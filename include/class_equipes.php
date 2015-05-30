<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe Equipes*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if (!defined('COMMON') ) { 
	include('common.php'); 
}

class Equipes
{
	/**
	* Nom de la table des utilisateurs
	*
	* @var string
	*/
	var $table = "tt_equipes"; 
	
	/**
	* TRUE si la liste  a ete construite, FALSE sinon
	*
	* @var boolean
	*/
	var $listIsBuilt = FALSE;
	
	/**
	* Liste des equipes
	*
	* @var array
	*/
	var $List = array(); 
	
	function Equipes()
	{
	} 

	/**
	* Construit la liste des equipes
	*
	* @return void
	*/
	function BuildList()
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." ORDER BY equipes_id ASC";
		
		$result = mysql_query($query);
		$cpt = 0;
		while ( $row = mysql_fetch_array($result) ) {
			$tEquipes[$cpt]['equipes_id'] = $row['equipes_id'];
			$tEquipes[$cpt]['equipes_adulte'] = $row['equipes_adulte'];
			$tEquipes[$cpt]['equipes_feminine'] = $row['equipes_feminine'];
			$tEquipes[$cpt]['equipes_veteran'] = $row['equipes_veteran'];
			$tEquipes[$cpt]['equipes_libelle'] =  stripSlashes($row['equipes_libelle']);
			$tEquipes[$cpt]['equipes_photo'] =  stripSlashes($row['equipes_photo']);
			$tEquipes[$cpt]['equipes_poule'] =  stripSlashes($row['equipes_poule']);
			$cpt++;
		}
		if ( $cpt != 0 ) {
			$this->List = $tEquipes;
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
	* Retourne une quipe
	*
	* @param integer $id identifiant de l'equipe
	* @return array
	*/
	function GetEquipes($id)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE equipes_id=".$id;
		$result = mysql_query($query);
				
		$equipes = mysql_fetch_array($result);
		include (RACINE."/include/bdd_close.php");
		
		return $equipes;
	}
		/**
	* Retourne les joueurs d'une equipe
	*
	* @param integer $id identifiant de l'equipe
	* @param boolean 1 si equipe adulte 
	* @param boolean 1 si equipe feminine
	* @return array
	*/
	function AffEquipe($id, $equipe_adulte, $equipe_feminine, $equipe_veteran)
	{
		include (RACINE."/include/bdd_connec.php");
		
		// Selection des infos de l'equipe
		$query  = " SELECT * FROM ".$this->table." WHERE equipes_id=".$id;
		$result = mysql_query($query);
		$equipe = mysql_fetch_array($result);
		
		$oUsers = new Users($id);
		// Selection des joueurs de l'equipe
		if ( $equipe_adulte) {
			$query_users  = " SELECT * FROM ".$oUsers->table." WHERE users_equipe=".$oUsers->numEquipe." ORDER BY users_points DESC";
			$result_users = mysql_query($query_users);
		}else if( $equipe_feminine){
			$query_users  = " SELECT * FROM ".$oUsers->table." WHERE users_equipe_feminine=".$oUsers->numEquipe." ORDER BY users_points DESC";
			$result_users = mysql_query($query_users);
		}else if( $equipe_veteran){
			$query_users  = " SELECT * FROM ".$oUsers->table." WHERE users_equipe_veteran=".$oUsers->numEquipe." ORDER BY users_points DESC";
			$result_users = mysql_query($query_users);
		}else{
			$query_users  = " SELECT * FROM ".$oUsers->table." WHERE users_equipe_jeune=".$oUsers->numEquipe." ORDER BY users_points DESC";
			$result_users = mysql_query($query_users);	
		}
		
		?>
		<table border="1" rules="all" id="t_equipe">
			<thead>
				<tr class="tr_titre">
					<th colspan="2">
					<?php echo stripSlashes($equipe['equipes_libelle'])." - Poule ".$equipe['equipes_poule']; ?>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
				while ( $row = mysql_fetch_array($result_users) ) { ?>
				
					<tr>
						<td class="td_nom"> 
							<?php 
							echo "<b>".stripSlashes($row['users_prenom'])." ";
							echo stripSlashes(mb_strtoupper($row['users_nom']))."</b>";
							if ($equipe_adulte) {
								if ( $row['users_capitaine'] )
									echo "&nbsp;-&nbsp;capitaine";
							}else if( $equipe_feminine){
								if ( $row['users_capitaine_feminine'] )
									echo "&nbsp;-&nbsp;capitaine";		
							}else if( $equipe_veteran){
								if ( $row['users_capitaine_veteran'] )
									echo "&nbsp;-&nbsp;capitaine";							
							}else if ( $row['users_capitaine_jeune'] ){
								echo "&nbsp;-&nbsp;capitaine";
							}
								
							?>
						</td>
						<td class="td_points"> 
							<?php
								echo $row['users_points']." pts";
							?>
						</td>
					</tr>
				<?php
				}
			?>
			<tr class="tr_footer">
				<td colspan="2">
					R&eacute;sultats et Classements : <br/>
					<span id="s_phase">
						<?php if ($equipe['equipes_lienResult1'] != "") { ?>
							<a href="<?php echo stripSlashes($equipe['equipes_lienResult1']); ?>" target="_blank" title="R&eacute;sultats et Classements - Lien FFTT">Première phase</a>
						<?php }else{ ?>	
								Première phase
						<?php } ?>	
						&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
						<?php if ($equipe['equipes_lienResult2'] != "") { ?>
							<a href="<?php echo stripSlashes($equipe['equipes_lienResult2']); ?>" target="_blank" title="R&eacute;sultats et Classements - Lien FFTT">Deuxième phase</a>
						<?php }else{ ?>	
								Deuxième phase
						<?php } ?>	
					</span>
				</td>
			</tr>
			</tbody>
		</table>
		<br/>
		<?php if (file_exists("../photos/equipes/mini_photo_equipe_" . $equipe['equipes_id'] . ".jpg")) { ?>
			<span id="s_photo">
				<a href="./photos/equipes/photo_equipe_<?php echo $equipe['equipes_id']; ?>.jpg" target="_blank">
					<img src="./photos/equipes/mini_photo_equipe_<?php echo $equipe['equipes_id']; ?>.jpg"
						alt="photo <?php echo $equipe['equipes_libelle']; ?>"
					/>
				</a>
			</span>
		<?php } ?>
		<br/>
		<br/>
		<?php
		include (RACINE."/include/bdd_close.php");
		
	}
	
}