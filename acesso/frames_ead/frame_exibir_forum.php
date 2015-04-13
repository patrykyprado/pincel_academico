<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 100;
     }
</script>
    
<?php 
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');
$turma_disc = $_GET["turma_disc"];
$cod_disc = $_GET["coddisc"];
$anograde = $_GET["anograde"];
$id_forum = $_GET["id_forum"];
$cod_ativ = $_GET["cod_ativ"];

//VERIFICA SE POSSUI AGRUPAMENTO PARA A TURMA_DISC
$sql_agrupamento = mysql_query("SELECT * FROM agrupamentos WHERE disciplinas LIKE '%$turma_disc%'");
$contar_agrupamento = mysql_num_rows($sql_agrupamento);


//PEGA O USUARIO TUTOR/PROFESSOR
$sql_professor = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = '$turma_disc'");
$dados_professor = mysql_fetch_array($sql_professor);
$codigo_professor = $dados_professor["cod_prof"];

if(isset($_GET["edicao"])){
	$_SESSION["edicao"] = $_GET["edicao"];
	$edicao = $_GET["edicao"];
} else {
	$_SESSION["edicao"] = 0;
	$edicao = 0;
}
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


//VERIFICA SE ESTA ENTRE A DATA
$sql_botao_forum = mysql_query("SELECT '1' as status FROM ea_forum WHERE id_forum = $id_forum AND (((addtime(now(), '$add_time'))) BETWEEN data_inicio AND data_fim)");
if(mysql_num_rows($sql_botao_forum)>=1 || $forum_inicio == "0000-00-00" || $codigo_professor == $user_usuario  || $permitido == 1){
	$botao_forum = "<br><br><center>
	<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"responder_forum.php?id=$id_forum\" class=\"btn btn-xs btn-success\"><font size=\"+2\">Responder ao Fórum</font></a></center>";	
} else {
	$botao_forum = "<center>
	<a class=\"btn btn-xs btn-info\"><font size=\"\">Esse fórum não está dentro do período de participação.</font></a></center>";
}



//verifica os posts existentes para o fórum
if($contar_agrupamento == 0){
	$sql_post_forum = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $id_forum AND post_resposta = 0 ORDER BY data_modif ASC");
	$total_post_forum = mysql_num_rows($sql_post_forum);
	
	$usuario = trim($user_usuario);
	$data_hora_atual = date("Y-m-d H:i:s");
	$sql_log_forum = mysql_query("SELECT * FROM ea_log_forum WHERE id_foruns = $id_forum AND usuario LIKE '$usuario'");
	if(mysql_num_rows($sql_log_forum)==0){
		mysql_query("INSERT INTO ea_log_forum (id_log, usuario, id_foruns, data_hora) VALUES (NULL, '$usuario', '$id_forum', '$data_hora_atual');");
	} else {
		$dados_log_forum = mysql_fetch_array($sql_log_forum);
		$id_log_forum = $dados_log_forum["id_log"];
		mysql_query("UPDATE ea_log_forum SET data_hora = '$data_hora_atual' WHERE id_log = '$id_log_forum';");
	}
	
	
} else {
	$dados_agrupamento = mysql_fetch_array($sql_agrupamento);
	$turmas_agrupamento = $dados_agrupamento["disciplinas"];
	$id_agrupamento = $dados_agrupamento["id_agrupamento"];
	$sql_foruns_agrupamentos = mysql_query("SELECT * FROM ea_forum WHERE subturma = '$id_agrupamento' AND titulo like '$forum_topico'");
	$id_foruns_agrupados = "";
	$contar_foruns_agrupados = mysql_num_rows($sql_foruns_agrupamentos);
	while($dados_foruns_agr = mysql_fetch_array($sql_foruns_agrupamentos)){
		if($contar_foruns_agrupados >1){
			$id_foruns_agrupados .= $dados_foruns_agr["id_forum"].",";
		} else {
			$id_foruns_agrupados .=$dados_foruns_agr["id_forum"];
		}
		$contar_foruns_agrupados -=1;
	}
	
	$usuario = trim($user_usuario);
	$data_hora_atual = date("Y-m-d H:i:s");
	$sql_log_forum = mysql_query("SELECT * FROM ea_log_forum WHERE id_foruns IN ($id_foruns_agrupados) AND usuario LIKE '$usuario'");
	if(mysql_num_rows($sql_log_forum)==0){
		mysql_query("INSERT INTO ea_log_forum (id_log, usuario, id_foruns, data_hora) VALUES (NULL, '$usuario', '$id_foruns_agrupados', '$data_hora_atual');");
	} else {
		$dados_log_forum = mysql_fetch_array($sql_log_forum);
		$id_log_forum = $dados_log_forum["id_log"];
		mysql_query("UPDATE ea_log_forum SET data_hora = '$data_hora_atual' WHERE id_log = '$id_log_forum';");
	}
	
	
	//VERIFICA TODOS OS POSTS EM TODAS AS TURMAS
	$sql_post_forum = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum IN ($id_foruns_agrupados) AND post_resposta = 0 ORDER BY data_modif ASC");
	$total_post_forum = mysql_num_rows($sql_post_forum);
}
$sql_forum = mysql_query("SELECT * FROM ea_forum WHERE cod_ativ = '$cod_ativ' AND turma_disc = '$turma_disc' ORDER BY data_criacao");
$total_forum = mysql_num_rows($sql_forum);
?>
<div id="central" style="margin-bottom:300px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade." - ".$forum_topico);
?>
</font> 
<font size="-1" color="#FFFFFF">(<?php echo format_data($forum_inicio)." à ".format_data($forum_fim);?>)</font>

</td>
</tr>
<tr>
<td colspan="3" bgcolor="#D5D5D5" align="left">
<?php echo $forum_descricao;?>
</td>
</tr>

</table>

<hr>

<?php 
$contar_post = $total_post_forum;
if($total_post_forum >=1){
	while($dados_post = mysql_fetch_array($sql_post_forum)){
		$post_matricula = trim($dados_post["matricula"]);
		$post_data =format_data_hora($dados_post["data_modif"]);
		$post_comentario =$dados_post["comentario"];
		$post_comentario_nota = format_valor($dados_post["nota_comentario"]);
		$post_id =$dados_post["id_post"];
		$post_id_forum =$dados_post["id_forum"];
		//cor do post
		$cor_post = "#bfd2cc";
		if($post_matricula == $codigo_professor){
			$cor_post = "#FFFACD";
		}
		
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
		$id_atividade = "F_".$post_id_forum;
		
		//PEGA A TURMA DISC DO POST
		$sql_turma_disc_post = mysql_query("SELECT ef.id_forum, ef.turma_disc FROM ea_post_forum epf INNER JOIN ea_forum ef
ON ef.id_forum = epf.id_forum WHERE epf.id_post = $post_id");
		$dados_disc_post = mysql_fetch_array($sql_turma_disc_post);
		$turma_disc_post = $dados_disc_post["turma_disc"];
		
		$sql_atividade_boletim = mysql_query("SELECT * FROM ced_turma_ativ WHERE id_atividade LIKE '$id_atividade' AND cod_turma_d = '$turma_disc_post'");
		$dados_atividade_boletim = mysql_fetch_array($sql_atividade_boletim);
		$ref_atividade = $dados_atividade_boletim["ref_id"];
		$max_nota = $dados_atividade_boletim["valor"];
		
		$sql_nota = mysql_query("SELECT cta.valor, cn.nota, cn.codnota FROM ced_turma_ativ cta
INNER JOIN ced_notas cn
ON cn.ref_ativ = cta.ref_id
WHERE cn.matricula = '$post_matricula' AND turma_disc = '$turma_disc_post' AND cta.id_atividade LIKE '$id_atividade' ");
		if(mysql_num_rows($sql_nota)==0){
			$nota_aluno = "0,00";
			$nota_comp = 0;
		} else {
			$dados_nota = mysql_fetch_array($sql_nota);
			$nota_aluno = format_valor($dados_nota["nota"]);
			$cod_nota = $dados_nota["codnota"];
			$nota_comp = $dados_nota["nota"];
		}
		if($nota_aluno == "0,00"){
			$cor_nota = "#A0522D";
		} else {
			$cor_nota = "#818181";
		}
		if($max_nota == $nota_comp){
			$cor_nota = "#2E8B57";
		} 
		
		//VERIFICA PERMISSÃO DE PROFESSOR
		if($codigo_professor == $user_usuario || $permitido == 1){
			$botao_excluir = "
			<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"excluir_post_forum.php?id_post=$post_id\"><font size=\"+1\"><div class=\"fa fa-trash-o tooltips\" data-placement=\"bottom\" data-original-title=\"Excluir esse comentário\"></div></font></a>";
			$botao_filtrar = "
			<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"filtrar_post_forum.php?id_forum=$post_id_forum&matricula=$post_matricula\"><font size=\"+1\"><div class=\"fa fa-search tooltips\" data-placement=\"bottom\" data-original-title=\"Filtrar comentários de $usuario_nome\"></div></font></a>";
			$botao_editar = "
			<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"editar_post_forum.php?id_post=$post_id\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"bottom\" data-original-title=\"Editar comentário\"></div></font></a>";
			$tipo_ficha = "ficha.php?codigo";
			$filtro_professor = "";
			$botao_resposta = "
			<a style=\"color:#FFF\" target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"responder_forum.php?id=$post_id_forum&user_resposta=$post_id\"><div class=\"tooltips\" data-placement=\"bottom\" data-original-title=\"Responder esse comentário\">[Responder ao aluno]</div></a>
			";
			$botao_nota = "			
			<a style=\"color:#FFF\" target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"registrar_nota_forum.php?turma_disc=$turma_disc_post&id=$cod_nota&matricula=$post_matricula&ref_id=$ref_atividade\"><div class=\"tooltips\" data-placement=\"bottom\" data-original-title=\"Registrar nota de $usuario_nome\">Nota: $nota_aluno</div></a>
			";
		} else {
			$botao_excluir = "";
			$botao_filtrar = "";
			$botao_editar = "";
			$tipo_ficha = "perfil_publico.php?id";
			$filtro_professor = " style=\"visibility:hidden;\" ";
			$botao_resposta = "";
			$botao_nota = "";
		}
		if($codigo_professor == $post_matricula){
			$barra_nota = "";
		} else {
			$barra_nota = "<tr bgcolor=\"$cor_nota\">
		<td bgcolor=\"$cor_nota\" colspan=\"2\">$botao_nota</td>
		<td align=\"right\" bgcolor=\"$cor_nota\">
		$botao_resposta
		</td>
		</tr>";
		}
		echo "
		<table width=\"100%\" align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" style=\"font-family: Nunito, sans-serif;\">
		<tr bgcolor=\"$cor_post\">
		<td width=\"45px\"> 
		<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"../$tipo_ficha=$post_matricula\"><img src=\"$usuario_foto\" width=\"40px\" height=\"40px\"></a>
		</td>
		<td colspan=\"2\">
		Comentário de: <a  target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"../$tipo_ficha=$post_matricula\">$usuario_nome</a><br>
		<font size=\"-2\">$post_data 
		$botao_filtrar $botao_editar $botao_excluir
		</font>
		</td>
		</tr>
		<tr bgcolor=\"#e3faf2\">
		<td colspan=\"3\">
		<div style=\"padding:10px\">$post_comentario</div>
		</td>
		</tr>
		$barra_nota
		";
		//PEGA RESPOSTAS DOS TUTORES/ADMINISTRADORES
		$sql_post_forum_adm = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $post_id_forum AND post_resposta LIKE '$post_id' ORDER BY data_modif ASC");
		if(mysql_num_rows($sql_post_forum_adm)>=1){
			while($dados_post_forum_adm = mysql_fetch_array($sql_post_forum_adm)){
				$post_matricula2 = $dados_post_forum_adm["matricula"];
				$post_data2 =format_data_hora($dados_post_forum_adm["data_modif"]);
				$post_comentario2 =$dados_post_forum_adm["comentario"];
				$post_comentario_nota2 = format_valor($dados_post_forum_adm["nota_comentario"]);
				$post_id2 =$dados_post_forum_adm["id_post"];
				//cor do post
				$cor_post = "#bfd2cc";
				if($post_matricula2 == $codigo_professor || $permitido == 1){
					$cor_post = "#FFFACD";
				}
				
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
				
				
				//VERIFICA PERMISSÃO DE PROFESSOR
				if($codigo_professor == $user_usuario || $permitido == 1){
					$botao_excluir = "
					<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"excluir_post_forum.php?id_post=$post_id2\"><font size=\"+1\"><div class=\"fa fa-trash-o tooltips\" data-placement=\"bottom\" data-original-title=\"Excluir esse comentário\"></div></font></a>";
					$botao_filtrar = "
					<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"filtrar_post_forum.php?id_forum=$post_id_forum&matricula=$post_matricula2\"><font size=\"+1\"><div class=\"fa fa-search tooltips\" data-placement=\"bottom\" data-original-title=\"Filtrar comentários de $usuario_nome\"></div></font></a>";
					$botao_editar = "
					<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"editar_post_forum.php?id_post=$post_id2\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"bottom\" data-original-title=\"Editar comentário\"></div></font></a>";
					$tipo_ficha = "ficha.php?codigo";
					$filtro_professor = "";
					$botao_resposta = "<a style=\"color:#FFF\" href=\"javascript:abrir('responder_forum.php?id=$post_id_forum&user_resposta=$post_id2');\">[Responder ao aluno]</a>";
					$botao_nota = "<a style=\"color:#FFF\" href=\"javascript:abrir('registrar_nota_forum.php?id=$cod_nota&matricula=$post_matricula2&ref_id=$ref_atividade');\">Nota: $nota_aluno</a>";
				} else {
					$botao_excluir = "";
					$botao_filtrar = "";
					$botao_editar = "";
					$tipo_ficha = "perfil_publico.php";
					$filtro_professor = " style=\"visibility:hidden;\" ";
					$botao_resposta = "";
					$botao_nota = "";
				}
				
				echo "
				<tr>
				<td width=\"45px\">
				</td>
				<td width=\"45px\" bgcolor=\"#bfd2cc\">
				<a href=\"javascript:abrir('../$tipo_ficha?id=$post_matricula2');\"><img src=\"$usuario_foto2\" width=\"40px\" height=\"40px\"></a>
				</td>
				<td colspan=\"2\" bgcolor=\"#bfd2cc\">
				Resposta de: <a href=\"javascript:abrir('../$tipo_ficha?id=$post_matricula2');\">$usuario_nome2</a><br>
				<font size=\"-2\">$post_data2
				$botao_filtrar $botao_editar $botao_excluir
				</font>
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
		echo "
				<br>";
		
	}
	
}
	
?>
<tr>
<td colspan="3">
<?php echo $botao_forum;?><br><br><br><br><br><br><br><br>


</td>
</tr>
<tr>
<td colspan="3" align="right">
</td>
</tr>
</table>

<br /><br />
<?php 
include('../includes/js_ead.php');
?>
</div>
    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
	  
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
	
function excluir (URL){


if(confirm ("Atenção: Deseja realmente excluir o comentário?"))
{
	  var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
}
else
{
exit;
}
}
	
    </script>
    