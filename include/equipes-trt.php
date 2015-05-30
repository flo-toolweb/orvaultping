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

include(RACINE.'/include/class_equipes.php');
include(RACINE.'/include/class_users.php');

$req = $_POST['TypeReq'];

if ( $req == 'aff' ) {

	$idEquipe = $_POST['id_equipe'];
	$adulte = $_POST['adulte'];
	$feminine = $_POST['feminine'];
	$veteran = $_POST['veteran'];
	
	// creation des objets
	$oEquipes = new Equipes();
	
	//Affichage des infos de l'equipe
	$oEquipes->affEquipe($idEquipe, $adulte, $feminine, $veteran);
	
} // end if aff
?>