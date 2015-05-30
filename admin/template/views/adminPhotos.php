<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Affichage de l'administration des  Photos *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

$idCat = $_GET['cat'];
$oPhotos = new Photos($idCat);

//recuperation infos sur la categorie
$oPhotosCategory = new PhotosCategory("./photos");
$tCat = $oPhotosCategory->GetCategory($idCat);
		


?>


<div id="d_haut">
	<div id="d_infoUser">
	</div>
	<!-- Fin div infoUser -->
	
	<div id="d_formulaires">
		<div id="d_ajout">
			<?php $oPhotos->affAjout(); ?>
		</div>
	</div>

</div>
<!-- Fin div haut -->
<div id="d_bas">
	<div id="d_list">
		<?php $oPhotos->affList($tCat); ?>
	</div>
	<!-- Fin div List -->
</div>
<!-- Fin div bas -->