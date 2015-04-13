<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$conta = $_GET["conta"];
$dataini = $_GET["dataini"];
$diaini = substr($dataini,0,2);
$mesini = substr($dataini,3,2);
$anoini = substr($dataini,6,4);
$datainifinal = $anoini."-".$mesini."-".$diaini;

$datafin = $_GET["datafin"];
$diafin = substr($datafin,0,2);
$mesfin = substr($datafin,3,2);
$anofin = substr($datafin,6,4);
$datafinfinal = $anofin."-".$mesfin."-".$diafin;
$conta2 = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
$conta3 = mysql_fetch_array($conta2);
$contafinal = $conta3["conta"];
$banco = $conta3["banco"];
$agencia = $conta3["agencia"];
$n_conta = $conta3["n_conta"];
$banco1 = mysql_query("SELECT * FROM bancos WHERE codigo LIKE '$banco'");
$banco2 = mysql_fetch_array($banco1);
$bancofinal = $banco2["banco"];
if($conta == "*"){
	$contafinal = "TODOS";
}

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
                              <b>Relat&oacute;rio: Extrato de Contas</b>
                          </header>
                          <div class="panel-body">
<div class="filtro">
<form method="GET" action="caixa_conta.php">
  Conta:
    <select name="conta" class="textBox" id="conta">
    <?php
include("menu/config_drop.php");?>
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
  
  De
   <input class="default-date-picker" name="dataini"  maxlength="10" size="16" type="text" value="" />
at&eacute; <input class="default-date-picker" name="datafin"  maxlength="10" size="16" type="text" value="" />
<input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form></div>
<table width="100%" border="1"  class="full_table_list">
	<tr> 
    	<td colspan="2"><img src="images/logo-color.png"  /></td>
        <td colspan="6"><center><strong>EXTRATO DE CONTA - CEDTEC</strong><center><BR />
          <strong>Conta:</strong> <?php echo $contafinal;?> - <strong>Banco:</strong> <?php echo $bancofinal;?> - <strong>Ag&ecirc;ncia/Conta:</strong></strong> <?php echo $agencia;?>/<?php echo $n_conta;?>
<br />
<strong>Per&iacute;odo:</strong> <?php echo format_data($datainifinal);?> at&eacute;  <?php echo format_data($datafinfinal);?></td>
    </tr>
	<tr>
		<td width="8%" align="center"><div align="center"><strong>Tipo de T&iacute;tulo</strong></div></td>
		<td width="8%"><div align="center"><strong> T&iacute;tulo</strong></div></td>

        <td width="16%"><div align="center"><strong>Vencimento</strong></div></td>
        <td width="17%"><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
 
        <td width="16%"><div align="center"><strong>Data de Pagamento</strong></div></td>
        <td width="18%"><div align="center"><strong>Valor</strong></div></td>
        <td width="17%"><div align="center"><strong>Saldo</strong></div></td>
  </tr>

<?php
include 'includes/conectar.php';
$date = date("Y-m-d");


//OUTRAS CONTAS
if($conta != "*"&&$dataini == ""&&$datafin == ""){
	$saldoanterior = 0;
	
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta like '$conta' AND data_pagto <>'' ORDER BY data_pagto, tipo_titulo DESC");
	$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND conta like '%$conta%'");
	$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%'");
	$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%'");
	
}



//OUTRAS CONTAS - PERIODO INICIAL
if($conta != "*"&&$dataini != ""&&$datafin == ""){
	$despesaant = mysql_query("SELECT SUM( valor_pagto ) as despesaant FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND data_pagto < '$datainifinal' AND conta like '%$conta%'");
	$receitaant = mysql_query("SELECT SUM( valor_pagto ) as receitaant FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto < '$datainifinal' AND conta like '%$conta%'");

	$l = mysql_fetch_array($receitaant);
	$receitaant = $l["receitaant"];
	$l = mysql_fetch_array($despesaant);
	$despesaant = $l["despesaant"];
	$saldoanterior = $receitaant - $despesaant;
	
	
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta like '%$conta%' AND data_pagto >= '$datainifinal' AND data_pagto <>'' ORDER BY data_pagto, tipo_titulo DESC");
	$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND conta like '%$conta%' AND data_pagto >= '$datainifinal'");
	$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%' AND data_pagto >= '$datainifinal'");
	$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%' AND data_pagto >= '$datainifinal'");
	
}


//OUTRAS CONTAS - PERIODO FINAL
if($conta != "*"&&$dataini == ""&&$datafin != ""){
	$despesaant = mysql_query("SELECT SUM( valor_pagto ) as despesaant FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND data_pagto < '$datainifinal' AND conta like '%$conta%'");
	$receitaant = mysql_query("SELECT SUM( valor_pagto ) as receitaant FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto < '$datainifinal' AND conta like '%$conta%'");
	
	$l = mysql_fetch_array($receitaant);
	$receitaant = $l["receitaant"];
	$l = mysql_fetch_array($despesaant);
	$despesaant = $l["despesaant"];
	$saldoanterior = $receitaant - $despesaant;
	
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta like '%$conta%' AND data_pagto =< '$datafinfinal' AND data_pagto <>'' ORDER BY data_pagto, tipo_titulo DESC");
	$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND conta like '%$conta%' AND data_pagto =< '$datafinfinal'");
	$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%' AND data_pagto =< '$datafinfinal'");
	$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%' AND data_pagto =< '$datafinfinal'");
	
}

//OUTRAS CONTAS - PERIODO INICIAL E FINAL
if($conta != '*'&&$dataini != ""&&$datafin != ""){
	$despesaant = mysql_query("SELECT SUM( valor_pagto ) as despesaant FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND data_pagto < '$datainifinal' AND conta like '%$conta%'");
	$receitaant = mysql_query("SELECT SUM( valor_pagto ) as receitaant FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto < '$datainifinal' AND conta like '%$conta%'");
	
	$l = mysql_fetch_array($receitaant);
	$receitaant = $l["receitaant"];
	$l = mysql_fetch_array($despesaant);
	$despesaant = $l["despesaant"];
	$saldoanterior = $receitaant - $despesaant;
	
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE data_pagto BETWEEN '$datainifinal' AND '$datafinfinal' AND conta like '%$conta%' AND data_pagto <>'' ORDER BY data_pagto, tipo_titulo DESC");
	$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND data_pagto BETWEEN '$datainifinal' AND '$datafinfinal' AND conta like '%$conta%'");
	$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto BETWEEN '$datainifinal' AND '$datafinfinal' AND conta like '%$conta%'");
	$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto BETWEEN '$datainifinal' AND '$datafinfinal' AND conta like '%$conta%'");
	
	
}



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='caixa.php';
    </SCRIPT>");
} else {
    // senão
	
    while ($l = mysql_fetch_array($despesa)) {
		$despesaatual = $l["despesaatual"];
	}
    while ($l = mysql_fetch_array($receita2)) {
		$receitaatual = $l["receitaatual"];
	}
    while ($l = mysql_fetch_array($receita3)) {
		$areceber = $l["areceber"];
	}
	
	$valor2 = $saldoanterior;//
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = strtoupper($dados["nome"]);
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = number_format($dados["valor"], 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = number_format($dados["valor_pagto"], 2, ',', '.');
		$tipotitulo          = $dados["tipo_titulo"];
		$ccusto          = $dados["c_custo"];
		//$saldo          = number_format($dados["saldo"], 2, ',', '.');
		$processamento          = $dados["processamento"];
		$procdia = substr($processamento,8,2);
		$procmes = substr($processamento,5,2);
		$procano = substr($processamento,0,4);
		$dataproc = $procdia."/".$procmes."/".$procano;
		$horaproc = substr($processamento,11,8);
		$receita  		= ($receitaatual - $despesaatual) + $saldoanterior;
		if($tipotitulo == 2 || $tipotitulo == 99){
			$tipo = "<font color='blue'><b>+</b></font>";
			$cor = "<font color='black'>R$ $valorpagt</font>";
			$saldo = $valor2 + $dados["valor_pagto"];
			$saldo_exib = number_format($saldo,2,",",".");
		}
		if($tipotitulo == 1){
			$tipo = "<font color='red'><b>-</b></font>";
			$cor = "<font color='red'>R$ $valorpagt</font>";
			$saldo = $valor2 - $dados["valor_pagto"];
			$saldo_exib = number_format($saldo,2,",",".");
		}
		$valor2 = $saldo;
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
        echo "
	<tr align='center'>
		<td align='center'>&nbsp;<strong>$tipo</strong></td>
		<td>&nbsp;<a rel=\"shadowbox\" href=\"editar.php?id=$idtitulo\">$idtitulo</a></td>
		<td>&nbsp;$venc</td>
		<td align='right'>&nbsp;R$ $valortitulo</td>
		<td>&nbsp;$pagamento</td>
		<td align='right'>&nbsp;<strong>$tipo</strong> $cor</td>
		<td align='right'><b>R$ $saldo_exib</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="9"><strong>Saldo em Conta:</strong> <font color="#0000FF">R$ <?php echo $saldo_exib; ?></font></td>
</tr>
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