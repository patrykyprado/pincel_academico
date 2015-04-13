<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$sql_banco = mysql_query("SELECT * FROM ea_banco_questao ORDER BY cursos, nome_bq, grau");
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
                              <b>Banco de Quest&otilde;es</b><br>
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
    <td align="center"><b>Grau de Dificuldade</b></td>
    <td align="center"><b>A&ccedil;ao</b></td>
</tr>
<?php

while($dados_banco = mysql_fetch_array($sql_banco)){
	$banco_id = $dados_banco["id_bq"];
	$banco_cursos = $dados_banco["cursos"];
	$banco_nome = $dados_banco["nome_bq"];
	$banco_grau = $dados_banco["grau"];
	$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = $banco_id");
	$qtd_questao = mysql_num_rows($sql_questoes);

	echo "
	<tr>
	<td align=\"center\">$qtd_questao</td>
	<td align=\"center\">$banco_cursos</td>
    <td><a rel=\"shadowbox\" href=\"ea_add_questao.php?id_bq=$banco_id;\">$banco_nome</a></td>
	<td align=\"center\">$banco_grau</td>
	<td align=\"center\">
	<a rel=\"shadowbox\" href=\"ea_questoes.php?id_bq=$banco_id\"><font size=\"+1\"><div class=\"fa fa-eye tooltips\" data-placement=\"right\" data-original-title=\"Visualizar Questões\"></div></font></a>
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
        
<script language="javascript">
function arrumaEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
var i;
for (i = 0; i < field.form.elements.length; i++)
if (field == field.form.elements[i])
break;
i = (i + 1) % field.form.elements.length;
field.form.elements[i].focus();
return false;
}
else
return true;
}
</script>
    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
    

 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script>