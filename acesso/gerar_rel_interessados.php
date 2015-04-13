<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
//GET DADOS DO FORMULARIO
$get_curso = $_GET["curso"];
$get_nivel = $_GET["nivel"];
$get_unidade = $_GET["unidade"];
$get_layout = $_GET["modelo"];
$get_modalidade = $_GET["modalidade"];
$get_inicio = $_GET["data_inicio"];
$get_fim = $_GET["data_fim"];
$get_confirmado = $_GET["confirmado"];

if(strstr($get_inicio, '/')==TRUE){
	$get_inicio = substr($get_inicio,6,4)."-".substr($get_inicio,3,2)."-".substr($get_inicio,0,2);
} else {
	$get_inicio = $get_inicio;
}

if(strstr($get_fim, '/')==TRUE){
	$get_fim = substr($get_fim,6,4)."-".substr($get_fim,3,2)."-".substr($get_fim,0,2);
} else {
	$get_fim = $get_fim;
}


if(trim($get_inicio)=="" || trim($get_fim)==""){
	echo "<script language=\"javascript\">
	alert('VOC&Ecirc; DEVE ESCOLHER UM PER&Iacute;ODO');
	history.back();
	</script>";
}
if($get_modalidade == 1){
	$modalidade = "PRESENCIAL";
}
if($get_modalidade == 2){
	$modalidade = "EAD";
}
if($get_modalidade == ""){
	$modalidade = "GERAL";
}

//começa a fazer os filtros
if($get_inicio == ""){
	$filtro_data = "WHERE ";
} else {
	$filtro_data = "WHERE (data_matricula BETWEEN '$get_inicio' AND '$get_fim') ";
}

if($get_curso == ""){
	$filtro_curso = "";
} else {
	$filtro_curso = "AND nome_curso LIKE '%$get_curso%' ";
}

if($get_nivel == ""){
	$filtro_nivel = "";
} else {
	$filtro_nivel = "AND curso_nivel LIKE '%$get_nivel%' ";
}

if($get_modalidade == ""){
	$filtro_modalidade = "";
} else {
	$filtro_modalidade = "AND modalidade LIKE '%$get_modalidade%' ";
}

if($get_unidade == ""){
	$filtro_unidade = "";
} else {
	$filtro_unidade = "AND unidade LIKE '%$get_unidade%' ";
}


if($get_confirmado == "N"){
	$filtro_pagos = "AND cpf NOT IN (select cpf FROM alunos) ";
} else {
	$filtro_pagos = "";
}


//GERA O WHERE DO FILTRO COMPLETO
$filtro_completo = $filtro_data.$filtro_curso.$filtro_nivel.$filtro_modalidade.$filtro_unidade.$filtro_pagos;
//PEGA DADOS DO FILTRO
$sql_filtro = mysql_query("SELECT * FROM ced_filtro WHERE id_filtro = $get_layout");
$dados_filtro = mysql_fetch_array($sql_filtro);
$filtro_tabela = $dados_filtro["tabela"];
$filtro_campos = $dados_filtro["campos"];
$filtro_cabecalho = $dados_filtro["cabecalho"];
$filtro_nome = $dados_filtro["layout"];
$filtro_ordem = $dados_filtro["ordem"];

//MONTA O FILTRO
$sql_query = "SELECT $filtro_campos FROM $filtro_tabela $filtro_completo $filtro_ordem";
$sql_relatorio = mysql_query($sql_query);
$total_resultados = mysql_num_rows($sql_relatorio);
$total_span=mysql_num_fields($sql_relatorio);
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
                              <b>Relat&oacute;rio: Banco de Interessados</b>
                          </header>
                          <div class="panel-body">
<table class="tabela_relatorio" width="100%" border="1">
<tr>
    <td valign="middle" align="center"><img src="images/logo-color.png"/></font></td>
    <td colspan="<?php echo $total_span-1;?>"><b><?php echo $get_nivel."</b>: ".$get_curso;?></b> <br />
        <b>Unidade:</b> <?php echo $get_unidade." / ".$get_polo; ?><br />
         <b>Modalidade:</b> <?php echo $modalidade ?><br />
    </td>
    </tr>
<tr> 
<td align="center" colspan="<?php echo $total_span;?>"><b style="font-size:14px"> <?php echo $filtro_nome;?><br />Esse relat&oacute;rio possui apenas inscri&ccedil;&otilde;es n&atilde;o confirmadas.</b>
</td></tr>
<?php //campo de texto livre
if($get_digitacao == 1){
	echo "<tr>
	<td align=\"center\" colspan=\"$total_span\"><textarea style=\"width:90%;line-height:20px;\" ></textarea></td>
	</tr>";
}
?>

<tr>
<?php //colunas

$i = 0;
while ($i < mysql_num_fields($sql_relatorio)){
	 $meta = mysql_fetch_field($sql_relatorio, $i);
	 
	 echo 
	 "<td align=\"center\" bgcolor=\"#C0C0C0\"><b>".$meta->name."</b></td>";
	 $i++;

}
?>
</tr>

<?php //dados das linhas

$sql_relatorio2 = mysql_query($sql_query);
$array_inscritos = "90099633";
while($dados_relatorio = mysql_fetch_array($sql_relatorio2)){
	echo "<tr>";
	$i2 =0;
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
	 $array_inscritos .= ",".$dados_relatorio["Código"];
	 echo 
	 "<td width=\"$campo_width\" align=\"$campo_align\">".$campo_funcao($dados_relatorio[$meta2->name])."</td>";
	 $i2++;
	}
	echo "</tr>";
}
?>
<tr>
<td colspan="<?php echo $total_span;?>"><?php echo $total_resultados;?> alunos encontrados.</td>
</tr>
</table>
<a rel="shadowbox" href="enviar_sms_interessados.php?codigos=<?php echo $array_inscritos;?>"><span class="label label-danger">Enviar SMS Matr&iacute;culas</span></a>
	
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