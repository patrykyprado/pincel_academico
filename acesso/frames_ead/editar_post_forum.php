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
$get_acao = 2;//$_GET["acao"];

if(isset($_GET["id_post"])){
	$id_post = $_GET["id_post"];
	$sql_post = mysql_query("SELECT * FROM ea_post_forum WHERE id_post = $id_post");
	$dados_post = mysql_fetch_array($sql_post);
	
} else {
	echo "<script language=\"javascript\">
	alert('Erro: O sistema apresentou um erro, entre em contato com o administrador do sistema.');
	window.parent.frames['frame_central_ead'].location.reload();
	window.parent.Shadowbox.close();
	</script>";
}

if($get_acao == 2){
	$nome_acao = "Editar comentário - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$comentario = $_POST["descricao"];
$data_post = date("Y-m-d H:i:s");


if(@mysql_query("UPDATE ea_post_forum SET comentario = '$comentario', data_modif='$data_post' WHERE id_post = $id_post")){
	if(mysql_affected_rows() ==1){
		
		echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Comentário atualizado com sucesso!');
			window.parent.frames['frame_central_ead'].location.reload();
			window.parent.Shadowbox.close();;
			
			</SCRIPT>");
	}

}


}//fecha o post Salvar comentário
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
                              <b>Edi&ccedil;&atilde;o de Coment&aacute;rio</b>
                          </header>
                        <div class="panel-body">
<form method="post" action="#">

<table width="100%">
<tr>
	<td align="center" bgcolor="#6C6C6C" style="color:#FFF"><?php echo $nome_acao.$nome_disciplina;?></td>
</tr>

<tr>
	<td align="center" bgcolor="#C0C0C0"><b>Resposta</b></td>
    </tr>
<tr>
    <td><b>Descri&ccedil;&atilde;o:</b><br /><textarea id="descricao" name="descricao" style="height:100px" class="ckeditor"><?php echo $dados_post["comentario"];?></textarea></td>
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
 include('../includes/js_ead.php');
 ?>


  </body>
</html>