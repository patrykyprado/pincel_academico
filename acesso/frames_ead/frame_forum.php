<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 35;
     }
</script>
    
<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');
$cod_disc = $_GET["cod_disc"];
$cod_ativ = $_GET["cod_ativ"];
$turma_disc = $_GET["turma_disc"];
$anograde = $_GET["anograde"];
if(isset($_GET["edicao"])){
	$_SESSION["edicao"] = $_GET["edicao"];
	$edicao = $_GET["edicao"];
} else {
	$_SESSION["edicao"] = 0;
	$edicao = 0;
}



//PEGA O USUARIO TUTOR/PROFESSOR
$sql_professor = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = '$turma_disc'");
$dados_professor = mysql_fetch_array($sql_professor);
$codigo_professor = $dados_professor["cod_prof"];


$sql_atividade = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' AND cod_ativ = '$cod_ativ' ORDER BY ordem_ativ");
$dados_atividade = mysql_fetch_array($sql_atividade);
$conteudo_atividade = $dados_atividade["conteudo"];
$tipo_atividade = $dados_atividade["tipo"];

$sql_tipo_atividade = mysql_query("SELECT * FROM ea_tipo_ativ WHERE  cod_tipo = '$tipo_atividade'");
$dados_tipo_atividade = mysql_fetch_array($sql_tipo_atividade);

$nome_atividade = $dados_tipo_atividade["tipo"];



//verifica fóruns existentes para a turma

$sql_forum = mysql_query("SELECT * FROM ea_forum WHERE turma_disc = '$turma_disc' ORDER BY data_criacao");
$total_forum = mysql_num_rows($sql_forum);
?>
<div id="central">
<table width="100%" align="center">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade);
?>
</font>

</td>
</tr>
<tr>
<td colspan="3" bgcolor="#E9E8E8" align="left">
<?php echo $conteudo_atividade;?>
</td>
</tr>
</table>

<hr>
<table width="100%" align="center">
<tr>
<td bgcolor="#C8C8C8" colspan="3" align="center">
<B><font size="+2">Tópicos</font></B>
</td>
</tr>
<tr>
<td colspan="3" align="left">
<div class="pagina">
<?php
if($total_forum >= 1){
	if($permitido == 1){
		$tabela_participantes_topo = "<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b></b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>PARTICIPANTES</b></td>
		";	
	} else {
		$tabela_participantes_topo = "";	
	}
	echo "<table width=\"100%\" align=\"center\" border=\"1\">
	<tr>
		<td  bgcolor=\"#6C6C6C\" style=\"color:#FFF\" align=\"center\"><b>ASSUNTO</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\" colspan=\"2\"><b>PERÍODO</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>VALOR</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>RESPOSTAS</b></td>
		$tabela_participantes_topo
	</tr>
	";
	while($dados_forum = mysql_fetch_array($sql_forum)){
		$forum_titulo = substr($dados_forum["titulo"],0,30);
		$forum_id = $dados_forum["id_forum"];
		$forum_valor = $dados_forum["max_nota"];
		$forum_inicio = format_data_hora($dados_forum["data_inicio"]);
		$forum_fim = format_data_hora($dados_forum["data_fim"]);
		
		//VERIFICA SE POSSUI AGRUPAMENTO PARA A TURMA_DISC
		$sql_agrupamento = mysql_query("SELECT * FROM agrupamentos WHERE disciplinas LIKE '%$turma_disc%'");
		$contar_agrupamento = mysql_num_rows($sql_agrupamento);
		
		
		if($contar_agrupamento == 0){
			//CONTADOR DE POSTS NO FÓRUM
			$sql_post_forum = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $forum_id ORDER BY data_modif ASC");
			$total_post_forum = mysql_num_rows($sql_post_forum);
			
			//CONTADOR DE POSTS NÃO VISUALIZADOS
			$usuario = trim($user_usuario);
			$sql_log_forum = mysql_query("SELECT * FROM ea_log_forum WHERE id_foruns = '$forum_id' AND usuario LIKE '$usuario'");
			if(mysql_num_rows($sql_log_forum)==0){
				$total_post_pendente = $total_post_forum;
			} else {
				$dados_log_forum = mysql_fetch_array($sql_log_forum);
				$log_data_hora = $dados_log_forum["data_hora"];
				$sql_post_forum2 = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = '$forum_id' AND data_modif > '$log_data_hora'");
				$total_post_pendente = mysql_num_rows($sql_post_forum2);
			}
			
			
		} else {
			$dados_agrupamento = mysql_fetch_array($sql_agrupamento);
			$turmas_agrupamento = $dados_agrupamento["disciplinas"];			
			$id_agrupamento = $dados_agrupamento["id_agrupamento"];
			$sql_foruns_agrupamentos = mysql_query("SELECT * FROM ea_forum WHERE subturma = '$id_agrupamento' AND titulo like '%$forum_titulo%'");
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
			if($permitido == 1){
				//VERIFICA ALUNOS PARTICIPANTES
				$sql_participantes = mysql_query("SELECT DISTINCT cad.matricula FROM ced_aluno_disc cad
	INNER JOIN ced_turma_disc ctd
	ON cad.turma_disc = ctd.codigo
	WHERE cad.turma_disc IN ($turmas_agrupamento) AND cad.matricula NOT IN (SELECT matricula FROM ocorrencias WHERE n_ocorrencia = 1 AND id_turma = ctd.id_turma)");
				$total_participantes = mysql_num_rows($sql_participantes);
				$matriculas_participantes = '000';
				while($dados_participantes = mysql_fetch_array($sql_participantes)){
					$matriculas_participantes .= ','.$dados_participantes['matricula'];
				}
				//CONTA QUEM PARTICIPOU
				$sql_participantes_ok = mysql_query("SELECT COUNT(DISTINCT matricula) AS total_participou FROM ea_post_forum WHERE id_forum IN ($id_foruns_agrupados) AND matricula IN ($matriculas_participantes)");
				$dados_participantes_ok = mysql_fetch_array($sql_participantes_ok);
				$total_participantes_ok = $dados_participantes_ok["total_participou"];
				$tabela_participantes_corpo = "<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$total_participantes_ok / $total_participantes</a></b></td>";
			} else {
				$tabela_participantes_corpo = "";
			}
			
			//CONTADOR DE POSTS NO FÓRUM
			$sql_post_forum = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum IN ($id_foruns_agrupados) ORDER BY data_modif ASC");
			if(mysql_num_rows($sql_post_forum)==0){
				$total_post_forum = 0;
			} else {
				$total_post_forum = mysql_num_rows($sql_post_forum);
			}
			//CONTADOR DE POSTS NÃO VISUALIZADOS
			$usuario = trim($user_usuario);
			$sql_log_forum = mysql_query("SELECT * FROM ea_log_forum WHERE id_foruns IN ($id_foruns_agrupados) AND usuario LIKE '$usuario'");
			if(mysql_num_rows($sql_log_forum)==0){
				$total_post_pendente = $total_post_forum;
			} else {
				$dados_log_forum = mysql_fetch_array($sql_log_forum);
				$log_data_hora = $dados_log_forum["data_hora"];
				$sql_post_forum2 = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum IN ($id_foruns_agrupados) AND data_modif > '$log_data_hora'");
				$total_post_pendente = mysql_num_rows($sql_post_forum2);
			}
			
			
		}
		
		
		if($forum_inicio == "//" || $forum_fim == "//"){
			$forum_periodo = "<td align=\"center\" colspan=\"2\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">LIVRE</a></b></td>";
		} else {
			$forum_periodo = "<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_inicio</a></b></td>
								<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_fim</a></b></td>";
		}
		if($forum_valor == 0){
			$forum_valor_exib = "NÃO AVALIATIVO";
		} else {
			$forum_valor_exib = number_format($forum_valor,2,",",".")." Pts";
		}
		if($codigo_professor == $user_usuario || $permitido == 1){
			$botao_excluir = "<td align=\"center\">
			<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"editar_topico.php?id_forum=$forum_id\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"left\" data-original-title=\"Editar Tópico\"></div></font></a>
			<a href=\"javascript:excluir('excluir_topico.php?id_forum=$forum_id')\"><font size=\"+1\"><div class=\"fa fa-trash-o tooltips\" data-placement=\"left\" data-original-title=\"Excluir Tópico\"></div></font></a>
			</td>";
		} else {
			$botao_excluir = "";
		}
		echo "
		
		<tr><td><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_titulo</a></b></td>
			<a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_periodo</a>
			<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_valor_exib</a></b></td>
			<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$total_post_pendente / $total_post_forum</a></b></td>
			$botao_excluir
			$tabela_participantes_corpo
		</tr>";
	}
	echo "</table>";
		
}
if($codigo_professor == $user_usuario || $permitido == 1){
	echo "<br>
<center>
	<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"topico.php?acao=1&cod_ativ=$cod_ativ&turma_disc=$turma_disc\" class=\"btn btn-xs btn-info\"><font size=\"+2\">Novo Tópico</font></a></center>
	";
}

?>

</div>

</td>
</tr>
</table>

</div>
<?php 
include('../includes/js_ead.php');
?>
    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
	
function excluir (URL){


if(confirm ("Atenção: Deseja realmente excluir o tópico? Todas as notas e comentários referente ao tópico serão apagadas."))
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
    
    
    