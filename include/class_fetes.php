<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe Fetes*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if (!defined('COMMON') ) { 
	include('common.php'); 
}

class Fetes
{
	/**
	* Nom de la table des fetes
	*
	* @var string
	*/
	var $table = "tt_fetes"; 
	

	
	function Fetes()
	{
	} 


	/**
	* Retourne un prenom 
	*
	* @param integer $jour numero du jour dans le mois
	* @param integer $mois numero du mois dans l'annee
	*/
	function GetPrenom($jour, $mois)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE fetes_jour=".$jour." AND fetes_mois = ".$mois;
		$result = mysql_query($query);
				
		$retour = "0";
		if (@mysql_num_rows($result)!=0) {
			$fete = mysql_fetch_row($result);
			$retour = stripSlashes($fete[2]);
		}
		
		return $retour;
	}
	
}