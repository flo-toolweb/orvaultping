<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Diaporama *
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../../../config/config.php');

//include('include/session.php');
//include('include/common.php');

// Chemin du theme choisi
$theme = CHEMIN.'/themes/'.THEME.'/';

// Recuperation du dossier a afficher
$dossierGet = $_GET['dossier'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta name="Title" content="Orvault Sport Tennis de Table">
		<meta name="Keywords" content="tennis de table, orvault, club, sport">
		<meta name="Description" content="Orvault Sport Tennis de Table - Retrouvez l'actualit&eacute;, les r&eacute;sultats et bien d'autres informations sur le club">
		<meta name="Subject" content="Tennis de table">
		<meta name="Author" content="Florian Ab&eacute;lard">
		<meta name="Language" content="français">
		<meta name="Revisit-After" content="7 days">
		<meta name="Robot" content="index, follow">
		<title>Orvault Sport Tennis de Table - <?php echo $oNavigation->page_vu; ?></title>
		<link rel="stylesheet" type="text/css" href="./styles.css">
	<script language="JavaScript"> 
     var bauto = 0;
    // var dossier = "<?php echo RACINE; ?>/photos/<?php echo $dossierGet; ?>/";
    var dossier = "../../../photos/<?php echo $dossierGet; ?>/";
	
	// alert (dossier);
     var numero = 1;
     function objet(tChemins) {
		this.length = tChemins.length;
		 
		for (var i = 0; i < this.length; i++) {
			//this[i+1] = objet.arguments[i];
			this[i+1] = tChemins[i];
			//alert (this[i+1]);
		}
     }
	 
	// Recuperation du nom des images
	function recupChemins() {
		var tChemins = new Array();
		
		<?php
		$handle = opendir(RACINE."/photos/".$dossierGet); 
		$a = 0;
		while (($file = readdir())!=false) { 
			clearstatcache(); 
			if($file!=".." && $file!="." && $file!="mini") 
				{
				echo "tChemins[$a] = '$file';";
				$a++;
				}
			}
		closedir($handle); 
		?>
		
		return tChemins;
	}
	 
    //var oNom = new objet ("photo-1UCO99.jpg", "photo-2GCMWG.jpg");
	var oNom = new objet ( recupChemins());
     
     function suivante() {
		// alert (recupChemins());
		numero += 1;
		if (numero == oNom.length + 1) numero = 1;
		document.image.src = dossier+oNom[numero];
     }
	function precedente() {
		numero -= 1;
		if (numero == 0) numero = oNom.length;
		 document.image.src = dossier+oNom[numero];
	}
	function changer() {
		if (bauto == 1) {
			numero += 1;
		}
		if (numero == oNom.length + 1) numero = 1;
		document.image.src = dossier+oNom[numero];
		bauto =1;
		roll=setTimeout("changer()", 4000);
	}
	function initial() {
		window.clearTimeout(roll);
		document.image.src = dossier+oNom[numero];
	}
	function auto() {
		if (bauto == 0) {
			 changer();
			document.getElementById('automat').value=" Arrêter le diaporama ";
		}
		else {
			bauto =0; initial();
			document.getElementById('automat').value=" Démarrer le diaporama ";
		}
	}
     //-->
     </script>
     </head>
    
     <body onload="auto()">
     <div id="d_contenu">
     <input type="button" class="i_btn" name="PrEcEdEnT" value="Photo précédente" onClick="precedente();">
     <input type="button" class="i_btn" name="automat" id="automat" value=" Démarrer le diaporama " onClick="auto();">
     <input type="button" class="i_btn" name="SuIvAnTe" value="Photo suivante" onClick="suivante();">
	 <br/>
	 <img src="" name="image">
     </div>
	 <br/>
     </body>
    
     </html>

