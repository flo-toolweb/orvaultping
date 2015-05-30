<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Méthodes pour l'affichage des liens personnels *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if ( !defined('LOGIN_AFF') ) {

	define("LOGIN_AFF",true);

	function affId () {
		if ( verifSession() ) {
			affIdOk();
		}else{
			affIdNone();
		}
	}

	function affIdNone () { ?>
			<form id="form_login" name="form_login" action="include/login_submit.php" method="post">
				<fieldset>
					<legend>Identification</legend>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_login">
								login :
							</label>
						</span>
						<span class="c_form_droite">      
							<input type="text" id="id_login" name="login" size="10">
						</span>
						</div><br/>
					<div class="d_row">
						<span class="c_form_gauche">
							<label for="id_pass">
								mot de passe :
							</label>
						</span>
						<span class="c_form_droite">       
							<input type="text" id="id_pass" name="pass" size="10">   
						</span>
						</div><br/>
					<div class="d_row">
						<input type="button" id="id_submit" onClick="idStart()" size="" value="OK"> 
					</div>
	            </fieldset>
			</form>
	<?php
	}

	function affIdOk () { ?>
		<?php echo $_SESSION['user_prenom']."&nbsp;".$_SESSION['user_nom'] ?> <br/>
		Vous &ecirc;tes connect&eacute;(e) <br/>
		<a href="#" onClick="idDeco()">D&eacute;connexion</a>
	<?php
	}

	function affConnecOk () { ?>
		<br/>Connexion r&eacute;ussie
		<script type="text/javascript">setTimeout("affDivId()",800); </script>
	<?php
	}
	
	function affDecoOk () { ?>
		<br/>D&eacute;onnexion effectu&eacute;e
		<script type="text/javascript">setTimeout("affDivId()",800);</script>	
	<?php
	}
}
?>