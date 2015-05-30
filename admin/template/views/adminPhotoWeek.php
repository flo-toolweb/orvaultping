<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Affichage de l'administration de la photo de la semaine *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

$oPhotoWeek = new photoWeek("photos");
?>


	<!-- Fin div NewsList -->
	<div id="">
		<div id="">
			<?php $oPhotoWeek->affAjoutPhotoWeek(); ?>
		</div>
	</div>
	<div id="d_list">
	<br/><br/>
	<b>Photo de la semaine actuelle</b><br/><br/>
	<?php 
		if ( !tableIsEmpty($oPhotoWeek->tablePhotoWeek) ) {
			$tPhotoWeek = $oPhotoWeek->getPhotoWeek();
			?>
			<a href="#" onClick="centrage_popup('themes/ttBlue/popup/photoWeekPopup.php', 
								<?php echo $tPhotoWeek['photoWeek_largeur']+30; ?>,
								<?php echo $tPhotoWeek['photoWeek_hauteur']+40; ?>,
								'scrollbars=1, toolbar=0, titlebar=0, status=0, resizable=0');">
			<img src="./photos/photoWeek/mini/<?php echo $tPhotoWeek['photoWeek_nomMini']; ?>"
			title="<?php echo $tPhotoWeek['photoWeek_description']; ?>"
			/>
			</a>
		<?php
		}
		?>
	</div><br/>