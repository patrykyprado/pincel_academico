<head>
<!-- CSS DE IMPRESSÃO -->
    <link href="../acesso/css/imprimir.css" media="print" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../acesso/css/style.css" media="screen" rel="stylesheet">
     
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
 <?php 
 include('../acesso/includes/conectar.php');
 include('includes/restricao.php');
 include('../acesso/includes/funcoes.php');


$turma_disc = $_GET["td"];

//PROTEÇÃO PARA SOMENTE PROFESSOR VISUALIZAR
if(isset($turma_disc)){
	$sql_bloq_prof = mysql_query("SELECT * FROM ced_turma_disc WHERE cod_prof = $user_usuario AND codigo = '$turma_disc'");
	if(mysql_num_rows($sql_bloq_prof)==0){
		echo "<script language=\"javascript\">
			alert('ACESSO NÃO PERMITIDO!');
			location.href='http://cedtec.com.br/pincelatomico';
		</script>";
	}
}


$sql_td = mysql_query("SELECT id_turma FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_td = mysql_fetch_array($sql_td);
$id_turma = $dados_td["id_turma"];

$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_disc 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
 


?>
<script language="javascript" src="../acesso/js/jquery_chamada.js"></script>
<script language="javascript" src="../acesso/js/funcoes.js"></script>
  <body>
<div style="background:#62944B; color:#FFFFFF; font-weight:bold;"><center>Aten&ccedil;&atilde;o: Ao digitar a nota a mesma ser&aacute; atualizada no di&aacute;rio online e registros acad&ecirc;micos.</center></div>
<form id="form1" name="form1" method="post" >

  <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center" class="diario_frequencia_tabela">
        
    <tr class="diario_frequencia_header" bgcolor="#E3E3E3">
    <td><b>NOME</b></td>
   
    <?php
	//PEGA ATIVIDADES LANÇADAS PARA A TURMA DISCIPLINA
	$pesquisar = mysql_query("SELECT ref_id,cod_ativ, id_etapa, data, descricao  FROM ced_turma_ativ WHERE cod_turma_d = $turma_disc");
	$total = mysql_num_rows($pesquisar);
		while($dados_ativ = mysql_fetch_array($pesquisar)){
			$ref_id = $dados_ativ["ref_id"];
			$cod_ativ = $dados_ativ["cod_ativ"];
			$etapa_ativ = $dados_ativ["id_etapa"];
			//pesquisa o nome da etapa
			$sql_etapa = mysql_query("SELECT etapa FROM ced_etapas WHERE id_etapa = $etapa_ativ");
			$dados_etapa = mysql_fetch_array($sql_etapa);
			$nome_etapa = $dados_etapa["etapa"];
			$desc_ativ = $dados_ativ["descricao"];
			$data_ativ = substr($dados_ativ["data"],8,2)."/".substr($dados_ativ["data"],5,2)."/".substr($dados_ativ["data"],0,4);
			$nome_ativ = mysql_query("SELECT atividade FROM ced_desc_nota WHERE  codigo = $cod_ativ;");
			$dados_atividade = mysql_fetch_array($nome_ativ);
			$nome_atividade = $dados_atividade["atividade"];
			echo "<td><a href=\"editar_atividade.php?id_atividade=$ref_id&turma=$turma_disc\" title=\"$desc_ativ\"><center><b>$nome_atividade<br>($data_ativ)<br>($nome_etapa)</b></a><br><font-size='-2'><a href=\"excluir_atividade.php?id=$ref_id\">[EXCLUIR]</font></a></center></td>";
			}
	
	?>
    </tr>
<?php 
//PEGA MATRÍCULA E NOME DO ALUNO
	while($dados = mysql_fetch_array($sql)){
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		
			
		
?>


<?php
			
		echo "<tr class=\"diario_frequencia_corpo\"><td>$nome</td>";
		//verifica cancelados
			$sql_cancelados = mysql_query("SELECT toc.nome, oco.data FROM ocorrencias oco
INNER JOIN tipo_ocorrencia toc
ON oco.n_ocorrencia = toc.id
WHERE oco.n_ocorrencia = 1 AND oco.matricula = $codigo AND oco.id_turma = $id_turma LIMIT 1");
			if(mysql_num_rows($sql_cancelados)>=1){
				$dados_cancelados = mysql_fetch_array($sql_cancelados);
				$nome_ocorrencia = $dados_cancelados["nome"];
				$data_ocorrencia = format_data($dados_cancelados["data"]);
				echo "<td align=\"center\" colspan=\"$total\">$nome_ocorrencia em $data_ocorrencia.</td></tr>";
			} else {
		
		//PEGA CODIGO DE ATIVIDADES
		$pesquisar = mysql_query("SELECT ref_id, cod_ativ, valor, grupo_ativ, data, id_etapa FROM ced_turma_ativ WHERE  cod_turma_d = $turma_disc;");
		$total = mysql_num_rows($pesquisar);
		while($dados_ativ = mysql_fetch_array($pesquisar)){
			$ref_id = $dados_ativ["ref_id"];
			$cod_ativ = $dados_ativ["cod_ativ"];
			$valor_ativ = $dados_ativ["valor"];
			$grupo_ativ = $dados_ativ["grupo_ativ"];
			$id_etapa = $dados_ativ["id_etapa"];
			$data_ativ = substr($dados_ativ["data"],8,2)."/".substr($dados_ativ["data"],5,2)."/".substr($dados_ativ["data"],0,4);
			$nome_ativ = mysql_query("SELECT atividade FROM ced_desc_nota WHERE  codigo = $cod_ativ;");
			$dados_atividade = mysql_fetch_array($nome_ativ);
			$nome_atividade = $dados_atividade["atividade"];
			//pesquisa notas anteriores
			$pesq_nota = mysql_query("SELECT nota FROM ced_notas WHERE matricula = $codigo AND ref_ativ = $ref_id AND turma_disc = $turma_disc");
			$contar_nota = mysql_num_rows($pesq_nota);
			if($contar_nota == 0){
				$nota_aluno = 0;
			} else {
				$dados_nota = mysql_fetch_array($pesq_nota);
				$nota_aluno = $dados_nota["nota"];
			}
			
			echo "<td align=\"center\"><input type=\"text\" id_etapa=\"$id_etapa\" name=\"nota\" id=\"nota\" matricula=\"$codigo\" ref_ativ=\"$ref_id\" turma_disc=\"$turma_disc\" grupoativ=\"$grupo_ativ\" maxnota=\"$valor_ativ\" value=\"$nota_aluno\" style=\"width:50px\" /> <b> | <font color=\"red\">$valor_ativ</font></b>
				
				</td>";
			}
		}
		
		
		
		"</tr>";
		
		
		
	}
	



?>

</table>
</form>
</body>
