<?php
include('./../../config/config.php');
include(RACINE.'/include/class_photos.php');

//Recuperation du dossier de la categorie
$dossier = $_POST['dossier'];



$DESTINATION_FOLDER = '../../photos/'.$dossier.'/';
//$DESTINATION_FOLDER = '../../photos/aaa/'.$dossier.'/';
$MAX_SIZE = 2000000;
$RETURN_LINK = $_SERVER['HTTP_REFERER'];					
$AUTH_EXT = array(".jpg", ".jpeg", ".JPG", ".JPEG");	

function isExtAuthorized($ext){
	global $AUTH_EXT;
	if(in_array($ext, $AUTH_EXT)){
		return true;
	}else{
		return false;
	}
}

$msg = "";
$ok = false;
$extension = strrchr($_FILES["file"]["name"], ".");
	
if(!empty($_FILES["file"]["name"])){

	if ( $extension == ".zip" || $extension == ".ZIP" ) {
		$zip = new ZipArchive;
		if ($zip->open($_FILES["file"]["tmp_name"]) === false) {
			$msg = "Impossible d'ouvrir l'archive .zip";
		}else{
			$error = false;
			for($i = 0; $i < $zip->numFiles; $i++) { 
				$nomFichier = $zip->getNameIndex($i);				
				$extension = strrchr($nomFichier, ".");
				if(!isExtAuthorized($extension)){		
					$error = true;
				}else{				
					$infoFichier = pathinfo($nomFichier);
					$destination_folder_tmp = substr($DESTINATION_FOLDER, 0, -1);
					if (!file_exists($destination_folder_tmp)) mkdir($destination_folder_tmp);
					$res = $zip->extractTo($destination_folder_tmp, array($nomFichier)); 
					if (!$res){		
						$error = true;						
					}else{
						$oPhotos = new photos;
						$stringAl = generatePWD();
						$nomFichier_clean = substr($nomFichier, 0 , strpos($nomFichier, "."));
						//$oPhotos->nomPhotoServ = "photo-" . $stringAl . ".jpg";
						$oPhotos->nomPhotoServ = "photo_" . $nomFichier_clean . "_" . $stringAl . ".jpg";
						
						$cheminPhoto = $DESTINATION_FOLDER.$oPhotos->nomPhotoServ;
						rename($DESTINATION_FOLDER.$nomFichier, $cheminPhoto);
						
						// Redimensionnement de la photo si necessaire
						$oPhotos -> redimPhoto($cheminPhoto,$DESTINATION_FOLDER);		
						
						// Creation de la vignette
						$oPhotos -> setMini($cheminPhoto,$DESTINATION_FOLDER);

						// Recuperation largeur et hauteur de l'image source
						$photo=imagecreatefromjpeg($cheminPhoto);
						$largeur = imagesx($photo); 
						$hauteur = imagesy($photo);	
						$ok = true;
						$msg = "L'upload des images a r&eacute;ussi";
					}
				}
			}			
			$zip->close();
			if ($error) $msg = "Au moins une image n'a pas pu être uploadée.";
		}
	}else{	
	
		$nomFichier = $_FILES["file"]["name"];
		$nomTemporaire = $_FILES["file"]["tmp_name"] ;
		$typeFichier = $_FILES["file"]["type"] ;
		$poidsFichier = $_FILES["file"]["size"] ;
		$codeErreur = $_FILES["file"]["error"] ;
		$extension = strrchr($nomFichier, ".");

		if($poidsFichier <> 0){
			if($poidsFichier < $MAX_SIZE){
				if(isExtAuthorized($extension)){			
					$oPhotos = new photos;
				
					$stringAl = generatePWD();
					$oPhotos->nomPhotoServ = "photo-".$stringAl.".jpg";
					$cheminPhoto = $DESTINATION_FOLDER.$oPhotos->nomPhotoServ;
					// Upload de la photo en taille normal
					if (!file_exists($DESTINATION_FOLDER)) mkdir($DESTINATION_FOLDER);
					$uploadOk = move_uploaded_file($nomTemporaire, $cheminPhoto);
					if($uploadOk){
						// Redimensionnement de la photo si necessaire
						$oPhotos -> redimPhoto($cheminPhoto,$DESTINATION_FOLDER);		
						
						// Creation de la vignette
						$oPhotos -> setMini($cheminPhoto,$DESTINATION_FOLDER);

						// Recuperation largeur et hauteur de l'image source
						$photo=imagecreatefromjpeg($cheminPhoto);
						$largeur = imagesx($photo); 
						$hauteur = imagesy($photo);
						$ok = true;
						$msg = "L'upload de l'image a r&eacute;ussi";
					}else{
						$msg = "Erreur : l'upload a &eacute;chou&eacute;";
					}
				}else{
						$msg = "Erreur : l'extension du fichier est invalide<br/>
							Les extensions autoris&eacute;es sont : .jpg et .jpeg";
				}
			}else{
				$tailleKo = $MAX_SIZE / 1000;
				$msg = "Erreur : vous ne pouvez pas uploader de fichiers dont la taille est supérieure à : " . $tailleKo . "Ko";
			}		
		}else{
			$msg = "Erreur : le fichier choisi est invalide";
		}
	}
}else{
	$msg = "Erreur : vous n'avez pas choisi de fichier";
}

if ($ok) {
	?>
		<div class="d_global" id="d_globalOk">
		<br/><br/>
		<br/><br/>
			<div class="d_okUpload"><?php echo $msg; ?></div>
		<br/><br/><br/>
		<input type="button" id="id_close" onClick="javascript:window.close(); window.opener.location.reload(true)" value="&nbsp;Fermer&nbsp;"> 
		</div>

	<?php
}else{
	?>
	<div class="d_global" id="d_globalErr">
		<br/><br/>
		<br/><br/>	
		<div class="d_errUpload"><?php echo $msg; ?></div>
		<br/><br/><br/>
		<input type="button" id="id_close" onClick="javascript:window.close(); window.opener.location.reload(true)" value="&nbsp;Fermer&nbsp;"> 
	</div>
	<?php

}
?>