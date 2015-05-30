<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe photos *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================


	
if (!defined('COMMON') ) { 
	include('common.php'); 
}
class PhotosCategory
{
	/**
	* Nom de la table Category
	*
	* @var string
	*/
	var $table = "tt_photosCategory"; 
	
	/**
	* Chemin absolu vers le repertoire contenant les photos
	*
	* @var string
	*/
	var $dir = ""; 
		
	/**
	* TRUE si la liste des news a ete construite, FALSE sinon
	*
	* @var boolean
	*/
	var $listIsBuilt = FALSE;
	
	/**
	* Liste des categories
	*
	* @var array
	*/
	var $categoryList = array(); 
	
	/**
	* Saison 
	*
	* @var string
	*/
	var $saison = ""; 
	/**
	* Saison en cours
	*
	* @var string
	*/
	var $saisonEnCours = ""; 
	
	
	function PhotosCategory()
	{
		$this->saisonEnCours = get_saisonEnCours();
	} 
		/**
	* Construit la liste des categorie d'une saison
	*
	* @return void
	*/
	function BuildList($saison)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE photosCategory_saison = '".$saison."' ORDER BY photosCategory_date DESC";
		
		$result = mysql_query($query);
		$cpt = 0;
		while ( $row = mysql_fetch_array($result) ) {
			$tCategory[$cpt]['photosCategory_id'] = $row['photosCategory_id'];
			$tCategory[$cpt]['photosCategory_titre'] = stripSlashes($row['photosCategory_titre']);
			$tCategory[$cpt]['photosCategory_description'] = stripSlashes($row['photosCategory_description']);
			$tCategory[$cpt]['photosCategory_dossier'] = $row['photosCategory_dossier'];
			$tCategory[$cpt]['photosCategory_date'] = $row['photosCategory_date'];
			$cpt++;
		}
		if ( $cpt != 0 ) {
			$this->categoryList = $tCategory;
		}
		include (RACINE."/include/bdd_close.php");
		$listIsBuilt = TRUE;
	}
	/**
	* Retourne la liste des categories d'une saison
	*
	* @return array
	*/
	function GetList($saison)
	{
		if (FALSE === $this->listIsBuilt) {
			$this->BuildList($saison);
		}
		return $this->categoryList;
	}
	/**
	* Retourne une categorie
	*
	* @param integer $id identifiant de la news
	* @return array
	*/
	function GetCategory($id)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->table." WHERE photosCategory_id=".$id;
		$result = mysql_query($query);
				
		$cat = mysql_fetch_array($result);
		include (RACINE."/include/bdd_close.php");
		
		return $cat;
	}
	
	function addCategory($dossier,$titre,$description)
	{
		// recuperation de la saison en cours
	
		include (RACINE."/include/bdd_connec.php");
		$query  = " INSERT INTO ".$this->table;
		$query .= " (photosCategory_dossier, photosCategory_titre, photosCategory_description, photosCategory_saison  )";
		$query .= " VALUES ( '".$dossier."', '".$titre."', '".$description."', '".$this->saisonEnCours."' )";
				
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}
	
	function updateCategory($id,$titre,$description)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->table." SET";
		$query .= " photosCategory_titre='".$titre."',";
		$query .= " photosCategory_description='".$description."'";
		$query .= " WHERE photosCategory_id='".$id."'";
		$result = mysql_query($query);
		include (RACINE."/include/bdd_close.php");
	}
	
	function deleteCategory($id) {
		include (RACINE."/include/bdd_connec.php");
		$query  = " DELETE FROM ".$this->table;
		$query .= " WHERE photosCategory_id = ".$id;
		
		$result = mysql_query($query);
		include (RACINE."/include/bdd_close.php");
	}
	
	/* Supprime le dossier et son contenu */
	function delTree($dossier){
        if(($dir=opendir($dossier))===false)
            return;
 
        while($name=readdir($dir)){
            if($name==='.' or $name==='..')
                continue;
            $full_name=$dossier.'/'.$name;
 
            if(is_dir($full_name))
                $this->delTree($full_name);
            else unlink($full_name);
            }
 
        closedir($dir);
 
        @rmdir($dossier);
    }
	
	/**
	* Affiche la liste des categories d'une saison ( espace user )
	*
	* @param string $saison identifiant de la saison
	* @return void
	*/
	function affListCategoryUser($saison)
	{
		// Recuperation de la liste descategories
		$oPhotosCategory = new PhotosCategory("./photos");
		$tCat = $oPhotosCategory->getList($saison);
		
		foreach ( $tCat as $cle=>$value ) {
			/* Recuperation d'une vignette */
			$dir = RACINE."/photos/".$tCat[$cle]['photosCategory_dossier']."/mini/";
			$nom = "";
			if ($handle = opendir($dir)) {
				$cpt = 1;
				while (false !== ($photo = readdir($handle)) && $cpt == 1) {
					if ($photo != "." && $photo != "..") {
						$nom = $photo;
						$cpt++;
					}
				}
			}
			?>	
			<li><div><img src="<?php echo "./photos/".$tCat[$cle]['photosCategory_dossier']."/mini/".$nom	?>"
				onclick="affMinPhotos(<?php echo $tCat[$cle]['photosCategory_id']; ?>)" alt="image <?php echo $tCat[$cle]['photosCategory_titre']; ?>" title="<?php echo $tCat[$cle]['photosCategory_titre']; ?>"/>
				<br/><span><?php echo $tCat[$cle]['photosCategory_titre']; ?></span>
			</div></li>
			<?php
		} 
	}
	/**
	* Affiche la liste des categories d'une saison ( espace admin )
	*
	* @param string $saison identifiant de la saison
	* @return void
	*/
	function affListCategory($saison)
	{
		// Mise a jour de la liste
		$list = $this->GetList($saison);
		
		if ( count($list) == 0 ) {
			echo "Aucune cat&eacute;gorie enregistr&eacute;e";
		}else{
		?>	<table border="1" rules="all" id="t_list">
			    <thead>
					<tr>
						<th colspan="5">Liste Des Cat&eacute;gories</th>
					</tr>
					<tr>
						<th>Titre</th>
						<th>Modifier</th>
						<th>Supprimer</th>
					</tr>
			    </thead>
			    <tbody>

				<?php

			
				foreach($list AS $cle => $valeur) { 
				
				?>
					<tr>
					<td><a href="admin.php?page=adminPhotos&cat=<?php echo $list[$cle]['photosCategory_id']; ?>" 
						title="G&eacute;rer les photos de cette cat&eacute;gorie"><?php echo $list[$cle]['photosCategory_titre']; ?>
						</a>
					</td>
					<td><a href="#" onClick="affCategoryModif(<?php echo $list[$cle]['photosCategory_id']; ?>)">Modif.</a></td>
					<td><a href="#" onClick="supprCategory(<?php echo $list[$cle]['photosCategory_id']; ?>)">Suppr.</a></td>
					</tr>
				<?php	
				}
				?>    
			</tbody>
		</table>
		<?php
		}
	}
		
	function affAjoutCategory()
	{
	?>
			<form id="form_ajoutNews" name="form_ajoutNews" action="#" method="post">
				<fieldset>
					<legend> Ajouter une Categorie </legend>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_titre">
								Titre :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_titre" name="titre" size="40">
						</span>
						</div><br/>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_description">
								Description :
							</label>
						</span>
						<span class="c_form_droite">       
							<textarea id="id_description" name="description" rows="2" cols="50"></textarea>
						</span>
						</div><br/>
					<div class="d_row">
						<input type="reset" id="id_reset"  size="" value="Annuler"> 
						<input type="button" id="id_submit" onClick="addCategory()" size="" value="Valider"> 
					</div>
		        </fieldset>
			</form>
		<!-- Fin div newsAjout -->
	<?php	
	}

}
?>