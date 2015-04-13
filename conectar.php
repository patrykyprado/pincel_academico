<?php 
$host = '177.70.22.184'; // endereço do seu mysql
$user = 'underweb_pincel'; // usuário
$pass = 'CEDTEC2014Pincel'; // senha
$con = mysql_connect($host,$user,$pass); // função de conexão
$db = 'underweb_pincel'; // nome do banco de dados
mysql_select_db($db,$con) or print mysql_error(); // seleção do banco de dados

?>