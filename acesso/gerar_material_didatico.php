<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

if(isset($_GET['nivel'])){
	$filtro_nivel = " AND ca.nivel LIKE '%".$_GET['nivel']."%'";
} else {
	$filtro_nivel = "";
}
if(isset($_GET['curso'])){
	$filtro_curso = " AND ca.curso LIKE '%".$_GET['curso']."%'";
} else {
	$filtro_curso = "";
}
if(isset($_GET['modulo'])){
	$filtro_modulo = " AND ca.modulo LIKE '%".$_GET['modulo']."%'";
} else {
	$filtro_modulo = "";
}
if(isset($_GET['unidade'])){
	$filtro_unidade = " AND ca.unidade LIKE '%".$_GET['unidade']."%'";
} else {
	$filtro_unidade = "";
}

if(isset($_GET['grupo'])){
	$filtro_grupo = " AND ca.grupo LIKE '%".$_GET['grupo']."%'";
} else {
	$filtro_grupo = "";
}


$filtro_completo = $filtro_grupo.$filtro_nivel.$filtro_curso.$filtro_modulo.$filtro_unidade;
$sql_completo = "
SELECT DISTINCT alu.codigo AS Matrícula, alu.nome AS Nome, ca.nivel AS Nível, ca.curso AS Curso, '' AS Assinatura
FROM ced_compras_pagseguro ccp
INNER JOIN alunos alu
ON ccp.id_cliente = alu.codigo
INNER JOIN curso_aluno ca
ON alu.codigo = ca.matricula
WHERE ccp.situacao = 2 $filtro_completo
UNION 
SELECT alu.codigo AS Matrícula, alu.nome AS Nome, ca.nivel AS Nível, ca.curso AS Curso, '' AS Assinatura
FROM titulos tit
INNER JOIN alunos alu
ON alu.codigo = tit.cliente_fornecedor
INNER JOIN curso_aluno ca
ON ca.matricula = alu.codigo
WHERE tit.conta LIKE '%LT%' AND tit.descricao LIKE '%didatico%' AND tit.data_pagto >= '2014-11-01' AND tit.parcela = 1
$filtro_completo
ORDER BY Nome
";
$sql_material = mysql_query($sql_completo);
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
                              <b>Relat&oacute;rio: Material Did&aacute;tico</b>
                          </header>
                          <div class="panel-body">
                          <?php
if(mysql_num_rows($sql_material)>=1){
	echo "<table border=\"1\" width=\"100%\">
	<tr bgcolor=\"#D4D4D4\">
		<td align=\"center\"><b>Matrícula</b></td>
		<td align=\"center\"><b>Nome</b></td>
		<td align=\"center\"><b>Nível</b></td>
		<td align=\"center\"><b>Curso</b></td>
		<td align=\"center\" width=\"120px\"><b>Assinatura</b></td>
	</tr>";
	while($dados_material = mysql_fetch_array($sql_material)){
		$material_matricula = $dados_material['Matrícula'];
		$material_nome = format_curso($dados_material['Nome']);
		$material_nivel = format_curso($dados_material['Nível']);
		$material_curso = format_curso($dados_material['Curso']);	
		$material_assinatura = $dados_material['Assinatura'];	
		echo "
	<tr>
		<td align=\"center\">$material_matricula</td>
		<td align=\"\"><b>$material_nome</td>
		<td align=\"\">$material_nivel</td>
		<td align=\"\">$material_curso</td>
		<td align=\"center\"></td>
	</tr>";
	}
	echo "</table>";
}
						  ?>

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