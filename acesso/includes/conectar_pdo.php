<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 12/01/15
 * Time: 16:23
 */

//dados
$servidor_mysql = '177.70.22.184';
$nome_banco = 'underweb_pincel';
$usuario = 'underweb_pincel';
$senha = 'CEDTEC2014Pincel';
global $conn;
//conectar o bd
$conn = new PDO("mysql:host=$servidor_mysql;dbname=$nome_banco","$usuario","$senha");

?>