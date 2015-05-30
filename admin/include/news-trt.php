<?php
header('Content-Type: text/html; charset=iso-8859-1');

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Operations sur les News (  ajout - modif ) *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../../config/config.php');

include(RACINE.'/include/class_news.php');
include(RACINE.'/include/class_forumMsg.php');
include(RACINE.'/include/session.php');


if ( !isAdmin() ) {
	header('Location: index.php?msg=droits');
}

$req = $_POST['TypeReq'];


if ( $req == 'add' ) {

	// Ajout des antislashs
	$titre = addslashes($_POST['titre']);
	$contenu = addslashes($_POST['contenu']);
	$auteur = addslashes($_POST['prenom']);
	$date = date("Y-m-d H:i:s");
	
	// prise en compte des retour chariot
	$contenu = nl2br($contenu);
	
	// Conversion en Iso 
	$titre = mb_convert_encoding($titre, "iso-8859-1", "UTF-8");
	$contenu = mb_convert_encoding($contenu, "iso-8859-1", "UTF-8");
	$auteur = mb_convert_encoding($auteur, "iso-8859-1", "UTF-8");
	
	// Execution de la requete
	$oNews = new News("tt_news");
	$oNews->addNews($titre,$contenu,$auteur,$date);
	
	// Creation d'une discussion sur le forum
	$auteur_id = $_SESSION['user_id'];
	$oForumMsg = new forumMsg();
	$oForumMsg -> add($titre, $contenu, $auteur_id, $date, 1, 0);
	
	// Affichage a renvoyer
	?>
	<span id="s_erreur">
		News ajout&eacute;e
	</span>	
	<?php
	$oNews->affListNews();
} // end if add

if ( $req == 'affModif' ) {

	$id = $_POST['id_news'];
	
	// Execution de la requete
	$oNews = new News("tt_news");
	$tNews = $oNews->GetNews($id);
	
	//Suppression des antislashs
	$tNews['news_titre'] = stripSlashes($tNews['news_titre']);
	$tNews['news_contenu'] = stripSlashes($tNews['news_contenu']);
	?>
		<form id="form_modifNews" name="form_ajoutNews" action="include/login_submit.php" method="post">
			<fieldset>
				<legend>&nbsp;Modifier cette News&nbsp;</legend>
				<div class="d_row">
					<span class="c_form_gauche">
						<label for="id_titreModif">
							Titre :
						</label>
					</span>
					<span class="c_form_droite">      
						<input type="text" id="id_titreModif" name="titre" size="50" value="<?php echo $tNews['news_titre']; ?>">
					</span>
				</div>
				<div class="d_row">
					<span class="c_form_gauche">
						Mise en forme :
					</span>
					<span class="c_form_droite">  						
						<input type="button" class="mise_en_forme" id="btn_bold"  name="bold" size="0" value="Gras" onClick="addBalises('id_contenu','bold')"/>
						<input type="button" class="mise_en_forme" id="btn_italic" name="italic" size="0" value="Italique" onClick="addBalises('id_contenu','italic')"/>						
						<input type="button" class="mise_en_forme" id="btn_link" name="link" size="0" value="Lien" onClick="addLink('id_contenu')"/>
					</span>
				</div>
				<div class="d_row">
					<span class="c_form_gauche">
						<label for="id_contenuModif">
							Contenu :
						</label>
					</span>
					<span class="c_form_droite">       
						<textarea id="id_contenuModif" name="contenu" rows="5" cols="65"><?php echo $tNews['news_contenu']; ?></textarea>
					</span>
					</div>
				<div class="d_row">
					<input type="button" id="id_retour" onClick="modifNews(<?php echo -1; ?>)" size="" value="Retour"> 
					<input type="reset" id="id_reset"  size="" value="Annuler"> 
					<input type="button" id="id_submitModif" onClick="modifNews(<?php echo $tNews['news_id']; ?>)" size="" value="Valider">
				</div>
	        </fieldset>
		</form>
	<!-- Fin div newsModif -->
<?php
} // end if affModif

if ( $req == 'modif' ) {

	$id = $_POST['id_news'];
	$titre = addslashes($_POST['titre']);
	$contenu = addslashes($_POST['contenu']);
	
	// Conversion en Iso 
	$titre = mb_convert_encoding($titre, "iso-8859-1", "UTF-8");
	$contenu = mb_convert_encoding($contenu, "iso-8859-1", "UTF-8");
	
	// Execution de la requete
	$oNews = new News("tt_news");
	$tNews = $oNews->updateNews($id,$titre,$contenu);
	
	?>
	<span id="s_erreur">
		News modifi&eacute;e
	</span>	
	<?php
	$oNews->affListNews();
} // end if modif

if ( $req == 'suppr' ) {

	$id = $_POST['id_news'];
	
	// Execution de la requete
	$oNews = new News("tt_news");
	$tNews = $oNews->deleteNews($id);
	
	?>
	<span id="s_erreur">
		News supprim&eacute;e
	</span>	
	<?php
	$oNews->affListNews();
} // end if suppr
?>