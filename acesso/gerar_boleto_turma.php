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
 <?php 
 include('includes/funcoes.php');
include('includes/conectar.php');
$ano_ref = $_GET["ano_ref"];
$id_turma = $_GET["id_turma"];

$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = $dados_turma["curso"];
$turma_cod = $dados_turma["cod_turma"];
$turma_modulo = $dados_turma["modulo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
$turma_turno = $dados_turma["turno"];
$turma_grupo = $dados_turma["grupo"];
$tipo_etapa = $dados_turma["tipo_etapa"];

//PEGA OS ALUNOS DA TURMA
$sql_alunos = mysql_query("SELECT distinct matricula FROM view_alunos_ata WHERE id_turma = $id_turma ORDER BY nome");

?>

  <body>
  <div class="filtro">
<center><a href="javascript:window.print();">[IMPRIMIR]</a></center></div>
<?php
while($dados_alunos = mysql_fetch_array($sql_alunos)){
	$matricula = $dados_alunos['matricula'];
	//PEGA OS TITULOS DO ALUNO
	$sql_titulos = mysql_query("SELECT id_titulo, parcela, layout FROM geral_titulos WHERE codigo = $matricula AND vencimento LIKE '%$ano_ref%' AND (data_pagto IS NULL OR TRIM(data_pagto) = '') AND
STATUS = 0 AND conta_nome LIKE '%$turma_unidade%' ORDER BY vencimento");
	while($dados_titulos = mysql_fetch_array($sql_titulos)){
		$id_titulo = $dados_titulos['id_titulo'];
		$parcela = $dados_titulos['parcela'];
		$layout = $dados_titulos['layout'];
		echo "<iframe name=\"frame_boleto\" scrolling=\"no\" width=\"100%\" frameborder=\"0\" style=\"height:900px;\" src=\"../boleto/$layout?id=$id_titulo&p=$parcela&id2=$matricula\"></iframe>
";
		
	}
}
?>


           </div>    


  </body>
</html>

