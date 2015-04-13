<?php 
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');
if(isset($_GET["id_forum"])){
	$id_forum = $_GET["id_forum"];
	$sql_pesq_forum = mysql_query("SELECT * FROM ea_forum WHERE id_forum = '$id_forum'");
	$dados_pesq_forum = mysql_fetch_array($sql_pesq_forum);
	if($dados_pesq_forum["subturma"] > 0){
		$forum_subturma = $dados_pesq_forum["subturma"];
		$forum_criacao = $dados_pesq_forum["data_criacao"];
		$sql_pesq_forum_2 =  mysql_query("SELECT * FROM ea_forum WHERE subturma = '$forum_subturma' AND data_criacao LIKE '$forum_criacao'");
		while($dados_p_forum = mysql_fetch_array($sql_pesq_forum_2)){
			$exc_id_forum = $dados_p_forum["id_forum"];
			$sql_excluir_topico = mysql_query("DELETE FROM ea_forum WHERE id_forum = '$exc_id_forum'");
			$id_forum_ativ = "F_".$exc_id_forum;
			$sql_excluir_ativ = mysql_query("DELETE FROM ced_turma_ativ WHERE id_atividade LIKE '$id_forum_ativ'");			
		}	
		echo "<script language=\"javascript\">
			alert('Tópico excluido com sucesso!');
			window.parent.frames['frame_central_ead'].location.reload();
			window.parent.Shadowbox.close();
			</script>";	
		
	} else {
		$sql_excluir_topico = mysql_query("DELETE FROM ea_forum WHERE id_forum = '$id_forum'");
		$id_forum_ativ = "F_".$id_forum;
		$sql_excluir_ativ = mysql_query("DELETE FROM ced_turma_ativ WHERE id_forum = '$id_forum_ativ'");
		echo "<script language=\"javascript\">
		alert('Tópico excluido com sucesso!');
		window.parent.frames['frame_central_ead'].location.reload();
		window.parent.Shadowbox.close();
		</script>";
	}
	
} else {
	echo "<script language=\"javascript\">
	alert('Erro: O sistema apresentou um erro, entre em contato com o administrador do sistema.');
	window.close();
	window.opener.location.reload();
	</script>";
}


?>