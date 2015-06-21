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

include('include/session.php');
include('include/common.php');
include('include/login_aff.php');
include('include/class_navigation.php');
include('include/class_photoWeek.php');
    
if (TYPE_ENV == 'prod') {
    error_reporting(0);
}
else {
    //error_reporting(E_ALL);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}

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