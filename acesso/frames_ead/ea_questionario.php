<link href="http://fonts.googleapis.com/css?family=Nunito:300" rel="stylesheet" type="text/css">
<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 35;
     }
    </script>
<script language="JavaScript"> 
function pergunta(){ 
   if (confirm('ATENÇÃO: Deseja realmente finalizar a avaliação?')){ 
      document.form_prova.submit() 
   } 
} 
</script> 
<?php 
/* Define o limite de tempo do cache em 180 minutos */
$expira = 60*60*24*14;
header("Pragma: public");
header("Cache-Control: maxage=".$expira);
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');

if($_SERVER["REQUEST_METHOD"]=="POST"){
$post_senha_certa = $_SESSION["senha_prova_correta"];
$post_senha_dig = $_POST["senha_dig"];

if($post_senha_certa != $post_senha_dig){
	echo "<script language=\"javascript\">
	alert('A senha digitada está incorreta.');
	history.back();
	</script>";
} else {

$turma_disc = $_SESSION["prova_turma_disc"];
$cod_disc = $_SESSION["prova_cod_disc"];
$tipo = $_SESSION["prova_tipo"];

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

$sql_ver_tentativa = mysql_query("SELECT max(tentativa) as tentativa FROM ea_q_feedback WHERE id_questionario = '$get_id_quest' AND matricula = '$user_usuario'");
	$dados_tentativa = mysql_fetch_array($sql_ver_tentativa);
	$tentativa = $dados_tentativa["tentativa"];
	$sql_max_tentativa = mysql_query("SELECT * FROM ea_questionario WHERE id_questionario = $get_id_quest");
	$dados_max_tentativa = mysql_fetch_array($sql_max_tentativa);
	$max_tentativa = $dados_max_tentativa["tentativas"];
	if($tentativa >= $max_tentativa&&$tipo == 1){
		echo "<script language=\"javascript\">
	alert('Você ja realizou o máximo de tentativas permitidas para essa atividade');
	history.back();
	</script>";
	}


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
	font-family: 'Open Sans', sans-serif;"><b><font size="+1">Avalia&ccedil;&atilde;o de <?php echo $nome_disciplina;?></font></b><td>
	</tr>
</table>
<form method="POST" id="form_prova" name="form_prova" action="ea_confirm_questionario.php">
<input type="hidden" value="<?php echo $get_id_quest;?>" name="id_questionario"/>
<?php 
$sql_questionario = mysql_query("SELECT * FROM ea_questionario WHERE id_questionario = '$get_id_quest'");
$dados_q = mysql_fetch_array($sql_questionario);
//PEGA QUESTÕES BAIXO
$nquestoes_baixo = $dados_q["qtd_questoes"];
$banco_baixo = $dados_q["id_bq"];
//PEGA QUESTÕES MÉDIO
$nquestoes_medio = $dados_q["qtd_questoes2"];
$banco_medio = $dados_q["id_bq2"];
//PEGA QUESTÕES ALTO
$nquestoes_alto = $dados_q["qtd_questoes3"];
$banco_alto = $dados_q["id_bq3"];

//MONTA QUESTÕES BAIXO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_baixo' AND simulado = 0  AND inativo = 0 ORDER BY rand() LIMIT $nquestoes_baixo");
$num_questao = 1;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "<table width=\"100%\">
	<tr>
	<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\" align=\"center\"><b><font size=\"+1\">$n_questao - </font></b></td>
		<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\"><b><font size=\"+1\">$questao_questao</font></b></td>
	</tr>";
	
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = 100;
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "<tr>
			<td width=\"5%\"><input type=\"hidden\" name=\"id_opcao[]\" value=\"$opcaoid\"><input type=\"hidden\" name=\"campo_nome[]\" value=\"$questao_cod\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\"></td>
			<td width=\"5%\">$letra_opcao</td>
			<td width=\"5%\"><input class=\"botao_escolha\" name=\"{$questao_cod}_option[]\" value=\"$opcaoid\" type=\"radio\" onKeyDown=\"javascript:return Verificar();\"  /></td>
			<td width=\"85%\"> $opcaoresposta</td>
		</tr>
		";
		$num_opcao += 1;
	}
	echo "</table>";
	$num_questao +=1;
	
 }


//MONTA QUESTÕES MÉDIO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_medio' AND simulado = 0 ORDER BY rand() LIMIT $nquestoes_medio");
$num_questao = $num_questao;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "<table width=\"100%\">
	<tr>
	<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\" align=\"center\"><b><font size=\"+1\">$n_questao - </font></b></td>
		<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\"><b><font size=\"+1\">$questao_questao</font></b></td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = 100;
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "<tr>
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
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_alto' AND simulado = 0 ORDER BY rand() LIMIT $nquestoes_alto");
$num_questao = $num_questao;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "<table width=\"100%\">
	<tr>
	<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\" align=\"center\"><b><font size=\"+1\">$n_questao - </font></b></td>
		<td class=\"avaliacao_top\" colspan=\"2\" valign=\"middle\"><b><font size=\"+1\">$questao_questao</font></b></td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = 100;
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "<tr>
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
<br><center><input class=\"btn btn-xs btn-success\" onclick=\"javascript:pergunta();\" type=\"button\"  value=\"Finalizar Avalia&ccedil;&atilde;o\"></center>";
}
	mysql_close();
	

}
}//fecha o if senha

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
    
<script language="javascript">
function arrumaEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
var i;
for (i = 0; i < field.form.elements.length; i++)
if (field == field.form.elements[i])
break;
i = (i + 1) % field.form.elements.length;
field.form.elements[i].focus();
return false;
}
else
return true;
}
</script>
