<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Template de le page d'accueil*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('include/class_news.php');
include('include/class_fetes.php');

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
		<?php 
		    if (TYPE_ENV == 'prod') {
                echo '<meta name="Robots" content="index, follow"/>';
            }
            else {
                echo '<meta name="Robots" content="noindex, nofollow"/>';
            }
        ?>
		<title>Orvault Sport Tennis de Table - Accueil</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $oNavigation->dossier.'styles.css';?>"/>
		<link href="./favicon.png" type="image/x-icon" rel="shortcut icon"/>
		<script type="text/javascript" src="./js/lib/prototype.js"></script>
		<script src="./js/lib/jquery-1.6.2.js" type="text/javascript"></script>
		<script type="text/javascript" src="./js/include/login.js"></script>
		<script type="text/javascript" src="./js/include/home.js"></script>
		<!--<script type="text/javascript" src="./js/include/template.js"></script>-->
		<!--[if lte IE 8]> 
		<script type="text/javascript" src="./js/lib/roundies.js"> 
		</script>
		<script type="text/javascript">
			DD_roundies.addRule('div#d_news_titre', '5px');
			DD_roundies.addRule('div.d_news_contenu', '10px');
			DD_roundies.addRule('div#d_id_titre', '5px'); 
			DD_roundies.addRule('div#d_id_connec', '7px'); 
			DD_roundies.addRule('div#d_connec_ok', '7px'); 
			DD_roundies.addRule('div#d_deco_ok', '7px'); 
			DD_roundies.addRule('div#d_connec_error', '7px');
			DD_roundies.addRule('a.a_boutons_int', '12px'); 
		</script>
		
		<![endif]-->

	</head>
	
	<body >
		<div id="upImages">
			<img src="themes/ttBlue/home/img/btn_inscription_on.png" alt="Prechargement de l'image"/>
		</div>
		<div id="d_global">
			<div id="d_header">		
				<div id="d_header_gauche">
					<div id="d_id">	
						<div id="d_id_titre">	
							<p>Identification</p>
						</div>
							
						<div id="d_id_contenu">	
							<?php affId(); ?>
						</div>
					</div>
					<div id="d_erreur">
						<?php
							if (isset($_GET['msg']) && ($_GET['msg']=='droits')){ ?>
								<span id="s_erreur">
								Vous n'avez pas les droits pour acc&eacute;der &agrave; cette page
								</span>
							<?php
							}
						?>		
					</div>
					<!-- Fin div erreur -->
					<!--
					<div id="d_inscription">	
						<a href="index.php?page=inscriptions" id="a_inscription"><img src="themes/ttBlue/home/img/spacer.gif"  alt=""/></a>
					</div>
					-->
				</div>
				<!-- Fin div header_gauche -->
				<div id="d_header_droite">
					<div id="d_news">	
						<div id="d_news_titre" class="arrondi">	
							<p><a href="index.php?page=news" title="Acc&eacute;der &agrave; la page des actualit�s du club">
								Vie du club
							</a></p>
						</div>		
						<?php 
							$oNews = new News();
							$tNews1 = $oNews -> getNewsHome(0); 
							$tNews2 = $oNews -> getNewsHome(1); 
						?>					
						<div class="d_news_contenu">	
							<!-- News 1 -->
							<span class="s_news_titre"><?php echo $tNews1['news_titre']; ?></span>
							<br/>
							<?php
								// On coupe les news si n�cessaire
								$oNews -> affNewsHome($tNews1['news_contenu']); 
							?>
								
							<div class="d_news_footer">	
								<?php $tDate = toDateTimeFr($tNews1['news_date']); ?>
								<span class="s_news_date">le <?php echo $tDate['date']; ?>&nbsp;&nbsp;&agrave; <?php echo $tDate['heure']; ?></span>							
								<span class="s_news_auteur">par <?php echo $tNews1['news_auteur']; ?></span>
							</div>	
							<div class="d_clear"></div>
							<div class="d_separation"></div>
							<!-- News 2 -->
							<span class="s_news_titre"><?php echo $tNews2['news_titre']; ?></span>
							<br/>
							<?php
								// Affichage du contenu de la news
								$oNews -> affNewsHome($tNews2['news_contenu']); 
							?>
								
							<div class="d_news_footer">	
								<?php $tDate = toDateTimeFr($tNews2['news_date']); ?>
								<span class="s_news_date">le <?php echo $tDate['date']; ?>&nbsp;&nbsp;&agrave; <?php echo $tDate['heure']; ?></span>							
								<span class="s_news_auteur">par <?php echo $tNews2['news_auteur']; ?></span>
							</div>
						</div>
					</div>
					<!-- Fin div news -->
					<!--
					<div id="d_calendrier">	
						<div id="d_txt_calendrier">
							<a href="https://www.google.com/calendar/embed?title=Agenda&amp;showTitle=0&amp;showTz=0
									&amp;mode=MONTH&amp;height=600&amp;wkst=2&amp;hl=fr&amp;bgcolor=%23FFFFFF
									&amp;src=orvaultsport%40googlemail.com&amp;color=%23A32929
									&amp;src=vasf3gmcmgakl1100eibjqmq2g%40group.calendar.google.com&amp;color=%230D7813
									&amp;src=q258cim1568jfsdqsn1r5pgeco%40group.calendar.google.com&amp;color=%231B887A
									&amp;src=31s8l2hgsv3ve5m6n7gj8uotuc%40group.calendar.google.com&amp;color=%232952A3
									&amp;src=5ksrmc8hdb2ccl03a3l1iccpag%40group.calendar.google.com&amp;color=%237A367A
									&amp;src=pbibskkgp8bbkjuioi85731pds%40group.calendar.google.com&amp;color=%23BE6D00
									&amp;src=fr.french%23holiday%40group.v.calendar.google.com&amp;color=%234E5D6C&amp;ctz=Europe%2FParis" 
									target="_blank" title="Calendrier du Club - Lien externe Google Calendar">	
								Calendrier du club
							</a>	
						</div>
					</div>
					-->
					<div id="d_photos">					
						<?php 
							$oPhotoWeek = new photoWeek("./photos");
							if ( !tableIsEmpty($oPhotoWeek->tablePhotoWeek) ) {
								$tPhotoWeek = $oPhotoWeek->getPhotoWeek();
						?>
						<a id="a_txt_photos" href="#" onclick="centrage_popup('themes/ttBlue/popup/photoWeekPopup.php', 
													<?php echo $tPhotoWeek['photoWeek_largeur']+30; ?>,
													<?php echo $tPhotoWeek['photoWeek_hauteur']+40; ?>,
													'scrollbars=1, toolbar=0, titlebar=0, status=0, resizable=1');"
													title="Afficher la photo : <?php echo stripSlashes($tPhotoWeek['photoWeek_description']); ?>"
													>
							
							<!--<img src="./photos/photoWeek/mini/<?php echo $tPhotoWeek['photoWeek_nomMini']; ?>" 
								title="<?php echo stripSlashes($tPhotoWeek['photoWeek_description']); ?>"
								alt="<?php echo stripSlashes($tPhotoWeek['photoWeek_description']); ?>"
							/>	-->
							<img src="./photos/photoWeek/mini/<?php echo $tPhotoWeek['photoWeek_nomMini']; ?>" 
								title="<?php echo stripSlashes($tPhotoWeek['photoWeek_description']); ?>"
								alt="<?php echo stripSlashes($tPhotoWeek['photoWeek_description']); ?>"
								id="photo_semaine_mini"
							/>	
							Photo de la semaine
						</a>					
						</span>
						<?php } ?>
					</div>
					<!-- Fin div photos -->
				</div>
				<!-- Fin div header_droite-->
			</div>
			<!-- Fin div header -->
			<div id="d_contenu">
				<div id="d_menu">				
					<img src="themes/ttBlue/home/img/img_btn_le_club.png" alt="Image bouton Le club"/>
					<a href="index.php?page=le_club" title="Toutes les informations sur le club" class="a_boutons_int" id="a_le_club">
						Le club
					</a>
					<img src="themes/ttBlue/home/img/img_btn_equipes.png" alt=""/>						
					<a href="index.php?page=equipes" title="Page de pr�sentation des �quipes" class="a_boutons_int" id="a_equipes">
						&Eacute;quipes
					</a>
					<img src="themes/ttBlue/home/img/img_btn_joueurs.png" alt=""/>
					<a href="index.php?page=joueurs" title="Liste des joueurs du club" class="a_boutons_int" id="a_joueurs">
						Joueurs
					</a>		
					<img src="themes/ttBlue/home/img/img_btn_forum.png" alt=""/>
					<a href="index.php?page=forum_liste" atitle="Le forum - Utilisateurs connect�s uniquement" class="a_boutons_int" id="a_forum">	
						Forum
					</a>		
					<img src="themes/ttBlue/home/img/img_btn_photos.png" alt=""/>
					<a href="index.php?page=medias" title="Les photos et les vid�os du club" class="a_boutons_int" id="a_medias">	
						M&eacute;dias
					</a>	
					<img src="themes/ttBlue/home/img/img_btn_contacts.png" alt=""/>
					<a href="index.php?page=contact-plan" title="Page des contacts et du plan d'acc�s" class="a_boutons_int" id="a_contacts">	
						Contacts/Plan
					</a>	
					<img src="themes/ttBlue/home/img/img_btn_partenaires.png" alt=""/>
					<a href="index.php?page=partenaires" title="Liste des partenaires du club"  class="a_boutons_int" id="a_partenaires">	
						Partenaires
					</a>
				</div>
				<!-- Fin div menu-->
				<div id="d_charlie">
					<img src="themes/ttBlue/home/img/nous_sommes_tous_charlie.png" alt=""/>
				</div>
				<div id="d_ephemeride">
					<span id="s_ephemeride_texte">
						<?php
							$oFetes = new Fetes();
							$tt=time();
							$mois=date("m",$tt);
							$jour=date("d",$tt);
							$prenom = $oFetes -> getPrenom($jour, $mois); 
							
							echo dateFullFr();
							if ( $prenom != "0" ) {	
								echo " - Nous f&ecirc;tons aujourd'hui la saint ".$prenom." ! ";
							}
							

						?>
					</span>
				</div>
				<!-- Fin div ephemeride -->
			</div>
			<div id="d_footer">
				<!--
				<div id="d_compte_a_rebours">
					<div id="d_compte_a_rebours_row_head">
						<span>Jours</span>
						<span>Heures</span>
						<span>Minutes</span>
						<span>Secondes</span>
					</div>
					<div id="d_compte_a_rebours_row_values">
						<span id="s_compte_a_rebours_jours"></span>
						<span id="s_compte_a_rebours_heures"></span>
						<span id="s_compte_a_rebours_minutes"></span>
						<span id="s_compte_a_rebours_secondes"></span>
					</div>				
					<div id="d_compte_a_rebours_texte">
						Bient�t la nouvelle salle :-)
					</div>				
				</div>
				-->
				<span class="s_logos">
					<a href="http://www.fftt.com" target="_blank" title="F&eacute;d&eacute;ration Fran�aise de Tennis de Table"><img src="themes/ttBlue/home/img/lien_FFTT.png" alt="Logo FFTT"/></a>
				</span>
				<span class="s_logos">
					<a href="http://www.cdtt44.fr" target="_blank" title="Comit&eacute; de Tennis de Table de Loire-Atlantique"><img src="themes/ttBlue/home/img/lien_CDTT44.png" alt="Logo CDTT44"/></a>
				</span>
			</div>
			<!-- Fin div footer -->
		</div>
		<!-- Fin div global -->
	</body>
	
</html>
