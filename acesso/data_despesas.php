<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$conta = $_GET['conta'];
$inicio = $_GET['dataini'];
$fim = $_GET['datafin'];
if($conta == "*"){
	$exibir_conta = "Geral";
	if($user_unidade == ""){
		$com_sql = ""; //complemento de sql
	} else {
		$com_sql = "AND conta_nome LIKE '%$user_unidade%'"; //complemento de sql
	}
} else {
	$sql_conta = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
	$dados_conta = mysql_fetch_array($sql_conta);
	$exibir_conta = $dados_conta["conta"];
	$com_sql = "AND conta = '$conta'"; //complemento de sql
}
?>
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
                              <b>T&iacute;tulos a Pagar</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="get" action="data_despesas.php">
 Conta: 
    <select name="conta" class="textBox" id="conta" style="width:auto;">
    <option value="<?php echo $conta;?>" selected="selected"><?php echo $exibir_conta;?></option>
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
<BR />
<hr>
<table width="100%" border="1" class="full_table_list">
	<tr bgcolor="#E7E7E7">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Cliente / Fornecedor</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';
$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 1 AND (vencimento BETWEEN '$inicio' AND '$fim') AND (valor_pagto = 0 OR data_pagto = '') $com_sql ORDER BY vencimento, conta");
$despesa = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE tipo_titulo = 1 AND (vencimento BETWEEN '$inicio' AND '$fim') AND (valor_pagto = 0 OR data_pagto = '') $com_sql");

// query para selecionar todos os campos da tabela usu�rios se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca � a vari�vel que foi enviada pelo nosso formul�rio da p�gina anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especifica��o
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    history.back();
    </SCRIPT>");
} else {
    // sen�o
    // se houver mais de um resultado diz quantos resultados existem
	while ($l = mysql_fetch_array($despesa)) {
		$despesaapagar = $l["despesapaga"];
	}
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = substr(strtoupper($dados["nome"]),0,20)."...";
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"]+$dados["acrescimo"];
		$valortitulofinal	= number_format($valortitulo, 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = $dados["valor_pagto"];
		$ccusto          = $dados["c_custo"];
		$conta          = $dados["conta_nome"];
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
		//if(trim($user_nivel) != 1&&trim($user_nivel) != 2&&trim($user_nivel) != 3&&trim($user_nivel) != 4 ){
		//	$comp_excluir = "";
		//} else {
			$comp_excluir = "<a href=\"javascript:aviso($idtitulo)\"><font size=\"+1\"><div class=\"fa fa-trash-o tooltips\" data-placement=\"right\" data-original-title=\"Excluir T�tulo\"></div></font></a>";
		//}
        echo "
	<tr>
		<td align='center'>
		<a rel=\"shadowbox\" href=\"editar.php?id=$idtitulo\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Editar T�tulo\"></div></font></a>
	    $comp_excluir</td>
		<td>&nbsp;$cliente</td>
		<td><center>$parcela</center></td>
		<td><center>$venc</center></td>
		<td align=\"right\"><b>R$ $valortitulofinal</b></td>
		<td><center>&nbsp;$conta</center></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
<tr>
<td colspan="7"><b><font color="#CC0000">PREVIS&Atilde;O DE DESPESA:</font> R$  <?php echo number_format($despesaapagar, 2, ',', '.')?></b></td>
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
					$('#cc4').html('<option value="">� CC4 �</option>');
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
					$('#cc5').html('<option value="">� CC5 �</option>');
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
					$('#fornecedor').html('<option value="">� Cliente-Fornecedor �</option>');
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

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o titulo? '))
{
location.href="apagar_receita.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>