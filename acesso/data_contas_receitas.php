<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$conta = $_GET['conta'];
$dataini = $_GET["dataini"];
$diaini = substr($dataini,0,2);
$mesini = substr($dataini,3,2);
$anoini = substr($dataini,6,4);
$inicio = $anoini."-".$mesini."-".$diaini;

$datafin = $_GET["datafin"];
$diafin = substr($datafin,0,2);
$mesfin = substr($datafin,3,2);
$anofin = substr($datafin,6,4);
$fim = $anofin."-".$mesfin."-".$diafin;
$transacao = $_GET['transacao'];
$empresa = $_GET['empresa'];
$trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ',);
$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y',);
$unidade = str_replace($trocarIsso, $porIsso, $_GET['unidade']);

if ($empresa == "*") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR UMA EMPRESA')
    window.location.href='contas_apagar.php';
    </SCRIPT>");
	return;
}
if ($inicio == "" || $fim =="") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR UM PERÍODO')
    window.location.href='contas_apagar.php';
    </SCRIPT>");
	return;
}
include 'includes/conectar.php';
$pesq_conta = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
$dados = mysql_fetch_array($pesq_conta);
$pesq_emp = mysql_query("SELECT * FROM cc1 WHERE id_empresa LIKE '$empresa'");
$dados2 = mysql_fetch_array($pesq_emp);
if($unidade == "*"){
	$contaexib = "Contas (".$dados2['nome_cc1'].")";
} else {
	$contaexib = $dados["conta"];
	}
if($conta == "*"){
	$contaexib = "Contas (".strtoupper($unidade).")";
	}
if($transacao == "*"){
	$transacaoexib="Todas";	
	$sql_order = "ORDER BY vencimento, nome";
}
if($transacao == "<>"){
	$transacaoexib="Recebidas";	
	$transacao2 = "is not";
	$sql_order = "ORDER BY processamento, nome";
	$sql_filtro = "(data_pagto BETWEEN '$inicio' AND '$fim')";
}
if($transacao == "="){
	$transacaoexib="A Receber";
	$transacao2 = "is";
	$sql_order = "ORDER BY vencimento, nome";
	$sql_filtro = "(vencimento BETWEEN '$inicio' AND '$fim')";
}
if($user_unidade ==""){
	$comp_sql = "";
} else {
	$comp_sql = " AND conta_nome LIKE '%$user_unidade%'";
}

if($conta == "B00CB" || $conta == "X00CB"){
	$unidade = "";	
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
                              <b>Relat&oacute;rio: Contas a Receber / Recebidas</b>
                          </header>
                          <div class="panel-body">
<div class="filtro">
<form id="form1" name="form1" method="get" action="data_contas_receitas.php">
Empresa: 
    <select name="empresa" class="textBox" id="empresa">
    <option value="*" selected="selected">Selecione</option>
    <?php
include 'menu/config_drop.php';?>
    <?php
	if($user_empresa == 0){
		$sql = "SELECT * FROM cc1 ORDER BY nome_cc1";
	} else {
		$sql = "SELECT * FROM cc1 WHERE id_empresa = $user_empresa ORDER BY nome_cc1";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
  </select>
  Unidade: 
    <select name="unidade" class="textBox" id="unidade">
    <option value="*" selected="selected">Geral</option>
  </select>
  Conta: 
    <select name="conta" class="textBox" id="conta">
    <option value="*" selected="selected">Geral</option>
  </select>
    <br />De:
<input class="default-date-picker" name="dataini"  maxlength="10" size="16" type="text" value="" />
at&eacute; <input class="default-date-picker" name="datafin"  maxlength="10" size="16" type="text" value="" />
Transa&ccedil;&atilde;o: 
    <select name="transacao" class="textBox" id="transacao">
    <option value="<>">Recebidas</option>
    <option value="=">A Receber</option>
  </select>
<input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" />
</form>
</div>
<table width="100%" border="1" class="full_table_receitas">
	<tr>
    <th colspan="2"><img src="images/logo-color.png" width="70" /><br />Pincel At&ocirc;mico <br /><font size="-5"><?php echo date("d/m/Y h:m:s");?></font></th>
    <th colspan="6">Relat&oacute;rio de Receitas (<?php echo $transacaoexib;?>)<br />Conta: <?php echo $contaexib; ?><br /> Per&iacute;odo: <?php echo substr($inicio,8,2)."/".substr($inicio,5,2)."/".substr($inicio,0,4) ;?> at&eacute; <?php echo substr($fim,8,2)."/".substr($fim,5,2)."/".substr($fim,0,4) ;?></th>
    
    </tr>
	<tr>
		<td><div align="center"><strong>T&iacute;tulo</strong></div></td>
		<td><div align="center"><strong>Fornecedor</strong></div></td>
        <td><div align="center"><strong>Descri&ccedil;&atilde;o</strong></div></td>
        <td style="color:#03C"><div align="center"><strong>Vencimento</strong></div></td>
        <td style="color:#03C"><div align="center"><strong>Valor</strong></div></td>
        <td><div align="center"><strong>Efetiva&ccedil;&atilde;o</strong></div></td>
        <td><div align="center"><strong>Valor</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php


//TODAS UNIDADES
if($unidade=="*"&&$transacao =="*"&&$conta <>"*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE status = 0 AND  $sql_filtro AND (tipo_titulo = 2 OR tipo_titulo = 99) AND conta LIKE '$conta' AND empresa LIKE '$empresa' $comp_sql $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM data_pagto WHERE status = 0 AND (vencimento BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto is null OR data_pagto ='') AND empresa LIKE '$empresa' $comp_sql");
	$despesa2 = mysql_query("SELECT SUM( valor_pagto ) as despesapaga FROM data_pagto WHERE status = 0 AND  (data_pagto BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (valor_pagto > 0 OR data_pagto <>'') AND empresa LIKE '$empresa' $comp_sql");
}
if($unidade=="*"&&$transacao =="*"&&$conta =="*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE status = 0 AND  $sql_filtro AND (tipo_titulo = 2 OR tipo_titulo = 99) AND empresa LIKE '$empresa' $comp_sql $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE status = 0 AND  (vencimento BETWEEN '$inicio' AND '$fim') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto is null OR data_pagto ='') AND empresa LIKE '$empresa' $comp_sql");
	$despesa2 = mysql_query("SELECT SUM( valor_pagto ) as despesapaga FROM geral_titulos WHERE status = 0 AND  (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (valor_pagto > 0 OR data_pagto <>'') AND empresa LIKE '$empresa' $comp_sql");
}
if($unidade=="*"&&$transacao <>"*"&&$conta =="*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE status = 0 AND  $sql_filtro AND (tipo_titulo = 2 OR tipo_titulo = 99) AND data_pagto $transacao '' AND empresa LIKE '$empresa' $comp_sql $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE status = 0 AND  (vencimento BETWEEN '$inicio' AND '$fim') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto is null OR data_pagto ='') AND empresa LIKE '$empresa' $comp_sql");
	$despesa2 = mysql_query("SELECT SUM( valor_pagto ) as despesapaga FROM geral_titulos WHERE status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (valor_pagto > 0 OR data_pagto <>'') AND empresa LIKE '$empresa' $comp_sql");
}
if($unidade=="*"&&$transacao <>"*"&&$conta <>"*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE status = 0 AND  $sql_filtro AND (tipo_titulo = 2 OR tipo_titulo = 99) AND conta LIKE '$conta' AND data_pagto $transacao '' AND empresa LIKE '$empresa' $comp_sql $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE status = 0 AND  (vencimento BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto is null OR data_pagto ='') AND empresa LIKE '$empresa' $comp_sql");
	$despesa2 = mysql_query("SELECT SUM( valor_pagto ) as despesapaga FROM geral_titulos WHERE status = 0 AND  (data_pagto BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (valor_pagto > 0 OR data_pagto <>'') AND empresa LIKE '$empresa' $comp_sql");
}

//UNIDADES SELECIONADAS
if($unidade<>"*"&&$transacao =="*"&&$conta <>"*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE status = 0 AND  $sql_filtro AND (tipo_titulo = 2 OR tipo_titulo = 99) AND conta LIKE '$conta' AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa' $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE status = 0 AND  (vencimento BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto is null OR data_pagto ='') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor_pagto ) as despesapaga FROM geral_titulos WHERE status = 0 AND  (data_pagto BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (valor_pagto > 0 OR data_pagto <>'') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
}
if($unidade<>"*"&&$transacao =="*"&&$conta =="*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE status = 0 AND  $sql_filtro AND (tipo_titulo = 2 OR tipo_titulo = 99) AND conta_nome LIKE '%$unidade%' $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE status = 0 AND  (vencimento BETWEEN '$inicio' AND '$fim') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto is null OR data_pagto ='') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor_pagto ) as despesapaga FROM geral_titulos WHERE  status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (valor_pagto > 0 OR data_pagto <>'') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
}
if($unidade<>"*"&&$transacao <>"*"&&$conta =="*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE status = 0 AND  $sql_filtro AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto $transacao '' OR data_pagto $transacao2 null) AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa' $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE status = 0 AND  (vencimento BETWEEN '$inicio' AND '$fim') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto is null OR data_pagto ='') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor_pagto ) as despesapaga FROM geral_titulos WHERE status = 0 AND  (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (valor_pagto > 0 OR data_pagto <>'') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
}
if($unidade<>"*"&&$transacao <>"*"&&$conta <>"*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE status = 0 AND  $sql_filtro AND (tipo_titulo = 2 OR tipo_titulo = 99) AND conta LIKE '$conta' AND (data_pagto $transacao '' OR data_pagto $transacao2 null) AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa' $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE status = 0 AND  (vencimento BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (data_pagto is null OR data_pagto ='') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor_pagto ) as despesapaga FROM geral_titulos WHERE status = 0 AND  (data_pagto BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND (valor_pagto > 0 OR data_pagto <>'') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
}


$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($l = mysql_fetch_array($despesa)) {
		$despesapagar = $l["despesapagar"];
	}
	while ($l = mysql_fetch_array($despesa2)) {
		$despesapaga = $l["despesapaga"];
	}
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = strtoupper(substr(($dados["nome"]),0,15));
		$descricao          = strtoupper(substr($dados["descricao"],0,30));
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = number_format($dados["valor"], 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = number_format($dados["valor_pagto"], 2, ',', '.');
		$ccusto          = $dados["c_custo"];
		$conta          = $dados["conta_nome"];
		$sql_alunos = mysql_query("SELECT * FROM alunos WHERE codigo = '$idcli'");
		if(mysql_num_rows($sql_alunos)>=1){
			$dados_aluno = mysql_fetch_array($sql_alunos);
			$cliente          = strtoupper(substr(($dados_aluno["nome"]),0,15));
			
		}
		
		
		$atual = date("Y-m-d");
		if($dados["valor_pagto"] == 0&&$vencimento < $atual){
			$cor = "#F08080";
		} else {
			$cor = "";
		}
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
		
		
		
        echo "
	<tr style=\"background:$cor\">
		<td align='center'><a rel=\"shadowbox\" href=\"ver_titulo.php?id=$idtitulo\">$idtitulo</a></td>
		<td>$cliente...</td>
		<td>$descricao...</td>
		<td style='color:#03C' align='center'>$venc</td>
		<td style='color:#03C' align='right'>R$ $valortitulo</td>
		<td align='center'>$pagamento</td>
		<td align='right'>R$ $valorpagt</td>
		<td>$conta</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="9">
  <strong><font color="#009966">Receitas Confirmadas:</strong> R$ <?php echo number_format($despesapaga, 2, ',', '.'); ?></font><br />
  <strong><font color="#CC0033">Receitas Pendentes:</strong> R$ <?php echo number_format($despesapagar, 2, ',', '.'); ?></font>
  
  
  
  
  </td>
  
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
  

	    <script type="text/javascript">
		$(function(){
			$('#empresa').change(function(){
				if( $(this).val() ) {
					$('#unidade').hide();
					$('.carregando').show();
					$.getJSON('unidade.ajax.php?search=',{empresa: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="*">Geral</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].unidade+ '">' + j[i].unidade_exib + '</option>';
						}	
						$('#unidade').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#unidade').html('<option value="*">Geral</option>');
				}
			});
		});
		</script>
<script type="text/javascript">
		$(function(){
			$('#unidade').change(function(){
				if( $(this).val() ) {
					$('#conta').hide();
					$('.carregando').show();
					$.getJSON('contas.ajax.php?search=',{unidade: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="*">Geral</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].ref_conta + '">' + j[i].conta + '</option>';
						}	
						$('#conta').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#conta').html('<option value="*">Geral</option>');
				}
			});
		});
		</script>
        
          <?php include("includes/js_data.php");?>