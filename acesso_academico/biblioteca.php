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
                              <b>Biblioteca Digital</b>
                          </header>
                          <div class="panel-body">
<form action="filtro_biblioteca.php" method="GET" target="filtro_biblioteca">
<b>Buscar:</b> <input style="width:500px" name="buscar_livro" id="buscar_livro"/>
</form>
</div>
                         
                          
                      </section>
                  </div>
              </div>
              <!-- page end-->
              <ul class="directory-list">
                  <li><a href="filtro_biblioteca.php?letra=a" target="filtro_biblioteca">a</a></li>
                  <li><a href="filtro_biblioteca.php?letra=b" target="filtro_biblioteca">b</a></li>
                  <li><a href="filtro_biblioteca.php?letra=c" target="filtro_biblioteca">c</a></li>
                  <li><a href="filtro_biblioteca.php?letra=d" target="filtro_biblioteca">d</a></li>
                  <li><a href="filtro_biblioteca.php?letra=e" target="filtro_biblioteca">e</a></li>
                  <li><a href="filtro_biblioteca.php?letra=f" target="filtro_biblioteca">f</a></li>
                  <li><a href="filtro_biblioteca.php?letra=g" target="filtro_biblioteca">g</a></li>
                  <li><a href="filtro_biblioteca.php?letra=h" target="filtro_biblioteca">h</a></li>
                  <li><a href="filtro_biblioteca.php?letra=i" target="filtro_biblioteca">i</a></li>
                  <li><a href="filtro_biblioteca.php?letra=j" target="filtro_biblioteca">j</a></li>
                  <li><a href="filtro_biblioteca.php?letra=k" target="filtro_biblioteca">k</a></li>
                  <li><a href="filtro_biblioteca.php?letra=l" target="filtro_biblioteca">l</a></li>
                  <li><a href="filtro_biblioteca.php?letra=m" target="filtro_biblioteca">m</a></li>
                  <li><a href="filtro_biblioteca.php?letra=n" target="filtro_biblioteca">n</a></li>
                  <li><a href="filtro_biblioteca.php?letra=o" target="filtro_biblioteca">o</a></li>
                  <li><a href="filtro_biblioteca.php?letra=p" target="filtro_biblioteca">p</a></li>
                  <li><a href="filtro_biblioteca.php?letra=q" target="filtro_biblioteca">q</a></li>
                  <li><a href="filtro_biblioteca.php?letra=r" target="filtro_biblioteca">r</a></li>
                  <li><a href="filtro_biblioteca.php?letra=s" target="filtro_biblioteca">s</a></li>
                  <li><a href="filtro_biblioteca.php?letra=t" target="filtro_biblioteca">t</a></li>
                  <li><a href="filtro_biblioteca.php?letra=u" target="filtro_biblioteca">u</a></li>
                  <li><a href="filtro_biblioteca.php?letra=v" target="filtro_biblioteca">v</a></li>
                  <li><a href="filtro_biblioteca.php?letra=w" target="filtro_biblioteca">w</a></li>
                  <li><a href="filtro_biblioteca.php?letra=x" target="filtro_biblioteca">x</a></li>
                  <li><a href="filtro_biblioteca.php?letra=y" target="filtro_biblioteca">y</a></li>
                  <li><a href="filtro_biblioteca.php?letra=z" target="filtro_biblioteca">z</a></li>
              </ul>
              <iframe name="filtro_biblioteca" id="filtro_biblioteca" src="filtro_biblioteca.php" frameborder="0" width="100%" height="300px"></iframe>
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