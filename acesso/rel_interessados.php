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
                              <b>Relat&oacute;rio: Banco de Interessados</b>
                          </header>
                          <div class="panel-body">

<form action="gerar_rel_interessados.php" method="GET">
<div class="conteudo">
<table width="60%" class="table table-striped" align="center">
<tr>
  <td align="right"><b>Unidade:</b></td>
  <td><select name="unidade" class="textBox" id="unidade" onkeypress="return arrumaEnter(this, event)">
    <option value="" selected="selected">- Selecione a Unidade -</option>
    <?php
include("menu/config_drop.php");?>
    <?php
$sql = "SELECT DISTINCT unidade FROM unidades WHERE categoria > 0 ORDER BY unidade";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select></td>
<td align="right"><b>Modelo:</b></td>
<td><select name="modelo" class="textBox" id="modelo" onkeypress="return arrumaEnter(this, event)">
  <?php
include("menu/config_drop.php");?>
  <?php
$sql = "SELECT * FROM ced_filtro WHERE (categoria = 3 AND id_pessoa = 0) OR (categoria = 3 AND id_pessoa LIKE '%$user_iduser%') ORDER BY layout";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filtro'] . "'>" . $row['layout'] . "</option>";
}
?>
</select></td>
</tr>
<tr>
  <td align="right"><b>N&iacute;vel:</b></td>
  <td><select name="nivel" class="textBox" id="nivel" onkeypress="return arrumaEnter(this, event)">
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
  </select></td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td align="right"><b>Curso:</b></td>
  <td><select name="curso" class="textBox" id="curso" onkeypress="return arrumaEnter(this, event)">
    <option value="">- Selecione o Curso -</option>
  </select></td>
<td colspan="2" align="center"></td>

</tr>
<tr>
  <td align="right"><b>Modalidade:</b></td>
  <td ><select name="modalidade" class="textBox" id="modalidade" onkeypress="return arrumaEnter(this, event)">
    <option value="" selected="selected">- Selecione a Modalidade -</option>
    <option value="1">Presencial</option>
    <option value="2">EAD</option>
  </select></td>
  <td colspan="2" align="center"><input name="confirmado" id="confirmado" type="hidden" value="N" /> 
   </td>
</tr>



<tr>
  <td align="right"><b>In&iacute;cio:</b></td>
  <td ><input type="date" name="data_inicio" /></td>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td align="right"><b>Fim:</b></td>
  <td ><input type="date" name="data_fim" /></td>
<td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center" colspan="4"><input class="button" type="submit" value="Pesquisar" /></td>
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