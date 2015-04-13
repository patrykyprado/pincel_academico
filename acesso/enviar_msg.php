<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');


if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$post_grupo = $_POST["grupo"];
	$post_curso = $_POST["curso"];
	$post_modulo = $_POST["modulo"];
	$post_titulo = $_POST["titulo"];
	$post_mensagem = $_POST["mensagem"];
	$dataatual = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO ced_informativos (id_informativo, datahora, grupo, curso, modulo, titulo, conteudo) VALUES (NULL,'$dataatual','$post_grupo', '$post_curso','$post_modulo','$post_titulo','$post_mensagem')");
	echo "
	<script language=\"javascript\">
	alert('Mensagem inserida com sucesso');
	window.close();
	</script>
	";
	
}
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
                              <b>Envio de Mensagem Acad&ecirc;mica</b>
                          </header>
                          <div class="panel-body">
<form name="novorda" action="#" method="post">
<table class="table table-striped" border="0" width="100%">
<tr>
	<td>Grupo</td>
    <td><select style="width:300px;"name="grupo" class="textBox" id="grupo" onKeyPress="return arrumaEnter(this, event)">
        <?php
include("menu/config_drop.php");?>
        <?php
$sql = "SELECT distinct grupo FROM grupos ORDER BY vencimento";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . strtoupper($row['grupo']) . "</option>";
}
?>
      </select></td>
</tr>
<tr>
	<td>Curso</td>
    <td><select style="width:300px;"name="curso" class="textBox" id="curso" onKeyPress="return arrumaEnter(this, event)">
        <?php
include("menu/config_drop.php");?>
        <?php
$sql = "SELECT DISTINCT( curso ) FROM cursosead ORDER BY curso";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['curso'] . "'>" . strtoupper($row['curso']) . "</option>";
}
?>
      </select></td>
</tr>
<tr>
	<td>M&oacute;dulo</td>
    <td><select style=""name="modulo" class="textBox" id="modulo" onKeyPress="return arrumaEnter(this, event)">
                                  <option value="1" selected="selected">I</option>
                                  <option value="2">II</option>
                                  <option value="3">III</option>
        
                             </select></td>
</tr>
<tr>
	<td>T&iacute;tulo</td>
    <td><input name="titulo" class="textBox" style="width:400px;height:30px;"></td>
</tr>
<tr>
	<td colspan="2" align="center">Mensagem</td>
</tr>
<tr>
    <td colspan="2" align="center">
    <textarea id="mensagem" name="mensagem" style="height:100px" class="ckeditor"></textarea></td>
</tr>
<tr>
	<td colspan="2" align="center"><input name="enviar" type="submit" value="Enviar"></td>
</tr>


<form>

                          
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->




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