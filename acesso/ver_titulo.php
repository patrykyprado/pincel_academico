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
<input type="hidden" readonly name="id" value="<?php echo $id; ?>" />
  <table class="full_table_list" width="100%" border="1" align="center">
  	<tr style="background:#0C9">
    <td colspan="2" style="border:1px #030303" align="center"><b>Dados do T&iacute;tulo</b></td>
    <td colspan="2" align="center"><b>Dados de Baixa</b></td>
    </tr>
    <tr>
    <td colspan="4"><strong>
      <input type="hidden" readonly name="tipo" id="tipo" value="<?php echo $dados["tipo_titulo"] ?>" readonly/>
    </strong></td>
    </tr>
    <tr bgcolor="#F7F7F7">
      <td><strong>T&iacute;tulo</strong></td>
      <td><input name="titulo" readonly type="text" class="textBox2" id="titulo" value="<?php echo $dados["id_titulo"]; ?>" maxlength="10" readonly/></td>
	<td  bgcolor="#C1FFC1"><strong>Conta: <font color="red">*</font></strong></td>
    <td bgcolor="#C1FFC1"><select readonly name="conta" class="textBox2" id="conta">
      <option value="<?php echo $dados2["ref_conta"]?>"><?php echo $dados2["conta"]?></option>
      </select></td>
    
    </tr>
  <tr  bgcolor="#F7F7F7">
      <td><strong>Cliente / Fornecedor</strong></td>
      <td><input readonly name="cliente" type="text" class="textBox22" id="cliente" value="<?php echo $dados["nome"]; ?>" maxlength="100" readonly/></td>
	  <td  bgcolor="#C1FFC1"><strong>Data de Pagamento</strong></td>
      <td  bgcolor="#C1FFC1"><input readonly name="dtpag" type="date" class="textBox2" id="dtpag" value="<?php echo $dados["data_pagto"]; ?>" maxlength="10" /></td>
    
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Nota Fiscal</strong></td>
      <td><input readonly name="nfe" type="text" id="nfe" value="<?php echo $dados["nfe"]; ?>" /></td>
      <td  bgcolor="#C1FFC1"><strong>Valor Efetivado</strong></td>
      <td  bgcolor="#C1FFC1"><input readonly name="valor" type="text" class="textBox2" id="valor" value="<?php echo format_valor($dados["valor_pagto"]); ?>" maxlength="10" /></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
      <td><strong>Data do Documento</strong></td>
      <td><input readonly name="dt_doc" rows="5" type="date" class="textBox2" id="dt_doc" value="<?php echo $dados["dt_doc"]; ?>" /></td>
      <td colspan="2" align="center" style="background:#0C9"><strong>Descri&ccedil;&atilde;o</strong></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
      <td><strong>Vencimento do Documento</strong></td>
      <td><input readonly name="vencimento" type="date" class="textBox2" id="vencimento" value="<?php echo $dados["vencimento"]; ?>" maxlength="100" /></td>
      <td colspan="2" rowspan="10" valign="top" align="center"><textarea readonly name="descricao" rows="5" style="width:90%" class="textBox2" id="descricao"><?php echo $dados["descricao"]; ?></textarea></td>
    </tr>	
    <tr  bgcolor="#F7F7F7">
      <td><strong>Valor do Documento</strong></td>
      <td><input readonly name="valordoc" type="text" class="textBox2" id="valordoc" value="<?php echo format_valor($dados["valor"]); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td colspan="2" align="center" style="background:#0C9"><b>Acr&eacute;scimos e Descontos</b></td>
      </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Dia de Desconto</strong></td>
      <td><input readonly name="dia_desc" type="text" class="textBox2" id="dia_desc" value="<?php echo $dados["dia_desc"]; ?>" maxlength="2" /></td>
      
    </tr>
    
    <tr  bgcolor="#F7F7F7">
      <td><strong>Acr&eacute;scimo</strong></td>
      <td><input readonly name="acrescimo" type="text" class="textBox2" id="acrescimo" value="<?php echo format_valor($dados["acrescimo"]); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Desconto</strong></td>
      <td><input readonly name="desconto" type="text" class="textBox2" id="desconto" value="<?php echo $dados["desconto"]; ?>" maxlength="20"/></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
	  <td><strong>Juros (Ap&oacute;s Vencimento)</strong></td>
	  <td><input readonly name="juros1" type="text" class="textBox2" id="juros1" value="<?php echo format_valor($juros1); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (Por dia de Atraso)</strong></td>
      <td><input readonly name="juros2" type="text" class="textBox2" id="juros2" value="<?php echo format_valor($juros2); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (5 dias de atraso)</strong></td>
      <td><input readonly name="juros3" type="text" class="textBox2" id="juros3" value="<?php echo format_valor($juros3); ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (30 dias de atraso)</strong></td>
      <td><input readonly name="juros4" type="text" class="textBox2" id="juros4" value="0" maxlength="20"/></td>
    </tr>
  </table>

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