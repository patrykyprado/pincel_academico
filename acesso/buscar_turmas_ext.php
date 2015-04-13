<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$buscar = $_GET["grupo"];
if($user_unidade == ""){
	$sql = mysql_query("SELECT * FROM ced_turma WHERE grupo LIKE '$buscar' ORDER BY grupo,nivel, curso, modulo");
} else {
	$sql = mysql_query("SELECT * FROM ced_turma WHERE grupo LIKE '$buscar' AND unidade LIKE '%$user_unidade%' ORDER BY grupo, nivel,curso, modulo");
}

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
                              <b>Turmas</b>
                          </header>
                          <div class="panel-body">
<form id="form2" name="form1" method="GET" action="buscar_turmas_ext.php">
    Grupo:
    <select name="grupo" class="textBox" id="grupo">
    <option value="">Escolha o Grupo</option>
    <?php
include ("menu/config_drop.php");?>
    <?php
if($user_unidade == ""){
		$sql2 = "SELECT distinct grupo FROM ced_turma ORDER BY grupo";
	} else {
		$sql2 = "SELECT distinct grupo FROM ced_turma WHERE unidade LIKE '%$user_unidade%' ORDER BY grupo";
	}
$result = mysql_query($sql2);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
}
?>
  </select>
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
  <label><strong>Turmas Encontradas:</strong> <?php echo $count; ?></label>
</form>
<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr>
    	
        <td><div align="center"><strong>Turma</strong></div></td>
        <td><div align="center"><strong>N&iacute;vel</strong></div></td>
		<td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>M&oacute;dulo</strong></div></td>
        <td><div align="center"><strong>Turno</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Polo</strong></div></td>
        
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
		$id_turma	   = $dados["id_turma"];
		$codigo	   = $dados["cod_turma"];
		$modulo	   = $dados["modulo"];
		$grupo	   = $dados["grupo"];
		$nivel	   = $dados["nivel"];
		$curso	   = $dados["curso"];
		$unidade	   = $dados["unidade"];
		$polo	   = $dados["polo"];
		$turno	   = strtoupper($dados["turno"]);
		
        echo "
	<tr>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><b><center>$codigo</b></center></a></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\">$nivel</td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$curso</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$modulo</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$turno</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$grupo</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$unidade</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$polo</center></td>
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