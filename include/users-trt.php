<?php
header('Content-Type: text/html; charset=iso-8859-1');

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Operations sur les utilisateurs (  ajout - modif ) *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../config/config.php');

include(RACINE.'/include/class_users.php');

$oUsers = new users();

$req = $_POST['TypeReq'];


if ( $req == 'affModif' ) {

	$id_user = $_POST['id_user'];

	$oUsers -> modifInfosPerso($id_user);

}
if ( $req == 'modif' ) {

	$user_id = $_POST['id'];
	
	// Ajout des antislashs
	$nom = addslashes($_POST['nom']);
	$prenom = addslashes($_POST['prenom']);
	$pseudo = addslashes($_POST['pseudo']);
	$signature = addslashes($_POST['signature']);
	
	$jour = $_POST['jour'];
	$mois = $_POST['mois'];
	$annee = $_POST['annee'];
	$tel1 = $_POST['tel1'];
	$tel2 = $_POST['tel2'];
	$email = $_POST['email'];
	$licence = $_POST['licence'];
	$points = $_POST['points'];
	
	$naissance = $annee."-".$mois."-".$jour;

	// Conversion en Iso 
	$nom = mb_convert_encoding($nom, "iso-8859-1", "UTF-8");
	$prenom = mb_convert_encoding($prenom, "iso-8859-1", "UTF-8");
	$pseudo = mb_convert_encoding($pseudo, "iso-8859-1", "UTF-8");
	$signature = mb_convert_encoding($signature, "iso-8859-1", "UTF-8");
	
	$oUsers -> update($user_id,$nom,$prenom,$naissance,$tel1,$tel2,$email,$licence,$points,$pseudo,$signature);
	
	?>
	<div class="d_msg">
		Modifications effectu&eacute;es
	</div>
	<?php
	$oUsers -> affInfosPerso($user_id);

}

if ( $req == 'password' ) {
	$user_id = $_POST['user_id'];
	$pass_old = $_POST['pass_old'];
	$pass_new1 = $_POST['pass_new1'];
	$pass_new2 = $_POST['pass_new2'];
	
	
	// Verifications
	$tUser = $oUsers -> GetUser($user_id);
	// Cryptage avec le salt
	if ($pass_old != "init" ) {
		$pass_old = sha1($tUser['users_salt'].$pass_old);
	}
	
	if ( $tUser['users_pass'] !== $pass_old ) {
		header("Location: ../index.php?page=password&msg=wrong");
		exit;		
	}
	if ( strlen($pass_new1) < 8 ) {
		header("Location: ../index.php?page=password&msg=lenght");
		exit;
	}
	if ( $pass_new1 !== $pass_new2 ) {
		header("Location: ../index.php?page=password&msg=diff");
		exit;
	}
	// OK
	// Cryptage du mot de passe et MAJ BDD
	$login = $tUser['users_login'];
	$oUsers -> setPassword($pass_new1, $login, $user_id );
	
	header("Location: ../index.php?page=perso&msg=ok");
	
	
}
