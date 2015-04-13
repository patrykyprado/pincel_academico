<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
?>

  <body>

  <section id="container" >
<?php
include ('includes/topo.php');
include ('includes/funcoes.php');
include ('includes/menu_lateral.php');
?>

<?php


include('incs/'.$user_nivel_pagina);
//verifica restri??o de usu?rio
$sql_status_user = mysql_query("SELECT * FROM users WHERE id_user = '$user_iduser'");
$_SESSION["tipo_usuario"] = 1;
if(mysql_num_rows($sql_status_user)==0){
	$_SESSION["tipo_usuario"] = 2;
	$sql_status_user = mysql_query("SELECT * FROM acesso WHERE codigo = $user_usuario");
}
$dados_status_user = mysql_fetch_array($sql_status_user);
$restricao_login = $dados_status_user["status"];
if($restricao_login == 1){
	header("Location: confirmar_dados_acesso.php"); 	
}
if($restricao_login == 2){
	header("Location: ../index.php?erro=2"); 	
}
?>


 <?php 
 include('includes/footer.php');
 ?>
  </section>
<?php
 include('includes/js.php');?>


  </body>
</html>
