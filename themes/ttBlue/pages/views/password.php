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
	<a href="index.php?page=perso" title="Page de gestion de vos donn&eacute;e personnelles">
	Informations personnelles</a>
	&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
	<i>Modifier votre mot de passe</i>
	
</div>
<br/>
<div id="d_aff_infos">
	<?php
	if (isset($_GET['msg']) && ($_GET['msg']=='wrong')){ ?>
		<div class="d_msg">
			Mot de passe incorrect
		</div>
	<?php
	}
	if (isset($_GET['msg']) && ($_GET['msg']=='lenght')){ ?>
		<div class="d_msg">
			Nouveau mot de passe trop court
		</div>
	<?php
	}
	if (isset($_GET['msg']) && ($_GET['msg']=='diff')){ ?>
		<div class="d_msg">
			Confirmation du mot de passe &eacute;chou&eacute;e
		</div>
	<?php
	}
	$oUsers -> affPassword($user_id); 
	?>
</div>
<br/><br/>
<div id="">
	* Votre mot de passe doit compter au minimum 8 caract&egrave;res
</div>
<br/>