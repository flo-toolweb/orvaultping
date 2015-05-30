<?php
header('Content-Type: text/html; charset=iso-8859-1');

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Operations sur la photo du jour (  upload - ajout - modif ) *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../../config/config.php');

include(RACINE.'/include/session.php');

$req = $_POST['TypeReq'];


if ( $req == 'add' ) {

	// Ajout des antislashs
	$desc = addslashes($_POST['desc']);
	$file= addslashes($_POST['file']);

	// Conversion en Iso 
	$desc= mb_convert_encoding($desc, "iso-8859-1", "UTF-8");
	
	include(RACINE.'/admin/include/upload.php');
	

} // end if add

?>