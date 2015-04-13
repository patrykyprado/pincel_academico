<?php
include("includes/conectar.php");
include("includes/head.php");
include("includes/restricao.php");
include("includes/funcoes.php");
if($_GET["id"] ==0){
	echo "<center>Selecione um alerta ao lado para ver o registro.</center>";
} else {
$get_id_mensagem = $_GET["id"];
$sql_ver_mensagem = mysql_query("SELECT * FROM alertas WHERE id_alert = $get_id_mensagem");
$dados_ver_mensagem = mysql_fetch_array($sql_ver_mensagem);
mysql_query("UPDATE alertas SET visto = 1 WHERE id_alert = $get_id_mensagem");
$pesq_de = $dados_ver_mensagem["de"];
//PEGA O REMETENTE DA MENSAGEM
		$sql_remetente = mysql_query("SELECT * FROM users WHERE usuario LIKE '$pesq_de'");
		if(mysql_num_rows($sql_remetente)>= 1){
			$dados_remetente = mysql_fetch_array($sql_remetente);
		} else {
			$sql_remetente = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$pesq_de'");
			$dados_remetente = mysql_fetch_array($sql_remetente);
		}
		$de_nome = $dados_remetente["nome"];
		$de_foto = $dados_remetente["foto_perfil"];
		if(strlen($de_nome)>=15){
			$de_nome = substr($de_nome,0,15)."...";
		}
if(trim($dados_ver_mensagem["titulo"])== ""){
	$titulo_msg = "{Sem Título}";
} else {
	$titulo_msg = $dados_ver_mensagem["titulo"];
}
$texto_msg = $dados_ver_mensagem["texto"];
echo "
<table class=\"table table-striped\" width=\"100%\">
	<tr>
		<td><font size=\"+1\">$titulo_msg</font><td>
	</tr>
	<tr>
		<td><font size=\"-1\">$texto_msg</font><td>
	</tr>
</table>

";

}
?>