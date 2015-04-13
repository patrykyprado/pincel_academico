<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

?>

<?php
$atual = date("Y-m-d H:i:s");
$ipativo = $_SERVER["REMOTE_ADDR"];

$id = $_GET["id"];
$tipo_titulo = $_GET["tipo"];


$alunobusca = mysql_query("SELECT * FROM cliente_fornecedor WHERE tipo = 2 AND codigo = $id");
$dadosaluno = mysql_fetch_array($alunobusca);
$cliente_nome = $dadosaluno["nome"];


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
                              <b>C&oacute;digo: <?php echo $id; ?>
                              <br>Cliente / Fornecedor: <?php echo $cliente_nome; ?></b>
                          </header>
                          <div class="panel-body">
<table class="table table-hover" width="100%" border="1" style="font-size:10px;">
	<tr bgcolor="#DFDFDF">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Data de Pagamento</strong></div></td>
        <td><div align="center"><strong>Valor Efetivado</strong></div></td>
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
ON con.ref_conta = tit.conta WHERE (tit.tipo = $tipo_titulo) AND alu.codigo LIKE '$id' ORDER BY tit.vencimento");
} else {
$sql = mysql_query("SELECT tit.id_titulo, alu.codigo, alu.nome, tit.parcela, tit.vencimento, tit.valor, tit.juros1, tit.juros2, tit.juros3, tit.juros4,
tit.acrescimo, tit.desconto, tit.data_pagto, tit.valor_pagto, tit.status,tit.conta, con.conta as conta_nome, tit.tipo
FROM titulos tit
INNER JOIN cliente_fornecedor alu
ON alu.codigo = tit.cliente_fornecedor
INNER JOIN contas con
ON con.ref_conta = tit.conta WHERE (con.conta LIKE '%$user_unidade%' OR con.conta LIKE '%livraria%' OR con.conta LIKE '%pertel%' OR con.conta LIKE '%EAD%') AND (tit.tipo = $tipo_titulo) AND alu.codigo LIKE '$id' ORDER BY tit.vencimento");
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
	
$total_efetivado = 0;
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
		$total_efetivado += $valortitulo; 
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
		
		
        echo "
	<tr bgcolor=\"$bgstatus\">
		<td valign=\"middle\" align='center'><a href=\"ver_titulo.php?id=$idtitulo\"><font size=\"+1\"><div class=\"fa fa-eye tooltips\" data-placement=\"right\" data-original-title=\"Visualizar Título\"></div></font></a></td>
		<td  valign=\"middle\" align=\"center\">&nbsp;$venc</td>
		<td valign=\"middle\" align=\"right\">R$ $valorreal</td>
		<td valign=\"middle\" align=\"center\"> $pagamento</td>
		<td valign=\"middle\" align=\"right\">R$&nbsp;$valorpagt</td>
		<td  valign=\"middle\"><center>$nome_conta</center></td>
	
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
	<tr bgcolor="#DFDFDF">
        <td colspan="4"><div align="right"><strong>Total Efetivado:</strong></div></td>
        <td><div align="right"><strong>R$ <?php echo format_valor($total_efetivado);?></strong></div></td>
        <td><div align="right"><strong></strong></div></td>

	</tr>
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
