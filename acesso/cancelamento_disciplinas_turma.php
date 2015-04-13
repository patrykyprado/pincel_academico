<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_cancel").height = document.getElementById("cancel").scrollHeight + 35;
     }
    </script>

<?php
include_once("includes/conectar.php");
$id_turma = $_GET["id_turma"];
$id_aluno = $_GET["id_aluno"];
?>
<div id="cancel">
<?php
$sql_completo = "SELECT DISTINCT ct.*, ctd.codigo as turma_disc, d.disciplina, d.anograde,d.ch, ctd.cod_prof, ctd.inicio, ctd.fim
		FROM ced_turma_disc ctd
		INNER JOIN ced_turma ct
		ON ctd.id_turma = ct.id_turma
		INNER JOIN disciplinas d
		ON d.anograde = ct.anograde AND ctd.disciplina = d.cod_disciplina
		WHERE ct.id_turma = $id_turma
		ORDER BY ctd.inicio, ctd.fim, d.disciplina
		";
$sql_disciplinas = mysql_query($sql_completo);
$total_disciplinas = mysql_num_rows($sql_disciplinas);
$sql_turma = mysql_query($sql_completo." LIMIT 1");
$dados_turma = mysql_fetch_array($sql_turma);
if($total_disciplinas >=1) {
	echo "
	Disciplinas da Turma: [".$dados_turma["cod_turma"]."] ".$dados_turma["nivel"].": ".$dados_turma["curso"]." Mód. ".$dados_turma["modulo"]." - ".$dados_turma["unidade"]."/".$dados_turma["polo"]."
<hr>
	<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" width=\"100%\">
		<tr bgcolor=\"#D7D7D7\" align=\"center\">
			<td>Situação</td>
			<td>Disciplina</td>
			<td>Carga Horária</td>
		</tr>
	";	
	while($dados_disciplinas = mysql_fetch_array($sql_disciplinas)){
		$disciplina_nome = $dados_disciplinas["disciplina"];
		$disciplina_situacao = "Em curso";
		$disciplina_ch = $dados_disciplinas["ch"];	
		echo "<tr>
			<td align=\"center\">$disciplina_situacao</td>
			<td>$disciplina_nome</td>
			<td align=\"center\">$disciplina_ch</td>
		</tr>";
	}
}
?>
</div>