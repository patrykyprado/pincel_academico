<?php
include("includes/conectar.php");
include("includes/head.php");
include("includes/restricao.php");
include("includes/funcoes.php");
$sql_alertas = mysql_query("SELECT * FROM alertas WHERE para LIKE '$user_usuario' AND tipo = 1 ORDER BY datahora DESC");
$sql_alertas_naolidos = mysql_query("SELECT * FROM alertas WHERE para LIKE '$user_usuario' AND visto = 0  AND tipo = 1 ORDER BY datahora DESC");
if(mysql_num_rows($sql_alertas)==0){
	echo "<center>Não há alertas para você.</center>";	
} else {
	$total_alerta = mysql_num_rows($sql_alertas);
	$total_alerta_naolidos = mysql_num_rows($sql_alertas_naolidos);
	echo "<table border=\"1\"  class=\"table table-hover\">
	<tr>
	<td align=\"center\"><b>Alertas ($total_alerta_naolidos / $total_alerta)</b></td>
	</tr>
	";
while($dados_alertas = mysql_fetch_array($sql_alertas)){
	$alerta_id = $dados_alertas["id_alert"];
	$alerta_titulo = substr($dados_alertas["titulo"],0,15)."...";
	$alerta_datahora = format_data_hora($dados_alertas["datahora"]);
	$alerta_visto =$dados_alertas["visto"];;
	if($alerta_visto == 0){
		$cor_visto = "blue";
	} else {
		$cor_visto = "black";
	}
	echo "
	
	<tr>
	<td><a target=\"frame_corpo\" href=\"frame_exib_alerta.php?id=$alerta_id\" style=\"color:$cor_visto\">
	<font size=\"-2\">$alerta_titulo</font><br>
	<font size=\"-3\">$alerta_datahora</font>
	</a></td>
	</tr>
	";
	
}
echo "</table>";
}



?>