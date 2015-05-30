<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Affichage de l'administration de la mise à jour *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

$oMaj = new Maj();

$action = "";
$affTrtSCV = "";
if ( isset($_POST['action']) ) 
	$action = $_POST['action'];
	
if ( $action == "upload" ) {
	$oMaj->uploadCsv();
	
	if ($oMaj->error != "0" ) {
		if ($oMaj->error != "empty" ) {
			
		}elseif ($oMaj->error != "extension" ) {
		
		}elseif ($oMaj->error != "upload" ) {
		
		}
	}else{
		// Traitement du fichier csv
		$affTrtSCV = $oMaj->traitementCSV();
	}
}

?>

	<div id="">
		<div id="d_updateBDD">
			<br/>		
			<form id="form_updateBDD" name="form_updateBDD"  enctype="multipart/form-data" action="./admin.php?page=adminMaj" method="post">
				<fieldset>
					<legend>Mise à jour de la base de données</legend>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_contenu">
								Fichier source (.csv) :
							</label>
						</span>
						<span class="c_form_droite">       
							<input type="file" name="file">
						</span>
						</div><br/>
					<div class="d_row">
						<input type="button" onClick="document.form_updateBDD.action.value='upload';document.form_updateBDD.submit();" name="button" size="" value="Valider"> 
						<input type="hidden" name="action" value="">
					</div>
		        </fieldset>
			</form>
		</div>
		<br/>
		<?php if  ($affTrtSCV != "" ) { ?>
			<br/>
			<div id="d_list_result">
				<?php echo $affTrtSCV; ?>
			</div>
		<?php } ?>
	</div><br/>