<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$get_matricula = $_GET["matricula"]; 
$get_ano =$_GET["ano"]; 
$get_unidade =$_GET["unidade"]; 
$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = '$get_matricula'");
$dados_aluno = mysql_fetch_array($sql_aluno);
$aluno_nome = $dados_aluno["nome"];
$aluno_pai = $dados_aluno["pai"];
$aluno_mae = $dados_aluno["mae"];
$aluno_nascimento = $dados_aluno["nascimento"];
$aluno_responsavel = $dados_aluno["nome_fin"];

//PEGA DADOS DA FILIAL
$sql_filial = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_unidade'");
$dados_filial = mysql_fetch_array($sql_filial);
$filial_cidade = trim($dados_filial["cidade"]);
if($get_unidade == "EA"){
	$filial_cidade = "EAD";	
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
                              <b>Declara&ccedil;&atilde;o IR</b>
                          </header>
                        <div class="panel-body">
<div class="declaracao_ir">
<br /><br /><br /><br />
<table width="100%" border="1">
<tr>
	<td width="200"><img src="images/logo-cedtec.png" width="150"/></td>
    <td><center>
<b><font size="+1"><?php echo $dados_filial["razao"];?></font></b>
</center></td>
</tr>
</table>


<table width="100%">
<tr>
	<td colspan="2"><b>Endere&ccedil;o: <?php echo $dados_filial["endereco"];?></b></td>
</tr>
<tr>
	<td><b>Bairro: <?php echo $dados_filial["bairro"];?></b></td>
    <td><b>CEP: <?php echo $dados_filial["cep"];?></b></td>
</tr>
<tr>
	<td><b>Cidade: <?php echo $dados_filial["cidade"];?></b></td>
    <td><b>Estado: <?php echo $dados_filial["uf"];?></b></td>
</tr>
<tr>
	<td colspan="2"><b>Telefone: <?php echo $dados_filial["telefones"];?></b></td>
</tr>
<tr>
	<td colspan="2"><b>CNPJ: <?php echo $dados_filial["cnpj"];?></b></td>
</tr>
</table>
<br /><br />
<center>
<b><u><font size="+2" style="font-stretch:extra-expanded;">DECLARA&Ccedil;&Atilde;O</font></u></b>
</center>
<p><br />
  <br /> 
  Declaramos para fins de declara&ccedil;&atilde;o de imposto de renda, que o aluno(a) 
  <b><?php echo ($aluno_nome);?></b> nascido(a) em <b><?php echo format_data_escrita_BR($aluno_nascimento);?></b> filho(a) de 
  
  <b><?php echo ($aluno_mae);?></b> e de <b><?php echo ($aluno_pai);?></b>, tendo como respons&aacute;vel financeiro <b><?php echo ($aluno_responsavel);?></b>, esteve matriculado no ano letivo de <b><?php echo $get_ano;?></b> e tendo pago todas as mensalidades abaixo relacionadas.</p>

<br /><br /><br />
<table width="100%" class="full_table_list" border="1">
<tr>
	<td align="center"><b>Parcela</b></td>
    <td align="center"><b>Data do Pagamento</b></td>
    <td align="center"><b>Valor Pago</b></td>
    <td align="center"><b>Tipo</b></td>
</tr>
<?php
$sql_financeiro = mysql_query("SELECT * FROM geral_titulos WHERE (conta_nome LIKE '%$filial_cidade%' OR conta_nome LIKE '%pertel%') AND codigo = '$get_matricula' AND data_pagto LIKE '%$get_ano%' AND valor_pagto <> 0 AND (tipo_titulo =2 OR tipo_titulo = 99) ORDER BY data_pagto");
$parcela = 1;
$valor_total = 0;
while($dados_financeiro = mysql_fetch_array($sql_financeiro)){
	$data_pagto = format_data($dados_financeiro["data_pagto"]);
	$valor_pagto = format_valor($dados_financeiro["valor_pagto"]);
	$valor_total += $dados_financeiro["valor_pagto"];
	echo"
	<tr>
	<td align=\"center\">$parcela</td>
    <td align=\"center\">$data_pagto</td>
    <td align=\"right\">$valor_pagto</td>
    <td align=\"center\">Mensalidade</td>
</tr>
	";
	$parcela +=1;
	
}
?>
<tr>
	<td align="right" colspan="2">Total:</td>
    <td align="right"> R$ <?php echo format_valor($valor_total);?></td>
    <td align="left"></td>

</tr>
</table>
<br />
<?php echo format_data_escrita(date("Y-m-d"));?>
<br /><br /><br /><br />
<center>______________________________________________<br />
<font size="-2"><?php echo $dados_filial["razao"];?><br />
<?php echo $dados_filial["cnpj"];?></font>
</center>
</div>
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
alert("o n� de usu�rio �: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O N�MERO DO T�TULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O T�TULO N�:  "+data))
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
//nome = id do campo que ir� receber o valor, esse campo deve da pagina que gerou o popup
//opener � elemento que faz a vincula��o/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que ir� receber o valor, esse campo deve da pagina que gerou o popup
//opener � elemento que faz a vincula��o/referencia entre a window pai com a window filho ou popup
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