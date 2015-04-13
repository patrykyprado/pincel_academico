
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
                  <div class="col-lg-12">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                              <?php 
							  if(!isset($_GET["conta"])){
							$get_ref_conta = '';
							$conta_atual = "Todas";
						} else {
							$get_ref_conta = $_GET["conta"];
							$sql_conta_atual = mysql_query("SELECT * FROM contas WHERE ref_conta = '$get_ref_conta'");
							$dados_conta_atual = mysql_fetch_array($sql_conta_atual);
							$conta_atual = $dados_conta_atual["conta"];
						}
							  ?>
                                  <h1>Contas a Pagar</h1>
                                  <p>Conta Selecionada: <?php echo $conta_atual;?></p>
                              </div><br>
                              <div align="left" class="task-option">
                              <form method="GET">
                                  <select name="conta" style="width:300px" class="textBox" id="conta" onKeyPress="return arrumaEnter(this, event)">
      <?php
include("includes/config_drop.php");?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT * FROM contas ORDER BY conta";
	  } else {
		 $sql = "SELECT * FROM contas WHERE conta LIKE '%$user_unidade%' ORDER BY conta";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['ref_conta'] . "'>" . $row['conta'] . "</option>";
}
?>
      </select>
      <button type="submit" class="btn btn-success">Alterar</button>
</form>
                              </div>
                          </div>
                          <table class="table table-striped table-hover table-bordered" id="editable-sample">
                              <thead>
                              <tr>
                                  <th align="center">T&iacute;tulo</th>
                                  <th align="center">Descri&ccedil;&atilde;o</th>
                                  <th align="center">Vencimento</th>
                                  <th align="center">Valor</th>
                                  <th align="center">Conta</th>
                              </tr>
                              </thead>
                              <tbody>
                              
                              
                              <?php
						
						//PESQUISA DE TÍTULOS A PAGAR DE ATÉ 4 DIAS
						$sql_titulos_apagar = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 1 AND status = 0 AND (data_pagto is null OR data_pagto LIKE '') AND (vencimento BETWEEN ADDDATE(now(), -4) AND ADDDATE(now(), 4)) AND conta_nome LIKE '%$user_unidade%' AND conta LIKE '%$get_ref_conta%' ORDER BY vencimento");
						if(mysql_num_rows($sql_titulos_apagar)==0){
							echo "<tr><td colspan=\"5\" align=\"center\">Nenhum título pendente de pagamento.</td></tr>";
						} else {
							$sql_titulos_apagar2 = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 1 AND status = 0 AND (data_pagto is null OR data_pagto LIKE '') AND (vencimento BETWEEN ADDDATE(now(), -4) AND ADDDATE(now(), 4)) AND conta_nome LIKE '%$user_unidade%' AND conta LIKE '$get_ref_conta'");
							$total_titulos = mysql_num_rows($sql_titulos_apagar2);
							while($dados_tit = mysql_fetch_array($sql_titulos_apagar)){
								$id_titulo = $dados_tit["id_titulo"];
								$descricao_titulo = substr($dados_tit["descricao"],0,10)."...";
								$valor_titulo = format_valor($dados_tit["valor"]);
								$conta_titulo = $dados_tit["conta_nome"];
								$vencimento_titulo = format_data($dados_tit["vencimento"]);
								if($total_titulos <= $limit_tit){
									$limit_tit = $total_titulos;	
								}
								echo "<tr class=\"\">
                                  <td><a rel=\"shadowbox\" href=\"editar.php?id=$id_titulo\">$id_titulo</a></td>
                                  <td>$descricao_titulo</td>
                                  <td>$vencimento_titulo</td>
                                  <td class=\"center\">R$ $valor_titulo</td>
                                  <td>$conta_titulo</td>
                              </tr>";
							}
							
						}
						
						?>
                            </tbody>
                          </table>
                      </section>
                      <!--work progress end-->
                  </div>
              </div>

                      </section>
                      <!--weather statement end-->
                  </div>
              </div>

          </section>
      </section>