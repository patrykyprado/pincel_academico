<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head_inside.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$editor = "";


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
                              <b>Lista de Quest&otilde;es</b>
                          </header>
                        <div class="panel-body">
<form method="POST" action="ea_confirm_questionario.php">
<?php 
$get_id_bq = $_GET["id_bq"];
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$get_id_bq' ORDER BY id_questao DESC");
$num_questao = 1;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_capitulo = $dados_questao["capitulo"];
	$questao_inativa = $dados_questao["inativo"];
	if($questao_inativa == 1){
		$cor_inativa = "bgcolor=\"#FFDAB9\"";
		$id_inativo = 1;
	} else {
		$cor_inativa = "";	
		$id_inativo = 0;
	}
	
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table class=\"table table-hover\" border=\"1\" width=\"100%\">
	<tr $cor_inativa >
		<td align=\"center\" valign=\"top\" width=\"17%\"><b><font size=\"+2\">$n_questao - </font><br><font size=\"-2\">Cap. $questao_capitulo</font></b><br>
		
		<a href=\"ea_editar_questao.php?id_questao=$questao_id&cod_questao=$questao_cod\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Editar Questão\"></div></font></a>
		 <a href=\"ea_bloquear_questao.php?id_questao=$questao_id&id_bq=$get_id_bq&id_inativo=$id_inativo\"><font size=\"+1\"><div class=\"fa fa-times-circle tooltips\" data-placement=\"right\" data-original-title=\"Inativar Questão\"></div></font></a></td>
		</td>
		<td colspan=\"2\" valign=\"top\" width=\"80%\"><b><font size=\"+1\">$questao_questao</font></b></td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = trim($dados_opcoes["resposta"]);	
		$letra_opcao = format_letra($num_opcao);
		if($opcaovalor >= 1){
			$cor_resposta = "bgcolor=\"yellow\"";	
		} else {
			$cor_resposta = "";
		}
		echo "
		<tr>
			<td $cor_resposta colspan=\"2\" align=\"right\"><input type=\"radio\" name=\"$questao_cod\" value=\"$opcaoid\"> $letra_opcao </td>
			<td $cor_resposta > $opcaoresposta</td>
		<tr>
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	
 }




?>
</form>
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