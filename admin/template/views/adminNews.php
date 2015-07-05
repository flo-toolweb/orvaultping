<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Affichage de l'administration des  News *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

$oNews = new News();
$listNews = $oNews->GetNewsList();
?>


<!-- Fin div gauche -->
<div id="d_haut">
	<div id="d_infoUser">
	
	</div>
	<!-- Fin div infoUser -->
	
	<div id="d_formulaires">
		<?php $oNews->affFormNews('add'); ?>
	</div>

</div>
<br/>
<!-- Fin div droite -->
<div id="d_bas">
	<div id="d_list">
		<?php $oNews->affListNews(); ?>
	</div>
	<!-- Fin div NewsList -->
</div>

<script type="text/javascript">
    initWysiwyg('id_contenu');
</script>
