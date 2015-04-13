<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

//GET DADOS DO FORMULARIO
$get_nivel = $_GET["nivel"];
$get_curso = $_GET["curso"];
$get_modulo = $_GET["modulo"];
$get_grupo = $_GET["grupo"];
$get_turno = $_GET["turno"];
$get_unidade = $_GET["unidade"];
$get_polo = $_GET["polo"];


//começa a fazer os filtros
if($get_grupo == ""){
	$filtro_grupo = "";
} else {
	$filtro_grupo = " AND ct.grupo LIKE '$get_grupo' ";
}

if($get_modulo == ""){
	$filtro_modulo = " ";
} else {
	$filtro_modulo = "AND ct.modulo = $get_modulo ";
}

if($get_nivel == ""){
	$filtro_nivel = " ";
} else {
	$filtro_nivel = "AND ct.nivel LIKE '%$get_nivel%' ";
}

if($get_curso == ""){
	$filtro_curso = " ";
} else {
	$filtro_curso = "AND ct.curso LIKE '%$get_curso%' ";
}

if($get_turno == ""){
	$filtro_turno = " ";
} else {
	$filtro_turno = "AND ct.turno LIKE '%$get_turno%' ";
}

if($get_unidade == ""){
	if($user_unidade == ""){
		$filtro_unidade = "";
	} else {
		$filtro_unidade = " AND ct.unidade LIKE '%$user_unidade%' ";
	}
} else {
	$filtro_unidade = "AND ct.unidade LIKE '%$get_unidade%' ";
}

if($get_polo == ""){
	$filtro_polo = " ";
} else {
	$filtro_polo = "AND ct.polo LIKE '%$get_polo%' ";
}


//GERA O WHERE DO FILTRO COMPLETO
$filtro_completo = $filtro_grupo.$filtro_modulo.$filtro_nivel.$filtro_curso.$filtro_turno.$filtro_unidade.$filtro_polo;
$sql = "SELECT ct.id_turma, ct.cod_turma as 'Cod. Turma', ct.grupo as Grupo, ct.unidade as Unidade, ct.polo as Polo, ct.turno as Turno,
ct.nivel as Nível, ct.curso as Curso, ct.modulo as Módulo, COUNT(DISTINCT cta.matricula) as Total 
FROM ced_turma ct
INNER JOIN ced_turma_aluno cta
ON cta.id_turma = ct.id_turma
WHERE now() BETWEEN ct.inicio AND ct.fim
 $filtro_completo GROUP BY cta.id_turma ORDER BY ct.grupo, ct.nivel, ct.curso, ct.modulo";
$sql_relatorio = mysql_query($sql);
$total_span = mysql_num_fields($sql_relatorio);
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
                              <b>Relat&oacute;rio: Turmas Ativas</b>
                          </header>
                          <div class="panel-body">
<div class="filtro"><center><a href="rel_turmas_ativas.php">[NOVA CONSULTA]</a></center></div>
<table class="full_table_list" style="font-size:10px; line-height:20px;" width="100%" border="1">
<tr>
    <td valign="middle" align="center"><img src="images/logo-color.png"/></font></td>
    <td colspan="<?php echo $total_span-1;?>"><b><?php echo $get_nivel."</b>: ".$get_curso;?></b> <br />
    	<b>Ano / M&oacute;dulo: </b><?php echo $get_modulo; ?>&ordm;<br />
    	<b>Turno:</b> <?php echo $get_turno; ?><br />
        <b>Grupo:</b> <?php echo $get_grupo; ?><br />
        <b>Unidade:</b> <?php echo $get_unidade." / ".$get_polo; ?><br />
    </td>
    </tr>
<tr> 
<td align="center" colspan="<?php echo $total_span;?>"><b style="font-size:14px"> Relat&oacute;rio - Alunos Ativos / Turma</b>
</td></tr>

<tr>
<?php //colunas

$i = 1;
while ($i < mysql_num_fields($sql_relatorio)){
	 $meta = mysql_fetch_field($sql_relatorio, $i);
	 
	 echo 
	 "<td align=\"center\" bgcolor=\"#C0C0C0\"><b>".$meta->name."</b></td>";
	 $i++;

}
?>
</tr>

<?php //dados das linhas

$sql_relatorio2 = mysql_query($sql);
while($dados_relatorio = mysql_fetch_array($sql_relatorio2)){
	echo "<tr>";
	$i2 =1;
	while ($i2 < mysql_num_fields($sql_relatorio2)){
	 $meta2 = mysql_fetch_field($sql_relatorio2, $i2);
	 //configurações do campo
	 $campo_width="auto";
	 $campo_align="";
	 $campo_funcao="not";
	 $sql_campo=mysql_query(("SELECT * FROM config_campos WHERE campo LIKE '%".$meta2->name."%'"));
	 if(mysql_num_rows($sql_campo)==1){
	 	$dados_campo = mysql_fetch_array($sql_campo);
	 	$campo_width = $dados_campo["width"];
		$campo_align= $dados_campo["align"];
		$campo_funcao= $dados_campo["funcao"];
	 }
	 
	 echo 
	 "<td width=\"$campo_width\" align=\"$campo_align\">".$campo_funcao($dados_relatorio[$meta2->name])."</td>";
	 $i2++;
	}
	echo "</tr>";
}
?>
<tr>
<td colspan="<?php echo $total_span;?>">
<table border="1" width="100%" style="font-size:10px">
	<tr bgcolor="#FFF6AA">
        <td align="center" bgcolor="#FFF6AA"><b>N&iacute;vel</b></td>
        <td align="center" bgcolor="#FFF6AA"><b>Curso</b></td>
        <td align="center" bgcolor="#FFF6AA"><b>M&oacute;dulo</b></td>
        <td align="center" bgcolor="#FFF6AA"><b>Total</b></td>
    </tr>
<?php 
$sql_curso_total = mysql_query("SELECT ct.unidade as Unidade, ct.polo as Polo, 
ct.nivel as Nível, ct.curso as Curso, ct.modulo as Módulo, COUNT(DISTINCT cta.matricula) as Total 
FROM ced_turma ct
INNER JOIN ced_turma_aluno cta
ON cta.id_turma = ct.id_turma
WHERE (now() BETWEEN ct.inicio AND ct.fim) $filtro_completo 
GROUP BY ct.nivel, ct.curso, ct.modulo
");
$total_final = 0;
while($dados_curso_total = mysql_fetch_array($sql_curso_total)){
	$exib_unidade = $dados_curso_total["Unidade"];
	$exib_polo = $dados_curso_total["Polo"];
	$exib_nivel = $dados_curso_total["Nível"];
	$exib_curso = strtoupper($dados_curso_total["Curso"]);
	$exib_modulo = $dados_curso_total["Módulo"];
	$exib_total = $dados_curso_total["Total"];
	$total_final +=$exib_total;
	echo "
	<tr bgcolor=\"#FFF6AA\">
        <td bgcolor=\"#FFF6AA\">$exib_nivel</td>
        <td bgcolor=\"#FFF6AA\">$exib_curso</td>
        <td bgcolor=\"#FFF6AA\" align=\"center\">$exib_modulo</td>
        <td bgcolor=\"#FFF6AA\" align=\"center\">$exib_total</td>
    </tr>
	";
}
?>
	<tr bgcolor="#F2F9AA">
    	<td colspan="3" align="right">Total:</td>
        <td align="center"><?php echo $total_final;?></td>
    </tr>
</table>
</td>
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