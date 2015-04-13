<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$get_cc1 = $_GET["cc1"];
$get_cc2 = $_GET["cc2"];
$get_cc3 = $_GET["cc3"];
$get_cc4 = $_GET["cc4"];
$get_cc5 = $_GET["cc5"];
$get_cc6 = $_GET["cc6"];
$get_tipo = $_GET["tipo"];

$dataini = $_GET["inicio"];
$diaini = substr($dataini,0,2);
$mesini = substr($dataini,3,2);
$anoini = substr($dataini,6,4);
$inicio = $anoini."-".$mesini."-".$diaini;

$datafin = $_GET["fim"];
$diafin = substr($datafin,0,2);
$mesfin = substr($datafin,3,2);
$anofin = substr($datafin,6,4);
$fim = $anofin."-".$mesfin."-".$diafin;

if($get_tipo == 2){
	$get_tipo2 = 99;
} else {
	$get_tipo2 = 1;
}

if($get_cc2 == ""){
	$filtro_cc2 = "";
} else {
	$filtro_cc2 = " AND cc2 LIKE '$get_cc2'";	
}

if ($inicio == "" || $fim == "") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('É NECESSÁRIO DIGITAR UM PERÍODO')
    history.back();
    </SCRIPT>");
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
                              <b>Relat&oacute;rio: T&iacute;tulos - Centro de Custo</b>
                          </header>
                          <div class="panel-body">
  <table class="full_table_list" width="auto" border="1">
	<tr style="font-size:12px;">
		<td><div align="center"><strong>Titulo</strong></div></td>
		<td><div align="center"><strong>Cliente / Fornecedor</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do Titulo</strong></div></td>
        <td><div align="center"><strong>Data de Efetiva&ccedil;&atilde;o</strong></div></td>
        <td><div align="center"><strong>Valor Efetivado</strong></div></td>
        <td><div align="center"><strong>Empresa</strong></div></td>
        <td><div align="center"><strong>Filial</strong></div></td>
        <td><div align="center"><strong>CC3</strong></div></td>
        <td><div align="center"><strong>CC4</strong></div></td>
        <td><div align="center"><strong>CC5</strong></div></td>
        <td><div align="center"><strong>CC6</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';

//FILTRO CC1
if($get_cc1 !=""&&$get_cc2 ==""&&$get_cc3 ==""&&$get_cc4 ==""&&$get_cc5 ==""&&$get_cc6 ==""){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1'
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");

$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' 
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");
$dados_soma = mysql_fetch_array($sql_soma);
}
//FILTRO CC1 / CC2
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 ==""&&$get_cc4 ==""&&$get_cc5 ==""&&$get_cc6 ==""){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc3 <> '90' AND cc2 = '$get_cc2'
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");

$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc2 = '$get_cc2'
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");
$dados_soma = mysql_fetch_array($sql_soma);
}
//FILTRO CC1 / CC2 / CC3
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 !=""&&$get_cc4 ==""&&$get_cc5 ==""&&$get_cc6 ==""){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");

$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");
$dados_soma = mysql_fetch_array($sql_soma);
}

//FILTRO CC1 / CC2 / CC3 / CC4
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 !=""&&$get_cc4 !=""&&$get_cc5 ==""&&$get_cc6 ==""){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'  AND cc4 = '$get_cc4' 
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");

$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3' AND cc4 = '$get_cc4' 
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");
$dados_soma = mysql_fetch_array($sql_soma);
}


//FILTRO CC1 / CC2 / CC3 / CC4 / CC5
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 !=""&&$get_cc4 !=""&&$get_cc5 !=""&&$get_cc6 ==""){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'  AND cc4 = '$get_cc4' AND cc5 = '$get_cc5' 
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");

$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3' AND cc4 = '$get_cc4'  AND cc5 = '$get_cc5' 
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");
$dados_soma = mysql_fetch_array($sql_soma);
}

//FILTRO CC1 / CC2 / CC3 / CC4 / CC5 / CC6
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 !=""&&$get_cc4 !=""&&$get_cc5 !=""&&$get_cc6 !=""){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'  AND cc4 = '$get_cc4' AND cc5 = '$get_cc5' AND cc6 = '$get_cc6' 
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");

$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_tit_ccusto WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3' AND cc4 = '$get_cc4'  AND cc5 = '$get_cc5' AND cc6 = '$get_cc6' 
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6");
$dados_soma = mysql_fetch_array($sql_soma);
}


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='c_custo.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem

    while ($dados = mysql_fetch_array($sql)) {
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
		$id_custo			 = $dados["id_custo"];
		$tipo			 = $dados["tipo"];
		
		if($tipo == 2 || $tipo == 99){
			$cor = "";
		} else {
			$cor = "";
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
		$nome_cc2 = $d_cc2["nome_filial"];
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
		$nome_conta =$d_conta["conta"];
		
		//BUSCA NOME DO CLIENTE / FORNECEDOR
		$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = '$id_cliente'");
		$total = mysql_num_rows($sql_cliente);
		if($total >= 1){
			$d_cliente = mysql_fetch_array($sql_cliente);
			$nome_cliente = substr($d_cliente["nome"],0,20);
		} else {
			$sql_cliente = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = '$id_cliente'");
			$d_cliente = mysql_fetch_array($sql_cliente);
			$nome_cliente = substr($d_cliente["nome"],0,20);
		}
		
		


		
		
        echo "
	<tr bgcolor='$cor'>
		<td bgcolor='$cor' align='center'><a rel=\"shadowbox\" href=\"editar_ccusto.php?id=$id_titulo&id2=$id_custo\">$id_titulo</a></td>
		<td bgcolor='$cor'>$nome_cliente..</td>
		<td bgcolor='$cor'>$venc</td>
		<td align='right' bgcolor='$cor'>R$&nbsp;$valor</td>
		<td bgcolor='$cor'>$pagamento</td>
		<td align='right' bgcolor='$cor'>R$ $valor_pagto</td>
		<td bgcolor='$cor'>$nome_cc1</td>
		<td bgcolor='$cor'>$nome_cc2</td>
		<td bgcolor='$cor'>$nome_cc3</td>
		<td bgcolor='$cor'>$nome_cc4</td>
		<td bgcolor='$cor'>$nome_cc5</td>
		<td bgcolor='$cor'>$nome_cc6</td>
		<td bgcolor='$cor'>$nome_conta</td>
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