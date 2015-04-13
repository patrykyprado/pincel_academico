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

$turma_disc = $_GET["turma_disc"];
$cod_disc = $_GET["coddisc"];
$anograde = $_GET["anograde"];
$id_estudo = $_GET["id_estudo"];
$cod_ativ = $_GET["cod_ativ"];

//VERIFICA SE POSSUI AGRUPAMENTO PARA A TURMA_DISC
$sql_agrupamento = mysql_query("SELECT * FROM agrupamentos WHERE disciplinas LIKE '%$turma_disc%'");
$contar_agrupamento = mysql_num_rows($sql_agrupamento);

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


//PEGA NOME DO TOPICO
$sql_estudo = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE id_estudo = $id_estudo");
$dados_estudo = mysql_fetch_array($sql_estudo);
$estudo_titulo = $dados_estudo["titulo"];
$estudo_inicio = $dados_estudo["data_inicio"];
$estudo_fim = $dados_estudo["data_fim"];
$estudo_descricao = $dados_estudo["descricao"];
$estudo_tentativa = $dados_estudo["tentativas"];

//VERIFICA SE ESTA ENTRE A DATA
$sql_botao_estudo = mysql_query("SELECT '1' as status FROM ea_estudo_dirigido WHERE id_estudo = $id_estudo AND ((addtime(now(), '$add_time'))) BETWEEN data_inicio AND data_fim");
if(mysql_num_rows($sql_botao_estudo)>=1 || $permitido == 1){
	$botao_estudo = "
	<center>
	<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"enviar_estudo.php?id=$id_estudo&user_resposta=0\" class=\"btn btn-xs btn-info\"><font size=\"+2\">Enviar Trabalho</font></a></center>
	";	
} else {
	$botao_estudo = "";
}

?>
<div id="central" style="margin-bottom:100px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade." - ".$estudo_titulo);
?>
</font> 
<font size="-1" color="#FFFFFF">(<?php echo format_data($estudo_inicio)." à ".format_data($estudo_fim);?>)</font>

</td>
</tr>
<tr>
<td colspan="3" bgcolor="#D5D5D5" align="left">
<?php echo $estudo_descricao;?>
</td>
</tr>

</table>

<hr>
<table width="100%" align="center" border="1" style="border:solid">
<tr>
<td colspan="2" align="center"><b>Nome</b></td>
<td align="center"><b>Data de Envio</b></td>
<td align="center"><b>Arquivo</b></td>
<td align="center"><b>Nota</b></td>
<td align="center"><b>Comentário</b></td>
</tr>

<?php
if($codigo_professor == $user_usuario || $permitido == 1){
	$comp_sql = " eee.id_estudo = '$id_estudo'";
	if($contar_agrupamento >= 1){
		$dados_agrupamento = mysql_fetch_array($sql_agrupamento);
		$agr_turmas_disc = $dados_agrupamento["disciplinas"];
		$sql_agrupamento_estudo = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE turma_disc IN ($agr_turmas_disc)");
		
		//monta array com dados dos estudos
		$estudos_agrupados = "";
		$total_estudos = mysql_num_rows($sql_agrupamento_estudo);
		while($dados_agr_estudo = mysql_fetch_array($sql_agrupamento_estudo)){
			if($total_estudos >= 2){
				$estudos_agrupados .= $dados_agr_estudo["id_estudo"].",";
			} else {
				$estudos_agrupados .= $dados_agr_estudo["id_estudo"];
			}
			$total_estudos -= 1;
		}
		$comp_sql = " eee.id_estudo IN ($estudos_agrupados) ";
	}
	$prof_sql = "$comp_sql";
} else {
	$prof_sql = " eee.id_estudo = '$id_estudo' AND eee.matricula = '$user_usuario'";
}

$sql_envios = mysql_query("SELECT eee.*, eed.turma_disc FROM ea_estudo_envio eee
INNER JOIN ea_estudo_dirigido eed
ON eee.id_estudo = eed.id_estudo WHERE $prof_sql ORDER BY data_envio ASC");
$enviados = mysql_num_rows($sql_envios);
while($dados_envios = mysql_fetch_array($sql_envios)){
	$matricula = (int)trim($dados_envios["matricula"]);
	$envio_turma_disc = trim($dados_envios["turma_disc"]);
	$envio_estudo_id = trim($dados_envios["id_estudo"]);
	$estudo_id_envio = $dados_envios["id_envio"];
	$estudo_comentario = substr($dados_envios["comentario"],0,30);
	$data_envio = format_data_hora($dados_envios["data_envio"]);
	$arquivo = $dados_envios["arquivo"];

	//PEGA DADOS DO USUÁRIO QUE POSTOU
	$sql_dados_usuario = mysql_query("SELECT * FROM users WHERE usuario LIKE '$matricula'");
	if(mysql_num_rows($sql_dados_usuario)==0){
		$sql_dados_usuario = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$matricula'");
	} else {
		$sql_dados_usuario = $sql_dados_usuario;
	}
	$dados_usuario = mysql_fetch_array($sql_dados_usuario);
	$usuario_nome = format_curso($dados_usuario["nome"]);
	//PEGA A NOTA ATUAL DO ALUNO
		$id_atividade = "E_".$envio_estudo_id;
		
		$sql_atividade_boletim = mysql_query("SELECT * FROM ced_turma_ativ WHERE id_atividade LIKE '$id_atividade' AND cod_turma_d = '$envio_turma_disc'");
		$dados_atividade_boletim = mysql_fetch_array($sql_atividade_boletim);
		$ref_atividade = $dados_atividade_boletim["ref_id"];
		
		$sql_nota = mysql_query("SELECT cta.valor, cn.nota, cn.codnota FROM ced_turma_ativ cta
INNER JOIN ced_notas cn
ON cn.ref_ativ = cta.ref_id
WHERE cn.matricula LIKE '$matricula' AND turma_disc = '$envio_turma_disc' AND cta.id_atividade LIKE '$id_atividade' ");
		if(mysql_num_rows($sql_nota)==0){
			$nota_aluno = "0,00";
		} else {
			$dados_nota = mysql_fetch_array($sql_nota);
			$nota_aluno = format_valor($dados_nota["nota"]);
			$cod_nota = $dados_nota["codnota"];
		}
		//VERIFICA SE PODE LANÇAR NOTA
		if($codigo_professor == $user_usuario || $permitido == 1){
			$botao_nota = "target=\"_top\" onclick=\"return openTopSBX(this);\"  href=\"registrar_nota_estudo.php?id=$cod_nota&matricula=$matricula&ref_id=$ref_atividade&turma_disc=$envio_turma_disc&id_envio=$estudo_id_envio\"";
		} else {
			$botao_nota = "href=\"javascript:alert('Sua nota atual dessa atividade é: $nota_aluno pontos.');\"";
		}
	echo "
	<tr>
<td colspan=\"2\" align=\"center\">$usuario_nome</td>
<td align=\"center\">$data_envio</td>
<td align=\"center\"><a href=\"javascript:abrir('../../trabalhos/$arquivo');\"><b>[Visualizar]</b></a></td>
<td align=\"center\"><a $botao_nota><b>$nota_aluno</b></a></td>
<td><a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"ver_comentario.php?id_envio=$estudo_id_envio\">$estudo_comentario</a></td>
</tr>
	";
}

?>

</table>
<br><br>
<center><font size="+2"><b>**Atenção**</b></font><br>
Essa atividade permite um máximo de <b><?php echo $estudo_tentativa;?></b> envios.
<br> Você ja enviou <?php echo $enviados;?> arquivo(s).</center>
<br>
<center><?php 
if($enviados >= $estudo_tentativa&&$permitido == 0){
	echo "<center>Você já enviou o máximo de arquivos permitidos.</center>";
} else {
	echo $botao_estudo;
}
	?></center>
<br /><br />
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
    </script>