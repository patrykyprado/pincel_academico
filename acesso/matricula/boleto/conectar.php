<?php
/*
*Nome: Sistema de Cadastro 1.0
*Autor: Caio Cйsar
*Descriзгo: Verifica se e possнvel conectar ao banco de dado
*/
//nome do servidor
$host = "177.70.22.184";
//nome de usuбrio
$user = "underweb_pincel";
//senha de usuбrio
$senha = "CEDTEC2014Pincel";
//nome do banco de dados
$dbname = "underweb_pincel";

//conectar ao banco de dados
mysql_connect($host, $user, $senha) or die("Nгo foi possнvel conectar-se com o banco de dados.");
//seleciona o banco de dados
mysql_select_db($dbname) or die("Nгo foi possнvel selecionar o banco de dados.");

?>