<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Template de le page d'accueil de l'espace Admin *
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<head>
		<link rel="stylesheet" type="text/css" href="<?php echo $oNavigation->dossier.'styles.css';?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $oNavigation->dossier.$oNavigation->page_vu.'.css';?>">
		<script type="text/javascript" src="./js/lib/prototype.js"></script>
		<script type="text/javascript" src="./js/include/login.js"></script>
		<script type="text/javascript" src="./js/include/admin.js"></script>
	</head>
	
	<body>
		<div id="d_global">
			<div id="d_header">
				<div id="d_header_gauche">
					<a href="index.php?page=home" id="a_accueil"><img src="themes/ttBlue/pages/img/spacer.gif"/></a>
				</div>
				<div id="d_header_droite">
					<div id="d_nom_page">
						<?php echo $oNavigation->pages_admin[$oNavigation->page_vu]; ?>
					</div>
				</div>
			</div>
			<!-- Fin div header -->
			<div id="d_contenu">
				<div id="d_contenu_gauche">
					<div id="d_id">	
						<div id="d_id_titre">	
							<p>Identification<p>
						</div>
						<div id="d_id_contenu">	
							<?php affId(); ?>
						</div>
						<!-- Fin div id_contenu -->
					</div>
					<!-- Fin div id-->			
					<div id="d_menu_titre">
						<p>Administration<p>
					</div>
					<div id="d_menu">	
						<span class="s_boutons">
							&#149; <a href="admin.php?page=adminNews">Les News</a>
						</span>
						<span class="s_boutons">
							&#149; <a href="admin.php?page=adminPhotosCat">Les Photos</a>
						</span>
						<span class="s_boutons">
							&#149; <a href="admin.php?page=adminPhotoWeek">La photo de la semaine</a>
						</span>
						<!-- Super admin -->
						<?php if (isSuperAdmin()) { ?>
						<span class="s_boutons">
							&#149; <a href="admin.php?page=adminMaj">Mise à jour</a>
						</span>
						<?php } ?>
					</div>
					<!-- Fin div menu-->
				</div>
				<!-- Fin div gauche -->
				<div id="d_contenu_droite">
					<div id="d_page">
						<?php $oNavigation -> afficherPage(); ?>
					</div>
					<!-- Fin div page -->
			
				</div>
				<!-- Fin div droite -->
			</div>
			<!-- Fin div contenu -->
			
			<div id="d_footer">
				<span>
					<a href="http://www.fftt.com" target="_blank" title="F&eacute;d&eacute;ration Française de Tennis de Table"><img src="themes/ttBlue/pages/img/lien_FFTT.png"/></a>
				</span>
				&nbsp;&nbsp;&nbsp;
				<span class="s_logos">
					<a href="http://www.cdtt44.com" target="_blank" title="Comit&eacute; de Tennis de Table de Loire-Atlantique"><img src="themes/ttBlue/pages/img/lien_CDTT44.png"/></a>
				</span>
			</div>
			<!-- Fin div footer -->
			
		</div>
		<!-- Fin div global -->
	</body>
	
</html>


