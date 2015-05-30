<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe photos *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================


	
if (!defined('COMMON') ) { 
	include('common.php'); 
}
class Photos
{

	/**
	* Catégorie des photos
	*
	* @var string
	*/
	var $catPhotos = ""; 
	/**
	* Nom de la photo taille normal
	*
	* @var string
	*/
	var $nomPhotoServ = ""; 
	/**
	* TRUE si la liste des news a ete construite, FALSE sinon
	*
	* @var boolean
	*/
	var $listIsBuilt = FALSE;	
	/**
	* largeur max des photos
	*
	* @var int
	*/
	var $largeurMax = 1250; 
	/**
	* hauteur max des photos
	*
	* @var int
	*/
	var $hauteurMax = 900; 	
	/**
	* largeur des vignettes
	*
	* @var int
	*/
	var $largeur = 130; 
	/**
	* hauteur des vignettes
	*
	* @var int
	*/
	var $hauteur = 110; 
	/**
	* Chemin absolu vers le repertoire contenant les photos
	*
	* @var string
	*/
	var $dir = ""; 	
	/**
	* Liste des categories
	*
	* @var array
	*/
	var $categoryList = array(); 
	
	function Photos($cat=0)
	{
		$this->catPhotos = $cat;
	} 
	
	/**
	* Cree la miniature de la photo
	*
	* @return void
	*/	
	function setMini($srcPhoto,$dir)
	{
		//$largeur = $this->largeur;
		$hauteur = $this->hauteur;
		// Recuperation de l'image a taille normal
		$src=imagecreatefromjpeg($srcPhoto);
		// Recuperation de la taille de l'iamge
		$taille=getimagesize($srcPhoto);
		// Creation de la vignette vide a sa taille
		$img=imagecreatetruecolor(round(($hauteur/$taille[1])*$taille[0]),$hauteur);
		//$img=imagecreate($largeur,round(($largeur/$taille[0])*$taille[1])); 
		// Copie de l'image source a la taille de la vignette
		imagecopyresampled($img,$src,0,0,0,0,
                                      //$largeur,round(($largeur/$taille[0])*$taille[1]),$taille[0],$taille[1]);
									  round(($hauteur/$taille[1])*$taille[0]),$hauteur,$taille[0],$taille[1]);
		
		// Sauvegarde de la vignette sur le serveur
		if (!file_exists($dir."mini/")) mkdir($dir."mini/");
		imagejpeg($img, $dir."mini/".$this->nomPhotoServ);
	}	
	/**
	* Redimensionne la photo si necessaire
	*
	* @return void
	*/	
	function redimPhoto($srcPhoto,$dir)
	{
		$largeurMax = $this->largeurMax;
		$hauteurMax = $this->hauteurMax;
		// Recuperation de l'image a taille normal
		$src=imagecreatefromjpeg($srcPhoto);
		// Recuperation de la taille de l'image
		$taille=getimagesize($srcPhoto);
		$larg = $taille[0];
		$haut= $taille[1];
		if ( $larg > $largeurMax ) {
			// Creation de la nouvelle photo vide a sa taille
			$newHauteur = round(($largeurMax/$larg)*$haut);
			$img=imagecreatetruecolor($largeurMax,$newHauteur); 
			// Copie de l'image source a la taille de la vignette
			imagecopyresampled($img,$src,0,0,0,0,$largeurMax,$newHauteur,$larg,$haut);
			
			$larg = $largeurMax;
			$haut = $newHauteur;
			$src = $img;
			if ( $haut > $hauteurMax ) {
				// Creation de la nouvelle photo vide a sa taille
				$newLargeur = round(($hauteurMax/$haut)*$larg);
				$img=imagecreatetruecolor($newLargeur ,$hauteurMax);
				// Copie de l'image source a la taille de la vignette
				imagecopyresampled($img,$src,0,0,0,0,$newLargeur,$hauteurMax,$larg,$haut);
			}			
			
			// Sauvegarde de la nouvelle photo sur le serveur
			imagejpeg($img, $dir."/".$this->nomPhotoServ);
		}
		if ( $haut > $hauteurMax ) {
			// Creation de la nouvelle photo vide a sa taille
			$newLargeur = round(($hauteurMax/$haut)*$larg);
			$img=imagecreatetruecolor($newLargeur ,$hauteurMax);
			// Copie de l'image source a la taille de la vignette
			imagecopyresampled($img,$src,0,0,0,0,$newLargeur ,$hauteurMax,$larg,$haut);
			
			// Sauvegarde de la nouvelle photo sur le serveur
			imagejpeg($img, $dir."/".$this->nomPhotoServ);
		}	
	}
	
	
	/**
	* Supprime une photo
	*
	* @return void
	*/	
	function deletePhoto($dossier,$nomPhoto) {
		unlink(RACINE."/photos/".$dossier."/".$nomPhoto);
		unlink(RACINE."/photos/".$dossier."/mini/".$nomPhoto);
	}
	/**
	* Affiche la liste des photos d'une categorie (espace admin)
	*
	* @return void
	*/	
	function affList($tCat)
	{
		$dir = RACINE."/photos/".$tCat['photosCategory_dossier']."/mini/";
		if ($handle = opendir($dir)) {
			$cpt = 1;
			while (false !== ($photo = readdir($handle))) {
				if ($photo != "." && $photo != "..") {
					$dossier = $tCat['photosCategory_dossier'];
					$nom = $photo;
				?>
					<div class="s_min_photos">
						<a href="./photos/<?php echo $tCat['photosCategory_dossier']."/".$photo; ?> " target="_blank" title="Voir la photo">
							<img src="./photos/<?php echo $tCat['photosCategory_dossier']."/mini/".$photo;	?>"
							title="<?php echo "photo ".$cpt." de la cat&eacute;gorie ".$tCat['photosCategory_titre']; ?>"
							/>
						</a><br/>
						<a href="#" onClick="supprPhoto(<?php echo $tCat['photosCategory_id']; ?>,'<?php echo $dossier; ?>','<?php echo $nom; ?>')" 
						title="Supprimer cette photo">
							Supprimer
						</a>
					</div>
					
				<?php 
				$cpt++;
				}
			}
		}
	}
	/**
	* Affiche la liste des photos d'une categorie (espace user)
	*
	* @return void
	*/	
	function affListUser($tCat)
	{
		$dir = RACINE."/photos/".$tCat['photosCategory_dossier']."/mini/";
		if ($handle = opendir($dir)) {
			$cpt = 1;
			?>
			<div id="d_minTitre">
				<?php echo stripSlashes($tCat['photosCategory_titre']); ?>
				&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;
				<a href="<?php echo CHEMIN.'/themes/'.THEME.'/diaporama/diaporama.php?dossier='.$tCat['photosCategory_dossier']; ?>" target="_blank" alt="Afficher ses photos en diaporama">Voir le diaporama</a>
			</div>
			<div id="d_minDesc"><?php echo stripSlashes($tCat['photosCategory_description']); ?></div>
			<div id="d_minEx">
			<?php
			while (false !== ($photo = readdir($handle))) {
				if ($photo != "." && $photo != "..") {
					$dossier = $tCat['photosCategory_dossier'];
					$nom = $photo;
				?>
					<div class="s_min_photos">
						<a href="./photos/<?php echo $tCat['photosCategory_dossier']."/".$photo; ?> " target="_blank" title="Voir la photo">
							<img src="./photos/<?php echo $tCat['photosCategory_dossier']."/mini/".$photo;	?>"
							title="<?php echo "photo ".$cpt." de la cat&eacute;gorie ".$tCat['photosCategory_titre']; ?>"
							/>
						</a>
					</div>
					
				<?php 
				$cpt++;
				}
			}
			?>
			</div>
			<?php
		}
	}
		
	/**
	* Formulaire d'ajout d'une photo
	*
	* @return void
	*/	
	function affAjout()
	{
	
		//recuperation infos sur la categorie
		$oPhotosCategory = new PhotosCategory("./photos");
		$tCat = $oPhotosCategory->GetCategory($this->catPhotos);
	?>
			<form id="form_ajoutphoto" name="form_ajout_photo"  enctype="multipart/form-data" action="./admin/popup/affUpload.php" method="post">
				<fieldset>
					<legend>Ajouter une photo</legend>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_contenu">
								Photo :&nbsp;
							</label>
						</span>
						<span class="c_form_droite">       
							<input type="file" name="file" size="40">
						</span>
						</div><br/>
					<div class="d_row">
						<input type="hidden" id="dossier" name="dossier" value="<?php echo $tCat['photosCategory_dossier']; ?>">
						<input type="button" onClick="centrage_popup_form('admin/popup/popUpWait.php', 350, 200,'scrollbars=0, toolbar=0, titlebar=0, status=0, resizable=0',form_ajout_photo);" name="button" size="" value="Valider"> 
					</div>
		        </fieldset>
			</form>
	<?php	
	}	

}
?>