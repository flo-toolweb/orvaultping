<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe Utilisateurs*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if (!defined('COMMON') ) { 
	include('common.php'); 
}

class Forum
{
	/**
	* Nom de la table des utilisateurs
	*
	* @var string
	*/
	var $table = "tt_forum"; 
	
	/**
	* TRUE si la liste  a ete construite, FALSE sinon
	*
	* @var boolean
	*/
	var $listIsBuilt = FALSE;
	
	/**
	* Liste
	*
	* @var array
	*/
	var $List = array(); 
	
	
	function Forum()
	{
		
	} 

	/**
	* Construit la liste 
	*
	* @return void
	*/
	function BuildList()
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." ORDER BY forumMsg_dateDerRep ASC";
		
		$result = mysql_query($query);
		$cpt = 0;
		while ( $row = mysql_fetch_array($result) ) {
			$tMsg[$cpt]['forumMsg_id'] = $row['forumMsg_id'];
			$tMsg[$cpt]['forumMsg_sujet'] = stripSlashes($row['forumMsg_sujet']);
			$tMsg[$cpt]['forumMsg_contenu'] = stripSlashes($row['forumMsg_contenu']);
			$tMsg[$cpt]['forumMsg_auteur'] = $row['forumMsg_auteur'];
			$tMsg[$cpt]['forumMsg_dateCreation'] = $row['forumMsg_dateCreation'];
			$tMsg[$cpt]['forumMsg_dateDerRep'] = $row['forumMsg_dateDerRep'];
			$tMsg[$cpt]['forumMsg_nbRep'] = $row['forumMsg_nbRep'];
			$tMsg[$cpt]['forumMsg_nbVue'] = $row['forumMsg_nbVue'];
			$cpt++;
		}
		if ( $cpt != 0 ) {
			$this->List = $tMsg;
		}
		include (RACINE."/include/bdd_close.php");
		$listIsBuilt = TRUE;
	}
	/**
	* Retourne la liste
	*
	* @return array
	*/
	function GetList()
	{
		if (FALSE === $this->listIsBuilt) {
			$this->BuildList();
		}
		return $this->List;
	}

		
	function update($id,$nom,$prenom,$naissance,$tel1,$tel2,$email,$licence,$points,$pseudo,$signature)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " users_nom='".$nom."',";
		$query .= " users_prenom='".$prenom."',";
		$query .= " users_naissance='".$naissance."',";
		$query .= " users_tel1='".$tel1."',";
		$query .= " users_tel2='".$tel2."',";
		$query .= " users_email='".$email."',";
		$query .= " users_numLicence='".$licence."',";
		$query .= " users_points='".$points."',";
		$query .= " users_pseudo='".$pseudo."',";
		$query .= " users_signature='".$signature."'";
		$query .= " WHERE users_id='".$id."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}		
}