<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
if(isset($_GET["grupo"])){
	$filtro_grupo = " WHERE grupo LIKE '".$_GET["grupo"]."'";
} else {
	$filtro_grupo = "";
}

if(isset($_GET["nivel"])){
	$filtro_nivel = " AND nivel LIKE '%".$_GET["nivel"]."%'";
} else {
	$filtro_nivel = "";
}

if(isset($_GET["curso"])){
	$filtro_curso = " AND curso LIKE '%".$_GET["curso"]."%'";
} else {
	$filtro_curso = "";
}

if(isset($_GET["modulo"])){
	$filtro_modulo = " AND modulo LIKE '%".$_GET["modulo"]."%'";
} else {
	$filtro_modulo = "";
}

if(isset($_GET["turno"])){
	$filtro_turno = " AND turno LIKE '%".$_GET["turno"]."%'";
} else {
	$filtro_turno = "";
}
if(isset($_GET["unidade"])){
	$filtro_unidade = " AND unidade LIKE '%".$_GET["unidade"]."%'";
} else {
	$filtro_unidade = "";
}

if($user_unidade != ""){
	$filtro_unidade = " AND unidade LIKE '%".$user_unidade."%'";
}
	
	

if(isset($_GET["polo"])){
	$filtro_polo = " AND polo LIKE '%".$_GET["polo"]."%'";
} else {
	$filtro_polo = "";
}
$order_by = " ORDER BY grupo, nivel, curso, modulo, turno";
$filtro_completo = $filtro_grupo.$filtro_curso.$filtro_modulo.$filtro_nivel.$filtro_polo.$filtro_turno.$filtro_unidade.$order_by;

$sql_completo = "SELECT * FROM ced_turma".$filtro_completo;

$sql_turmas_ead = mysql_query($sql_completo);

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
                              <b>Sala Virtual - Pesquisa</b>
                          </header>
                          <div class="panel-body">
<table class="table table-hover" border="1" align="center">
	<tr>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Polo</strong></div></td>
		<td><div align="center"><strong>N&iacute;vel</strong></div></td>
        <td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>M&oacute;dulo</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Sala Virtual</strong></div></td>
	</tr>
<?php

while($dados_turmas = mysql_fetch_array($sql_turmas_ead)){
	$turma_cod = $dados_turmas["cod_turma"];
	$turma_turno = $dados_turmas["turno"];
	$turma_polo = $dados_turmas["polo"];
	$turma_unidade = $dados_turmas["unidade"];
	$turma_curso = format_curso($dados_turmas["curso"]);
	$turma_nivel = format_curso($dados_turmas["nivel"]);
	$turma_modulo = $dados_turmas["modulo"];
	$turma_grupo = $dados_turmas["grupo"];
	$turma_idturma = $dados_turmas["id_turma"];
	$turma_anograde = $dados_turmas["anograde"];
	echo "
	<tr>
	<td>$turma_unidade</td>
    <td>$turma_polo</td>
    <td>$turma_nivel</td>
    <td>$turma_curso</td>
    <td>$turma_modulo</td>
    <td>$turma_grupo</td>
	<td align=\"center\">
	<a href=\"ea_sala.php?id_turma=$turma_idturma\"><font size=\"+1\"><div class=\"fa fa-group tooltips\" data-placement=\"top\" data-original-title=\"Acessar CEDTEC Virtual\"></div></font></a>
	</td>
</tr>
	";
}


?>

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

    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
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
