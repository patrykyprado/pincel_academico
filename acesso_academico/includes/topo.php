<?php 
include('includes/restricao.php');
?>
<?php


//VERIFICA SE SISTEMA ENCONTRA-SE EM MANUTENÇÃO
$sql_app = mysql_query("SELECT * FROM config_app WHERE id_config = 1");
$dados_app = mysql_fetch_array($sql_app);
if($dados_app["modo_manutencao"]==1){
	session_destroy();	
	header("Location: ../manutencao.php" );
}

//ALERTAS DO SISTEMA
$sql_alertas_sis = "SELECT * FROM alertas WHERE tipo = 1 AND visto = 0 AND para = '$user_usuario' ORDER BY datahora DESC";
$sql_alertas_sis_nolimit = mysql_query($sql_alertas_sis);
$sql_alertas_sis_limit = mysql_query($sql_alertas_sis." LIMIT 5");
$contar_alerta_sis = mysql_num_rows($sql_alertas_sis_nolimit);

?>
      <!--header start-->
      <header class="header white-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Menu de Navegação"></div>
              </div>
            <!--logo start-->
           <?php echo $config_nome_app;?>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">                  
<?php 
if($contar_alerta_sis == 0){
	$exib_contagem_alerta_sis = "Não há novos alertas do sistema";
	$exib_box_contagem = "";
} else {
	$exib_contagem_alerta_sis = "Você possui $contar_alerta_sis novo(s) alerta(s) do sistema";
	$exib_box_contagem = "<span class=\"badge bg-warning\">$contar_alerta_sis</span>";
}
?>
                    <!-- notification dropdown start-->
                    <li id="header_notification_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="fa fa-bell-o"></i>
                            <?php echo $exib_box_contagem; ?>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-yellow"></div>
                            <li>
                                <p class="yellow"><?php echo $exib_contagem_alerta_sis; ?></p>
                            </li>
                            
                            <?php
							if($contar_alerta_sis >= 1){
								while($dados_alerta_sis = mysql_fetch_array($sql_alertas_sis_limit)){
									$sis_alerta_titulo = $dados_alerta_sis["titulo"];
									$sis_alerta_id = $dados_alerta_sis["id_alert"];
									
									$inicio_alert_sis = $dados_alerta_sis["datahora"];
									$fim_alert_sis = date("Y-m-d H:i:s");
									 
									$exib_tempo = format_tempo($inicio_alert_sis, $fim_alert_sis);
									
								echo "
								<li>
                                <a rel=\"shadowbox;height=500;width=700\" href=\"ver_alerta.php?id=$sis_alerta_id\">
                                    <span class=\"label label-info\"><i class=\"fa fa-bullhorn\"></i></span>
                                    $sis_alerta_titulo
                                    <span class=\"small italic\"><br>$exib_tempo</span>
                                </a>
                            </li>
								";
									
								}
							}
							?>
                           
                            
                            <li>
                                <a rel="shadowbox;height=500;width=700" href="ver_alerta.php">Ver todos os alertas</a>
                            </li>
                        </ul>
                    </li>
                    <!-- notification dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                	<li>
                    <center><?php echo date("d/m/Y");?><br><?php echo $user_nivel_nome;?></center> <div id="datahora2" style="margin-top:10px;"></div>
                    </li>
                	<li>
                    <a data-placement="bottom" data-original-title="Imprimir Página Atual" data-toggle="tooltip" class="tooltips" href="javascript:window.print();"><i class="fa fa-print"></i></a>
                    </li>
                    <li>
                        <input type="text" class="form-control search" placeholder="Procurar">
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img class="img_perfil" alt="" src="../<?php echo $user_foto;?>">
                            <span class="username"><?php echo $user_nome?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="perfil.php"><i class=" fa fa-suitcase"></i>Perfil</a></li>
                            <li><a href="config.php"><i class="fa fa-cog"></i> Configurações</a></li>
                            <li><a href="<?php echo $logoutAction ?>"><i class="fa fa-key"></i> Sair</a></li>
                        </ul>
                    </li>
                    <li class="sb-toggle-right">
                        <i class="fa  fa-align-right"></i>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      
<?php
function format_tempo($inicio, $fim){
	
									$unix_data1 = strtotime($inicio);
									$unix_data2 = strtotime($fim);
									
									$nHoras   = ($unix_data2 - $unix_data1) / 3600;
									$nMinutos = (($unix_data2 - $unix_data1) % 3600) / 60;
									
									if($nHoras < 1){
										$exib_tempo = floor($nMinutos)." min." ;
									} else {
										$exib_tempo = floor($nHoras)." hora(s)." ;
									}
									if($nHoras >=24){
										$exib_tempo = floor($nHoras/24)." dia(s)";
									}
									return $exib_tempo;
}



?>

