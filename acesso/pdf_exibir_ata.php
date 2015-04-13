<?php
/* Carrega a classe DOMPdf */
require_once("../dompdf/dompdf_config.inc.php");
include('includes/conectar.php');
include('includes/funcoes.php');
$html_arquivo = "";

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


while($dados_base = mysql_fetch_array($sql_base)){
	$nome_base = $dados_base["base_ensino"];
	$id_base = $dados_base["id_base"];
	$sql2 = mysql_query("SELECT ctd.* FROM ced_turma_disc ctd
	INNER JOIN ced_turma ct
	ON ct.id_turma = ctd.id_turma
	INNER JOIN disciplinas d
	ON ctd.disciplina = d.cod_disciplina AND ct.anograde = d.anograde
	WHERE d.base_ensino = $id_base AND ct.id_turma = $id_turma
	ORDER BY d.disciplina");
	$count2 = mysql_num_rows($sql2);
	
	//SELECIONA OS ALUNOS
	$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
	INNER JOIN ced_turma_aluno cta
	ON vad.id_turma = cta.id_turma WHERE vad.id_turma = $id_turma 
	AND vad.matricula
	IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
	ORDER BY vad.nome");
	
	$count = mysql_num_rows($sql);
	$contar_resultado = 0;
//monta o cabecalho da pagina.
$html_arquivo .= "
<div class=\"paginar\">
<table width=\"100%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" class=\"full_table_list\" style=\"font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px\">

    
    <tr class=\"diario_frequencia_header\">
    <th colspan=\"2\"><img src=\"images/logo-cedtec.png\" /></th>
    <th align=\"center\" colspan=\"$count2\">Ata de Resultados $comp_nome_ata - $nome_etapa</th>
    </tr>
    
    <tr class=\"diario_frequencia_header\">
    <td colspan=\"2\"><b>Curso:<br />".strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Ano/Módulo ".strtoupper($modulo_turma)."</b></td>
    <td><b>Ano/Semestre:<br />$grupo_turma</b></td>
    <td><b>Unidade / Polo - Turma<br />$unidade_turma / $polo_turma - $cod_turma</b></td>
    </tr>
	</table>";
	
$html_arquivo .= "<table width=\"100%\"  cellpadding=\"0\" cellspacing=\"0\" border=\"1\" style=\"color:#00000\">
    <tr style=\"line-height:20px\">
    	<td class=\"diario_frequencia_header\" colspan=\"2\"><div align=\"center\" class=\"\"><strong></strong></div></td>
        <td class=\"diario_frequencia_header\" colspan=\"60\"><div align=\"center\"><strong>$nome_base</strong></div></td>
        </tr>
        
    <tr style=\"line-height:10px\">
    	<td class=\"diario_frequencia_header\" rowspan=\"2\"><div align=\"center\"><strong>N&ordm;</strong></div></td>
        <td class=\"diario_frequencia_header\" rowspan=\"2\" width=\"20%\"><div align=\"center\"><strong>Nome</strong></div></td>";
		
if ($count2 == 0) {

} else {
	
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados2 = mysql_fetch_array($sql2)) {
        // enquanto houverem resultados...
		$cod_tdisc = $dados2["codigo"];
		$cod_disciplina = $dados2["disciplina"];
		$ano_grade = $dados2["ano_grade"];
		$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina ='$cod_disciplina' AND anograde= '$ano_grade' AND base_ensino = $id_base ORDER BY disciplina");
		$dados_disc = mysql_fetch_array($sql_disc);
		$nome_disciplina = $dados_disc["disciplina"];
		$ch_disciplina = $dados_disc["ch"];
        $html_arquivo .= "
		<td colspan=\"2\" valign=\"middle\" class=\"diario_frequencia_header\" width=\"70px\"><div align=\"center\" class=\"diario_frequencia_header\"><strong>$nome_disciplina</strong></div><br>
		
		</td>

		\n";
    }
$html_arquivo .= "<td colspan=\"2\" style=\"line-height:10px\" width=\"70px\"><div align=\"center\" class=\"diario_frequencia_header\"><strong>Resultado</strong></div>
		
		</td>";
	$contador = $count2;
	$html_arquivo . "
	
	</td><tr style=\"line-height:10px\">";
	 while ($contador >=1) {
		 $html_arquivo ."
  <td class=\"diario_frequencia_header\" align=\"center\" bgcolor=\"#FFFAFA\"><b>Faltas</b></td>
  <td class=\"diario_frequencia_header\" align=\"center\" bgcolor=\"#F5F5F5\"><b>Nota</b></td>";
  $contador -=1;
  }
  $html_arquivo .= "<td colspan=\"2\" style=\"line-height:10px\" width=\"70px\"><div align=\"center\" class=\"diario_frequencia_header\"><strong>--</strong></div>
		
		</td></tr>";
}

	$i = 0;

    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		//verifica cancelados
		$sql_cancelados = mysql_query("SELECT toc.nome, oco.data FROM ocorrencias oco
	INNER JOIN tipo_ocorrencia toc
	ON oco.n_ocorrencia = toc.id
	WHERE oco.n_ocorrencia = 1 AND oco.matricula = $codigo AND oco.id_turma = $id_turma LIMIT 1");
		if(mysql_num_rows($sql_cancelados)>=1){
			$dados_cancelados = mysql_fetch_array($sql_cancelados);
			$nome_ocorrencia = $dados_cancelados["nome"];
			$data_ocorrencia = format_data($dados_cancelados["data"]);
			$cancelado_observacao .= "Aluno(a) $nome, nº de matricula $codigo foi $nome_ocorrencia em $data_ocorrencia.<br>";
		}
		
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
       $html_arquivo .= "
	<tr style=\"line-height:10px\">
		<td class=\"diario_frequencia_corpo\" style=\"font-size:07px;\"><b><center>$exib_i</b></center></td>
		<td class=\"diario_frequencia_corpo\" style=\"font-size:07px;\"><b>$nome</b></td>
		
		
		\n";
		
		//verifica ocorrencias	
		$sql_cancel = mysql_query("SELECT * FROM ocorrencias WHERE matricula = $codigo AND id_turma = $id_turma AND (n_ocorrencia = 1 OR n_ocorrencia = 2 OR n_ocorrencia = 10) LIMIT 1");
		$count_cancel = mysql_num_rows($sql_cancel);
	
		if($count_cancel >=1){
			$dados_cancel = mysql_fetch_array($sql_cancel);
			$data_cancel = substr($dados_cancel["data"],8,2)."/".substr($dados_cancel["data"],5,2)."/".substr($dados_cancel["data"],0,4);
			$id_ocorrencia = $dados_cancel["n_ocorrencia"];
			$sql_ocorrencia = mysql_query("SELECT * FROM tipo_ocorrencia WHERE id = $id_ocorrencia");
			$dados_ocorrencia = mysql_fetch_array($sql_ocorrencia);
			$nome_ocorrencia = $dados_ocorrencia["nome"];
			$contador2 = $count2*2 +1;
			$html_arquivo .= "<td colspan=\"$contador2\" class=\"diario_frequencia_corpo\" align=\"center\">$nome_ocorrencia em $data_cancel</td>";
		} else {
		//PEGA OS DADOS DAS DISCIPLINAS
		$sql3 = mysql_query("SELECT ctd.* FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON ctd.disciplina = d.cod_disciplina AND ct.anograde = d.anograde
WHERE d.base_ensino = $id_base AND ct.id_turma = $id_turma
ORDER BY d.disciplina");
		while ($dados3 = mysql_fetch_array($sql3)) {
        // enquanto houverem resultados...
			$cod_tdisc2 = $dados3["codigo"];
			$cod_disciplina2 = $dados3["disciplina"];
			$ano_grade2 = $dados3["ano_grade"];
			//PEGA AS NOTAS DA DISCIPLINA
			$pesq_nota = mysql_query("
SELECT sum(t1.nota) as notafinal FROM 
					(SELECT DISTINCT cn.matricula, cn.ref_ativ, cn.turma_disc, cn.grupo, cn.nota FROM 
ced_notas cn
INNER JOIN ced_turma_ativ cta
ON cta.ref_id = cn.ref_ativ
INNER JOIN ced_desc_nota cdn
ON cdn.codigo = cta.cod_ativ
WHERE cn.matricula = $codigo AND cn.turma_disc = $cod_tdisc2 AND cdn.subgrupo <> 'C'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
AND cta.id_etapa = $etapa) t1
			");
			$dados_nota2 = mysql_fetch_array($pesq_nota);
			$nota1 = $dados_nota2["notafinal"];
			if($nota1 < $min_nota){
				$pesq_rec = mysql_query("SELECT SUM(nota) as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $cod_tdisc2 AND grupo = 'C'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ  WHERE id_etapa = $etapa)");
				$dados_rec = mysql_fetch_array($pesq_rec);
				$nota_final1 = $dados_rec["notafinal"];
			} else {
				$nota_final1 = $nota1;
			}
			
			if($nota_final1 <= $nota1){//verifica se a nota da recuperação é menor que soma das notas
				$nota_final1 = $nota1;
			}
			
			$nota_final = number_format($nota_final1, 2, ',', '');
			
			
			
			//PEGA AS FALTAS
			$sql_falta = mysql_query("SELECT COUNT(DISTINCT n_aula) as falta_total FROM ced_falta_aluno WHERE matricula = '$codigo' AND turma_disc = '$cod_tdisc2' AND status LIKE 'F' AND data IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$cod_tdisc2');");
			$dados_falta = mysql_fetch_array($sql_falta);
			$falta         = $dados_falta["falta_total"];
			
			if($nota_final1 >=$etapa_min_nota&&$falta<=(($min_freq*$ch_disciplina)/100)){
				$contar_resultado +=1;	
			} else {
				$contar_resultado +=0;	
			}
		
			$html_arquivo .= "<td class=\"diario_frequencia_corpo\" align=\"center\" bgcolor=\"#FFFAFA\">$falta</td>
			
			<td class=\"diario_frequencia_corpo\" align=\"center\" bgcolor=\"#F5F5F5\">$nota_final</td>";
		}
		// exibi resultado final
		if($contar_resultado >= $count2&&$etapa != 0){
			$exibir_resultado = "<div id=\"resultado\">Aprovado</div>";
		} else {
			$exibir_resultado = "<div id=\"resultado\">Recuperação</div>";
		}
			
		
		$html_arquivo .= "<td class=\"diario_frequencia_corpo\" align=\"center\" bgcolor=\"#F5F5F5\" colspan=\"2\">$exibir_resultado</td>";
		$contar_resultado = 0;
		}
	}
$html_arquivo .= "</table>
</div>
";

}
 /* Cria a instância */
$dompdf = new DOMPDF();
$dompdf->set_paper('letter','landscape');
/* Carrega seu HTML */
$dompdf->load_html($html_arquivo);
 
/* Renderiza */
$dompdf->render();

$nome_arquivo = date("d-m-Y His");
 
/* Exibe */
$dompdf->stream(
    $nome_arquivo, /* Nome do arquivo de saída */
    array(
        "Attachment" => true /* Para download, altere para true */
    )
);
?>