<?php 
header('Content-Type: text/html; charset=iso-8859-1');

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Verification de l'identification de l'utilisateur *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
include('./../config/config.php');

include("../include/bdd_connec.php");	
if (!defined('LOGIN_AFF')) { include('./../include/login_aff.php'); }
if (!defined('SESSION')) { include('./../include/session.php'); }

include('../include/class_users.php');
	
$req = $_POST['TypeReq'];

if ( $req == 'verif' ) {

	$oUsers = new users();

	$login = $_POST['login'];
	$pass = $_POST['pass'];
	
	$cryptedPassword = "init";
	if ( $pass != "init"){
		//recuperation du salt
		$query_2  = " SELECT * FROM tt_users ";
		$query_2 .= " WHERE users_login='".$login."'";	//on éxécute la requete
		$result_2 = mysql_query($query_2);
		//on compte le nombre de ligne du resultat
		$nb_row_2 = mysql_num_rows($result_2);
		// Verification que le requete renvoie un seul resultat
		if ($nb_row_2 == "1"){
			$row_2 = mysql_fetch_array($result_2);
			$salt = $row_2['users_salt'];
			$cryptedPassword = sha1($salt.$pass);
			//echo "<br/>".$salt ;
			//echo "<br/>".$cryptedPassword ;
		}
	}

	//requete à la base de donnée
	$query  = " SELECT * FROM tt_users ";
	$query .= " WHERE users_login='".$login."' AND users_pass='".$cryptedPassword."'";
			
	//on éxécute la requete
	$result = mysql_query($query);
			
	//on compte le nombre de ligne du resultat
	$nb_row = mysql_num_rows($result);

	//on vérifie si la variable $row renvoi un resultat
	if ($nb_row == "1"){
		//session_start();
		//on va chercher les données nécessaires dans le resultat
		$row = mysql_fetch_array($result);
		//on enregistre la variable id qui servira d'identification
		//session_register($row['users_id']);
			
		$_SESSION['user_id'] = $row['users_id'];
		$_SESSION['user_login'] = $login;
		$_SESSION['user_nom'] = $row['users_nom'];
		$_SESSION['user_prenom'] = $row['users_prenom'];
		$_SESSION['user_statut'] = $row['users_statut'];
		
		affConnecOk();
	} else {
		affErrorConnec();
	}
}
if ( $req == 'deco' ) {
	decoSession();
	affDecoOk();
}
if ( $req == 'affInfos' ) {
	affId();
}	

?>
	</body>
</html>