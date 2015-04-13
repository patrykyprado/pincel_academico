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
                              <b>Gerador de Avalia&ccedil;&atilde;o</b>
                          </header>
                          <div class="panel-body">
<form action="gerar_rel_prova_escrita.php" method="GET">

<table class="full_table_cad" border="1" align="center" cellpadding="3">
<tr>
  <td align="right"><b>Ano / Grade:</b></td>
  <td><select name="anograde" class="textBox" id="anograde" onkeypress="return arrumaEnter(this, event)">
    <option value="" selected="selected">- Selecione a Grade -</option>
    <?php
include("includes/config_drop.php");?>
    <?php
$sql = "SELECT DISTINCT anograde FROM disciplinas";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['anograde'] . "'>" . $row['anograde'] . "</option>";
}
?>
    </select></td>
</tr>
<tr>
  <td align="right"><b>N&iacute;vel:</b></td>
  <td><select name="nivel" class="textBox" id="nivel" onkeypress="return arrumaEnter(this, event)">
    <option value="" selected="selected">- Selecione o N&iacute;vel -</option>
    <?php
$sql = "SELECT DISTINCT tipo FROM cursosead WHERE tipo NOT LIKE '%-%' AND tipo NOT LIKE '%profis%' ORDER BY tipo";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['tipo'] . "'>" . $row['tipo'] . "</option>";
}
?>
    </select></td>
</tr>
<tr>
  <td align="right"><b>Curso:</b></td>
  <td><select name="curso" class="textBox" id="curso" onkeypress="return arrumaEnter(this, event)">
    <option value="">- Selecione o Curso -</option>
  </select></td>

</tr>

<tr>
  <td align="right"><b>N&ordm; Quest&otilde;es (Grau: Baixo):</b></td>
  <td ><input type="text" readonly value="5" name="nquestoes_baixo2" />
  <input type="hidden" name="nquestoes_baixo" value="5" /></td>
</tr>
<tr>
  <td align="right"><b>N&ordm; Quest&otilde;es (Grau: M&eacute;dio):</b></td>
  <td ><input type="text" readonly value="3" name="nquestoes_medio2" />
  <input type="hidden" name="nquestoes_medio" value="3"  /></td>
</tr>
<tr>
  <td align="right"><b>N&ordm; Quest&otilde;es (Grau: Alto):</b></td>
  <td ><input type="text" readonly value="2" name="nquestoes_alto2" />
  <input type="hidden" name="nquestoes_alto" value="2" /></td>
</tr>
<tr>
  <td align="right"><b>Data da Prova:</b></td>
  <td ><input type="date" name="data" /></td>
</tr>
<tr>
  <td align="right"><b>Valor da Prova:</b></td>
  <td ><input type="text" name="valor" /></td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>
<tr>
<td align="center" colspan="4"><input class="button" type="submit" value="Pesquisar" /></td>
</tr>
</table></form>
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