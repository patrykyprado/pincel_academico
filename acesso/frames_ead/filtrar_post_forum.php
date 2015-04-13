<!DOCTYPE html>
<html lang="en">
<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/topo_inside_ead.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');

$id_forum = $_GET["id_forum"];
$matricula = trim($_GET["matricula"]);

$sql_atividade = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' AND cod_ativ = '$cod_ativ' ORDER BY ordem_ativ");
$dados_atividade = mysql_fetch_array($sql_atividade);
$conteudo_atividade = $dados_atividade["conteudo"];
$tipo_atividade = $dados_atividade["tipo"];

$sql_tipo_atividade = mysql_query("SELECT * FROM ea_tipo_ativ WHERE  cod_tipo = '$tipo_atividade'");
$dados_tipo_atividade = mysql_fetch_array($sql_tipo_atividade);

$nome_atividade = $dados_tipo_atividade["tipo"];


//PEGA NOME DO TOPICO
$sql_forum = mysql_query("SELECT * FROM ea_forum WHERE id_forum = $id_forum");
$dados_forum = mysql_fetch_array($sql_forum);
$forum_topico = $dados_forum["titulo"];
$forum_inicio = $dados_forum["data_inicio"];
$forum_fim = $dados_forum["data_fim"];
$forum_descricao = $dados_forum["descricao"];

//verifica os posts existentes para o fórum
$sql_post_forum = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $id_forum AND matricula LIKE '$matricula' ORDER BY data_modif ASC");
$total_post_forum = mysql_num_rows($sql_post_forum);
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
                              <b>Filtro de Coment&aacute;rios</b>
                          </header>
                        <div class="panel-body">
<div id="central" style="margin-bottom:100px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($forum_topico);
?>
</font> 
<font size="-1" color="#FFFFFF">(<?php echo format_data($forum_inicio)." à ".format_data($forum_fim);?>)</font>

</td>
</tr>

</table>

<hr>

<?php 
if($total_post_forum >=1){
	while($dados_post = mysql_fetch_array($sql_post_forum)){
		$post_matricula = trim($dados_post["matricula"]);
		$post_data =format_data_hora($dados_post["data_modif"]);
		$post_comentario =$dados_post["comentario"];
		$post_comentario_nota = format_valor($dados_post["nota_comentario"]);
		$post_id =$dados_post["id_post"];
		
		//PEGA DADOS DO USUÁRIO QUE POSTOU
		$sql_dados_usuario = mysql_query("SELECT * FROM users WHERE usuario LIKE '$post_matricula'");
		if(mysql_num_rows($sql_dados_usuario)==0){
			$sql_dados_usuario = mysql_query("SELECT * FROM acessos_completos WHERE usuario = $post_matricula");
		} else {
			$sql_dados_usuario = $sql_dados_usuario;
		}
		$dados_usuario = mysql_fetch_array($sql_dados_usuario);
		$usuario_nome = format_curso($dados_usuario["nome"]);
		$usuario_foto = "../../".$dados_usuario["foto_perfil"];
		
		//PEGA A NOTA ATUAL DO ALUNO
		$id_atividade = "F_".$id_forum;
		
		$sql_atividade_boletim = mysql_query("SELECT * FROM ced_turma_ativ WHERE id_atividade LIKE '$id_atividade' AND cod_turma_d = '$turma_disc'");
		$dados_atividade_boletim = mysql_fetch_array($sql_atividade_boletim);
		$ref_atividade = $dados_atividade_boletim["ref_id"];
		
		$sql_nota = mysql_query("SELECT cta.valor, cn.nota, cn.codnota FROM ced_turma_ativ cta
INNER JOIN ced_notas cn
ON cn.ref_ativ = cta.ref_id
WHERE cn.matricula LIKE '$post_matricula' AND turma_disc = '$turma_disc' AND cta.id_atividade LIKE '$id_atividade' ");
		if(mysql_num_rows($sql_nota)==0){
			$nota_aluno = "0,00";
		} else {
			$dados_nota = mysql_fetch_array($sql_nota);
			$nota_aluno = format_valor($dados_nota["nota"]);
			$cod_nota = $dados_nota["codnota"];
		}

		echo "
		<table width=\"100%\" align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" style=\"font-family: Nunito, sans-serif;\">
		<tr bgcolor=\"#bfd2cc\">
		<td width=\"45px\">
		<a href=\"javascript:abrir('../ficha.php?codigo=$post_matricula');\"><img src=\"$usuario_foto\" width=\"40px\" height=\"40px\"></a>
		</td>
		<td colspan=\"2\">
		Comentário de: <a href=\"javascript:abrir('../ficha.php?codigo=$post_matricula');\">$usuario_nome</a><br>
		<font size=\"-2\">$post_data</font>
		</td>
		</tr>
		<tr bgcolor=\"#e3faf2\">
		<td colspan=\"3\">
		<div style=\"padding:10px\">$post_comentario</div>
		</td>
		</tr>
		
		<tr bgcolor=\"#bfd2cc\">
		<td bgcolor=\"#818181\" colspan=\"3\">
		<a style=\"color:#FFF\" href=\"javascript:abrir('responder_forum.php?id=$id_forum&user_resposta=$post_id');\">[Responder ao aluno]</a>
		</td>
		</tr>
		";
		//PEGA RESPOSTAS DOS TUTORES/ADMINISTRADORES
		$sql_post_forum_adm = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $id_forum AND post_resposta LIKE '$post_id' ORDER BY data_modif ASC");
		if(mysql_num_rows($sql_post_forum_adm)>=1){
			while($dados_post_forum_adm = mysql_fetch_array($sql_post_forum_adm)){
				$post_matricula2 = $dados_post_forum_adm["matricula"];
				$post_data2 =format_data_hora($dados_post_forum_adm["data_modif"]);
				$post_comentario2 =$dados_post_forum_adm["comentario"];
				$post_comentario_nota2 = format_valor($dados_post_forum_adm["nota_comentario"]);
				$post_id2 =$dados_post_forum_adm["id_post"];
				
				//PEGA DADOS DO USUÁRIO QUE POSTOU
				$sql_dados_usuario2 = mysql_query("SELECT * FROM users WHERE usuario LIKE '$post_matricula2'");
				if(mysql_num_rows($sql_dados_usuario2)==0){
					$sql_dados_usuario2 = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$post_matricula2'");
				} else {
					$sql_dados_usuario2 = $sql_dados_usuario2;
				}
				$dados_usuario2 = mysql_fetch_array($sql_dados_usuario2);
				$usuario_nome2 = format_curso($dados_usuario2["nome"]);
				$usuario_foto2 = "../../".$dados_usuario2["foto_perfil"];
				echo "
				<tr>
				<td width=\"45px\">
				</td>
				<td width=\"45px\" bgcolor=\"#bfd2cc\">
				<a href=\"javascript:abrir('../ficha.php?id=$post_matricula2');\"><img src=\"$usuario_foto2\" width=\"40px\" height=\"40px\"></a>
				</td>
				<td colspan=\"2\" bgcolor=\"#bfd2cc\">
				Resposta de: <a href=\"javascript:abrir('../ficha.php?id=$post_matricula2');\">$usuario_nome2</a><br>
				<font size=\"-2\">$post_data2</font>
				</td>
				</tr>
				<tr>
				<td width=\"45px\">
				</td>
				<td colspan=\"2\" bgcolor=\"#e3faf2\">
				<div style=\"padding:10px\">$post_comentario2</div>
				</td>
				</tr>
				";
			}
			
		}
		echo "</table>
				<br>";
		
	}
	
}
?>
<tr>
<td colspan="3" align="right">
</td>
</tr>
</table>           
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