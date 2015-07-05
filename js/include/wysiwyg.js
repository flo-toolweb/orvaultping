/*
 * Gestion de TinyMCE
*/

function initWysiwyg(elemId)
{
	tinymce.init({
		mode: "none",
	    selector: "#" + elemId,
	    language : 'fr_FR',
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
	   	content_css : "/themes/ttBlue/pages/wysiwyg.css",
		style_formats: [
		    {title: 'Paragraphe', inline: 'p'},
			{title: 'Titre 1', format: 'h1'},
			{title: 'Titre 2', block: 'h2'},
			{title: 'Titre 3', block: 'h3'},
			{title: 'Note', selector: 'p', classes: 'note'},
			{title: 'Important', selector: 'p', classes: 'important'}
			// {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			//{title: 'Example 1', inline: 'span', classes: 'example1'},
	    ],
	    statusbar: true
	 });
}