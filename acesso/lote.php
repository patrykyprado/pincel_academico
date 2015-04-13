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
                              <b>Lote NF-e</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="get" action="listar_lote.php">
  <font size="+2" style="text-align:left"></font>
  <table width="50%" border="1" align="center" cellspacing="5" class="full_table_cad" style="text-align:left">
    <tr>
    <td>Unidade:</td>
    <td><select name="unidade" class="textBox" id="unidade" onkeypress="return arrumaEnter(this, event)">
      <?php
include 'menu/config_drop.php';?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0";
	  } else {
		$sql = "SELECT distinct unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' AND categoria > 0";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
    </select></td>
    <td width="37%" align="center"><select style="width:200px;" name="cc1" class="textBox" id="cc1" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE A EMPRESA</option>
      <?php
include 'menu/config_drop.php';?>
      <?php
	  if($user_empresa == 0){
		$sql = "SELECT * FROM cc1 ";
	  } else {
		 $sql = "SELECT * FROM cc1 WHERE id_empresa = $user_empresa";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
    </select></td>
  </tr>
  <tr>
    <td>Tipo:</td>
    <td><select name="tipo" class="textBox" id="tipo" onkeypress="return arrumaEnter(this, event)">
      <option value="2">Receita</option>
    </select></td>
    <td align="center"><select style="width:200px;" name="cc2" class="textBox" id="cc2" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE A FILIAL</option>
      <?php
include 'menu/config_drop.php';?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT * FROM cc2 WHERE niveltxt like '%GERAL%' AND lote_xml = 1 ORDER BY nome_filial ";
	  } else {
		  $sql = "SELECT * FROM cc2 WHERE niveltxt like '%GERAL%' AND nome_filial LIKE '%$user_unidade%' AND lote_xml = 1 ORDER BY nome_filial ";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filial'] . "'>" . $row['nome_filial'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr>
    <td>In&iacute;cio:</td>
    <td><input type="date" required="required" name="inicio" id="inicio" onkeypress="return arrumaEnter(this, event)" /></td>
    <td align="center"><select style="width:200px;" name="cc3" class="textBox" id="cc3" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE</option>
      <?php
include 'menu/config_drop.php';?>
      <?php
$sql = "SELECT * FROM cc3 ORDER BY id_cc3";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc3'] . "'>" . $row['nome_cc3'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr>
    <td>Fim:</td>
    <td><input type="date" required="required" name="fim" id="fim" onkeypress="return arrumaEnter(this, event)" /></td>
    <td align="center"><select style="width:200px;" name="cc4" class="textBox" id="cc4" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE</option>
    </select></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><select style="width:200px;" name="cc5" class="textBox" id="cc5" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE</option>
    </select></td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><select style="width:200px;" name="cc6" class="textBox" id="cc6" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE</option>
      <?php
include 'menu/config_drop.php';?>
      <?php
$sql = "SELECT * FROM cc6 ORDER BY id_cc6";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc6'] . "'>" . $row['nome_cc6'] . "</option>";
}
?>
    </select></td>
    </tr>

  
  <tr>
    <td colspan="3" align="center"><input type="submit" name="buscar" id="buscar" value="Buscar" /></td>
  </tr>
</table>

</form>
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