<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$re    = mysql_query("select count(*) as total from curso_aluno WHERE matricula = $user_usuario" );	
$total = 1;

if($total == 1) {
	$re2    = mysql_query("select * from curso_aluno WHERE matricula = $user_usuario ORDER BY modulo DESC");
	$dados = mysql_fetch_array($re);	
	$pesq = mysql_query("select * from curso_aluno WHERE matricula = $user_usuario  ORDER BY modulo DESC" );
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
                              Requerimento de Rematr&iacute;cula
                          </header>
                          <div class="panel-body" align="center">
<table width="100%" border="1" align="center">
  <tr> 
  <td colspan="7" bgcolor="#CCCCCC"><center>
    <strong>Cursos Contratados</strong>
  </center></td>
  </tr>
  <tr>
    <td align="center"><b>ANO / GRUPO</b></td>
    <td align="center"><b>N&Iacute;VEL</b></td>
    <td align="center"><b>CURSO</b></td>
    <td align="center"><b>M&Oacute;DULO</b></td>
    <td align="center"><b>UNIDADE</b></td>
    <td align="center"><b>POLO</b></td>
    <td align="center"><b>A&Ccedil;&Atilde;O</b></td>
  </tr>
<tr>
<?php 
while($l = mysql_fetch_array($re2)){
	$codigo = $l["matricula"];
	$grupo =  ($l["grupo"]);
	$nivel =  format_curso($l["nivel"]);
	$curso =  format_curso($l["curso"]);	
	$modulo =  $l["modulo"];	
	$ref_curso =  $l["ref_id"];	
	$unidade = trim($l["unidade"]);
	$polo = trim($l["polo"]);
	if($unidade == "EAD"){
		$link = "a_aditivo.php?id=$codigo&ref=$ref_curso";	
	} else {
		$link = "a_rematricular2.php?id=$codigo&ref=$ref_curso";}
	echo "
	<td align=\"center\">$grupo</td>
	<td align=\"center\">$nivel</td>
	<td align=\"center\">$curso</td>
	<td align=\"center\">$modulo</td>
	<td align=\"center\">$unidade</td>
	<td align=\"center\">$polo</td>
	<td align=\"center\"><a rel=\"shadowbox\" href=\"$link\">[REMATRICULAR]</a></td><tr>";
}
?>

</table>
</div>
                          </div>
                      </section>
                  </div>
                  
              </div>
              <!-- page end-->
                  
              </div>
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


