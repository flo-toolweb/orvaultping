<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Fichier d'acces principal *
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

@session_start();

//error_reporting(E_ALL);
include('include/session.php');
include('include/common.php');
include('include/login_aff.php');
include('include/class_navigation.php');
include('include/class_photoWeek.php');

// Chemin du theme choisi
$theme = CHEMIN.'/themes/'.THEME.'/';

// Recuperation de la page demandee
$getPage = "home";
if ( isset($_GET['page']) ) {
	$getPage = htmlentities($_GET['page']);
}
// Appel de la page demandee
$oNavigation = new Navigation(THEME,$getPage,"users");
$typePage = $oNavigation -> getTypePage();
include($theme.$typePage.'/template.php');

?>
<?

?>