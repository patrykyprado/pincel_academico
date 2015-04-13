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
                              <b>Pesquisa de Notas Moodle</b>
                          </header>
                          <div class="panel-body">
<form action="#" method="post">
Nome / Matr&iacute;cula: <input type="text" name="busca"> <input type="submit" value="Pesquisar">
</form>
<hr>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	include('includes/conectar_md.php');
	$busca = $_POST["busca"];
	$sql_nota = mysql_query("SELECT * FROM nota2 WHERE codaluno LIKE '%$busca%' OR nome LIKE '%$busca%' ORDER BY nome, sobrenome");
	if(mysql_num_rows($sql_nota)==0){
		echo "<center>Nenhum resultado encontrado.</center>";
	} else {
		echo "<table border=\"1\" width=\"100%\">
		<tr bgcolor=\"#CCCC\">
			<td align=\"center\"><b>Matrícula</b></td>
			<td align=\"center\"><b>Nome</b></td>
			<td align=\"center\"><b>Disciplina</b></td>
			<td align=\"center\"><b>Nota</b></td>
		</tr>
		";
		while($dados_nota = mysql_fetch_array($sql_nota)){
			$matricula = $dados_nota["codaluno"];
			$nome = $dados_nota["nome"]." ".$dados_nota["sobrenome"];
			$disciplina = $dados_nota["curso"];
			$nota = format_valor($dados_nota["notafinal"]);
			
			echo "
		<tr>
			<td align=\"center\">$matricula</td>
			<td >$nome</td>
			<td align=\"\">$disciplina</td>
			<td align=\"center\">$nota</td>
		</tr>
		";
		}
		echo "</table>";
	}	
	
}
include('includes/conectar.php');
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
        
