<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

?>

<?php
$atual = date("Y-m-d H:i:s");
$ipativo = $_SERVER["REMOTE_ADDR"];

$id = $_GET["id"];
$aluno = $_GET["aluno"];

 if($_SERVER["REQUEST_METHOD"]=="POST") {
		              for( $i = 0 , $x = count( $_POST[ 'titulo' ] ) ; $i < $x ; $i++ ) {
						 mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
VALUES ('$user_usuario','$atual','08','INATIVOU O TÍTULO '".$_POST[ 'titulo' ]."','$ipativo');");
			
						 mysql_query("UPDATE titulos SET status = '".$_POST[ 'checkbox' ][$i]."' WHERE id_titulo = '".$_POST[ 'titulo' ][ $i ]."'");
							
		              }
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('TITULOS ATUALIZADOS COM SUCESSO');
			</SCRIPT>");
 }


$alunobusca = mysql_query("SELECT * FROM alunos WHERE codigo = $id");
$dadosaluno = mysql_fetch_array($alunobusca);
$alunonome = $dadosaluno["nome"];


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
                              <b>C&oacute;digo do Aluno: <?php echo $id; ?>
                              <br>Nome do Aluno: <a rel="shadowbox" href="ficha.php?codigo=<?php echo $id;?>"><?php echo $alunonome; ?></a></b>
                              <div align="left" class="task-option">
                              <a rel="shadowbox" href="ced_produtos.php?id_cliente=<?php echo $id; ?>">[Material Didático]</a> 
                              <a rel="shadowbox" href="declaracao_ir.php?matricula=<?php echo $id; ?>">[Declaração IR]</a>
                              </div>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="GET" action="buscar_receitas.php">
Nome: 
    <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Filtrar" id="Buscar" value="Buscar" />
  <br>
  <input type="radio" name="tipo_cliente" checked id="tipo_cliente" value="1"> Aluno | <input type="radio" name="tipo_cliente" id="tipo_cliente" value="2"> Cliente/Fornecedor

</form>
<form action="#"  method="post">
  <input type="submit" value="Atualizar T&iacute;tulos" name="Atualizar" /> 
<?php  
if($user_unidade == "PERTEL"){
	echo" 
   | <a target=\"_blank\" href=\"cob_cad_titulo.php?tipo=2&id=$id\">[NOVO T&Iacute;TULO]</a>";
}
   ?>
<table class="table" width="100%" border="1" style="font-size:10px;">
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
        <td><div align="center"><strong>--</strong></div></td>
	</tr>

<?php

if($user_unidade == "" || $user_unidade == "PERTEL"){
$sql = mysql_query("SELECT * FROM geral_titulos WHERE (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id' ORDER BY vencimento");
} else {
$sql = mysql_query("SELECT * FROM geral_titulos WHERE (conta_nome LIKE '%$user_unidade%' OR conta_nome LIKE '%livraria%' OR conta_nome LIKE '%pertel%' OR conta_nome LIKE '%EAD%') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id' ORDER BY vencimento");
}



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Não há títulos para o aluno.')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
$valor_vencido = 0;
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
		$contasel = mysql_query("SELECT layout, conta FROM contas WHERE ref_conta = '$conta'");
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

FROM view_juros as t1
WHERE (t1.data_pagto = '' OR t1.data_pagto IS NULL) AND t1.vencimento < '$data_atual' AND t1.status = 0 AND t1.id_titulo = $idtitulo");
		if(mysql_num_rows($sql_calculo)==1){
			$dados_calculo = mysql_fetch_array($sql_calculo);
			$valortitulofinal = format_valor($dados_calculo["valor_calculado"]);
			$multa = format_valor($dados_calculo["multa"]);
			$juros_dia = format_valor($dados_calculo["juros_dia"]);
			$honorario = format_valor($dados_calculo["honorario"]);
			$valor_vencido += $dados_calculo["valor_calculado"];
		} else {
			$multa = format_valor($dados["juros1"]);
			$juros_dia = format_valor($dados["juros2"]);
			$honorario = format_valor($dados["juros3"]);
			$valor_vencido += 0;
		}
		
		
		
		
        echo "
	<tr bgcolor=\"$bgstatus\">
		<td valign=\"middle\" align='center'>&nbsp;<a rel=\"shadowbox\" href=\"editar.php?id=$idtitulo\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Editar Título\"></div></font></a> <a href=\"../boleto/$layout?id=$idtitulo&p=$parcela&id2=$idcli&refreshed=no\" target=\"_blank\"><font size=\"+1\"><div class=\"fa fa-barcode tooltips\" data-placement=\"right\" data-original-title=\"Gerar Boleto\"></div></font></a></td>
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
		<td valign=\"middle\" align=\"center\"><input name='titulo[]' id='titulo[]' type='hidden' value='$idtitulo' />
		
		<select name='checkbox[]' class='a' id='checkbox[]' style='width:auto; height:25px;'>
    <option value='$status'>$statuscheck</option>
  	<option value='0'>Ativo</option>
    <option value='1'>Inativo</option>
  </select>
  
  </td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
	<tr bgcolor="#DFDFDF">
		<td colspan="12"><strong><font color="red">Total de Títulos Vencidos: </strong> R$ <?php echo format_valor($valor_vencido);?></font></td>

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
