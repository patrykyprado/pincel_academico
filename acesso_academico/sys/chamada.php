<?php
include('../includes/conectar.php');
include('../includes/restricao.php');
include('../includes/funcoes.php');
$acao = $_POST["acao"];

switch($acao){
	
	case 'chamada':
		$matricula = $_POST["matricula"];
		$n_aula = $_POST["n_aula"];
		$tipo = $_POST["tipo"];
		$turma_disc = $_POST["turma_disc"];
		$data_aula = $_POST["data_aula"];
		$sql_verificar = mysql_query("SELECT * FROM ced_falta_aluno WHERE matricula = $matricula AND n_aula = $n_aula AND turma_disc = $turma_disc");
		if(mysql_num_rows($sql_verificar)==0){
			mysql_query("INSERT INTO ced_falta_aluno (matricula, turma_disc, data, n_aula, status) VALUES ($matricula,$turma_disc,'$data_aula', $n_aula, '$tipo')");
		} else {
			mysql_query("UPDATE ced_falta_aluno SET status = '$tipo', data='$data_aula' WHERE matricula = $matricula AND n_aula = $n_aula AND turma_disc = $turma_disc");
		}
		
		
	break;
	
	case 'nota':
		$matricula = $_POST["matricula"];
		$ref_ativ = $_POST["ref_ativ"];
		$turma_disc = $_POST["turma_disc"];
		$grupo_ativ = $_POST["grupo_ativ"];
		$nota = $_POST["nova_nota"];
		$id_etapa = $_POST["id_etapa"];
		$nota = str_replace(",",".",$nota);
		$pesquisar = mysql_query("SELECT * FROM ced_notas WHERE  matricula = '".$matricula."' AND ref_ativ = '".$ref_ativ."' AND turma_disc = '".$turma_disc."'");
		$total = mysql_num_rows($pesquisar);
		if($total == 0){
			mysql_query("INSERT INTO ced_notas (codnota, matricula, ref_ativ, turma_disc, grupo, nota, id_etapa) VALUES (NULL, '".$matricula."','".$ref_ativ."', '$turma_disc','".$grupo_ativ."','$nota','$id_etapa');");
		} else {
			mysql_query("UPDATE ced_notas SET nota = '$nota' WHERE  matricula = '".$matricula."' AND ref_ativ = '".$ref_ativ."' AND turma_disc = '".$turma_disc."';");
		}
		
	break;
	
}
?>