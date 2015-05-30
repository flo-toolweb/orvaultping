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

$oNews = new news();
$tNews = $oNews->GetNewsList()
?>


<div id="d_news">	
		
	<?php 
	foreach ( $tNews as $cle=>$value ) {
		if ( $cle <= 10 ) {
	?>
			<div class="d_news_global">	
				<div class="d_news_titre">	
					<span class="s_news_titre">&nbsp;<?php echo $tNews[$cle]['news_titre']; ?>&nbsp;</span>
				</div>
				<div class="d_news_global_2">	
					<div class="d_news_contenu">	
						<span class="s_news_contenu">
							<?php echo $oNews->interpretTag($tNews[$cle]['news_contenu']);  ?>
						</span>
					</div>
					<div class="d_news_footer">		
						<?php $tDate = toDateTimeFr($tNews[$cle]['news_date']); ?>
						<span class="s_news_date">le <?php echo $tDate['date']; ?>&nbsp;&nbsp;&agrave; <?php echo $tDate['heure']; ?></span>							
						<span class="s_news_auteur">par <?php echo $tNews[$cle]['news_auteur']; ?></span>
					</div>
				</div>
			</div>
			<!-- Fin div news_contenu -->
			<?php
		}
	}
	?>
	
</div>
<!-- Fin div news -->
	