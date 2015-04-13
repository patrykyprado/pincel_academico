<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$get_anograde = $_GET["anograde"];
$get_curso = $_GET["curso"];
$get_nivel = $_GET["nivel"];
$get_modulo = $_GET["modulo"];
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
<table class="full_table_cad" border="1" align="center">
<tr>
	<td colspan="2" align="center" bgcolor="#575757"><font color="#FFFFFF"><b><?php echo $get_nivel.": ".$get_curso." - M&oacute;d. ".$get_modulo ;?></b></font></td>
</tr>
<tr>
	<td align="center"><b>Disciplinas</b></td>
    <td align="center"><b>Carga Hor&aacute;ria</b></td>
</tr>
<?php
$sql_disciplinas = mysql_query("SELECT DISTINCT * FROM disciplinas WHERE anograde LIKE '%$get_anograde%' AND curso LIKE '%$get_curso%' AND modulo LIKE '%$get_modulo%' AND nivel LIKE '%$get_nivel%'  ORDER BY disciplina");
while($dados_disc = mysql_fetch_array($sql_disciplinas)){
	$disc_nome = format_curso($dados_disc["disciplina"]);
	$disc_ch = format_curso($dados_disc["ch"]);
	$disc_cod = $dados_disc["cod_disciplina"];

	echo "
	<tr>
		<td align=\"center\"><a href=\"planejamento.php?anograde=$get_anograde&cod_disc=$disc_cod&nivel=$get_nivel&curso=$get_curso\">$disc_nome</a></td>
		<td align=\"center\"><a href=\"planejamento.php?anograde=$get_anograde&cod_disc=$disc_cod&nivel=$get_nivel&curso=$get_curso\">$disc_ch</a></td>
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