<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$get_turma_disc = $_GET["turma_disc"];
$sql_disciplina = mysql_query("SELECT disciplina FROM view_disciplina_turma WHERE turma_disc = $get_turma_disc");
$dados_disciplina = mysql_fetch_array($sql_disciplina);
$nome_disciplina = $dados_disciplina["disciplina"];


$sql_agrupamento = mysql_query("SELECT id_agrupamento,agrupamento,  disciplinas FROM agrupamentos WHERE disciplinas LIKE '%$get_turma_disc,%'");
$dados_agrupamento = mysql_fetch_array($sql_agrupamento);
$disciplinas_agrupadas = $dados_agrupamento["disciplinas"];
$disciplinas_id_agrupamento = $dados_agrupamento["id_agrupamento"];
$agrupamento_nome = $dados_agrupamento["agrupamento"];

$sql_alunos = mysql_query("SELECT matricula, nome FROM v_aluno_disc WHERE turma_disc IN ($disciplinas_agrupadas) ORDER BY nome");
$total_alunos = mysql_num_rows($sql_alunos);

?>


<body>

  <section id="container"  class="sidebar-closed">


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Relat&oacute;rio: Participantes<br>
                              Agrupamento: <?php echo $agrupamento_nome;?><br>
                              Disciplina: <?php echo $nome_disciplina;?></b>
                          </header>
                          <div class="panel-body">
<?php
if($total_alunos == 0){
	echo "<center>Nenhum aluno encontrado.</center>";
} else {
	echo "<table width=\"auto\" border=\"1\">
	<tr>
		<td align=\"center\"><b>Matrícula</b></td>
		<td align=\"center\"><b>Nome</b></td>";
		//PEGA AS ATIVIDADES DE FORUM  DA TURMA
		$sql_turma_ativ = mysql_query("SELECT titulo, data_criacao, data_inicio, data_fim, max_nota FROM ea_forum WHERE subturma = $disciplinas_id_agrupamento AND max_nota >0 GROUP BY data_criacao");
		if(mysql_num_rows($sql_turma_ativ) >=1){
			$x_ativ = 1;
			while($dados_turma_ativ =mysql_fetch_array($sql_turma_ativ)){
				$turma_ativ_titulo = $dados_turma_ativ["titulo"];
				$turma_ativ_nota = format_valor($dados_turma_ativ["max_nota"]);
				$turma_ativ_data_inicio = format_data_hora($dados_turma_ativ["data_inicio"]);	
				$turma_ativ_data_fim = format_data_hora($dados_turma_ativ["data_fim"]);
				$turma_ativ_nome = "F".$x_ativ;
				$x_ativ +=1;
				echo "<td align=\"center\" width=\"100px\"><a href=\"#\" data-original-title=\"$turma_ativ_titulo\" data-content=\"Data de Início: $turma_ativ_data_inicio \n Data Final: $turma_ativ_data_fim - Valor: $turma_ativ_nota\" data-placement=\"top\" data-trigger=\"hover\" class=\"popovers\"><b>$turma_ativ_nome</b></td>";
			}
		}
		
		//PEGA AS ATIVIDADES DE ESTUDO DIRIGIDO  DA TURMA
		$sql_turma_ativ = mysql_query("SELECT titulo, data_criacao, data_inicio, data_fim, max_nota FROM ea_estudo_dirigido WHERE subturma = $disciplinas_id_agrupamento AND max_nota >0 GROUP BY data_criacao");
		if(mysql_num_rows($sql_turma_ativ) >=1){
			$x_ativ = 1;
			while($dados_turma_ativ =mysql_fetch_array($sql_turma_ativ)){
				$turma_ativ_titulo = $dados_turma_ativ["titulo"];
				$turma_ativ_nota = $dados_turma_ativ["max_nota"];
				$turma_ativ_data_inicio = format_data_hora($dados_turma_ativ["data_inicio"]);	
				$turma_ativ_data_fim = format_data_hora($dados_turma_ativ["data_fim"]);
				$turma_ativ_nome = "ED".$x_ativ;
				$x_ativ +=1;
				echo "<td align=\"center\" width=\"100px\"><a href=\"#\" data-original-title=\"$turma_ativ_titulo\" data-content=\"Data de Início: $turma_ativ_data_inicio \n Data Final: $turma_ativ_data_fim - Valor: $turma_ativ_nota\" data-placement=\"top\" data-trigger=\"hover\" class=\"popovers\"><b>$turma_ativ_nome</b></td>";
			}
		}
		
	echo"</tr>";
	
	while($dados_alunos = mysql_fetch_array($sql_alunos)){
		$aluno_matricula = $dados_alunos["matricula"];
		$aluno_nome = ($dados_alunos["nome"]);		
		echo "<tr>
			<td align=\"center\" width=\"80px\"><b>$aluno_matricula</b></td>
			<td align=\"\" width=\"300px\"><font size=\"-1\"><b>$aluno_nome</b></font></td>";
		 //PEGA AS ATIVIDADES DE FORUM  DA TURMA
		$sql_turma_ativ = mysql_query("SELECT titulo, data_criacao, data_inicio, data_fim FROM ea_forum WHERE subturma = $disciplinas_id_agrupamento AND max_nota >0 GROUP BY data_criacao");
		if(mysql_num_rows($sql_turma_ativ) >=1){
			while($dados_turma_ativ =mysql_fetch_array($sql_turma_ativ)){
				$id_foruns = "000";
				$turma_ativ_titulo = $dados_turma_ativ["titulo"];
				$turma_ativ_data_criacao = $dados_turma_ativ["data_criacao"];	
				$sql_foruns = mysql_query("SELECT id_forum FROM ea_forum WHERE data_criacao = '$turma_ativ_data_criacao' AND titulo LIKE '$turma_ativ_titulo'");
				while($dados_foruns = mysql_fetch_array($sql_foruns)){
					$id_foruns .= ",".$dados_foruns["id_forum"];	
				}
				//VERIFICA SE O ALUNO PARTICIPOU E CRIA O CHECK
				$sql_participacao_alunos = mysql_query("SELECT id_forum FROM ea_post_forum WHERE id_forum IN ($id_foruns) AND matricula = $aluno_matricula");
				if(mysql_num_rows($sql_participacao_alunos)>=1){
					$icone_participacao = "<i class=\"fa fa-check\" style=\"color:green\"></i>";
				} else {
					$icone_participacao = "<a id=\"email_atividade\" href=\"javascript:void(0);\" turma_disc=\"$get_turma_disc\" matricula=\"$aluno_matricula\" nome_disciplina=\"$nome_disciplina\" tipo=\"forum\"><i class=\"fa fa-ban\" style=\"color:red\"></i></a>";
				}
				echo "<td align=\"center\" width=\"80px\"><b><font size =\"+2\">$icone_participacao</font></b></td>";
			}
		}
		
		//PEGA AS ATIVIDADES DE ESTUDO DIRIGIDO DA TURMA
		$sql_turma_ativ = mysql_query("SELECT titulo, data_criacao, data_inicio, data_fim FROM ea_estudo_dirigido WHERE subturma = $disciplinas_id_agrupamento AND max_nota >0 GROUP BY data_criacao");
		if(mysql_num_rows($sql_turma_ativ) >=1){
			while($dados_turma_ativ =mysql_fetch_array($sql_turma_ativ)){
				$id_estudos = "000";
				$turma_ativ_titulo = $dados_turma_ativ["titulo"];
				$turma_ativ_data_criacao = $dados_turma_ativ["data_criacao"];	
				$sql_estudos = mysql_query("SELECT id_estudo FROM ea_estudo_dirigido WHERE data_criacao = '$turma_ativ_data_criacao' AND titulo LIKE '$turma_ativ_titulo'");
				while($dados_estudos = mysql_fetch_array($sql_estudos)){
					$id_estudos .= ",".$dados_estudos["id_estudo"];	
				}
				//VERIFICA SE O ALUNO PARTICIPOU E CRIA O CHECK
				$sql_participacao_alunos = mysql_query("SELECT id_envio FROM ea_estudo_envio WHERE id_estudo IN ($id_estudos) AND matricula = $aluno_matricula");
				if(mysql_num_rows($sql_participacao_alunos)>=1){
					$icone_participacao = "<i class=\"fa fa-check\" style=\"color:green\"></i>";
				} else {
					$icone_participacao = "<a id=\"email_atividade\" href=\"javascript:void(0);\" turma_disc=\"$get_turma_disc\" matricula=\"$aluno_matricula\" nome_disciplina=\"$nome_disciplina\" tipo=\"estudo\"><i class=\"fa fa-ban\" style=\"color:red\"></i></a>";
				}
				echo "<td align=\"center\" width=\"80px\"><b><font size =\"+2\">$icone_participacao</font></b></td>";
			}
		}
		echo "
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