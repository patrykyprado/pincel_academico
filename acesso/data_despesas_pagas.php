<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

?>

<?php 
$inicio = $_GET['dataini'];
$conta = $_GET['conta'];
$fim = $_GET['datafin'];

if($conta == "*"){
	if($user_unidade == ""){
		$sql_filtro = "";
	} else {
		$sql_filtro = "AND conta_nome LIKE '%$user_unidade%'";
	}
	$conta_nome = "Geral";
} else {
	$sql_filtro = "AND conta LIKE '$conta'";
	$sql_conta = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
	$dados_conta = mysql_fetch_array($sql_conta);
	$conta_nome = $dados_conta["conta"];
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
                              <b>T&iacute;tulos Pagos</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="get" action="data_despesas_pagas.php">
Conta: 
    <select name="conta" class="textBox" id="conta" style="width:auto;">
    <option value="<?php echo $conta; ?>" selected="selected"><?php echo $conta_nome;?></option>
    <option value="*">Geral</option>
    <?php
include ('menu/config_drop.php');?>
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
  De: 
  <input type="date" name="dataini" id="dataini" value="<?php echo $inicio;?>"/>
At&eacute;: 
<input type="date" name="datafin" id="datafin" value="<?php echo $fim;?>" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<hr />
<table width="100%" border="1" class="table table-hover">
	<tr bgcolor="#E7E7E7">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Cliente / Fornecedor</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><font color="blue"><strong>Vencimento</strong></font></div></td>
        <td><div align="center"><font color="blue"><strong>Valor</strong></font></div></td>
        <td><div align="center"><strong>Data de Efetiva&ccedil;&atilde;o</strong></div></td>
        <td><div align="center"><strong>Valor Efetivado</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';
$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 1 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND valor_pagto <> '' $sql_filtro ORDER BY data_pagto,conta, nome");

$sql_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM geral_titulos WHERE tipo_titulo = 1 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND valor_pagto <> '' $sql_filtro ORDER BY data_pagto, nome");
$dados_sum = mysql_fetch_array($sql_sum);
// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = substr(strtoupper($dados["nome"]),0,20)."...";
		$parcela          = $dados["parcela"];
		$conta          = $dados["conta_nome"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"];
		$valortitulofinal	= number_format($valortitulo, 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = number_format($dados["valor_pagto"], 2, ',', '.');
		$ccusto          = $dados["c_custo"];
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
        echo "
	<tr>
		<td align='center'>
		<a rel=\"shadowbox\" href=\"ver_titulo.php?id=$idtitulo\"><font size=\"+1\"><div class=\"fa fa-eye tooltips\" data-placement=\"right\" data-original-title=\"Visualizar Título\"></div></font></a>
		</td>
		<td>$cliente</td>
		<td align=\"center\">$parcela</td>
		<td align=\"center\"><font color=\"blue\">$venc</font></td>
		<td align=\"right\"><b><font color=\"blue\">R$ $valortitulofinal</font></b></td>
		<td align=\"center\">$pagamento</td>
		<td align=\"right\"><b>R$ $valorpagt</b></center></td>
		<td>$conta</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
<tr>
		<td colspan="8"><strong>Valor Total Efetivado: R$ <?php echo number_format($dados_sum["total"], 2, ',', '.');?></strong></td>
	</tr>
</table>
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
		$(function(){
			$('#cc3').change(function(){
				if( $(this).val() ) {
					$('#cc4').hide();
					$('.carregando').show();
					$.getJSON('cc4.ajax.php?search=',{cc3: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc4 + '">' + j[i].nome_cc4 + '</option>';
						}	
						$('#cc4').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc4').html('<option value="">– CC4 –</option>');
				}
			});
		});
		</script>
        




	    <script type="text/javascript">
		$(function(){
			$('#cc4').change(function(){
				if( $(this).val() ) {
					$('#cc5').hide();
					$('.carregando').show();
					$.getJSON('cc5.ajax.php?search=',{cc4: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc5 + '">' + j[i].nome_cc5 + '</option>';
						}	
						$('#cc5').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc5').html('<option value="">– CC5 –</option>');
				}
			});
		});
		</script>
        
        
        
	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#fornecedor').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
						}	
						$('#fornecedor').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#fornecedor').html('<option value="">– Cliente-Fornecedor –</option>');
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
