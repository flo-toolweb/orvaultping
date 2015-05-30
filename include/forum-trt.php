<?php
header('Content-Type: text/html; charset=iso-8859-1');

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Operations sur le forum(  ajout messages  -  reponses ) *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../config/config.php');

include(RACINE.'/include/class_forumMsg.php');
include(RACINE.'/include/class_forumRep.php');

$req = $_POST['TypeReq'];

if ( $req == 'newMsg' ) {

	$id_user = $_POST['user_id'];
	
	$oForumMsg = new forumMsg();
	
	// Ajout des antislashs
	$sujet = addslashes($_POST['sujet']);
	$message = addslashes($_POST['msg']);
	// prise en compte des retour chariot
	$message = nl2br($message);
	// Postit
	$postit = 0;
	if ( isset($_POST['postit'])){
		$postit = 1;
	}
	
	$auteur = $id_user;
	$date = date("Y-m-d H:i:s");
	
	// Ajout du message dans la bdd
	$oForumMsg -> add($sujet, $message, $auteur, $date, 0, $postit);
	
	header("Location: ../index.php?page=forum_liste&msg=newMsg");
	exit;
}
if ( $req == 'modifMsg' ) {

	$id_msg = $_POST['msg_id'];
	
	$oForumMsg = new forumMsg();
	
	// Ajout des antislashs
	$sujet = addslashes($_POST['sujet']);
	$message = addslashes($_POST['msg']);
	// prise en compte des retour chariot
	$message = nl2br($message);
	// Postit
	$postit = 0;
	if ( isset($_POST['postit'])){
		$postit = 1;
	}
		
	// Ajout du message dans la bdd
	$oForumMsg -> update($id_msg, $sujet, $message, $postit);
	
	header("Location: ../index.php?page=forum_liste&msg=modifMsg");
	exit;
}
if ( $req == 'modifRep' ) {

	$id_rep = $_POST['rep_id'];
	$id_msg = $_POST['msg_id'];
	
	$oForumRep = new forumRep($id_msg);
	
	// Ajout des antislashs
	$message = addslashes($_POST['msg']);
	// prise en compte des retour chariot
	$message = nl2br($message);
		
	// Ajout du message dans la bdd
	$oForumRep -> update($id_rep, $message);
	
	header("Location: ../index.php?page=forum_msg&id_msg=".$id_msg."&msg=modifRep");
	exit;
}
if ( $req == 'newRep' ) {

	$id_user = $_POST['user_id'];
	$id_msg = $_POST['msg_id'];
	
	$oForumRep = new forumRep($id_msg);
	
	// Ajout des antislashs
	$message = addslashes($_POST['msg']);
	
	// prise en compte des retour chariot
	$message = nl2br($message);
	
	$auteur = $id_user;
	$date = date("Y-m-d H:i:s");
	
	// Ajout du message dans la bdd
	$oForumRep -> add($message, $auteur, $id_msg, $date);
	// Mise a jour dateDerRep
	$oForumMsg = new forumMsg();
	$oForumMsg -> updateNewRep($id_msg, $auteur, $date);
	
	header("Location: ../index.php?page=forum_msg&msg=newRep&id_msg=".$id_msg."");
	exit;
}
?>