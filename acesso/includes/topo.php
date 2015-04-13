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

//MENSAGENS
$sql_mensagem = "SELECT * FROM chat_mensagens WHERE visto = 0 AND id_para = $user_iduser ORDER BY data DESC";
$sql_mensagem_ver = "SELECT * FROM chat_mensagens WHERE (id_para = $user_iduser OR id_de = $user_iduser) ORDER BY data DESC";
$sql_mensagem_nolimit = mysql_query($sql_mensagem);
$sql_mensagem_limit = mysql_query($sql_mensagem_ver." LIMIT 6");
$contar_mensagem = mysql_num_rows($sql_mensagem_nolimit);
$contar_mensagem_ver = mysql_num_rows($sql_mensagem_limit);
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
            <!-- inbox dropdown start-->
<?php 
if($contar_mensagem == 0){
	$exib_contagem_chatec = "Não há novas mensagens";
	$exib_box_chatec = "";
} else {
	if($contar_mensagem == 1){
		$comp_text_mensagem = " nova mensagem.";	
	} else {
		$comp_text_mensagem = " novas mensagens.";	
	}
	$exib_contagem_chatec = "Você possui $contar_mensagem $comp_text_mensagem";
	$exib_box_chatec = "<span class=\"badge bg-important\">$contar_mensagem</span>";
}
?>
              <li id="header_inbox_bar" class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                      <i class="fa fa-envelope-o"></i>
                      <?php echo $exib_box_chatec;?>
                  </a>
                  <ul class="dropdown-menu extended inbox">
                      <div class="notify-arrow notify-arrow-red"></div>
                      <li>
                          <p class="red"><?php echo $exib_contagem_chatec;?></p>
                      </li>
                      <?php
							if($contar_mensagem_ver >= 1){
								while($dados_mensagem = mysql_fetch_array($sql_mensagem_limit)){
									$mensagem_texto = substr($dados_mensagem["mensagem"],0,15)."..";
									$mensagem_id_de = $dados_mensagem["id_de"];
									
									$inicio_mensagem = $dados_mensagem["data"];
									$fim_mensagem = date("Y-m-d H:i:s",strtotime('-2 hour'));
									$exib_tempo = format_tempo($inicio_mensagem, $fim_mensagem);
									
									$sql_mensagem_de = mysql_query("SELECT nome, foto_perfil FROM users WHERE id_user = $mensagem_id_de");
									$dados_mensagem_de = mysql_fetch_array($sql_mensagem_de);
									$mensagem_nome = $dados_mensagem_de["nome"];
									$mensagem_autor_foto = "../".$dados_mensagem_de["foto_perfil"];
								echo "
								<li>
                          <a href=\"#\">
                              <span class=\"photo\"><img alt=\"avatar\" src=\"$mensagem_autor_foto\"></span>
                                    <span class=\"subject\">
                                    <span class=\"from\">$mensagem_nome</span>
                                    <span class=\"time\">$exib_tempo</span>
                                    </span>
                                    <span class=\"message\">
                                        $mensagem_texto 
                                    </span>
                          </a>
                      </li>
								";
									
								}
							}
							?>
                      
   
                  </ul>
              </li>
              <!-- inbox dropdown end -->
                    <!-- inbox dropdown start-->
                    

             </ul>
             </div>
            </div>
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                	<li>
                    <center><?php echo date("d/m/Y");?><br><?php echo $user_nivel_nome;?></center> <div id="datahora2" style="margin-top:10px;"></div>
                    </li>
                	<li>
                    <a data-placement="bottom" data-original-title="Imprimir a Página Atual" data-toggle="tooltip" class="tooltips" href="javascript:window.print();"><i class="fa fa-print"></i></a>
                    </li>
					<?php
					
					//BOTÃO DE PESQUISA DE TITULO
					if($permitido_pesquisa == 1){
						echo "<li>
                    <a data-placement=\"bottom\" data-original-title=\"Pesquisar Título\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"#\" Onclick=\"pesquisar_titulo();\"><i class=\"fa fa-search\"></i></a>
                    </li>";	
					}
					?>
                    

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
										if($nHoras == 1){
											$exib_tempo = floor($nHoras)." hora." ;
										} else {
											$exib_tempo = floor($nHoras)." horas." ;
										}
										
									}
									if($nHoras >=24){
										if(($nHoras/24) == 1){
											$exib_tempo = floor($nHoras/24)." dia";
										} else {
											$exib_tempo = floor($nHoras/24)." dias";
										}
										
									}
									return $exib_tempo;
}

?>



