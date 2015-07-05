<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Methodes de base de l'application *
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if ( !defined('COMMON') ) {
	define("COMMON",true);

	if (!defined('CONFIG') ) {
		include('config/config.php');
	}
    
    if (TYPE_ENV == 'prod') {
        error_reporting(0);
    }
    else {
        //error_reporting(E_ALL);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    }
     	
	function toDateTimeFr($datetime) {
		// le datetime est de format "0000:00:00 00:00:00"

	    // s�paration date et heure avec pour r�f�rence " "
	    list($date, $time) = explode(" ", $datetime);
	    // s�paration ann�e, mois et jour avec pour r�f�rence "-"
	    list($year, $month, $day) = explode("-", $date);
		// s�paration heure, minute, seconde avec pour r�f�rence "-"
		list($h, $mn, $s) = explode(":", $time);

	    // la date est r�adapt� au format fran�ais
	    $tDate['date'] = $day."/".$month."/".$year;
		$tDate['heure'] = $h."h".$mn;

	     return $tDate; // renvoi du nouveau datetime
    } 	
	function toDateFr($date) {
		// le date est de format "0000-00-00"

	    // s�paration ann�e, mois et jour avec pour r�f�rence "-"
	    list($year, $month, $day) = explode("-", $date);

	    // la date est r�adapt� au format fran�ais
	    $newDate = $day."/".$month."/".$year;

	     return $newDate; // renvoi de la nouvelle date
    }  	
	function dateFullFr() {
	
		$date_fr = "";
		
		// jour
		$day = date("l");
		
		$aDay["Monday"] = "Lundi";
		$aDay["Tuesday"] = "Mardi";
		$aDay["Wednesday"] = "Mercredi";
		$aDay["Thursday"] = "Jeudi";
		$aDay["Friday"] = "Vendredi";
		$aDay["Saturday"] = "Samedi";
		$aDay["Sunday"] = "Dimanche";
		
		$day_fr = $aDay[$day];
		
		// mois
		$month = date("F");
		
		$aMonth["January"] = "Janvier";
		$aMonth["February"] = "F�vrier";
		$aMonth["March"] = "Mars";
		$aMonth["April"] = "Avril";
		$aMonth["May"] = "Mai";
		$aMonth["June"] = "Juin";
		$aMonth["July"] = "Juillet";
		$aMonth["August"] = "Ao�t";
		$aMonth["September"] = "Septembre";
		$aMonth["October"] = "Octobre";
		$aMonth["November"] = "Novembre";
		$aMonth["December"] = "D�cembre";
				
		$month_fr = $aMonth[$month];

		$date_fr = $day_fr." ".date("j")." ".$month_fr." ".date("Y");
	     return $date_fr;
    } 
		
	function tableIsEmpty($table) {		
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$table;
		$result = mysql_query($query);
		$nbLigne = mysql_num_rows($result);
		include (RACINE."/include/bdd_close.php");
		if ( $nbLigne == 0 ) {
			return TRUE;
		}else{
			return FALSE;
		}
	
	}
	
	function generatePWD() {
		// Ensemble des caract�res utilis�s pour le cr�er
		$chars="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		// Combien on en a mis au fait ?
		$wlong=strlen($chars);
		// Au d�part, il est vide ce mot de passe ;)
		$wpas="";
		// Combien on veut de caract�res pour ce mot de passe ?
		$taille=6;
		// On initialise la fonction al�atoire
		srand((double)microtime()*1000000);
		// On boucle sur le nombre de caract�res voulus
		for($i=0;$i<$taille;$i++){
		// Tirage al�atoire d'une valeur entre 1 et wlong
		      $wpos=rand(0,$wlong-1);
		// On cumule le caract�re dans le mot de passe
		      $wpas=$wpas.substr($chars,$wpos,1);
		// On continue avec le caract�re suivant � g�n�rer      
		}
		// On affiche le mot de passe (on peut le stocker quelque part...)
		return $wpas;
	}	
	
	function formatTel($numero) {
		// le numero est format 0000000000

	    $numero = wordwrap ($numero, 2, '.', 1);


	     return $numero;
    } 
	
	// Retourne la saison en cours au format AAAA-AAAA
	function get_saisonEnCours() {
		
		$annee_curr = date("Y");
		$mois_curr = date("n");
		$annee_debut = $annee_curr;
		$annee_fin = $annee_curr;	
	
		if ( $mois_curr < 8 ) 
			$annee_debut = $annee_curr-1;
		else
			$annee_fin = $annee_curr+1;
			
		return $annee_debut . "-" . $annee_fin;
	}
	
	// Retourne la liste des saisons pour un <select>
	function getSaisonsOptions ($saison_selected, $annee_debut) {
		echo "<br/> getSaisonsOptions";
		$liste_options = "";
		$annee_curr = date("Y");
		$mois_curr = date("n");
		$annee_fin = $annee_curr;
		
		if ( $mois_curr > 8 )
			$annee_fin = $annee_curr + 1;
			
		for ( $annee_fin_curr = $annee_fin; $annee_fin_curr > $annee_debut; $annee_fin_curr-- ) {
			$annee_debut_curr = $annee_fin_curr - 1;
			$saison_curr = $annee_debut_curr . "-" . $annee_fin_curr;
			$liste_options .= "<option value=\"" . $saison_curr . "\"";
			if ( $saison_selected == $saison_curr )
				$liste_options .= " selected=\"selected\"";
			$liste_options .= ">";
			$liste_options .= "&nbsp;Saison " . $saison_curr . "&nbsp;";
			$liste_options .= "</option>";
		}	
		return $liste_options;
	}
	
    // ANTI-INJECTION SQL + XSS
    function protection($valeur, $mode='NUMERIC') {
        switch($mode) {
            case 'NUMERIC' :
                if ($numeric = ctype_digit($valeur)) {
                $valeur = stripslashes($valeur);
                $valeur = htmlspecialchars($valeur);
                $valeur = htmlentities($valeur);
                return @mysql_real_escape_string($valeur);
                } else {echo'no numeric';};
            break;
            case 'ALPHA' :
                if ($alpha = ctype_alpha($valeur)) {
                $valeur = stripslashes($valeur);
                $valeur = htmlspecialchars($valeur);
                $valeur = htmlentities($valeur);
                return @mysql_real_escape_string($valeur);
                } else {echo'no alpha';};
            break;
            case 'ALPHA-NUMERIC' :
                if ($alnum = ctype_alnum($valeur)) {
                $valeur = stripslashes($valeur);
                $valeur = htmlspecialchars($valeur);
                $valeur = htmlentities($valeur);
                return @mysql_real_escape_string($valeur);
                } else {echo'no alpha-numeric';};
            break;
            default:
                $valeur = stripslashes($valeur);
                $valeur = htmlspecialchars($valeur);
                $valeur = htmlentities($valeur);
                return @mysql_real_escape_string($valeur);
            break;
        }
    }

}








?>