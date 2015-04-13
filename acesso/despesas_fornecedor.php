<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$codigo = $_GET['codigo'];

$sql_titulos = mysql_query("SELECT * FROM geral_titulos WHERE codigo = $codigo AND tipo_titulo = 1");

$sql_cliente = mysql_query("SELECT nome_fantasia FROM cliente_fornecedor WHERE codigo = $codigo");
$dados_cliente = mysql_fetch_array($sql_cliente);

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
                              <b>T&iacute;tulos de Fornecedor<br></b>
                              <font size="-1"><b>Nome Fantasia: </b><?php echo $dados_cliente['nome_fantasia'];?></font>
                          </header>
                          <div class="panel-body">
<form action="#"  method="post">
  <input type="submit" value="Atualizar T&iacute;tulos" name="Atualizar" /> 
<table class="table" width="100%" border="1" style="font-size:10px;">
	<tr bgcolor="#DFDFDF">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Data de Pagamento</strong></div></td>
        <td><div align="center"><strong>Valor Efetivado</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
        <td><div align="center"><strong>--</strong></div></td>
	</tr>

<?php
$count = mysql_num_rows($sql_titulos);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Não há títulos.')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
$valor_vencido = 0;
    while ($dados = mysql_fetch_array($sql_titulos)) {
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
		
		
		
		
        echo "
	<tr bgcolor=\"$bgstatus\">
		<td valign=\"middle\" align='center'>&nbsp;<a rel=\"shadowbox\" href=\"editar.php?id=$idtitulo\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Editar Título\"></div></font></a></td>
		<td  valign=\"middle\" align=\"center\">&nbsp;$parcela</td>
		<td  valign=\"middle\" align=\"center\">&nbsp;$venc</td>
		<td valign=\"middle\" align=\"right\">R$ $valorreal</td>
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
    

 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script>