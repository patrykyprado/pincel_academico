<?php 
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');
if(isset($_GET["id_estudo"])){
	$id_estudo = $_GET["id_estudo"];
	$sql_pesq_estudo = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE id_estudo = '$id_estudo'");
	$dados_pesq_estudo = mysql_fetch_array($sql_pesq_estudo);
	if($dados_pesq_estudo["subturma"] > 0){
		$estudo_subturma = $dados_pesq_estudo["subturma"];
		$estudo_criacao = $dados_pesq_estudo["data_criacao"];
		$sql_pesq_estudo_2 =  mysql_query("SELECT * FROM ea_estudo_dirigido WHERE subturma = '$estudo_subturma' AND data_criacao LIKE '$estudo_criacao'");
		while($dados_p_estudo = mysql_fetch_array($sql_pesq_estudo_2)){
			$exc_id_estudo = $dados_p_estudo["id_estudo"];
			$sql_excluir_estudo = mysql_query("DELETE FROM ea_estudo_dirigido WHERE id_estudo = '$exc_id_estudo'");
			$id_estudo_ativ = "E_".$exc_id_estudo;
			$sql_excluir_ativ = mysql_query("DELETE FROM ced_turma_ativ WHERE id_atividade LIKE '$id_estudo_ativ'");			
		}	
		echo "<script language=\"javascript\">
			alert('Atividade excluida com sucesso!');
			window.parent.frames['frame_central_ead'].location.reload();
			window.parent.Shadowbox.close();
			</script>";	
		
	} else {
		$sql_excluir_topico = mysql_query("DELETE FROM ea_estudo_dirigido WHERE id_estudo = '$id_estudo'");
		$id_forum_ativ = "E_".$id_estudo;
		$sql_excluir_ativ = mysql_query("DELETE FROM ced_turma_ativ WHERE id_atividade LIKE '$id_forum_ativ'");
		echo "<script language=\"javascript\">
		alert('Atividade excluida com sucesso!');
		window.close();
		window.opener.location.reload();
		</script>";
	}
	
} else {
	echo "<script language=\"javascript\">
	alert('Erro: O sistema apresentou um erro, entre em contato com o administrador do sistema.');
	window.parent.Shadowbox.close();
	</script>";
}


?>