<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
if(isset($_GET["id"])){
	$get_id_mensagem = $_GET["id"];
} else {
	$get_id_mensagem = 0;
}
?>

  <body>

  <section id="container" >



?>

<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-4">
                      <section class="panel">
                          <header class="panel-heading">
                              Alertas do Sistema
                          </header>
                          <div class="panel-body">
                           	<table width="100%" border="1" class="table table-striped">
                            <tr>
                            	<td width="30%"><iframe width="100%" height="300px" scrolling="no" src="frame_alerta.php"></iframe></td>
                                <td width="70%"><iframe width="100%" height="300px" name="frame_corpo" src="frame_exib_alerta.php?id=<?php echo $get_id_mensagem;?>"></iframe></td>
                            </tr>
                            </table>
                          </div>
                          <div class="panel-footer">
                              <center><a onClick="ShadowClose()" href="javascript:parent.location.reload();">FECHAR</a></center>
                          </div>
                      </section>
                  </div>
                 
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('includes/footer.php');
 ?>
  </section>
 <?php 
 include('includes/js.php');
 ?>


  </body>
</html>
