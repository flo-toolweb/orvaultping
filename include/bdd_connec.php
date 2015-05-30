<?php

# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================
#
# * Connexion a la base de donnees *
#
# ***** ORVAULT SPORT TENNIS DE TABLE *****
# =========================================

$link = mysql_connect(DB_HOST,DB_USER,DB_PASS) or 
	die("Impossible de se connecter :" . mysql_error());
mysql_select_db(DB_NAME,$link);

?>