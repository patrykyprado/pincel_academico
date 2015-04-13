<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$get_id = $_GET["id"];
$get_id_cliente = $_GET["id_cliente"];

$sql_produtos = mysql_query("SELECT * FROM ced_tipo_produto WHERE id_produto = $get_id");
$dados_produto = mysql_fetch_array($sql_produtos);

$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = $get_id_cliente");
$dados_cliente = mysql_fetch_array($sql_cliente);
$nome_cliente = $dados_cliente["nome"];
require_once("../PagSeguroLibrary/PagSeguroLibrary.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$post_produto_id = $_POST["id_produto"];
	$post_produto_parcelamento = $_POST["qtd_parcelas"];
	$comprador_nome = $_POST["nome_cliente"];
	$comprador_email = $_POST["email_cliente"];
	$comprador_ddd = $_POST["ddd_cliente"];
	$comprador_telefone = $_POST["telefone_cliente"];
	$post_id_cliente = $_POST["id_cliente"];
	$tipo_pagamento = $_POST["tipo_pagamento"];
	
	//PEGA DADOS DO PRODUTO E PAGAMENTO SELECIONADO
	$sql_produto_parcelamento = mysql_query("SELECT * FROM ced_produtos_parcelamento WHERE tipo_produto = $post_produto_id AND parcela = $post_produto_parcelamento");
	$dados_produto_parcelamento = mysql_fetch_array($sql_produto_parcelamento);
	$valor_produto = floatval($dados_produto_parcelamento["valor_total"]);
	$descricao_produto = remover_acentos($dados_produto_parcelamento["descricao"]);
	$conta_produto = $dados_produto_parcelamento["conta"];
	$produto_parcelamento_id = $dados_produto_parcelamento["id_produto"];
		//PEGA CREDENCIAIS DA CONTA
		$sql_conta = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta_produto'");
		$dados_conta = mysql_fetch_array($sql_conta);
		$conta_pagseguro_email = $dados_conta["pagseguro_email"];
		$conta_pagseguro_tokem = $dados_conta["pagseguro_tokem"];
		$conta_ref_conta = $dados_conta["ref_conta"];
		$processamento = date("Y-m-d H:i:s");
		//ADICIONA OS DADOS DA COMPRA NO HISTÓRICO
		mysql_query("INSERT INTO ced_compras_pagseguro (id_compra, id_cliente, id_parcelamento, situacao, conta, processamento) VALUES (NULL, '$post_id_cliente', '$produto_parcelamento_id','1','$conta_produto','$processamento')");
		//sleep(4);
		//$sql_compras = mysql_query("SELECT * FROM ced_compras_pagseguro WHERE id_cliente = '$post_id_cliente' AND processamento = '$processamento'");
		//$dados_compra = mysql_fetch_array($sql_compras);
		//$ref_compra = $dados_compra["id_produto"];
	if($tipo_pagamento == "WEB"){
		//GERA O PAGAMENTO NO PAGSEGURO
		$paymentRequest = new PagSeguroPaymentRequest();
		$paymentRequest->addItem($post_produto_id,"aaa",1, $valor_produto);
		$paymentRequest->setSender(
		$comprador_nome,
		$comprador_email,
		$comprador_ddd,
		$comprador_telefone);
		$paymentRequest->setCurrency("BRL");
		$paymentRequest->setShippingType(3);
		$paymentRequest->setReference($post_produto_id);
		
	
		$PagSeguroConfig['credentials'] = Array();  
		$PagSeguroConfig['credentials']['email'] = "livraria.tecnica@cedtec.com.br";  
		$PagSeguroConfig['credentials']['token'] = "3B364D50044745B08701F146C9F1B420";
		$credentials = PagSeguroConfig::getAccountCredentials();
		$url = $paymentRequest->register($credentials); 
		header("Location: $url");  
		echo "<br><br><br><br>".$PagSeguroConfig['credentials']['email'] ." - ".$PagSeguroConfig['credentials']['token'];
	} else {
		header("Location: confirmar_pagseguro.php?id_cliente=$post_id_cliente&id_produto=$produto_parcelamento_id");
	}
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
                              <b>Detalhe de Produto</b><br>
                              <b>Cliente Selecionado: </b> <?php echo $nome_cliente;?> (<?php echo $get_id_cliente;?>)
                          
                          </header>
                        <div class="panel-body">
<form action="#" method="POST">
<table width="50%" border="1" align="center">
<tr>
	<td colspan="2" align="center">WEB: <input name="tipo_pagamento" checked type="radio" value="WEB"/> | Máquina: <input type="radio" onClick="habilitar(this.checked)" name="tipo_pagamento" value="DC"/></td>
</tr>
<tr>
	<td>Cliente <font size="+1" color="#FF0004"><b>*</b></font></td>
    <td><input required type="text" style="width:100%"  name="nome_cliente" value="<?php echo format_curso($dados_cliente["nome_fin"]);?>"/>
    <input required type="hidden" style="width:100%"  name="id_cliente" value="<?php echo $get_id_cliente;?>"/>
    </td>
</tr>
<tr>
	<td>E-mail <font size="+1" color="#FF0004"><b>*</b></font></td>
    <td><input required type="text" style="width:100%"  name="email_cliente" value="<?php echo ($dados_cliente["email"]);?>"/>
    </td>
</tr>
<tr>
	<td>Telefone <font size="+1" color="#FF0004"><b>*</b></font></td>
    <td>DDD<input  required type="text"  style="width:30px"  name="ddd_cliente" value=""/> - <input type="text"  style="width:100px" required name="telefone_cliente" value=""/>
    </td>
</tr>

<tr>
	<td>Id. Produto</td>
    <td><input type="text" readonly name="id_produto2" value="<?php echo $get_id;?>"/>
    <input type="hidden" name="id_produto" value="<?php echo $get_id;?>"/>
    <input type="hidden" name="id_cliente" value="<?php echo $get_id_cliente;?>"/></td>
</tr>
<tr>
	<td colspan="2" bgcolor="#D9D9D9" align="center">Pagamento <font size="+1" color="#FF0004"><b>*</b></font></td>
</tr>
<tr>
    <td colspan="2"><?php
	$sql_parcelamento = mysql_query("SELECT * FROM ced_produtos_parcelamento WHERE tipo_produto = $get_id ORDER BY parcela");
    if(mysql_num_rows($sql_parcelamento)>=1){
		echo "<table width=\"100%\" class=\"tabela_parcelamento\" border=\"1\">
		<tr>
			<td align=\"center\" bgcolor=\"#E0E0E0\"><b>&nbsp;</b></td>
			<td align=\"center\" bgcolor=\"#E0E0E0\"><b>Qtd. Parcelas</b></td>
			<td align=\"center\" bgcolor=\"#E0E0E0\"><b>Valor Parcela</b></td>
			<td align=\"center\" bgcolor=\"#E0E0E0\"><b>Valor Final</b></td>
		</tr>
		";
		while($dados_parcelamento = mysql_fetch_array($sql_parcelamento)){
			$parcelamento_parcela = $dados_parcelamento["parcela"];
			$parcelamento_valor_parcela = format_valor($dados_parcelamento["valor_parcela"]);
			$parcelamento_valor_final = format_valor($dados_parcelamento["parcela"] * $dados_parcelamento["valor_parcela"]);
			echo "
		<tr>
			<td align=\"center\"><input required name=\"qtd_parcelas\" type=\"radio\" value=\"$parcelamento_parcela\"></td>
			<td align=\"center\">$parcelamento_parcela</td>
			<td align=\"right\">$parcelamento_valor_parcela</td>
			<td align=\"right\">$parcelamento_valor_final</td>
		</tr>
		";
		}
		echo "</table>";
	}
	?>
	</td>
</tr>
<tr>
	<td valign="top">Descri&ccedil;&atilde;o</td>
    <td valign="top"><input type="text" readonly name="id_produto2" style="width:100%; height:100px;" value="<?php echo $dados_produto["tipo_produto"];?>"/></td>
</tr>
<tr>
	<td colspan="2" valign="top" align="center"><input value="Finalizar Pedido" type="submit"/></td>
</tr>



</form>
                          </div>
                      </section>
                 
              </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('includes/js.php');
 ?>

<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('tipo_pagamento').value=="WEB"){  
        document.getElementById('pagamento_aprovado').disabled = true;  
    } else {  
        document.getElementById('pagamento_aprovado').disabled = false;  
    }  
}  
</script> 
  </body>
</html>


    
