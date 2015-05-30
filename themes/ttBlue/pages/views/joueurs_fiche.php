<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Contenu de la page de la fche du joueur*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('include/class_users.php');

$oUsers = new users();

if ( isset($_GET['id_user'])) {
	$user_id = $_GET['id_user'];
}else{
	header('Location: index.php?page=joueurs.php');
	exit;
}

?>

<div id="d_sous_menu">
	<ul> 
        <li><a href="index.php?page=joueurs" title="Liste des joueurs du club">
			Liste des joueurs</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li>
        <li><a href="./files/class_indiv.pdf"target="_blank" title="Tableaux des progressions - fichier pdf">
			Tableaux des progressions</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li> 
        <li><a href="http://www.fftt.com/sportif/pclassement/php3/FFTTlj.php3?session=reqid%3D311%26precision%3D04440141"target="_blank" title="Lien FFTT vers la liste des joueurs du club - Femmes">
			Liste FFTT - Femmes</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li> 
        <li><a href="http://www.fftt.com/sportif/pclassement/php3/FFTTlj.php3?session=reqid%3D211%26precision%3D04440141" target="_blank" title="Lien FFTT vers la liste des joueurs du club - Hommes">
			Liste FFTT - Hommes</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li> 
        <li><a href="index.php?page=joueurs_top5" title="Top 5 des meilleurs progressions par phase">Top 5</a></li> 
    </ul> 
</div>

<div id="d_aff_infos_ext">	
	<div id="d_aff_infos">
		<?php $oUsers -> affInfosFiche($user_id); ?>
	</div>
</div>
<br/>