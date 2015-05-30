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

class Users
{
	/**
	* Nom de la table des utilisateurs
	*
	* @var string
	*/
	var $table = "tt_users"; 
	
	/**
	* TRUE si la liste  a ete construite, FALSE sinon
	*
	* @var boolean
	*/
	var $listIsBuilt = FALSE;
	
	/**
	* Liste des users
	*
	* @var array
	*/
	var $List = array(); 
	
	/**
	* Id de l'equipe du joueur
	*
	* @var array
	*/
	var $numEquipe = 0;
	
	
	function Users($equipe=0)
	{
		$this->numEquipe = $equipe;
	} 

	/**
	* Construit la liste des users
	*
	* @return void
	*/
	function BuildList()
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." ORDER BY users_nom ASC";
		
		$result = mysql_query($query);
		$cpt = 0;
		while ( $row = mysql_fetch_array($result) ) {
			$tUsers[$cpt]['users_id'] = $row['users_id'];
			$tUsers[$cpt]['users_login'] = $row['users_login'];
			$tUsers[$cpt]['users_pass'] = $row['users_pass'];
			$tUsers[$cpt]['users_salt'] = $row['users_salt'];
			$tUsers[$cpt]['users_statut'] = $row['users_statut'];
			$tUsers[$cpt]['users_statutSportif'] = $row['users_statutSportif'];
			$tUsers[$cpt]['users_nom'] = stripSlashes($row['users_nom']);
			$tUsers[$cpt]['users_prenom'] = stripSlashes($row['users_prenom']);
			$tUsers[$cpt]['users_naissance'] = stripSlashes($row['users_prenom']);
			$tUsers[$cpt]['users_prenom'] = stripSlashes($row['users_prenom']);
			$tUsers[$cpt]['users_naissance'] = $row['users_naissance'];
			$tUsers[$cpt]['users_tel1'] = $row['users_tel1'];
			$tUsers[$cpt]['users_tel2'] = $row['users_tel2'];
			$tUsers[$cpt]['users_adresse'] = stripSlashes($row['users_adresse']);
			$tUsers[$cpt]['users_photo'] = stripSlashes($row['users_photo']);
			$tUsers[$cpt]['users_numLicence'] = $row['users_numLicence'];
			$tUsers[$cpt]['users_points'] = $row['users_points'];
			$tUsers[$cpt]['users_equipe'] = $row['users_equipe'];
			$tUsers[$cpt]['users_equipe_feminine'] = $row['users_equipe_feminine'];
			$tUsers[$cpt]['users_equipe_veteran'] = $row['users_equipe_veteran'];
			$tUsers[$cpt]['users_equipe_jeune'] = $row['users_equipe_jeune'];
			$tUsers[$cpt]['users_capitaine'] = $row['users_capitaine'];
			$tUsers[$cpt]['users_capitaine_jeune'] = $row['users_capitaine_jeune'];
			$tUsers[$cpt]['users_entraineur'] = $row['users_entraineur'];
			$tUsers[$cpt]['users_pseudo'] = stripSlashes($row['users_pseudo']);
			$tUsers[$cpt]['users_signature'] = stripSlashes($row['users_signature']);
			$tUsers[$cpt]['users_avatar'] = stripSlashes($row['users_avatar']);
			$tUsers[$cpt]['users_lastView'] = $row['users_lastView'];
			$cpt++;
		}
		if ( $cpt != 0 ) {
			$this->List = $tUsers;
		}
		include (RACINE."/include/bdd_close.php");
		$listIsBuilt = TRUE;
	}
	/**
	* Retourne la liste des utilisateurs
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
	/**
	* Retourne un utilisateur
	*
	* @param integer $id identifiant numérale du joueur
	*/
	function GetUser($id)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE users_id=".$id;
		$result = mysql_query($query);
				
		$user = mysql_fetch_array($result);
		include (RACINE."/include/bdd_close.php");
		
		$user['users_nom'] = stripSlashes($user['users_nom']);
		$user['users_prenom'] = stripSlashes($user['users_prenom']);
		//$user['users_naissance'] = $user['users_naissance'];
		$user['users_prenom'] = stripSlashes($user['users_prenom']);
		$user['users_adresse'] = stripSlashes($user['users_adresse']);
		$user['users_photo'] = stripSlashes($user['users_photo']);
		$user['users_pseudo'] = stripSlashes($user['users_pseudo']);
		$user['users_signature'] = stripSlashes($user['users_signature']);
		$user['users_avatar'] = stripSlashes($user['users_avatar']);
		$user['users_lastView'] = $user['users_lastView'];
		
		return $user;
	}
	/**
	* Retourne l'id numérale de l'utilisateur,
	* Retourne -1 si l'utilisateur n'existe pas
	*
	* @param integer $login identifiant de connexion de l'utilisateur
	*/
	function userExist($login)
	{
		$retour = -1;
		
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE users_login='".$login."'";
		
		$result = mysql_query($query);
				
		$user = mysql_fetch_array($result);
		
		if ($user) 
			$retour = $user['users_id'];
		
		include (RACINE."/include/bdd_close.php");
		
		return $retour;
	}
	
	/**
	* Création d'un utilisateur
	*
	* @return void
	*/		
	function create($login, $statutSportif=1, $nom, $prenom, $numLicence, $points, $equipe, $equipe_jeune)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " INSERT INTO ".$this->table." (";
		$query .= " users_login,";
		$query .= " users_statutSportif,";
		$query .= " users_nom,";
		$query .= " users_prenom,";
		$query .= " users_numLicence,";
		$query .= " users_points,";
		$query .= " users_equipe,";
		$query .= " users_equipe_jeune )";
		$query .= " VALUES (";
		$query .= " '" . $login . "',";
		$query .= " '" . $statutSportif . "',";
		$query .= " '" . $nom . "',";
		$query .= " '" . $prenom . "',";
		$query .= " '" . $numLicence . "',";
		$query .= " '" . $points . "',";
		$query .= " '" . $equipe . "',";
		$query .= " '" . $equipe_jeune . "')";	
		
		//echo $query;	
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}	
	/**
	* Met à jour les informations de l'utilisateur
	*
	* @return void
	*/		
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
	/**
	* Met à jour de l'équipe de l'utilisateur
	*
	* @return void
	*/		
	function updateEquipe($login, $equipe)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " users_equipe='".$equipe."'";
		$query .= " WHERE users_login='".$login."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}		
	/**
	* Met à jour de la catégorie de l'utilisateur
	*
	* @return void
	*/		
	function udpateCategorie($login, $statutSportif)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " users_statutSportif='".$statutSportif."'";
		$query .= " WHERE users_login='".$login."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}		
	/**
	* Met à jour le mot de passe de l'utilisateur
	*
	* @return void
	*/	
	function updatePass($id, $newPass)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " users_pass='".$newPass."'";
		$query .= " WHERE users_id='".$id."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}			
	/**
	* Met à jour l'heure de creation du dernier message lu
	*
	* @return void
	*/	
	function updateLastView($id, $newLastView)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " users_lastView='".$newLastView."'";
		$query .= " WHERE users_id='".$id."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}
	
	
	/**
	* Affiche la liste des joueurs du club
	*
	* @param chaine $tri // variable de tri du tableau
	* @return void
	*/
	function affList($tri='nom')
	{
		// Mise a jour de la liste
		$this->BuildList();
		$list = $this->GetList();
		
		if ( count($list) == 0 ) {
			echo "Aucun joueur enregistr&eacute;";
		}	
		$nb_user = 0;
		$nb_jeune = 0;
		foreach($list AS $cle => $valeur) { 
			if ( $list[$cle]['users_statutSportif'] != 5 || $list[$cle]['users_entraineur'] == 1) {
				$nb_user++;
			}			
			if ( $list[$cle]['users_statutSportif'] == 3) {
				$nb_jeune++;
			}
		}	
		// Tri du tableau
		// Obtient une liste de colonnes
		foreach ($list as $key => $row) {
		    $nom[$key]  = $row['users_nom'];
		    $cat[$key] = $row['users_statutSportif'];
		    $classement[$key] = $row['users_points'];
		}
		if ( $tri == "nom" ) {
			array_multisort($nom, SORT_ASC, SORT_STRING, $list);
		 } else{
			if  ( $tri == "cat" ) {
				array_multisort($cat, SORT_ASC, SORT_STRING, $nom, SORT_ASC, SORT_STRING, $list);	
			} else {
				array_multisort($classement, SORT_DESC, SORT_NUMERIC, $nom, SORT_ASC, SORT_STRING, $list);							
			}
		}
		?>
					
			<div id="d_liste_header">
				&bull;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $nb_user;?>&nbsp;Membres&nbsp;&nbsp;&nbsp;&nbsp; 
				&bull;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $nb_jeune;?>&nbsp;jeunes&nbsp;&nbsp;&nbsp;&nbsp;&bull;
			</div>
			<table border="1" rules="all" id="t_liste">
			    <thead>
					<tr>
						<th><a href="index.php?page=joueurs&tri=nom" title="Trier le tableau par nom du joueur">Joueur</a></th>
						<th><a href="index.php?page=joueurs&tri=cat" title="Trier le tableau par cat&eacute;gorie">Cat&eacute;gorie</a></th>
						<th><a href="index.php?page=joueurs&tri=classement" title="Trier le tableau par classement">Classement</a></th>
					</tr>
			    </thead>
			    <tbody>

				<?php
				$oUsers = new Users();
				foreach($list AS $cle => $valeur) { 
					
					// Si ce n'est pas un invité ou si c'est un entraineur
					if ( $list[$cle]['users_statutSportif'] != 5 || $list[$cle]['users_entraineur'] == 1) {
				
				
						if ( ($cle+1)%2 === 0 ) {
							echo '<tr class="tr_liste1">';
						}else{
							echo '<tr class="tr_liste2">';				
						}?>					
						<td class="td_joueur">		
							<?php 
								if (!verifSession()) {
									echo $list[$cle]['users_prenom'].' ';; 
									echo $list[$cle]['users_nom']; 
								} else {
									echo '<a href="index.php?page=joueurs_fiche&id_user='.$list[$cle]['users_id'].'" title="Voir la fiche du joueur" >';
									echo $list[$cle]['users_prenom'].' '; 
									echo $list[$cle]['users_nom']; 
									echo '</a>';
								}
								?>
						</td>
						<td class="td_cat">
							<?php
							if ( $list[$cle]['users_entraineur'] == 1 ) {
								echo 'Entra&icirc;neur';							
							}else{
								switch( $list[$cle]['users_statutSportif'] ) 
								{
								  case 1: 
								    echo 'Comp&eacute;tition';
								    break;
								  case 2: 
								    echo 'Loisir';
								    break;
								  case 3: 
								    echo 'Jeune';
								    break;
								  case 4: 
								    echo 'Bureau';
								    break;

								  default: // dans tous les autres cas
								    echo '';
								} 
							}
							?>
							
						</td>
						<td class="td_classement">
							<?php 
							if ( $list[$cle]['users_points'] > 0 ) {
								echo $list[$cle]['users_points']; 
							} else {
								echo '-';
							}
							?>
						</td>
						</tr>
					
				<?php
					} // end if 
				} // end foreach
				?>    
			</tbody>
		</table>
		<?php
	}
	
	/**
	* Affiche les informations personnelles de l'utilisateur
	*
	* @param integer $id identifiant de l'utilisateur
	* @return array
	*/

	function affInfosPerso($id)
	{
		$tUser = $this -> GetUser($id);
		
		//Suppression des antislashs
		$tUser['users_nom'] = stripSlashes($tUser['users_nom']);
		$tUser['users_prenom'] = stripSlashes($tUser['users_prenom']);
		$tUser['users_pseudo'] = stripSlashes($tUser['users_pseudo']);
		$tUser['users_signature'] = stripSlashes($tUser['users_signature']);
		
	?>
			<span id="s_titre_page">Vos informations personnelles</span>
			<br/><br/>
				<fieldset>
					<div id="d_titre_form_haut">
						Administratif
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Nom :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_nom']; ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Pr&eacute;nom :
						</span>
						<span class="c_form_droite">       
							<b><?php echo $tUser['users_prenom']; ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Date de naissance :
						</span>
						<span class="c_form_droite"> 
							<b><?php 
								if ( $tUser['users_naissance'] !== NULL ) {
									$tUser['users_naissance'] = toDateFr($tUser['users_naissance']);
									echo $tUser['users_naissance']; 
								}
							?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								T&eacute;l&eacute;phone 1* :
						</span>
						<span class="c_form_droite">      
							<b><?php echo formatTel($tUser['users_tel1']);  ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								T&eacute;l&eacute;phone 2* :
						</span>
						<span class="c_form_droite">      
							<b><?php echo formatTel($tUser['users_tel2']);  ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								E-Mail* :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_email'];  ?></b>
						</span>
					</div>
					<div class="d_titre_form">
						Sportif
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Num&eacute;ro de licence :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_numLicence']; ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Nombre de points :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_points']; ?></b>
						</span>
					</div>
					<div class="d_titre_form">
						Forum
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Pseudo :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_pseudo']; ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Signature :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_signature']; ?></b>
						</span>
					</div>
					<div class="d_row" id="d_form_footer">
						<br/>
						<button type="button" class="i_bouton" onClick="affModifPerso(<?php echo $tUser['users_id']; ?>)" title="Modifier">
							Modifier vos informations 
						</button>
						<br/>
						<br/>
					</div>
		        </fieldset>
	<?php	
	}
		/**
	* Affiche les informations personnelles du joueur
	*
	* @param integer $id identifiant de l'utilisateur
	* @return array
	*/

	function affInfosFiche($id)
	{
		$tUser = $this -> GetUser($id);
		
		//Suppression des antislashs
		$tUser['users_nom'] = stripSlashes($tUser['users_nom']);
		$tUser['users_prenom'] = stripSlashes($tUser['users_prenom']);
		$tUser['users_pseudo'] = stripSlashes($tUser['users_pseudo']);
		$tUser['users_signature'] = stripSlashes($tUser['users_signature']);
		
	?>
			<span id="s_titre_page">Fiche personnelle de <?php echo $tUser['users_prenom'].' '.$tUser['users_nom']; ?></b></span>
			<br/><br/>
				<fieldset>
					<div id="d_titre_form_haut">
						Administratif
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Nom :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_nom']; ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Pr&eacute;nom :
						</span>
						<span class="c_form_droite">       
							<b><?php echo $tUser['users_prenom']; ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Date de naissance :
						</span>
						<span class="c_form_droite"> 
							<b><?php 
								if ( $tUser['users_naissance'] !== NULL ) {
									$tUser['users_naissance'] = toDateFr($tUser['users_naissance']);
									echo $tUser['users_naissance']; 
								}
							?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								T&eacute;l&eacute;phone 1* :
						</span>
						<span class="c_form_droite">      
							<b><?php echo formatTel($tUser['users_tel1']);  ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								T&eacute;l&eacute;phone 2* :
						</span>
						<span class="c_form_droite">      
							<b><?php echo formatTel($tUser['users_tel2']);  ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								E-Mail* :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_email'];  ?></b>
						</span>
					</div>
					<div class="d_titre_form">
						Sportif
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Num&eacute;ro de licence :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_numLicence']; ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Nombre de points :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_points']; ?></b>
						</span>
					</div>
					<div class="d_titre_form">
						Forum
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Pseudo :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_pseudo']; ?></b>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
								Signature :
						</span>
						<span class="c_form_droite">      
							<b><?php echo $tUser['users_signature']; ?></b>
						</span>
					</div>
		        </fieldset>
	<?php	
	}	
	/**
	* Affiche le formulaire de modification des informations personnelles de l'utilisateur
	*
	* @param integer $id identifiant de l'utilisateur
	* @return array
	*/

	function modifInfosPerso($id)
	{
		$tUser = $this -> GetUser($id);
	
		//Suppression des antislashs
		$tUser['users_nom'] = stripSlashes($tUser['users_nom']);
		$tUser['users_prenom'] = stripSlashes($tUser['users_prenom']);
		$tUser['users_pseudo'] = stripSlashes($tUser['users_pseudo']);
		$tUser['users_signature'] = stripSlashes($tUser['users_signature']);
		
	?>		<span id="s_titre_page">Modification de vos informations personnelles</span>
			<br/><br/>
			<form id="form_modif" name="form_modif" action="#" method="post">
				<fieldset>
					<div id="d_titre_form_haut">
						Administratif
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_nom">
								Nom :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_nom" name="nom" size="20" value="<?php echo $tUser['users_nom']; ?>"/>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_prenom">
								Pr&eacute;nom :
							</label>
						</span>
						<span class="c_form_droite">       
							<input type="text" id="id_prenom" name="prenom" size="20" value="<?php echo $tUser['users_prenom']; ?>"/>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_naissance">
								Date de naissance :
							</label>
						</span>
						<span class="c_form_droite">     
								Jour 
							<select name="jour" id="id_jour">
								<?php
								if ( $tUser['users_naissance'] !== NULL ) {
									// on recupere le jour le mois et l'annee
									$date = $tUser['users_naissance'];
																
									if ( $date != "" ) {
									    // séparation année, mois et jour avec pour référence "-"
									    list($year, $month, $day) = explode("-", $date);
									}	
									
								
									for ($i=1; $i<=31; $i++) {
										echo '<option ';
										if ( $i == $day ) {
											echo 'selected="selected" ';
										}
										echo 'VALUE="'.$i.'">';
										if ( $i < 10 ) {
											echo "0".$i;
										}else{
											echo $i;
										}
										echo '&nbsp;</option>';
									}	
								}else{
									for ($i=1; $i<=31; $i++) {
										echo '<option ';
										echo 'VALUE="'.$i.'">';
										if ( $i < 10 ) {
											echo "0".$i;
										}else{
											echo $i;
										}
										echo '&nbsp;</option>';
									}								
								}
								?>
							</select>
								&nbsp;&nbsp;Mois
							<select name="mois" id="id_mois">
								<?php			
								if ( $tUser['users_naissance'] !== NULL ) {					
									for ($i=1; $i<=12; $i++) {
										echo '<option ';
										if ( $i == $month ) {
											echo 'selected="selected" ';
										}
										echo 'VALUE="'.$i.'">';
										if ( $i < 10 ) {
											echo "0".$i;
										}else{
											echo $i;
										}
										echo '&nbsp;</option>';
									}	
								}else{				
									for ($i=1; $i<=12; $i++) {
										echo '<option ';
										echo 'VALUE="'.$i.'">';
										if ( $i < 10 ) {
											echo "0".$i;
										}else{
											echo $i;
										}
										echo '&nbsp;</option>';
									}								
								}	
								?>
							</select>
								&nbsp;&nbsp;Ann&eacute;e
							<select name="annee" id="id_annee">
								<?php							
								if ( $tUser['users_naissance'] !== NULL ) {		
									for ($i=2010; $i>=1920; $i--) {
										echo '<option ';
										if ( $i == $year ) {
											echo 'selected="selected" ';
										}
										echo 'VALUE="'.$i.'">';
										if ( $i < 10 ) {
											echo "0".$i;
										}else{
											echo $i;
										}
										echo '&nbsp;</option>';
									}	
								}else{					
									for ($i=2010; $i>=1920; $i--) {
										echo '<option ';
										echo 'VALUE="'.$i.'">';
										if ( $i < 10 ) {
											echo "0".$i;
										}else{
											echo $i;
										}
										echo '&nbsp;</option>';
									}								
								}	
								?>
							</select>

						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_tel1">
								T&eacute;l&eacute;phone 1* :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_tel1" name="tel1" size="12" maxlength="10" value="<?php echo $tUser['users_tel1']; ?>"/>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_tel2">
								T&eacute;l&eacute;phone 2* :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_tel2" name="tel2" size="12" maxlength="10" value="<?php echo $tUser['users_tel2']; ?>"/>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_email">
								E-Mail* :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_email" name="email" size="25" maxlength="60" value="<?php echo $tUser['users_email']; ?>"/>
						</span>
					</div>
					<div class="d_titre_form">
						Sportif
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_licence">
								Num&eacute;ro de licence :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_licence" name="licence" size="7" value="<?php echo $tUser['users_numLicence']; ?>"/>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_points">
								Nombre de points :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_points" name="points" size="4" value="<?php echo $tUser['users_points']; ?>"/>
						</span>
					</div>
					<div class="d_titre_form">
						Forum
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_pseudo">
								Pseudo :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_pseudo" name="pseudo" size="20" value="<?php echo $tUser['users_pseudo']; ?>"/>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_signature">
								Signature :
							</label>
						</span>
						<span class="c_form_droite">      
							<textarea type="text" id="id_signature" name="signature" cols="50" rows="3"><?php echo $tUser['users_signature']; ?></textarea>
						</span>
					</div>
					<div class="d_row" id="d_form_footer">
						<input type="reset" id="id_reset"  size="" value="Annuler" class="i_bouton" title="Annuler vos modifications"/> &nbsp;&nbsp;
						<input type="button" id="id_submit" onClick="modifPerso(<?php echo $tUser['users_id']; ?>)" value="Enregistrer" class="i_bouton" title="Enregistrer vos modifications"/> 
						<br/><br/>
						<a href="index.php?page=perso">
							<button type="button" class="i_bouton" title="Retour vers vos informations personnelles">
								Retour
							</button>
						</a>
					</div>
		        </fieldset>
			</form>
	<?php	
	}
	
	/**
	* Affiche le formulaire de modification de mot de passe
	*
	* @param integer $id identifiant de l'utilisateur
	* @return array
	*/

	function affPassword($id)
	{
		$tUser = $this -> GetUser($id);
		
	?>		
			<form id="form_password" name="form_password" action="./include/users-trt.php" method="post">
				<fieldset>
					<div id="d_titre_form_haut">
						Modification de votre mot de passe
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_pass_old">
								Mot de passe actuel :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="password" id="id_pass_old" name="pass_old" size="20"/>
						</span>
					</div>
					<div class="d_row" id="d_form_footer">
						<span class="c_form_gauche">
							<label for="id_pass_new1">
								Nouveau mot de passe* :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="password" id="id_pass_new1" name="pass_new1" size="20"/>
						</span>
					</div>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_pass_new2">
								Confirmation :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="password" id="id_pass_new2" name="pass_new2" size="20"/>
						</span>
					</div>
					<div class="d_row" id="d_form_footer">
						<input type="hidden" id="id_user_id"  name="user_id" size="0" value="<?php echo $tUser['users_id']; ?>"/>
						<input type="hidden" id="id_typeReq"  name="TypeReq" size="0" value="password"/>
						<input type="reset" id="id_reset"  size="" value="Annuler" class="i_bouton" title="Annuler"/> &nbsp;&nbsp;
						<input type="submit" id="id_submit" value="Enregistrer" class="i_bouton" title="Enregistrer votre nouveau mot de passe"/> 
						<br/><br/>
						<a href="index.php?page=perso">
							<button class="i_bouton"  title="Retour vers vos informations personnelles">
								Retour
							</button>
						</a>
					</div>
		        </fieldset>
			</form>
	<?php	
	}
	
	/**
	* Cryptage du mot de passe en MD5	
	* On ajoute au mot de passe une chaîne arbitraire appelée salt (composée ici de la concaténation d'un nombre aléatoire et du login, le tout encodé en md5).
	* Et on encode le tout avec sha1.
	*
	* @param string password en clair de l'utilisateur
	* @param string login  de l'utilisateur
	* @param integer id  de l'utilisateur
	*/

	function setPassword($password, $login, $id)
	{ 
		if ($password != "") {
			// Création du salt
			$salt = md5(rand(100000, 999999).$login); 				
			// Enregistrement du salt dans la BDD
			$this->updateSalt($salt, $id);
			// Enregistrement du mot de passe
			$newPass = sha1($salt.$password);
			$this->updatePass($id, $newPass);   	
		}
	}

	
	/**
	* Vérifie la validité du password
	*
	* @param string $password
	* @return boolean
	*/

	function checkPassword($password)
	{
		return ( sha1($this->getSalt().$password) == $this->getPassword() );
	}	
	
	/**
	* Met à jour la valeur du salt dans le base de donnees
	*
	* @param string $salt
	*/	
	function updateSalt($newSalt, $id)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " users_salt='".$newSalt."'";
		$query .= " WHERE users_id='".$id."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}
	
	
	
}