<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$editor = "";
session_start();
if(isset($_GET['turma_disc'])){
	$turma_disc = $_GET['turma_disc'];
	$cod_disc = $_GET['coddisc'];
	$anograde = $_GET['anograde'];
	$_SESSION["turma_disc"] = $turma_disc;
	$_SESSION["coddisc"] = $cod_disc;
	$_SESSION["anograde"] = $anograde;
} else {
	$turma_disc = $_SESSION["turma_disc"];
	$cod_disc = $_SESSION["coddisc"];
	$anograde = $_SESSION["anograde"];

}

if(isset($_GET["edicao"])){
	$_SESSION["edicao"] = $_GET["edicao"];
	$edicao = $_GET["edicao"];
} else {
	$_SESSION["edicao"] = 0;
	$edicao = 0;
}

//pega dados da turma
$sql_turma_d = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_turma_d = mysql_fetch_array($sql_turma_d);
$id_turma = $dados_turma_d["id_turma"];
$inicio_disciplina = format_data($dados_turma_d["inicio"]);
$fim_disciplina = format_data($dados_turma_d["fim"]);
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = $dados_turma["curso"];
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
if($turma_modulo == 1){
$turma_modulo_exib = "I";
}

if($turma_modulo == 2){
$turma_modulo_exib = "II";
}

if($turma_modulo == 3){
$turma_modulo_exib = "II";
}



//pega dados da disciplina
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disc' AND anograde LIKE '%$anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b><a style="text-decoration:none; background:none;" href="javascript:location.reload()"><?php echo $nome_disciplina?></a>
                              <br><font size="-2"><?php echo $inicio_disciplina?> at&eacute; <?php echo $fim_disciplina?><br>Grupo: <?php echo $turma_grupo;?>
 
<?php 
if($user_nivel == 1 || $user_nivel == 2 || $permitido == 1){
	
	echo "<div align=\"left\" class=\"task-option\">
<a rel=\"shadowbox\" href=\"../acesso/detalhes_participantes.php?acao=1&turma_disc=$turma_disc&coddisc=$cod_disc&anograde=$anograde\" class=\"btn btn-xs btn-warning\"><font size=\"+1\">Participantes</font></a>
<a rel=\"shadowbox\" href=\"frames_ead/cad_atividade.php?acao=1&turma_disc=$turma_disc&coddisc=$cod_disc&anograde=$anograde\" class=\"btn btn-xs btn-info\"><font size=\"+1\">Nova Atividade</font></a>
                              </div>";
}
?>                           

                          </header>
                          <div class="panel-body" align="center">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr bgcolor="#FFFFFF">
<td align="center">
<div align="center" style="margin:auto;width:100%; align-content:center; align-items:center; align-self:center; text-align:center">
<?php


$sql_ativ1 = mysql_query("SELECT ea.* FROM ea_ativ ea
INNER JOIN ea_tipo_ativ eta
ON eta.cod_tipo = ea.tipo
WHERE ea.cod_disc LIKE '$cod_disc' AND ea.ano_grade LIKE '$anograde'
ORDER BY eta.ordem");

echo "<center>";
while($dados_ativ1 = mysql_fetch_array($sql_ativ1)){
	$d_cod_ativ = $dados_ativ1["cod_ativ"];
	$d_cod_disc = $dados_ativ1["cod_disc"];
	$d_ano_grade = $dados_ativ1["ano_grade"];
	$d_tipo = $dados_ativ1["tipo"];
	$d_link = $dados_ativ1["link"];
	$sql_tipo_ativ = mysql_query("SELECT * FROM ea_tipo_ativ WHERE cod_tipo = $d_tipo ");
	$dados_tipo_ativ = mysql_fetch_array($sql_tipo_ativ);
	$ativ_tipo = ($dados_tipo_ativ["tipo"]);
	$ativ_rotulo = $dados_tipo_ativ["rotulo"];
	if($d_link == "#"){
		$ativ_link = $dados_tipo_ativ["link"];
		$target_link = "frame_central_ead";
		$comp_link = "frames_ead/";
	} else {
		$ativ_link = $d_link;
		$target_link = "_blank";
		$comp_link = "";
	}
	if($edicao == 1){
		$editor = "<a href=\"javascript:abrir('editar_ativ.php?turma_disc=$turma_disc&tipo_ativ=$d_tipo&cod_ativ=$d_cod_ativ')\">[E]</a> | <a href=\"javascript:abrir('excluir_ativ.php?turma_disc=$turma_disc&tipo_ativ=$d_tipo&cod_ativ=$d_cod_ativ')\">[X]</a>";
	}
	echo "
	
	<div style=\"float:left; margin-right:30px\"><a style=\"text-decoration: none;\" target=\"$target_link\" href=\"$comp_link$ativ_link?turma_disc=$turma_disc&tipo_ativ=$d_tipo&cod_ativ=$d_cod_ativ&anograde=$anograde&cod_disc=$cod_disc\"><img src=\"frames_ead/icones/$ativ_rotulo\" title=\"$ativ_tipo\" alt=\"$ativ_tipo\" height=\"auto\">$editor<br>
	<font size=\"-2\" style=\"font-family: 'Nunito', sans-serif; color:#666666; text-decoration: none;\"><b<font size=\"-2\"><b>$ativ_tipo</font></b></font></a>
	</div>

	
	";
}

echo "
<div style=\"float:left; margin-right:30px;\"><a style=\"text-decoration: none;\" target=\"frame_central_ead\" href=\"frames_ead/frame_simulado.php?turma_disc=$turma_disc&tipo_ativ=7&cod_ativ=00&anograde=$anograde&cod_disc=$cod_disc\"><img src=\"frames_ead/icones/icone_simulado.png\" title=\"Simulado\" alt=\"Simulado\" height=\"auto\"><br>
	<font size=\"-2\" style=\"font-family: 'Nunito', sans-serif; color:#666666; text-decoration: none;\"><b><font size=\"-2\">Simulado</font></b></font></a>
	</div>
	
<div style=\"float:left; margin-right:30px;\"><a style=\"text-decoration: none;\" target=\"frame_central_ead\" href=\"frames_ead/frame_avaliacao.php?turma_disc=$turma_disc&tipo_ativ=7&cod_ativ=00&anograde=$anograde&cod_disc=$cod_disc\"><img src=\"frames_ead/icones/icone_avaliacao.png\" title=\"Avaliação Online\" alt=\"Avaliação Online\" height=\"auto\"><br>
	<font size=\"-2\" style=\"font-family: 'Nunito', sans-serif; color:#666666; text-decoration: none;\"><b><font size=\"-2\">Avaliação Online</font></b></font></a>
	</div></center>";
?>
</div>
</td>
</tr>
</table>


<?php
if($edicao == 1){
	echo "<div align=\"right\" style=\"margin-right:50px;\"><a href=\"javascript:abrir('ea_atividade.php?acao=1&turma_disc=$turma_disc&coddisc=$cod_disc&anograde=$anograde');\" title=\"Nova Atividade\">[Nova Atividade]</a></div>
";
}

?>
<hr>
<iframe width="100%" style="z-index:100;" height="" name="frame_central_ead" frameborder="0" id="frame_central_ead" scrolling="no" src="frames_ead/frame_index.php?cod_disc=<?php echo ($cod_disc);?>&anograde=<?php echo ($anograde);?>&edicao=<?php echo $edicao?>&anograde=<?php echo ($anograde);?>&turma_disc=<?php echo $turma_disc?>"></iframe>
</div>
                          </div>
                      </section>
                  </div>
                  
              </div>
              <!-- page end-->
                  
              </div>
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


