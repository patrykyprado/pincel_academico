<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$get_cliente = $_GET["id_cliente"];
$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = $get_cliente");
$dados_cliente = mysql_fetch_array($sql_cliente);
$nome_cliente = $dados_cliente["nome"];

$sql_produtos = mysql_query("SELECT * FROM ced_tipo_produto");
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
                              <b>Produtos Disponíveis</b><br>
                              <b>Cliente Selecionado: </b> <?php echo $nome_cliente;?> (<?php echo $get_cliente;?>)
                          </header>
                          <div class="panel-body">
<?php
if(mysql_num_rows($sql_produtos)>=1){
	echo "<table border=\"1\" width=\"100%\">
	<tr>
		<td align=\"center\"><b>Id. Produto</b></td>
		<td align=\"center\"><b>Tipo</b></td>
		<td align=\"center\"><b>Max. Parcelas</b></td>
		<td align=\"center\"><b>Ação</b></td>
	</tr>"
	;
	while($dados_produto = mysql_fetch_array($sql_produtos)){
		$produto_id = $dados_produto["id_produto"];
		$produto_descricao = $dados_produto["tipo_produto"];
		$sql_detalhe_produto = mysql_query("SELECT * FROM ced_produtos_parcelamento WHERE tipo_produto = $produto_id");
		$produto_parcela = mysql_num_rows($sql_detalhe_produto);
		echo "
			<tr>
				<td align=\"center\"><b>$produto_id</b></td>
				<td>$produto_descricao</td>
				<td align=\"center\"><b>$produto_parcela</b></td>
				<td align=\"center\"><b><a href=\"detalhes_produto.php?id=$produto_id&id_cliente=$get_cliente\">Ver</a></b></td>
			</tr>";
	}
	echo "</table>";
}


/*$sql_compras = mysql_query("SELECT * FROM ced_compras_pagseguro WHERE cliente_fornecedor = '$get_cliente'");
if(mysql_num_rows($sql_compras)>=1){
	while($dados_compras = mysql_fetch_array($sql_compras)){
		
	}
}*/
?>


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
        
<script type="text/javascript" src=
"https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>