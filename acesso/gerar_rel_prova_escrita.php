<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$get_curso = $_GET["curso"];
$nivel = $_GET["nivel"];
$nquestoes_baixo = $_GET["nquestoes_baixo"];
$nquestoes_medio = $_GET["nquestoes_medio"];
$nquestoes_alto = $_GET["nquestoes_alto"];
$get_valor = format_valor($_GET["valor"]);
$get_data = format_data($_GET["data"]);
$get_anograde = $_GET["anograde"];

if(isset($get_anograde)){
	$filtro_anograde = "anograde LIKE '%$get_anograde%' AND ";
} else {
	$filtro_anograde = "";
}

if(isset($get_curso)){
	$filtro_curso = "curso LIKE '%$get_curso%' AND ";
} else {
	$filtro_curso = "";
}

if(isset($nivel)){
	$filtro_nivel = "nivel LIKE '%$nivel%'";
} else {
	$filtro_nivel = "";
}


$filtro_completo = $filtro_anograde.$filtro_curso.$filtro_nivel;
$sql_disciplinas = mysql_query("SELECT * FROM disciplinas WHERE $filtro_completo");
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
<table class="full_table_list" border="1" width="100%">
<tr bgcolor="#D1D1D1">
	<td align="center"><b>N&iacute;vel</b></td>
    <td align="center"><b>Curso</b></td>
    <td align="center"><b>Ano / M&oacute;dulo</b></td>
    <td align="center"><b>Disciplina</b></td>
    <td align="center"><b>Ano / Grade</b></td>
    <td align="center"><b>Avalia&ccedil;&atilde;o</b></td>
</tr>
<?php
while($dados_disciplina = mysql_fetch_array($sql_disciplinas)){
	$disciplina_cod = $dados_disciplina["cod_disciplina"];
	$disciplina_nome = $dados_disciplina["disciplina"];
	$disciplina_nivel = $dados_disciplina["nivel"];
	$disciplina_curso = $dados_disciplina["curso"];
	$disciplina_modulo = $dados_disciplina["modulo"];
	$disciplina_anograde = $dados_disciplina["anograde"];
	echo "
	<tr>
		<td align=\"center\">$disciplina_nivel</td>
		<td align=\"center\">$disciplina_curso</td>
		<td align=\"center\">$disciplina_modulo</td>
		<td align=\"center\">$disciplina_nome</td>
		<td align=\"center\">$disciplina_anograde</td>
		<td align=\"center\"><a target=\"_blank\" href=\"gerar_prova_escrita.php?curso=$disciplina_curso&modulo=$disciplina_modulo&cod_disc=$disciplina_cod&nquestoes_baixo=$nquestoes_baixo&nquestoes_medio=$nquestoes_medio&nquestoes_alto=$nquestoes_alto&anograde=$get_anograde&valor=$get_valor&data=$get_data\">
		[Gerar Avalia&ccedil;&atilde;o]</a></td>
	</tr>
	";
}
$get_curso = $_GET["curso"];
$cod_disc = $_GET["cod_disc"];
$nquestoes_baixo = $_GET["nquestoes_baixo"];
$nquestoes_medio = $_GET["nquestoes_medio"];
$nquestoes_alto = $_GET["nquestoes_alto"];
$get_valor = format_valor($_GET["valor"]);
$get_data = format_data($_GET["data"]);
$get_anograde = $_GET["anograde"];
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