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
                              <b>Relat&oacute;rio: Graficos de Matr&iacute;culas</b>
                          </header>
                          <div class="panel-body">

<table class="full_table_cad" align="center">
<form action="gerar_grafico.php" method="GET" onsubmit="validarAction(this);return false;">
<tr>
<?php
			include('includes/conectar.php');
		?>
<td><b>Unidade:</b></td>
<td>
		  <select name="unidade"  style="width:250px;" id="unidade" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <?php
				if($user_unidade == "" || $user_iduser == 26 || $user_iduser == 33){
					$sql = "SELECT distinct unidade
						FROM unidades WHERE categoria <> 0 OR unidade LIKE 'EAD'";
					echo '<option value="">Todas as Unidade</option>';
				} else {
				$sql = "SELECT distinct unidade
						FROM unidades WHERE unidade LIKE '%$user_unidade%'";
					}
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['unidade'].'">'.($row['unidade']).'</option>';
				}
			?>
                            </select> 
</td>
</tr>
<tr>
<td><b>Grupo:</b></td>
<td>
		  <select name="grupo"  style="width:250px;" id="grupo" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <?php
				$sql = "SELECT DISTINCT grupo
						FROM grupos ORDER BY grupo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['grupo'].'">'.($row['grupo']).'</option>';
				}
			?>
           </select>
</td>
</tr>

<tr>
<td><b>N&iacute;vel:</b></td>
<td>
		  <select name="nivel"  style="width:250px;" id="nivel" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <option value="">- ESCOLHA O N&Iacute;VEL -</option>
		    <?php
				$sql = "SELECT DISTINCT tipo
						FROM cursosead ORDER BY tipo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['tipo'].'">'.($row['tipo']).'</option>';
				}
			?>
           </select>
</td>
</tr>

<tr>
<td><b>M&oacute;dulo:</b></td>
<td>
           <select name="modulo"  style="width:250px;" id="modulo" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <option value="1" selected="selected">M&oacute;dulo I</option>
            
            <option value="2">M&oacute;dulo II</option>
            <option value="3">M&oacute;dulo III</option>
            
            
 </select>  
</td>
	</tr> 
<tr>
<td><b>Turno:</b></td>
<td><select name="turno" style="width:250px" class="textBox" id="turno" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione o Turno -</option>
        <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT DISTINCT turno FROM cursosead ORDER BY turno";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['turno'] . "'>" . strtoupper($row['turno']) . "</option>";
}
?></select></td>
      </tr>
<tr>
<td><b>Modelo:</b></td>
<td>
<select name="modelo" class="textBox"  style="width:250px;" id="modelo" onKeyPress="return arrumaEnter(this, event)">
      <?php
$sql = "SELECT * FROM ced_filtro WHERE (categoria = 2 AND id_pessoa = 0) OR (categoria = 2 AND id_pessoa LIKE '%$user_iduser%') ORDER BY layout";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filtro'] . "'>" . $row['layout'] . "</option>";
}
?>
      </select> 
</td> 
</tr>
<tr>
<td colspan="4" align="center"><br>
                            <input name="GERAR" type="submit" value="Gerar Gráfico" />     
                            
</td></tr>
</form>
</table>

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