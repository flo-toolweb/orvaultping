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
include('include/class_users.php');

$oForumMsg = new forumMsg();
$user_id = $_SESSION['user_id'];

/* Suppression d'une discussion */
if ( isset($_GET['delete_msg']))
	$oForumMsg -> deleteMsg($_GET['delete_msg']);


?>

<div id="d_sous_menu">
	<ul>
        <li><i>Liste des discussions</i>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; </li>
		<li><a href="index.php?page=forum_new_msg" title="Cr&eacute;er un nouveau sujet">
			Nouvelle discussion</a></li> 
    </ul> 
</div>
<div id="d_liste">
	<?php if ( isset($_GET['msg']) && $_GET['msg'] === "newMsg" ) { ?>
		<div class="d_msgRep">
			Nouvelle discussion cr&eacute;&eacute;e
		</div>
	<?php
	} ?>
	<?php if ( isset($_GET['msg']) && $_GET['msg'] === "modifMsg" ) { ?>
		<div class="d_msgRep">
			Discussion modifi&eacute;e
		</div>
	<?php
	} ?>
	<?php if ( isset($_GET['delete_msg'])) { ?>
		<div class="d_msgRep d_msgDelete">
			Discussion supprim&eacute;e
		</div>
	<?php
	} ?>
	<?php $oForumMsg -> affList($user_id); ?>
</div><br/>
	