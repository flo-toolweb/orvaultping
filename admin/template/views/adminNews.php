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
		<div id="d_ajout">
			<?php $oNews->affAjoutNews(); ?>
		</div>
		<div id="d_modif">
		</div>
	</div>

</div>
<!-- Fin div droite -->
<div id="d_bas">
	<div id="d_list">
		<?php $oNews->affListNews(); ?>
	</div>
	<!-- Fin div NewsList -->
</div>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#id_contenu",
    toolbar: [
        "undo redo spellchecker | styleselect | bold italic | link image | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent"
    ],
    plugins: [
        "advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker",
         "searchreplace visualblocks visualchars code fullscreen",
         "save table contextmenu directionality emoticons paste textcolor"
   ],
    style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
    ],
    statusbar: true
 });
</script>
