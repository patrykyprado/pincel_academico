<?php include '../menu/tabela_ead.php'; 
include('../includes/conectar.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_acao = 1;//$_GET["acao"];



if($get_acao == 1){
	$nome_acao = "Responder Fórum - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$id_resposta = $_POST["resposta"];
$id_forum = $_GET["id"];
$comentario = $_POST["descricao"];
$data_post = date("Y-m-d H:i:s");
//
$verificar = "<!--[if gte mso 9]";
if(strpos($comentario,$verificar) === true){
		mysql_query("INSERT INTO logs (id_log, usuario, data_hora, cod_acao, acao, ip_usuario) VALUES (NULL, '$user_usuario', '$data_post', '10', 'Tentou enviar um código XML malicioso no fórum $id_forum', '00')");
		echo "<script language='javascript'>
			window.alert('O sistema identificou que você tentando enviar um conteúdo malicioso, digite-o e tente envia-lo novamente.');
			history.back();
			</script>";
} else {
if(@mysql_query("INSERT INTO ea_post_forum (id_post, id_forum,post_resposta, matricula, data_modif, comentario, nota_comentario) VALUES (NULL, '$id_forum','$id_resposta', '$user_usuario','$data_post', '$comentario',0)")){
	if(mysql_affected_rows() ==1){
		echo "<script language='javascript'>
			window.alert('Resposta salva com sucesso!');
			window.close();
			window.opener.location.reload();
			</script>";
	}

}
}

}//fecha o post Salvar
	
	
	
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
<tr><input name="resposta" type="hidden" value="<?php echo $_GET["user_resposta"]?>" />
    <td><b>Descrição:</b><br /><textarea id="descricao" name="descricao" style="height:100px" class="ckeditor"></textarea></td>
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