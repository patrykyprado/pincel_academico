<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head_inside.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$post_curso = strtoupper($_POST["curso"]);
	$post_disciplina = $_POST["disciplina"];
	$post_grau = $_POST["grau"];
	mysql_query("INSERT INTO ea_banco_questao (id_bq, cursos, nome_bq, grau) VALUES (NULL, '$post_curso', '$post_disciplina', '$post_grau')");

	
		echo "
		<script language=\"javascript\">alert('Banco inserido com sucesso!');
		</script>";
		
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
                              <b>Novo Banco de Quest&atilde;o</b>
                          </header>
                        <div class="panel-body">
<form action="#" method="post">
<table class="table table-striped" border="1" width="100%">
<tr>
	<td><b>Curso:</b></td>
    <td><?php 
		$sql = "SELECT distinct curso FROM cursosead ORDER BY curso";
		$result = mysql_query($sql);
		echo "<select name=\"curso\" style=\"width:auto\" class=\"textBox\" id=\"curso\" onKeyPress=\"return arrumaEnter(this, event)\">";
		echo "<option value='COMUM'>COMUM</option>";
		while ($row = mysql_fetch_array($result)) {
			echo "<option value='" . $row['curso'] . "'>" . $row['curso'] ."</option>";
		}
		echo "</select>";

	
	?>
    </td>
</tr>
<tr>
	<td><b>Disciplina:</b></td>
    <td><?php 
		$sql = "SELECT distinct disciplina FROM disciplinas ORDER BY disciplina";
		$result = mysql_query($sql);
		echo "<select name=\"disciplina\" style=\"width:auto\" class=\"textBox\" id=\"disciplina\" onKeyPress=\"return arrumaEnter(this, event)\">";
		while ($row = mysql_fetch_array($result)) {
			echo "<option value='" . $row['disciplina'] . "'>" . $row['disciplina'] ."</option>";
		}
		echo "</select>";

	
	?>
    </td>
</tr>
<tr>
	<td><b>Grau:</b></td>
    <td><?php 
		$sql = "SELECT distinct grau FROM ea_banco_questao ORDER BY grau";
		$result = mysql_query($sql);
		echo "<select name=\"grau\" style=\"width:auto\" class=\"textBox\" id=\"grau\" onKeyPress=\"return arrumaEnter(this, event)\">";
		while ($row = mysql_fetch_array($result)) {
			echo "<option value='" . $row['grau'] . "'>" . $row['grau'] ."</option>";
		}
		echo "</select>";

	
	?>
    </td>
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