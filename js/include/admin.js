/* 
 *** Popup ***
*/
function centrage_popup_form(page,largeur,hauteur,options,the_form){
	var top=(screen.height-hauteur)/2;
	var left=(screen.width-largeur)/2;
	my_form = eval(the_form);
	window.open(page,"popup","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+options);
	my_form.target = "popup";
	my_form.submit();
}
function centrage_popup(page,largeur,hauteur,options){
	var top=(screen.height-hauteur)/2;
	var left=(screen.width-largeur)/2;
	window.open(page,"popup","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+options);
}

/* 
 *** Gestion des News ***
*/

// Appel Ajax apres l'ajout d'une news par l'utilisateur
function addNews() {
	tinyMCE.triggerSave(true, true);
	
	var titre = document.getElementById("id_titre").value;	
	var contenu = document.getElementById("id_contenu").value;	
	var prenom = document.getElementById("id_prenom").value;
	
	document.getElementById("id_titre").value = "";
	document.getElementById("id_contenu").value = "";
		
	var options = { 
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
		parameters: {titre: titre, contenu: contenu, prenom: prenom, TypeReq: 'add'}
	} 
	var ajaxCall = new Ajax.Updater("d_list", "./admin/include/news-trt.php", options); 
}

// Appel Ajax pour afficher la news a modifier
function affNewsModif(id_news) {
	tinymce.remove();
	var options = {
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
		parameters: {id_news: id_news, TypeReq: 'affModif'},
		onComplete: function() {
   			initWysiwyg('id_contenu');
		}
	}
	var ajaxCall = new Ajax.Updater("d_formulaires", "./admin/include/news-trt.php", options);
}

function modifNews(id_news) { 

	if ( id_news != -1 ) {
		tinyMCE.triggerSave(true, true);
		
		var id_news = id_news;
		var titre = document.getElementById("id_titre").value;
		var contenu = document.getElementById("id_contenu").value;
		console.log('titre ' + titre);
		console.log('contenu ' + contenu);
		var options = { 
			encoding: 'iso-8859-1',
			evalScripts: true,
			method: "post",
			parameters: {id_news: id_news, titre: titre, contenu: contenu, TypeReq: 'modif'}
		} 
		var ajaxCall = new Ajax.Updater("d_list", "./admin/include/news-trt.php", options); 
	}
}

function supprNews(id_news) { 
	
	if (window.confirm('Voulez vous supprimer cette news ?')) {
		
		var id_news = id_news;

		var options = { 
			encoding: 'iso-8859-1',
			evalScripts: true,
			method: "post",
		parameters: {id_news: id_news, TypeReq: 'suppr'}
		} 
		var ajaxCall = new Ajax.Updater("d_list", "./admin/include/news-trt.php", options); 
	}
}
/* 
 *** Ajout des balises de mise en forme ***
*/
function addBalises(id, type) {
	// Verification du focus du textarea	?? 
	
	// Recuperation du texte du textarea
    var text_value = document.getElementById(id).value;
	// Recuperation de la position du curseur
    var position = getCursorPosition(id);
	// Recuperation de la position de la scrollbar
    var textarea = document.getElementById(id);  
    var scroll_position = textarea.scrollTop;
	
	// Selection de l'utilisateur si il y a 
	var select = getSelect(id);
	// Texte avant la balise
    var string_start = text_value.substring(0, position);
	// Texte apres la balise
    var string_end = text_value.substring(position+select.length);
	
	if ( type == "bold") {
		var text_balise = "[b]"+select+"[/b]";
	}else if ( type == "italic") {
		var text_balise = "[i]"+select+"[/i]";
	}
	// Nouveau texte du textarea
    document.getElementById(id).value = string_start + text_balise + string_end;
	// Positionnement du curseur apres la selection
    setCursorPosition(id, position + text_balise.length, position + text_balise.length);
	// Positionnement de la scrollbar
	textarea.scrollTop = scroll_position;
 } 

function getCursorPosition(id) {
    var textarea = document.getElementById(id);
	// firefox
    if (typeof textarea.selectionStart != 'undefined' )
       return textarea.selectionStart;
    // ie
    textarea.focus();
    var range = textarea.createTextRange();
    range.moveToBookmark(document.selection.createRange().getBookmark());
    range.moveEnd('character', textarea.value.length);
    return textarea.value.length - range.text.length; 
 }

/* Retourne la selection de l'utilisateur */
function getSelect(id) {
    var textarea = document.getElementById(id);
	if (textarea.setSelectionRange) // firefox
		return textarea.value.substring(textarea.selectionStart, textarea.selectionEnd);
	else if (document.selection) { // ie
		userSelection = document.selection.createRange();
		return (userSelection.text);
	}
}
  
function setCursorPosition(id, start, end) {
    var textarea = document.getElementById(id);
    end = end || start;
    textarea.focus();
    if (textarea.setSelectionRange) // firefox
		textarea.setSelectionRange(start, end); 
    else if (document.selection) { // ie
       var range = textarea.createTextRange();
       range.moveStart('character', start);
       range.moveEnd('character', - textarea.value.length + end);
       range.select();
    }
 }
/* 
 *** Ajout d'un lien dans le message ***
*/
function addLink(id) {	
	// Selection de l'utilisateur si il y a 
	var select = getSelect(id);
	// Recuperation de la position de la scrollbar
    var textarea = document.getElementById(id);  
    var scroll_position = textarea.scrollTop;
	// Recuperation du lien
	var link_url = prompt("Entrez l'adresse de la page","http://") ;
	if ( link_url == null ) 
		return false;
	// Recuperation du texte associe
	if ( select != "" ) {
		var link_text = prompt("Entrez le texte de votre lien",select);	
		if ( link_text == null ) 
			return false;
		// Formation de la balise
		if ( (link_text == link_url)) {
			var link_tag = "[lien]"+link_url+"[/lien]";		
		}else{
			var link_tag = "[lien="+link_url+"]"+link_text+"[/lien]";		
		}
		// Recuperation du texte du textarea
	    var text_value = document.getElementById(id).value;
		// Recuperation de la position du curseur
	    var position = getCursorPosition(id);
		// Texte avant la balise
	    var string_start = text_value.substring(0, position);
		// Texte apres la balise
	    var string_end = text_value.substring(position+select.length);
	}else{
		var link_text = prompt("Entrez le texte de votre lien",link_url);
		if ( link_text == null ) 
			return false;
		// Formation de la balise
		if ( link_url == link_text ) {
			var link_tag = "[lien]"+link_url+"[/lien]";		
		}else{
			var link_tag = "[lien="+link_url+"]"+link_text+"[/lien]";		
		}
		// Recuperation du texte du textarea
	    var text_value = document.getElementById(id).value;
		// Recuperation de la position du curseur
	    var position = getCursorPosition(id);
		// Texte avant le lien
	    var string_start = text_value.substring(0, position);
		// Texte apres le lien
	    var string_end = text_value.substring(position);
		}
	// Nouveau texte du textarea
	document.getElementById(id).value = string_start + link_tag + string_end;
	// Positionnement du curseur apres le lien
	setCursorPosition(id, position + link_tag.length, position + link_tag.length);
	// Positionnement de la scrollbar
	textarea.scrollTop = scroll_position;
}

/* 
 *** Gestion de la photo du jour ***
*/
// Appel Ajax apres l'ajout d'une photo par l'utilisateur
function addPhotoWeek() { 
	var desc = document.getElementById("id_desc").value;
	var file = document.getElementById("id_file").value;
	
	
	document.getElementById("id_desc").value = "";
	document.getElementById("id_file").value = "";
		
	var options = { 
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
	parameters: {desc: desc, file: file, TypeReq: 'add'}
	} 
	var ajaxCall = new Ajax.Updater("d_list", "./admin/include/photoWeek-trt.php", options); 
}

/* 
 *** Gestion des cat�gories des photos ***
*/

// Appel Ajax apres l'ajout d'une news par l'utilisateur
function addCategory() { 
	var titre = document.getElementById("id_titre").value;
	var description = document.getElementById("id_description").value;
	
	document.getElementById("id_titre").value = "";
	document.getElementById("id_description").value = "";
		
	var options = { 
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
	parameters: {titre: titre, description: description, TypeReq: 'add'}
	}
	var ajaxCall = new Ajax.Updater("d_list", "./admin/include/photosCategory-trt.php", options); 
}

// Appel Ajax pour afficher la categorie a modifier
function affCategoryModif(id_category) { 
	// On cache l'ajout des categories
	document.getElementById("d_ajout").style.visibility = 'hidden';
	document.getElementById("d_modif").style.visibility = 'visible';
	
	var options = { 
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
	parameters: {id_category: id_category, TypeReq: 'affModif'}
	} 
	var ajaxCall = new Ajax.Updater("d_modif", "./admin/include/photosCategory-trt.php", options); 
}

function modifCategory(id_category) { 
	
	document.getElementById("d_modif").style.visibility = 'hidden';
	document.getElementById("id_titre").value = "";
	document.getElementById("id_description").value = "";
	document.getElementById("d_ajout").style.visibility = 'visible';

	if ( id_category != -1 ) {
		var id= id_category;
		var titre = document.getElementById("id_titreModif").value;
		var description = document.getElementById("id_descriptionModif").value;
		
		var options = { 
			encoding: 'iso-8859-1',
			evalScripts: true,
			method: "post",
		parameters: {id: id, titre: titre, description: description, TypeReq: 'modif'}
		} 
		var ajaxCall = new Ajax.Updater("d_list", "./admin/include/photosCategory-trt.php", options); 
	}
}

function supprCategory(id) { 
	
	if (window.confirm("Voulez vous supprimer cette cat�gorie et toutes les photos qu'elle contient?")) {
		
		var id = id;

		var options = { 
			encoding: 'iso-8859-1',
			evalScripts: true,
			method: "post",
		parameters: {id: id, TypeReq: 'suppr'}
		} 
		var ajaxCall = new Ajax.Updater("d_list", "./admin/include/photosCategory-trt.php", options); 
	}
}

/* 
 *** Gestion des photos ***
*/

function supprPhoto(id_cat,dossier,nom) { 
	
	if (window.confirm('Voulez vous supprimer cette photo ?')) {
		
		var id_cat= id_cat;
		var dossier= dossier;
		var nom = nom;

		var options = { 
			encoding: 'iso-8859-1',
			evalScripts: true,
			method: "post",
		parameters: {dossier: dossier, nom: nom, id_cat: id_cat, TypeReq: 'suppr'}
		} 
		var ajaxCall = new Ajax.Updater("d_list", "./admin/include/photos-trt.php", options); 
	}
}

