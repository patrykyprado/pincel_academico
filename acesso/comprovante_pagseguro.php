<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');

$get_cliente = $_GET["id_cliente"];
$get_produto = $_GET["id_produto"];
$get_tipo = $_GET["tipo"];

if($get_tipo == 1){
	$tipo_transacao = "Pagamento Aprovado";	
}
if($get_tipo == 2){
	$tipo_transacao = "Pagamento Recusado Pela Operadora";	
}
if($get_tipo == 3){
	$tipo_transacao = "Pagamento Cancelado";	
}


	$sql_compra = mysql_query("SELECT * FROM ced_produtos_parcelamento WHERE id_produto = $get_produto");
	$dados_compra = mysql_fetch_array($sql_compra);
	$compra_parcela = $dados_compra["parcela"];
	$compra_valor_parcela = $dados_compra["valor_parcela"];
	$compra_valor_sem_juros = $dados_compra["valor_total"];
	$compra_valor_total = $compra_valor_parcela *$compra_parcela;
	
	$sql_aluno = mysql_query("SELECT nome FROM alunos WHERE codigo = $get_cliente");
	$dados_aluno = mysql_fetch_array($sql_aluno);
	
?>


<body>

  <section id="container" class="sidebar-closed" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                <div class="col-md-12">
                  <section class="panel">
                          <header class="panel-heading">
                              <b>Finalizar Pagamento</b>
                          </header>
                          <div class="panel-body">
<center><b>Comprovante de Transa&ccedil;&atilde;o - <?php echo $tipo_transacao;?></b></center>
<br><br>
Recebemos o valor de R$ <?php echo format_valor($compra_valor_total);?> referente a compra de material did&aacute;tico do aluno <?php echo $dados_aluno["nome"];?>.<br>
Detalhes da Transa&ccedil;&atilde;o:<br>
<table align="center" border="1">
<?php 
echo "<tr>
	<td align=\"center\"><b>Quantidade de Parcelas</b></td>
	<td align=\"center\"><b>Valor da Parcela</b></td>
	<td align=\"center\"><b>Valor Total</b></td>
	<td align=\"center\"><b>Valor Maquina</b></td>
	</tr>
	<tr>
	<td align=\"center\"><b>$compra_parcela</b></td>
	<td>R$ $compra_valor_parcela</td>
	<td>R$ $compra_valor_total</td>
	<td>R$ $compra_valor_sem_juros</td>
	</tr>
	";
	?>
</table>
<br><br><br><br>
<center>____________________________________________________<br>
Setor Financeiro</center>
<br><br>
<div align="right"><?php echo format_data_escrita(date("Y-m-d"));?></div>
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