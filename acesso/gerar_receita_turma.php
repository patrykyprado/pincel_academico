<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$get_unidade = $_GET["unidade"];

$dataini = $_GET["dataini"];
$diaini = substr($dataini,0,2);
$mesini = substr($dataini,3,2);
$anoini = substr($dataini,6,4);
$get_inicio = $anoini."-".$mesini."-".$diaini;

$datafin = $_GET["datafin"];
$diafin = substr($datafin,0,2);
$mesfin = substr($datafin,3,2);
$anofin = substr($datafin,6,4);
$get_fim = $anofin."-".$mesfin."-".$diafin;

$sql = mysql_query("SELECT * FROM ced_turma WHERE unidade LIKE '%$get_unidade%' ORDER BY nivel,curso,modulo,grupo");


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Relat&oacute;rio: Receitas / Turma</b>
                          </header>
                          <div class="panel-body">
<form method="GET" action="gerar_receita_turma.php">
  Unidade:
    <select name="unidade" class="textBox" id="unidade">
    <option  value="<?php echo $get_unidade;?>" selected="selected"><?php echo $get_unidade;?></option>
    <?php
include("menu/config_drop.php");?>
    <?php
$sql_p = "SELECT distinct unidade FROM unidades WHERE categoria > 0 OR unidade LIKE '%ead%' ORDER BY unidade";
$result = mysql_query($sql_p);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select>
  
  De
   <input class="default-date-picker" name="dataini" value="<?php echo format_data($get_inicio);?>"  maxlength="10" size="16" type="text" value="" />
at&eacute; <input class="default-date-picker" name="datafin"  value="<?php echo format_data($get_fim);?>" maxlength="10" size="16" type="text" value="" /> 
<input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
</form>
<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr>
    	<td><div align="center"><strong>Turma</strong></div></td>
        <td><div align="center"><strong>N&iacute;vel</strong></div></td>
		<td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>M&oacute;dulo</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Turno</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Receita</strong></div></td>
	</tr>

<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA TURMA ENCONTRADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo	   = $dados["cod_turma"];
		$id_turma	   = $dados["id_turma"];
		$modulo	   = $dados["modulo"];
		$grupo	   = $dados["grupo"];
		$nivel	   = $dados["nivel"];
		$curso	   = $dados["curso"];
		$unidade	   = $dados["unidade"];
		$turno	   = strtoupper($dados["turno"]);
		$sql_recebimento = mysql_query("SELECT SUM(valor_pagto) as recebimento_total FROM titulos WHERE tipo = 2 AND conta NOT LIKE '%LT%' AND (data_pagto BETWEEN '$get_inicio' AND '$get_fim') AND cliente_fornecedor IN (SELECT codigo FROM alunos WHERE codigo IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma=$id_turma))");
		$dados_recebimento = mysql_fetch_array($sql_recebimento);
		$recebimento_turma = number_format($dados_recebimento["recebimento_total"],2,",",".");


		
        echo "
	<tr>
		<td><a rel=\"shadowbox\" href=\"detalhe_receita_turma.php?id_turma=$id_turma&id=$codigo&turno=$turno&grade=$grupo&inicio=$get_inicio&fim=$get_fim&unidade=$get_unidade\"><b><center>$codigo</b></center></a></td>
		<td>$nivel</td>
		<td><center>$curso</center></td>
		<td><center>$modulo</center></td>
		<td><center>$unidade</center></td>
		<td><center>$turno</center></td>
		<td><center>$grupo</center></td>
		<td align=\"right\"><b>R$ $recebimento_turma</b></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

</table>
</div>
                          </div>
                          
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('includes/footer.php');
 ?>
  </section>
 <?php 
 include('includes/js.php');
 ?>


  </body>
</html>
        
<script language="javascript">
function arrumaEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
var i;
for (i = 0; i < field.form.elements.length; i++)
if (field == field.form.elements[i])
break;
i = (i + 1) % field.form.elements.length;
field.form.elements[i].focus();
return false;
}
else
return true;
}
</script>
    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
    

 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script>
  
  <?php include("includes/js_data.php");?>