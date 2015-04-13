<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["matricula"];
$codturma = $_GET["td"];
$etapa = $_GET["etapa"];
$grupo_pesq = $_GET["grupo"];

$sql_disciplina = mysql_query("SELECT d.disciplina FROM ced_turma_disc ctd INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
WHERE ctd.codigo = $codturma");
$dados_disciplina = mysql_fetch_array($sql_disciplina);
$nome_disciplina = $dados_disciplina["disciplina"];
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
                              <b>Detalhamento de Atividades e Notas - <?php echo $nome_disciplina?></b>
                          </header>
                        <div class="panel-body">
<table class="table table-hover" border="1">
<tr bgcolor="#D5D5D5" align="center">
<td><b>Atividade</b></td>
<td><b>Data</b></td>
<td><b>Valor</b></td>
<td><b>Descri&ccedil;&atilde;o</b></td>
<td><b>Nota</b></td>
</tr>
<?php
		$pesquisar = mysql_query("SELECT * FROM ced_turma_ativ WHERE id_etapa = $etapa AND cod_turma_d = $codturma AND grupo_ativ = '$grupo_pesq' ORDER BY data;");
		$total = mysql_num_rows($pesquisar);
		while($dados_ativ = mysql_fetch_array($pesquisar)){
			$ref_id = $dados_ativ["ref_id"];
			$cod_ativ = $dados_ativ["cod_ativ"];
			$grupo_ativ = $dados_ativ["grupo_ativ"];
			$valor_ativ = $dados_ativ["valor"];
			$data_ativ = substr($dados_ativ["data"],8,2)."/".substr($dados_ativ["data"],5,2)."/".substr($dados_ativ["data"],0,4);
			$desc_ativ = $dados_ativ["descricao"];
			$nome_ativ = mysql_query("SELECT * FROM ced_desc_nota WHERE  codigo = $cod_ativ;");
			$dados_atividade = mysql_fetch_array($nome_ativ);
			$nome_atividade = ($dados_atividade["atividade"]);
			
			//pesquisa notas anteriores
			$pesq_nota = mysql_query("SELECT * FROM ced_notas WHERE matricula = $id AND ref_ativ = $ref_id AND turma_disc = $codturma");
			$contar_nota = mysql_num_rows($pesq_nota);
			if($contar_nota == 0){
				$nota_aluno = "0,00";
			} else {
				$dados_nota = mysql_fetch_array($pesq_nota);
				$nota_aluno = number_format($dados_nota["nota"],2,",",".");
			}
			if($cod_ativ == 17 || $cod_ativ == 19 ){
				if(strtotime($dados_ativ["data"]) < strtotime(date("Y-m-d"))){
					$exibir_nota = $nota_aluno;
				} else {
					$exibir_nota = "0,00";	
				}
			} else {
				$exibir_nota = $nota_aluno;	
			}
			
			
			
		echo "
		<tr>
			<td align=\"center\">$nome_atividade</font></b></td>
			<td align=\"center\">$data_ativ</font></b></td>
			<td align=\"center\">$valor_ativ</font></b></td>
			<td align=\"center\"><font size=\"-3\">$desc_ativ</font></b></td>
			<td align=\"center\">$exibir_nota</font></b></td>
			
			
		</tr>";
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