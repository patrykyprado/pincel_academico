<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$dias_atraso = 11;
$data =  date("Y-m-d", time() - ($dias_atraso * 86400));
$unidade = $_GET["unidade"];
$data_ini = $_GET["inicio"];
$data_fin = $_GET["final"];
$empresa = $_GET["empresa"];
$pesq_emp = mysql_query("SELECT * FROM cc1 WHERE id_empresa LIKE '$empresa'");
$dados2 = mysql_fetch_array($pesq_emp);
if ($empresa == "*") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR UMA EMPRESA');
	history.back();
    </SCRIPT>");
	return;
}
if ($data_ini == "") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR A DATA INICIAL');
   history.back();
    </SCRIPT>");
	return;
}
if ($data_fin == "") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR A DATA FINAL');
    history.back();
    </SCRIPT>");
	return;
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
                              <b>Cobran&ccedil;a de Alunos</b>
                          </header>
                          <div class="panel-body">
<div class="filtro">
  <form id="form1" name="form1" method="GET" action="cob_filtro_cobranca.php">
Empresa: 
    <select name="empresa" class="textBox" id="empresa">
    <option value="*" selected="selected">Selecione</option>
    <?php
include("menu/config_drop.php");?>
    <?php
$sql = "SELECT * FROM cc1 ORDER BY nome_cc1";
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
  <input type="date" name="inicio" id="inicio" />
  <input type="date" name="final" id="final" />

<input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" />
</form>
</div>
<table width="80%" border="1" class="table table-striped" align="center">
	<tr>
    <th><img src="images/logo-color.png" width="70" /><br />Pincel At&ocirc;mico <br /><font size="-5"><?php echo date("d/m/Y h:m:s");?></font></th>
    <th align="left" colspan="2">Relat&oacute;rio de Cobran&ccedil;a (<?php echo strtoupper($unidade); ?>)<br />Empresa: <?php echo $dados2["nome_cc1"]; ?><br />Per&iacute;odo: <?php echo substr($data_ini,8,2)."/".substr($data_ini,5,2)."/".substr($data_ini,0,4);?> - <?php echo substr($data_fin,8,2)."/".substr($data_fin,5,2)."/".substr($data_fin,0,4);?></th>
    
    </tr>
	<tr>
		<td><div align="center"><strong>ALUNO</strong></div></td>
        <td><div align="center"><strong>RESP. FINANCEIRO</strong></div></td>
		<td><div align="center"><strong>VALOR DO D&Eacute;BITO</strong></div></td>
	</tr>

<?php



//SELECT
if($unidade <> '*'&&$empresa==10){
	$sql = mysql_query("SELECT codigo, nome, SUM( valor ) as VALORTOTAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND vencimento <  '$data' AND empresa = '$empresa' AND conta_nome LIKE '%$unidade%' AND conta_nome NOT LIKE '%livraria%' AND status = 0 AND (vencimento BETWEEN '$data_ini' AND '$data_fin')  GROUP BY codigo ORDER BY nome");
	$sql_max = mysql_query("SELECT SUM( valor ) as VALOR_FINAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND vencimento <  '$data' AND empresa = '$empresa' AND conta_nome LIKE '%$unidade%' AND conta_nome NOT LIKE '%livraria%' AND status = 0 AND (vencimento BETWEEN '$data_ini' AND '$data_fin') ORDER BY nome");
	$total_valor = mysql_fetch_array($sql_max);
	$sql_max2 = mysql_query("SELECT SUM( valor_pagto ) as VALOR_FATURADO FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto <> '' OR data_pagto is not null) AND tipo = 3 AND vencimento <  '$data'  AND empresa = '$empresa' AND conta_nome LIKE '%$unidade%' AND conta_nome NOT LIKE '%livraria%' AND status = 0  AND (vencimento BETWEEN '$data_ini' AND '$data_fin') ORDER BY nome");
	$total_faturado = mysql_fetch_array($sql_max2);
}
if($unidade == '*'&&$empresa==10){
	$sql = mysql_query("SELECT codigo, nome, SUM( valor ) as VALORTOTAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND vencimento <  '$data' AND empresa = '$empresa' AND conta_nome NOT LIKE '%livraria%' AND status = 0 AND (vencimento BETWEEN '$data_ini' AND '$data_fin') GROUP BY codigo ORDER BY nome");
	$sql_max = mysql_query("SELECT SUM( valor ) as VALOR_FINAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND vencimento <  '$data' AND empresa = '$empresa' AND conta_nome NOT LIKE '%livraria%' AND status = 0 AND (vencimento BETWEEN '$data_ini' AND '$data_fin') ORDER BY nome");
	$total_valor = mysql_fetch_array($sql_max);
	$sql_max2 = mysql_query("SELECT SUM( valor_pagto ) as VALOR_FATURADO FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto <> '' OR data_pagto is not null) AND tipo = 3 AND vencimento <  '$data'  AND empresa = '$empresa' AND conta_nome NOT LIKE '%livraria%' AND status = 0 AND (vencimento BETWEEN '$data_ini' AND '$data_fin') ORDER BY nome");
	$total_faturado = mysql_fetch_array($sql_max2);
	
}

if($unidade == '*'&&$empresa==20){
	$sql = mysql_query("SELECT codigo, nome, SUM( valor ) as VALORTOTAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND vencimento <  '$data' AND empresa = '$empresa' AND conta_nome LIKE '%livraria%' AND status = 0 AND (vencimento BETWEEN '$data_ini' AND '$data_fin') GROUP BY codigo ORDER BY nome");
	$sql_max = mysql_query("SELECT SUM( valor ) as VALOR_FINAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND vencimento <  '$data' AND empresa = '$empresa' AND conta_nome LIKE '%livraria%' AND status = 0 AND (vencimento BETWEEN '$data_ini' AND '$data_fin') ORDER BY nome");
	$total_valor = mysql_fetch_array($sql_max);
	$sql_max2 = mysql_query("SELECT SUM( valor_pagto ) as VALOR_FATURADO FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto <> '' OR data_pagto is not null) AND tipo = 3 AND vencimento <  '$data'  AND empresa = '$empresa' AND conta_nome LIKE '%livraria%' AND status = 0 AND (vencimento BETWEEN '$data_ini' AND '$data_fin') ORDER BY nome");
	$total_faturado = mysql_fetch_array($sql_max2);
	
}
// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
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


    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idcli			 = $dados["codigo"];
		$nome			 = format_curso($dados["nome"]);
		$valortotal			 = number_format($dados["VALORTOTAL"], 2, ',', '.');
		$sql3 = mysql_query("SELECT * FROM alunos WHERE codigo = '$idcli'");
		$dados2 = mysql_fetch_array($sql3);
		$aluno = format_curso($dados2["nome"]);
		if(trim($aluno)==""){
			$aluno == "X";
		}
        echo "
	<tr>
		<td>&nbsp;<a href=\"buscar_receitas2.php?aluno=$aluno&id=$idcli\">$aluno</a></td>
		<td>&nbsp;<a href=\"buscar_receitas2.php?aluno=$aluno&id=$idcli\">$nome</a></td>
		<td align='center'>R$ &nbsp;$valortotal</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="3">
<strong>Valor a Receber: <font color="#FF0000">R$ <?php echo number_format($total_valor["VALOR_FINAL"], 2, ',', '.');?></font></strong></td>
  
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

    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#nivel').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">- Selecione o Curso -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">' + j[i].cursoexib + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="">– Selecione o Curso –</option>');
				}
			});
		});
		</script>
        
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
    
    
<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('projeto').disabled = false;  
    } else {  
        document.getElementById('projeto').disabled = true;  
    }  
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
							options += '<option value="' + j[i].unidade + '">' + j[i].unidade + '</option>';
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
