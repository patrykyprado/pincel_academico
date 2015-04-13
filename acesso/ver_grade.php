<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$get_grade = $_GET["grade"];
$sql_cursos = mysql_query("SELECT DISTINCT nivel, curso, modulo FROM disciplinas WHERE anograde LIKE '%$get_grade%' ORDER BY nivel, curso, modulo");
$total_cursos = mysql_num_rows($sql_cursos);
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
                              <b>Grade Curricular</b>
                          </header>
                      <div class="panel-body">
<form method="GET" action="ver_grade.php">
  Grade Curr&iacute;cular:
    <select name="grade" class="textBox" id="grade">
    <?php
include("menu/config_drop.php");?>
    <?php
	if($user_empresa == ""){
		$sql = "SELECT * FROM grade ORDER BY grade";
	} else {
		$sql = "SELECT * FROM grade WHERE empresa LIKE '%$user_empresa%' ORDER BY grade";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grade'] . "'>" . $row['grade'] . "</option>";
}
?>
  </select>
  <input type="submit" name="Pesquisar" value="Pesquisar"/>
</form>
<hr>
<?php
if($total_cursos == 0){
	echo "<center>Nenhum curso encontrado para a grade selecionada.<br><br><a href=\"novo_curso_grade.php?grade=$get_grade\">[CADASTRE AGORA]</a></center>";
} else {
	echo "<table border=\"1\" width=\"100%\">
	<tr>
		<td align=\"center\"><b>Nível</b></td>
		<td align=\"center\"><b>Curso</b></td>
		<td align=\"center\"><b>Módulo</b></td>
	</tr>";
	while($dados_curso = mysql_fetch_array($sql_cursos)){
		$curso_nivel = format_curso($dados_curso["nivel"]);
		$curso_curso = format_curso($dados_curso["curso"]);
		$curso_modulo = format_curso($dados_curso["modulo"]);
		echo "<tr>
		<td align=\"center\"><a href=\"ver_detalhe_grade.php?nivel=$curso_nivel&curso=$curso_curso&modulo=$curso_modulo&grade=$get_grade\">$curso_nivel</a></td>
		<td><a href=\"ver_detalhe_grade.php?nivel=$curso_nivel&curso=$curso_curso&modulo=$curso_modulo&grade=$get_grade\">$curso_curso</a></td>
		<td align=\"center\"><a href=\"ver_detalhe_grade.php?nivel=$curso_nivel&curso=$curso_curso&modulo=$curso_modulo&grade=$get_grade\">$curso_modulo</a></td>
	</tr>";
	}
	echo "</table>";
}

?>
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