<?php 
    print "<b><center> <font size=\"5\" face=\"arial\">Données du serveur : http://$_SERVER[HTTP_HOST] </font></b></center><br>" ;
    $noir = "<font size=\"1\" face=\"verdana\" color=\"#000000\"><b>";
    $rouge = "<font size=\"1\" face=\"verdana\" color=\"#A60000\"><b>";
    $debut = "<font size=\"1\" face=\"verdana\" color=\"#FFFFFF\"> ====== </font>";
    $php_ver = phpversion();
    print "$noir PHP version : $rouge $php_ver <br>";
    foreach ($_SERVER as $key => $info_server) print " $debut $noir \$_SERVER[$key] = $rouge $info_server <br>";

    print " <br>\$PHP_SELF = $PHP_SELF <br>";
    print " <br>\$HTTP_HOST = $HTTP_HOST <br>";
    print "</b></font>";
?> 