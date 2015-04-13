<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$get_id = $_GET["id"];

if($get_id != ""){
	$sql_aluno = mysql_query("SELECT * FROM inscritos WHERE codigo = '$get_id' AND codigo NOT IN (SELECT codigo FROM alunos)");
	$dados_aluno = mysql_fetch_array($sql_aluno);
	$nome = $dados_aluno["nome"];
	$id_curso = $dados_aluno["curso"];
	$unidade_nome = $dados_aluno["unidade"];
	//PEGAR CURSOS
	$sql_curso = mysql_query("SELECT * FROM cursosead WHERE codigo = '$id_curso'");
	$dados_curso = mysql_fetch_array($sql_curso);
	$curso = $dados_curso["tipo"].": ".$dados_curso["curso"];
	$cod_unidade = substr($dados_curso["unidade"],0,2);
	$mod_curso = substr($dados_curso["unidade"],2,1);
	
	if($mod_curso == 2){
		$unidade = "EAD";
		$polo = $unidade_nome;	
	} else {
		$unidade = $unidade_nome;
		$polo = $unidade_nome;
	}

}
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$post_id = $_POST["id"];
	$sql_aluno = mysql_query("SELECT * FROM inscritos WHERE codigo = '$post_id' AND codigo NOT IN (SELECT codigo FROM alunos)");
if(mysql_num_rows($sql_aluno)==0){
	echo "
	<script language=\"javascript\">
	alert('Esse aluno ja está matrículado, para alterar o desconto acesse a ficha financeira do aluno.');
	window.close();
	</script>
	";
} else {
	$desconto_1 = $_POST["desconto_1"];
	$desconto = $_POST["desconto"];
	$data_inicio = date("Y-m-d");
	$descricao = $_POST["descricao"];
	$origem = $_POST["origem"];
	
	mysql_query("DELETE FROM ced_bolsas WHERE matricula = '$get_id'");
	mysql_query("INSERT INTO ced_bolsas (id_bolsa, matricula, unidade, polo, curso, desconto_1, desconto, inicio_desconto, autorizado, descricao, origem) VALUES (NULL, '$get_id','$unidade', '$polo', '$id_curso',
	'$desconto_1', '$desconto', '$data_inicio', '$user_usuario', '$descricao', '$origem')");
	echo "
	<script language=\"javascript\">
	alert('Desconto cadastrado com sucesso!');
	window.close();
	</script>
	";
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
                              <b>Confirma&ccedil;&atilde;o de Matr&iacute;cula</b>
                          </header>
                        <div class="panel-body">
<form action="#" method="post">
<table class="full_table_list" width="100%">
<tr>
	<td colspan="3" align="center"><font size="+2"><b>Alterar Desconto</b></font></td>
</tr>
<input type="hidden" name="id" value="<?php echo $get_id?>"
<tr>
	<td><b>Nome:</b></td>
    <td colspan="2"><input type="text" readonly name="nome" value="<?php echo $nome;?>" style="width:500px;"></td>
</tr>
<tr>
	<td><b>Unidade / Polo:</b></td>
    <td colspan="2"><input type="text" readonly name="unidade" value="<?php echo $unidade;?>"> / <input type="text" readonly name="polo" value="<?php echo $polo;?>"></td>
</tr>
<tr>
	<td><b>Curso:</b></td>
    <td colspan="2"><input type="text" readonly name="curso" style="width:500px;" value="<?php echo $curso;?>"></td>
</tr>
<tr>
	<td><b>Desconto - 1&ordf; Parcela(%):</b></td>
    <td colspan="2"><input type="text" name="desconto_1" value=""></td>
</tr>
<tr>
	<td><b>Desconto (%):</b></td>
    <td colspan="2"><input type="text" name="desconto" value=""></td>
</tr>
<tr>
	<td><b>Origem do Desconto:</b></td>
    <td colspan="2"><select name="origem">
    <option selected value="Convênio">Conv&ecirc;nio</option>
    <option value="Direção Geral">Dire&ccedil;&atilde;o Geral</option>
    <option value="Gestor">Gestor</option>
    </select></td>
</tr>
<tr>
	<td><b>Descri&ccedil;&atilde;o do Desconto:</b></td>
    <td colspan="2"><textarea name="descricao" style="width:500px; height:100px;"></textarea></td>
</tr>
<tr>
	<td colspan="3" align="center"><input type="submit" name="ENVIAR" value="Salvar"></b></td>
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