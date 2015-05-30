<?php
header('Content-Type: text/html; charset=iso-8859-1');

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Operations sur les News (  ajout - modif ) *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../../config/config.php');

include(RACINE.'/include/class_photos.php');
include(RACINE.'/include/class_photosCategory.php');
include(RACINE.'/include/session.php');

$req = $_POST['TypeReq'];

if ( $req == 'suppr' ) {

	$idCat = $_POST['id_cat'];
	$dossier = $_POST['dossier'];
	$nom = $_POST['nom'];
	
	//Suppression de la photo
	$oPhotos = new Photos($idCat);
	$tPhotos = $oPhotos->deletePhoto($dossier, $nom);
	//recuperation infos sur la categorie
	$oPhotosCategory = new PhotosCategory("./photos");
	$tCat = $oPhotosCategory->GetCategory($idCat);
	
	?>
	<span id="s_erreur">
		Photo supprim&eacute;e<br/>
	</span>	
	<?php
	$oPhotos->affList($tCat);
} // end if suppr
?>