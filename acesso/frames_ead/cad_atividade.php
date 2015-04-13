<!DOCTYPE html>
<html lang="en">
<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/topo_inside_ead.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_acao = $_GET["acao"];


if($get_acao == 1){
	$nome_acao = "Cadastro de Atividade - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$coddisc = $_SESSION["coddisc"];
$turma_disc = $_SESSION["turma_disc"];
$anograde = $_SESSION["anograde"];
$tipo_ativ = $_POST["tipo_ativ"];
$descricao_ativ = $_POST["descricao"];
$data_criacao = date("Y-m-d h:i:s");
if(isset($_POST["check1"])){
	$datahora_inicio = $_POST["a_ini"]."-".$_POST["m_ini"]."-".$_POST["d_ini"]." ".$_POST["hh_ini"].":".$_POST["mm_ini"].":".$_POST["ss_ini"];
	$datahora_final = $_POST["a_fin"]."-".$_POST["m_fin"]."-".$_POST["d_fin"]." ".$_POST["hh_fin"].":".$_POST["mm_fin"].":".$_POST["ss_fin"];
} else {
	$datahora_inicio = "0000-00-00 00:00:00";
	$datahora_final = "0000-00-00 00:00:00";
}
if(isset($_POST["check2"])){
	$link = $_POST["link"];
} else {
	$link = "#";
}

$sql_max_ativ = mysql_query("SELECT max(ordem_ativ) as maximo FROM ea_ativ WHERE cod_disc LIKE '$coddisc' AND ano_grade LIKE '$anograde'");
$dados_max_ativ = mysql_fetch_array($sql_max_ativ);
$max_ativ = $dados_max_ativ["maximo"] +1;

if(@mysql_query("INSERT INTO ea_ativ (cod_ativ,cod_disc,ano_grade,tipo,data_criacao,descricao,conteudo,link,ordem,ordem_ativ) VALUES (NULL,'$coddisc','$anograde','$tipo_ativ','$data_criacao','$descricao_ativ','$descricao_ativ','$link','0','$max_ativ')")){
	if(mysql_affected_rows() ==1){
		echo "<script language='javascript'>
			window.alert('Atividade inserida com sucesso!');
			window.parent.location.reload();
			window.parent.Shadowbox.close();
			</script>";
	}

}


}//fecha o post Salvar
	
	
	
}//fecha o get acao

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
                              <b>Cadastro de Atividade</b>
                          </header>
                        <div class="panel-body">
<form method="post" action="#">
<input name="cod_disc" id="cod_disc" type="hidden"  value="<?php echo $_SESSION["coddisc"] ;?>"/>
    <input name="turma_disc" id="turma_disc" type="hidden"  value="<?php echo $_SESSION["turma_disc"] ;?>"/>
    <input name="anograde" id="anograde" type="hidden"  value="<?php echo $_SESSION["anograde"] ;?>"/>

<table class="full_table_list" width="100%">
<tr>
	<td colspan="4" align="center" bgcolor="#6C6C6C" style="color:#FFF"><?php echo $nome_acao.$nome_disciplina;?></td>
</tr>
<tr>
    <td colspan="4" align="center"><b>Atividade: </b>
     <select name="tipo_ativ" style="width:auto;" id="tipo_ativ" onkeypress="return arrumaEnter(this, event)">
      <?php
include("../menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM ea_tipo_ativ ORDER BY tipo";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['cod_tipo'] . "'>" . ($row['tipo']) . "</option>";
}
?>
    </select></td>
    
</tr>

<tr>
	<td bgcolor="#6C6C6C" align="center" colspan="4" style="color:#FFF"><font size="+1"><b>DESCRI&Ccedil;&Atilde;O</b></font></td>
</tr>
<tr>
    <td colspan="4"><textarea id="descricao" name="descricao" style="height:100px" class="ckeditor"></textarea></td>
</tr>
<tr>
	<td colspan="2" align="right"><b>Link Externo:</b></td>
    <td colspan="2"><b><input id="link" name="link" type="text" disabled="disabled" value="http://"> <input name="check2" id="check2" type="checkbox" onclick="habilitar();"></b></td>

</tr>
<tr>
	<td colspan="4" align="center"><input id="Salvar" name="Salvar" type="submit" value="Salvar"></td>
</tr>

</table>

</form>
                          </div>
                          <div class="panel-footer">
                          </div>
                      </section>
                 
              </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('../includes/footer.php');
 ?>
  </section>
 <?php 
 include('../includes/js_ead.php');
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
  
<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check1').checked){  
        document.getElementById('d_ini').disabled = false; 
		document.getElementById('m_ini').disabled = false; 
		document.getElementById('a_ini').disabled = false;
		document.getElementById('hh_ini').disabled = false; 
		document.getElementById('mm_ini').disabled = false; 
		document.getElementById('ss_ini').disabled = false;  
		document.getElementById('d_fin').disabled = false; 
		document.getElementById('m_fin').disabled = false; 
		document.getElementById('a_fin').disabled = false;
		document.getElementById('hh_fin').disabled = false; 
		document.getElementById('mm_fin').disabled = false; 
		document.getElementById('ss_fin').disabled = false;  
    } else {  
        document.getElementById('d_ini').disabled = true; 
		document.getElementById('m_ini').disabled = true; 
		document.getElementById('a_ini').disabled = true;
		document.getElementById('hh_ini').disabled = true; 
		document.getElementById('mm_ini').disabled = true; 
		document.getElementById('ss_ini').disabled = true; 
		document.getElementById('d_fin').disabled = true; 
		document.getElementById('m_fin').disabled = true; 
		document.getElementById('a_fin').disabled = true;
		document.getElementById('hh_fin').disabled = true; 
		document.getElementById('mm_fin').disabled = true; 
		document.getElementById('ss_fin').disabled = true;    
    }  
	
	
	if(document.getElementById('check2').checked){  
        document.getElementById('nota').disabled = false;  
    } else {  
        document.getElementById('nota').disabled = true; 
    } 
	
}  
</script> 