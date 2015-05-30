<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Méthodes de vérification de session *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================


	
if ( !defined('SESSION') ) {
	
	define("SESSION",true);
		
	@session_start();
	
	function verifSession () {
		if ( isset ($_SESSION['user_id'])){
			return true;
		}else {
			return false;
		}
	}// end function verifSession()

	function decoSession() {
		
		// on désenregistre la session uti_id
		//session_unregister("user_id");
		
		//on supprime toutes les variables de la session
		session_unset();
		
		//on detruit totalement la session
		session_destroy();
	}// end function decoSession()

	function isAdmin () {
		if ( verifSession() ) {
			if ( $_SESSION['user_statut'] == 1 || $_SESSION['user_statut'] == 2 ) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}// end function isAdmin()

	function isSuperAdmin () {
		if ( verifSession() ) {
			if ( $_SESSION['user_statut'] == 1 ) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}// end function isAdmin()
	
} // end if !defined SESSION
?>