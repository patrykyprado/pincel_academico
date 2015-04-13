<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexao = "177.70.22.184";
$database_conexao = "underweb_pincel";
$username_conexao = "underweb_pincel";
$password_conexao = "CEDTEC2014Pincel";
$conexao = mysql_pconnect($hostname_conexao, $username_conexao, $password_conexao) or trigger_error(mysql_error(),E_USER_ERROR); 
?>