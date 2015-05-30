<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Contenu de la page bureau*
#
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

include('include/class_users.php');
include('include/class_equipes.php');

$oUsers = new Users();
$tUsers = $oUsers->GetList();

$oEquipes = new Equipes();
$tEquipes = $oEquipes->GetList();

?>
<div id="d_equipes">
	<br/>
	<div id="d_gauche">
	<?php 
	// Reécupération libellés équipe
	$tLibelles = array();
	foreach ( $tEquipes as $cle=>$value ) {
		if (array_key_exists($tEquipes[$cle]['equipes_libelle'], $tLibelles))
			$tLibelles[$tEquipes[$cle]['equipes_libelle']]++;
		else
			$tLibelles[$tEquipes[$cle]['equipes_libelle']] = 1;
	}
	// Affichage de la liste des equipes
	$curr_type_equipe = "";
	$curr_type_equipe_new = "";
	foreach ( $tEquipes as $cle=>$value ) {
		if ( $tEquipes[$cle]['equipes_id'] != 0 ) {
			if ( $tEquipes[$cle]['equipes_adulte'] != 0 )
				$curr_type_equipe_new = "equipes_adulte";
			else if ( $tEquipes[$cle]['equipes_feminine'] != 0 )
				$curr_type_equipe_new = "equipes_feminine";
			else if ( $tEquipes[$cle]['equipes_veteran'] != 0 )
				$curr_type_equipe_new = "equipes_veteran";
			else
				$curr_type_equipe_new = "equipes_jeune";
				
			if ( $curr_type_equipe != "" && $curr_type_equipe != $curr_type_equipe_new ) { ?>
				<span class="s_equipes_separateur"></span>
			<?php
			}
			$curr_type_equipe = $curr_type_equipe_new;
			?>
			<span class="s_equipes"><p>&#149;&nbsp;
				<a href="javascript:affEquipe(<?php echo $tEquipes[$cle]['equipes_id']; ?>,<?php echo $tEquipes[$cle]['equipes_adulte']; ?>,<?php echo $tEquipes[$cle]['equipes_feminine']; ?>,<?php echo $tEquipes[$cle]['equipes_veteran']; ?>)" 
					title="Composition <?php echo $tEquipes[$cle]['equipes_libelle']; ?>">
					<?php echo $tEquipes[$cle]['equipes_libelle']; ?>					
					<?php			
						if ( $tLibelles[$tEquipes[$cle]['equipes_libelle']] > 1 )
							echo "&nbsp;".$tEquipes[$cle]['equipes_poule']; 
					?>
				</a>
				<br/>
			</span>
		<?php 	
		}
	}
	?>		
	</div>
	<!-- Fin div gauche  -->
	<div id="d_droite">
		<div id="d_aff_equipe">
		
		</div>
	
	</div>
	<!-- Fin div droite  -->

</div>
<!-- Fin div equipes  -->