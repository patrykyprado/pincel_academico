<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$ano_ref = $_GET['ano_ref'];
//GET
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
$sql_turmas = mysql_query($sql_completo);
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
                              <b>Boletos / Turma</b>
                          </header>
                          <div class="panel-body">
<table class="table table-hover" border="1" align="center">
	<tr>
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

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
$count = mysql_num_rows($sql_turmas);

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    alert('NENHUM RESULTADO ENCONTRADO');
	history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados = mysql_fetch_array($sql_turmas)) {
        // enquanto houverem resultados...
		$id_turma	   = $dados["id_turma"];
		$codigo	   = $dados["cod_turma"];
		$modulo	   = $dados["modulo"];
		$grupo	   = $dados["grupo"];
		$nivel	   = $dados["nivel"];
		$curso	   = format_curso($dados["curso"]);
		$unidade	   = $dados["unidade"];
		$polo	   = $dados["polo"];
		$turno	   = strtoupper($dados["turno"]);
        echo "
	<tr>
		<td><a target=\"_blank\" href=\"gerar_boleto_turma.php?id_turma=$id_turma&ano_ref=$ano_ref\"><b><center>$codigo</b></center></a></td>
		<td><a target=\"_blank\" href=\"gerar_boleto_turma.php?id_turma=$id_turma&ano_ref=$ano_ref\">$nivel</td>
		<td><a target=\"_blank\" href=\"gerar_boleto_turma.php?id_turma=$id_turma&ano_ref=$ano_ref\"><center>$curso</center></td>
		<td><a target=\"_blank\" href=\"gerar_boleto_turma.php?id_turma=$id_turma&ano_ref=$ano_ref\"><center>$modulo</center></td>
		<td><a target=\"_blank\" href=\"gerar_boleto_turma.php?id_turma=$id_turma&ano_ref=$ano_ref\"><center>$turno</center></td>
		<td><a target=\"_blank\" href=\"gerar_boleto_turma.php?id_turma=$id_turma&ano_ref=$ano_ref\"><center>$grupo</center></td>
		<td><a target=\"_blank\" href=\"gerar_boleto_turma.php?id_turma=$id_turma&ano_ref=$ano_ref\"><center>$unidade</center></td>
		<td><a target=\"_blank\" href=\"gerar_boleto_turma.php?id_turma=$id_turma&ano_ref=$ano_ref\"><center>$polo</center></td>
		</tr>
		\n";
        // exibir a coluna nome e a coluna email
    }

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
