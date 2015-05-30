<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe maj*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if (!defined('COMMON') ) { 
	include('common.php'); 
}

class Maj
{
	/**
	* Code erreur retourné
	*
	* @var string
	*/
	var $error = "0"; 
	
	/**
	* Dossier de destination du fichier temporaire
	*
	* @var string
	*/
	var $dest_folder = "tmp/"; 
	
	/**
	* 
	*
	* @var string
	*/
	var $chemin_csv = ""; 
	
	/**
	* Nombre de colonne du fichier csv
	*
	* @var int
	*/
	var $nb_colonnes = 0; 

	
	function Maj()
	{
	} 

	/**
	* Upload du fichier csv
	*
	*/
	function uploadCSV()
	{
		if(empty($_FILES["file"]["name"])){
			$this->error = "empty";
		}else{ 
			$nomFichier = $_FILES["file"]["name"] ;
			$nomTemporaire = $_FILES["file"]["tmp_name"] ;
			$typeFichier = $_FILES["file"]["type"] ;
			$poidsFichier = $_FILES["file"]["size"] ;
			$codeErreur = $_FILES["file"]["error"] ;
			$extension = strrchr($nomFichier, ".");
			
			// Verification extension
			if($extension != ".csv" && $extension != ".CSV") {
				$this->error = "extension";
			}else{
				$this->chemin_csv = $this->dest_folder . $nomFichier;
				// Upload du fichier
				$uploadOk = move_uploaded_file($nomTemporaire, $this->chemin_csv);
				if(!$uploadOk){
					$this->error = "upload";
				}else{
					// Upload du fichier réussi
				}
			}
		}
	}
	
	/**
	* Traitement sur le fichier csv
	*
	*/
	function traitementCSV()
	{
		$retour = "";
	
		// *** Récupération du contenu du fichier ***
		
		$nb_lignes = 0; // compteur de ligne
		$handle = fopen($this->chemin_csv, "r");
		$tLigne_entete = array();
		$tLignes_temp = array();
		while($ligne = fgetcsv($handle, 1024, ';')) {
		
			if ( $nb_lignes == 0 ) {
				$this->nb_colonnes = count($ligne);
				// En tete CSV
				$tLigne_entete = $ligne;
				
			}else{
				$tLignes_temp[$nb_lignes] = $ligne;
			
			}
			$nb_lignes++;
		}
		fclose($handle);
		
		// Entete CSV		
		for( $i=0; $i<$this->nb_colonnes; $i++) {
			//$tLigne_entete[$i] = utf8_decode($tLigne_entete[$i]);
			echo $tLigne_entete[$i] = trim($tLigne_entete[$i]);
			//echo $tLigne_entete[$i] . "<br />";
		}
		
		// Remplissage du tableau tLignes avec les associations [intitulé colonne / valeur] pour chaque ligne
		$tLignes = array();
		for( $j=1; $j<count($tLignes_temp); $j++) {
			for( $k=0; $k<$this->nb_colonnes; $k++) {
				$tLignes[$j][$tLigne_entete[$k]] = $tLignes_temp[$j][$k];
			}
		}
		
		// *** Traitement pour chaque ligne du fichier *** 
		
		$oUsers = new Users();
		for( $j=1; $j<count($tLignes); $j++) {
		
			//$nom = utf8_decode(trim($tLignes[$j]["Nom"]));
			$nom = trim($tLignes[$j]["Nom"]);
			
			if ( $nom != "" ) {
			
				$login = trim($tLignes[$j]["Identifiant"]);
				$nom = trim($tLignes[$j]["Nom"]);
				$prenom = trim($tLignes[$j]["Prénom"]);
				$type_licence = trim($tLignes[$j]["Lic."]);
				$categorie = trim($tLignes[$j]["Cat."]);
				$numLicence = trim($tLignes[$j]["Licence"]);
				$points = trim($tLignes[$j]["Points"]);
				$equipe = trim($tLignes[$j]["Equipe Adulte"]);
				$equipe_jeune = "";
			
				// Traitement Catégorie
				$liste_cat_jeune = array("B1", "B2", "M1", "M2", "C1", "C2", "J1", "J2", "J3"); 					
				$statutSportif = 1;
				if ($type_licence == "P")
						$statutSportif = 2; // Loisir
				if ( in_array($categorie, $liste_cat_jeune))
					$statutSportif = 3; // Jeune					
			
			
				$retour .= "<b>" . $login . "</b>";
			
				if ($oUsers->userExist($login) != -1 ) {
					// * L'utilisateur existe *
					if ( $categorie != "") {
						$oUsers->udpateCategorie($login, $statutSportif);
						$retour .= " - Statut Sportif modifié";
					}				
				}
				else {
					// * L'utilisateur n'existe pas * 	
					
					$oUsers->create($login, $statutSportif, $nom, $prenom, $numLicence, $points, $equipe, $equipe_jeune);					
					$retour .= " - Utilisateur créé";
				}
				
				// * Gestion des équipes * 
				if ($equipe != "" ) {
					if ($equipe == "R3 C")
						$oUsers->updateEquipe($login, 1);
					if ($equipe == "D1 D")
						$oUsers->updateEquipe($login, 2);
					if ($equipe == "D2 B")
						$oUsers->updateEquipe($login, 3);
					if ($equipe == "D2 D")
						$oUsers->updateEquipe($login, 4);
					if ($equipe == "D4 D")
						$oUsers->updateEquipe($login, 5);
					if ($equipe == "D5 B")
						$oUsers->updateEquipe($login, 6);
					if ($equipe == "D5 D")
						$oUsers->updateEquipe($login, 7);
					if ($equipe == "D0 A (F)")
						$oUsers->updateEquipe($login, 11);
					if ($equipe == "D1 A (F)")
						$oUsers->updateEquipe($login, 12);
					$retour .=  " - Equipe modifiée";
				}
				$retour .= "<br/>";					
			}
		}	
		
		// Suppression du fichier temporaire - TODO
		unlink($this->chemin_csv);
		
		return $retour;
	}		
}