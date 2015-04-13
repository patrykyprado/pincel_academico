<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$td = $_GET["td"];
$n_aula = $_GET["aula"];
$get_anograde = $_GET["anograde"];
$get_cod_disc = $_GET["cod_disc"];
$get_aula = $_GET["aula"];

//PROTEÇÃO PARA SOMENTE PROFESSOR VISUALIZAR
$sql_bloq_prof = mysql_query("SELECT * FROM ced_turma_disc WHERE cod_prof = '$user_usuario' AND codigo = '$td'");
if(mysql_num_rows($sql_bloq_prof)==0){
	echo "<script language=\"javascript\">
		alert('ACESSO NÃO PERMITIDO!');
		location.href='http://cedtec.com.br/pincelatomico';
	</script>";
}


$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
if(mysql_num_rows($sql_verificar_previsto)==1){
	$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
} else {
	$sql_nome_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$get_cod_disc%' AND anograde LIKE '%$get_anograde%' LIMIT 1");
	$dados_disciplina = mysql_fetch_array($sql_nome_disciplina);
	$nome_disciplina = $dados_disciplina["disciplina"];
	
	$sql_cod_disc = mysql_query("SELECT * FROM disciplinas WHERE disciplina LIKE '%$nome_disciplina%' AND anograde LIKE '%$get_anograde%'");
	$codigos_disciplinas = "";
	$contar_codigos = mysql_num_rows($sql_cod_disc);
while($dados_disc = mysql_fetch_array($sql_cod_disc)){
		if($contar_codigos >=2){
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."',";
		} else {
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."'";
		}
		$contar_codigos -=1;
}
$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc IN ($codigos_disciplinas) AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
}

$aula = $_GET["aula"];
$turma_disc = $_GET["td"];
$prof = $_GET["prof"];
$disciplina1=$_GET["disciplina"];
$curso=$_GET["curso"];


//PEGA A UNIDADE/NIVEL DA TURMA.
$sql_turma = mysql_query("SELECT DISTINCT ct.unidade,ct.nivel FROM ced_turma_disc ctd INNER JOIN ced_turma ct 
ON ctd.id_turma = ct.id_turma WHERE ctd.codigo = $turma_disc");
$dados_turma = mysql_fetch_array($sql_turma);
$unidade_disc = $dados_turma["unidade"];
$nivel_disc = $dados_turma["nivel"];

//PEGA OS DIRETORES PEDAGÓGICOS DAS UNIDADES.
$sql_diretor = mysql_query("SELECT * FROM users WHERE dir_unidade LIKE '%$unidade_disc%' AND dir_nivel LIKE '%$nivel_disc%' LIMIT 1");
$dados_diretor = mysql_fetch_array($sql_diretor);
$email_dir = $dados_diretor["email"];

 if( isset ( $_POST[ 'Salvar' ] ) ) {
//PEGA AULA SE EXISTIR
$sql = mysql_query("SELECT * FROM ced_data_aula WHERE n_aula = $aula AND turma_disc = $turma_disc");
$verificar = mysql_num_rows($sql);

$n_aula = $_POST["aula"];
$turma_disciplina = $_POST["td"];
$realizado = $_POST["realizado"];
$data_aula2 = $_POST["data"];
if(strstr($data_aula2, '/')==TRUE){
	$data_aula = substr($data_aula2,6,4)."-".substr($data_aula2,3,2)."-".substr($data_aula2,0,2);
} else {
	$data_aula = $data_aula2;
}




$atev_extra = $_POST['atividade'];
$material= $_POST['material'];
$equipamento= $_POST['equipamento'];


if($verificar >= 1){
// inicio de envio de mensagem
// Diretoria Pedagógica



	
//ATUALIZA AULA
mysql_query("UPDATE ced_data_aula SET n_aula = '$n_aula', turma_disc = '$turma_disciplina', realizado = '$realizado', data_aula = '$data_aula', status1 = '$status1', status2 = '$status2', status3 = '$status3', status4 = '$status4', status5 = '$status5', status6 = '$status6', status7 = '$status7', status8 = '$status8', status9 = '$status9', status10 = '$status10',  ativ_extra = '$atev_extra',  material = '$material', equipamento = '$equipamento'   WHERE n_aula = $aula AND turma_disc = $turma_disc");


 echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('AULA ATUALIZADA COM SUCESSOS')
	window.close();
	window.opener.location.reload();    
	</SCRIPT>");
} else {

//fim de envio de mensagem	
//INSERE AULA   n_aula, turma_disc,realizado,data_aula, status1,status2,status3,status4,status5,status6,status7,status8,	status9,status10, status12, status13, ativ_extra, tempo_extra
// inicio de envio de mensagem

mysql_query("INSERT INTO ced_data_aula (n_aula, turma_disc, realizado,	data_aula,	status1,status2,status3,status4,status5,status6,status7,status8,status9,status10,  ativ_extra,	 material, equipamento )                                      
VALUES ('$n_aula', '$turma_disciplina', '$realizado', '$data_aula', '$status1', '$status2', '$status3', '$status4', '$status5', '$status6', '$status7', '$status8', '$status9', '$status10',  '$atev_extra' ,  '$material', '$equipamento' )");
//***********************************************************************************************************

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		 
//endereço do remitente
$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";		 
//endereço de resposta, se queremos que seja diferente a do remitente
$headers .= "Reply-To: patryky@cedtec.com.br". "\r\n";			 
//endereços que receberão uma copia oculta
$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";

if (trim($atev_extra) <> "" ) {	
$mesagem1 = "<table width=\"100%\" border=\"1\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#424242\" style=\"color:#FFF\"><b>Registro de Aula</b></td>
  </tr>
  <tr>
    <td width=\"27%\"><b>Curso / Disciplina:</b></td>
    <td width=\"73%\">$curso / $disciplina1 - <b>Nº aula:</b> $aula</td>
  </tr>
  <tr>
    <td><b>Professor:</b></td>
    <td>$prof</td>
  </tr>
  <tr>
    <td valign=\"top\"><b>Conteúdo:</b></td>
    <td valign=\"top\">$atev_extra</td>
  </tr>
</table>";

$assunto = "Atividades Relacionadas à Atividade Extra - Pincel Atômico";
$destinatario ="marcos@cedtec.com.br, erivelton@cedtec.com.br,".$email_dir;
mail($destinatario,$assunto,$mesagem1,$headers);


}

if (trim($material) <> "" ) {	
$mesagem2 = "<table width=\"100%\" border=\"1\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#424242\" style=\"color:#FFF\"><b>Registro de Aula - Material Didático</b></td>
  </tr>
  <tr>
    <td width=\"27%\"><b>Curso / Disciplina:</b></td>
    <td width=\"73%\">$curso / $disciplina1 - <b>Nº aula:</b> $aula</td>
  </tr>
  <tr>
    <td><b>Professor:</b></td>
    <td>$prof</td>
  </tr>
  <tr>
    <td valign=\"top\"><b>Conteúdo:</b></td>
    <td valign=\"top\">$material</td>
  </tr>
</table>";

$assunto2 = "Atividades Relacionadas à Atividade Material Didático - Pincel Atômico";
$destinatario2 ="marcos@cedtec.com.br, erivelton@cedtec.com.br, livraria.tecnica@cedtec.com.br,wemerson.prof@gmail.com";
mail($destinatario2,$assunto2,$mesagem2,$headers);


}

if (trim($equipamento) <> "" ) {
$mesagem3 = "<table width=\"100%\" border=\"1\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#424242\" style=\"color:#FFF\"><b>Registro de Aula - Estrutura Física</b></td>
  </tr>
  <tr>
    <td width=\"27%\"><b>Curso / Disciplina:</b></td>
    <td width=\"73%\">$curso / $disciplina1 - <b>Nº aula:</b> $aula</td>
  </tr>
  <tr>
    <td><b>Professor:</b></td>
    <td>$prof</td>
  </tr>
  <tr>
    <td valign=\"top\"><b>Comentários:</b></td>
    <td valign=\"top\">$equipamento</td>
  </tr>
</table>";

$assunto3 = "Atividades Relacionadas à Estrutura Física - Pincel Atômico";
$destinatario3 ="marcos@cedtec.com.br, erivelton@cedtec.com.br,".$email_dir;
mail($destinatario3,$assunto3,$mesagem3,$headers);


}


 echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('AULA CADASTRADA COM SUCESSO!')
	window.opener.location.reload();
	window.close();
	
    </SCRIPT>");

}	        
}
//PEGA AULA SE EXISTIR
$sql = mysql_query("SELECT * FROM ced_data_aula WHERE n_aula = $aula AND turma_disc = $turma_disc");
$verificar = mysql_num_rows($sql);
if($verificar >= 1){
$dados = mysql_fetch_array($sql);
$data = $dados["data_aula"];
$realizado = $dados["realizado"];
$atev_extra = $dados["ativ_extra"];
$material = $dados["material"];
$equipamento  = $dados["equipamento"];

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
                              <b>Registro de Aula</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">
<input type="hidden" name="aula" value="<?php echo $aula; ?>" />
<input type="hidden" name="td" value="<?php echo $turma_disc; ?>" />
  <table width="100%" border="1" align="center" class="full_table_list">
          <tr>
            <td colspan="2"><strong>Aula N&uacute;mero:</strong><?php echo $aula; ?></td>
            <td align="center" colspan="2"><strong>Data da Aula </strong>
              
              <input type="text" placeholder="" value="<?php 
			  if($data == "//"){
			  	echo "";  
			  } else {
				echo substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4); 
			  }
			  ?>" maxlength="10" name="data" id="data" data-mask="99/99/9999" class="form-control">
             
           </td>
    </tr>
<tr>
 <td colspan="4" align="center" ><img src="<?php echo $dados_previsto["arquivo"];?>" width="700" />
</td>
 </tr>
<tr>
	<td colspan="2" align="center" bgcolor="#6C6C6C"><font color="#FFFFFF"><b>Atividades Extras</b></font></td>
    <td colspan="2" align="center" bgcolor="#6C6C6C"><font color="#FFFFFF"><b></b>Observa&ccedil;&otilde;es da Aula</font></td>
</tr>
<tr>
	<td colspan="2" align="center" ><font color=""><b><textarea name="atividade" onKeyPress="return arrumaEnter(this, event)" style="width:200px; height:100px;"class="textBox" id="atividade" ><?php echo $atev_extra; ?></textarea></b></font></td>
    <td colspan="2" align="center" ><font color=""><b></b><textarea name="realizado" onKeyPress="return arrumaEnter(this, event)" style="width:200px; height:100px;"class="textBox" id="realizado" ><?php echo $realizado; ?></textarea></font></td>
</tr>

<tr>
	<td colspan="2" align="center" bgcolor="#6C6C6C"><font color="#FFFFFF"><b>Coment&aacute;rios Sobre Material Did&aacute;tico</b></font></td>
    <td colspan="2" align="center" bgcolor="#6C6C6C"><font color="#FFFFFF"><b></b>Coment&aacute;rios Sobre Equipamentos e Estrutura F&iacute;sica</font></td>
</tr>
<tr>
	<td colspan="2" align="center" ><font color=""><b><textarea name="material" onKeyPress="return arrumaEnter(this, event)" style="width:200px; height:100px;"class="textBox" id="material" ><?php echo $material; ?></textarea></b></font></td>
    <td colspan="2" align="center" ><font color=""></b><textarea name="equipamento" onKeyPress="return arrumaEnter(this, event)" style="width:200px; height:100px;"class="textBox" id="equipamento" ><?php echo $equipamento; ?></textarea></font></td>
</tr>
 
  </table>

  <p align="center">
    <input type="submit" name="Salvar" class="textBox" value="SALVAR" style="cursor:pointer;"/>
  </p>
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