<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id_turma = $_GET["id_turma"];


$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_cod_turma = $dados_turma["cod_turma"];
$turma_nivel = format_curso($dados_turma["nivel"]);
$turma_curso = format_curso($dados_turma["curso"]);
$turma_modulo = $dados_turma["modulo"];
$turma_unidade = strtoupper($dados_turma["unidade"]);
$turma_polo = $dados_turma["polo"];
$turma_turno = $dados_turma["turno"];
$turma_grupo = $dados_turma["grupo"];
$turma_anograde = $dados_turma["anograde"];
$turma_tipo_etapa = $dados_turma["tipo_etapa"];

if($turma_modulo == 1){
	$modulo_exib = "I"; 	
	$garantia_contratual = 0;
}
if($turma_modulo == 2){
	$modulo_exib = "II";
	$garantia_contratual = 1; 	
}
if($turma_modulo == 3){
	$modulo_exib = "III"; 
	$garantia_contratual = 1;	
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
                              <b>Rematr&iacute;cula de Turma</b>
                              <br><font size="-2"><?php echo $turma_nivel.": ".$turma_curso." Mód. ".$modulo_exib." - ".$turma_unidade." / ".$turma_polo." (".$turma_grupo.")";?></font>
                              
                              <div align="left" class="task-option">
<a target="_blank" href="gerar_rematricula.php?id_turma=<?php echo $id_turma?>&garantia=<?php echo $garantia_contratual;?>" class="btn btn-xs btn-warning">Gerar Rematr&iacute;cula</a>
                              </div>
                          </header>
                        <div class="panel-body">
<table border="1" width="100%">
	
<?
	$sql_alunos = mysql_query("SELECT DISTINCT alu.codigo, alu.nome 
FROM ced_turma_aluno cta 
INNER JOIN alunos alu
ON cta.matricula = alu.codigo
WHERE cta.id_turma = $id_turma ORDER BY alu.nome
");
	if(mysql_num_rows($sql_alunos)==0){
		"";
	} else {
		echo "<tr  bgcolor=\"#DDDDDD\">
    	<td align=\"center\"><b>Matrícula</b></td>
        <td align=\"center\"><b>Nome</b></td>
        <td align=\"center\"><b>Situação</b></td>
    </tr>";
		while($dados_aluno_turma = mysql_fetch_array($sql_alunos)){
			$aluno_matricula = $dados_aluno_turma["codigo"];
			$aluno_nome = format_curso($dados_aluno_turma["nome"]);
			$situacao_exib = "Pendente";
			
			echo "<tr>
			<td align=\"center\">$aluno_matricula</td>
			<td>$aluno_nome</td>
			<td align=\"center\"><b>$situacao_exib</b></td>
		</tr>";
		}
	}
?>

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