<?php
include('./../../config/config.php');
include(RACINE.'/include/class_photoWeek.php');

$DESTINATION_FOLDER = '../../photos/photoWeek/';
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

if(!empty($_FILES["file"]["name"])){
	$nomFichier = $_FILES["file"]["name"] ;
	$nomTemporaire = $_FILES["file"]["tmp_name"] ;
	$typeFichier = $_FILES["file"]["type"] ;
	$poidsFichier = $_FILES["file"]["size"] ;
	$codeErreur = $_FILES["file"]["error"] ;
	$extension = strrchr($nomFichier, ".");
	
	
	if($poidsFichier <> 0){
		// Verification poids photo
		if($poidsFichier < $MAX_SIZE){
			// Verification extension photo
			if(isExtAuthorized($extension)){
				$oPhotoWeek = new photoWeek($DESTINATION_FOLDER);
				$stringAl = generatePWD();
				$oPhotoWeek->nomPhotoServ = "photoWeek-".$stringAl.".jpg";
				$cheminPhoto = $DESTINATION_FOLDER.$oPhotoWeek->nomPhotoServ;
				// Upload de la photo en taille normal
				$uploadOk = move_uploaded_file($nomTemporaire, $cheminPhoto);
				// Verification upload reussi
				if($uploadOk){
					// Suppression de l'ancienne photo du jour
					$tphotoWeek = $oPhotoWeek->GetPhotoWeek();
					if ( $tphotoWeek['photoWeek_nom'] != "" ) {
						unlink($DESTINATION_FOLDER.$tphotoWeek['photoWeek_nom']);
						unlink($DESTINATION_FOLDER."mini/".$tphotoWeek['photoWeek_nomMini']);
					}
					
					// Redimensionnement de la photo si necessaire
					$oPhotoWeek -> redimPhoto($cheminPhoto,$DESTINATION_FOLDER);					
					
					// Creation de la vignette
					$oPhotoWeek -> setMini($cheminPhoto);
					
					// Modification Base de donnees
					$description = addslashes($_POST['desc']);
					$nomPhoto = addslashes($oPhotoWeek->nomPhotoServ);
					$nomMini = addslashes("mini_".$oPhotoWeek->nomPhotoServ);
					// Recuparation largeur et hauteur de l'image source
					$photo=imagecreatefromjpeg($cheminPhoto);
					$largeur = imagesx($photo); 
					$hauteur = imagesy($photo);
					
					
					// Verification que la table n'est pas vide
					if ( tableIsEmpty($oPhotoWeek->tablePhotoWeek) ) {
						//Insertion d'une nouvelle ligne
					}else{
						//Modification de la ligne 
						$oPhotoWeek->updatePhotoWeek($description,$nomPhoto,$nomMini,$poidsFichier,$largeur,$hauteur);
					}
				?>
					<div class="d_global" id="d_globalOk">
					<br/><br/>
					<br/><br/>
						<div class="d_okUpload">
							L'upload de la photo a r&eacute;ussi
						</div>
					<br/><br/><br/>
					<input type="button" id="id_close" onClick="javascript:window.close(); window.opener.location.reload(true)" value="&nbsp;Fermer&nbsp;"> 
					</div>

				<?php
				}else{
				?>
				<div class="d_global" id="d_globalErr">
					<br/><br/>
					<br/><br/>
					<div class="d_errUpload">
						Erreur : l'upload a &eacute;chou&eacute;
					</div>
					<br/><br/><br/>
					<input type="button" id="id_close" onClick="javascript:window.close(); window.opener.location.reload(true)" value="&nbsp;Fermer&nbsp;"> 
				</div>
				<?php
				}
			}else{
				?>
				<div class="d_global" id="d_globalErr">
					<br/><br/>
					<br/><br/>
					<div class="d_errUpload">
						Erreur : l'extension du fichier est invalide<br/>
						Les extensions autoris&eacute;es sont : .jpg et .jpeg
					</div>
					<br/><br/><br/>
					<input type="button" id="id_close" onClick="javascript:window.close(); window.opener.location.reload(true)" value="&nbsp;Fermer&nbsp;"> 
				</div>
				<?php
			}
		}else{
			$tailleKo = $MAX_SIZE / 1000;
			?>

				<div class="d_global" id="d_globalErr">
					<br/><br/>
					<br/><br/>
				<div class="d_errUpload">
					Erreur : vous ne pouvez pas uploader de fichiers dont la taille est supérieure à : <?php echo $tailleKo; ?>Ko
				</div>
					<br/><br/><br/>
					<input type="button" id="id_close" onClick="javascript:window.close(); window.opener.location.reload(true)" value="&nbsp;Fermer&nbsp;"> 
				</div>
			<?php
		}		
	}else{
	?>
			<div class="d_global" id="d_globalErr">
			<br/><br/>
			<br/><br/>		
				<div class="d_errUpload">
					Erreur : le fichier choisi est invalide
				</div>
			<br/><br/><br/>
			<input type="button" id="id_close" onClick="javascript:window.close(); window.opener.location.reload(true)" value="&nbsp;Fermer&nbsp;"> 
			</div>

	<?php
	}
}else{
	?>
		<div class="d_global" id="d_globalErr">
			<br/><br/>
			<br/><br/>	
			<div class="d_errUpload">
				Erreur : vous n'avez pas choisi de fichier
			</div>
			<br/><br/><br/>
			<input type="button" id="id_close" onClick="javascript:window.close(); window.opener.location.reload(true)" value="&nbsp;Fermer&nbsp;"> 
			</div>
	<?php
}
?>