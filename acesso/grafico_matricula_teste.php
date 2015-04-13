<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$inicio_mes = date("Y-m-")."01";
$fim_mes = date("Y-m-t");
$mes_atual = format_mes(date("m"));
$sql_matriculas_novas = mysql_query("SELECT Dtpaga AS data_matricula, COUNT(codigo) AS total_matriculas  FROM geral 
WHERE unidade LIKE '%$user_unidade%' AND (Dtpaga BETWEEN '$inicio_mes' AND '$fim_mes')
GROUP BY Dtpaga");
$matriculas_novas = 0;
$total_matriculas_novas = mysql_num_rows($sql_matriculas_novas);
$x_novas = $total_matriculas_novas;
$total_novas = 0;
while($dados_matriculas_novas =mysql_fetch_array($sql_matriculas_novas)){
	$total_novas += $dados_matriculas_novas["total_matriculas"];
	if($x_novas == 1){ 
		$matriculas_novas .= $dados_matriculas_novas["total_matriculas"];
	} else {
		$matriculas_novas .= ",".$dados_matriculas_novas["total_matriculas"];
	}
	
}

$sql_matriculas_anteriores = mysql_query("SELECT Dtpaga AS data_matricula, COUNT(codigo) AS total_matriculas  FROM geral 
WHERE unidade LIKE '%$user_unidade%' AND (Dtpaga BETWEEN '2014-01-01' AND '2014-01-31') AND modulo = 1
GROUP BY Dtpaga");
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <!--new earning start-->
                      <div class="panel terques-chart">
                          <div class="panel-body chart-texture">
                              <div class="chart">
                                  <div class="heading">
                                      <span>Tivemos <?php echo $total_novas;?> novas matrículas no mês de <?php echo $mes_atual;?></span>
                                      <strong><?php echo date("Y");?></strong>
                                  </div>
                                  <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[<?php echo $matriculas_novas;?>]"></div>
                              </div>
                          </div>
                          <div class="chart-tittle">
                              <span class="title">Novas Matrículas</span>
                              <span class="value">
                                  <a href="#" class="active">CEDTEC</a>
                                  |
                                  <a href="#">Referal</a>
                                  |
                                  <a href="#">Online</a>
                              </span>
                          </div>
                      </div>
                      <!--new earning end-->
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
<!--script for this page-->
    <script src="js/sparkline-chart.js"></script>
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