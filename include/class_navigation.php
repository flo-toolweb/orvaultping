<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe Navigation *
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if (!defined('COMMON') ) {
	include('common.php');
}

if (!defined('NAVIGATION') ) {
	define("NAVIGATION",true);
	class Navigation
	{
		var $pages = array("home"=>"Accueil","bureau"=>"Bureau","calendrier"=>"Calendrier du Club","contact-plan"=>"Contact - Plan",
						"equipes"=>"Equipes","joueurs"=>"Joueurs","joueurs_top5"=>"Joueurs","joueurs_fiche"=>"Joueurs",
						"le_club"=>"Le Club","liens_utiles"=>"Liens Utiles","inscriptions"=>"Inscriptions","mutations"=>"Mutations","criterium"=>"Criterium","news"=>"Vie du club","medias"=>"Médias","partenaires"=>"Partenaires",
						"forum"=>"Forum V 1.3", "forum_msg"=>"Forum V 1.3", "forum_new_msg"=>"Forum V 1.3",
						"forum_liste"=>"Forum","forum_edit_msg"=>"Forum","forum_edit_rep"=>"Forum",
						"perso"=>"Espace perso","password"=>"Mot de passe", "tournoi"=>"Tournoi", "babyping"=>"Baby ping");
		var $pages_perso = array("equipes"=>"Equipes","joueurs_fiche"=>"Joueurs","perso"=>"Espace perso","password"=>"Mot de passe",
						"forum"=>"Forum V 1.3", "forum_msg"=>"Forum V 1.3", "forum_new_msg"=>"Forum V 1.3",
						"forum_liste"=>"Forum V 1.3","forum_edit_msg"=>"Forum V 1.3","forum_edit_rep"=>"Forum V 1.3");
		var $pages_admin = array("adminHome"=>"Espace admin","adminNews"=>"Vie du club","adminPhotos"=>"Photos",
								"adminPhotosCat"=>"Photos","adminPhotoWeek"=>"Photos de la semaine",
								"adminMaj"=>"Mise à jour");
		var $page_vu;
		var $theme;
		var $typePage;

		var $titre;
		var $description;
		var $keywords;

		function Navigation($theme,$page="home",$type)
		{

			$this -> theme = $theme;

			if ( !array_key_exists($page,$this->pages) && !array_key_exists($page,$this->pages_admin) ) {
				if ( $type == 'admin' ) {
					$this -> typePage = "admin";
					$page = "adminHome";
				}else{
					$this -> typePage = "home";
					$page = "home";
				}
			}

			$this -> page_vu = $page;

			// Si la page demandee est une page de l'espace admin
			if ( array_key_exists($page,$this->pages_admin) ) {
				//Verification des droits
				if (isAdmin()) {
					$this -> dossier = CHEMIN.'/admin/template/';
				}else{
					header('Location: index.php?msg=droits');
				}

			// Si la page demandee n'est pas une page de l'espace admin
			}else{
				// Si la page demandee est une page de l'espace perso
				if ( array_key_exists($page,$this->pages_perso) ) {
					//Verification des droits
					if (!verifSession()) {
						header('Location: index.php?msg=droits');
					}
				}
				if ( $page != 'home' ) {
					$this -> dossier = CHEMIN.'/themes/'.$theme.'/pages/';
					$this -> typePage = "pages";
				}else{
					$this -> dossier = CHEMIN.'/themes/'.$theme.'/home/';
					$this -> typePage = "home";
				}

			}

			//$this -> recupererMetas($page);
		} // end function navigation

		function PreparerPourAffichage()
		{
			include($this->dossier.'template.php');
		}
		function afficherPage()
		{
			include($this->dossier.'views/'.$this->page_vu.'.php');
		}
		function getTypePage()
		{
			return $this -> typePage;
		}










	} // end class Navigation

} // end if !defined
