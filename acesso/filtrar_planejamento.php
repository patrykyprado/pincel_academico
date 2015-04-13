<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$get_anograde = $_GET["anograde"];
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
                              <b>Planejamentos</b>
                          </header>
                          <div class="panel-body">
<form action="filtrar_planejamento.php" method="get">
Selecione a Grade:  <select name="anograde" class="textBox" id="anograde" style="width:auto;">
    <?php
include ('menu/config_drop.php');?>
    <?php

$sql = "SELECT distinct anograde FROM disciplinas ORDER BY anograde DESC";


$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['anograde'] . "'>" . $row['anograde'] . "</option>";
}
?>
  </select>
<input type="submit" value="Pesquisar"/>
</form>
<table class="full_table_list" border="1" width="100%">
<tr>
	<td align="center"><b>N&iacute;vel</b></td>
    <td align="center"><b>Curso</b></td>
    <td align="center"><b>M&oacute;dulo</b></td>
    <td align="center"><b>Ano / Grade</b></td>
</tr>
<?php
$sql_cursos = mysql_query("SELECT DISTINCT nivel, curso, modulo, anograde FROM disciplinas WHERE anograde LIKE '%$get_anograde%' ORDER BY nivel, curso, modulo");
while($dados_cursos = mysql_fetch_array($sql_cursos)){
	$curso_nivel = format_curso($dados_cursos["nivel"]);
	$curso_nome = format_curso($dados_cursos["curso"]);
	$curso_modulo = format_curso($dados_cursos["modulo"]);
	$curso_grade = format_curso($dados_cursos["anograde"]);
	echo "
	<tr>
		<td align=\"center\"><a href=\"curso_planejamento.php?nivel=$curso_nivel&curso=$curso_nome&modulo=$curso_modulo&anograde=$curso_grade\">$curso_nivel</a></td>
		<td align=\"center\"><a href=\"curso_planejamento.php?nivel=$curso_nivel&curso=$curso_nome&modulo=$curso_modulo&anograde=$curso_grade\">$curso_nome</a></td>
		<td align=\"center\"><a href=\"curso_planejamento.php?nivel=$curso_nivel&curso=$curso_nome&modulo=$curso_modulo&anograde=$curso_grade\">$curso_modulo</a></td>
		<td align=\"center\"><a href=\"curso_planejamento.php?nivel=$curso_nivel&curso=$curso_nome&modulo=$curso_modulo&anograde=$curso_grade\">$curso_grade</a></td>
	</tr>
	";
	
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