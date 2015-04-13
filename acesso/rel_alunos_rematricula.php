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
                              <b>Relat&oacute;rio: Alunos Rematr&iacute;culados</b>
                          </header>                           
                      </section>
                  </div>
                  <form action="gerar_alunos_rematriculados.php" method="GET">
                  <div class="col-md-6">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Grupo Anterior</b>
                          </header>
                          <div class="panel-body">
					<table class="full_table_cad" width="60%" align="center" cellpadding="3">
<tr>
<td align="right"><B>N&iacute;vel:</B></td>
<td>
<select name="nivel_ant" class="textBox" id="nivel_ant" onKeyPress="return arrumaEnter(this, event)">
<option value="" selected="selected">- Selecione o N&iacute;vel -</option>
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT DISTINCT tipo FROM cursosead WHERE tipo NOT LIKE '%-%' AND tipo NOT LIKE '%profis%' ORDER BY tipo";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['tipo'] . "'>" . $row['tipo'] . "</option>";
}
?>
      </select>
</td>
</tr>
<tr>
<td align="right"><B>Curso:</B></td>
<td><select name="curso_ant" class="textBox" id="curso_ant" onKeyPress="return arrumaEnter(this, event)">
        <option value="">- Selecione o Curso -</option>
        
      </select></td>
</tr>
<tr>
<td align="right"><B>Ano/M&oacute;dulo:</B></td>
<td ><select name="modulo_ant" class="textBox" id="modulo_ant" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione o M&oacute;dulo/Ano -</option>
        <option value="1">M&oacute;dulo I</option>
        <option value="2">M&oacute;dulo II</option>
        <option value="3">M&oacute;dulo III</option>
        
      </select></td>

</tr>
<tr>
<td align="right"><B>Turno:</B></td>
<td ><select name="turno_ant" class="textBox" id="turno_ant" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione o Turno -</option>
        <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT DISTINCT turno FROM cursosead ORDER BY turno";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['turno'] . "'>" . strtoupper($row['turno']) . "</option>";
}
?>
        
      </select></td>
</tr>



<tr>
<td align="right"><B>Unidade:</B></td>
<td><select name="unidade_ant" class="textBox" id="unidade_ant" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione a Unidade -</option>
        <?php
include("menu/config_drop.php");?>
      <?php
	  if($user_unidade == "" || $user_iduser == 26){
		$sql = "SELECT DISTINCT unidade FROM unidades WHERE categoria > 0 OR unidade LIKE '%EAD%' ORDER BY unidade";
	  } else {
		$sql = "SELECT DISTINCT unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' ORDER BY unidade";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . strtoupper($row['unidade']) . "</option>";
}
?>
        
      </select></td>
</tr>
<tr>
<td align="right"><B>Polo:</B></td>
<td ><select name="polo_ant" class="textBox" id="polo_ant" onKeyPress="return arrumaEnter(this, event)">
  <option value="" selected="selected">- Selecione o Polo -</option>
  <?php
include("menu/config_drop.php");?>
  <?php
	  if($user_unidade == "" || $user_unidade == "EAD"){
		$sql = "SELECT DISTINCT unidade FROM unidades WHERE categoria > 0 ORDER BY unidade";
	  } else {
		$sql = "SELECT DISTINCT unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' ORDER BY unidade";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . strtoupper($row['unidade']) . "</option>";
}
?>
  
</select></td>
</tr>
<tr>
<td align="right"><B>Grupo:</B></td>
<td><select name="grupo_ant" class="textBox" id="grupo_ant" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione o Grupo -</option>
        <?php
include("menu/config_drop.php");?>
      <?php

		$sql = "SELECT DISTINCT grupo FROM grupos  ORDER BY grupo";
	  
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . strtoupper($row['grupo']) . "</option>";
}
?>
        
      </select></td>
</tr>
</table>
</div>
                         
                          
                      </section>
                  </div>
                  <div class="col-md-6">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Grupo Novo</b>
                          </header>
                          <div class="panel-body">
<table class="full_table_cad" width="60%" align="center" cellpadding="3">

<tr>
<td align="right"><B>Grupo:</B></td>
<td><select name="grupo" class="textBox" id="grupo" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione o Grupo -</option>
        <?php
include("menu/config_drop.php");?>
      <?php

		$sql = "SELECT DISTINCT grupo FROM grupos  ORDER BY grupo";
	  
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . strtoupper($row['grupo']) . "</option>";
}
?>
        
      </select></td>
</tr>
</table>
</div>
                         
                          
                      </section>
                  </div>
                  
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                          <center><input type="submit" value="Buscar"/></center>
                          </header>                           
                      </section>
                  </div>
                  </form>
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
			$('#nivel_ant').change(function(){
				if( $(this).val() ) {
					$('#curso_ant').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">- Selecione o Curso -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cursoexib + '">' + j[i].cursoexib + '</option>';
						}	
						$('#curso_ant').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso_ant').html('<option value="">– Selecione o Curso –</option>');
				}
			});
		});
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