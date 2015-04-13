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
$id_turma = $_GET["id"];
$etapa = $_GET["etapa"];
$cancelado_observacao = "";

if($etapa != 0){
	$comp_nome_ata = "Parciais";	
} else {
	$comp_nome_ata = "Finais";		
}

//PEGA NOME DA ETAPA
$sql_etapa = mysql_query("SELECT * FROM ced_etapas WHERE id_etapa = $etapa");
$dados_etapa = mysql_fetch_array($sql_etapa);
$nome_etapa = $dados_etapa["etapa"];
$etapa_min_nota = $dados_etapa["min_nota"];

//PEGA OS DADOS DA TURMA
$turma_pesq2 = mysql_query("SELECT * FROM ced_turma WHERE  id_turma = $id_turma");
$dados_turma2 = mysql_fetch_array($turma_pesq2);
$cod_turma = $dados_turma2["cod_turma"];
$grupo_turma = $dados_turma2["grupo"];
$nivel_turma = trim($dados_turma2["nivel"]);
$curso_turma = trim($dados_turma2["curso"]);
$modulo_turma = trim($dados_turma2["modulo"]);
$unidade_turma = $dados_turma2["unidade"];
$polo_turma = $dados_turma2["polo"];
$inicio_turma = $dados_turma2["inicio"];
$fim_turma = $dados_turma2["fim"];
$min_nota = $dados_turma2["min_nota"];
$min_freq = $dados_turma2["min_freq"];

//MONTA O IN BASE
$sql_bases = mysql_query("SELECT distinct base_ensino FROM disciplinas WHERE curso LIKE '%$curso_turma%' AND nivel LIKE '%$nivel_turma%' AND modulo = $modulo_turma ORDER BY base_ensino");
if(mysql_num_rows($sql_bases)>=1){
	$base_in = "00";
	while($dados_bases = mysql_fetch_array($sql_bases)){
		$base_in .= ",".$dados_bases["base_ensino"];
	}
}

//PEGA NOME DA BASE
$sql_base = mysql_query("SELECT * FROM ced_base_ensino WHERE id_base IN ($base_in)");
?>

  <body>
<div class="filtro">  <center><A href="javascript:window.print();">[IMPRIMIR]</A></center></div>
<?php
while($dados_base = mysql_fetch_array($sql_base)){
	$nome_base = $dados_base["base_ensino"];
	$id_base = $dados_base["id_base"];
	$sql_disciplinas = mysql_query("SELECT codigo, nome_disciplina FROM view_disciplinas_ata
	WHERE base_ensino = $id_base AND id_turma = $id_turma AND nome_disciplina NOT LIKE '%EAD%'
	ORDER BY disciplina");
	$total_disciplinas = mysql_num_rows($sql_disciplinas);
	$count2 = mysql_num_rows($sql_disciplinas);
	$sql_alunos = mysql_query("SELECT DISTINCT matricula, nome FROM view_alunos_ata WHERE id_turma = $id_turma");
	$total_alunos = mysql_num_rows($sql_alunos);
	if($total_alunos == 0){
		echo "<script language=\"javascript\">
		alert('Nenhum aluno encontrado na turma!');
		</script>";	
	} else {
		if($total_disciplinas >=1){
			echo "<table width=\"100%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" class=\"full_table_list\" style=\"font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px\">
		
			
			<tr class=\"diario_frequencia_header\">
			<th colspan=\"2\"><img src=\"images/logo-cedtec.png\" /></th>
			<th align=\"center\" colspan=\"$count2\">Ata de Resultados $comp_nome_ata - $nome_etapa</th>
			</tr>
			
			<tr class=\"diario_frequencia_header\">
			<td colspan=\"2\"><b>Curso:<br />".strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Ano/Módulo ".strtoupper($modulo_turma)."</b></td>
			<td><b>Ano/Semestre:<br />$grupo_turma</b></td>
			<td><b>Unidade / Polo - Turma<br />$unidade_turma / $polo_turma - $cod_turma</b></td>
			</tr>
			</table>
			
			<table width=\"100%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" class=\"full_table_list\" style=\"font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px; color:#000\"\">
			<tr>
				<td align=\"center\" rowspan=\"2\"><b>Nº</b></td>
				<td align=\"center\" rowspan=\"2\"><b>Nome</b></td>";
			//MONTA AS COLUNAS DAS DISCIPLINAS	
			$array_disciplinas = array();
			$x_array_disciplinas = 1;
			while($dados_disciplinas = mysql_fetch_array($sql_disciplinas)){
				$disciplina_nome = $dados_disciplinas["nome_disciplina"];
				$disciplina_codigo = $dados_disciplinas["codigo"];
				$array_disciplinas[$x_array_disciplinas] = 
				array("nome_disciplina" => $disciplina_nome,
				"disciplina_codigo" => $disciplina_codigo);
				
				$x_array_disciplinas +=1;
				
				
				echo "<td align=\"center\" colspan=\"2\" width=\"100px;\"><b>$disciplina_nome $disciplina_codigo</b></td>";
			}
			echo "
			<td align=\"center\" rowspan=\"2\"><b>Resultado</b></td>
			</tr>
			<tr>";
			$x_disciplinas = $total_disciplinas;
			while($x_disciplinas >=1){
				echo "<td align=\"center\"><b>Nota</b></td>
			<td align=\"center\"><b>Faltas</b></td>";
				$x_disciplinas -=1;	
			}
			
			//MONTA O CORPO DA ATA
			$n_aluno = 1;
			while($dados_alunos = mysql_fetch_array($sql_alunos)){
				$aluno_matricula = $dados_alunos["matricula"];
				$aluno_nome = $dados_alunos["nome"];	
				echo "<tr>
					<td align=\"center\" width=\"20px\">$n_aluno</td>
					<td>$aluno_nome</td>";
				$total_array = 1;
				while($total_array <= $total_disciplinas){
					$turma_disc = $array_disciplinas[$total_array]["disciplina_codigo"];
					$sql_nota = mysql_query("SELECT SUM(notafinal) as notafinal FROM view_boletim_notas WHERE subgrupo <> 'C' AND turma_disc = $turma_disc AND etapa = $etapa AND matricula = $aluno_matricula GROUP BY matricula");
					if(mysql_num_rows($sql_nota) ==0){
						$nota_aluno = 0;	
					} else {
						$dados_nota = mysql_fetch_array($sql_nota);
						$nota_aluno = $dados_nota["notafinal"];	
					}
					echo "<td align=\"center\">$nota_aluno</td>
					<td align=\"center\">$turma_disc</td>";	
					$total_array +=1;	
				}
				echo "</tr>";
				$n_aluno +=1;
			}
			
			echo "</table>";
		}
	}
}
?>


  </body>
</html>
