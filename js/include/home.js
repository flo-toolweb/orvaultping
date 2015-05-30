jQuery.noConflict();

jQuery(document).ready(function(){

	/* Position de la photo de la semaine */
	var largeur_lien = jQuery("#d_photos #a_txt_photos").width();
	var largeur_img = jQuery("#d_photos #photo_semaine_mini").width();
	var left = largeur_img-largeur_lien+1;
	jQuery("#d_photos #photo_semaine_mini").css("left","-"+left+"px");
	
	/* Compte à rebours nouvelle salle */
//	CompteARebours();
//	setInterval(CompteARebours, 1000);
});
/* 
 *** Popup ***
*/
function centrage_popup(page,largeur,hauteur,options){
	var top=(screen.height-hauteur)/2;
	var left=(screen.width-largeur)/2;
	window.open(page,"popup","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+options);
}
/* 
 ***  ***
*/
function CompteARebours(){
	var date_actuelle = new Date();
	var date_nouvelle_salle = new Date(2015, 2, 20, 19, 0, 0);
	var tps_restant = date_nouvelle_salle.getTime() - date_actuelle.getTime();
	
	if ( tps_restant < 0 ) 	
		return 1;
	
	var s_restantes = tps_restant / 1000; // On convertit en secondes
	var mn_restantes = s_restantes / 60;
	var H_restantes = mn_restantes / 60;
	var d_restants = H_restantes / 24;
	s_restantes = Math.floor(s_restantes % 60); // Secondes restantes
    mn_restantes = Math.floor(mn_restantes % 60); // Minutes restantes
    H_restantes = Math.floor(H_restantes % 24); // Heures restantes
    d_restants = Math.floor(d_restants); // Jours restants
		
	jQuery("#d_compte_a_rebours #s_compte_a_rebours_jours").html(d_restants);	
	jQuery("#d_compte_a_rebours #s_compte_a_rebours_heures").html(H_restantes);	
	jQuery("#d_compte_a_rebours #s_compte_a_rebours_minutes").html(mn_restantes);	
	jQuery("#d_compte_a_rebours #s_compte_a_rebours_secondes").html(s_restantes);
	
	return 0;
}
