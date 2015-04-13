<!DOCTYPE html>
<html lang="en">
<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/topo_inside_ead.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');

$get_estudo_id_envio = $_GET["id_envio"];
//VERIFICA COMENTARIO ANTERIOR
$sql_comentario = mysql_query("SELECT * FROM ea_estudo_envio WHERE id_envio = $get_estudo_id_envio");
if(mysql_num_rows($sql_comentario)>=1){
	$dados_comentario = mysql_fetch_array($sql_comentario);
	$comentario = $dados_comentario["comentario"];
} else {
	$comentario = "";	
}


?>
  <body>

  <section id="container" class="sidebar-closed">


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Registro de Nota Individual</b>
                          </header>
                        <div class="panel-body">
<div id="central" style="margin-bottom:100px;">
<table class="full_table_list" width="100%" align="center">
<tr>
	<td align="center"><b>Comentario do Tutor</b></td>
</tr>

<tr>
	<td><?php echo $comentario?></td>
</tr>
</table>
                          </div>
                          <div class="panel-footer">
                          </div>
                      </section>
                 
              </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('../includes/footer.php');
 ?>
  </section>
 <?php 
 include('../includes/js_ead.php');
 ?>


  </body>
</html>
