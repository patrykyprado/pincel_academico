<?php
include('../includes/conectar.php');
include('../menu/tabela_ead.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_acao = $_GET["acao"];


if($get_acao == 1){
	$nome_acao = "Cadastro de Atividade - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$coddisc = $_SESSION["coddisc"];
$turma_disc = $_SESSION["turma_disc"];
$anograde = $_SESSION["anograde"];
$tipo_ativ = $_POST["tipo_ativ"];
$ordem_ativ = $_POST["ordem"];
$descricao_ativ = $_POST["descricao"];
$conteudo_ativ = $_POST["conteudo"];
$data_criacao = date("Y-m-d h:i:s");
if(isset($_POST["check1"])){
	$datahora_inicio = $_POST["a_ini"]."-".$_POST["m_ini"]."-".$_POST["d_ini"]." ".$_POST["hh_ini"].":".$_POST["mm_ini"].":".$_POST["ss_ini"];
	$datahora_final = $_POST["a_fin"]."-".$_POST["m_fin"]."-".$_POST["d_fin"]." ".$_POST["hh_fin"].":".$_POST["mm_fin"].":".$_POST["ss_fin"];
} else {
	$datahora_inicio = "0000-00-00 00:00:00";
	$datahora_final = "0000-00-00 00:00:00";
}
if(isset($_POST["check2"])){
	$link = $_POST["link"];
} else {
	$link = "#";
}

$sql_max_ativ = mysql_query("SELECT max(ordem_ativ) as maximo FROM ea_ativ WHERE cod_disc LIKE '$coddisc' AND ano_grade LIKE '$anograde'");
$dados_max_ativ = mysql_fetch_array($sql_max_ativ);
$max_ativ = $dados_max_ativ["maximo"] +1;

if(@mysql_query("INSERT INTO ea_ativ (cod_ativ,cod_disc,ano_grade,tipo,data_criacao,descricao,conteudo,link,ordem,ordem_ativ) VALUES (NULL,'$coddisc','$anograde','$tipo_ativ','$data_criacao','$descricao_ativ','$conteudo_ativ','$link','$ordem_ativ','$max_ativ')")){
	if(mysql_affected_rows() ==1){
		echo "<script language='javascript'>
			window.alert('Atividade inserida com sucesso!');
			window.close();
			window.opener.location.reload();
			</script>";
	}

}


}//fecha o post Salvar
	
	
	
}//fecha o get acao


?>
<div class="conteudo">

<form method="post" action="#">
<input name="cod_disc" id="cod_disc" type="hidden"  value="<?php echo $_SESSION["coddisc"] ;?>"/>
    <input name="turma_disc" id="turma_disc" type="hidden"  value="<?php echo $_SESSION["turma_disc"] ;?>"/>
    <input name="anograde" id="anograde" type="hidden"  value="<?php echo $_SESSION["anograde"] ;?>"/>

<table class="full_table_list" width="100%">
<tr>
	<td colspan="4" align="center" bgcolor="#6C6C6C" style="color:#FFF"><?php echo $nome_acao.$nome_disciplina;?></td>
</tr>
<tr>
    <td colspan="4" align="center"><b>Atividade: </b>
     <select name="tipo_ativ" style="width:auto;" id="tipo_ativ" onkeypress="return arrumaEnter(this, event)">
      <?php
include("../menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM ea_tipo_ativ ORDER BY tipo";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['cod_tipo'] . "'>" . ($row['tipo']) . "</option>";
}
?>
    </select> | <b>Local:</b> <select name="ordem" style="width:auto;" id="ordem" onkeypress="return arrumaEnter(this, event)">
      <option value="1">Topo</option>
      <option value="2" selected >Corpo</option>
    </select></td>
    
</tr>
<tr>
    <td colspan="4" align="center"> 
    <input name="check1" id="check1" type="checkbox" onclick="habilitar();"> 
    Essa atividade possui per&iacute;odo de realiza&ccedil;&atilde;o.</td>
<tr>
    <td align="right" colspan="2">                   
     <b>Data de In&iacute;cio: </b>
     </td>
     <td colspan="2"> 
     <select  disabled="disabled" name="d_ini" style="width:auto;" id="d_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">DD</option>
     <?php $dia = 1;
while($dia<=31){
	$dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
   echo "<option value='$dia'>$dia</option>";
   $dia++;
}?>
	</select>    
    
    
    <select  disabled="disabled" name="m_ini" style="width:auto;" id="m_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">MM</option>
     <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
	</select>
    
    <select  disabled="disabled" name="a_ini" style="width:auto;" id="a_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="0000">AAAA</option>
     <?php $ano = date('Y')-1;
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
	</select></td>
    </tr>
    <tr>
    <td align="right" colspan="2"> 
	<b>Hor&aacute;rio de In&iacute;cio: </b>
    </td>
    <td colspan="2">
     <select  disabled="disabled" name="hh_ini" style="width:auto;" id="hh_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Hora</option>
     <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
	</select>    
    
    
    <select  disabled="disabled" name="mm_ini" style="width:auto;" id="mm_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Min.</option>
     <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
	</select>
    
    <select  disabled="disabled" name="ss_ini" style="width:auto;" id="ss_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Seg.</option>
     <?php $ss = 0;
while($ss<=59){
	$ss = str_pad($ss, 2, "0", STR_PAD_LEFT);
   echo "<option value='$ss'>$ss</option>";
   $ss++;
}?>
	</select>
    </td>
    
</tr>

<tr>
    <td align="right" colspan="2">                   
     <b>Data Final: </b>
     </td>
     <td colspan="2"> 
     <select  disabled="disabled" name="d_fin" style="width:auto;" id="d_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">DD</option>
     <?php $dia = 1;
while($dia<=31){
	$dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
   echo "<option value='$dia'>$dia</option>";
   $dia++;
}?>
	</select>    
    
    
    <select  disabled="disabled" name="m_fin" style="width:auto;" id="m_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">MM</option>
     <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
	</select>
    
    <select  disabled="disabled" name="a_fin" style="width:auto;" id="a_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="0000">AAAA</option>
     <?php $ano = date('Y')-1;
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
	</select></td>
    </tr>
    <tr>
    <td align="right" colspan="2"> 
	<b>Hor&aacute;rio de T&eacute;rmino: </b>
    </td>
    <td colspan="2">
     <select  disabled="disabled" name="hh_fin" style="width:auto;" id="hh_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Hora</option>
     <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
	</select>    
    
    
    <select  disabled="disabled" name="mm_fin" style="width:auto;" id="mm_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Min.</option>
     <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
	</select>
    
    <select  disabled="disabled" name="ss_fin" style="width:auto;" id="ss_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Seg.</option>
     <?php $ss = 0;
while($ss<=59){
	$ss = str_pad($ss, 2, "0", STR_PAD_LEFT);
   echo "<option value='$ss'>$ss</option>";
   $ss++;
}?>
	</select>
    </td>
    
</tr>

<tr>
	<td bgcolor="#6C6C6C" align="center" colspan="4" style="color:#FFF"><font size="+1"><b>DESCRI&Ccedil;&Atilde;O</b></font></td>
</tr>
<tr>
    <td colspan="4"><textarea id="descricao" name="descricao" style="height:100px" class="ckeditor"></textarea></td>
</tr>

<tr>
	<td bgcolor="#6C6C6C" align="center" colspan="4" style="color:#FFF"><font size="+1"><b>CONTE&Uacute;DO</b></font></td>
</tr>
<tr>
    <td colspan="4"><textarea id="conteudo" name="conteudo" class="ckeditor"></textarea></td>
</tr>
<tr>
	<td colspan="2" align="right"><b>Link Externo:</b></td>
    <td colspan="2"><b><input id="link" name="link" type="text" disabled="disabled" value="http://"> <input name="check2" id="check2" type="checkbox" onclick="habilitar();"></b></td>

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
        document.getElementById('link').disabled = false;  
    } else {  
        document.getElementById('link').disabled = true; 
    } 
	
}  
</script> 