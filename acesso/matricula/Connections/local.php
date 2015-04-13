<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_PRADOSIS = "177.70.22.184";
$database_PRADOSIS = "underweb_pincel";
$username_PRADOSIS = "underweb_pincel";
$password_PRADOSIS = "CEDTEC2014Pincel";
$PRADOSIS = mysql_pconnect($hostname_PRADOSIS, $username_PRADOSIS, $password_PRADOSIS) or trigger_error(mysql_error(),E_USER_ERROR); 
?>