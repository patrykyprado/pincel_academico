<?php include '../menu/tabela_ead.php'; 
include('../includes/conectar.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_acao = 2;//$_GET["acao"];

if(isset($_GET["id_post"])){
	$id_post = $_GET["id_post"];
	$sql_post = mysql_query("SELECT * FROM ea_post_forum WHERE id_post = $id_post");
	$dados_post = mysql_fetch_array($sql_post);
	
} else {
	echo "<script language=\"javascript\">
	alert('Erro: O sistema apresentou um erro, entre em contato com o administrador do sistema.');
	window.close();
	window.opener.location.reload();
	</script>";
}

if($get_acao == 2){
	$nome_acao = "Editar comentário - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$comentario = $_POST["descricao"];
$data_post = date("Y-m-d H:i:s");


if(@mysql_query("UPDATE ea_post_forum SET comentario = '$comentario', data_modif='$data_post' WHERE id_post = $id_post")){
	if(mysql_affected_rows() ==1){
		echo "<script language='javascript'>
			window.alert('Comentário atualizado com sucesso!');
			window.close();
			window.opener.location.reload();
			</script>";
	}

}


}//fecha o post Salvar comentário
}//fecha o get acao

?>
<div class="conteudo">

<form method="post" action="#">

<table class="full_table_list">
<tr>
	<td align="center" bgcolor="#6C6C6C" style="color:#FFF"><?php echo $nome_acao.$nome_disciplina;?></td>
</tr>

<tr>
	<td align="center" bgcolor="#C0C0C0"><b>Resposta</b></td>
    </tr>
<tr>
    <td><b>Descri&ccedil;&atilde;o:</b><br /><textarea id="descricao" name="descricao" style="height:100px" class="ckeditor"><?php echo $dados_post["comentario"];?></textarea></td>
</tr>
<tr>
  <td align="center"><input id="Salvar" name="Salvar" type="submit" value="Salvar"></td>
</tr>

</table>

</form>

</div>
  <?php include '../menu/footer.php' ?>
<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
</div>
</body>
</html>

<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check1').checked){  
        document.getElementById('d_ini').disabled = false; 
		document.getElementById('m_ini').disabled = false; 
		document.getElementById('a_ini').disabled = false;
		document.getElementById('hh_ini').disabled = false; 
		document.getElementById('mm_ini').disabled = false; 
		document.getElementById('ss_ini').disabled = false;  
		document.getElementById('d_fin').disabled = false; 
		document.getElementById('m_fin').disabled = false; 
		document.getElementById('a_fin').disabled = false;
		document.getElementById('hh_fin').disabled = false; 
		document.getElementById('mm_fin').disabled = false; 
		document.getElementById('ss_fin').disabled = false;  
    } else {  
        document.getElementById('d_ini').disabled = true; 
		document.getElementById('m_ini').disabled = true; 
		document.getElementById('a_ini').disabled = true;
		document.getElementById('hh_ini').disabled = true; 
		document.getElementById('mm_ini').disabled = true; 
		document.getElementById('ss_ini').disabled = true; 
		document.getElementById('d_fin').disabled = true; 
		document.getElementById('m_fin').disabled = true; 
		document.getElementById('a_fin').disabled = true;
		document.getElementById('hh_fin').disabled = true; 
		document.getElementById('mm_fin').disabled = true; 
		document.getElementById('ss_fin').disabled = true;    
    }  
	
	
	if(document.getElementById('check2').checked){  
        document.getElementById('nota').disabled = false;  
    } else {  
        document.getElementById('nota').disabled = true; 
    } 
	
}  
</script> 