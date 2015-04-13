<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["codigo"];
?>

<?php



$alunobusca = mysql_query("SELECT * FROM alunos WHERE codigo = $id");
$dadosaluno = mysql_fetch_array($alunobusca);
$alunonome = $dadosaluno["nome"];


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
                              <b>C&oacute;digo do Aluno: <?php echo $id; ?>
                              <br>Nome do Aluno: <?php echo $alunonome; ?></b>
                          </header>
                          <div class="panel-body">

<table class="table table-hover" width="100%" border="1" style="font-size:10px;">
	<tr bgcolor="#DFDFDF">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Multa</strong></div></td>
        <td><div align="center"><strong>Juros (Dia)</strong></div></td>
        <td><div align="center"><strong>Honor&aacute;rio</strong></div></td>
        <td><div align="center"><strong>Valor Calculado</strong></div></td>
        <td><div align="center"><strong>Data de Pagamento</strong></div></td>
        <td><div align="center"><strong>Valor Recebido</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php

if($user_unidade == "" || $user_unidade == "PERTEL"){
$sql = mysql_query("SELECT tit.id_titulo, alu.codigo, alu.nome, tit.parcela, tit.vencimento, tit.valor, tit.juros1, tit.juros2, tit.juros3, tit.juros4,
tit.acrescimo, tit.desconto, tit.data_pagto, tit.valor_pagto, tit.status,tit.conta, con.conta as conta_nome, tit.tipo
FROM titulos tit
INNER JOIN cliente_fornecedor alu
ON alu.codigo = tit.cliente_fornecedor
INNER JOIN contas con
ON con.ref_conta = tit.conta WHERE (tit.tipo = 2 OR tit.tipo = 99) AND alu.codigo LIKE '$id' ORDER BY tit.vencimento");
} else {
$sql = mysql_query("SELECT tit.id_titulo, alu.codigo, alu.nome, tit.parcela, tit.vencimento, tit.valor, tit.juros1, tit.juros2, tit.juros3, tit.juros4,
tit.acrescimo, tit.desconto, tit.data_pagto, tit.valor_pagto, tit.status,tit.conta, con.conta as conta_nome, tit.tipo
FROM titulos tit
INNER JOIN cliente_fornecedor alu
ON alu.codigo = tit.cliente_fornecedor
INNER JOIN contas con
ON con.ref_conta = tit.conta WHERE (con.conta LIKE '%$user_unidade%' OR con.conta LIKE '%livraria%' OR con.conta LIKE '%pertel%' OR con.conta LIKE '%EAD%') AND (tit.tipo = 2 OR tit.tipo = 99) AND alu.codigo LIKE '$id' ORDER BY tit.vencimento");
}



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	

    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = strtoupper($dados["nome"]);
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valorreal          = number_format($dados["valor"], 2, ',', '');
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"]+$dados["acrescimo"]-(($dados["valor"]*$dados["desconto"])/100);
		$valortitulofinal	= number_format($valortitulo, 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = number_format($dados["valor_pagto"],2,',','.');
		$status          = $dados["status"];
		$conta          = $dados["conta"];
		$contasel = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
		$dadosconta = mysql_fetch_array($contasel);
		$layout = $dadosconta["layout"];
		$nome_conta = $dadosconta["conta"];
		if(trim($datapagt) <> ""){
			$layout = 'comprovante.php';
		}
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
		if($status == 1){
			$bgstatus = "#FFDAB9";
			$statuscheck = "Inativo";
		} else {
			$bgstatus = "";
			$statuscheck = "Ativo";
		}
		if($conta == "B00CB"&&$status==0&&$user_unidade!="PERTEL"){
			$bgstatus = "#FFFF00";
		}
		if($user_unidade=="PERTEL"&&$vencimento < date("Y-m-d")&&$status==0&&$datapagt==""){
			$bgstatus = "#E6E6E6";
		}
		
		//INICIA CALCULO DINÂMICO DE JUROS
		$data_atual = date("Y-m-d");
		$sql_calculo = mysql_query("SELECT t1.id_titulo, t1.vencimento, t1.valor, t1.dias_atraso , 
t1.multa, t1.juros_dia, t1.honorario,
t1.multa+t1.juros_dia+t1.honorario as acrescimos_totais,
t1.valor+t1.multa+t1.juros_dia+t1.honorario as valor_calculado

FROM (
SELECT id_titulo, vencimento,data_pagto, valor_pagto, valor, DATEDIFF(NOW(), vencimento) as dias_atraso,  status,

IF(DATEDIFF(NOW(), vencimento) >=1,0.02*valor,0) as multa,
IF(DATEDIFF(NOW(), vencimento) >=1,((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*(valor),0) as juros_dia,
IF(DATEDIFF(NOW(), vencimento) >=11,0.10*(valor+(((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*valor)+(0.02*valor)),0) as honorario


FROM titulos 
) as t1
WHERE (t1.data_pagto = '' OR t1.data_pagto IS NULL) AND t1.vencimento < '$data_atual' AND t1.status = 0 AND t1.id_titulo = $idtitulo");
		if(mysql_num_rows($sql_calculo)==1){
			$dados_calculo = mysql_fetch_array($sql_calculo);
			$valortitulofinal = format_valor($dados_calculo["valor_calculado"]);
			$multa = format_valor($dados_calculo["multa"]);
			$juros_dia = format_valor($dados_calculo["juros_dia"]);
			$honorario = format_valor($dados_calculo["honorario"]);
		} else {
			$multa = format_valor($dados["juros1"]);
			$juros_dia = format_valor($dados["juros2"]);
			$honorario = format_valor($dados["juros3"]);
		}
		
		
		
		
        echo "
	<tr bgcolor=\"$bgstatus\">
		<td valign=\"middle\" align='center'><a href=\"../boleto/$layout?id=$idtitulo&p=$parcela&id2=$idcli&refreshed=no\" target=\"_blank\"><font size=\"+1\"><div class=\"fa fa-barcode tooltips\" data-placement=\"right\" data-original-title=\"Gerar Boleto\"></div></font></a></td>
		<td  valign=\"middle\" align=\"center\">&nbsp;$parcela</td>
		<td  valign=\"middle\" align=\"center\">&nbsp;$venc</td>
		<td valign=\"middle\" align=\"right\">R$ $valorreal</td>
		<td valign=\"middle\" align=\"right\">R$ $multa</td>
		<td valign=\"middle\" align=\"right\">R$ $juros_dia</td>
		<td valign=\"middle\" align=\"right\">R$ $honorario</td>
		<td valign=\"middle\"  align=\"right\">R$ $valortitulofinal</td>
		<td valign=\"middle\" align=\"center\"> $pagamento</td>
		<td valign=\"middle\" align=\"right\">R$&nbsp;$valorpagt</td>
		<td  valign=\"middle\"><center>$nome_conta</center></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

</table>
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
