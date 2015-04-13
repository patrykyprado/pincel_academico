<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_local = "177.70.22.184";
$database_local = "underweb_pincel";
$username_local = "underweb_pincel";
$password_local = "CEDTEC2014Pincel";
$local = mysql_pconnect($hostname_local, $username_local, $password_local) or trigger_error(mysql_error(),E_USER_ERROR); 

?>