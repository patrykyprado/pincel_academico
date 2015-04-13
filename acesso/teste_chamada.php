<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

?>
<script language="javascript" src="js/jquery_chamada.js"></script>
<script language="javascript" src="js/funcoes.js"></script>

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
                              <b>Chamada</b>
                          </header>
                        <div class="panel-body">
<div class="diario" id="diario">
<table border="1" style="border:1px solid;">

	<tr>
    	<td>Patryky Prado de Oliveira</td>
        <td valign="middle" align="center" width="30px"><a id="frequencia" href="javascript:void(0);" n_aula="1" matricula="100" tipo="P"><div id="100_1">P</div></a></td>
        <td valign="middle" align="center" width="30px"><a id="frequencia" href="javascript:void(0);" n_aula="2" matricula="100" tipo="P"><div id="100_2">P</div></a></td>

    </tr>
</table>
</div>
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


  </body>
</html>