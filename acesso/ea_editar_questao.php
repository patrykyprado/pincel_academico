<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head_inside.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
if(isset($_GET["id_bq"])){
	$get_bq = $_GET["id_bq"];
} else {
	$get_bq = 0;
}

$get_id_questao = $_GET["id_questao"];
$get_cod_questao = $_GET["cod_questao"];

$sql_questao = mysql_query("SELECT * FROM ea_questao WHERE id_questao = '$get_id_questao' AND cod_questao = '$get_cod_questao'");
$dados_questao = mysql_fetch_array($sql_questao);
$questao_banco = $dados_questao["id_bq"];
$questao_questao = $dados_questao["questao"];
$questao_id = $dados_questao["id_questao"];
$questao_capitulo = $dados_questao["capitulo"];
$sql_banco = mysql_query("SELECT * FROM ea_banco_questao WHERE id_bq = $questao_banco");
$dados_banco = mysql_fetch_array($sql_banco);
$nome_banco = $dados_banco["nome_bq"]." | Grau: ".$dados_banco["grau"];

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$post_banco = $_POST["banco"];
	$post_questao = $_POST["questao"];
	$post_capitulo = $_POST["capitulo"];
	$post_id_questao = $_POST["id_questao"];
	if($post_id_questao != "" || $post_id_questao != 0){
		mysql_query("UPDATE ea_questao SET id_bq = '$post_banco', questao = '$post_questao', capitulo = '$post_capitulo' WHERE id_questao = $post_id_questao");
		for( $i = 0 , $x = count( $_POST[ 'valor' ] ) ; $i < $x ; ++ $i ) {
			mysql_query("UPDATE ea_resposta SET valor='".$_POST[ 'valor' ][$i]."', resposta='".$_POST[ 'opcao' ][$i]."' WHERE id_resposta ='".$_POST[ 'id_resposta' ][$i]."'");
		}
	}
	echo "<script language=\"javascript\">
	alert('Questão atualizada com sucesso!');
	window.location.href='ea_questoes.php?id_bq=$post_banco'
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
                              <b>Editar Quest&atilde;o</b>
                          </header>
                        <div class="panel-body">
<form action="#" method="post">
<table class="full_table_list" width="100%">
<tr>
	<td><b>Banco de Quest&atilde;o:</b></td>
    <td><?php 
	if($get_bq == 0){
		$sql = "SELECT * FROM ea_banco_questao ORDER BY cursos, nome_bq";
		$result = mysql_query($sql);
		echo "<select name=\"banco\" style=\"width:auto\" class=\"textBox\" id=\"banco\" onKeyPress=\"return arrumaEnter(this, event)\">";
		echo "<option selected=\"selected\" value=\"$questao_banco\">$nome_banco</option>";
		while ($row = mysql_fetch_array($result)) {
			echo "<option value='" . $row['id_bq'] . "'> Cursos: ". $row['cursos']. " | ". $row['nome_bq'] ." | Grau: ".$row['grau'] ."</option>";
		}
		echo "</select>";
	} else {
		$sql_nome_bq = mysql_query("SELECT * FROM ea_banco_questao WHERE id_bq = $get_bq");
		$dados_bq = mysql_fetch_array($sql_nome_bq);
		$nome_bq = $dados_bq["nome_bq"];
		echo "<input name=\"banco2\" type=\"text\" readonly=\"readonly\" style=\"width:700px;\" value=\"$nome_bq\"/>
		<input name=\"banco\" type=\"hidden\" value=\"$get_bq\"/> ";	
	}
	
	?>
    </td>
</tr>
<tr>
	<td><b>Enunciado da Quest&atilde;o:<br /><br /><br />
    Cap&iacute;tulo: </b><input name="capitulo" id="capitulo" type="number" value="<?php echo $questao_capitulo;?>" style="width:40px" required="required" /></b></td>
    <td><input type="hidden" name="id_questao" id="id_questao" value="<?php echo $questao_id;?>" /><textarea class="ckeditor" name="questao" id="questao"><?php echo $questao_questao;?></textarea></td>
</tr>
<?php
$sql_resposta = mysql_query("SELECT * FROM view_questionario WHERE id_questao = $get_id_questao");
while($dados_resposta = mysql_fetch_array($sql_resposta)){
	$resposta = $dados_resposta["resposta"];
	$resposta_id = $dados_resposta["id_resposta"];
	$resposta_valor = $dados_resposta["valor"];
	echo "<tr>
	<td  valign=\"top\"><b>Op&ccedil;&atilde;o:<br />
    <select id=\"valor[]\" name=\"valor[]\" style=\"width:100px\">
	<option value=\"$resposta_valor\" selected=\"selected\">$resposta_valor%</option>
    <option value=\"100\">100%</option>
 	<option value=\"90\">90%</option>
    <option value=\"70\">70%</option>
    <option value=\"50\">50%</option>
    <option value=\"33.33\">33%</option>
	<option value=\"25\">25%</option>
	<option value=\"20\">20%</option>
    <option value=\"15\">15%</option>
    <option value=\"0\">0%</option>
    </select></b>
	<input type=\"hidden\" name=\"id_resposta[]\" id=\"id_resposta[]\" value=\"$resposta_id\" /></td>
    <td><textarea class=\"ckeditor\" name=\"opcao[]\" id=\"opcao[]\">$resposta</textarea></td>
</tr>";	
}
?>
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