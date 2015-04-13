<?php

$servidor = '177.70.22.184';
$usuario = 'underweb_pincel';
$senha = 'CEDTEC2014Pincel';
$banco = 'underweb_pincel';

// Conecta-se ao banco de dados MySQL
$mysqli = new mysqli($servidor, $usuario, $senha, $banco);

// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

?>