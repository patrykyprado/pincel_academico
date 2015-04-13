<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$id = $_GET["id"];
$re    = mysql_query("select count(*) as total from geral_titulos where id_titulo = $id");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("select * from geral_titulos where id_titulo = $id");
	
	$dados = mysql_fetch_array($re);
	$conta = $dados["conta"];

	
	$re2    = mysql_query("select * from contas where ref_conta like '$conta'");
	$dados2 = mysql_fetch_array($re2);
	
	//INICIA CALCULO DINÂMICO DE JUROS
		
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
WHERE (t1.data_pagto = '' OR t1.data_pagto IS NULL) AND t1.status = 0 AND t1.id_titulo = $id");
		if(mysql_num_rows($sql_calculo)==1){
			$dados_calculo = mysql_fetch_array($sql_calculo);
			$juros1 = $dados_calculo["multa"];
			$juros2 = $dados_calculo["juros_dia"];
			$juros3 = $dados_calculo["honorario"];
		} else {
			$juros1 = $dados["juros1"];
			$juros2 = $dados["juros2"];
			$juros3 = $dados["juros3"];
			
		}
	
}

//POST
if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$pagamento         = $_POST["dtpag"];
$recebido         = $_POST["valor"];
$vencimento         = $_POST["vencimento"];
$valordoc         = $_POST["valordoc"];
$acrescimo         = $_POST["acrescimo"];
$desconto         = $_POST["desconto"];
$juros1         = $_POST["juros1"];
$juros2         = $_POST["juros2"];
$juros3         = $_POST["juros3"];
$juros4         = $_POST["juros4"];
$dia_desc         = str_pad($_POST["dia_desc"], 2, "0", STR_PAD_LEFT);;
$conta         = $_POST["conta"];
$nfe         = $_POST["nfe"];
$data_doc         = $_POST["dt_doc"];
$descricao         = $_POST["descricao"];
$tipo = $_POST["tipo"];
$processamento = date("Y-m-d H:i:s:U");
$valordocfinal		= str_replace(",",".",$valordoc);
$recebidofinal		= str_replace(",",".",$recebido);
$juros1final		= str_replace(",",".",$juros1);
$juros2final		= str_replace(",",".",$juros2);
$juros3final		= str_replace(",",".",$juros3);
$juros4final		= str_replace(",",".",$juros4);
$acrescimofinal		= str_replace(",",".",$acrescimo);
$descontofinal		= str_replace(",",".",$desconto);

if($conta == "selecione"){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('VOCÊ DEVE SELECIONAR A CONTA');
		history.back();
		</SCRIPT>");
		return;
		}


if(isset($_POST["ativo"])&&$recebido == 0){
	$status = 1;
} else {
	$status = 0;
}


	



$re    = mysql_query("select * from geral_titulos where id_titulo = $id");
	
$dados = mysql_fetch_array($re);
$pago = trim($dados["data_pagto"]);


//PESQUISA DADOS DA CONTA
$sql_conta = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
$dados_conta = mysql_fetch_array($sql_conta);
$nome_conta = $dados_conta["conta"];

//INSERE O ALERTA
$atual = date("Y-m-d H:i:s");
$alert_texto = "<p><strong>T&iacute;tulo:</strong> $id</p>

<p><strong>Vencimento:</strong> $vencimento</p>

<p><strong>Valor do T&iacute;tulo:</strong> $valordoc</p>

<p><strong>Data de Pagamento: </strong>$pago</p>

<p><strong>Valor Efetivado:</strong> $recebido</p>

<p><strong>Conta:</strong> $nome_conta  ($conta)</p>";

/*mysql_query("INSERT INTO alertas (id_alert, de, para, tipo, setor, titulo, texto, datahora)
VALUES (NULL, 'SISTEMA','$user_usuario','1','2', 'Baixa / Edição de Título - $id', '$alert_texto', '$atual');");*/


//FAZ O UPDATE DA TABELA TITULOS
if($pago == "" || $user_nivel == 1 || $user_nivel == 2 || $user_nivel == 3 || $user_nivel == 4){
	
//zera o processamento do titulo
mysql_query("UPDATE titulos SET processamento = '0000-00-00' WHERE id_titulo = $id");


// usuário
$user 				=$_SESSION['MM_Username'];
$ipativo = $_SERVER["REMOTE_ADDR"];
//pega o cliente
	$sql_cliente = mysql_query("SELECT * FROM titulos where id_titulo = $id");
	$dados_cliente = mysql_fetch_array($sql_cliente);
	$cliente = $dados_cliente["nome"];
	$parcela = $dados_cliente["parcela"];
if(substr($nfe,2,3)=="REM"&&$parcela==1){
	$p_curso = mysql_query("SELECT * FROM curso_aluno WHERE matricula = '$cliente' AND grupo LIKE '%2014%' ORDER BY ref_id DESC LIMIT 1");
	$dados_pcurso = mysql_fetch_array($p_curso);
	$p_nivel = $dados_pcurso["nivel"]; 
	$p_curso = $dados_pcurso["curso"]; 
	$p_modulo = $dados_pcurso["modulo"] + 1; 
	$p_grupo = "2014/02";
	$p_turno = $dados_pcurso["turno"];
	$p_unidade = $dados_pcurso["unidade"];
	$p_polo = $dados_pcurso["polo"];
	mysql_query("INSERT INTO curso_aluno (ref_id, matricula, nivel, curso, modulo, grupo, turno, unidade, polo, grupo2)
								 VALUES (NULL, '$cliente', '$p_nivel', '$p_curso', '$p_modulo', '$p_grupo', '$p_turno', '$p_unidade', '$p_polo', '$p_grupo')");
}
//UPDATE
	if(@mysql_query("UPDATE titulos SET documento_fiscal = '$nfe', dt_doc = '$data_doc', data_pagto = '$pagamento',dia_desc = '$dia_desc',status = '$status',
	valor_pagto = '$recebidofinal', vencimento='$vencimento', descricao= '$descricao',valor= '$valordocfinal',juros1= '$juros1final',juros2= '$juros2final',juros3= '$juros3final',juros4= '$juros4final',acrescimo='$acrescimofinal',desconto='$descontofinal', conta = '$conta', processamento = '$processamento' WHERE id_titulo = $id")) {
	
		if(mysql_affected_rows() == 1){
			mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
VALUES ('$user','$atual','05','BAIXOU O TÍTULO $id NO VALOR DE R$ $recebidofinal - CONTA: $conta','$ipativo');");
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('TITULO ALTERADO COM SUCESSO');
			
			window.parent.location.reload();
			window.parent.Shadowbox.close();
			
			</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível receber o título.";
			exit;
		}	
		@mysql_close();
	}
} else {
//teste
	if(@mysql_query("UPDATE titulos SET descricao= '$descricao',status = '$status', vencimento = '$vencimento',valor= '$valordocfinal',juros1= '$juros1final',juros2= '$juros2final',juros3= '$juros3final',juros4= '$juros4final' WHERE id_titulo = $id")) {
	
		if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('DESCRIÇÃO DO TITULO ALTERADA COM SUCESSO');
			window.parent.Shadowbox.close();
			location.reload();
			
		</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível receber o título.";
			exit;
		}	
		@mysql_close();
	}
}

}
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
                              <b>Baixa / Edi&ccedil;&atilde;o de T&iacute;tulo</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="editar.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table class="full_table_list" width="100%" border="1" align="center">
  	<tr style="background:#0C9">
    <td colspan="2" style="border:1px #030303" align="center"><b>Dados do T&iacute;tulo</b></td>
    <td colspan="2" align="center"><b>Dados de Baixa</b></td>
    </tr>
    <tr>
    <td colspan="4"><strong>
      <input type="hidden" name="tipo" id="tipo" value="<?php echo $dados["tipo_titulo"] ?>" readonly/>
    </strong></td>
    </tr>
    <tr bgcolor="#F7F7F7">
      <td><strong>T&iacute;tulo</strong></td>
      <td><input name="titulo" type="text" class="textBox2" id="titulo" value="<?php echo $dados["id_titulo"]; ?>" maxlength="10" readonly/></td>
	<td  bgcolor="#C1FFC1"><strong>Conta: <font color="red">*</font></strong></td>
    <td bgcolor="#C1FFC1"><select name="conta" class="textBox2" id="conta">
      <option value="<?php echo $dados2["ref_conta"]?>"><?php echo $dados2["conta"]?></option>
<?php
include("menu/config_drop.php");?>
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
      </select></td>
    
    </tr>
  <tr  bgcolor="#F7F7F7">
      <td><strong>Cliente / Fornecedor</strong></td>
      <td><input name="cliente" type="text" class="textBox22" id="cliente" value="<?php echo $dados["nome"]; ?>" maxlength="100" readonly/></td>
	  <td  bgcolor="#C1FFC1"><strong>Data de Pagamento</strong></td>
      <td  bgcolor="#C1FFC1"><input name="dtpag" type="date" class="textBox2" id="dtpag" value="<?php echo $dados["data_pagto"]; ?>" maxlength="10" /></td>
    
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Nota Fiscal</strong></td>
      <td><input name="nfe" type="text" id="nfe" value="<?php echo $dados["nfe"]; ?>" /></td>
      <td  bgcolor="#C1FFC1"><strong>Valor Efetivado</strong></td>
      <td  bgcolor="#C1FFC1"><input name="valor" type="text" class="textBox2" id="valor" value="<?php echo ($dados["valor_pagto"]); ?>" maxlength="10" /></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
      <td><strong>Data do Documento</strong></td>
      <td><input name="dt_doc" rows="5" type="date" class="textBox2" id="dt_doc" value="<?php echo $dados["dt_doc"]; ?>" /></td>
      <td colspan="2" align="center" style="background:#0C9"><strong>Descri&ccedil;&atilde;o</strong></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
      <td><strong>Vencimento do Documento</strong></td>
      <td><input name="vencimento" type="date" class="textBox2" id="vencimento" value="<?php echo $dados["vencimento"]; ?>" maxlength="100" /></td>
      <td colspan="2" rowspan="10" valign="top" align="center"><textarea name="descricao" rows="5" style="width:90%" class="textBox2" id="descricao"><?php echo $dados["descricao"]; ?></textarea></td>
    </tr>	
    <tr  bgcolor="#F7F7F7">
      <td><strong>Valor do Documento</strong></td>
      <td><input name="valordoc" type="text" class="textBox2" id="valordoc" value="<?php echo ($dados["valor"]); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td colspan="2" align="center" style="background:#0C9"><b>Acr&eacute;scimos e Descontos</b></td>
      </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Dia de Desconto</strong></td>
      <td><input name="dia_desc" type="text" class="textBox2" id="dia_desc" value="<?php echo $dados["dia_desc"]; ?>" maxlength="2" /></td>
      
    </tr>
    
    <tr  bgcolor="#F7F7F7">
      <td><strong>Acr&eacute;scimo</strong></td>
      <td><input name="acrescimo" type="text" class="textBox2" id="acrescimo" value="<?php echo format_valor($dados["acrescimo"]); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Desconto</strong></td>
      <td><input name="desconto" type="text" class="textBox2" id="desconto" value="<?php echo $dados["desconto"]; ?>" maxlength="20"/></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
	  <td><strong>Juros (Ap&oacute;s Vencimento)</strong></td>
	  <td><input name="juros1" type="text" class="textBox2" id="juros1" value="<?php echo format_valor($juros1); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (Por dia de Atraso)</strong></td>
      <td><input name="juros2" type="text" class="textBox2" id="juros2" value="<?php echo format_valor($juros2); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (5 dias de atraso)</strong></td>
      <td><input name="juros3" type="text" class="textBox2" id="juros3" value="<?php echo format_valor($juros3); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (30 dias de atraso)</strong></td>
      <td><input name="juros4" type="text" class="textBox2" id="juros4" value="0" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td colspan="4" align="center"><input name="tipo" type="hidden" class="textBox2" id="tipo" value="<?php echo format_valor($dados["tipo_titulo"]); ?>" maxlength="10" />
      <input type="submit" name="Submit" value="Salvar" style="cursor:pointer;"/></td>
    </tr>
  </table>
</form>
                          </div>
                          <div class="panel-footer">
                              <center><a onClick="ShadowClose()" href="javascript:parent.location.reload();">FECHAR</a></center>
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


    

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o cliente/fornecedor? '))
{
location.href="apagar_forn.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar_forn.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
function enviar(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor2').value = valor;
this.close();
}
</script>
    </script>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
     
<script>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 