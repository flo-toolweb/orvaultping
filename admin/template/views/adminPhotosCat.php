<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Affichage de l'administration des  categories des Photos *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
$oPhotosCategory = new PhotosCategory("./photos");
?>


<div id="d_haut">
	<div id="d_infoUser">
	</div>
	<!-- Fin div infoUser -->
	
	<div id="d_formulaires">
		<div id="d_ajout">
			<?php $oPhotosCategory->affAjoutCategory(); ?>
		</div>
		<div id="d_modif">
		</div>
	</div>

</div>
<!-- Fin div haut -->
<div id="d_bas">
	<div id="d_list">
		<?php $oPhotosCategory->affListCategory($oPhotosCategory -> saisonEnCours); ?>
	</div>
	<!-- Fin div NewsList -->
</div>
<!-- Fin div bas -->