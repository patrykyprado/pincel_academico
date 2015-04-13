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



?>
<div id="central">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade);
?>
</font>

</td>
</tr>
</table>

<hr>
<table width="100%" align="center" cellpadding="4" cellspacing="4">

<tr>
<td colspan="3" align="left">
<div class="pagina">
<?php
echo $conteudo_atividade;

?>
<?php
$sql_estudo_dirigido = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE turma_disc = '$turma_disc' ORDER BY data_criacao");
$total_estudo = mysql_num_rows($sql_estudo_dirigido);
if($total_estudo >= 1){
	echo "<table width=\"100%\" class=\"full_table_list\" align=\"center\" border=\"1\">
	<tr>
<td bgcolor=\"#C8C8C8\" colspan=\"5\" align=\"center\">
<B><font size=\"+2\">Atividades</font></B>
</td>
</tr>
	<tr>
		<td  bgcolor=\"#6C6C6C\" style=\"color:#FFF\" align=\"center\"><b>Assunto</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\" colspan=\"2\"><b>Período</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>Valor</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>Envios</b></td>
	</tr>
	";
	while($dados_estudo = mysql_fetch_array($sql_estudo_dirigido)){
		$estudo_titulo = substr($dados_estudo["titulo"],0,30);
		$estudo_id = $dados_estudo["id_estudo"];
		$estudo_subturma = $dados_estudo["subturma"];
		$estudo_valor = format_valor($dados_estudo["max_nota"]);
		$estudo_inicio = format_data_hora($dados_estudo["data_inicio"]);
		$estudo_fim = format_data_hora($dados_estudo["data_fim"]);
		
		if($codigo_professor == $user_usuario || $permitido == 1){
			
			//verifica turmas do agrupamento
			$sql_agrupamento = mysql_query("SELECT * FROM agrupamentos WHERE id_agrupamento = $estudo_subturma");
			if(mysql_num_rows($sql_agrupamento)==1){
				$dados_agrupamento = mysql_fetch_array($sql_agrupamento);
				$estudo_turmas = $dados_agrupamento["disciplinas"];
				//VERIFICA QUANTOS ESTUDOS DIRIGIDOS FORAM ENVIADOS
				$sql_verificar_estudos = mysql_query("SELECT eed.turma_disc, eee.id_estudo,eee.id_envio FROM ea_estudo_envio eee
		INNER JOIN ea_estudo_dirigido eed 
		ON eed.id_estudo = eee.id_estudo WHERE eed.turma_disc IN ($estudo_turmas)");
				$envios = mysql_num_rows($sql_verificar_estudos);
		
			} else {
				$sql_contar_envios = mysql_query("SELECT * FROM ea_estudo_envio WHERE id_estudo = '$estudo_id'");
				$envios = mysql_num_rows($sql_contar_envios);
			}
		} else {
			$sql_contar_envios = mysql_query("SELECT * FROM ea_estudo_envio WHERE id_estudo = '$estudo_id' AND matricula = '$user_usuario'");
			$envios = mysql_num_rows($sql_contar_envios);
		}
		
		
		
		
		
		
		if($codigo_professor == $user_usuario || $permitido == 1){
			$botao_excluir = "			
			<td align=\"center\">
			<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"editar_estudo_dirigido.php?id_estudo=$estudo_id\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"left\" data-original-title=\"Editar Estudo Dirigido\"></div></font></a>
			<a href=\"javascript:excluir('excluir_estudo_dirigido.php?id_estudo=$estudo_id')\"><font size=\"+1\"><div class=\"fa fa-trash-o tooltips\" data-placement=\"left\" data-original-title=\"Excluir Estudo Dirigido\"></div></font></a>
			</td>
			";
		} else {
			$botao_excluir = "";
		}
		
		echo "
		<tr><td><b><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$estudo_titulo</a></b></td>
			<td align=\"center\"><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$estudo_inicio</a></td>
			<td align=\"center\"><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$estudo_fim</a></td>
			<td align=\"center\"><b><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$estudo_valor</a></b></td>
			<td align=\"center\"><b><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$envios</a></b></td>
			$botao_excluir
		</tr>";
	}
	echo "</table>";
		
}
if($codigo_professor == $user_usuario || $permitido == 1){
	echo "
<br>
<center>
	<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"cad_estudo.php?acao=1&cod_ativ=$cod_ativ&turma_disc=$turma_disc\" class=\"btn btn-xs btn-info\"><font size=\"+2\">Nova Atividade</font></a></center>
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


if(confirm ("Atenção: Deseja realmente excluir a atividade? Todas as notas serão apagadas."))
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