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

$oForumMsg = new ForumMsg();

$user_id = $_SESSION['user_id'];

?>

<div id="d_sous_menu">	
	<ul>
        <li><a href="index.php?page=forum_liste" title="Acc&egrave;s &agrave; la liste des messages">
			Liste des discussions</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li>
		<li><i>Nouvelle discussion</i></li> 
    </ul> 
</div>
	
<br/>
<div id="d_aff_infos">
	<?php $oForumMsg -> affFormSujet($user_id); ?>
</div>