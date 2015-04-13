<?php include '../menu/tabela_ead.php'; 
include('../includes/conectar.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_turma_disc= $_GET["turma_disc"];
$get_matricula = $_GET["matricula"];
$get_estudo_id_envio = $_GET["id_envio"];
$get_ref = $_GET["ref_id"];
$get_codnota = $_GET["id"];

//VERIFICA COMENTARIO ANTERIOR
$sql_comentario = mysql_query("SELECT * FROM ea_estudo_envio WHERE id_envio = $get_estudo_id_envio");
if(mysql_num_rows($sql_comentario)>=1){
	$dados_comentario = mysql_fetch_array($sql_comentario);
	$comentario = $dados_comentario["comentario"];
} else {
	$comentario = "";	
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$comentario = $_POST["comentario"];
	//ATUALIZA COMENTÁRIO
    mysql_query("UPDATE ea_estudo_envio SET comentario = '$comentario' WHERE id_envio = $get_estudo_id_envio");
	
	//SALVA NOTA
	if($_POST["nota"] <= $_POST["max_nota"]){
		$nota_atual = str_replace(",",".",$_POST["nota"]);
		if($_POST["ref_update"] == 1){
			mysql_query("UPDATE ced_notas SET nota = '$nota_atual' WHERE matricula = '$get_matricula' AND codnota = '$get_codnota'");
			echo "<script language=\"javascript\">
		alert('Nota atualizada com sucesso.');
		window.opener.location.reload();
		window.close();
		</script>";	
		} else {
			mysql_query("INSERT INTO ced_notas (codnota, matricula, ref_ativ, turma_disc, grupo, nota) VALUES 
			(NULL, '$get_matricula', '$get_ref', '$get_turma_disc','B','$nota_atual')");
			echo "<script language=\"javascript\">
		alert('Nota inserida com sucesso.');
		window.opener.location.reload();
		window.close();
		</script>";	
		}
		
	} else {
		echo "<script language=\"javascript\">
		alert('Você digitou uma nota maior que o máximo da atividade.');
		history.back();
		</script>";	
		return;
	}


}

?>
<div class="conteudo">

<form method="post" action="#">
<table class="full_table_list" width="100%" align="center">
<tr>
	<td align="center"><b>Nome</b></td>
    <td align="center"><b>Nota</b></td>
</tr>
<?php
$get_matricula = $_GET["matricula"];
$get_codnota = $_GET["id"];
$sql_nota = mysql_query("SELECT a.nome, cta.valor, cn.nota, cn.codnota FROM ced_turma_ativ cta
INNER JOIN ced_notas cn
ON cn.ref_ativ = cta.ref_id
INNER JOIN alunos a
ON cn.matricula = a.codigo
WHERE cn.matricula LIKE '$get_matricula' AND codnota LIKE '$get_codnota' ");
if(mysql_num_rows($sql_nota)==0){
	$nota = 0;
	$sql_atividade = mysql_query("SELECT * FROM ced_turma_ativ WHERE ref_id = $get_ref");
	$dados_atividade = mysql_fetch_array($sql_atividade);
	$max_nota = $dados_atividade["valor"];
	$ref_update = "0";
	
} else {
	$dados_nota = mysql_fetch_array($sql_nota);
	$nota = $dados_nota["nota"];
	$max_nota = $dados_nota["valor"];
	$ref_update = "1";
}

$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = '$get_matricula'");
$dados_aluno = mysql_fetch_array($sql_aluno);

?>
<tr>
	<td align="center"><b><?php echo $dados_aluno["nome"];?></b></td>
    <td align="center"><b><input type="text" name="nota" id="nota" value="<?php echo $nota;?>"/>
    <input type="hidden" name="max_nota" id="max_nota" value="<?php echo $max_nota;?>"/>
    <input type="hidden" name="ref_update" id="ref_update" value="<?php echo $ref_update;?>"/> | <?php echo format_valor($max_nota);?></b></td>
</tr>
<tr>
	<td bgcolor="#E4E4E4" colspan="2" align="center">Coment&aacute;rio</td>
</tr>
<tr>
	<td colspan="2" align="center"><textarea id="comentario" name="comentario" style="height:100px" class="ckeditor"><?php echo $comentario?></textarea></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" value="Salvar" /></td>
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