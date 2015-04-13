<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$get_anograde = $_GET["anograde"];
$get_cod_disc = $_GET["cod_disc"];
$get_nivel = $_GET["nivel"];
$get_curso = $_GET["curso"];
$sql_disciplina = mysql_query("SELECT * FROM disciplinas WHERE curso LIKE '%$get_curso%' AND nivel LIKE '%$get_nivel%' AND anograde LIKE '%$get_anograde%' AND cod_disciplina LIKE '%$get_cod_disc%' ORDER BY disciplina");
$dados_disc = mysql_fetch_array($sql_disciplina);
$disc_ch = $dados_disc["ch"];
$disc_nome= format_curso($dados_disc["disciplina"]);
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
<table class="full_table_list" width="70%" border="1" align="center">
<tr>
	<td colspan="4" align="center" bgcolor="#575757"><font color="#FFFFFF"><b><?php echo $disc_nome ;?></b></font></td>
</tr>
<tr>
	<td align="center"><b>Disciplina</b></td>
	<td align="center"><b>N&ordm; Aula</b></td>
    <td align="center"><b>Planejamento</b></td>
    <td align="center"><b>Status</b></td>
    
</tr>
<?php
$aula = 1;
while($aula <= $disc_ch){
	$sql_planejamento = mysql_query("SELECT * FROM conteudo_previsto WHERE n_aula = '$aula' AND cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%'");
	if(mysql_num_rows($sql_planejamento)>=1){
		$dados_planejamento = mysql_fetch_array($sql_planejamento);
		$status = $dados_planejamento["arquivo"];
	} else {
		$status = "PENDENTE";	
	}
	echo "
	<tr>
		<td align=\"center\">$disc_nome</td>
		<td align=\"center\">$aula</td>
		<td align=\"center\"><a rel=\"shadowbox\" href=\"ver_planejamento.php?aula=$aula&cod_disc=$get_cod_disc\"><font size=\"+1\"><div class=\"fa fa-eye tooltips\" data-placement=\"right\" data-original-title=\"Visualizar Planejamento\"></div></font></a> <a rel=\"shadowbox\" href=\"cad_planejamento.php?aula=$aula&cod_disc=$get_cod_disc&anograde=$get_anograde\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Alterar Planejamento\"></div></font></a></td>
		<td align=\"center\"><a href=\"$status\" rel=\"shadowbox\">$status</a></td>
	</tr>
	";
	$aula +=1;
	
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