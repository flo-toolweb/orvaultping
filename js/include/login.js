
// Appel Ajax apres l'envoi des informations d'identification de l'utilisateur
function idStart() { 

	var log = document.getElementById("id_login").value;
	var pwd = document.getElementById("id_pass").value;
	var options = {
		encoding: 'iso-8859-1',
		evalScripts: true,
		method: 'post',
	parameters: {login: log, pass: pwd, TypeReq: 'verif'}
	} 
	var ajaxCall = new Ajax.Updater("d_id_contenu", "./include/login_trt.php", options); 
	
}

// Appel Ajax apres la demande de deconnexion de l'utilisateur
function idDeco() { 
	var options = {
		encoding: 'iso-8859-1', 
		evalScripts: true,
		method: "post",
	parameters: {TypeReq: 'deco'}
	} 
	var ajaxCall = new Ajax.Updater("d_id_contenu", "./include/login_trt.php", options); 
}

// Affichage des infos de connexion apres idientification
function affDivId() { 
	var options = {
		encoding: 'iso-8859-1' ,
		method: "post",
	parameters: {TypeReq: 'affInfos'}
	} 
	var ajaxCall = new Ajax.Updater("d_id_contenu", "./include/login_trt.php", options); 
	
}

// efface les valeurs des input
function clearInput(id) { 
	inputTxt = document.getElementById(id).value;
	if ( inputTxt == "Password" || inputTxt == "Login" ) {
		document.getElementById(id).value = "";
	}
}
	