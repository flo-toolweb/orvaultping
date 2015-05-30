<?php
header('Content-Type: text/html; charset=iso-8859-1');

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Operations sur les News (  ajout - modif ) *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../config/config.php');

include(RACINE.'/include/class_photos.php');
include(RACINE.'/include/class_photosCategory.php');
include(RACINE.'/include/session.php');

$req = $_POST['TypeReq'];
$saison = $_POST['saison'];

if ( $req == 'aff' ) {

	$oPhotosCategory = new PhotosCategory("./photos");
	$oPhotosCategory -> affListCategoryUser($saison);
	
} // end if aff
?>