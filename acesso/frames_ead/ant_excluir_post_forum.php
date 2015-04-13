<?php include '../menu/tabela_ead.php'; 
include('../includes/conectar.php');
if(isset($_GET["id_post"])){
	$id_post = $_GET["id_post"];
	$sql_excluir_post = mysql_query("DELETE FROM ea_post_forum WHERE id_post = $id_post");
	echo "<script language=\"javascript\">
	alert('Comentário excluido com sucesso!');
	window.close();
	window.opener.location.reload();
	</script>";
	
} else {
	echo "<script language=\"javascript\">
	alert('Erro: O sistema apresentou um erro, entre em contato com o administrador do sistema.');
	window.close();
	window.opener.location.reload();
	</script>";
}


?>