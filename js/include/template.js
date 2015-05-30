/* 
 *** Popup ***
*/
function centrage_popup(page,largeur,hauteur,options){
	var top=(screen.height-hauteur)/2;
	var left=(screen.width-largeur)/2;
	window.open(page,"popup","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+options);
}

/* 
 *** Photos ***
*/

/*  Affiche la liste des categories par saison*/
function affCatPhotos(){
	
	var saison = document.getElementById("select_saison").value;
	
	var options = { 
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
	parameters: {saison: saison, TypeReq: 'aff'}
	} 
	var ajaxCall = new Ajax.Updater("d_catEx", "./include/photosCategory-trt.php", options); 
}
function affMinPhotos(id_cat){
	
	var options = { 
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
	parameters: {id_cat: id_cat, TypeReq: 'aff'}
	} 
	var ajaxCall = new Ajax.Updater("d_miniatures", "./include/photos-trt.php", options); 
}
/* 
 *** Equipes ***
*/
function affEquipe(id_equipe, adulte, feminine, veteran){
		
	var options = { 
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
	parameters: {id_equipe: id_equipe, adulte: adulte, feminine: feminine, veteran: veteran, TypeReq: 'aff'}
	} 
	var ajaxCall = new Ajax.Updater("d_aff_equipe", "./include/equipes-trt.php", options); 
}


/* 
 *** Gestion de l'espace perso ***
*/

function affModifPerso(id_user) { 
	
	var id_user = id_user;

	var options = { 
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: "post",
	parameters: {id_user: id_user, TypeReq: 'affModif'}
	} 
	var ajaxCall = new Ajax.Updater("d_aff_infos", "./include/users-trt.php", options); 
}
function modifPerso(id_user) { 
	
	var id_user = id_user;

	if ( id_user != -1 ) {
		var id= id_user;
		var nom = document.getElementById("id_nom").value;
		var prenom = document.getElementById("id_prenom").value;
		var jour = document.getElementById("id_jour").value;
		var mois = document.getElementById("id_mois").value;
		var annee = document.getElementById("id_annee").value;
		var tel1 = document.getElementById("id_tel1").value;
		var tel2 = document.getElementById("id_tel2").value;
		var email = document.getElementById("id_email").value;
		var licence = document.getElementById("id_licence").value;
		var points = document.getElementById("id_points").value;
		var pseudo = document.getElementById("id_pseudo").value;
		var signature = document.getElementById("id_signature").value;
		
		var options = { 
			encoding: 'iso-8859-1',
			evalScripts: true,
			method: "post",
		parameters: {id: id, nom: nom, prenom: prenom, jour: jour, mois: mois, annee: annee, tel1: tel1, tel2: tel2, email: email,
					licence: licence, points: points, pseudo: pseudo, signature: signature,
					TypeReq: 'modif'}
		} 
		var ajaxCall = new Ajax.Updater("d_aff_infos", "./include/users-trt.php", options); 
	}
}