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

class ForumRep
{
	/**
	* Nom de la table des utilisateurs
	*
	* @var string
	*/
	var $table = "tt_forumRep"; 
	
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
	
	/**
	* id de la discussion
	*
	* @var integer
	*/
	var $msg_id = 0; 
	
	
	function ForumRep($id_msg)
	{
		$this->msg_id = $id_msg;
	} 

	/**
	* Construit la liste 
	*
	* @return void
	*/
	function BuildList()
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE forumRep_msg = ".$this->msg_id." ORDER BY forumRep_dateCreation ASC";
		
		$result = mysql_query($query);
		$cpt = 0;
		if ( $result){
			while ( $row = mysql_fetch_array($result) ) {
				$tMsg[$cpt]['forumRep_id'] = $row['forumRep_id'];
				$tMsg[$cpt]['forumRep_contenu'] = stripSlashes($row['forumRep_contenu']);
				$tMsg[$cpt]['forumRep_auteur'] = $row['forumRep_auteur'];
				$tMsg[$cpt]['forumRep_msg'] = $row['forumRep_msg'];
				$tMsg[$cpt]['forumRep_dateCreation'] = $row['forumRep_dateCreation'];
				$cpt++;
			}
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
	/**
	* Retourne un utilisateur
	*
	* @param integer $id identifiant du message
	*/
	function GetRep($id)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE forumRep_id=".$id;
		$result = mysql_query($query);
				
		$msg = mysql_fetch_array($result);
		include (RACINE."/include/bdd_close.php");
		
		return $msg;
	}
			
	function add($message, $auteur, $msg, $date)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " INSERT INTO ".$this->table;
		$query .= " ( forumRep_contenu , forumRep_auteur , forumRep_msg, forumRep_dateCreation)";
		$query .= " VALUES ( '".$message."', '".$auteur."', '".$msg."', '".$date."' )";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}
	function update($id, $message)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " forumRep_contenu='".$message."'";
		$query .= " WHERE forumRep_id='".$id."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}			
		

		/**
	* Affiche les reponses a ce sujet
	*
	* @param integer $msg_id du sujet 
	* @param integer $user_id de l'utilisateur connecte
	* @param integer $id du forum // a implementer plus tard
	* @return void
	*/
	function affRep($msg_id, $user_id, $tRep)
	{	
	
		$oUsers = new Users();
		foreach($tRep AS $cle => $valeur) { 
			// Recuperation des infos de l'auteur
			$tAuteur = $oUsers -> getUser($tRep[$cle]['forumRep_auteur']); 
			?>
			<div id="d_msg_header">
				<span id="s_msg_header_gauche">
					<?php echo $tAuteur['users_prenom']." ".$tAuteur['users_nom']; ?>
				</span>
				<span id="s_msg_header_droite">
					<?php
					$tDateTime = toDateTimeFr($tRep[$cle]['forumRep_dateCreation']);
					 echo "le ".$tDateTime['date']." &agrave; ".$tDateTime['heure']; 
					 ?>
				</span>
			</div>
			<div id="d_msg_content">
				<div id="d_msg_content_gauche">
					<?php 
					if ( $tAuteur['users_pseudo'] !== "" ) { ?>
						<span id="s_msg_pseudo">
								<br/>
								<?php echo '" '.$tAuteur['users_pseudo'].' "'; ?>
						</span>
					<?php
					}
					?>
				</div>
				<div id="d_msg_content_droite">
					<span id="s_msg_contenu">
						<?php 
							$oForumMsg = new forumMsg();
							echo $oForumMsg->interpretTag($tRep[$cle]['forumRep_contenu']); 
						?>
					</span>			
					<?php
					if ( $tAuteur['users_signature'] !== "" || $tAuteur['users_id'] == $user_id || $_SESSION['user_statut'] == 1) { ?>
						<div id="d_msg_signature">
							<?php 
								if ( $tAuteur['users_signature'] !== "" ) { ?>
									<span id="s_msg_signature">
										<?php echo $tAuteur['users_signature']; ?>
									</span>
								<?php 
								}	
						if (( $tAuteur['users_id'] == $user_id ) || ( $_SESSION['user_statut'] == 1 ) ) {
						?>
							<span id="s_msg_edit">
								<a class="a_edit" href="index.php?page=forum_edit_rep&id_msg=<?php echo $msg_id; ?>&id_rep=<?php echo $tRep[$cle]['forumRep_id']; ?>" title="Editer ce message">
									Editer
								</a>
							</span>
						<?php 
						} 
						?>
						</div>
					<?php 
					} 
					?>					
				</div>
			</div>
	<?php
		}
	}
	/**
	* Affiche le formulaire de reponse a un sujet
	*
	* @param integer $msg_id du sujet 
	* @param integer $user_id de l'auteur du sujet 
	* @param integer $id du forum // a implementer plsu tard
	* @return void
	*/
	function affFormRep($user_id, $msg_id)
	{	
		
	?>		
			<form id="form_rep" name="form_rep" action="./include/forum-trt.php" method="post">
				<fieldset>
					<div id="d_titre_form_haut">
						Participez &agrave cette discussion
					</div>
					<div id="d_titre_message">
						Contenu du message
					</div>
					<div id="d_mise_en_forme">
						Mise en forme du texte :
						<input type="button" id="btn_bold"  name="bold" size="0" value="Gras" onClick="addBalises('id_msg','bold')"/>
						<input type="button" id="btn_italic" name="italic" size="0" value="Italique" onClick="addBalises('id_msg','italic')"/>
						<input type="button" id="btn_link" name="link" size="0" value="Lien" onClick="addLink('id_msg')"/>
					</div>
					<div id="d_message_ext">
						<div id="d_message">
							<textarea  id="id_msg" name="msg" cols="67" rows="11"></textarea>
						</div>
						<div id="d_smiley">
							<br/>
							<span id="s_smiley_titre">Emotic&ocirc;nes</span><br/>
							<br/>
							<img alt="Ajouter le smiley : content" title="Content" onClick="addSmiley('id_msg', 'smile')" src="themes/ttBlue/pages/img/ico_smile.png"/>
							<img alt="Ajouter le smiley : Tr&egrave;s content" title="Tr&egrave;s content" title="Tire la langue" onClick="addSmiley('id_msg', 'bigsmile')" src="themes/ttBlue/pages/img/ico_bigsmile.png"/>
							<img alt="Ajouter le smiley : Triste" title="Triste" onClick="addSmiley('id_msg', 'sad')" src="themes/ttBlue/pages/img/ico_sad.png"/><br/>
							<img alt="Ajouter le smiley : Tire la langue" title="Tire la langue" onClick="addSmiley('id_msg', 'tongueout')" src="themes/ttBlue/pages/img/ico_tongueout.png"/>
							<img alt="Ajouter le smiley : Clin d'oeil" title="Clin d'oeil" onClick="addSmiley('id_msg', 'wink')" src="themes/ttBlue/pages/img/ico_wink.png"/>
							<img alt="Ajouter le smiley : Pleure" title="Pleure" onClick="addSmiley('id_msg', 'crying')" src="themes/ttBlue/pages/img/ico_crying.png"/><br/>
							<img alt="Ajouter le smiley : Surpris" title="Surpris" onClick="addSmiley('id_msg', 'surprised')" src="themes/ttBlue/pages/img/ico_surprised.png"/>
							<img alt="Ajouter le smiley : Timide" title="Timide" onClick="addSmiley('id_msg', 'blush')" src="themes/ttBlue/pages/img/ico_blush.png"/>
							<img alt="Ajouter le smiley : Innocent" title="Innocent" onClick="addSmiley('id_msg', 'wasntme')" src="themes/ttBlue/pages/img/ico_wasntme.png"/><br/>
							<img alt="Ajouter le smiley : Pouffe de rire" title="Pouffe de rire" onClick="addSmiley('id_msg', 'giggle')" src="themes/ttBlue/pages/img/ico_giggle.png"/>
							<img alt="Ajouter le smiley : Inquiet" title="Inquiet" onClick="addSmiley('id_msg', 'worried')" src="themes/ttBlue/pages/img/ico_worried.png"/>
							<img alt="Ajouter le smiley : En col&egrave;re" title="En col&egrave;re" onClick="addSmiley('id_msg', 'angry')" src="themes/ttBlue/pages/img/ico_angry.png"/><br/>
							<img alt="Ajouter le smiley : Tranquille" title="Tranquille" onClick="addSmiley('id_msg', 'cool')" src="themes/ttBlue/pages/img/ico_cool.png"/>
							<img alt="Ajouter le smiley : Rock'n'Roll !" title="Rock'n'Roll !" onClick="addSmiley('id_msg', 'rock')" src="themes/ttBlue/pages/img/ico_rock.png"/>
							<img alt="Ajouter le smiley : Diable" title="Diable" onClick="addSmiley('id_msg', 'devil')" src="themes/ttBlue/pages/img/ico_devil.png"/><br/>
						</div>
					</div>						
					<div class="d_row" id="d_form_footer">
						<input type="hidden" id="id_user_id"  name="user_id" size="0" value="<?php echo $user_id; ?>"/>
						<input type="hidden" id="id_msg_id"  name="msg_id" size="0" value="<?php echo $msg_id; ?>"/>
						<input type="hidden" id="id_typeReq"  name="TypeReq" size="0" value="newRep"/>
						<input type="reset" id="id_reset"  size="" value="Annuler" class="i_bouton" title="Annuler"/> &nbsp;&nbsp;
						<input type="submit" id="id_submit" value="Valider" class="i_bouton" title="Enregistrer votre nouveau message"/> 
						<br/><br/>
						<button onclick="javascript: document.location='index.php?page=forum_liste'" type="button" class="i_bouton" title="Retour vers la liste des discussions">
							Retour
						</button>
					</div>
		        </fieldset>
			</form>
	<?php	
	}
	/**
	* Affiche le formulaire de modification d'une reponse dans une discussion
	*
	* @param integer $msg_id  -  id de la discussion
	* @param integer $rep_id  -  id de la reponse
	* @param integer $id du forum // a implementer plsu tard
	* @return void
	*/
	function affFormModifRep($msg_id, $rep_id)
	{
		//Recuperation des infos du message
		$tRep = $this -> getRep($rep_id);
		
		//Suppression de l'affichage des <br/> pour l'utilisateur
		$contenu = preg_replace('#(<br />)#', '', $tRep['forumRep_contenu']);
		
		$contenu = stripSlashes($contenu);
	?>		
			<form id="form_sujet" name="form_sujet" action="./include/forum-trt.php" method="post">
				<fieldset>
					<div id="d_titre_form_haut">
						Modifier ce message
					</div>
					<div id="d_titre_message">
						Contenu du message
					</div>
					<div id="d_mise_en_forme">
						Mise en forme du texte :
						<input type="button" id="btn_bold"  name="bold" size="0" value="Gras" onClick="addBalises('id_msg','bold')"/>
						<input type="button" id="btn_italic" name="italic" size="0" value="Italique" onClick="addBalises('id_msg','italic')"/>
						<input type="button" id="btn_link" name="link" size="0" value="Lien" onClick="addLink('id_msg')"/>
					</div>
					<div id="d_message_ext">
						<div id="d_message">
							<textarea  id="id_msg" name="msg" cols="67" rows="11"><?php echo $contenu; ?></textarea>
						</div>
						<div id="d_smiley">
							<br/>
							<span id="s_smiley_titre">Emotic&ocirc;nes</span><br/>
							<br/>
							<img alt="Ajouter le smiley : content" title="Content" onClick="addSmiley('id_msg', 'smile')" src="themes/ttBlue/pages/img/ico_smile.png"/>
							<img alt="Ajouter le smiley : Tr&egrave;s content" title="Tr&egrave;s content" title="Tire la langue" onClick="addSmiley('id_msg', 'bigsmile')" src="themes/ttBlue/pages/img/ico_bigsmile.png"/>
							<img alt="Ajouter le smiley : Triste" title="Triste" onClick="addSmiley('id_msg', 'sad')" src="themes/ttBlue/pages/img/ico_sad.png"/><br/>
							<img alt="Ajouter le smiley : Tire la langue" title="Tire la langue" onClick="addSmiley('id_msg', 'tongueout')" src="themes/ttBlue/pages/img/ico_tongueout.png"/>
							<img alt="Ajouter le smiley : Clin d'oeil" title="Clin d'oeil" onClick="addSmiley('id_msg', 'wink')" src="themes/ttBlue/pages/img/ico_wink.png"/>
							<img alt="Ajouter le smiley : Pleure" title="Pleure" onClick="addSmiley('id_msg', 'crying')" src="themes/ttBlue/pages/img/ico_crying.png"/><br/>
							<img alt="Ajouter le smiley : Surpris" title="Surpris" onClick="addSmiley('id_msg', 'surprised')" src="themes/ttBlue/pages/img/ico_surprised.png"/>
							<img alt="Ajouter le smiley : Timide" title="Timide" onClick="addSmiley('id_msg', 'blush')" src="themes/ttBlue/pages/img/ico_blush.png"/>
							<img alt="Ajouter le smiley : Innocent" title="Innocent" onClick="addSmiley('id_msg', 'wasntme')" src="themes/ttBlue/pages/img/ico_wasntme.png"/><br/>
							<img alt="Ajouter le smiley : Pouffe de rire" title="Pouffe de rire" onClick="addSmiley('id_msg', 'giggle')" src="themes/ttBlue/pages/img/ico_giggle.png"/>
							<img alt="Ajouter le smiley : Inquiet" title="Inquiet" onClick="addSmiley('id_msg', 'worried')" src="themes/ttBlue/pages/img/ico_worried.png"/>
							<img alt="Ajouter le smiley : En col&egrave;re" title="En col&egrave;re" onClick="addSmiley('id_msg', 'angry')" src="themes/ttBlue/pages/img/ico_angry.png"/><br/>
							<img alt="Ajouter le smiley : Tranquille" title="Tranquille" onClick="addSmiley('id_msg', 'cool')" src="themes/ttBlue/pages/img/ico_cool.png"/>
							<img alt="Ajouter le smiley : Rock'n'Roll !" title="Rock'n'Roll !" onClick="addSmiley('id_msg', 'rock')" src="themes/ttBlue/pages/img/ico_rock.png"/>
							<img alt="Ajouter le smiley : Diable" title="Diable" onClick="addSmiley('id_msg', 'devil')" src="themes/ttBlue/pages/img/ico_devil.png"/><br/>
						</div>
					</div>
						
					<div class="d_row" id="d_form_footer">
						<input type="hidden" id="id_rep_id"  name="rep_id" size="0" value="<?php echo $rep_id; ?>"/>
						<input type="hidden" id="id_msg_id"  name="msg_id" size="0" value="<?php echo $msg_id; ?>"/>
						<input type="hidden" id="id_typeReq"  name="TypeReq" size="0" value="modifRep"/>
						<input type="reset" id="id_reset"  size="" value="Annuler" class="i_bouton" title="Annuler"/> &nbsp;&nbsp;
						<input type="submit" id="id_submit" value="Valider" class="i_bouton" title="Enregistrer vos modifocations"/> 
						<br/><br/>
						<button onclick="javascript: document.location='index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>'" type="button" class="i_bouton"  title="Retour vers la discussion">
							Retour &agrave; la discussion
						</button>
					</div>
		        </fieldset>
			</form>
	<?php	
	}
}
?>