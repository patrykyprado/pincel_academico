<head>
<!-- CSS DE IMPRESSÃO -->
    <link href="css/imprimir.css" media="print" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" media="screen" rel="stylesheet">
    <style type="text/css">
    body,td,th {
	font-family: "Open Sans", sans-serif;
}
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("meio_frame").height = document.getElementById("frame").scrollHeight + 35;
     }
    </script>
 <?php 
 include('includes/funcoes.php');

include('includes/conectar.php');

//PEGA O POST
$post_cod_barras = $_POST["cod_barras"];
$post_id_titulo = $_POST["id_titulo"];
$post_cliente = $_POST["id_cliente"];

if($post_cod_barras == ""){
	$sql_cod_barras = "";	
} else {
	$sql_cod_barras = "AND tic.codigo_barras LIKE '%$post_cod_barras%' ";	
}
if($post_id_titulo == ""){
	$sql_id_titulo = "";	
} else {
	$sql_id_titulo = "AND tic.id_titulo LIKE '%$post_id_titulo%' ";
}
if($post_cliente == ""){
	$sql_cliente = "";	
} else {
	$sql_cliente = "AND (alu.nome LIKE '%$post_cliente%' OR alu.nome_fin LIKE '%$post_cliente%')";
}

$sql_hist_titulo = mysql_query("SELECT tic.id_controle, alu.codigo, alu.nome, tit.id_titulo,tic.codigo_barras, tic.nosso_numero, tic.conta,con.conta AS conta_nome, tic.data_hora  
FROM titulos_codigos tic
INNER JOIN titulos tit
ON tic.id_titulo = tit.id_titulo
INNER JOIN alunos alu
ON alu.codigo = tit.cliente_fornecedor
INNER JOIN contas con
ON con.cedente = tic.conta
WHERE alu.nome != '' $sql_cod_barras $sql_id_titulo $sql_cliente ORDER BY tic.data_hora;");

$sql = "SELECT tic.id_controle, alu.codigo, alu.nome, tit.id_titulo,tic.codigo_barras, tic.nosso_numero, tic.conta,con.conta AS conta_nome, tic.data_hora  
FROM titulos_codigos tic
INNER JOIN titulos tit
ON tic.id_titulo = tit.id_titulo
INNER JOIN alunos alu
ON alu.codigo = tit.cliente_fornecedor
INNER JOIN contas con
ON con.cedente = tic.conta
WHERE alu.nome != '' $sql_cod_barras $sql_id_titulo $sql_cliente ORDER BY tic.data_hora;";

$total_encontrado = mysql_num_rows($sql_hist_titulo);


?>

  <body>
<div id="frame">
<?php
if($total_encontrado == 0){
	echo "<center><b>Nenhum resultado encontrado.</center></b>";	
} else {
	echo "
	<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
	<tr>
		<td align=\"center\"><b>Título</b></td>
		<td align=\"center\"><b>Conta</b></td>
		<td align=\"center\"><b>Data de Impressão</b></td>
	</tr>";
	while($dados_hist_titulos = mysql_fetch_array($sql_hist_titulo)){
		$id_titulo = $dados_hist_titulos["id_titulo"];
		$conta_titulo = $dados_hist_titulos["conta_nome"];
		$data_hora = format_data_hora($dados_hist_titulos["data_hora"]);
		$id_controle = $dados_hist_titulos["id_controle"];
		echo "
		<tr bgcolor=\"#FFF\">
			<td align=\"center\">$id_titulo</td>
			<td>$conta_titulo</td>
			<td align=\"center\">$data_hora</td>
		</tr>";
			
	}
	
	echo "</table>";
}

?>
</div>
</body>
