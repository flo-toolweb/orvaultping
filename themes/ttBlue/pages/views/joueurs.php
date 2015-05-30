<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Contenu de la page joueur*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
include('include/class_users.php');

$oUsers = new users();

?>

<div id="d_sous_menu">
    <ul>
        <li><i>Liste des joueurs</i>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; </li>
        <li><a href="./files/class_indiv.pdf"target="_blank" title="Tableaux des progressions - fichier pdf">
			Tableaux des progressions</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li> 
        <li><a href="http://www.fftt.com/sportif/pclassement/php3/FFTTlj.php3?session=reqid%3D311%26precision%3D04440141"target="_blank" title="Lien FFTT vers la liste des joueurs du club - Femmes">
			Liste FFTT - Femmes</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li> 
        <li><a href="http://www.fftt.com/sportif/pclassement/php3/FFTTlj.php3?session=reqid%3D211%26precision%3D04440141" target="_blank" title="Lien FFTT vers la liste des joueurs du club - Hommes">
			Liste FFTT - Hommes</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li> 
        <li><a href="index.php?page=joueurs_top5" title="Top 5 des meilleurs progressions par phase">Top 5</a></li> 
    </ul> 
</div>

<div id="d_intro">
	Vous pouvez accéder aux résultats individuels des joueurs/joueuses du club en vous rendant sur les liens "Liste FFTT" correspondant.<br/>
	Si vous êtes connectés, vous avez également accès à la fiche personnelle de chaque membre en cliquant sur son nom.
</div>
<br/>
<div id="d_liste">
	<?php 
		if ( isset($_GET['tri']) ) {
			$tri = $_GET['tri'];
		} else {
			$tri = 'nom';
		}
		$oUsers -> affList($tri); 
	?>
</div><br/>
	