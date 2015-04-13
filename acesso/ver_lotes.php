<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$get_unidade = $_GET["unidade"];
$get_cc1 = $_GET["cc1"];
$get_cc2 = $_GET["cc2"];
$get_cc3 = $_GET["cc3"];;
$inicio = $_GET["inicio"];
$fim = $_GET["fim"];


if($user_empresa == 0){
	$sql_lote = mysql_query("SELECT DISTINCT lote, data, arquivo FROM iss_xml WHERE filial LIKE '%$get_cc2%' ORDER BY lote DESC");
} else {
	$sql_lote = mysql_query("SELECT DISTINCT lote, data, arquivo FROM iss_xml WHERE empresa = $user_empresa AND filial LIKE '%$get_cc2%' ORDER BY  lote DESC");
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
                              <b>Arquivos Gerados - <?php echo $get_unidade;?></b>
                          </header>
                        <div class="panel-body">
<?php
if(mysql_num_rows($sql_lote)==0){
	echo "<center>Nenhum arquivo foi gerado para a empresa e filial selecionada.</center>";
} else {
	echo "<table align=\"center\" border=\"1\" width=\"50%\"> 
	<tr align=\"center\" bgcolor=\"#D7D7D7\">
		<td>Nº de Lote</td>
		<td>Data de Emissão</td>
		<td>Quantidade de Registros</td>
		<td>Arquivo</td>
	</tr>";
		while($dados_lotes = mysql_fetch_array($sql_lote)){
			$lote_num = $dados_lotes["lote"];
			$lote_data = format_data($dados_lotes["data"]);
			$lote_arquivo = $dados_lotes["arquivo"];
			$sql_contar_registros = mysql_query("SELECT count(*) as qtd FROM iss_xml WHERE lote = '$lote_num'");
			$dados_registros = mysql_fetch_array($sql_contar_registros);
			$lote_qtd = $dados_registros["qtd"];
			echo "
			<tr align=\"center\">
				<td>$lote_num</td>
				<td>$lote_data</td>
				<td>$lote_qtd</td>
				<td><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"lotes/$lote_arquivo\" data-original-title=\"Baixar lote $lote_num\"><i class=\"fa fa-arrow-circle-down\"></i></a></td>
			</tr>";
		}
		echo "</table>";
	
}
?>
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