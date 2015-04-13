<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_local = "dbmy0062.whservidor.com";
$database_local = "cedtecvirt_2";
$username_local = "cedtecvirt_2";
$password_local = "Marcelo2";
$local = mysql_pconnect($hostname_local, $username_local, $password_local) or trigger_error(mysql_error(),E_USER_ERROR); 

?>