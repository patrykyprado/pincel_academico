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
                  <div class="col-lg-12">
                      <section class="panel">
                      <div class="panel-heading">
                      <b>Dashboard</b>
                      </div>
                          <div class="panel-body">
<?php
$sql_turmas_atuais = mysql_query("SELECT acc.nome, d.disciplina,ctd.codigo, d.cod_disciplina, agr.agrupamento, ctd.cod_prof, agr.data_inicio, agr.data_fim, ct.anograde
FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ctd.id_turma = ct.id_turma
INNER JOIN agrupamentos agr
ON ctd.codigo IN (agr.disciplinas)
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
INNER JOIN acessos_completos acc
ON acc.usuario = ctd.cod_prof
WHERE (NOW() BETWEEN agr.data_inicio AND agr.data_fim) ORDER BY agr.data_inicio, agr.data_fim");
if(mysql_num_rows($sql_turmas_atuais)>=1){
	$total_atuais = mysql_num_rows($sql_turmas_atuais);
	echo "
		<div class=\"panel-heading-aviso\">
                                  <h4 class=\"panel-title\">
                                      <a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#atuais\">
                                          Disciplinas em Andamento
                                      </a><font color=\"#FFF\" size=\"-3\">Total: $total_atuais</font>
                                  </h4>
                              </div>
                              <div id=\"atuais\" class=\"panel-collapse collapse in\">
                                  <div class=\"panel-body-aviso\">
								  <table width=\"100%\" border=\"1\">
								  <tr>
								  	<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Disciplina</b></td>
									<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Agrupamento</b></td>
									<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Início</b></td>
									<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Fim</b></td>
									<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Professor</b></td>
								  </tr>
								  ";
		while($dados_turmas_atuais = mysql_fetch_array($sql_turmas_atuais)){
			$disciplina_nome = $dados_turmas_atuais["disciplina"];
			$disciplina_cod = $dados_turmas_atuais["cod_disciplina"];
			$disciplina_agrupamento = $dados_turmas_atuais["agrupamento"];
			$disciplina_turma_disc = $dados_turmas_atuais["codigo"];
			$disciplina_anograde = $dados_turmas_atuais["anograde"];
			$disciplina_inicio = format_data($dados_turmas_atuais["data_inicio"]);
			$disciplina_fim = format_data($dados_turmas_atuais["data_fim"]);
			$disciplina_professor = format_curso($dados_turmas_atuais["nome"]);
			echo " <tr bgcolor=\"#FFFFFF\">
								  	<td><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_nome</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_agrupamento</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_inicio</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_fim</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_professor</a></td>
								  </tr>";
								  
								  
		}

      echo "</table></div></div>";
	
}


$sql_turmas_concluidas = mysql_query("SELECT acc.nome, d.disciplina,ctd.codigo, d.cod_disciplina, agr.agrupamento, ctd.cod_prof, agr.data_inicio, agr.data_fim, ct.anograde
FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ctd.id_turma = ct.id_turma
INNER JOIN agrupamentos agr
ON ctd.codigo IN (agr.disciplinas)
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
INNER JOIN acessos_completos acc
ON acc.usuario = ctd.cod_prof
WHERE (NOW() > agr.data_fim) ORDER BY agr.data_inicio, agr.data_fim");
if(mysql_num_rows($sql_turmas_concluidas)>=1){
	$total_concluidas = mysql_num_rows($sql_turmas_concluidas);
	echo "
		<div class=\"panel-heading-aviso\">
                                  <h4 class=\"panel-title\">
                                      <a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#concluidas\">
                                          Disciplinas Encerradas
                                      </a><font color=\"#FFF\" size=\"-3\">Total: $total_concluidas</font>
                                  </h4>
                              </div>
                              <div id=\"concluidas\" class=\"panel-collapse collapse\">
                                  <div class=\"panel-body-aviso\">
								  <table width=\"100%\" border=\"1\">
								  <tr>
								  	<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Disciplina</b></td>
									<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Agrupamento</b></td>
									<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Início</b></td>
									<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Fim</b></td>
									<td bgcolor=\"#E5E5E5\" align=\"center\"><b>Professor</b></td>
								  </tr>
								  ";
		while($dados_turmas_concluidas = mysql_fetch_array($sql_turmas_concluidas)){
			$disciplina_nome = $dados_turmas_concluidas["disciplina"];
			$disciplina_cod = $dados_turmas_concluidas["cod_disciplina"];
			$disciplina_agrupamento = $dados_turmas_concluidas["agrupamento"];
			$disciplina_turma_disc = $dados_turmas_concluidas["codigo"];
			$disciplina_anograde = $dados_turmas_concluidas["anograde"];
			$disciplina_inicio = format_data($dados_turmas_concluidas["data_inicio"]);
			$disciplina_fim = format_data($dados_turmas_concluidas["data_fim"]);
			$disciplina_professor = format_curso($dados_turmas_concluidas["nome"]);
			echo " <tr bgcolor=\"#FFFFFF\">
								  	<td><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_nome</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_agrupamento</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_inicio</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_fim</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_professor</a></td>
								  </tr>";
								  
								  
		}

      echo "</table></div></div>";
	
}


?>
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


