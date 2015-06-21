<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Classe News*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if (!defined('COMMON') ) { 
	include('common.php'); 
}

class News 
{
	/**
	* Nom de la table des news
	*
	* @var string
	*/
	var $tableNews = "tt_news"; 
	
	/**
	* TRUE si la liste des news a ete construite, FALSE sinon
	*
	* @var boolean
	*/
	var $newsListIsBuilt = FALSE;
	
	/**
	* TRUE si la News a ete coupee, FLASE sinon
	*
	* @var boolean
	*/
	var $newsIsCut = FALSE;
	
	/**
	* Liste des news
	*
	* @var array
	*/
	var $newsList = array(); 
	
	function News()
	{
	} 

	/**
	* Construit la liste des news
	*
	* @return void
	*/
	function BuildNewsList()
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->tableNews." ORDER BY news_date DESC";
		
		$result = mysql_query($query);
		$cpt = 0;
		while ( $row = mysql_fetch_array($result) ) {
			$tNews[$cpt]['news_id'] = $row['news_id'];
			$tNews[$cpt]['news_titre'] = stripSlashes($row['news_titre']);
			$tNews[$cpt]['news_contenu'] = stripSlashes($row['news_contenu']);
			$tNews[$cpt]['news_auteur'] = stripSlashes($row['news_auteur']);
			$tNews[$cpt]['news_date'] = $row['news_date'];
			$cpt++;
		}
		if ( $cpt != 0 ) {
			$this->newsList = $tNews;
		}
		include (RACINE."/include/bdd_close.php");
		$newsListIsBuilt = TRUE;
	}
	/**
	* Retourne la liste des news
	*
	* @return array
	*/
	function GetNewsList()
	{
		if (FALSE === $this->newsListIsBuilt) {
			$this->BuildNewsList();
		}
		return $this->newsList;
	}
	/**
	* Retourne une news
	*
	* @param integer $id identifiant de la news
	* @return array
	*/
	function GetNews($id)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->tableNews." WHERE news_id=".$id;
		$result = mysql_query($query);
				
		$news = mysql_fetch_array($result);
		include (RACINE."/include/bdd_close.php");
		
		return $news;
	}
	
	function addNews($titre,$contenu,$auteur,$date)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " INSERT INTO ".$this->tableNews;
		$query .= " ( news_titre , news_contenu , news_auteur , news_date )";
		$query .= " VALUES ( '".$titre."', '".$contenu."', '".$auteur."', '".$date."' )";
		
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}
	
	function updateNews($id,$titre,$contenu)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->tableNews." SET";
		$query .= " news_titre='".$titre."',";
		$query .= " news_contenu='".$contenu."'";
		$query .= " WHERE news_id='".$id."'";
		$result = mysql_query($query);
		
		include (RACINE."/include/bdd_close.php");
	}
	
	function deleteNews($id) {
		include (RACINE."/include/bdd_connec.php");
		$query  = " DELETE FROM ".$this->tableNews;
		$query .= " WHERE news_id = ".$id;
		$result = mysql_query($query);
		include (RACINE."/include/bdd_close.php");
	}
	
	function getNewsHome($num_news) {
		$tListNews = $this->getNewsList();
		$tNews = $tListNews[$num_news];
		return $tNews;
	}
	/**
	* Retourne le contenu d'une news coupe si celle ci fait plus de 180 caracteres
	*
	* @param string $contenu contenu de la news
	* @return string
	*/
	function cutNewsHome($contenu) {
		
		if ( strlen($contenu) > 130 ){
			//decoupage d'une chaine en des morceaux de longueur donnee (130) sans couper les mots 
			$tabs = explode('�',wordwrap($contenu, 130, '�'));
			$contenu = $tabs[0];
			$this->newsIsCut = true;
		}
		if ( strlen($contenu) > 100 ){
			// Suppression des <br/>		
			$contenu = preg_replace('#(<br />)#', '', $contenu);
			$contenu = preg_replace('#<br/>#', '', $contenu);
			$contenu = preg_replace('#<br#', '', $contenu);
			$contenu = preg_replace('#<br>#', '', $contenu);
			$contenu = preg_replace('#</br>#', '', $contenu);
		}
		// Suppression des infos de mise en forme pour affichage
		$contenu = preg_replace('/\[([^\]]+)\]/', '', $contenu);
		
		return $contenu;
	}
	/**
	* Affiche la news sur la page home
	*
	* @param
	* @return void
	*/
	function affNewsHome($contenu) {
		$newsContenu = $this->cutNewsHome($contenu);
		
		if (FALSE === $this->newsIsCut ) { ?>
			<span class="s_news_contenu">
				<a href="index.php?page=news" title="Acc&eacute;der &agrave; la page des actualit�s du club">
						<?php echo $newsContenu; ?>
				</a>
			</span>
		<?php 
		}else{ 
		?>
			<span class="s_news_contenu">
				<a href="index.php?page=news" title="Acc&eacute;der &agrave; la page des actualit�s du club">
						<?php echo $newsContenu; ?>
				</a>
			</span>
			<?php if ( strlen($contenu) > 130 ) { ?>
			<span class="s_newsSuite">
				...
				<a href="index.php?page=news" alt="Acc&eacute;der &agrave; la page des actualit�s du club"
				title="Acc&eacute;der &agrave; la page des actualit�s du club">
				lire la suite
				</a>
			</span>
		<?php
			}
		}
	}	
	
	function affListNews()
	{
		// Mise a jour de la liste
		$this->BuildNewsList();
		$listNews = $this->GetNewsList();
		
		if ( count($listNews) == 0 ) {
			echo "Aucune news enregistr&eacute;e";
		}else{
		?>	<table border="1" rules="all" id="t_list">
			    <thead>
					<tr>
						<th colspan="5">Liste Des News</th>
					</tr>
					<tr>
						<th>Titre</th>
						<th>Auteur</th>
						<th>Date</th>
						<th>Modifier</th>
						<th>Supprimer</th>
					</tr>
			    </thead>
			    <tbody>

				<?php

			
				foreach($listNews AS $cle => $valeur) { 
				
					// conversion de la date datetime de mysql
					$datetime = $listNews[$cle]['news_date'];
					$tDatetime = toDateTimeFr($datetime);
				?>
					<tr>
					<td><?php echo $listNews[$cle]['news_titre']; ?></td>
					<td><?php echo $listNews[$cle]['news_auteur']; ?></td>
					<td><?php echo "le ".$tDatetime['date']." &agrave; ".$tDatetime['heure']; ?></td>
					<td><a href="#" onClick="affNewsModif(<?php echo $listNews[$cle]['news_id']; ?>)">Modif.</a></td>
					<td><a href="#" onClick="supprNews(<?php echo $listNews[$cle]['news_id']; ?>)">Suppr.</a></td>
					</tr>
				<?php	
				}
				?>    
			</tbody>
		</table>
		<?php
		}
	}
		function affAjoutNews()
	{
	?>
			<form id="form_ajoutNews" name="form_ajoutNews" action="#" method="post">
				<fieldset>
					<legend>&nbsp;Ajouter une News&nbsp;</legend>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_titre">
								Titre :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_titre" name="titre" size="50">
						</span>
					</div>	
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_contenu">
								Contenu :
							</label>
						</span>
					</div>
                    <div class="d_row">
						<span class="">       
							<textarea id="id_contenu" name="contenu" rows="12" cols="65"></textarea>
						</span>
					</div>
					<div class="d_row">
						<input type="hidden" id="id_prenom" name="prenom" value="<?php echo $_SESSION['user_prenom']; ?>">
						<input type="reset" id="id_reset"  size="" value="Annuler"> 
						<input type="button" id="id_submit" onClick="addNews()" size="" value="Valider"> 
					</div>
		        </fieldset>
			</form>
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
	            // Les guillemets simples sont tr�s importants ici
	            // ou bien il faut prot�ger les caract�res $ avec \$
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
		$texte = str_replace(":langue:",'<img src="themes/ttBlue/pages/img/ico_tongueout.png"/>',$texte);
		$texte = str_replace(":pleure:",'<img src="themes/ttBlue/pages/img/ico_crying.png"/>',$texte);
		$texte = str_replace(":surpris:",'<img src="themes/ttBlue/pages/img/ico_surprised.png"/>',$texte);
		$texte = str_replace(":timide:",'<img src="themes/ttBlue/pages/img/ico_blush.png"/>',$texte);
		$texte = str_replace(":innocent:",'<img src="themes/ttBlue/pages/img/ico_wasntme.png"/>',$texte);
		$texte = str_replace(":pouffe:",'<img src="themes/ttBlue/pages/img/ico_giggle.png"/>',$texte);
		$texte = str_replace(":inquiet:",'<img src="themes/ttBlue/pages/img/ico_worried.png"/>',$texte);
		$texte = str_replace(":furieux:",'<img src="themes/ttBlue/pages/img/ico_angry.png"/>',$texte);
		$texte = str_replace(":tranquille:",'<img src="themes/ttBlue/pages/img/ico_cool.png"/>',$texte);
		$texte = str_replace(":rock:",'<img src="themes/ttBlue/pages/img/ico_rock.png"/>',$texte);
		$texte = str_replace(":diable:",'<img src="themes/ttBlue/pages/img/ico_devil.png"/>',$texte);
		$texte = str_replace(":)",'<img src="themes/ttBlue/pages/img/ico_smile.png"/>',$texte);
		$texte = str_replace(":D",'<img src="themes/ttBlue/pages/img/ico_bigsmile.png"/>',$texte);
		$texte = str_replace(":(",'<img src="themes/ttBlue/pages/img/ico_sad.png"/>',$texte);
		$texte = str_replace(";)",'<img src="themes/ttBlue/pages/img/ico_wink.png"/>',$texte);
		
		return $texte;
	
	}
} 

?>