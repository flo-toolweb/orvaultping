<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Fichier d'acces a l'espace Admin *
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

@session_start();

//error_reporting(E_ALL);
include('include/session.php');
include('include/common.php');
include('include/login_aff.php');
include('include/class_maj.php');
include('include/class_navigation.php');
include('include/class_news.php');
include('include/class_photos.php');
include('include/class_photosCategory.php');
include('include/class_photoWeek.php');
include('include/class_users.php');

// Recuperation de la page demandee
$getPage = "adminHome";
if ( isset($_GET['page']) ) {
	$getPage = htmlentities($_GET['page']);
}
$getErreur = "none";
if ( isset($_GET['err']) ) {
	$getErreur = htmlentities($_GET['err']);
}
// Appel de la page demandee
$oNavigation = new Navigation(THEME,$getPage,$getErreur,"admin");

include('admin/template/template.php');

?>


