<link href="http://fonts.googleapis.com/css?family=Nunito:300" rel="stylesheet" type="text/css">
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

$turma_disc = $_SESSION["prova_turma_disc"];
$cod_disc = $_SESSION["prova_cod_disc"];
$prova_tipo = $_SESSION["prova_tipo"];



$get_id_quest = $_GET["id_q"];
//pega dados da turma
$sql_turma_d = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_turma_d = mysql_fetch_array($sql_turma_d);
$id_turma = $dados_turma_d["id_turma"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = $dados_turma["curso"];
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$turma_anograde = trim($dados_turma["anograde"]);
$turma_polo = $dados_turma["polo"];
if($turma_modulo == 1){
$turma_modulo_exib = "I";
}

if($turma_modulo == 2){
$turma_modulo_exib = "II";
}

if($turma_modulo == 3){
$turma_modulo_exib = "III";
}



//pega dados da disciplina
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$cod_disc%' AND anograde LIKE '%$turma_anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];

?>

<div id="central" style="margin-bottom:100px;">

<?php 
$sql_questionario = mysql_query("SELECT * FROM ea_questionario WHERE id_questionario = '$get_id_quest' AND 
((addtime(now(), '$add_time')) BETWEEN data_inicio AND data_fim)");
if(mysql_num_rows($sql_questionario)==0){
	header("location:ea_exercicio.php");
} else {
	$dados_questionario = mysql_fetch_array($sql_questionario);
	$questionario_id = $dados_questionario["id_questionario"];
	$questionario_valor = number_format($dados_questionario["valor"],2,",",".");
	$questionario_senha = $dados_questionario["senha"];
	$_SESSION["senha_prova_correta"] = $questionario_senha;
	//PEGA QUESTÕES NIVEL BAIXO
	$idbd_baixo = $dados_questionario["id_bd"];
	$questoes_baixo = $dados_questionario["qtd_questoes"];
	//PEGA QUESTÕES NIVEL MÉDIO
	$idbd_medio = $dados_questionario["id_bd2"];
	$questoes_medio = $dados_questionario["qtd_questoes2"];
	//PEGA QUESTÕES NIVEL ALTO
	$idbd_alto = $dados_questionario["id_bd3"];
	$questoes_alto = $dados_questionario["qtd_questoes3"];
	//PEGA TOTAL DE QUESTÕES
	$total_questoes = $questoes_alto + $questoes_baixo + $questoes_medio;
	
	$questionario_inicio = format_data_hora($dados_questionario["data_inicio"]);
	$questionario_fim = format_data_hora($dados_questionario["data_fim"]);
	if($questionario_senha != ""){
		$exib_senha = "password";	
	} else {
		$exib_senha = "hidden";	
	}
	$action = "ea_questionario.php?id_q=$questionario_id";
	if($prova_tipo == "1"){
		$nome_botao = "Iniciar Avaliação";
	} else {
		$nome_botao = "Iniciar Exercicio";
	}
	echo "
	<form method=\"post\" action=\"$action\">
	<table class=\"full_table_cad\" border=\"1\" align=\"center\">

		<tr>
			<td><b>Quantidade de Questões:</b></td>
			<td align=\"center\">$total_questoes questões</td>
		<tr>
		<tr>
			<td><b>Valor:</b</td>
			<td align=\"center\">$questionario_valor pontos</td>
		<tr>
		<tr>
			<td><b>Início:</b</td>
			<td align=\"center\">$questionario_inicio</td>
		<tr>
		<tr>
			<td><b>Fim:</b</td>
			<td align=\"center\">$questionario_fim</td>
		<tr>
		<tr>
			<td style=\"visibility:$exib_senha\"><b>Senha:</b></td>
			<td style=\"visibility:$exib_senha\" align=\"center\"><input type=\"$exib_senha\" name=\"senha_dig\">
			
		<tr>
		<tr>
			<td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"iniciar\" value=\"$nome_botao\"></td>
		<tr>
	</table>
	</form>
	";
}
?>
</div>
<?php
include('../includes/js_ead.php');
?>
</body>
</html>
