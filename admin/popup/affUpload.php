<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Affichage apres upload d'une photo *
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
?>
<!DOCTYPE XHTML PUBLIC "-//W3C//DTD XHTML 1.0 strict//en">
<html lang="fr">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<head>
		<title>Page d'upload</title>
		<style type="text/css">
			*{margin:0;padding:0;}

			html {
				font-size: 100%;
			}
			body {
				background-color: #000000;
				font-family: arial, sans-serif;
				font-size: 0.8em;
			}
			div#d_globalErr{
				position:relative;
				width:342px;
				height:192px;
				overflow:visible;
				text-align: center;
				border: 4px solid #8B0000;
				background-color:#FFC0CB;
			}
			div#d_globalOk{
				position:relative;
				width:342px;
				height:192px;
				overflow:visible;
				text-align: center;
				border:4px solid #006600;
				background-color:#99FFCC;
			}
			div.d_errUpload{
				position:relative;
				overflow:visible;
				font-weight: bold;	
				color: #8B0000;
			}
			div.d_okUpload{
				position:relative;
				overflow:visible;
				font-weight: bold;	
				color: #006600;
			}
			div.d_global input{
				height:29px;
				width:120px;
				font-size: 1.3em;
				font-weight: bold;
				cursor: pointer;
				display: inline;
				border:2px solid #000000;
				background-color:#8B0000;
				color: #FFC0CB;
			}
			div.d_global input:hover{
				border:3px solid #000000;
			}
		</style>
	</head>
	
	<body>
		<?php
			include("../include/uploadPhotos.php");
		?>
	</body>
</html>
