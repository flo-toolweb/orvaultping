<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Contenu de la page forum - modification du sujet d'une discussion*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('include/class_forum.php');
include('include/class_forumMsg.php');

$oForumMsg = new ForumMsg();

$user_id = $_SESSION['user_id'];

if ( isset($_GET['id_msg'])) {
	$msg_id = $_GET['id_msg'];
}else{
	header('Location: index.php?page=forum_liste.php');
	exit;
}
?>

<div id="d_sous_menu">	
	<ul>
        <li><a href="index.php?page=forum_liste" title="Acc&egrave;s &agrave; la liste des messages">
			Liste des discussions</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li>
		<li><a href="index.php?page=forum_new_msg" title="Cr&eacute;er un nouveau sujet">
			Nouvelle discussion</a></li> 
    </ul> 
</div>
	
<br/>
<div id="d_aff_infos">
	<?php $oForumMsg -> affFormModifSujet($msg_id); ?>
</div>