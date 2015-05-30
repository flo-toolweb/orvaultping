<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe Messages ( discussions )*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if (!defined('COMMON') ) { 
	include('common.php'); 
}

class ForumMsg
{
	/**
	* Nom de la table des messages ( discussions )
	*
	* @var string
	*/
	var $table = "tt_forumMsg"; 
	
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
	
	
	function ForumMsg()
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
		$query  = " SELECT * FROM ".$this->table." ORDER BY forumMsg_dateDerRep DESC";
		
		$result = mysql_query($query);
		$cpt = 0;
		if ( $result){
			while ( $row = mysql_fetch_array($result) ) {
				$tMsg[$cpt]['forumMsg_id'] = $row['forumMsg_id'];
				$tMsg[$cpt]['forumMsg_sujet'] = stripSlashes($row['forumMsg_sujet']);
				$tMsg[$cpt]['forumMsg_contenu'] = stripSlashes($row['forumMsg_contenu']);
				$tMsg[$cpt]['forumMsg_auteur'] = $row['forumMsg_auteur'];
				$tMsg[$cpt]['forumMsg_dateCreation'] = $row['forumMsg_dateCreation'];
				$tMsg[$cpt]['forumMsg_auteurDerRep'] = $row['forumMsg_auteurDerRep'];
				$tMsg[$cpt]['forumMsg_dateDerRep'] = $row['forumMsg_dateDerRep'];
				$tMsg[$cpt]['forumMsg_nbRep'] = $row['forumMsg_nbRep'];
				$tMsg[$cpt]['forumMsg_nbVue'] = $row['forumMsg_nbVue'];
				$tMsg[$cpt]['forumMsg_isNews'] = $row['forumMsg_isNews'];
				$tMsg[$cpt]['forumMsg_isPostit'] = $row['forumMsg_isPostit'];
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
	* Retourne un message
	*
	* @param integer $id identifiant du message
	*/
	function GetMsg($id)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE forumMsg_id=".$id;
		$result = mysql_query($query);
				
		$msg = mysql_fetch_array($result);
		include (RACINE."/include/bdd_close.php");
		
		$msg['forumMsg_sujet'] = stripSlashes($msg['forumMsg_sujet']);
		$msg['forumMsg_contenu'] = stripSlashes($msg['forumMsg_contenu']);
		
		return $msg;
	}
			
	function add($sujet, $message, $auteur, $date, $is_news=0, $is_postit)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " INSERT INTO ".$this->table;
		$query .= " ( forumMsg_sujet, forumMsg_contenu , forumMsg_auteur , forumMsg_dateCreation, forumMsg_auteurDerRep, forumMsg_dateDerRep, forumMsg_isNews, forumMsg_ispostit )";
		$query .= " VALUES ( '".$sujet."', '".$message."', '".$auteur."', '".$date."', '".$auteur."', '".$date."', '".$is_news."', '".$is_postit."' )";
				
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}
	
	function update($id, $sujet, $message, $postit)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " forumMsg_sujet='".$sujet."',";
		$query .= " forumMsg_contenu='".$message."',";
		$query .= " forumMsg_isPostit='".$postit."'";
		$query .= " WHERE forumMsg_id='".$id."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}		
	
	function updateVue($id)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " forumMsg_nbVue = forumMsg_nbVue+1";
		$query .= " WHERE forumMsg_id='".$id."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}		
	function updateNewRep($id_msg, $id_user, $date)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " forumMsg_nbRep = forumMsg_nbRep+1,";
		$query .= " forumMsg_auteurDerRep = ".$id_user.",";
		$query .= " forumMsg_dateDerRep = '".$date."'";
		$query .= " WHERE forumMsg_id='".$id_msg."'";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}		
	
	function deleteMsg($id) {
		include (RACINE."/include/bdd_connec.php");
		$query  = " DELETE FROM ".$this->table;
		$query .= " WHERE forumMsg_id = ".$id;
		$result = mysql_query($query);
		include (RACINE."/include/bdd_close.php");
	}

	/**
	* Affiche la liste des messages d'un forum
	*
	* @param integer $user_id -> id de l'utilisateur connecte
	* @param integer $pageForum -> numero de la page du forum // pas besoin 
	* @param integer $id du forum // a implementer plus tard
	* @return void
	*/
	function affList($user_id)
	{
		// Mise a jour de la liste
		$this->BuildList();
		$list = $this->GetList();
		
		$listPostit = $this->GetList();
		
		if ( count($list) == 0 ) {
			echo "Aucun message enregistr&eacute;";
		}else{
			// Variable nombre d'enreg par page
			$pageForum = 1;
			if (isset($_GET['pageForum'])) {
				$pageForum = $_GET['pageForum'];
			}
			$limite = 20;
			$debut = ($pageForum-1)*$limite;
			$nb_msg = count($list);
			
			if ( $nb_msg > $limite ) {
				$list = array_slice ($list,$debut,$limite);
			}
		
		
		?>
					
			<div class="d_liste_header">
			<?php echo $nb_msg;?>&nbsp;sujets&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp; &nbsp;
			<?php
				// AFFICHAGE PAGE PAR PAGE
					if ( ($nb_msg%$limite) === 0 ) {
						$nbPages = (int)($nb_msg/$limite);							
					} else {
						$nbPages = (int)($nb_msg/$limite);	
						$nbPages++;
					}
					if ( $pageForum == 3 ) {?>
						<a href="index.php?page=forum_liste&pageForum=1" title="Page 1">
							<span class="s_num_page">
								1
							</span>
						</a>&nbsp;
					<?php						
					}
					if ( $pageForum > 3 ) {?>
						<a href="index.php?page=forum_liste&pageForum=1" title="Page 1">
							<span class="s_num_page">
								1
							</span>
						</a>&nbsp;&nbsp;...&nbsp;
					<?php						
					}
					
					if ( $pageForum > 1 ) { ?>
						<a href="index.php?page=forum_liste&pageForum=<?php echo $pageForum-1; ?>" title="Page <?php echo $pageForum-1; ?>">
							<span class="s_num_page">
								<?php echo $pageForum-1; ?>
							</span>
						</a>&nbsp;
					<?php		
					} ?>
					<span class="s_num_page" id="s_num_page_act">
						<?php echo $pageForum; ?>
					</span>&nbsp;
					<?php
					if ( $nbPages > $pageForum ) { ?>
						<a href="index.php?page=forum_liste&pageForum=<?php echo $pageForum+1; ?>" title="Page <?php echo $pageForum+1; ?>">
							<span class="s_num_page">
								<?php echo $pageForum+1; ?>
							</span>
						</a>&nbsp;
					<?php
					} 
					if ( $nbPages == $pageForum+2 ) {?>
						<a href="index.php?page=forum_liste&pageForum=<?php echo $nbPages; ?>" title="Page <?php echo $nbPages; ?>">
							<span class="s_num_page">
								<?php echo $nbPages; ?>
							</span>
						</a>&nbsp;
					<?php						
					}
					if ( $nbPages > $pageForum+2 ) {?>
						...&nbsp;
						<a href="index.php?page=forum_liste&pageForum=<?php echo $nbPages; ?>" title="Page <?php echo $nbPages; ?>">
							<span class="s_num_page">
								<?php echo $nbPages; ?>
							</span>
						</a>&nbsp;
					<?php						
					}
					// FIN AFFICHAGE PAGE PAR PAGE
					?>
					&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;&nbsp;page <?php echo $pageForum; ?> sur <?php echo $nbPages; ?>
			</div>
			<!-- fin div liste_header -->
			<table border="1" rules="all" id="t_liste">
			    <thead>
					<tr>
						<th>Sujet</th>
						<th>R&eacute;ponses</th>
						<th>Vus</th>
						<th>Dernier message</th>
					</tr>
			    </thead>
			    <tbody>
				<?php
				/* *** Affichage de la liste des postits */
				$oUsers = new Users();
				
				// message vu ou non
				$vu = false;
				
				// Liste des discussions
				foreach($listPostit AS $cle => $valeur) { 
					// verification si postit
					if ($listPostit[$cle]['forumMsg_isPostit'] == 1) {
						// Recuperation des infos de l'auteur
						$tAuteur = $oUsers -> getUser($listPostit[$cle]['forumMsg_auteur']); 
						// Recuperation des infos de l'auteur de la derniere reponse
						$tAuteurDerRep = $oUsers -> getUser($listPostit[$cle]['forumMsg_auteurDerRep']);
						// Recuperation de la date du dernier message lu par l'utilisateur connecte
						$tUser = $oUsers -> getUser($user_id);
					
						// conversion de la date datetime de mysql
						$dateCreation = $listPostit[$cle]['forumMsg_dateCreation'];
						$tDateCreation = toDateTimeFr($dateCreation);
						$dateDerRep = $listPostit[$cle]['forumMsg_dateDerRep'];
						$tDateDerRep = toDateTimeFr($dateDerRep);
						
						// Comparaison des dates
						if ( $tUser['users_lastView'] >= $dateDerRep ) {
							// Message deja lu
							$vu = true;
						}else{
							$vu = false;
						}
						
						if ( ($cle+1)%2 == 0 ) {
							if ($vu) echo '<tr class="tr_liste1">';
							else echo '<tr class="tr_liste1 tr_liste1_new">';
						}else{
							if ($vu) echo '<tr class="tr_liste2">';		
							else echo '<tr class="tr_liste2 tr_liste2_new">';	
						}?>					
						<td class="td_sujet">
							<?php if ($listPostit[$cle]['forumMsg_isPostit'] == 1) { ?>
								<img src="./themes/ttBlue/pages/img/forum_punaise.png" alt="Post it" class="img_postit"/>
							<?php } ?>
							<a href="index.php?page=forum_msg&id_msg=<?php echo $listPostit[$cle]['forumMsg_id']; ?>" title="Voir cette discussion">
								<span class="s_sujet"><b><?php echo $listPostit[$cle]['forumMsg_sujet']; ?></b></span><br/>	
							</a>
							<div class="d_footer_sujet">
								<span class="s_footer_sujet_auteur">
									de
									<span class="s_auteurInt">
										<a href="index.php?page=joueurs_fiche&id_user=<?php echo $tAuteur['users_id']; ?>" title="Voir la fiche" >
										<?php echo $tAuteur['users_prenom']." ".$tAuteur['users_nom']; ?></a>
									</span>&nbsp;
									le <?php echo $tDateCreation['date']." &agrave ".$tDateCreation['heure']; ?>
								</span>		
								<?php 
								if (( $tAuteur['users_id'] == $user_id ) || ( $_SESSION['user_statut'] == 1 ) ) {
								?>
									<span class="s_footer_sujet_edit">
										<a class="a_edit" href="index.php?page=forum_edit_msg&id_msg=<?php echo $listPostit[$cle]['forumMsg_id']; ?>" title="Editer ce message">
											Editer
										</a>		
										<?php 										
										if (( $_SESSION['user_statut'] == 1 ) ) {
										?>
											<a class="a_edit a_delete" href="index.php?page=forum_liste&delete_msg=<?php echo $listPostit[$cle]['forumMsg_id']; ?>" onclick="return confirm('Supprimer cette discussion ?');" title="Supprimer cette discussion">
												x
											</a>
										<?php 
										}
										?>
									</span>	
								<?php 
								}
								?>
							</div>				
						</td>
						<td class="td_rep"><?php echo $listPostit[$cle]['forumMsg_nbRep']; ?></td>
						<td class="td_vus"><?php echo $listPostit[$cle]['forumMsg_nbVue']; ?></td>
						<td class="td_der_rep">		
							<span class="s_auteur">
								de 
								<span class="s_auteurInt">
									<a href="index.php?page=joueurs_fiche&id_user=<?php echo $tAuteurDerRep['users_id']; ?>" title="Voir la fiche" >
									<?php echo $tAuteurDerRep['users_prenom']." ".$tAuteurDerRep['users_nom']; ?>
									</a>
								</span><br/>
								le <?php echo $tDateDerRep['date']." &agrave ".$tDateDerRep['heure']; ?>
							</span>	
						</td>
						</tr>					
				<?php	
					}
				}
				/* *** Fin liste des postits *** */
				?>   

				<?php
				/* *** Affichage de la liste des discussions */
				
				// message lu ou non
				$vu = false;
				
				// Liste des discussions
				foreach($list AS $cle => $valeur) { 
					// verification si postit
					if ($list[$cle]['forumMsg_isPostit'] == 0) {
						// Recuperation des infos de l'auteur
						$tAuteur = $oUsers -> getUser($list[$cle]['forumMsg_auteur']); 
						// Recuperation des infos de l'auteur de la derniere reponse
						$tAuteurDerRep = $oUsers -> getUser($list[$cle]['forumMsg_auteurDerRep']);
						// Recuperation de la date du dernier message lu par l'utilisateur connecte
						$tUser = $oUsers -> getUser($user_id);
					
						// conversion de la date datetime de mysql
						$dateCreation = $list[$cle]['forumMsg_dateCreation'];
						$tDateCreation = toDateTimeFr($dateCreation);
						$dateDerRep = $list[$cle]['forumMsg_dateDerRep'];
						$tDateDerRep = toDateTimeFr($dateDerRep);
						
						// Comparaison des dates
						if ( $tUser['users_lastView'] >= $dateDerRep ) {
							// Message deja lu
							$vu = true;
						}else{
							$vu = false;
						}
						
						if ( ($cle+1)%2 == 0 ) {
							if ($vu) echo '<tr class="tr_liste1">';
							else echo '<tr class="tr_liste1 tr_liste1_new">';
						}else{
							if ($vu) echo '<tr class="tr_liste2">';		
							else echo '<tr class="tr_liste2 tr_liste2_new">';	
						}?>					
						<td class="td_sujet">
							<a href="index.php?page=forum_msg&id_msg=<?php echo $list[$cle]['forumMsg_id']; ?>" title="Voir cette discussion">
								<span class="s_sujet"><b><?php echo $list[$cle]['forumMsg_sujet']; ?></b></span><br/>	
							</a>
							<div class="d_footer_sujet">
								<span class="s_footer_sujet_auteur">
									de
									<span class="s_auteurInt"> 
										<a href="index.php?page=joueurs_fiche&id_user=<?php echo $tAuteur['users_id']; ?>" title="Voir la fiche" >
										<?php echo $tAuteur['users_prenom']." ".$tAuteur['users_nom']; ?></a>
									</span>&nbsp;
									le <?php echo $tDateCreation['date']." &agrave ".$tDateCreation['heure']; ?>
								</span>	
								<?php 
								if (( $tAuteur['users_id'] == $user_id ) || ( $_SESSION['user_statut'] == 1 ) ) {
								?>
									<span class="s_footer_sujet_edit">
										<a class="a_edit" href="index.php?page=forum_edit_msg&id_msg=<?php echo $listPostit[$cle]['forumMsg_id']; ?>" title="Editer ce message">
											Editer
										</a>		
										<?php 										
										if (( $_SESSION['user_statut'] == 1 ) ) {
										?>
											<a class="a_edit a_delete" href="index.php?page=forum_liste&delete_msg=<?php echo $listPostit[$cle]['forumMsg_id']; ?>" onclick="return confirm('Supprimer cette discussion ?');" title="Supprimer cette discussion">
												x
											</a>
										<?php 
										}
										?>
									</span>	
								<?php 
								}
								?>
							</div>				
						</td>
						<td class="td_rep"><?php echo $list[$cle]['forumMsg_nbRep']; ?></td>
						<td class="td_vus"><?php echo $list[$cle]['forumMsg_nbVue']; ?></td>
						<td class="td_der_rep">		
							<span class="s_auteur">
								de 
								<span class="s_auteurInt">
									<a href="index.php?page=joueurs_fiche&id_user=<?php echo $tAuteurDerRep['users_id']; ?>" title="Voir la fiche" >
									<?php echo $tAuteurDerRep['users_prenom']." ".$tAuteurDerRep['users_nom']; ?>
									</a>
								</span><br/>
								le <?php echo $tDateDerRep['date']." &agrave ".$tDateDerRep['heure']; ?>
							</span>	
						</td>
						</tr>					
				<?php	
					}
				}
				/* *** Fin liste des discussions *** */
				?>    
			</tbody>
		</table><div class="d_liste_header">
			<?php echo $nb_msg;?>&nbsp;sujets&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp; &nbsp;
			<?php
				// AFFICHAGE PAGE PAR PAGE
					if ( ($nb_msg%$limite) === 0 ) {
						$nbPages = (int)($nb_msg/$limite);							
					} else {
						$nbPages = (int)($nb_msg/$limite);	
						$nbPages++;
					}
					if ( $pageForum == 3 ) {?>
						<a href="index.php?page=forum_liste&pageForum=1" title="Page 1">
							<span class="s_num_page">
								1
							</span>
						</a>&nbsp;
					<?php						
					}
					if ( $pageForum > 3 ) {?>
						<a href="index.php?page=forum_liste&pageForum=1" title="Page 1">
							<span class="s_num_page">
								1
							</span>
						</a>&nbsp;&nbsp;...&nbsp;
					<?php						
					}
					
					if ( $pageForum > 1 ) { ?>
						<a href="index.php?page=forum_liste&pageForum=<?php echo $pageForum-1; ?>" title="Page <?php echo $pageForum-1; ?>">
							<span class="s_num_page">
								<?php echo $pageForum-1; ?>
							</span>
						</a>&nbsp;
					<?php		
					} ?>
					<span class="s_num_page" id="s_num_page_act">
						<?php echo $pageForum; ?>
					</span>&nbsp;
					<?php
					if ( $nbPages > $pageForum ) { ?>
						<a href="index.php?page=forum_liste&pageForum=<?php echo $pageForum+1; ?>" title="Page <?php echo $pageForum+1; ?>">
							<span class="s_num_page">
								<?php echo $pageForum+1; ?>
							</span>
						</a>&nbsp;
					<?php
					} 
					if ( $nbPages == $pageForum+2 ) {?>
						<a href="index.php?page=forum_liste&pageForum=<?php echo $nbPages; ?>" title="Page <?php echo $nbPages; ?>">
							<span class="s_num_page">
								<?php echo $nbPages; ?>
							</span>
						</a>&nbsp
					<?php						
					}
					if ( $nbPages > $pageForum+2 ) {?>
						...&nbsp;
						<a href="index.php?page=forum_liste&pageForum=<?php echo $nbPages; ?>" title="Page <?php echo $nbPages; ?>">
							<span class="s_num_page">
								<?php echo $nbPages; ?>
							</span>
						</a>&nbsp
					<?php						
					}
					// FIN AFFICHAGE PAGE PAR PAGE
					?>
					&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;&nbsp;page <?php echo $pageForum; ?> sur <?php echo $nbPages; ?>
			</div>
			<!-- fin div liste_header -->
		<?php
		}
	}
	
	/**
	* Affiche le formulaire d'ajout de sujet
	*
	* @param integer $id du forum // a implementer plsu tard
	* @return void
	*/
	function affFormSujet($user_id)
	{
		
		
	?>		
			<form id="form_sujet" name="form_sujet" action="./include/forum-trt.php" method="post">
				<fieldset>
					<div id="d_titre_form_haut">
						Nouveau message sur ce forum
					</div>
					<div class="d_form_sujet">
						<label for="id_sujet">
							Sujet :
						</label>     
						<input type="text" id="id_sujet" name="sujet" size="58"/>
						<?php
						// Post it
						if (( $_SESSION['user_statut'] == 1 ) || ( $_SESSION['user_statut'] == 2 )){ ?>
						<span>
							Post-it :&nbsp;&nbsp;&nbsp;
						</span>
						<input type="checkbox" id="id_postit" name="postit"/>
						<?php }?>
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
						<input type="hidden" id="id_typeReq"  name="TypeReq" size="0" value="newMsg"/>
						<input type="reset" id="id_reset"  size="" value="Annuler" class="i_bouton" title="Annuler"/> &nbsp;&nbsp;
						<input type="submit" id="id_submit" value="Valider" class="i_bouton" title="Enregistrer votre nouveau message"/> 
						<br/><br/>
						<button onclick="javascript: document.location='index.php?page=forum_liste'" type="button" class="i_bouton"  title="Retour vers la liste des discussions">
							Retour
						</button>
					</div>
		        </fieldset>
			</form>
			
	<?php	
	}
	/**
	* Affiche le formulaire de modification d'un sujet
	*
	* @param integer $id du forum // a implementer plsu tard
	* @return void
	*/
	function affFormModifSujet($msg_id)
	{
		//Recuperation des infos du message
		$tMsg = $this -> getMsg($msg_id);
		
		//Suppression de l'affichage des <br/> pour l'utilisateur
		$tMsg['forumMsg_contenu'] = preg_replace('#(<br />)#', '', $tMsg['forumMsg_contenu']);
	?>		
			<form id="form_sujet" name="form_sujet" action="./include/forum-trt.php" method="post">
				<fieldset>
					<div id="d_titre_form_haut">
						Modifier cette discussion
					</div>
					<div class="d_form_sujet">
						<label for="id_sujet">
							Sujet :
						</label>     
						<input type="text" id="id_sujet" name="sujet" size="58" value="<?php echo $tMsg['forumMsg_sujet']; ?>"/>
						<?php
						// Post it
						if (( $_SESSION['user_statut'] == 1 ) || ( $_SESSION['user_statut'] == 2 )){ ?>
						<span>
							Post-it :&nbsp;&nbsp;&nbsp;
						</span>
						<input type="checkbox" id="id_postit" name="postit"
							<?php if ($tMsg['forumMsg_isPostit'] == 1) { ?>
							checked="checked"
							<?php } ?>
						/>
						<?php }?>
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
							<textarea  id="id_msg" name="msg" cols="67" rows="11"><?php echo $tMsg['forumMsg_contenu']; ?></textarea>
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
						<input type="hidden" id="id_msg_id"  name="msg_id" size="0" value="<?php echo $msg_id; ?>"/>
						<input type="hidden" id="id_typeReq"  name="TypeReq" size="0" value="modifMsg"/>
						<input type="reset" id="id_reset"  size="" value="Annuler" class="i_bouton" title="Annuler"/> &nbsp;&nbsp;
						<input type="submit" id="id_submit" value="Valider" class="i_bouton" title="Enregistrer vos modifocations"/> 
						<br/><br/>
						<button onclick="javascript: document.location='index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>'" type="button" class="i_bouton"  title="Retour vers la liste des discussions">
							Retour &agrave; la discussion
						</button>
					</div>
		        </fieldset>
			</form>
	<?php	
	}
		/**
	* Affiche le sujet de la discussion et ses reponses
	*
	* @param integer $msg_id du sujet 
	* @param integer $user_id de l'usilisateur connecté
	* @param integer $id du forum // a implementer plus tard
	* @return void
	*/
	function affDiscussion($msg_id, $user_id)
	{	
		$oForumRep = new forumRep($msg_id);
		$tRep = $oForumRep -> getList();
		// Variable nombre d'enreg par page
		$pageForum = 1;
		if (isset($_GET['pageForum'])) {
			$pageForum = $_GET['pageForum'];
		}
		$limite = 9;
		$debut = ($pageForum-1)*$limite;
		// nombre de message affiche -> nombre de reponses + le sujet
		$nb_msg_aff = count($tRep)+1;
		$nb_msg = count($tRep);
		
		if ( $nb_msg > $limite ) {
			$tRep = array_slice ($tRep,$debut,$limite);		
		}
	?>
		<div class="d_liste_header">
			<?php echo $nb_msg_aff;?>
			&nbsp;message(s)&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
			<?php
				// AFFICHAGE PAGE PAR PAGE
					if ( ($nb_msg%$limite) === 0 ) {
						$nbPages = (int)($nb_msg/$limite);							
					} else {
						$nbPages = (int)($nb_msg/$limite);	
						$nbPages++;
					}
					if ( $pageForum == 3 ) {?>
						<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=1" title="Page 1">
							<span class="s_num_page">
								1
							</span>
						</a>&nbsp;
					<?php						
					}
					if ( $pageForum > 3 ) {?>
						<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=1" title="Page 1">
							<span class="s_num_page">
								1
							</span>
						</a>&nbsp;&nbsp;...&nbsp;
					<?php						
					}
					
					if ( $pageForum > 1 ) { ?>
						<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=<?php echo $pageForum-1; ?>" title="Page <?php echo $pageForum-1; ?>">
							<span class="s_num_page">
								<?php echo $pageForum-1; ?>
							</span>
						</a>&nbsp;
					<?php		
					} ?>
					<span class="s_num_page" id="s_num_page_act">
						<?php echo $pageForum; ?>
					</span>&nbsp;
					<?php
					if ( $nbPages > $pageForum ) { ?>
						<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=<?php echo $pageForum+1; ?>" title="Page <?php echo $pageForum+1; ?>">
							<span class="s_num_page">
								<?php echo $pageForum+1; ?>
							</span>
						</a>&nbsp;
					<?php
					} 
					if ( $nbPages == $pageForum+2 ) {?>
						<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=<?php echo $nbPages; ?>" title="Page <?php echo $nbPages; ?>">
							<span class="s_num_page">
								<?php echo $nbPages ?>
							</span>
						</a>&nbsp
					<?php						
					}
					if ( $nbPages > $pageForum+2 ) {?>
						...&nbsp;
						<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=<?php echo $nbPages; ?>" title="Page <?php echo $nbPages; ?>">
							<span class="s_num_page">
								<?php echo $nbPages ?>
							</span>
						</a>&nbsp
					<?php						
					}
					// FIN AFFICHAGE PAGE PAR PAGE
					if ( $nbPages === 0 ) { $nbPages++; }
					?>
					&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;&nbsp;page <?php echo $pageForum; ?> sur <?php echo $nbPages; ?>
		</div>
		<!-- fin div liste_header -->
		<?php
		// Affichage du sujet
		$this -> affMsg($msg_id, $user_id);
		?>
		<div id="d_sep_msg_rep">
		<?php
		// Si premiere page alors on afiche les points de suspensions
		if ( $debut !== 0 ) { ?>
			<img src="themes/ttBlue/pages/img/points_forum.png"/>
		<?php
		} ?>
		</div>
		<?php
		$oForumRep -> affRep($msg_id, $user_id, $tRep);
		
		if ( $nb_msg > 9 ) { ?>
			
			<div class="d_liste_header">
				<?php echo $nb_msg_aff;?>
				&nbsp;message(s)&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
				<?php
					// AFFICHAGE PAGE PAR PAGE
						if ( ($nb_msg%$limite) === 0 ) {
							$nbPages = (int)($nb_msg/$limite);							
						} else {
							$nbPages = (int)($nb_msg/$limite);	
							$nbPages++;
						}
						if ( $pageForum == 3 ) {?>
							<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=1" title="Page 1">
								<span class="s_num_page">
									1
								</span>
							</a>&nbsp;
						<?php						
						}
						if ( $pageForum > 3 ) {?>
							<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=1" title="Page 1">
								<span class="s_num_page">
									1
								</span>
							</a>&nbsp;&nbsp;...&nbsp;
						<?php						
						}
						
						if ( $pageForum > 1 ) { ?>
							<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=<?php echo $pageForum-1; ?>" title="Page <?php echo $pageForum-1; ?>">
								<span class="s_num_page">
									<?php echo $pageForum-1; ?>
								</span>
							</a>&nbsp;
						<?php		
						} ?>
						<span class="s_num_page" id="s_num_page_act">
							<?php echo $pageForum; ?>
						</span>&nbsp;
						<?php
						if ( $nbPages > $pageForum ) { ?>
							<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=<?php echo $pageForum+1; ?>" title="Page <?php echo $pageForum+1; ?>">
								<span class="s_num_page">
									<?php echo $pageForum+1; ?>
								</span>
							</a>&nbsp;
						<?php
						} 
						if ( $nbPages == $pageForum+2 ) {?>
							<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=<?php echo $nbPages; ?>" title="Page <?php echo $nbPages; ?>">
								<span class="s_num_page">
									<?php echo $nbPages ?>
								</span>
							</a>&nbsp
						<?php						
						}
						if ( $nbPages > $pageForum+2 ) {?>
							...&nbsp;
							<a href="index.php?page=forum_msg&id_msg=<?php echo $msg_id; ?>&pageForum=<?php echo $nbPages; ?>" title="Page <?php echo $nbPages; ?>">
								<span class="s_num_page">
									<?php echo $nbPages ?>
								</span>
							</a>&nbsp
						<?php						
						}
						// FIN AFFICHAGE PAGE PAR PAGE
						if ( $nbPages === 0 ) { $nbPages++; }
						?>
						&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;&nbsp;page <?php echo $pageForum; ?> sur <?php echo $nbPages; ?>
			</div>
		<!-- fin div liste_header -->
		<?php
		}
	}
		/**
	* Affiche le sujet
	*
	* @param integer $msg_id du sujet 
	* @param integer $user_id  //  id de l'utilisateur connecté
	* @param integer $id du forum // a implementer plus tard
	* @return void
	*/
	function affMsg($msg_id, $user_id)
	{	
		$tMsg = $this -> getMsg($msg_id); 
		
		// Recuperation des infos de l'auteur
		$oUsers = new Users();
		$tAuteur = $oUsers -> getUser($tMsg['forumMsg_auteur']); 
		
		// ** Mise a jour de users_lastView **
		// Recuperation de la date du dernier message lu par l'utilisateur connecte
		$tUser = $oUsers -> GetUser($user_id);
		// Comparaison des deux dates		
		if ( $tMsg['forumMsg_dateDerRep'] >$tUser['users_lastView'] ) {
			// Si la date de la discussion est plus recente que celle dans la bdd -> Mise a jour 
			$oUsers -> updateLastView($_SESSION['user_id'], $tMsg['forumMsg_dateDerRep']);
		}		
		
		?>
		<div id="d_msg_titre">	
			<?php echo $tMsg['forumMsg_sujet']; ?>
		</div>
		<div id="d_msg_header">
			<span id="s_msg_header_gauche">
				<?php echo $tAuteur['users_prenom']." ".$tAuteur['users_nom']; ?>
			</span>
			<span id="s_msg_header_droite">
				<?php
				$tDateTime = toDateTimeFr($tMsg['forumMsg_dateCreation']);
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
					<?php echo $this->interpretTag($tMsg['forumMsg_contenu']); ?>
				</span>
				<?php
				if ( $tAuteur['users_signature'] !== "" || $tAuteur['users_id'] == $user_id ) { ?>
					<div id="d_msg_signature">
						<?php 
						if ( $tAuteur['users_signature'] !== "" ) { ?>
							<span id="s_msg_signature">
								<?php echo $tAuteur['users_signature']; ?>
							</span>
								
						<?php 
						}
						if ( $tAuteur['users_id'] == $user_id ) {
						?>
							<span id="s_msg_edit">
								<a class="a_edit" href="index.php?page=forum_edit_msg&id_msg=<?php echo $msg_id; ?>&" title="Editer ce message">
									<img src="./themes/ttBlue/pages/img/spacer.gif"/>&nbsp;&nbsp;
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
		/**
	* Renvoi le texte du message apres interpretation des balises wiki et smileys
	*
	* @param string $texte // texte du message
	* @return string
	*/
	function interpretTag($texte)
	{	
		// gras
		/*
		$expr_reg = '/\[b\](.*)\[\/b\]/i';
		$texte = preg_replace_callback($expr_reg,
	        create_function(
	            // Les guillemets simples sont très importants ici
	            // ou bien il faut protéger les caractères $ avec \$
	            '$matches',
	            'return "<span class=\"s_bold\">$matches[1]</span>";'
	         ),
			$texte);*/
			
		//$masque = "\[b\]([^\[]*)\[/b\]";	
		//$texte = preg_replace($masque,'<span class="s_bold">\\0</span>',$texte);
			
		$texte = str_replace("[b]",'<span class="s_bold">',$texte);
		$texte = str_replace("[/b]",'</span>',$texte);
		
		
		// Italic		
		$texte = str_replace("[i]",'<span class="s_italic">',$texte);
		$texte = str_replace("[/i]",'</span>',$texte);
		
		// lien 
		$masque = "\[lien\]([^\[]*)\[/lien\]";
		$texte = eregi_replace($masque,'<a href="\\1" target="_blank">\\1</a>',$texte);
		//$masque = "#\[lien\]([[:alnum:]]+)://([^<[:space:]]*)([[:alnum:]#?/&=])\[/lien\]#s";
		//$texte = ereg_replace($masque, "<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>", $texte);
		
		$masque = "\[lien=([^\[]*)\]([^\[]*)\[/lien\]";
		$texte = eregi_replace($masque,'<a href="\\1" target="_blank">\\2</a>',$texte);
		//$masque = "\[lien=([[:alnum:]]+)://([^<[:space:]]*)([[:alnum:]#?/&=])\]([[:alnum:]|[:punct:]#?/&= ]*)\[/lien\]";		
		//$texte = ereg_replace($masque, '<a href="\\1://\\2\\3" target="_blank">\\4</a>', $texte);
		
		//Smileys
		$texte = str_replace(":langue:",'<img src="themes/ttBlue/pages/img/ico_tongueout.png" class="emoticone" class="emoticone"/>',$texte);
		$texte = str_replace(":pleure:",'<img src="themes/ttBlue/pages/img/ico_crying.png" class="emoticone" class="emoticone"/>',$texte);
		$texte = str_replace(":surpris:",'<img src="themes/ttBlue/pages/img/ico_surprised.png" class="emoticone"/>',$texte);
		$texte = str_replace(":timide:",'<img src="themes/ttBlue/pages/img/ico_blush.png" class="emoticone"/>',$texte);
		$texte = str_replace(":innocent:",'<img src="themes/ttBlue/pages/img/ico_wasntme.png" class="emoticone"/>',$texte);
		$texte = str_replace(":pouffe:",'<img src="themes/ttBlue/pages/img/ico_giggle.png" class="emoticone"/>',$texte);
		$texte = str_replace(":inquiet:",'<img src="themes/ttBlue/pages/img/ico_worried.png" class="emoticone"/>',$texte);
		$texte = str_replace(":furieux:",'<img src="themes/ttBlue/pages/img/ico_angry.png" class="emoticone"/>',$texte);
		$texte = str_replace(":tranquille:",'<img src="themes/ttBlue/pages/img/ico_cool.png" class="emoticone"/>',$texte);
		$texte = str_replace(":rock:",'<img src="themes/ttBlue/pages/img/ico_rock.png" class="emoticone"/>',$texte);
		$texte = str_replace(":diable:",'<img src="themes/ttBlue/pages/img/ico_devil.png" class="emoticone"/>',$texte);
		$texte = str_replace(":)",'<img src="themes/ttBlue/pages/img/ico_smile.png" class="emoticone"/>',$texte);
		$texte = str_replace(":D",'<img src="themes/ttBlue/pages/img/ico_bigsmile.png" class="emoticone"/>',$texte);
		$texte = str_replace(":(",'<img src="themes/ttBlue/pages/img/ico_sad.png" class="emoticone"/>',$texte);
		$texte = str_replace(";)",'<img src="themes/ttBlue/pages/img/ico_wink.png" class="emoticone"/>',$texte);
		
		return $texte;
	
	}
}
?>