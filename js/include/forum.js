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
 *** Ajout d'un smiley dans le message ***
*/
function addSmiley(id, type) {	

    var textarea = document.getElementById(id);   
	// Recuperation de la position de la scrollbar
    var scroll_position = textarea.scrollTop;
	// Recuperation du texte du textarea
    var text_value = document.getElementById(id).value;
	// Recuperation de la position du curseur
    var position = getCursorPosition(id);
	
	// Selection de l'utilisateur si il y a 
	var select = getSelect(id);
	// Texte avant la balise
    var string_start = text_value.substring(0, position);
	// Texte apres la balise
    var string_end = text_value.substring(position+select.length);
	 
	switch(type)
    {
    case "smile" :
        var text_balise = ":)";
        break;
    case "bigsmile" :
        var text_balise = ":D";
        break;
    case "sad" :
        var text_balise = ":(";
        break;
    case "tongueout" :
        var text_balise = ":langue:";
        break;
    case "wink" :
        var text_balise = ";)";
        break;
    case "crying" :
        var text_balise = ":pleure:";
        break;
    case "surprised" :
        var text_balise = ":surpris:";
        break;
    case "blush" :
        var text_balise = ":timide:";
        break;
    case "wasntme" :
        var text_balise = ":innocent:";
        break;
    case "giggle" :
        var text_balise = ":pouffe:";
        break;
    case "worried" :
        var text_balise = ":inquiet:";
        break;
    case "angry" :
        var text_balise = ":furieux:";
        break;
    case "cool" :
        var text_balise = ":tranquille:";
        break;
    case "rock" :
        var text_balise = ":rock:";
        break;
    case "devil" :
        var text_balise = ":diable:";
        break;
    default :
        return false;
    } 
	// Nouveau texte du textarea
    document.getElementById(id).value = string_start + text_balise + string_end;
	// Positionnement du curseur apres la selection
    setCursorPosition(id, position + text_balise.length, position + text_balise.length);
	// Positionnement de la scrollbar
	textarea.scrollTop = scroll_position;
}
 