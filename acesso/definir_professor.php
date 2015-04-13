<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$turma_disc = $_GET["id"];

if(isset($_GET["salvar"])){
$id           = $_GET["turma_disc"];
$professor         = $_GET["professor"];


if(@mysql_query("UPDATE ced_turma_disc SET cod_prof = '$professor' WHERE codigo = $id")) {
	
		if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Professor definido com sucesso!');
			window.parent.location.reload();
			window.parent.Shadowbox.close();
			</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível definir o professor";
			exit;
		}	
		@mysql_close();
	}


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
                              <b>Defini&ccedil;&atilde;o de Professor</b>
                          </header>
                        <div class="panel-body">
                          <table class="table table-striped table-hover table-bordered" id="editable-sample">
                              <thead>
                              <tr>
                              	  <th align="center">A&ccedil;&atilde;o</th>
                                  <th align="center">C&oacute;digo</th>
                                  <th align="center">Nome</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
						
						//PESQUISA PROFESSORES
						$sql_professores = mysql_query("SELECT * FROM cliente_fornecedor where tipo = 1 ORDER BY nome");
						while($dados_professor = mysql_fetch_array($sql_professores)){
							$codigo = $dados_professor["codigo"];
							$nome = strtoupper($dados_professor["nome"]);
							echo "
							<tr>
                                  <th align=\"center\"><center><a href=\"definir_professor.php?salvar=1&professor=$codigo&turma_disc=$turma_disc\"><font size=\"+1\"><div class=\"fa fa-check-circle tooltips\" data-placement=\"top\" data-original-title=\"Definir $nome como professor desta disciplina\"></div></font></a></center></th>
								  <th align=\"center\">
								  <center><a href=\"definir_professor.php?salvar=1&professor=$codigo&turma_disc=$turma_disc\"><div class=\"tooltips\" data-placement=\"top\" data-original-title=\"Definir $nome como professor desta disciplina\">$codigo</div></a></center>
								  </th>
                                  <th><a href=\"definir_professor.php?salvar=1&professor=$codigo&turma_disc=$turma_disc\"><div class=\"tooltips\" data-placement=\"top\" data-original-title=\"Definir $nome como professor desta disciplina\">$nome</div></a></th>
                              </tr>";
							
						}
						?>
                            </tbody>
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


    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
  <!--script for this page only-->
      <script src="js/editable-table.js"></script>
  <script>
          jQuery(document).ready(function() {
              EditableTable.init();
          });
      </script>