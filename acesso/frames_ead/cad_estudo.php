<!DOCTYPE html>
<html lang="en">
<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/topo_inside_ead.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_acao = $_GET["acao"];


if($get_acao == 1){
	$nome_acao = "Cadastro de Estudo - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$coddisc = $_SESSION["coddisc"];
$turma_disc = $_SESSION["turma_disc"];
$anograde = $_SESSION["anograde"];
$codativ = $_GET["cod_ativ"];
$titulo = $_POST["titulo"];
$descricao = $_POST["descricao"];
$tentativas = $_POST["tentativas"];

//VERIFICA SE POSSUI AGRUPAMENTO PARA A TURMA_DISC
$sql_agrupamento = mysql_query("SELECT * FROM agrupamentos WHERE disciplinas LIKE '%$turma_disc%'");
$contar_agrupamento = mysql_num_rows($sql_agrupamento);


$data_criacao = date("Y-m-d h:i:s");
if(isset($_POST["check1"])){
	$datahora_inicio = $_POST["a_ini"]."-".$_POST["m_ini"]."-".$_POST["d_ini"]." ".$_POST["hh_ini"].":".$_POST["mm_ini"].":".$_POST["ss_ini"];
	$datahora_final = $_POST["a_fin"]."-".$_POST["m_fin"]."-".$_POST["d_fin"]." ".$_POST["hh_fin"].":".$_POST["mm_fin"].":".$_POST["ss_fin"];
} else {
	$datahora_inicio = "0000-00-00 00:00:00";
	$datahora_final = "0000-00-00 00:00:00";
}
if(isset($_POST["check2"])){
	$nota = str_replace(",",".",$_POST["nota"]);
} else {
	$nota = 0;
}

if($contar_agrupamento == 1){
	$dados_agrupamento = mysql_fetch_array($sql_agrupamento);
	$id_agrupamento = $dados_agrupamento["id_agrupamento"];
	$turmas_exp = explode(",",$dados_agrupamento["disciplinas"]);
	for( $i = 0 , $x = count( $turmas_exp ) ; $i <= $x ; ++ $i ) {
		$turma_disc = trim($turmas_exp[$i]);
		if(@mysql_query("INSERT INTO ea_estudo_dirigido (id_estudo,cod_ativ,turma_disc,subturma,data_criacao,data_inicio,data_fim,max_nota,tentativas,titulo,descricao) VALUES (NULL,'$codativ','$turma_disc','$id_agrupamento','$data_criacao','$datahora_inicio','$datahora_final','$nota','$tentativas','$titulo','$descricao')")){
			if(mysql_affected_rows() ==1){
				$data_boletim = substr($datahora_final,0,10);
				$sql_p_estudo = mysql_query("SELECT MAX(id_estudo) as id_atividade FROM ea_estudo_dirigido WHERE cod_ativ LIKE '$codativ' AND turma_disc LIKE '$turma_disc'");
				$dados_p_estudo = mysql_fetch_array($sql_p_estudo);
				$id_atividade = $dados_p_estudo["id_atividade"];
				$id_atividade_final = "E_".$id_atividade;
				if($nota !=0){
					mysql_query("INSERT INTO ced_turma_ativ (ref_id, cod_turma_d, grupo_ativ, cod_ativ, valor, data, descricao, id_atividade, id_etapa)
			VALUES (NULL, '$turma_disc', 'B', '19', '$nota', '$data_boletim', 'Estudo Dirigido - $titulo', '$id_atividade_final','4')");
				}
				echo "<script language='javascript'>
					window.alert('Estudo inserido com sucesso!');
					window.parent.frames['frame_central_ead'].location.reload();
					window.parent.Shadowbox.close();
					</script>";
			}

}
		
	}
} else {



if(@mysql_query("INSERT INTO ea_estudo_dirigido (id_estudo,cod_ativ,turma_disc,subturma,data_criacao,data_inicio,data_fim,max_nota,tentativas,titulo,descricao) VALUES (NULL,'$codativ','$turma_disc','0','$data_criacao','$datahora_inicio','$datahora_final','$nota','$tentativas','$titulo','$descricao')")){
	if(mysql_affected_rows() ==1){
		$data_boletim = substr($datahora_final,0,10);
		$sql_p_estudo = mysql_query("SELECT MAX(id_estudo) as id_atividade FROM ea_estudo_dirigido WHERE cod_ativ LIKE '$codativ' AND turma_disc LIKE '$turma_disc'");
		$dados_p_estudo = mysql_fetch_array($sql_p_estudo);
		$id_atividade = $dados_p_estudo["id_atividade"];
		$id_atividade_final = "E_".$id_atividade;
		if($nota !=0){
			mysql_query("INSERT INTO ced_turma_ativ (ref_id, cod_turma_d, grupo_ativ, cod_ativ, valor, data, descricao, id_atividade, id_etapa)
	VALUES (NULL, '$turma_disc', 'B', '19', '$nota', '$data_boletim', 'Estudo Dirigido - $titulo', '$id_atividade_final', '4')");
		}
		echo "<script language='javascript'>
			window.alert('Estudo inserido com sucesso!');
			window.parent.frames['frame_central_ead'].location.reload();
			window.parent.Shadowbox.close();
			</script>";
	}

}
}

}//fecha o post Salvar
	
	
	
}//fecha o get acao


?>

  <body>

  <section id="container" class="sidebar-closed">


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Cadastro de Estudo Dirigido</b>
                          </header>
                        <div class="panel-body">
<form method="post" action="#">
<input name="cod_disc" id="cod_disc" type="hidden"  value="<?php echo $_SESSION["coddisc"] ;?>"/>
    <input name="turma_disc" id="turma_disc" type="hidden"  value="<?php echo $_SESSION["turma_disc"] ;?>"/>
    <input name="anograde" id="anograde" type="hidden"  value="<?php echo $_SESSION["anograde"] ;?>"/>

<table width="100%">
<tr>
	<td colspan="4" align="center" bgcolor="#6C6C6C" style="color:#FFF"><?php echo $nome_acao.$nome_disciplina;?></td>
</tr>
<tr>
    <td colspan="4" align="center"> 
    <input name="check1" id="check1" type="checkbox" onclick="habilitar();"> Esse estudo possui per&iacute;odo para realiza&ccedil;&atilde;o<br>                   
     </td>
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
     <option value="23">Hora</option>
     <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
	</select>    
    
    
    <select  disabled="disabled" name="mm_fin" style="width:auto;" id="mm_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="59">Min.</option>
     <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
	</select>
    
    <select  disabled="disabled" name="ss_fin" style="width:auto;" id="ss_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="59">Seg.</option>
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
	<td colspan="2" align="right"><b>M&aacute;ximo de Envios:</b></td>
    <td colspan="2"><b><input id="tentativas" name="tentativas" type="text" value="2"></b></td>

</tr>
<tr>
	<td align="right" colspan="2"><font size="+1"><b>T&iacute;tulo:</b></font></td>
    <td colspan="2"><input name="titulo" type="text" id="titulo" style="width:400px;" value="" /></td>
</tr>
<tr>
    <td colspan="4"><b>Descri&ccedil;&atilde;o:</b><br /><textarea id="descricao" name="descricao" style="height:100px" class="ckeditor"></textarea></td>
</tr>
<tr>
	<td colspan="2" align="right"><b>Nota:</b></td>
    <td colspan="2"><b><input id="nota" name="nota" type="text" disabled="disabled" value="0,00"> <input name="check2" id="check2" type="checkbox" onclick="habilitar();"></b></td>

</tr>

<tr>
	<td colspan="4" align="center"><input id="Salvar" name="Salvar" type="submit" value="Salvar"></td>
</tr>

</table>

</form>
                          </div>
                          <div class="panel-footer">
                          </div>
                      </section>
                 
              </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('../includes/footer.php');
 ?>
  </section>
 <?php 
 include('../includes/js_ead.php');
 ?>


  </body>
</html>


    

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o cliente/fornecedor? '))
{
location.href="apagar_forn.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar_forn.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
function enviar(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor2').value = valor;
this.close();
}
</script>
    </script>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
     
<script>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 
  
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