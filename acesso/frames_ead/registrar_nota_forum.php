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
$get_turma_disc= $_GET["turma_disc"];
$get_matricula = (int)$_GET["matricula"];
$get_ref = $_GET["ref_id"];
$get_codnota = $_GET["id"];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($_POST["nota"] <= $_POST["max_nota"]){
		$nota_atual = str_replace(",",".",$_POST["nota"]);
		if($_POST["ref_update"] == 1){
			mysql_query("UPDATE ced_notas SET nota = '$nota_atual' WHERE matricula = '$get_matricula' AND codnota = '$get_codnota'");
			echo "<script language=\"javascript\">
		alert('Nota atualizada com sucesso.');
		window.parent.frames['frame_central_ead'].location.reload();
		window.parent.Shadowbox.close();
		</script>";	
		} else {
			$sql_id_etapa = mysql_query("SELECT id_etapa FROM ced_turma_ativ WHERE ref_id = $get_ref");
			$dados_id_etapa = mysql_fetch_array($sql_id_etapa);
			$id_etapa = $dados_id_etapa["id_etapa"];
			mysql_query("INSERT INTO ced_notas (codnota, matricula, ref_ativ, turma_disc, grupo, nota, id_etapa) VALUES 
			(NULL, '$get_matricula', '$get_ref', '$get_turma_disc','B','$nota_atual','$id_etapa')");
			echo "<script language=\"javascript\">
		alert('Nota inserida com sucesso.');
		window.parent.frames['frame_central_ead'].location.reload();
		window.parent.Shadowbox.close();
		</script>";	
		}
		
	} else {
		echo "<script language=\"javascript\">
		alert('Você digitou uma nota maior que o máximo da atividade.');
		history.back();
		</script>";	
		return;
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
                              <b>Registro de Nota Individual</b>
                          </header>
                        <div class="panel-body">
<div id="central" style="margin-bottom:100px;">
<form method="post" action="#">
<table class="table table-hover" align="center">
<tr>
	<td align="center"><b>Nome</b></td>
    <td align="center"><b>Nota</b></td>
</tr>
<?php
$get_matricula = $_GET["matricula"];
$get_codnota = $_GET["id"];
$sql_nota = mysql_query("SELECT a.nome, cta.valor, cn.nota, cn.codnota FROM ced_turma_ativ cta
INNER JOIN ced_notas cn
ON cn.ref_ativ = cta.ref_id
INNER JOIN alunos a
ON cn.matricula = a.codigo
WHERE cn.matricula = '$get_matricula' AND codnota LIKE '$get_codnota' ");
if(mysql_num_rows($sql_nota)==0){
	$nota = 0;
	$sql_atividade = mysql_query("SELECT * FROM ced_turma_ativ WHERE ref_id = $get_ref");
	$dados_atividade = mysql_fetch_array($sql_atividade);
	$max_nota = $dados_atividade["valor"];
	$ref_update = "0";
	
} else {
	$dados_nota = mysql_fetch_array($sql_nota);
	$nota = $dados_nota["nota"];
	$max_nota = $dados_nota["valor"];
	$ref_update = "1";
}

$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = '$get_matricula'");
$dados_aluno = mysql_fetch_array($sql_aluno);

?>
<tr>
	<td align="center"><b><?php echo $dados_aluno["nome"];?></b></td>
    <td align="center"><b><input type="text" name="nota" id="nota" value="<?php echo $nota;?>"/>
    <input type="hidden" name="max_nota" id="max_nota" value="<?php echo $max_nota;?>"/>
    <input type="hidden" name="ref_update" id="ref_update" value="<?php echo $ref_update;?>"/> | <?php echo format_valor($max_nota);?></b></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" value="Salvar" /></td>
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