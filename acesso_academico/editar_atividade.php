<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$turma_disc = $_GET["turma"];
$ref_id = $_GET["id_atividade"];

//dados da turma
$sql_turma = mysql_query("SELECT ct.nivel, ct.tipo_etapa FROM ced_turma_disc ctd INNER JOIN ced_turma ct
ON ctd.id_turma = ct.id_turma WHERE ctd.codigo = $turma_disc");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$tipo_etapa = $dados_turma["tipo_etapa"];



//PEGA DADOS DA ATIVIDADE
$sql_atividade = mysql_query("SELECT cta.*, cet.etapa FROM ced_turma_ativ cta 
INNER JOIN ced_etapas cet 
ON cet.id_etapa = cta.id_etapa
WHERE cta.ref_id =$ref_id");
$dados_atividade = mysql_fetch_array($sql_atividade);
$atividade = $dados_atividade["cod_ativ"];

$sql_atividade2 = mysql_query("select * from ced_desc_nota WHERE codigo = $atividade");
$dados_atividade2 = mysql_fetch_array($sql_atividade2);



//enviar post 
 if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$data = $_POST["data"];
	$atividade = $_POST["atividade"];
	$descricao = $_POST["descricao"];
	$etapa = $_POST["etapa"];
	
	if($etapa == ""){
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('Você deve escolher uma etapa!');
		history.back();
		</SCRIPT>");
		return;
	}
	
	if($data == ""){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.alert('Você deve lançar a data para salvar a atividade');
	history.back();
	</SCRIPT>");
	return;
	} else {
		
		
	$sql_atividade_subgrupo = mysql_query("SELECT subgrupo FROM ced_desc_nota WHERE codigo = $atividade");
	$dados_atividade_subgrupo = mysql_fetch_array($sql_atividade_subgrupo);
	$grupo = $dados_atividade_subgrupo['subgrupo'];
	if(mysql_query("UPDATE ced_turma_ativ SET data='$data', descricao='$descricao', id_etapa='$etapa', cod_ativ='$atividade' WHERE ref_id = $ref_id;"))
	{
		if(mysql_affected_rows()>=1){
			mysql_query("UPDATE ced_notas SET grupo = '$grupo' WHERE ref_ativ = $ref_id");
			echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Atividade atualizada com sucesso!!');
						history.back(2);
						window.location.reload();
						</SCRIPT>");	
		}
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
                              <b>Editar Atividade</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">

  <table width="430" border="0" align="center" class="full_table_list2">
  <tr>
          <td width="116" align="center"><b>Etapa</b></td>
      <td><select name="etapa" style="width:auto" class="textBox" id="etapa" onKeyPress="return arrumaEnter(this, event)">
      <option value="<?php echo $dados_atividade["id_etapa"]?>"><?php echo $dados_atividade["etapa"]?></option>
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM ced_etapas WHERE tipo_etapa like '%$tipo_etapa%' ORDER BY etapa ";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_etapa'] . "'>" . $row['etapa'] . "</option>";
}
?>
      </select></td>
    </tr>
    
  <tr>
          <td width="116" align="center"><b>Atividade</b></td>
      <td><select name="atividade" style="width:auto" class="textBox" id="atividade" onKeyPress="return arrumaEnter(this, event)">
      <option value="<?php echo $dados_atividade["cod_ativ"]?>"><?php echo $dados_atividade2["atividade"]?></option>
      <?php
include("includes/config_drop.php");?>
      <?php
$sql = "SELECT * FROM ced_desc_nota WHERE subgrupo like '%$grupo_ativ%' AND subgrupo NOT LIKE '0' ORDER BY atividade ";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['codigo'] . "'>" ."(".$row['subgrupo'].") ". $row['atividade'] . "</option>";
}
?>
      </select></td>
    </tr>
  <tr>
    <td align="center" valign="top"><b>Data</b></td>
    <td><input name="data" type="date" class="textBox" id="" value="<?php echo $dados_atividade["data"]?>" /></td>
    </tr>
    <tr>
    <td width="116" align="center"><b>Valor</b></td>
  <td>
    <input type="text" class="textBox"  name="valor" id="valor" readonly value="<?php echo $dados_atividade["valor"]?>" onKeyPress="return arrumaEnter(this, event)"/>
</td>
    </tr>
    <tr>
    <td align="center" valign="top"><b>Descri&ccedil;&atilde;o</b></td>
    <td><textarea name="descricao" style="width:350px; height:200px;" class="textBox" id="descricao" onkeypress="return arrumaEnter(this, event)"><?php echo $dados_atividade["descricao"]?></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
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