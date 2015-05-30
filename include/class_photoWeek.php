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

class photoWeek 
{
	/**
	* Nom de la table
	*
	* @var string
	*/
	var $tablePhotoWeek = "tt_photoWeek"; 
	/**
	* Nom de la photo taille normal
	*
	* @var string
	*/
	var $nomPhotoServ = ""; 
	/**
	* Chemin absolu vers le repertoire contenant les photos
	*
	* @var string
	*/
	var $dir = ""; 	
	/**
	* largeur max des photos
	*
	* @var int
	*/
	var $largeurMax = 1250; 
	/**
	* hauteur max des photos
	*
	* @var int
	*/
	var $hauteurMax = 900; 		
	/**
	* hauteur des vignettes
	*
	* @var int
	*/
	var $hauteur = 260; 
	
	function photoWeek ($dir)
	{
		$this->dir = $dir;
	} 

	/**
	* Retourne la photo du jour
	*
	* @return array
	*/
	function GetPhotoWeek()
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " SELECT * FROM ".$this->tablePhotoWeek;
		$query .= " WHERE photoWeek_id = 1";
		$result = mysql_query($query);
				
		$photo = mysql_fetch_array($result);
		include (RACINE."/include/bdd_close.php");
		
		return $photo;
	}
	
	/**
	* Cree la miniature de la photo
	*
	* @return void
	*/	
	function setMini($srcPhoto)
	{
		$hauteur = $this->hauteur;
		// Recuperation de l'image a taille normal
		$src=imagecreatefromjpeg($srcPhoto);
		// Recuperation de la taille de l'image
		$taille=getimagesize($srcPhoto);
		$larg = $taille[0];
		$haut= $taille[1];
		// Creation de la vignette vide a sa taille
		$img=imagecreatetruecolor(round(($hauteur/$haut)*$larg),$hauteur);
		// Copie de l'image source a la taille de la vignette
		imagecopyresampled($img,$src,0,0,0,0,
                                      // $larg,round(($larg/$larg)*$haut),$larg,$haut);
									   round(($hauteur/$haut)*$larg),$hauteur,$larg,$haut);
		
		// Sauvegarde de la vignette sur le serveur
		imagejpeg($img, $this->dir."/mini" ."/mini_".$this->nomPhotoServ);
	}	
	/**
	* Redimensionne la photo si necessaire
	*
	* @return void
	*/	
	function redimPhoto($srcPhoto,$dir)
	{
		$largeurMax = $this->largeurMax;
		$hauteurMax = $this->hauteurMax;
		// Recuperation de l'image a taille normal
		$src=imagecreatefromjpeg($srcPhoto);
		// Recuperation de la taille de l'image
		$taille=getimagesize($srcPhoto);
		$larg = $taille[0];
		$haut= $taille[1];
		if ( $larg > $largeurMax ) {
			// Creation de la nouvelle photo vide a sa taille
			$newHauteur = round(($largeurMax/$larg)*$haut);
			$img=imagecreatetruecolor($largeurMax,$newHauteur); 
			// Copie de l'image source a la taille de la vignette
			imagecopyresampled($img,$src,0,0,0,0,$largeurMax,$newHauteur,$larg,$haut);
			
			$larg = $largeurMax;
			$haut = $newHauteur;
			$src = $img;
			if ( $haut > $hauteurMax ) {
				// Creation de la nouvelle photo vide a sa taille
				$newLargeur = round(($hauteurMax/$haut)*$larg);
				$img=imagecreatetruecolor($newLargeur ,$hauteurMax);
				// Copie de l'image source a la taille de la vignette
				imagecopyresampled($img,$src,0,0,0,0,$newLargeur,$hauteurMax,$larg,$haut);
			}			
			// Sauvegarde de la nouvelle photo sur le serveur		
			imagejpeg($img, $dir."/".$this->nomPhotoServ);	
		}
		if ( $haut > $hauteurMax ) {
			// Creation de la nouvelle photo vide a sa taille
			$newLargeur = round(($hauteurMax/$haut)*$larg);
			$img=imagecreatetruecolor($newLargeur ,$hauteurMax);
			// Copie de l'image source a la taille de la vignette
			imagecopyresampled($img,$src,0,0,0,0,$newLargeur ,$hauteurMax,$larg,$haut);
			
			// Sauvegarde de la nouvelle photo sur le serveur		
			imagejpeg($img, $dir."/".$this->nomPhotoServ);	
		}
	}
	
	
	function updatePhotoWeek($description,$nom,$nomMini,$taille,$largeur,$hauteur)
	{
		include (RACINE."/include/bdd_connec.php");
		$query  = " UPDATE ".$this->tablePhotoWeek." SET";
		$query .= " photoWeek_description = '".$description."',";
		$query .= " photoWeek_nom = '".$nom."',";
		$query .= " photoWeek_nomMini = '".$nomMini."',";
		$query .= " photoWeek_taille = ".$taille.",";
		$query .= " photoWeek_largeur = ".$largeur.",";
		$query .= " photoWeek_hauteur = ".$hauteur;
		$query .= " WHERE photoWeek_id=1";
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
	
	
	function affAjoutPhotoWeek()
	{
	?>
		<div id="d_photoWeekAjout">
			<br/>		
			<form id="form_ajoutphotoWeek" name="form_ajoutphotoWeek"  enctype="multipart/form-data" action="./admin/popup/affUploadWeek.php" method="post">
				<fieldset>
					<legend>Nouvelle photo de la semaine</legend>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_desc">
								Description rapide :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_desc" name="desc" size="30">
						</span>
						</div><br/>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_contenu">
								Photo :
							</label>
						</span>
						<span class="c_form_droite">       
							<input type="file" name="file">
						</span>
						</div><br/>
					<div class="d_row">
						<input type="button" onClick="centrage_popup_form('admin/popup/popUpWait.php', 350, 200,'scrollbars=0, toolbar=0, titlebar=0, status=0, resizable=0',form_ajoutphotoWeek);" name="button" size="" value="Valider"> 
					</div>
		        </fieldset>
			</form>
		</div>
		<!-- Fin div newsAjout -->
	<?php	
	} // fin affAjoutPhotoWeek()
} 

?>