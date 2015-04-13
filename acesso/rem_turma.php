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
                              <b>Relat&oacute;rio: Rematr&iacute;cula / Turma</b>
                          </header>
                          <div class="panel-body">
<form id="form2" name="form1" method="GET" action="filtrar_rem_turma.php">
    Grupo:
    <select name="grupo" class="textBox" id="grupo">
    <option value="">Escolha o Grupo</option>
    <?php
include("menu/config_drop.php");?>
    <?php
	if($user_unidade == ""){
		$sql2 = "SELECT distinct grupo FROM ced_turma ORDER BY grupo";
	} else {
		$sql2 = "SELECT distinct grupo FROM ced_turma WHERE unidade LIKE '%$user_unidade%' ORDER BY grupo";
	}
$result = mysql_query($sql2);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
}
?>
  </select>
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
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
  
  	    <script type="text/javascript">
		$(function(){
			$('#nivel').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">- Selecione o Curso -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cursoexib + '">' + j[i].cursoexib + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="">– Selecione o Curso –</option>');
				}
			});
		});
		</script>