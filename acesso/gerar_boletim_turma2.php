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
$id = $_GET["codigo"];
$id_turma = $_GET["id_turma"];
$id_aluno = $_GET["id_aluno"];
$inicio = $_GET["inicio"];
$fim = $_GET["fim"];

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
$ano_atual = date("Y");
if($id_aluno == 0){
$sql_alunos = mysql_query("
SELECT DISTINCT cta.matricula, alu.nome FROM ced_turma_aluno
cta INNER JOIN alunos alu
ON cta.matricula = alu.codigo
WHERE cta.id_turma = $id_turma ORDER BY alu.nome");
} else {
$sql_alunos = mysql_query("
SELECT DISTINCT cta.matricula, alu.nome FROM ced_turma_aluno
cta INNER JOIN alunos alu
ON cta.matricula = alu.codigo
WHERE cta.id_turma = $id_turma AND matricula = $id_aluno ORDER BY alu.nome");
}
$total_alunos = mysql_num_rows($sql_alunos);
$total_alunos_i = 1;
while($dados_aluno = mysql_fetch_array($sql_alunos)){
	//PEGA AS ETAPAS EXISTENTES NA TURMA
	$sql_etapa_atividades = mysql_query("SELECT id_etapa,etapa, cor_etapa, min_nota, max_nota,grupos_ativ FROM ced_etapas WHERE tipo_etapa LIKE '%$tipo_etapa%'");
	$sql_etapa_nome = mysql_query("SELECT id_etapa, etapa, cor_etapa, min_nota, max_nota,grupos_ativ FROM ced_etapas WHERE tipo_etapa LIKE '%$tipo_etapa%'");
	$mat_aluno = $dados_aluno["matricula"];
	$nome_aluno = $dados_aluno["nome"];
?>

  <body>



<table border="1" class="full_table_list" cellpadding="0" cellspacing="0" width="100%" style="font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th colspan="2">BOLETIM ESCOLAR
    </th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo (strtoupper($turma_nivel)).": ".(strtoupper($turma_curso))." - Ano/M&oacute;dulo ".(strtoupper($turma_modulo));?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $turma_grupo;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $turma_unidade;?> / <?php echo $turma_polo;?> - <?php echo $turma_cod;?></b></td>
    </tr>
    <tr>
    <td colspan="4"><b>Aluno(a):<br /><?php echo $mat_aluno;?> | <?php echo (strtoupper($nome_aluno));?></b></td>
    </tr>
	</table>
    <?php 
	$sql_turma_disc = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma = $id_turma");
	echo "
	<table border=\"1\" class=\"full_table_list\"  cellpadding=\"0\" cellspacing=\"0\" style=\"font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px\">
	<tr>
	<td></td>
  	";
	
	//MONTA AS ETAPAS
	while($dados_etapa = mysql_fetch_array($sql_etapa_nome)){
		$etapa_nome = $dados_etapa["etapa"];
		$etapa_cor = $dados_etapa["cor_etapa"];
		$etapa_id = $dados_etapa["id_etapa"];
		$colspan_etapa = 4;	
		$rowspan = 0;
		if($etapa_id == 3){
			$colspan_etapa = 3;	
		}
		if($etapa_id == 5){
			$colspan_etapa = 1;	
			$rowspan = 2;
		}
		echo "<td align=\"center\" rowspan=\"$rowspan\" bgcolor=\"$etapa_cor\" colspan=\"$colspan_etapa \"><b>$etapa_nome</b></td>";
		
	}
	
	echo "
	</tr>
    <tr>
		<td align=\"center\" bgcolor=\"#D5D5D5\" width=\"30%\"><b>Componente Curricular / Disciplina</b></td>";
	while($dados_etapa = mysql_fetch_array($sql_etapa_atividades)){
		$etapa_cor = $dados_etapa["cor_etapa"];
		$etapa_id = $dados_etapa["id_etapa"];
		$etapa_ativs = $dados_etapa["grupos_ativ"];
		$sql_atividades = mysql_query("SELECT atividade FROM ced_desc_nota WHERE subgrupo LIKE 0 AND grupo IN ($etapa_ativs) ORDER BY codigo");
		while($dados_atividades = mysql_fetch_array($sql_atividades)){
			$atividade = ($dados_atividades["atividade"]);	
			if($etapa_id != 5){
				echo "<td align=\"center\" bgcolor=\"$etapa_cor\"><b>$atividade</b></td>";
			}
		}
		if($etapa_id != 5){
			echo"<td align=\"center\" bgcolor=\"$etapa_cor\"><b>Nota Parcial</b></td>
			";
		}
	}
	echo "<td bgcolor=\"#EEEE0\" align=\"center\"><b>Faltas</b></td>
<td bgcolor=\"#EEEE0\" align=\"center\"><b>Nota Final</b></td>
<td bgcolor=\"#CCC\" align=\"center\"><b>Resultado</b></td></tr>";
		while($dados_turma_disc = mysql_fetch_array($sql_turma_disc)){
			$turma_disc = $dados_turma_disc["codigo"];
			$cod_disc = $dados_turma_disc["disciplina"];
			$ano_grade = $dados_turma_disc["ano_grade"];
			$sql_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina = '$cod_disc' AND anograde LIKE '$ano_grade'");
			$dados_disciplina = mysql_fetch_array($sql_disciplina);
			$disciplina = format_curso(($dados_disciplina["disciplina"]));
			$nota_final = 0;
			echo "
			<tr>
				<td>$disciplina</td>
		";	
		//NOTAS POR ETAPA
		$sql_etapa_notas = mysql_query("SELECT * FROM ced_etapas WHERE tipo_etapa LIKE '%$tipo_etapa%'");
		while($dados_etapa = mysql_fetch_array($sql_etapa_notas)){
			$etapa_cor = $dados_etapa["cor_etapa"];
			$etapa_id = $dados_etapa["id_etapa"];
			$etapa_min_nota = $dados_etapa["min_nota"];
			
			
			//PESQUISA NOTA DE AVALIAÇÕES
			$pesq_nota_a = mysql_query("
			SELECT SUM(cn.nota)as notafinal FROM 
ced_notas cn
INNER JOIN ced_turma_ativ cta
ON cta.ref_id = cn.ref_ativ
INNER JOIN ced_desc_nota cdn
ON cdn.codigo = cta.cod_ativ
WHERE cn.matricula = $mat_aluno AND cn.turma_disc = $turma_disc AND cdn.subgrupo = 'A'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
AND cta.id_etapa = $etapa_id");
			$contar_nota_a = mysql_num_rows($pesq_nota_a);
			if($contar_nota_a == 0){
				$nota_aluno_a = "0,00";
				$nota_parcial1 = 0;
			} else {
				$dados_nota_a = mysql_fetch_array($pesq_nota_a);
				$nota_aluno_a = number_format($dados_nota_a["notafinal"], 2, ',', '');
				$nota_parcial1 = $dados_nota_a["notafinal"];
			}
			//PESQUISA NOTA DE ATIVIDADES DIVERSIFICADAS
			$pesq_nota_b = mysql_query("
			SELECT SUM(cn.nota)as notafinal FROM 
ced_notas cn
INNER JOIN ced_turma_ativ cta
ON cta.ref_id = cn.ref_ativ
INNER JOIN ced_desc_nota cdn
ON cdn.codigo = cta.cod_ativ
WHERE cn.matricula = $mat_aluno AND cn.turma_disc = $turma_disc AND cdn.subgrupo = 'B'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
AND cta.id_etapa = $etapa_id");
			$contar_nota_b = mysql_num_rows($pesq_nota_b);
			if($contar_nota_b == 0){
				$nota_aluno_b = "0,00";
				$nota_parcial2 = 0;
			} else {
				$dados_nota_b = mysql_fetch_array($pesq_nota_b);
				$nota_aluno_b = number_format($dados_nota_b["notafinal"], 2, ',', '');
				$nota_parcial2 = $dados_nota_b["notafinal"];
			}
			if($etapa_id != 3&&$etapa_id !=5){
				//PESQUISA NOTA DE RECUPERAÇÃO
				$pesq_nota_c = mysql_query("
				SELECT SUM(cn.nota)as notafinal FROM 
	ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	INNER JOIN ced_desc_nota cdn
	ON cdn.codigo = cta.cod_ativ
	WHERE cn.matricula = $mat_aluno AND cn.turma_disc = $turma_disc AND cdn.subgrupo = 'C'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
	AND cta.id_etapa = $etapa_id");
				$contar_nota_c = mysql_num_rows($pesq_nota_c);
				if($contar_nota_c == 0){
					$nota_aluno_c = "0,00";
					$nota_parcial3 = 0;
				} else {
					$dados_nota_c = mysql_fetch_array($pesq_nota_c);
					$nota_aluno_c = number_format($dados_nota_c["notafinal"], 2, ',', '');
					$nota_parcial3 = $dados_nota_c["notafinal"];
				}
				$nota_atividades = $nota_parcial1 + $nota_parcial2;
				$nota_recuperação = $nota_parcial3;
				
				if($nota_atividades >= $etapa_min_nota){
					$exibir_nota_parcial = format_valor($nota_atividades);
				}
				if($nota_recuperação == 0){
					$exibir_nota_parcial = format_valor($nota_atividades);
				}
				if($nota_recuperação > 0&&$nota_atividades < $etapa_min_nota){
					$exibir_nota_parcial = format_valor($nota_recuperação);
				}
				if($nota_recuperação < $nota_atividades){
					$exibir_nota_parcial = format_valor($nota_atividades);
				}
				if($nota_recuperação > $nota_atividades){
					$exibir_nota_parcial = format_valor($nota_recuperação);
				}
				$nota_final += str_replace(",",".",$exibir_nota_parcial);
				
				echo "
				<td align=\"center\" bgcolor=\"$etapa_cor\">$nota_aluno_a</td>
				<td align=\"center\" bgcolor=\"$etapa_cor\">$nota_aluno_b</td>
				<td align=\"center\" bgcolor=\"$etapa_cor\">$nota_aluno_c</td>
				<td align=\"center\" bgcolor=\"$etapa_cor\">$exibir_nota_parcial</td>
				";
			}
			//NOTA 3º TRIMESTRE
			if($etapa_id == 3){
				//PESQUISA NOTA DE AVALIAÇÕES
				$pesq_nota_a = mysql_query("
				SELECT IF(SUM(cn.nota) IS NULL, 0,SUM(cn.nota)) AS notafinal FROM 
				ced_notas cn
				INNER JOIN ced_turma_ativ cta
				ON cta.ref_id = cn.ref_ativ
				INNER JOIN ced_desc_nota cdn
				ON cdn.codigo = cta.cod_ativ
				WHERE cn.matricula = $mat_aluno AND cn.turma_disc = $turma_disc AND cdn.subgrupo = 'A'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
				AND cta.id_etapa = $etapa_id");
				$contar_nota_a = mysql_num_rows($pesq_nota_a);
				if($contar_nota_a == 0){
					$nota_aluno_a = "0,00";
					$nota_parcial1 = 0;
				} else {
					$dados_nota_a = mysql_fetch_array($pesq_nota_a);
					$nota_aluno_a = number_format($dados_nota_a["notafinal"], 2, ',', '');
					$nota_parcial1 = $dados_nota_a["notafinal"];
				}
				
				//PESQUISA NOTA DE ATIVIDADES
				$pesq_nota_b = mysql_query("
				SELECT IF(SUM(cn.nota) IS NULL, 0,SUM(cn.nota)) AS notafinal FROM 
				ced_notas cn
				INNER JOIN ced_turma_ativ cta
				ON cta.ref_id = cn.ref_ativ
				INNER JOIN ced_desc_nota cdn
				ON cdn.codigo = cta.cod_ativ
				WHERE cn.matricula = $mat_aluno AND cn.turma_disc = $turma_disc AND cdn.subgrupo = 'B'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
				AND cta.id_etapa = $etapa_id");
				$contar_nota_b = mysql_num_rows($pesq_nota_b);
				if($contar_nota_b == 0){
					$nota_aluno_b = "0,00";
					$nota_parcial1 += 0;
				} else {
					$dados_nota_b = mysql_fetch_array($pesq_nota_b);
					$nota_aluno_b = number_format($dados_nota_b["notafinal"], 2, ',', '');
					$nota_parcial1 += $dados_nota_b["notafinal"];
				}
				$nota_final += $nota_parcial1;
				$exib_nota_parcial = format_valor($nota_parcial1);
				echo "
				<td align=\"center\" bgcolor=\"$etapa_cor\">$nota_aluno_a</td>
				<td align=\"center\" bgcolor=\"$etapa_cor\">$nota_aluno_b</td>
				<td align=\"center\" bgcolor=\"$etapa_cor\">$exib_nota_parcial</td>
				";
			}
			if($etapa_id == 5){
				//PESQUISA NOTA DE RECUPERAÇÃO FINAL
				$pesq_nota_f = mysql_query("
				SELECT IF(SUM(cn.nota) IS NULL, 0,SUM(cn.nota)) AS notafinal FROM 
				ced_notas cn
				INNER JOIN ced_turma_ativ cta
				ON cta.ref_id = cn.ref_ativ
				INNER JOIN ced_desc_nota cdn
				ON cdn.codigo = cta.cod_ativ
				WHERE cn.matricula = $mat_aluno AND cn.turma_disc = $turma_disc AND cdn.subgrupo = 'C'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
				AND cta.id_etapa = $etapa_id");
				$contar_nota_f = mysql_num_rows($pesq_nota_f);
				if($contar_nota_f == 0){
					$nota_aluno_f = "0,00";
				} else {
					$dados_nota_f = mysql_fetch_array($pesq_nota_f);
					$nota_aluno_f = $dados_nota_f["notafinal"];
				}
				echo "
				<td align=\"center\" bgcolor=\"$etapa_cor\">".format_valor($nota_aluno_f)."</td>
				";	
			}
			
		}
		//PEGA AS FALTAS
		$sql_falta = mysql_query("SELECT COUNT(*) as falta_total FROM ced_falta_aluno WHERE matricula = '$mat_aluno' AND turma_disc = '$turma_disc' AND status LIKE 'F' AND data IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_disc')");
		$dados_falta = mysql_fetch_array($sql_falta);
		$falta         = $dados_falta["falta_total"];
		if($nota_final >= 59&&$nota_final<=60){
			$nota_final = 60;
		}
		if($nota_aluno_f <= $nota_final){
			$nota_final = $nota_final;	
		} else {
			$nota_final = $nota_aluno_f;	
		}
		$exibir_nota_final = format_valor($nota_final);
		
		// exibi resultado final
		if($nota_final >= 60){
			$exibir_resultado = "<td align=\"center\" bgcolor=\"\"><b><div id=\"resultado\">Aprovado</div></b></td>
			";
		} else {
			$exibir_resultado = "<td align=\"center\" bgcolor=\"#FFDAB9\"><b><div style=\"color:#000\" id=\"resultado\">Reprovado</div></b></td>";
		}
		echo "<td bgcolor=\"#EEEE0\" align=\"center\"><b>$falta</b></td>
<td bgcolor=\"#EEEE0\" align=\"center\"><b>$exibir_nota_final</b></td>
$exibir_resultado</tr>";
	}
	?>
<tr>
    <td colspan="15" valign="top"><b>Observa&ccedil;&otilde;es:</b> O detalhamento de notas, faltas e ocorr&ecirc;cncias est&atilde;o dispon&iacute;veis em seu portal acad&ecirc;mico, entre em www.cedtec.com.br e clique em portal acad&ecirc;mico, acesse com os dados abaixo para utiliza-lo:<br>
    <b>Usu&aacute;rio / Matr&iacute;cula:</b> <?php echo $mat_aluno;?><br>
    <?php 
	$sql_obs = mysql_query("SELECT * FROM obs_nivel WHERE nivel_obs LIKE '%$turma_nivel%'");
	$dados_obs = mysql_fetch_array($sql_obs);
	$observacao_geral = ($dados_obs["obs"]);
	echo $observacao_geral;?></td>
    </tr>
</table>
<table border="1"  width="100%" class="full_table_list"  cellpadding="0" cellspacing="0"  style="font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
<tr>
<td colspan="5" align="center" bgcolor="#C0C0C0"><b>OCORR&Ecirc;NCIAS - <?php echo $ano_atual;?></b></td>
</tr>
<tr>
<td align="center" bgcolor="#EAEAEA"><b>Data</b></td>
<td align="center" bgcolor="#EAEAEA"><b>Tipo</b></td>
<td align="center" bgcolor="#EAEAEA"><b>Descri&ccedil;&atilde;o</b></td>
</tr>
<?php
$sql_ocorrencias = mysql_query("SELECT * FROM ocorrencias WHERE matricula = $mat_aluno AND data LIKE '%$ano_atual%' AND n_ocorrencia <> 4 AND n_ocorrencia <> 7 ORDER BY data DESC LIMIT 10");
$count_ocorrencias = mysql_num_rows($sql_ocorrencias);
if($count_ocorrencias >=1){
while($dados_oc = mysql_fetch_array($sql_ocorrencias)){
	$n_ocorrencia = $dados_oc["n_ocorrencia"];
	$data_ocorrencia = substr($dados_oc["data"],8,2)."/".substr($dados_oc["data"],5,2)."/".substr($dados_oc["data"],0,4);
	$ocorrencia = $dados_oc["ocorrencia"];
	$sql_tipo_oc = mysql_query("SELECT * FROM tipo_ocorrencia WHERE id = $n_ocorrencia");
	$dados_tipo_oc = mysql_fetch_array($sql_tipo_oc);
	$tipo_ocorrencia = ($dados_tipo_oc["ocorrencia"]);
	echo "
	<tr>
	<td align=\"center\">$data_ocorrencia</td>
	<td><b>$tipo_ocorrencia</b></td>
	<td>$ocorrencia</td>
	
	</tr>";
	
	
}
} else {
	echo "
	<tr>
	<td colspan=\"3\" align=\"center\">N&atilde;o h&aacute; ocorr&ecirc;ncias para o aluno no ano de $ano_atual</td>
	</tr>";
	
}

?>
</table>
<br>
<div style="border: 1px dashed #FF0000;"></div>    
<br>
<table border="1" class="full_table_list"  cellpadding="0" cellspacing="0"  width="100%" style="font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
    <tr>
    <td colspan="3"><b>Curso:<br /><?php echo (strtoupper($turma_nivel)).": ".(strtoupper($turma_curso))." - Ano/M&oacute;dulo ".(strtoupper($turma_modulo));?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $turma_grupo;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $turma_unidade;?> / <?php echo $turma_polo;?> - <?php echo $turma_cod;?></b></td>
    </tr>
    <tr>
    <td colspan="5"><b>Aluno(a): <?php echo $mat_aluno;?> | <?php echo (strtoupper($nome_aluno));?></b></td>
    </tr>
    <tr style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:30px; height:30px;">
    <td colspan="1"><b>Este Canhoto Deve ser Devolvido &agrave; Escola</b></td>
    <td colspan="1"><b>Data: _____/_____/_______</b></td>
    <td colspan="3"><b>Assinatura do Respons&aacute;vel:</b></td>
    </tr>
	</table>

           </div>    
<?php 
if($total_alunos_i < $total_alunos){
	echo "<p class=\"break\">&nbsp;</p>";
	$total_alunos_i +=1;
}
}

?>


  </body>
</html>

