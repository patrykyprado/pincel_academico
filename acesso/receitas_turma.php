<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
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
    <option value="selecione" selected="selected">- Selecione a Unidade -</option>
    <?php
include("menu/config_drop.php");?>
    <?php
	if($user_unidade == ""){
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0 OR unidade LIKE '%ead%' ORDER BY unidade";
	} else {
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0 AND unidade LIKE '%$user_unidade%' OR unidade LIKE '%ead%' ORDER BY unidade";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select>
  
  De
   <input class="default-date-picker" name="dataini"  maxlength="10" size="16" type="text" value="" />
at&eacute; <input class="default-date-picker" name="datafin"  maxlength="10" size="16" type="text" value="" />
<input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
</form>
<hr>
<div align="center"><font size="+1" style="font-family:Verdana, Geneva, sans-serif">PARA EXIBIR RESULTADOS REALIZE A PESQUISA ACIMA.</font></div>
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