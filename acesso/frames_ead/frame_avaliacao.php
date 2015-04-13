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

$turma_disc = $_GET["turma_disc"];
$cod_disc = $_GET["cod_disc"];
$tipo = 1;

$_SESSION["prova_turma_disc"] = $turma_disc;
$_SESSION["prova_cod_disc"] = $cod_disc;
$_SESSION["prova_tipo"] = $tipo;


//pega dados da turma
$sql_turma_d = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_turma_d = mysql_fetch_array($sql_turma_d);
$id_turma = $dados_turma_d["id_turma"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = trim($dados_turma["nivel"]);
$turma_curso = trim($dados_turma["curso"]);
$turma_modulo = trim($dados_turma["modulo"]);
$turma_grupo = trim($dados_turma["grupo"]);
$turma_unidade = trim($dados_turma["unidade"]);
$turma_polo = trim($dados_turma["polo"]);
$turma_anograde = trim($dados_turma["anograde"]);
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
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disc' AND anograde LIKE '%$turma_anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];
?>

<div id="central" style="margin-bottom:100px;">


<?php 
$agora = trim(date("Y-m-d h:i:s"));
$sql_questionario = mysql_query("SELECT * FROM ea_questionario WHERE turma_disc = '$turma_disc' AND 
((addtime(now(), '$add_time')) BETWEEN data_inicio AND data_fim)");
if(mysql_num_rows($sql_questionario)==0){
	if($tipo == "1"){
		echo "<center>Essa avaliação ainda não está disponível. Verifique a data de realização com a sua unidade de ensino.</center>";
	} else {
		echo "<center>Esse exercicio ainda não está disponível. Verifique a data de realização com a sua unidade de ensino.</center>";
	}
		
} else {
	$dados_questionario = mysql_fetch_array($sql_questionario);
	$questionario_id = $dados_questionario["id_questionario"];
	$questionario_valor = number_format($dados_questionario["valor"],2,",",".");
	$questionario_senha = $dados_questionario["senha"];
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
		$exib_senha = "Essa atividade requer uma senha para acesso.";	
	} else {
		$exib_senha = "Essa atividade não requer senha.";	
	}
	if($tipo == "1"){
		$botao = "<center><a href=\"ea_questionario_seg.php?id_q=$questionario_id\">[INICIAR AVALIAÇÃO]</a></center>";
	} else {
		$botao ="<center><a href=\"ea_questionario_seg.php?id_q=$questionario_id\">[INICIAR ATIVIDADE]</a></center>";
	}
	
	echo "
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
			<td><b>Senha:</b></td>
			<td align=\"center\">$exib_senha</td>
		<tr>
		<tr>
			<td colspan=\"2\">$botao</td>
		<tr>
	</table>
	";
	
	
}

?>
</div>

<?php
include('../includes/js_ead.php');
?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
</div>
</body>
</html>
