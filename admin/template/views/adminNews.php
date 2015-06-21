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

<script src="/js/lib/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#id_contenu",
    menu : { // this is the complete default configuration
        file   : {title : 'File'  , items : 'newdocument'},
        edit   : {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall searchreplace'},
        /*insert : {title : 'Insert', items : 'link media | template hr'},*/
        /*view   : {title : 'View'  , items : 'visualaid'},*/
        format : {title : 'Format', items : 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
        /*table  : {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},*/
        /*tools  : {title : 'Tools' , items : 'spellchecker code'}*/
    },
    toolbar: [
        "removeformat styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent",
        "undo redo | image jbimages media | link  unlink | table | hr | spellchecker | code preview fullscreen"
    ],
    plugins: [
        "advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker",
         "searchreplace visualblocks visualchars code fullscreen",
         "save table contextmenu emoticons paste textcolor jbimages"
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
