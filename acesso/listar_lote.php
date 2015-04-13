<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

 if( isset ( $_POST[ 'Atualizar' ] ) ) {
		              for( $i = 0 , $x = count( $_POST[ 'titulo' ] ) ; $i < $x ; $i++ ) {
						 
						 mysql_query("UPDATE titulos SET iss = '".$_POST[ 'checkbox' ][$i]."' WHERE id_titulo = '".$_POST[ 'titulo' ][ $i ]."'");
							
		              }
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('TITULOS ATUALIZADOS COM SUCESSO');
			</SCRIPT>");
 }

$get_unidade = $_GET["unidade"];
$get_cc1 = $_GET["cc1"];
$get_cc2 = $_GET["cc2"];
$get_cc3 = $_GET["cc3"];
$get_cc4 = $_GET["cc4"];
$get_cc5 = $_GET["cc5"];
$get_cc6 = $_GET["cc6"];
$get_tipo = $_GET["tipo"];
$inicio = $_GET["inicio"];
$fim = $_GET["fim"];
$get_ebitda = "S";
if($get_tipo == 2){
	$get_tipo2 = 99;
} else {
	$get_tipo2 = 1;
}


if ($inicio == "" || $fim == "") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('É NECESSÁRIO DIGITAR UM PERÍODO')
    history.back();
    </SCRIPT>");
}
if ($get_unidade == "") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('É necessário escolher a unidade')
    history.back();
    </SCRIPT>");
}

//INICIO DO FILTRO
if($get_cc1 == ""){
	$filtro_cc1 ="";	
} else {
	$filtro_cc1 = " AND cc1 = '$get_cc1'";
}
if($get_cc2 == ""){
	$filtro_cc2 ="";	
} else {
	$filtro_cc2 = " AND cc2 = '$get_cc2'";
}
if($get_cc3 == ""){
	$filtro_cc3 ="";	
} else {
	$filtro_cc3 = " AND cc3 = '$get_cc3'";
}
if($get_cc4 == ""){
	$filtro_cc4 ="";	
} else {
	$filtro_cc4 = " AND cc4 = '$get_cc4'";
}
if($get_cc5 == ""){
	$filtro_cc5 ="";	
} else {
	$filtro_cc5  =" AND cc5 = '$get_cc5'";
}
if($get_cc6 == ""){
	$filtro_cc6 ="";	
} else {
	$filtro_cc6 = " AND cc6 = '$get_cc6'";
}
$filtro_tipo = " AND (tipo = '$get_tipo' OR tipo ='$get_tipo2')";
$filtro_ebitda =  " AND ebitda = '$get_ebitda'";
$filtro_ordem = " ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6";
$filtro_status = " AND status = 0";
$filtro_exceto = " AND cc3 <> 90 AND cc5 <> 801";

$query_completa = "SELECT * FROM view_tit_ccusto WHERE (data_pagto BETWEEN '$inicio' AND '$fim')".$filtro_cc1.$filtro_cc2.$filtro_cc3.$filtro_cc4.$filtro_cc5.$filtro_cc6.$filtro_tipo.$filtro_exceto.$filtro_ebitda.$filtro_status.$filtro_ordem;


$filtro_titulo_xml = " AND id_titulo NOT IN (select id_titulo from iss_xml) AND iss LIKE '%S%'";
$query_xml = "SELECT * FROM view_tit_ccusto WHERE (data_pagto BETWEEN '$inicio' AND '$fim')".$filtro_titulo_xml.
$filtro_cc1.$filtro_cc2.$filtro_cc3.$filtro_cc4.$filtro_cc5.$filtro_cc6.$filtro_tipo.$filtro_exceto.$filtro_ebitda.$filtro_status.$filtro_ordem;


$query_soma = "SELECT SUM(valor_pagto) as soma FROM view_tit_ccusto WHERE (data_pagto BETWEEN '$inicio' AND '$fim')".$filtro_cc1.$filtro_cc2.$filtro_cc3.$filtro_cc4.$filtro_cc5.$filtro_cc6.$filtro_tipo.$filtro_exceto.$filtro_ebitda.$filtro_status.$filtro_ordem;

//QUERY'S COMPLETAS
$sql_lote = mysql_query($query_completa);
$sql_xml = mysql_query($query_xml);

$sql_soma = mysql_query($query_soma);
$dados_soma = mysql_fetch_array($sql_soma);


$count = mysql_num_rows($sql_lote);
$count_xml = mysql_num_rows($sql_xml);

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
                              <b>Pesquisa de Lote NF-e<br>T&iacute;tulos ainda n&atilde;o enviados:</b> <?php echo $count_xml;?></b>
                              <div align="left" class="task-option">
                              <a title="" data-placement="left" data-toggle="tooltip" class="tooltips" href="ver_lotes.php?unidade=<?php echo $get_unidade;?>&cc1=<?php echo $get_cc1;?>&cc2=<?php echo $get_cc2;?>&cc3=<?php echo $get_cc3;?>&inicio=<?php echo $inicio;?>&fim=<?php echo $fim;?>" rel="shadowbox" data-original-title="Arquivos Gerados (xml)"><i class="fa fa-archive"></i></a>
                              
                              
                              <a title="" data-placement="left" data-toggle="tooltip" class="tooltips" href="gerar_lote.php?unidade=<?php echo $get_unidade;?>&cc1=<?php echo $get_cc1;?>&cc2=<?php echo $get_cc2;?>&cc3=<?php echo $get_cc3;?>&inicio=<?php echo $inicio;?>&fim=<?php echo $fim;?>" rel="shadowbox" data-original-title="Gerar Lote"><i class="fa fa-asterisk"></i></a>
                              </div>
                          </header>
                          <div class="panel-body">
<form action="#"  method="post">
<input type="submit" value="Atualizar Títulos" name="Atualizar" /> 

  <table style="font-size:10px;" width="100%" border="1">
	<tr bgcolor="#E7E7E7">
		<td><div align="center"><strong>Titulo</strong></div></td>
		<td><div align="center"><strong>Aluno</strong></div></td>
        <td><div align="center"><strong>Respons&aacute;vel</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do Titulo (R$)</strong></div></td>
        <td><div align="center"><strong>Data de Efetiva&ccedil;&atilde;o</strong></div></td>
        <td><div align="center"><strong>Valor Efetivado (R$)</strong></div></td>
        <td><div align="center"><strong>Empresa</strong></div></td>
        <td><div align="center"><strong>Filial</strong></div></td>
        <td><div align="center"><strong>CC3</strong></div></td>
        <td><div align="center"><strong>CC4</strong></div></td>
        <td><div align="center"><strong>CC5</strong></div></td>
        <td><div align="center"><strong>CC6</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
        <td><div align="center"><strong>ISS</strong></div></td>
	</tr>
<?php
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='lote.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem

    while ($dados = mysql_fetch_array($sql_lote)) {
        // enquanto houverem resultados...
		$id_titulo          = $dados["id_titulo"];
		$id_cliente			 = $dados["cliente_fornecedor"];
		$vencimento			 = $dados["vencimento"];
		$valor			 = number_format($dados["valor"], 2, ',', '.');
		$datapagt			 = $dados["data_pagto"];
		$valor_pagto			 = number_format($dados["valor_pagto"], 2, ',', '.');
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
		$b_cc1			 = $dados["cc1"];
		$b_cc2			 = $dados["cc2"];
		$b_cc3			 = $dados["cc3"];
		$b_cc4			 = $dados["cc4"];
		$b_cc5			 = $dados["cc5"];
		$b_cc6			 = $dados["cc6"];
		$conta			 = $dados["conta"];
		$iss_ant		 = $dados["iss"];
		$id_custo			 = $dados["id_custo"];
		$tipo			 = $dados["tipo"];
		if($iss_ant == "S"){
			$iss_nome = "Sim";
			$cor  = "";
		} else {
			$iss_nome = "Não";
			$cor  = "#FFDAB9";
		}
		
		
		
		
		//BUSCA NOME CC1
		$sql_cc1 = mysql_query("SELECT * FROM cc1 WHERE id_empresa = '$b_cc1'");
		$d_cc1 = mysql_fetch_array($sql_cc1);
		$nome_cc1 = $d_cc1["nome_cc1"];
		if(trim($nome_cc1) == ""){
			$nome_cc1 = "----";
		}
		
		//BUSCA NOME CC2
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial = '$b_cc2'");
		$d_cc2 = mysql_fetch_array($sql_cc2);
		$nome_cc2 = utf8_encode($d_cc2["nome_filial"]);
		if(trim($nome_cc2) == ""){
			$nome_cc2 = "----";
		}
		
		//BUSCA NOME CC3
		$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = '$b_cc3'");
		$d_cc3 = mysql_fetch_array($sql_cc3);
		$nome_cc3 = $d_cc3["nome_cc3"];
		if(trim($nome_cc3) == ""){
			$nome_cc3 = "----";
		}
		
		
		//BUSCA NOME CC4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 = '$b_cc4'");
		$d_cc4 = mysql_fetch_array($sql_cc4);
		$nome_cc4 = $d_cc4["nome_cc4"];
		if(trim($nome_cc4) == ""){
			$nome_cc4 = "----";
		}
		
		//BUSCA NOME CC5
		$sql_cc5 = mysql_query("SELECT * FROM cc5 WHERE cc5 = '$b_cc5' AND id_cc5 = '$b_cc4'");
		$d_cc5 = mysql_fetch_array($sql_cc5);
		$nome_cc5 = $d_cc5["nome_cc5"];
		if(trim($nome_cc5) == ""){
			$nome_cc5 = "----";
		}
		
		//BUSCA NOME CC6
		$sql_cc6 = mysql_query("SELECT * FROM cc6 WHERE id_cc6 = '$b_cc6'");
		$d_cc6 = mysql_fetch_array($sql_cc6);
		$nome_cc6 = $d_cc6["nome_cc6"];
		if(trim($nome_cc6) == ""){
			$nome_cc6 = "----";
		}
		
		//BUSCA NOME DA CONTA
		$sql_conta = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
		$d_conta = mysql_fetch_array($sql_conta);
		$nome_conta = $d_conta["conta"];
		
		//BUSCA NOME DO CLIENTE / FORNECEDOR
		$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = '$id_cliente'");
		$total = mysql_num_rows($sql_cliente);
		if($total >= 1){
			$d_cliente = mysql_fetch_array($sql_cliente);
			$nome_cliente = substr($d_cliente["nome"],0,20);
			$nome_cliente2 = substr($d_cliente["nome_fin"],0,20);
		} else {
			$sql_cliente = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = '$id_cliente'");
			$d_cliente = mysql_fetch_array($sql_cliente);
			$nome_cliente = substr($d_cliente["nome"],0,20);
			$nome_cliente2 = substr($d_cliente["nome"],0,20);
		}
		
		


		
		
        echo "
	<tr bgcolor='$cor'>
		<td bgcolor='$cor' align='center'>&nbsp;<a rel=\"shadowbox\" href=\"ver_titulo.php?id=$id_titulo&id2=$id_custo\">$id_titulo</a></td>
		<td bgcolor='$cor'>$nome_cliente..</td>
		<td bgcolor='$cor'>$nome_cliente2..</td>
		<td bgcolor='$cor'>$venc</td>
		<td align='right' bgcolor='$cor'>$valor</td>
		<td bgcolor='$cor'>$pagamento</td>
		<td align='right' bgcolor='$cor'>$valor_pagto</td>
		<td bgcolor='$cor'>$nome_cc1</td>
		<td bgcolor='$cor'>$nome_cc2</td>
		<td bgcolor='$cor'>$nome_cc3</td>
		<td bgcolor='$cor'>$nome_cc4</td>
		<td bgcolor='$cor'>$nome_cc5</td>
		<td bgcolor='$cor'>$nome_cc6</td>
		<td bgcolor='$cor'>$nome_conta</td>
		<td>
		<input name='titulo[]' id='titulo[]' type='hidden' value='$id_titulo' />
		
		<select name='checkbox[]' class='a' id='checkbox[]' style='width:auto; height:25px;'>
    <option value='$iss_ant'>$iss_nome</option>
  	<option value='S'>Sim</option>
    <option value='N'>Não</option>
  </select></td>
	</tr>";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="13">
<strong>Valor Efetivado:</strong> R$ <?php echo number_format($dados_soma["soma"], 2, ',', '.');?><br /></td>
  
</tr>
</table>
</form>
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