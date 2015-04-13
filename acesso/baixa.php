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
                              <b>Arquivo Retorno</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" enctype="multipart/form-data" method="post"  onsubmit="validarAction(this);return false;">
<p>Banco: </select>  
           <select name="tipo" id="tipo" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <option value="baixa.php" selected="selected">BANCO DE RETORNO</option>
            <option value="ler.php">021 - BANESTES</option>
            <option value="ler_santander.php">033 - SANTANDER</option>
           
		   
                            </select>   </p>
<p>Selecione o arquivo retorno para leitura.</p>

  <input type="file" name="arq" id="arq" />
  <center><input type="submit" name="Enviar" id="Enviar" value="Enviar" /></center>
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