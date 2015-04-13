<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');

$get_cliente = $_GET["id_cliente"];
$get_produto = $_GET["id_produto"];

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
1º Insira o valor total do produto no celular do leitor PagSeguro.<br>
2º Após inserir o valor, clique em OK e selecione a forma de pagamento (Crédito ou Débito).<br>
3º Após selecionar a forma de pagamento selecione a quantidade de parcelas escolhida pelo comprador.<br><br>

Para facilitar segue abaixo os valores e parcelamento escolhido pelo comprador.<br>
<table align="center" border="1">
	<?php
	$sql_compra = mysql_query("SELECT * FROM ced_produtos_parcelamento WHERE id_produto = $get_produto");
	$dados_compra = mysql_fetch_array($sql_compra);
	$compra_parcela = $dados_compra["parcela"];
	$compra_valor_parcela = $dados_compra["valor_parcela"];
	$compra_valor_total = $compra_valor_parcela *$compra_parcela;
	echo "<tr>
	<td align=\"center\"><b>Quantidade de Parcelas</b></td>
	<td align=\"center\"><b>Valor da Parcela</b></td>
	<td align=\"center\"><b>Valor Total</b></td>
	</tr>
	<tr>
	<td align=\"center\"><b>$compra_parcela</b></td>
	<td>R$ $compra_valor_parcela</td>
	<td>R$ $compra_valor_total</td>
	</tr>
	";
	?>
</table>
<br>
4º Confirme o status da transação:<br>
<center><a href="comprovante_pagseguro.php?tipo=1&&id_cliente=<?php echo $get_cliente;?>&&id_produto=<?php echo $get_produto;?>" class="btn btn-xs btn-info"><font size="+1">Aprovada</font></a>
<a href="comprovante_pagseguro.php?tipo=2&&id_cliente=<?php echo $get_cliente;?>&&id_produto=<?php echo $get_produto;?>" class="btn btn-xs btn-warning"><font size="+1">Recusada</font></a>
<a href="comprovante_pagseguro.php?tipo=3&&id_cliente=<?php echo $get_cliente;?>&&id_produto=<?php echo $get_produto;?>" class="btn btn-xs btn-send"><font size="+1">Cancelada</font></a>
</center>
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