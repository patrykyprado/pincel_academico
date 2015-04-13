
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!--state overview start-->
              <div class="row state-overview">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">

                          <div class="symbol red">
                              <i class="fa fa-user"></i>
                          </div>
                          <div class="value">
                          <a rel="shadowbox" href="usuarios_online.php">
                              <h1 class="usuarios_online">
                                 0
                            </h1>
                              <p>Usu&aacute;rios Online</p>
                              </a>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="fa fa-group"></i>
                          </div>
                          <div class="value">
                              <h1 class="alunos_ativos">
                                  0
                              </h1>
                              <p>Alunos Enturmados</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="fa fa-plus-circle"></i>
                          </div>
                          <div class="value">
                          <a rel="shadowbox" href="novas_matriculas.php">
                              <h1 class="novas_matriculas">
                                  0
                              </h1>
                              <p>Novas Matr&iacute;culas</p>
                          </a>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="fa fa-bar-chart-o"></i>
                          </div>
                          <div class="value">
                              <h1 class="total_acessos">
                                  0
                              </h1>
                              <p>Total de Acessos</p>
                          </div>
                      </section>
                  </div>
              </div>
              <!--state overview end-->


              <div class="row">
                  <div class="col-lg-12">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Grupo de Matr&iacute;culas</h1>
                              </div>
                          </div>
                          <?php
$get_unidade = $user_unidade;
$get_grupo = '2015/01';
$get_modulo = 1;
$get_modelo = 7;//$_GET['modelo'];
$get_nivel = "";

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
$filtro_completo = $filtro_grupo.$filtro_modulo.$filtro_unidade.$filtro_nivel;

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
        var options = {'title':'CEDTEC - MATRÍCULAS: <?PHP echo $get_unidade;?> - <?php echo $get_grupo;?>',
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

<?php //colunas

$i = 0;
if(mysql_num_rows($sql_grafico)>=1){
	echo "<table class=\"table table-hover\" width=\"auto\" align=\"center\" border=\"1\">
<tr> 
<td align=\"center\" colspan=\"$total_span\"><b style=\"font-size:14px\">$filtro_nome</b>
</td></tr>

<tr>";
}
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
if(mysql_num_rows($sql_grafico)>=1){
	echo "<tr>
	<td colspan=\"$total_span\"><b>Total:</b> $qtd_total</td>
	</tr>
	</table>";
}
?>

                          

                      </section>
                      <!--work progress end-->
                  </div>
              
              
                  <div class="col-lg-12">
                      <section class="panel">
                      <div class="panel-heading">
                      <b>Avisos Importantes</b>
                      </div>
                          <div class="panel-body">
<?php
$sql_avisos = mysql_query("SELECT * FROM avisos WHERE nivel_user = $user_nivel OR nivel_user = 0 ORDER BY data_hora DESC LIMIT 3");
if(mysql_num_rows($sql_avisos)==0){
	echo "<center>Não há nenhum aviso.</center>";	
} else {
	$contar_avisos = 0;
	while($dados_avisos = mysql_fetch_array($sql_avisos)){
		$aviso_id = "aviso_".$dados_avisos["id_aviso"];
		$aviso_titulo = $dados_avisos["titulo_aviso"];	
		$aviso_texto = $dados_avisos["aviso"];
		$aviso_data = format_data_hora($dados_avisos["data_hora"]);
		if($contar_avisos == 0){
			$aviso_status = "in";	
		} else {
			$aviso_status = "";
		}
		$contar_avisos +=1;
		echo "
		<div class=\"panel-heading-aviso\">
                                  <h4 class=\"panel-title\">
                                      <a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#$aviso_id\">
                                          $aviso_titulo
                                      </a><font color=\"#FFF\" size=\"-3\"> - $aviso_data</font>
                                  </h4>
                              </div>
                              <div id=\"$aviso_id\" class=\"panel-collapse collapse $aviso_status\">
                                  <div class=\"panel-body-aviso\">
                                      $aviso_texto
                                  </div>
                              </div>
		
		";
		
	}
}
?>
    </div>
                         
                      </section>
                  </div>

              </div>

                      </section>
                      <!--weather statement end-->
                  </div>
              </div>

          </section>
      </section>