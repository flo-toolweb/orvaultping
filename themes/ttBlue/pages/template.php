<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Template de le page de base *
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta name="Title" content="Orvault Sport Tennis de Table"/>
		<meta name="Keywords" content="tennis de table, orvault, club, sport"/>
		<meta name="Description" content="Orvault Sport Tennis de Table - Retrouvez l'actualit&eacute;, les r&eacute;sultats et bien d'autres informations sur le club"/>
		<meta name="Subject" content="Tennis de table"/>
		<meta name="Author" content="Florian Ab&eacute;lard"/>
		<meta name="Language" content="français"/>
		<meta name="Revisit-After" content="7 days"/>
        <meta name="Robots" content="
            <?php 
                if (TYPE_ENV == 'prod') {
                    echo 'index, follow';
                }
                else {
                    echo 'noindex, nofollow';
                }
            ?>
        "/>
		<title>Orvault Sport Tennis de Table - <?php echo $oNavigation->page_vu; ?></title>
		<link href="./favicon.ico" type="image/x-icon" rel="shortcut icon"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $oNavigation->dossier.'styles.css';?>"/>
		<?php
			if ( substr($oNavigation->page_vu, 0, 5) === "forum" ) { ?>
				<link rel="stylesheet" type="text/css" href="<?php echo $oNavigation->dossier.'forum.css';?>"/>
			<?php
			} else {
		?>
			<link rel="stylesheet" type="text/css" href="<?php echo $oNavigation->dossier.$oNavigation->page_vu.'.css';?>"/>
		<?php } ?>
		<script type="text/javascript" src="./js/include/login.js"></script>
		<script type="text/javascript" src="./js/include/template.js"></script>
		<script type="text/javascript" src="./js/lib/prototype.js"></script>
		<script type="text/javascript" src="./js/include/forum.js"></script>
		<?php
			if ( $oNavigation->page_vu === "medias" ) { ?>
				<script src="./js/lib/jquery-1.6.2.js" type="text/javascript"></script>
				<script type="text/javascript" src="./js/lib/jquery.bxSlider.min.js"></script>
				<script type="text/javascript">
				<!-- Carousel -->
				jQuery(document).ready(function(){
					jQuery('#slider1').bxSlider({
							pager: true, 
							pagerLocation: 'top',
							mode: 'horizontal',
							displaySlideQty: 3,
							moveSlideQty: 1             
						});
				});	
				</script>
		<?php } ?>
		
		<!-- Bords arrondis sous IE -->
		<!--[if lte IE 8]> 
		<script type="text/javascript" src="./js/lib/roundies.js"> 
		</script>
		<script type="text/javascript">
			DD_roundies.addRule('a.a_boutons_int', '12px'); 
		</script>
		
		<![endif]-->
	</head>
	
	<body>
		<div id="d_global">
			<!-- Debut div header -->
			<div id="d_header">
				<div id="d_header_gauche">
					<a href="index.php?page=home" id="a_accueil"><img src="themes/ttBlue/pages/img/spacer.gif"/></a>
				</div>
				<div id="d_header_droite">
					<div id="d_nom_page">
						<?php echo $oNavigation->pages[$oNavigation->page_vu]; ?>
					</div>
				</div>
			</div>
			<!-- Fin div header -->
			<div id="d_contenu">
				<div id="d_contenu_gauche">
					<div id="d_id">	
						<div id="d_id_titre">	
							<p>Identification</p>
						</div>
						<div id="d_id_contenu">	
							<?php affId(); ?>
						</div>
						<!-- Fin div id_contenu -->
					</div>
					<!-- Fin div id-->
					
					<!-- Debut div menu-->
					<div id="d_menu">	
						<div class="d_menu_lien">		
							<img src="themes/ttBlue/pages/img/img_btn_le_club.png" alt="Image bouton Le club"/>		
							<a href="index.php?page=le_club" title="Toutes les informations sur le club" class="a_boutons_int" id="a_le_club">		
								Le club
							</a>
						</div>
						<div class="d_menu_lien">
							<img src="themes/ttBlue/pages/img/img_btn_equipes.png" alt="Image bouton �quipes"/>		
							<a href="index.php?page=equipes" title="Page de pr�sentation des �quipes" class="a_boutons_int" id="a_equipes">	
								&Eacute;quipes
							</a>		
						</div>
						<div class="d_menu_lien">
							<img src="themes/ttBlue/pages/img/img_btn_joueurs.png" alt="Image bouton joueurs"/>
							<a href="index.php?page=joueurs" title="Liste des joueurs du club" class="a_boutons_int" id="a_joueurs">
								Joueurs
							</a>
						</div>
						<div class="d_menu_lien">			
							<img src="themes/ttBlue/pages/img/img_btn_forum.png" alt="Image bouton forum"/>
							<a href="index.php?page=forum_liste" title="Forum - utilisateurs connect�s uniquement" class="a_boutons_int" id="a_forum">	
								Forum
							</a>
						</div>
						<div class="d_menu_lien">
							<img src="themes/ttBlue/pages/img/img_btn_photos.png" alt="Image bouton m&eacute;dias"/>
							<a href="index.php?page=medias" title="Les photos et les vid�os du club" class="a_boutons_int" id="a_photos">
								M&eacute;dias
							</a>
						</div>
						<div class="d_menu_lien">
							<img src="themes/ttBlue/pages/img/img_btn_news.png" alt="Image bouton vie du club"/>
							<a href="index.php?page=news" title="Page des news" class="a_boutons_int" id="a_news">
								Vie du club
							</a>
						</div>
						<div class="d_menu_lien">
							<img src="themes/ttBlue/pages/img/img_btn_contacts.png" alt="Image bouton contact"/>
							<a href="index.php?page=contact-plan" title="Page des contacts et du plan d'acc�s" class="a_boutons_int" id="a_contacts">	
									Contacts
							</a>	
						</div>
						<div class="d_menu_lien">	
							<img src="themes/ttBlue/pages/img/img_btn_partenaires.png" alt=""/>
							<a href="index.php?page=partenaires" title="Liste des partenaires du club" class="a_boutons_int" id="a_partenaires">	
								Partenaires
							</a>
						</div>
						<br/><br/>
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
				<div id="d_footer_gauche">
					<span>
						<p>Orvault Sport Tennis de Table - Tous droits R&eacute;serv&eacute;s - Cr&eacute;ation et Design par LaBuche & fl0</p>
					</span>
				</div>
				<div id="d_footer_droite">
					<span>
						<a href="http://www.fftt.com" target="_blank" title="F&eacute;d&eacute;ration Fran�aise de Tennis de Table"><img src="themes/ttBlue/pages/img/lien_FFTT.png"/></a>
					</span>
					&nbsp;&nbsp;&nbsp;
					<span class="s_logos">
						<a href="http://www.cdtt44.fr" target="_blank" title="Comit&eacute; de Tennis de Table de Loire-Atlantique"><img src="themes/ttBlue/pages/img/lien_CDTT44.png"/></a>
					</span>
				</div>
			</div>
			<!-- Fin div footer -->
			
		</div>
		<!-- Fin div global -->
	</body>
	
</html>


