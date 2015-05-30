<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Contenu de la page des infos personnelles*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('include/class_users.php');

$oUsers = new users();

$user_id = $_SESSION['user_id'];


?>


<div id="d_sous_menu">
	<i>Informations personnelles</i>
	&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="index.php?page=password" title="Modifier votre mot de passe">
	Modifier votre mot de passe</a>
	
</div>
<div id="d_aff_infos_ext">	
<?php
	if (isset($_GET['msg']) && ($_GET['msg']=='ok')){ ?>
		<div class="d_msg">
			Nouveau mot de passe enregistr&eacute;
		</div>
	<?php
	}
	?>
	<div id="d_aff_infos">
		<?php $oUsers -> affInfosPerso($user_id); ?>
	</div>
</div>
<br/>
<div id="">
	* Ces données ne seront accessibles qu'aux membres du club.
</div>