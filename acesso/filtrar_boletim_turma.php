<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$get_grupo = $_GET["grupo"];

if($user_unidade == ""){
	$sql = mysql_query("SELECT * FROM ced_turma WHERE grupo LIKE '%$get_grupo%' ORDER BY grupo,nivel, curso, modulo");
} else {
	$sql = mysql_query("SELECT * FROM ced_turma WHERE unidade LIKE '%$user_unidade%' AND grupo LIKE '%$get_grupo%' ORDER BY grupo,nivel, curso, modulo, unidade, polo");
}

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
$count = mysql_num_rows($sql);
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
                              <b>Relat&oacute;rio: Boletim / Turma</b>
                          </header>
                          <div class="panel-body">
<table width="100%" border="1" class="full_table_list" >
	<tr bgcolor="#DADADA" style="font-size:14px">
    	<td><div align="center"><strong>Turma</strong></div></td>
        <td><div align="center"><strong>N&iacute;vel</strong></div></td>
		<td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>M&oacute;dulo</strong></div></td>
        <td><div align="center"><strong>Turno</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Polo</strong></div></td>
	</tr>

<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA TURMA ENCONTRADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo	   = $dados["cod_turma"];
		$id_turma	   = $dados["id_turma"];
		$modulo	   = $dados["modulo"];
		$grupo	   = $dados["grupo"];
		$nivel	   = $dados["nivel"];
		$curso	   = $dados["curso"];
		$unidade	   = $dados["unidade"];
		$polo	   = $dados["polo"];
		$turno	   = strtoupper($dados["turno"]);
		
        echo "
	<tr>
		<td><a target=\"_blank\" href=\"gerar_boletins.php?id_turma=$id_turma\"><b><center>$codigo</b></center></a></td>
		<td><a target=\"_blank\" href=\"gerar_boletins.php?id_turma=$id_turma\">$nivel</td>
		<td><a target=\"_blank\" href=\"gerar_boletins.php?id_turma=$id_turma\"><center>$curso</center></td>
		<td><a target=\"_blank\" href=\"gerar_boletins.php?id_turma=$id_turma\"><center>$modulo</center></td>
		<td><a target=\"_blank\" href=\"gerar_boletins.php?id_turma=$id_turma\"><center>$turno</center></td>
		<td><a target=\"_blank\" href=\"gerar_boletins.php?id_turma=$id_turma\"><center>$grupo</center></td>
		<td><a target=\"_blank\" href=\"gerar_boletins.php?id_turma=$id_turma\"><center>$unidade</center></td>
		<td><a target=\"_blank\" href=\"gerar_boletins.php?id_turma=$id_turma\"><center>$polo</center></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

</table></div>
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