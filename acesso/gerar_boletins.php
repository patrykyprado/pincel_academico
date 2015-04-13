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
<body>
 <?php 
 include('includes/funcoes.php');
 ?>
<?php
include('includes/conectar.php');
$id_turma = $_GET["id_turma"];
?>
<div class="filtro"><center><a href="javascript:window.print();">[IMPRIMIR]</a></center></div>
<?php
$sql_alunos = mysql_query("SELECT cta.matricula, alu.nome FROM ced_turma_aluno cta INNER JOIN alunos alu
ON cta.matricula = alu.codigo WHERE cta.id_turma = $id_turma");
while($dados_alunos=mysql_fetch_array($sql_alunos)){
	$matricula_aluno = $dados_alunos["matricula"];
	$link = "gerar_boletim_turma2.php?id_turma=".$id_turma."&id_aluno=".$matricula_aluno;
	echo "<iframe style=\"border:0px\" src=\"$link\" width=\"100%\" scrolling=\"no\" height=\"97%\"></iframe>";	
}
?>
</body>
