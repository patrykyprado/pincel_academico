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



$post_senha_certa = 1;
$post_senha_dig = 1;

if($post_senha_certa != $post_senha_dig){
	echo "<script language=\"javascript\">
	alert('A senha digitada está incorreta.');
	history.back();
	</script>";
} else {


$turma_disc = $_GET["turma_disc"];
$tentativa = $_GET["tentativa"];




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

<table width="500px" border="1">
<tr>
	<td width="100px" bgcolor="yellow"></td>
    <td width="400px">Respostas corretas s&atilde;o marcadas em amarelo</td>
</tr>
<tr>
	<td align="center"><B><font size="+2">X</font></b></td>
    <td>Respostas marcardas por voc&ecirc;.</td>
</tr>
</table>
<hr>
<?php 


//MONTA REVISÃO
$sql_f_questoes = mysql_query("SELECT DISTINCT cod_questao FROM ea_simu_feedback WHERE tentativa = '$tentativa' AND turma_disc = '$turma_disc' AND matricula = '$user_usuario'");
$num_questao = 1;


while($dados_f_questao = mysql_fetch_array($sql_f_questoes)){
	$cod_f_questao = $dados_f_questao["cod_questao"];
	$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE cod_questao LIKE '$cod_f_questao'");
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
		$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod'");
		$num_opcao = 1;
		while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
			$opcaoid = $dados_opcoes["id_resposta"];
			$opcaovalor = $dados_opcoes["valor"];
			$opcaoresposta = $dados_opcoes["resposta"];	
			$letra_opcao = format_letra($num_opcao);
			
			//PEGA AS OPÇÕES SELECIONADAS
			$sql_revisao_feedback = mysql_query("SELECT * FROM ea_simu_feedback WHERE cod_questao = '$questao_cod' AND tentativa = '$tentativa' AND turma_disc = '$turma_disc' AND matricula = '$user_usuario'");
			$dados_revisao = mysql_fetch_array($sql_revisao_feedback);
			$revisao_resposta = $dados_revisao["resposta"];
			$revisao_idopcao = $dados_revisao["id_opcao"];
			if($revisao_resposta == $opcaoid){
				$select_resposta = "<B><font size=\"+2\">X</font></b>";
			} else {
				$select_resposta = "";
			}
			
			if($opcaovalor >= 1){
				$cor_resposta = "bgcolor=\"yellow\"";
			} else {
				$cor_resposta = "";
			}
			
			
			echo "
		<tr>
			<td width=\"5%\"><input type=\"hidden\" name=\"id_opcao[]\" value=\"$opcaoid\"><input type=\"hidden\" name=\"campo_nome[]\" value=\"$questao_cod\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\"></td>
			<td  $cor_resposta width=\"10%\">$select_resposta $letra_opcao</td>
			<td  $cor_resposta width=\"85%\"> $opcaoresposta</td>
		</tr>
		";
			$num_opcao += 1;
		}
		$num_questao +=1;
		
	 }
}
	mysql_close();
}


?>
</form>
</div>


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
