<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$get_conta = $_GET["conta"];
$get_data = $_GET["data"];

$dia = substr($get_data,0,2);
$mes = substr($get_data,3,2);
$ano = substr($get_data,6,4);
$data_final = $ano."-".$mes."-".$dia;
$sql_processamento = mysql_query("SELECT * FROM geral_titulos WHERE processamento LIKE '%$data_final%' AND conta LIKE '$get_conta' AND data_pagto <> '' ORDER BY processamento ASC");
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
                              <b>Relat&oacute;rio: T&iacute;tulos / Processamento</b>
                          </header>
                          <div class="panel-body">
<div class="filtro">
<form id="form1" name="form1" method="GET" action="data_processamento.php">
  Conta: 
    <select name="conta" class="textBox" id="conta">
    <option value="*" selected="selected">Geral</option>
    <?php
include 'menu/config_drop.php';?>
    <?php
if($user_unidade == ""){
		$sql = "SELECT * FROM contas ORDER BY conta";
	} else {
		$sql = "SELECT * FROM contas WHERE conta LIKE '%$user_unidade%' ORDER BY conta";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['ref_conta'] . "'>" . $row['conta'] . "</option>";
}
?>
  </select>
    <br />Data:
<input class="default-date-picker" name="data" required="required"  maxlength="10" size="16" type="text" value="" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
</div>


<table class="full_table_list" width="100%" border="1">
<tr>
<td align="center"><b>T&iacute;tulo</b></td>
<td align="center"><b>Cliente / Fornecedor</b></td>
<td align="center"><b>Vencimento</b></td>
<td align="center"><b>Valor</b></td>
<td align="center"><b>Data de Pagamento</b></td>
<td align="center"><b>Valor Efetivado</b></td>
<td align="center"><b>Conta</b></td>
<td align="center"><b>Processamento</b></td>
</tr>
<?php
while($dados_proc = mysql_fetch_array($sql_processamento)){
	$id_titulo = $dados_proc["id_titulo"];
	$processamento = substr($dados_proc["processamento"],8,2)."/".substr($dados_proc["processamento"],5,2)."/".substr($dados_proc["processamento"],0,4)." ".substr($dados_proc["processamento"],11,8);
	$vencimento = substr($dados_proc["vencimento"],8,2)."/".substr($dados_proc["vencimento"],5,2)."/".substr($dados_proc["vencimento"],0,4);
	$data_pagto = substr($dados_proc["data_pagto"],8,2)."/".substr($dados_proc["data_pagto"],5,2)."/".substr($dados_proc["data_pagto"],0,4);
	$valor = number_format($dados_proc["valor"],2,",",".");
	$valor_pagto = number_format($dados_proc["valor_pagto"],2,",",".");
	$conta = $dados_proc["conta_nome"];
	
	
	//SELECIONA O CLIENTE
	$cod_cliente = $dados_proc["codigo"];
	$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = '$cod_cliente'");
	if(mysql_num_rows($sql_cliente)== 0){
		$sql_cliente2 = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = '$cod_cliente'");
	} else {
		$sql_cliente2 = mysql_query("SELECT * FROM alunos WHERE codigo = '$cod_cliente'");
	}
	$dados_cliente = mysql_fetch_array($sql_cliente2);
	$nome_cliente = substr($dados_cliente["nome"],0,20)."...";
	
	echo "<tr>
		<td align=\"center\"><a rel=\"shadowbox\" href=\"editar.php?id=$id_titulo\">$id_titulo</a></td>
		<td>$nome_cliente</td>
		<td align=\"center\">$vencimento</td>
		<td align=\"right\">$valor</td>
		<td align=\"center\">$data_pagto</td>
		<td align=\"right\">$valor_pagto</td>
		<td>$conta</td>
		<td align=\"center\">$processamento</td>
		
	</tr>";
	
}
?>


</table>

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
  
  
   <?php include("includes/js_data.php");?>