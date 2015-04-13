<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$sql_banco = mysql_query("SELECT cursos, nome_bq FROM ea_banco_questao
GROUP BY  cursos, nome_bq
ORDER BY cursos, nome_bq");
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Banco de Quest&otilde;es</b>
                              <br>
                               <a rel="shadowbox" href="ea_add_questao.php"><font size="+2"><div class="fa fa-plus-square tooltips" data-placement="top" data-original-title="Adicionar Nova Questão"></div></font></a> 
                                <a rel="shadowbox" href="ea_add_banco.php"><font size="+2"><div class="fa fa-book tooltips" data-placement="top" data-original-title="Adicionar Novo Banco de Questão"></div></font></a> 
                                <a href="ea_banco_questoes.php"><button type="button" class="btn btn-danger tooltips" data-placement="right" data-original-title="Clique aqui para visualizar questões por disciplina."><i class="fa fa-eye"></i> Quest&otilde;es / Disciplina</button></a>
                          </header>
                          <div class="panel-body">
<table class="table table-hover" align="center" width="40%" border="1">
<tr bgcolor="#D9D9D9">
	<td align="center"><b>QTD. Quest&otilde;es</b></td>
    <td align="center"><b>Cursos</b></td>
    <td align="center"><b>Banco de Quest&atilde;o</b></td>
    <td align="center"><b>A&ccedil;ao</b></td>
</tr>
<?php

while($dados_banco = mysql_fetch_array($sql_banco)){
	$banco_cursos = $dados_banco["cursos"];
	$banco_nome = $dados_banco["nome_bq"];
	$sql_id_bqs = mysql_query("SELECT * FROM ea_banco_questao WHERE cursos LIKE '%$banco_cursos%' AND nome_bq LIKE '%$banco_nome%'");
	$ids_bq = "";
	$contador = 1;
	$contar_resultados = mysql_num_rows($sql_id_bqs);
	while($dados_id_bqs = mysql_fetch_array($sql_id_bqs)){
		$id_bq_encontrado = $dados_id_bqs["id_bq"];
		if($contador < $contar_resultados){
			$ids_bq .= $id_bq_encontrado.",";
		} else {
			$ids_bq .= $id_bq_encontrado;
		}
		$contador +=1;
	}

	$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq IN ($ids_bq);");
	$qtd_questao = mysql_num_rows($sql_questoes);

	echo "
	<tr>
	<td align=\"center\">$qtd_questao</td>
	<td align=\"center\">$banco_cursos</td>
    <td>$banco_nome</td>
	<td align=\"center\">
	<a rel=\"shadowbox\" href=\"ea_questoes_geral.php?id_bqs=$ids_bq\"><font size=\"+1\"><div class=\"fa fa-eye tooltips\" data-placement=\"right\" data-original-title=\"Visualizar Questões\"></div></font></a>
	</td>

</tr>
	";
}


?>

</table>
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
        