<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id_turma = $_GET["id_turma"];
$matricula = $_GET["matricula"];

//PEGA DADOS DA TURMA
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_curso = $dados_turma["curso"];
$turma_nivel = $dados_turma["nivel"];
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
$turma_grade = $dados_turma["anograde"];


//PEGA DISCIPLINAS DA TURMA
$sql_disciplinas = mysql_query("SELECT ctd.codigo, d.disciplina, d.ch 
FROM ced_turma_disc ctd
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = '$turma_grade'
WHERE ctd.id_turma = $id_turma");


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
                          <div class="filtro"><header class="panel-heading">
                              <b>Aproveitamento de Estudos</b>
                          </header>
                          </div>
                        <div class="panel-body">
<table border="1" class="table table-hover">
<tr bgcolor="#CFCFCF">
	<td align="center"><b>Disciplina</b></td>
    <td align="center"><b>Carga Hor&aacute;ria</b></td>
    <td align="center"><b>Situa&ccedil;&atilde;o</b></td>
</tr>

<?
while($dados_disciplinas = mysql_fetch_array($sql_disciplinas)){
	$disciplina_cod = $dados_disciplinas["codigo"];
	$disciplina_nome = $dados_disciplinas["disciplina"];
	$disciplina_ch = $dados_disciplinas["ch"];
	
	//VERIFICA SE HÁ ALGUM APROVEITAMENTO SOLICITADO
	$sql_aproveitamento = mysql_query("SELECT * FROM ced_aproveitamento WHERE id_turma = $id_turma AND turma_disc = $disciplina_cod");
	if(mysql_num_rows($sql_aproveitamento)==0){
		$aproveitamento_status = "Não Solicitado";
	} else {
		$dados_aproveitamento = mysql_fetch_array($sql_aproveitamento);
		$aproveitamento_codigo = $dados_aproveitamento["status"];
		if($aproveitamento_codigo == 0){
			$aproveitamento_status = "<font color=\"blue\">Pendente</font>";
		}
		if($aproveitamento_codigo == 1){
			$aproveitamento_status = "<font color=\"green\">Deferido</font>";
		}
		if($aproveitamento_codigo == 2){
			$aproveitamento_status = "<font color=\"red\">Indeferido</font>";
		}
	}
	
	echo "
	<tr>
	<td><a href=\"solicitacao_aproveitamento.php?id_turma=$id_turma&turma_disc=$disciplina_cod&matricula=$matricula\">$disciplina_nome</a></td>
    <td align=\"center\">$disciplina_ch</td>
    <td align=\"center\"><b>$aproveitamento_status</b></td>
</tr>
	";
}

?>
</table>
</div>

                          </div>
                          <div class="panel-footer">
                              <center><a onClick="window.parent.Shadowbox.close();">FECHAR</a></center>
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


    

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o cliente/fornecedor? '))
{
location.href="apagar_forn.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar_forn.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
function enviar(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor2').value = valor;
this.close();
}
</script>
    </script>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
     
<script>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 