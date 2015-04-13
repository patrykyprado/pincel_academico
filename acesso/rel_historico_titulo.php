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
                              <b>Hist&oacute;rico de T&iacute;tulos</b>
                          </header>
                          <div class="panel-body">
<table width="auto">
<form action="gerar_historico_titulo.php" method="post" target="meio_frame">

<tr>
	<td>C&oacute;digo de Barras:</td>
    <td><input type="text" name="cod_barras" style="width:300px;"/></td>
    <td>Num. T&iacute;tulo: </td>
    <td><input type="text" name="id_titulo" style="width:70px;"/></td>
    <td width="300px" align="right"><input name="pesquisar" type="submit" value="Pesquisar"/></td>
</tr>
<tr>
	<td>Cliente / Fornecedor:</td>
    <td><input name="id_cliente" type="text" style="width:300px;"/></td>
</tr>

</form>
</table>
<hr>
<iframe width="100%" name="meio_frame" frameborder="0" style="border:0px;" id="meio_frame"></iframe>

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