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
                              <b>Relat&oacute;rio: Fechamento</b><br>
                              <font size="-1"><strong>Conta:</strong> <?php echo $contafinal;?> - <strong>Banco:</strong> <?php echo $bancofinal;?> - <strong>Ag&ecirc;ncia/Conta:</strong></strong> <?php echo $agencia;?>/<?php echo $n_conta;?>
<br />
<strong>Per&iacute;odo:</strong> <?php echo format_data($datainifinal);?> at&eacute;  <?php echo format_data($datafinfinal);?></font>
                          </header>
                          <div class="panel-body">
<table width="100%" border="1" class="table table-hover">
	<tr>
		<td width="5%" align="center"><div align="center"><strong>Tipo de Receita</strong></div></td>
		<td><div align="center"><strong> Data de Fechamento</strong></div></td>

        <td><div align="center"><strong>Valor</strong></div></td>
       
  </tr>

<?php
include 'includes/conectar.php';
$date = date("Y-m-d");


if($conta =='selecione'){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR A CONTA')
    history.go(-1);
    </SCRIPT>");
	return;
}



//TODAS AS CONTAS
if($conta == '*'&&$dataini == ""&&$datafin == ""){
	
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
	
}
//TODAS AS CONTAS - PERIODO INICIAL
if($conta == '*'&&$dataini != ""&&$datafin == ""){
	
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND data_pagto >='$datainifinal' GROUP BY tipo, data_pagto ORDER BY data_pagto");

}

//TODAS AS CONTAS - PERIODO FINAL
if($conta == '*'&&$dataini == ""&&$datafin != ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND data_pagto <='$datainifinal' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
	
}


//OUTRAS CONTAS
if($conta != "*"&&$dataini == ""&&$datafin == ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND conta =  '$conta' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
}



//OUTRAS CONTAS - PERIODO INICIAL
if($conta != "*"&&$dataini != ""&&$datafin == ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND conta =  '$conta' AND data_pagto >='$datainifinal' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
}


//OUTRAS CONTAS - PERIODO FINAL
if($conta != "*"&&$dataini == ""&&$datafin != ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND conta =  '$conta' AND data_pagto <='$datafinfinal' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
}

//OUTRAS CONTAS - PERIODO INICIAL E FINAL
if($conta != '*'&&$dataini != ""&&$datafin != ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND conta =  '$conta' AND (data_pagto BETWEEN '$datainifinal' AND '$datafinfinal') GROUP BY tipo, data_pagto ORDER BY data_pagto");
}



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($extrato);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem

    while ($dados = mysql_fetch_array($extrato)) {
        // enquanto houverem resultados...
		$valor          = $dados["VALOR"];
		$valorfinal		= number_format($valor, 2, ',', '.');
		$data			 = $dados["DATA"];
		$tipotitulo          = $dados["TIPO"];
		$dia = substr($data,8,2);
		$mes = substr($data,5,2);
		$ano = substr($data,0,4);
		$datafinal = $dia."/".$mes."/".$ano;
		if($tipotitulo == 2 || $tipotitulo == 99){
			$tipo = "<font color='blue'><b>+</b></font>";
			$cor = "<font color='black'>R$ $valorfinal</font>";
		}
		if($tipotitulo == 1){
			$tipo = "<font color='red'><b>-</b></font>";
			$cor = "<font color='red'>R$ $valorfinal</font>";
		}
        echo "
	<tr align='center'>
		<td align='center'>&nbsp;<strong>$tipo</strong></td>
		<td>&nbsp;$datafinal</td>
		<td>&nbsp;<a rel=\"shadowbox\" href=\"detalhe_fechamento.php?data=$data&tipo=$tipotitulo&conta=$conta\">$tipo  $cor</a></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
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