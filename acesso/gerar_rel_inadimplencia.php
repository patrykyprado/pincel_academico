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
                              <b>Relat&oacute;rio: Inadimplentes</b>
                          </header>
                          <div class="panel-body">
<?php
$sql_exec = "SELECT DISTINCT gt.codigo,a.nome,gt.vencimento, gt.id_titulo, gt.parcela, gt.valor, ca.grupo, ca.unidade, ca.polo FROM geral_titulos gt
INNER JOIN curso_aluno ca
ON ca.matricula = gt.codigo
INNER JOIN alunos a
ON a.codigo = ca.matricula
WHERE gt.vencimento < now() AND (gt.data_pagto IS NULL OR gt.data_pagto LIKE '') AND gt.tipo_titulo = 2 AND gt.status = 0";

$get_nivel = $_GET["nivel"];
$get_curso = $_GET["curso"];
$get_modulo = $_GET["modulo"];
$get_turno = $_GET["turno"];
$get_unidade = $_GET["unidade"];
$get_polo = $_GET["polo"];
$get_grupo = $_GET["grupo"];
$get_inicio = $_GET["data_inicio"];
$get_fim = $_GET["data_fim"];

if($get_nivel == ""){
	$filtro_nivel = "";
} else {
	$filtro_nivel = " AND ca.nivel LIKE '%$get_nivel%'";
}

if($get_curso == ""){
	$filtro_curso = "";
} else {
	$filtro_curso = " AND ca.curso LIKE '%$get_curso%'";
}

if($get_modulo == ""){
	$filtro_modulo = "";
} else {
	$filtro_modulo = " AND ca.modulo LIKE '%$get_modulo%'";
}

if($get_turno == ""){
	$filtro_turno = "";
} else {
	$filtro_turno = " AND ca.turno LIKE '%$get_turno%'";
}

if($get_unidade == ""){
	$filtro_unidade = "";
	$filtro_conta = "";
} else {
	$filtro_unidade = "";
	$filtro_conta = " AND (gt.conta_nome LIKE '%get_unidade%' OR gt.conta_nome LIKE '%pertel%')";
}

if($get_polo == ""){
	$filtro_polo = "";
} else {
	$filtro_polo = " AND ca.polo LIKE '%$get_polo%'";
}

if($get_grupo == ""){
	$filtro_grupo = "";
} else {
	$filtro_grupo = " AND ca.grupo LIKE '%$get_grupo%'";
}

if($get_inicio == ""&&$get_fim ==""){
	$filtro_data = "";
} else {
	$filtro_data = " AND (gt.vencimento BETWEEN '$get_inicio' AND '$get_fim')";
}

$order_by = " ORDER BY a.nome, gt.vencimento";

//monta a query do filtro selecionado
$filtro_final = $sql_exec.$filtro_nivel.$filtro_curso.$filtro_modulo.$filtro_unidade.$filtro_polo.$filtro_turno.$filtro_grupo.$filtro_conta.$filtro_data.$order_by;
$sql_inad = mysql_query($filtro_final);
if(mysql_num_rows($sql_inad)==0){
	echo "<script language=\"javascript\">
	alert('Nenhum resultado encontrado!');
	</script>";
	echo $filtro_final;	
} else {
	echo "<table class=\"full_table_list\" width=\"100%\" border=\"1\">
	<tr>
	<td valign=\"middle\" align=\"center\"><img src=\"images/logo-color.png\"/></font></td>
    <td colspan=\"4\"><b>$get_nivel: $get_curso</b> <br />
    	<b>Ano / M&oacute;dulo: </b>$get_modulo<br />
    	<b>Turno:</b> $get_turno<br />
        <b>Grupo:</b> $get_grupo<br />
        <b>Unidade:</b> $get_unidade / $get_polo<br />
    </td>
	</tr>
	<tr>
		<td colspan=\"5\" bgcolor=\"#D5D5D5\" align=\"center\"><font size=\"+1\">Alunos Inadimplentes</font></td>
	</tr>
	<tr>
	<td align=\"center\"><b>Matrícula</b></td>
	<td align=\"center\"><b>Nome</b></td>
	<td align=\"center\"><b>Parcela</b></td>
	<td align=\"center\"><b>Vencimento</b></td>
	<td align=\"center\"><b>Valor</b></td>
	<tr>
	";
	$valor_total = 0;
	while($dados_inad = mysql_fetch_array($sql_inad)){
		$matricula = $dados_inad["codigo"];
		$nome = $dados_inad["nome"];
		$parcela = $dados_inad["parcela"];
		$vencimento = format_data($dados_inad["vencimento"]);
		$valor = format_valor($dados_inad["valor"]);
		echo "<tr>
		<td align=\"center\">$matricula</td>
		<td align=\"left\">$nome</td>
		<td align=\"center\"><b>$parcela</b></td>
		<td align=\"center\"><b>$vencimento</b></td>
		<td align=\"right\">R$ $valor</td></tr>";
		$valor_total += $dados_inad["valor"];
	}

	echo "<tr>
		<td align=\"right\" colspan=\"4\"><b>Valor Total:</b></td>
		<td align=\"right\">R$ ".format_valor($valor_total)."</td></tr>
		</table>";
}
?>
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
  