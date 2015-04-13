<?php
/* Carrega a classe DOMPdf */
require_once("../dompdf/dompdf_config.inc.php");
include('includes/conectar.php');
include('includes/funcoes.php');

$id_turma = $_GET["id"];

$sql_turma = mysql_query("SELECT DISTINCT alu.codigo, alu.nome FROM ced_turma_aluno cta
INNER JOIN alunos alu
ON cta.matricula = alu.codigo
WHERE cta.id_turma = $id_turma");
 
 /* Cria a instância */
$dompdf = new DOMPDF();
 
$html_arquivo = "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
	<tr bgcolor=\"#DCDCDC\">
    	<td width=\"5%\" align=\"center\"><b>Matrícula</b></td>
        <td width=\"55%\" align=\"center\"><b>Nome</b></td>
        <td width=\"40%\" align=\"center\"><b>Assinatura</b></td>
    </tr>"; 
while($dados_alunos = mysql_fetch_array($sql_turma)){
		$matricula = $dados_alunos["codigo"];	
		$nome = format_curso($dados_alunos["nome"]);	
		$html_arquivo.="
		<tr>
    	<td align=\"center\"><b>$matricula</b></td>
        <td>$nome</td>
        <td></td>
    </tr>";
	}
$html_arquivo .= '</table>';
 
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