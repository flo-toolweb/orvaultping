<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Méthodes pour l'affichage du div d'identification *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

if ( !defined('LOGIN_AFF') ) {

	define("LOGIN_AFF",true);
	#
	# * Verification de la connexion *
	#
	function affId () {
		if ( verifSession() ) {
			affIdOk();
		}else{
			affIdNone();
		}
	}
	#
	# * Affiche la partie identification si l'utilisateur n'est pas connecté *
	#
	function affIdNone () { ?>
	
		<div id="d_id_connec">	<?php  //echo $_SERVER["HTTP_USER_AGENT"]; ?>
			<form id="form_login" name="form_login" action="javascript:idStart()">
				<?php 
				// Test du navigateur
				$nav_html_5 = 0;
				if (strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox' ) !== false) {$nav_html_5 = 1;}
				if (strpos($_SERVER["HTTP_USER_AGENT"], 'Opera' ) !== false) {$nav_html_5 = 1;}
				if (strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome' ) !== false) {$nav_html_5 = 1;}
				
				if ($nav_html_5 == 1) { // compatible html5
				?>
				<div id="d_id_input">   
						<input type="text" id="id_login" class="form_id"
								name="login" size="12" placeholder="Login" autocomplete="on"
						/>	
						<input type="password" id="id_pass" class="form_id" onfocus="" 
								name="pass" size="10" placeholder="Password" autocomplete="on"
						/>  
				</div>					
				<?php
				} else { // non compatible html5
				?>  
				<div id="d_id_input">  
						<input type="text" id="id_login" class="form_id" onfocus="clearInput('id_login')" 
								name="login" size="12" value="Login"
						/>	
						<input type="password" id="id_pass" class="form_id" onfocus="clearInput('id_pass')" 
								name="pass" size="10" value="Password"
						/>    
				</div>				
				<?php
				}
				?>
				
				<div id="d_id_valid">
					<input type="submit" id="id_submit" value="&nbsp;Valider&nbsp;"/>  
				</div>
			</form>
		</div>
		
	<?php
	}
	#
	# * Affiche la partie identification si l'utilisateur est connecté*
	#
	function affIdOk () { ?>
		<div id="d_id_connec">
			<?php
			if ( $_SESSION['user_statut'] == 3 ) { ?>
			<p>
			
			Etat : connect&eacute; </p>
				<div id="d_menuAdmin">
					<span class="s_menuAdminEx">
						<a href="index.php?page=perso" title="Acc&eacute;der &agrave; cotre espace perso">
							<span class="s_menuAdmin">
								Espace Perso
							</span>
						</a>
					</span>
				</div>
			<?php
			}else{ ?>	
			<p>
			Etat : connect&eacute; </p>
				<div id="d_menuAdmin">
					<span class="s_menuAdminEx">
						<a href="index.php?page=perso" title="Acc&eacute;der &agrave; cotre espace perso">
							<span class="s_menuAdmin">
								Espace Perso
							</span>
						</a>
					</span>
					
					<span class="s_menuAdminEx">
						<a href="admin.php" title="Acc&eacute;der &agrave; l'espace admin">
							<span class="s_menuAdmin">
								Espace Admin	
							</span>
						</a>	
					</span>
				</div>
			<?php
			} ?>
			<div id="d_deco">
				<a href="#" onClick="idDeco()" title="Se d&eacute;connecter">
				D&eacute;connexion
				</a>
			</div>
		</div>
	<?php
	}

	function affConnecOk () { ?>
		<div id="d_connec_ok">
			<p>Connexion r&eacute;ussie</p>
			<script type="text/javascript">setTimeout("affDivId()",1000); </script>
		</div>
	<?php
	}
	
	function affDecoOk () { ?>
		<div id="d_deco_ok">
			<p>D&eacute;connexion effectu&eacute;e</p>
			<script type="text/javascript">setTimeout("affDivId()",1000);</script>	
		</div>
	<?php
	}
	
	function affErrorConnec () { ?>
		<div id="d_connec_error">
			<p>Connexion impossible</p>
			<script type="text/javascript">setTimeout("affDivId()",1000);</script>	
		</div>
	<?php
	}

}
?>