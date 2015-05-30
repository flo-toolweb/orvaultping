<?php
header('Content-Type: text/html; charset=iso-8859-1');

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Operations sur les categories des photos (  ajout - modif ) *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../../config/config.php');

include(RACINE.'/include/class_photosCategory.php');
include(RACINE.'/include/session.php');

$req = $_POST['TypeReq'];

if ( $req == 'add' ) {

	// Ajout des antislashs
	$titre = addslashes($_POST['titre']);
	$description = addslashes($_POST['description']);

	// Conversion en Iso 
	$titre = mb_convert_encoding($titre, "iso-8859-1", "UTF-8");
	$description = mb_convert_encoding($description, "iso-8859-1", "UTF-8");
	
	// Creation du dossier correspondant
	$string = generatePWD();
	$dossier = "catPhotos-".$string;
	mkdir (RACINE."/photos/".$dossier, 0705); 
	mkdir (RACINE."/photos/".$dossier."/mini", 0705); 
	
	// Execution de la requete
	$oPhotosCategory = new PhotosCategory("./photos");
	$oPhotosCategory->addCategory($dossier,$titre,$description);

	// Affichage a renvoyer
	?>
	<span id="s_erreur">
		Cat&eacute;gorie ajout&eacute;e
	</span>	
	<?php
	$oPhotosCategory->affListCategory($oPhotosCategory->saisonEnCours);
} // end if add

if ( $req == 'affModif' ) {

	$id = $_POST['id_category'];
	
	// Execution de la requete
	$oCategory = new PhotosCategory("tt_photosCategory");
	$tCategory = $oCategory->GetCategory($id);
	
	//Suppression des antislashs
	$tCategory['photosCategory_titre'] = stripSlashes($tCategory['photosCategory_titre']);
	$tCategory['photosCategory_description'] = stripSlashes($tCategory['photosCategory_description']);
	?>
		
			<form id="form_modif" name="form_modif" action="#" method="post">
				<fieldset>
					<legend> Modifier cette Cat&eacute;gorie </legend>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_titreModif">
								Titre :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_titreModif" name="titre" size="40" value="<?php echo $tCategory['photosCategory_titre']; ?>">
						</span>
						</div><br/>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_descriptionModif">
								Description :
							</label>
						</span>
						<span class="c_form_droite">       
							<textarea id="id_descriptionModif" name="description" rows="2" cols="50"><?php echo $tCategory['photosCategory_description']; ?></textarea>
						</span>
						</div><br/>
					<div class="d_row">
						<input type="reset" id="id_reset"  size="" value="Annuler"> 
						<input type="button" id="id_submit" onClick="modifCategory(<?php echo $tCategory['photosCategory_id']; ?>)" size="" value="Valider">
						<br/>
						<input type="button" id="id_retour" onClick="modifCategory(<?php echo -1; ?>)" size="" value="Retour">  
					</div>
		        </fieldset>
			</form>
	<!-- Fin div newsModif -->
<?php
} // end if affModif

if ( $req == 'modif' ) {

	$id = $_POST['id'];
	$titre = addslashes($_POST['titre']);
	$description = addslashes($_POST['description']);
	
	// Conversion en Iso 
	$titre = mb_convert_encoding($titre, "iso-8859-1", "UTF-8");
	$description = mb_convert_encoding($description, "iso-8859-1", "UTF-8");
	
	// Execution de la requete
	$oCategory = new photosCategory();
	$tCategory = $oCategory->updateCategory($id,$titre,$description);
	
	?>
	<span id="s_erreur">
		Cat&eacute;gorie modifi&eacute;e
	</span>	
	<?php
	$oCategory->affListCategory($oCategory->saisonEnCours);
} // end if modif

if ( $req == 'suppr' ) {

	$id = $_POST['id'];
	
	$oCategory = new PhotosCategory();
	// Suppression des photos correspondantes
	$tCat = $oCategory->getCategory($id);
	$cheminDossier = RACINE."/photos/".$tCat['photosCategory_dossier'];
	$oCategory->delTree($cheminDossier);
	
	// Execution de la requete sql
	$oCategory->deleteCategory($id);
	

	
	?>
	<span id="s_erreur">
		Cat&eacute;gorie supprim&eacute;e
	</span>	
	<?php
	$oCategory->affListCategory($oCategory->saisonEnCours);
} // end if suppr
?>