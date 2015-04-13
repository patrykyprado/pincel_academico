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
                              <b>Relat&oacute;rio: Ocorr&ecirc;ncias</b>
                          </header>
                          <div class="panel-body">
<form id="form2" name="form1" method="post" action="filtrar_ocorrencia.php">
      <select name="grupo" class="textBox" id="grupo" onKeyPress="return arrumaEnter(this, event)">
        <option value="selecione">- Selecione o Grupo - </option>
        <?php
include('includes/config_drop.php')?>
        <?php
$sql = "SELECT * FROM grupos ORDER BY vencimento";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . (($row['grupo'])) . "</option>";
}
?>
      </select>
      <select name="polo" class="textBox" id="polo" onKeyPress="return arrumaEnter(this, event)">
      <option value="selecione">- Selecione a Unidade -</option>	
        <?php
		if($user_unidade == "EAD"){
			$sql = "SELECT distinct unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' OR unidade LIKE '%EAD%' ORDER BY unidade";
		} else {
			$sql = "SELECT distinct unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' AND categoria > 0 OR unidade LIKE '%EAD%'  ORDER BY unidade";
		}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . ($row['unidade']) . "'>" . (($row['unidade'])) . "</option>";
}
?>
      </select>
      
      <select name="tipo" class="textBox" id="tipo" onKeyPress="return arrumaEnter(this, event)">
        <option value="selecione">- Tipo de Ocorr&ecirc;ncia - </option>
        <?php
$sql = "SELECT * FROM tipo_ocorrencia ORDER BY ocorrencia";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id'] . "'>" . (($row['ocorrencia'])) . "</option>";
}
?>
      </select>
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form></div>
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
							options += '<option value="' + j[i].curso + '">' + j[i].cursoexib + '</option>';
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