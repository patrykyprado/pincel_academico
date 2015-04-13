<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$get_unidade = $_GET['unidade'];
$get_grupo = $_GET['grupo'];
$get_modulo = $_GET['modulo'];
$get_modelo = $_GET['modelo'];
$get_nivel = $_GET['nivel'];
$get_turno = $_GET['turno'];


if($get_turno == ""){
	$filtro_turno = "";
} else {
	$filtro_turno = " AND turno LIKE '%$get_turno%' ";
}

if($get_grupo == ""){
	$filtro_grupo = "WHERE ";
} else {
	$filtro_grupo = "WHERE grupo LIKE '$get_grupo' ";
}

if($get_modulo == ""){
	$filtro_modulo = "";
} else {
	$filtro_modulo = "AND modulo = '$get_modulo' ";
}

if($get_unidade == ""){
	$filtro_unidade = "";
} else {
	$filtro_unidade = "AND unidade LIKE '%$get_unidade%' ";
}

if($get_nivel == ""){
	$filtro_nivel = "";
} else {
	$filtro_nivel = "AND nivel LIKE '%$get_nivel%' ";
}
//gera o filtro completo
$filtro_completo = $filtro_grupo.$filtro_modulo.$filtro_unidade.$filtro_nivel.$filtro_turno;

//PEGA DADOS DO FILTRO
$sql_filtro = mysql_query("SELECT * FROM ced_filtro WHERE id_filtro = $get_modelo");
$dados_filtro = mysql_fetch_array($sql_filtro);
$filtro_tabela = $dados_filtro["tabela"];
$filtro_campos = $dados_filtro["campos"];
$filtro_cabecalho = $dados_filtro["cabecalho"];
$filtro_nome = $dados_filtro["layout"];
$filtro_ordem = $dados_filtro["ordem"];
$filtro_groupby = $dados_filtro["groupby"];

$sql = "SELECT $filtro_campos FROM $filtro_tabela $filtro_completo $filtro_groupby $filtro_ordem";
$sql_grafico = mysql_query($sql);

$total_span=mysql_num_fields($sql_grafico);
$sql2 = 0;//mysql_query("SELECT distinct codigo, curso FROM geral WHERE unidade LIKE '%$unidade%' AND grupo LIKE '%$grupo%'  AND modulo = '$modulo' AND nivel LIKE 'CURSO TECNICO'");
$qtd_sql = 0;//mysql_num_rows($sql2);
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
                              <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([

<?php
if($get_modelo ==6){
	$total_parcial = 0;
    while ($dados_grafico = mysql_fetch_array($sql_grafico)) {
        // enquanto houverem resultados...
		$curso          = format_curso($dados_grafico["Curso"]);
		$qtd_grupo          = $dados_grafico["Quantidade"];
		$qtd_total = $total_parcial + $qtd_grupo;
		$total_parcial = $qtd_total;
        echo "
		['$curso', $qtd_grupo],
		\n";
		
        // exibir a coluna nome e a coluna email
    }
}

if($get_modelo ==7){
	$total_parcial = 0;
    while ($dados_grafico = mysql_fetch_array($sql_grafico)) {
        // enquanto houverem resultados...
		$unidade          = format_curso($dados_grafico["Unidade"]);
		$qtd_grupo          = $dados_grafico["Quantidade"];
		$qtd_total = $total_parcial + $qtd_grupo;
		$total_parcial = $qtd_total;
        echo "
		['$unidade', $qtd_grupo],
		\n";
		
        // exibir a coluna nome e a coluna email
    }
}
if($get_modelo ==10){
	$total_parcial = 0;
    while ($dados_grafico = mysql_fetch_array($sql_grafico)) {
        // enquanto houverem resultados...
		$polo          = ($dados_grafico["Polo"]);
		$qtd_grupo          = $dados_grafico["Quantidade"];
		$qtd_total = $total_parcial + $qtd_grupo;
		$total_parcial = $qtd_total;
        echo "
		['$polo', $qtd_grupo],
		\n";
		
        // exibir a coluna nome e a coluna email
    }
}
?>
       
        ]);

        // Set chart options
        var options = {'title':'CEDTEC - MATRÍCULAS (<?PHP echo $get_nivel;?>): <?PHP echo $get_unidade;?> - <?php echo $get_grupo;?>',
                       'width':600,
                       'height':'330'};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>


    <!--Div that will hold the pie chart-->
    <div id="chart_div" align="center"> </div>
<div style="z-index:9999999">
<table class="full_table_list2" width="auto" align="center" border="1">
<tr> 
<td align="center" colspan="<?php echo $total_span;?>"><b style="font-size:14px"> <?php echo $filtro_nome;?></b>
</td></tr>

<tr>
<?php //colunas

$i = 0;
while ($i < mysql_num_fields($sql_grafico)){
	 $meta = mysql_fetch_field($sql_grafico, $i);
	 
	 echo 
	 "<td align=\"center\" bgcolor=\"#C0C0C0\"><b>".$meta->name."</b></td>";
	 $i++;

}
?>
</tr>

<?php //dados das linhas

$sql_grafico2 = mysql_query($sql);
while($dados_grafico2 = mysql_fetch_array($sql_grafico2)){
	echo "<tr>";
	$i2 =0;
	$total_parcial = 0;
	while ($i2 < mysql_num_fields($sql_grafico2)){
	 $meta2 = mysql_fetch_field($sql_grafico2, $i2);
	 //configurações do campo
	 
	 echo 
	 "<td align=\"center\">".format_curso($dados_grafico2[$meta2->name])."</td>";

	 $i2++;
	}
	echo "</tr>";
}
?>
<tr>
<td colspan="<?php echo $total_span;?>"><b>Total:</b> <?php echo $qtd_total;?></td>
</tr>
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