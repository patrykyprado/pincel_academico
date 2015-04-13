<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

?>]


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
                              <b>Relat&oacute;rio: Ebitda</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="get" action="listar_ebitda.php" target="_blank">
  <font size="+2" style="text-align:left"></font>
  <table width="60%"border="1" align="center" cellspacing="5"  style="text-align:left">
      <th colspan="2" align="center"><font size="+2">Pesquisa (Centro de Custo</font></th>
  	<th width="37%" align="center"><font size="+2">Centro de Custo</font></th>
  <tr>
    <td>In&iacute;cio:</td>
    <td><input type="date" required="required" name="inicio" id="inicio" onkeypress="return arrumaEnter(this, event)" /></td>
    <td align="center"><select name="cc1" style="width:200px" class="textBox" id="cc1" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE A EMPRESA</option>
      <?php
include ('menu/config_drop.php');?>
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
    <td>Fim:</td>
    <td><input type="date" required="required" name="fim" id="fim" onkeypress="return arrumaEnter(this, event)" /></td>
    <td align="center"><select name="cc2" style="width:200px"  class="textBox" id="cc2" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE A FILIAL</option>
      <?php
include ('menu/config_drop.php');?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT * FROM cc2 WHERE niveltxt like '%GERAL%' ORDER BY nome_filial ";
	  } else {
		  $sql = "SELECT * FROM cc2 WHERE niveltxt like '%GERAL%' AND nome_filial LIKE '%$user_unidade%' ORDER BY nome_filial ";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filial'] . "'>" . $row['nome_filial'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr>
    <td>Tipo:</td>
    <td><select name="tipo" class="textBox" id="tipo" onkeypress="return arrumaEnter(this, event)">
      <option value="1">Despesa</option>
      <option value="2">Receita</option>
      
    </select></td>
    <td></td>
    </tr>
  <tr>
    <td>Ebitda:</td>
    <td colspan="2">
  <input type="radio" checked name="ebitda" value="S" />
      Sim<br />
  <input type="radio" name="ebitda" value="N" />
      N&atilde;o</td>
    
    </tr>
    


  
  <tr>
    <td colspan="3" align="center"><input type="submit" name="buscar" id="buscar" value="Buscar" /></td>
  </tr>
</table>

</form>
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
    
    
<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('projeto').disabled = false;  
    } else {  
        document.getElementById('projeto').disabled = true;  
    }  
}  
</script> 
