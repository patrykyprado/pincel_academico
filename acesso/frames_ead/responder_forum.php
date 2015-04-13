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
$get_acao = 1;//$_GET["acao"];



if($get_acao == 1){
	$nome_acao = "Responder F�rum - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$id_resposta = $_POST["resposta"];
$id_forum = $_GET["id"];
$comentario = substr($_POST["descricao"],0,3000);
$data_post = date("Y-m-d H:i:s", strtotime("-3 hour"));
//
$verificar = "<!--[if gte mso 9]";
$verificar2 = "<!--[if";
if(strpos($comentario,$verificar) == true || strpos($comentario,$verificar2) == true){
		mysql_query("INSERT INTO logs (id_log, usuario, data_hora, cod_acao, acao, ip_usuario) VALUES (NULL, '$user_usuario', NOW(), '10', 'Tentou enviar um c�digo XML malicioso no f�rum $id_forum', '00')");
		$comentario = strip_tags($comentario);
	if(@mysql_query("INSERT INTO ea_post_forum (id_post, id_forum,post_resposta, matricula, data_modif, comentario, nota_comentario) VALUES (NULL, '$id_forum','$id_resposta', '$user_usuario',NOW(), '$comentario',0)")){
		if(mysql_affected_rows() ==1){
			echo "<script language='javascript'>
				window.alert('Resposta salva com sucesso!');
				window.parent.frames['frame_central_ead'].location.reload();
				window.parent.Shadowbox.close();
				</script>";
		}
	}
} else {
if(@mysql_query("INSERT INTO ea_post_forum (id_post, id_forum,post_resposta, matricula, data_modif, comentario, nota_comentario) VALUES (NULL, '$id_forum','$id_resposta', '$user_usuario',NOW(), '$comentario',0)")){
	if(mysql_affected_rows() ==1){
		echo "<script language='javascript'>
			window.alert('Resposta salva com sucesso!');
			window.parent.frames['frame_central_ead'].location.reload();
			window.parent.Shadowbox.close();
			</script>";
	}

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
                              <b>Responder F&oacute;rum</b>
                          </header>
                        <div class="panel-body">
<form method="post" action="#">

<table width="100%">
<tr>
	<td align="center" bgcolor="#6C6C6C" style="color:#FFF"><?php echo $nome_disciplina;?></td>
</tr>
<?php
if(isset($_GET["user_resposta"])){
	$post_id = $_GET["user_resposta"];
	$sql_resposta = mysql_query("SELECT alu.nome,epf.comentario
FROM ea_post_forum epf
INNER JOIN alunos alu
ON alu.codigo = epf.matricula WHERE epf.id_post ='$post_id'");
	$dados_resposta = mysql_fetch_array($sql_resposta);
	$nome_aluno = $dados_resposta["nome"];
	$comentario_aluno = $dados_resposta["comentario"];
	echo "<tr>
		<td bgcolor=\"#EBEBEB\">Coment�rio de: $nome_aluno</td>
	</tr>
	<tr>
		<td>$comentario_aluno</td>
	</tr>";
	
}
?>

<tr>
	<td align="center" bgcolor="#C0C0C0"><b>Resposta</b></td>
    </tr>
<tr><input name="resposta" type="hidden" value="<?php echo $_GET["user_resposta"]?>" />
    <td><b>Descri&ccedil;&atilde;o:</b><br /><textarea maxlength="500" id="descricao" name="descricao" style="height:100px" class="ckeditor"></textarea></td>
</tr>
<tr>
  <td align="center"><input id="Salvar" name="Salvar" type="submit" value="Salvar"></td>
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
 include('../includes/js.php');
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
alert("o n� de usu�rio �: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O N�MERO DO T�TULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O T�TULO N�:  "+data))
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
//nome = id do campo que ir� receber o valor, esse campo deve da pagina que gerou o popup
//opener � elemento que faz a vincula��o/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que ir� receber o valor, esse campo deve da pagina que gerou o popup
//opener � elemento que faz a vincula��o/referencia entre a window pai com a window filho ou popup
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