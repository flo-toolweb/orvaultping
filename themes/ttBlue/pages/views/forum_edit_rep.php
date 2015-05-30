<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Contenu de la page forum - modification d'une reponse dans une discussion*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('include/class_forum.php');
include('include/class_forumRep.php');


$user_id = $_SESSION['user_id'];

if ( isset($_GET['id_msg'])) {
	$msg_id = $_GET['id_msg'];
}else{
	header('Location: index.php?page=forum_liste.php');
	exit;
}
if ( isset($_GET['id_rep'])) {
	$rep_id = $_GET['id_rep'];
}else{
	header('Location: index.php?page=forum_liste.php');
	exit;
}

$oForumRep = new ForumRep($msg_id);
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
	<?php $oForumRep -> affFormModifRep($msg_id, $rep_id); ?>
</div>