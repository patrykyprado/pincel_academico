<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$get_tipo = 0;
if($get_tipo == 0){
	$comp_sql_in = " NOT IN ";
} else {
	$comp_sql_in = " IN ";
}
if($_GET["grupo"]){
	$sql_grupo_ant = " WHERE grupo LIKE '%".$_GET["grupo"]."%' ";
	$sql_grupo = "AND ca.grupo LIKE '%".$_GET["grupo_ant"]."%' AND grupo NOT LIKE '%pronatec%'";
} else {
	echo "<script language=\"javascript\">
	alert('Selecione o grupo anterior e novo para comparação.');
	history.back();
	</script>;";
}

if($_GET["nivel_ant"]){
	$sql_nivel_ant = "AND nivel LIKE '%".$_GET["nivel_ant"]."%' ";
	$sql_nivel = "AND ca.nivel LIKE '%".$_GET["nivel_ant"]."%' ";
} else {
	$sql_nivel_ant = " ";
	$sql_nivel = "";
}

if($_GET["curso_ant"]){
	$sql_curso_ant = "AND curso LIKE '%".$_GET["curso_ant"]."%' ";
	$sql_curso = "AND ca.curso LIKE '%".$_GET["curso_ant"]."%'  ";
} else {
	$sql_curso_ant = " ";
	$sql_curso = "";
}

if($_GET["modulo_ant"]){
	$sql_modulo_ant = "AND modulo LIKE '%".$_GET["modulo_ant"]."%' ";
	$sql_modulo = "AND ca.modulo LIKE '%".$_GET["modulo_ant"]."%' ";
} else {
	$sql_modulo_ant = " ";
	$sql_modulo = "";
}

if($_GET["turno_ant"]){
	$sql_turno_ant = "AND turno LIKE '%".$_GET["turno_ant"]."%' ";
	$sql_turno = "AND ca.turno LIKE '%".$_GET["turno_ant"]."%' ";
} else {
	$sql_turno_ant = " ";
	$sql_turno = "";
}

if($_GET["unidade_ant"]){
	$sql_unidade_ant = "AND unidade LIKE '%".$_GET["unidade_ant"]."%' ";
	$sql_unidade = "AND ca.unidade LIKE '%".$_GET["unidade_ant"]."%' ";
} else {
	$sql_unidade_ant = " ";
	$sql_unidade = "";
}

if($_GET["polo_ant"]){
	$sql_polo_ant = "AND polo LIKE '%".$_GET["polo_ant"]."%' ";
	$sql_polo = "AND ca.polo LIKE '%".$_GET["polo_ant"]."%' ";
} else {
	$sql_polo_ant = " ";
	$sql_polo = "";
}

$sql_completo = "SELECT matricula FROM curso_aluno ".$sql_grupo_ant.$sql_nivel_ant.$sql_curso_ant.$sql_turno_ant.$sql_unidade_ant.$sql_polo_ant;

$sql_alunos_ant = mysql_query($sql_completo);
$total_alunos_ant = mysql_num_rows($sql_alunos_ant);
if($total_alunos_ant >=1){
	$array_alunos_ant = "";	
	while($dados_alunos_ant = mysql_fetch_array($sql_alunos_ant)){
		$matricula_ant = $dados_alunos_ant["matricula"];
		if($total_alunos_ant == 1){
			$array_alunos_ant .= $matricula_ant;
		} else {
			$array_alunos_ant .= $matricula_ant.",";	
		}
		$total_alunos_ant -=1;
		
	}
	
}

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
                          <div class="panel-body">
                          
<BR>


<?php
$sql_completo2 = "SELECT DISTINCT alu.codigo, alu.nome, alu.email, alu.telefone, alu.celular 
FROM alunos alu INNER JOIN curso_aluno ca
ON ca.matricula = alu.codigo
WHERE alu.codigo $comp_sql_in ($array_alunos_ant) AND alu.codigo NOT IN (SELECT matricula FROM ocorrencias WHERE n_ocorrencia = 1 OR n_ocorrencia = 2) $sql_grupo $sql_nivel $sql_curso $sql_modulo $sql_turno $sql_unidade $sql_polo AND modulo < 3 ORDER BY TRIM(alu.nome)";
$sql_alunos = mysql_query($sql_completo2);
$total_resultado = mysql_num_rows($sql_alunos);
if($total_resultado == 0){
	echo "<script language=\"javascript\">
	alert('Nenhum resultado encontrado!');
	history.back();
	</script>";	
} else {
	echo "
	
	<table border=\"1\" width=\"100%\">
	<tr bgcolor=\"#E0E0E0\">
		<td align=\"center\"><b>Matrícula</b></td>
		<td align=\"center\"><b>Nome</b></td>
		<td align=\"center\"><b>E-mail</b></td>
		<td align=\"center\"><b>Telefone</b></td>
		<td align=\"center\"><b>Celular</b></td>
	</tr>";
	$array_alunos = "";
	$total_array = $total_resultado;
	while($dados_alunos = mysql_fetch_array($sql_alunos)){
		$aluno_matricula = $dados_alunos["codigo"];
		$aluno_nome = $dados_alunos["nome"];
		$aluno_email = $dados_alunos["email"];
		$aluno_telefone = $dados_alunos["telefone"];
		$aluno_celular = $dados_alunos["celular"];
		if($total_array == 1){
			$array_alunos .= $aluno_matricula;	
		} else {
			$array_alunos .= $aluno_matricula.",";	
		}
		$total_array -=1;
		echo "
		<tr>
			<td align=\"center\"><b>$aluno_matricula</b></td>
			<td>$aluno_nome</td>
			<td>$aluno_email</td>
			<td align=\"center\">$aluno_telefone</td>
			<td align=\"center\">$aluno_celular</td>
		</tr>";			
	}
	
	echo "
	<tr>
		<td colspan=\"5\">Resultados encontrados: $total_resultado alunos</td>
	</tr>
	</table>
	<a rel=\"shadowbox\" href=\"enviar_sms_rematricula.php?codigos=$array_alunos\"><span class=\"label label-danger\">Enviar Aviso de Rematrícula (SMS)</span></a>
	";
	
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