<link href="http://fonts.googleapis.com/css?family=Nunito:300" rel="stylesheet" type="text/css">
<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 35;
     }
    </script>
<?php 
/* Define o limite de tempo do cache em 180 minutos */
session_cache_expire(180);
?>

<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');


$post_senha_certa = 1;
$post_senha_dig = 1;

if($post_senha_certa != $post_senha_dig){
	echo "<script language=\"javascript\">
	alert('A senha digitada está incorreta.');
	history.back();
	</script>";
} else {


$turma_disc = $_GET["turma_disc"];
$cod_disc = $_GET["cod_disc"];
$tipo = 2;

$_SESSION["simulado_turma_disc"] = $turma_disc;
$_SESSION["simulado_cod_disc"] = $cod_disc;
$_SESSION["simulado_tipo"] = $tipo;



//pega dados da turma
$sql_turma_d = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_turma_d = mysql_fetch_array($sql_turma_d);
$id_turma = $dados_turma_d["id_turma"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = trim($dados_turma["curso"]);
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$anograde = $dados_turma["anograde"];
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
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disc' AND anograde LIKE '%$anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];

?>

<div id="central" style="margin-bottom:100px;">
<table width="100%">
	<tr>
		<td align="center" style="border: medium none;
    font-size: 13px;
	line-height: 20px;
	background: #2a3542;
	color: #FFF;
	padding-bottom:10px;
	padding-top:10px;
	font-family: 'Open Sans', sans-serif;"><b><font size="+1">Simulado de <?php echo $nome_disciplina;?></font></b><td>
	</tr>
</table>
<form method="POST" class="form-horizontal tasi-form" action="frame_confirm_simulado.php">
<?php 
$sql_bd = mysql_query("SELECT * FROM view_simulado WHERE nome_bq LIKE '%$nome_disciplina%' AND cursos LIKE '%$turma_curso%' LIMIT 1");
if(mysql_num_rows($sql_bd)==0){
	$sql_bd = mysql_query("SELECT * FROM view_simulado WHERE nome_bq LIKE '%$nome_disciplina%' AND cursos LIKE '%COMUM%' LIMIT 1");
}
$dados_bd = mysql_fetch_array($sql_bd);
$limite_questoes = 10;
//PEGA QUESTÕES BAIXO
$nquestoes_baixo = 5;
$banco_baixo = $dados_bd["id_bq_1"];
//PEGA QUESTÕES MÉDIO
$nquestoes_medio = 3;
$banco_medio = $dados_bd["id_bq_2"];
//PEGA QUESTÕES ALTO
$nquestoes_alto = 2;
$banco_alto = $dados_bd["id_bq_3"];

//MONTA QUESTÕES BAIXO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_baixo' AND simulado = 0 AND inativo = 0 ORDER BY id_questao LIMIT $nquestoes_baixo");
$num_questao = 1;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = trim($dados_questao["questao"]);
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table width=\"100%\">
	<tr>
	<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\" align=\"center\"><b><font size=\"+1\">$n_questao - </font></b></td>
		<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\"><b><font size=\"+1\">$questao_questao</font></b></td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "
		<tr>
			<td width=\"5%\"><input type=\"hidden\" name=\"id_opcao[]\" value=\"$opcaoid\"><input type=\"hidden\" name=\"campo_nome[]\" value=\"$questao_cod\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\"></td>
			<td width=\"5%\">$letra_opcao</td>
			<td width=\"5%\"><input class=\"botao_escolha\" name=\"{$questao_cod}_option[]\" value=\"$opcaoid\" type=\"radio\" onKeyDown=\"javascript:return Verificar();\"  /></td>
			<td width=\"85%\"> $opcaoresposta</td>
		</tr>
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	echo "</table>";
 }


//MONTA QUESTÕES MÉDIO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_medio' AND simulado = 0 ORDER BY id_questao LIMIT $nquestoes_medio");
$num_questao = $num_questao;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table width=\"100%\">
	<tr>
	<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\" align=\"center\"><b><font size=\"+1\">$n_questao - </font></b></td>
		<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\"><b><font size=\"+1\">$questao_questao</font></b></td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "
		<tr>
			<td width=\"5%\"><input type=\"hidden\" name=\"id_opcao[]\" value=\"$opcaoid\"><input type=\"hidden\" name=\"campo_nome[]\" value=\"$questao_cod\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\"></td>
			<td width=\"5%\">$letra_opcao</td>
			<td width=\"5%\"><input class=\"botao_escolha\" name=\"{$questao_cod}_option[]\" value=\"$opcaoid\" type=\"radio\" onKeyDown=\"javascript:return Verificar();\"  /></td>
			<td width=\"85%\"> $opcaoresposta</td>
		</tr>
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	echo "</table>";
	
 }
 
 
//MONTA QUESTÕES ALTO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_alto' AND simulado = 0 ORDER BY id_questao LIMIT $nquestoes_alto");
$num_questao = $num_questao;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table width=\"100%\">
	<tr>
	<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\" align=\"center\"><b><font size=\"+1\">$n_questao - </font></b></td>
		<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\"><b><font size=\"+1\">$questao_questao</font></b></td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "
		<tr>
			<td width=\"5%\"><input type=\"hidden\" name=\"id_opcao[]\" value=\"$opcaoid\"><input type=\"hidden\" name=\"campo_nome[]\" value=\"$questao_cod\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\"></td>
			<td width=\"5%\">$letra_opcao</td>
			<td width=\"5%\"><input class=\"botao_escolha\" name=\"{$questao_cod}_option[]\" value=\"$opcaoid\" type=\"radio\" onKeyDown=\"javascript:return Verificar();\"  /></td>
			<td width=\"85%\"> $opcaoresposta</td>
		</tr>
	
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	echo "</table>";
	
 }






if($num_questao == 1){
	echo "<center>Não existem questões disponíveis para esse simulado!</center>";
} else {
echo "
<br><center><input class=\"btn btn-xs btn-success\" type=\"submit\"  value=\"Finalizar Avalia&ccedil;&atilde;o\"></center>";
	mysql_close();
}

}


?>
</form>
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
