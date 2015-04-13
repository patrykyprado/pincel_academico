<?php include '../menu/tabela_ead.php'; 
include('../includes/conectar.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_acao = 1;
$get_estudo = $_GET["id_estudo"];

$sql_estudo = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE id_estudo = $get_estudo");
$dados_estudo = mysql_fetch_array($sql_estudo);
$estudo_criacao = $dados_topico["data_criacao"];

if($get_acao == 1){
	$nome_acao = "Edição de Estudo Dirigido - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$id_estudo = $_POST["id_estudo"];
$titulo = $_POST["titulo"];
$descricao = $_POST["descricao"];
$subturma = $_POST["subturma"];
$data_criacao = date("Y-m-d h:i:s");
$datahora_inicio = $_POST["a_ini"]."-".$_POST["m_ini"]."-".$_POST["d_ini"]." ".$_POST["hh_ini"].":".$_POST["mm_ini"].":".$_POST["ss_ini"];
$datahora_final = $_POST["a_fin"]."-".$_POST["m_fin"]."-".$_POST["d_fin"]." ".$_POST["hh_fin"].":".$_POST["mm_fin"].":".$_POST["ss_fin"];
$nota = str_replace(",",".",$_POST["nota"]);


if($subturma == 0) {
	$id_atividade = "E_".$id_estudo;
	$data_forum = ($datahora_final);
	//PEGA DADOS DAS ATIVIDADES
	$sql_atividade = mysql_query("SELECT * FROM ced_turma_ativ WHERE id_atividade LIKE '$id_atividade'");
	$dados_atividade = mysql_fetch_array($sql_atividade);
	$ref_id = $dados_atividade["ref_id"];
	$nota_anterior = $dados_atividade["valor"];
	mysql_query("UPDATE ea_estudo_dirigido SET data_criacao = '$data_criacao', data_inicio='$datahora_inicio', data_fim='$datahora_final', titulo='$titulo',descricao='$descricao',max_nota='$nota' WHERE id_estudo = '$id_estudo' ");
	if($nota == 0){
		mysql_query("DELETE FROM ced_turma_ativ WHERE ref_id = '$ref_id' ");
	} else {
		mysql_query("UPDATE ced_turma_ativ SET data = '$data_forum', valor='$nota' WHERE ref_id = '$ref_id' ");
		$sql_notas = mysql_query("SELECT cn.codnota, cn.matricula, cta.valor, cn.nota FROM ced_notas cn
INNER JOIN ced_turma_ativ cta
ON cta.ref_id = cn.ref_ativ
 WHERE cta.ref_id = $ref_id");
		while($dados_notas = mysql_fetch_array($sql_notas)){
			$nota_matricula = $dados_notas["matricula"];
			$nota_codigo = $dados_notas["codnota"];
			$nota_atual = $dados_notas["nota"];
			$nota_valor = $dados_notas["valor"];
			$nova_nota = ($nota_atual/$nota_anterior)*$nota;
			mysql_query("UPDATE ced_notas SET nota = '$nova_nota' WHERE codnota = '$nota_codigo'");
		}
		
	}
	
} else {
	
	//SELECT FORUNS DO GRUPO
	$sql_estudos = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE subturma = '$subturma' AND data_criacao LIKE '%$estudo_criacao%'");
	while($dados_estudos = mysql_fetch_array($sql_estudos)){
		$id_estudo = $dados_estudos["id_estudo"];
			
		
		
		$id_atividade = "E_".$id_estudo;
		$data_forum = ($datahora_final);
		//PEGA DADOS DAS ATIVIDADES
		$sql_atividade = mysql_query("SELECT * FROM ced_turma_ativ WHERE id_atividade LIKE '$id_atividade'");
		$dados_atividade = mysql_fetch_array($sql_atividade);
		$ref_id = $dados_atividade["ref_id"];
		$nota_anterior = $dados_atividade["valor"];
		mysql_query("UPDATE ea_estudo_dirigido SET data_criacao = '$data_criacao', data_inicio='$datahora_inicio', data_fim='$datahora_final', titulo='$titulo',descricao='$descricao',max_nota='$nota' WHERE id_estudo = '$id_estudo' ");
		if($nota == 0){
			mysql_query("DELETE FROM ced_turma_ativ WHERE ref_id = '$ref_id' ");
		} else {
			mysql_query("UPDATE ced_turma_ativ SET data = '$data_forum', valor='$nota' WHERE ref_id = '$ref_id' ");
			$sql_notas = mysql_query("SELECT cn.codnota, cn.matricula, cta.valor, cn.nota FROM ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	 WHERE cta.ref_id = $ref_id");
			while($dados_notas = mysql_fetch_array($sql_notas)){
				$nota_matricula = $dados_notas["matricula"];
				$nota_codigo = $dados_notas["codnota"];
				$nota_atual = $dados_notas["nota"];
				$nota_valor = $dados_notas["valor"];
				$nova_nota = ($nota_atual/$nota_anterior)*$nota;
				mysql_query("UPDATE ced_notas SET nota = '$nova_nota' WHERE codnota = '$nota_codigo'");
			}
			
		}
	}
	
}
echo "<script language=\"javascript\">
alert('Tópico atualizado com sucesso!');
window.close();
window.opener.location.reload();
</script>";

}//fecha o post Salvar
}//fecha o get acao


?>

<div class="conteudo">
  <form method="post" action="#">
    <input name="id_estudo" id="id_estudo" type="hidden"  value="<?php echo $get_estudo;?>"/>
    <input name="subturma" id="subturma" type="hidden"  value="<?php echo ($dados_topico["subturma"]);?>"/>
    <table class="full_table_list">
      <tr>
        <td colspan="4" align="center" bgcolor="#6C6C6C" style="color:#FFF"><?php echo $nome_acao.$nome_disciplina;?></td>
      </tr>
      <tr>
        <td colspan="4" align="center"></td>
      <tr>
        <td align="right" colspan="2"><b>Data de In&iacute;cio: </b></td>
        <td colspan="2"><select name="d_ini" style="width:auto;" id="d_ini" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_inicio"],8,2);?>"><?php echo substr($dados_estudo["data_inicio"],8,2);?></option>
            <?php $dia = 1;
while($dia<=31){
	$dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
   echo "<option value='$dia'>$dia</option>";
   $dia++;
}?>
          </select>
          <select  name="m_ini" style="width:auto;" id="m_ini" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_inicio"],5,2);?>"><?php echo substr($dados_estudo["data_inicio"],5,2);?></option>
            <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
          </select>
          <select name="a_ini" style="width:auto;" id="a_ini" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_inicio"],0,4);?>"><?php echo substr($dados_estudo["data_inicio"],0,4);?></option>
            <?php $ano = date('Y');
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
          </select></td>
      </tr>
      <tr>
        <td align="right" colspan="2"><b>Hor&aacute;rio de In&iacute;cio: </b></td>
        <td colspan="2"><select  name="hh_ini" style="width:auto;" id="hh_ini" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_inicio"],11,2);?>"><?php echo substr($dados_estudo["data_inicio"],11,2);?></option>
            <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
          </select>
          <select  name="mm_ini" style="width:auto;" id="mm_ini" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_inicio"],14,2);?>"><?php echo substr($dados_estudo["data_inicio"],14,2);?></option>
            <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
          </select>
          <select  name="ss_ini" style="width:auto;" id="ss_ini" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_inicio"],17,2);?>"><?php echo substr($dados_estudo["data_inicio"],17,2);?></option>
            <?php $ss = 0;
while($ss<=59){
	$ss = str_pad($ss, 2, "0", STR_PAD_LEFT);
   echo "<option value='$ss'>$ss</option>";
   $ss++;
}?>
          </select></td>
      </tr>
      <tr>
        <td align="right" colspan="2"><b>Data Final: </b></td>
        <td colspan="2"><select  name="d_fin" style="width:auto;" id="d_fin" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_fim"],8,2);?>"><?php echo substr($dados_estudo["data_fim"],8,2);?></option>
            <?php $dia = 1;
while($dia<=31){
	$dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
   echo "<option value='$dia'>$dia</option>";
   $dia++;
}?>
          </select>
          <select  name="m_fin" style="width:auto;" id="m_fin" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_fim"],5,2);?>"><?php echo substr($dados_estudo["data_fim"],5,2);?></option>
            <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
          </select>
          <select name="a_fin" style="width:auto;" id="a_fin" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_fim"],0,4);?>"><?php echo substr($dados_estudo["data_fim"],0,4);?></option>
            <?php $ano = date('Y');
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
          </select></td>
      </tr>
      <tr>
        <td align="right" colspan="2"><b>Hor&aacute;rio de T&eacute;rmino: </b></td>
        <td colspan="2"><select  name="hh_fin" style="width:auto;" id="hh_fin" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_fim"],11,2);?>"><?php echo substr($dados_estudo["data_fim"],11,2);?></option>
            <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
          </select>
          <select name="mm_fin" style="width:auto;" id="mm_fin" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_fim"],14,2);?>"><?php echo substr($dados_estudo["data_fim"],14,2);?></option>
            <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
          </select>
          <select name="ss_fin" style="width:auto;" id="ss_fin" onkeypress="return arrumaEnter(this, event)">
            <option value="<?php echo substr($dados_estudo["data_fim"],17,2);?>"><?php echo substr($dados_estudo["data_fim"],17,2);?></option>
            <?php $ss = 0;
while($ss<=59){
	$ss = str_pad($ss, 2, "0", STR_PAD_LEFT);
   echo "<option value='$ss'>$ss</option>";
   $ss++;
}?>
          </select></td>
      </tr>
      <tr>
        <td align="right" colspan="2"><font size="+1"><b>T&iacute;tulo:</b></font></td>
        <td colspan="2"><input name="titulo" type="text" id="titulo" style="width:400px;" value="<?php echo $dados_estudo["titulo"];?>" /></td>
      </tr>
      <tr>
        <td colspan="4"><b>Descrição:</b><br />
          <textarea id="descricao" name="descricao" style="height:100px" class="ckeditor"><?php echo $dados_estudo["descricao"];?></textarea></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><b>Nota:</b></td>
        <td colspan="2"><b>
          <input id="nota" name="nota" type="text" value="<?php echo ($dados_estudo["max_nota"]);?>">
          </b></td>
      </tr>
      <tr>
        <td colspan="4" align="center"><input id="Salvar" name="Salvar" type="submit" value="Salvar"></td>
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