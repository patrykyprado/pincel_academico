<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$matricula = $_GET["matricula"];
$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo =  '$matricula'");
$dados_aluno = mysql_fetch_array($sql_aluno);
$aluno_nome = $dados_aluno["nome"];


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
                              <b>Declara&ccedil;&atilde;o IR</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="GET" action="gerar_declaracao_ir.php" onsubmit="return confirma(this)">
<input type="hidden" name="matricula" value="<?php echo $matricula; ?>" />
<table class="full_table_cad" align="center">
<tr>
	<td><b>Nome do Aluno:</b></td>
    <td><input type="text" readonly width="400px;" name="nome_aluno" value="<?php echo $aluno_nome; ?>" /></td>
</tr>
<tr>
	<td><b>Unidade:</b></td>
    <td><select name="unidade" class="textBox" id="unidade">
    <?php
include 'includes/config_drop.php';?>
    <?php
	if($user_unidade == ""){
		$sql = "SELECT * FROM cc2 WHERE niveltxt LIKE '%GERAL%' ORDER BY nome_filial";
	} else {
		$sql = "SELECT * FROM cc2 WHERE niveltxt LIKE '%GERAL%' AND nome_filial LIKE '%$user_unidade%'";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filial'] . "'>" . $row['nome_filial'] . "</option>";
}
?>
  </select></td>
</tr>
<tr>
	<td><b>Ano Refer&ecirc;ncia</b></td>
    <td><select  name="ano" style="width:auto;" id="ano" onkeypress="return arrumaEnter(this, event)">
     <option value="0000">AAAA</option>
     <?php $ano = date('Y')-1;
  $anoatual = date('Y');
while($ano<($anoatual+1)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
	</select></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="GERAR" /></td>
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