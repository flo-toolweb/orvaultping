<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Contenu de la page forum - accueil du forum*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('include/class_forum.php');
include('include/class_forumMsg.php');
include('include/class_forumRep.php');
include('include/class_users.php');

$oForum = new forum();
$oForumMsg = new forumMsg();

$user_id = $_SESSION['user_id'];
if ( isset($_GET['id_msg'])) {
	$msg_id = $_GET['id_msg'];
}else{
	header('Location: index.php?page=forum_liste.php');
	exit;
}

$oForumRep = new forumRep($msg_id);

$oForumMsg -> updateVue($msg_id);

?>

<div id="d_sous_menu">	
	<ul>
        <li><a href="index.php?page=forum_liste" title="Acc&egrave;s &agrave; la liste des messages">
			Liste des discussions</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li>
		<li><a href="index.php?page=forum_new_msg" title="Cr&eacute;er un nouveau sujet">
			Nouvelle discussion</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li> 
		<li><a href="#repondre" title="R&eacute;pondre &agrave; ce message">
			Participez &agrave cette discussion</a></li> 
    </ul> 	
</div>
<div id="d_aff_msg">
	<?php if ( isset($_GET['msg']) && $_GET['msg'] === "newRep" ) { ?>
		<div class="d_msgRep">
			Nouveau message ajout&eacute;
		</div>
	<?php
	} ?>
	<?php if ( isset($_GET['msg']) && $_GET['msg'] === "modifRep" ) { ?>
		<div class="d_msgRep">
			Votre message a bien &eacute;t&eacute; modifi&eacute;
		</div>
	<?php
	} ?>

	<?php $oForumMsg -> affDiscussion($msg_id, $user_id); ?>
	
	
</div>
<br/>
<br/>
<a name="repondre"></a>
<div id="d_aff_rep">
	<?php 
		$oForumRep -> affFormRep($user_id,$msg_id); ?>
</div>

	