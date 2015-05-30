<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Pop up d'affichage de la photo*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('./../../../config/config.php');
include(RACINE.'/include/class_photoWeek.php');
?>
<!DOCTYPE XHTML PUBLIC "-//W3C//DTD XHTML 1.0 strict//en">
<html lang="fr">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<head>
		<title>Photo de la semaine</title>

		<style type="text/css">
			*{margin:0;padding:0;border: 0px;}

			html {
				font-size: 100%;
			}
			body {
				margin-top:8px;
				background-color: #03638A;
				font-family: arial, sans-serif;
				font-size: 1em;
				font-weight:bold;
				color: black;
				text-align: center;
			}
			img {
				border: 0px;
			}
			a{
				text-decoration:none;
			}
		</style>
	<body>
		<?php
			$oPhotoWeek = new photoWeek("photos");
			$tPhotoWeek = $oPhotoWeek->getPhotoWeek();
			$desc = stripslashes($tPhotoWeek['photoWeek_description']);
		?>
		<a onClick="window.close();" href="#">
		<img src="./../../../photos/photoWeek/<?php echo $tPhotoWeek['photoWeek_nom']; ?>"  
			title="Fermer cette fen&ecirc;tre"
		/>
		</a><br/>
		<?php echo $desc; ?>
	</body>
</html>