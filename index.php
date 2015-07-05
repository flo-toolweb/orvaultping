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

// Chemin du theme choisi
$theme = CHEMIN.'/themes/'.THEME.'/';

// Recuperation de la page demandee
//$getPage = "home";
$getPage = "news";
if ( isset($_GET['page']) ) {
	$getPage = htmlentities($_GET['page']);
    if ($getPage == 'home') {
        $getPage = 'news';
    }
}
// Appel de la page demandee
$oNavigation = new Navigation(THEME,$getPage,"users");
$typePage = $oNavigation -> getTypePage();
include($theme.$typePage.'/template.php');

?>