<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Template de le page d'accueil*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('include/class_photosCategory.php');
include('include/class_photos.php');

$oPhotosCategory = new PhotosCategory("./photos");
if (isset($_GET['saison'])) { 
	$saison = $_GET['saison'];
}else{
	$saison = $oPhotosCategory -> saisonEnCours;
}
?>

<div id="d_sous_menu">
	<ul> 
        <li><i>Les photos</i>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li>
        <li><a href="http://www.dailymotion.com/orvaultping" title="Le compte dailymotion du club" target="_blank">
			Les vidéos  ( dailymotion )</a></li> 
    </ul> 
</div>
<div id="d_haut">
	<div id="d_selectSaison">
		<select id="select_saison" onchange="window.location.href='index.php?page=medias&saison='+this.value">
			<?php echo getSaisonsOptions($saison, "2008") ?>
		</select> 
	</div>
	<div id="d_catTitre">Choisissez une cat&eacute;gorie</div>
	<div id="d_carousel">
		<ul id="slider1" class="multiple">
	<?php 
		$oPhotosCategory -> affListCategoryUser($saison);
	?>
		</ul>
	</div>
</div>
<div id="d_bas">
	<div id="d_miniatures">
		<div id="d_minTitre"></div>
	</div>
</div>

<!-- Fin div photos -->
	