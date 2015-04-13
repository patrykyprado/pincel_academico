
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row">              

                  <div class="col-lg-12">
                      <section class="panel">
                      <div class="panel-heading">
                      <b>Dashboard</b>
                      </div>
                          <div class="panel-body">
<?php
$sql_turmas_atuais = mysql_query("SELECT d.disciplina,ctd.codigo, d.cod_disciplina, agr.agrupamento, ctd.cod_prof, agr.data_inicio, agr.data_fim, ct.anograde
FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ctd.id_turma = ct.id_turma
INNER JOIN agrupamentos agr
ON ctd.codigo IN (agr.disciplinas)
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
WHERE (NOW() BETWEEN agr.data_inicio AND agr.data_fim) AND ctd.cod_prof = '$user_usuario'");
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
			echo " <tr bgcolor=\"#FFFFFF\">
								  	<td><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_nome</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_agrupamento</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_inicio</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_fim</a></td>
								  </tr>";
								  
								  
		}

      echo "</table></div></div>";
	
}


$sql_turmas_concluidas = mysql_query("SELECT d.disciplina,ctd.codigo, d.cod_disciplina, agr.agrupamento, ctd.cod_prof, agr.data_inicio, agr.data_fim, ct.anograde
FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ctd.id_turma = ct.id_turma
INNER JOIN agrupamentos agr
ON ctd.codigo IN (agr.disciplinas)
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
WHERE (NOW() > agr.data_fim) AND ctd.cod_prof = '$user_usuario'");
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
			echo " <tr bgcolor=\"#FFFFFF\">
								  	<td><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_nome</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_agrupamento</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_inicio</a></td>
									<td align=\"center\"><a href=\"ea_disciplina.php?turma_disc=$disciplina_turma_disc&coddisc=$disciplina_cod&anograde=$disciplina_anograde\">$disciplina_fim</a></td>
								  </tr>";
								  
								  
		}

      echo "</table></div></div>";
	
}


?>
    </div>
                         
                      </section>
                  </div>
  
                  <div class="col-lg-12">
                      <section class="panel">
                      <div class="panel-heading">
                      <b>Avisos Importantes</b>
                      </div>
                          <div class="panel-body">
<?php
$sql_avisos = mysql_query("SELECT * FROM avisos WHERE nivel_user = $user_nivel ORDER BY data_hora DESC LIMIT 3");
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