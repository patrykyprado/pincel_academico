<div id="janelas"></div>
              <!-- janelas de chat fim --> 
      <!-- Right Slidebar start -->
<?php
if($user_nivel != 80){
$sql_usuarios_online = mysql_query("SELECT DISTINCT alu.codigo, alu.nome, cac.foto_perfil, 'Professor' as 'setor'
FROM acesso ac
INNER JOIN alunos alu
ON ac.codigo = alu.codigo
INNER JOIN ced_turma_disc ctd
ON ctd.cod_prof = ac.codigo
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN comp_acesso cac
ON cac.usuario = ac.codigo
WHERE ct.id_turma = $user_turma_id_turma AND ac.chat_status = 2 ORDER BY alu.nome ASC
");
if(mysql_num_rows($sql_usuarios_online)>=1){
	$total_usuarios_online = mysql_num_rows($sql_usuarios_online);
} else {
	$total_usuarios_online = 0;
}


$sql_usuarios_offline= mysql_query("SELECT DISTINCT alu.codigo, alu.nome, cac.foto_perfil, 'Professor' as 'setor'
FROM acesso ac
INNER JOIN alunos alu
ON ac.codigo = alu.codigo
INNER JOIN ced_turma_disc ctd
ON ctd.cod_prof = ac.codigo
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN comp_acesso cac
ON cac.usuario = ac.codigo
WHERE ct.id_turma = $user_turma_id_turma AND ac.chat_status = 1 ORDER BY alu.nome ASC");
if(mysql_num_rows($sql_usuarios_offline)>=1){
	$total_usuarios_offline = mysql_num_rows($sql_usuarios_offline);
} else {
	$total_usuarios_offline = 0;
}


?>

      <div class="sb-slidebar sb-right sb-style-overlay"> 
          <div class="titulo-chat">CHATEC</div>
          <div id="contatos"> 
          <ul class="quick-chat-list">  
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#usuarios_online">
                                          <h5 class="side-title-online">Usu&aacute;rios Conectados (<?php echo $total_usuarios_online?>)</h5>
                                      </a>
                                      <div id="usuarios_online" class="panel-collapse collapse in">
                              
           
            
              <?php
			  if(mysql_num_rows($sql_usuarios_online)>=1){
				  while($dados_usuarios_online = mysql_fetch_array($sql_usuarios_online)){
					  $chat_nome = $dados_usuarios_online["nome"];
					  $chat_id = $dados_usuarios_online["codigo"];
					  $chat_foto = "../".$dados_usuarios_online["foto_perfil"];
					  $chat_setor = $dados_usuarios_online["setor"];
					  $chat_status = $dados_usuarios_online["chat_status"];
					  if($chat_status == 1){
						  $exibir_status = "offline";  
					  }
					  if($chat_status == 2){
						  $exibir_status = "online";  
					  }
					  
					  //CONTA MENSAGENS NÃO LIDAS
					  $sql_chat_mensagens = mysql_query("SELECT * FROM chat_mensagens WHERE id_para = '$user_iduser' AND id_de = '$chat_id' AND visto = 0");
					  $total_chat_mensagens = mysql_num_rows($sql_chat_mensagens);
					  if($total_chat_mensagens>=1){
						  $exibir_chat_mensagens = '<span class="badge bg-warning">'.$total_chat_mensagens.'</span>';
					  } else {
						  $exibir_chat_mensagens = '';
					  }
					  
					  echo '
					 
					  <li class="'.$exibir_status.'">
					  <div class="media">
					  <a href="javascript:;" nome="'.substr($chat_nome,0,20).'" id="'.$chat_id.'" class="pull-left media-thumb comecar">
                          <img alt="" src="'.$chat_foto.'" class="media-object">
						  </a>
						  <a href="javascript:;" nome="'.substr($chat_nome,0,20).'" id="'.$chat_id.'" class="comecar">
                      <div class="media-body">
                          <div class="media-status">
                             '.$exibir_chat_mensagens.'
                          </div>
                          <strong>'.substr($chat_nome,0,20).'</strong>
                          <small>'.$chat_setor.'</small>
						  </a>
                      </div>
				 	
                  </div><!-- media -->
              </li>';
					  
					  
				  }
				  
			  }
			  ?>
              </div>
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#usuarios_offline">
                                          <h5 class="side-title-offline">Usu&aacute;rios Desconectados (<?php echo $total_usuarios_offline?>)</h5>
                                      </a>
                                      <div id="usuarios_offline" class="panel-collapse collapse">
                              
           
            
              <?php
			  if(mysql_num_rows($sql_usuarios_offline)>=1){
				  while($dados_usuarios_offline = mysql_fetch_array($sql_usuarios_offline)){
					  $chat_nome = $dados_usuarios_offline["nome"];
					  $chat_id = $dados_usuarios_offline["id_user"];
					  $chat_foto = $dados_usuarios_offline["foto_perfil"];
					  $chat_setor = $dados_usuarios_offline["setor"];
					  $chat_status = $dados_usuarios_offline["chat_status"];
					  if($chat_status == 1){
						  $exibir_status = "offline";  
					  }
					  if($chat_status == 2){
						  $exibir_status = "online";  
					  }
					  
					  //CONTA MENSAGENS NÃO LIDAS
					  $sql_chat_mensagens = mysql_query("SELECT * FROM chat_mensagens WHERE id_para = '$user_iduser' AND id_de = '$chat_id' AND visto = 0");
					  $total_chat_mensagens = mysql_num_rows($sql_chat_mensagens);
					  if($total_chat_mensagens>=1){
						  $exibir_chat_mensagens = '<span class="badge bg-warning">'.$total_chat_mensagens.'</span>';
					  } else {
						  $exibir_chat_mensagens = '';
					  }
					  
					  echo '
					 
					  <li class="'.$exibir_status.'">
					  <div class="media">
					  <a href="javascript:;" nome="'.substr($chat_nome,0,20).'" id="'.$chat_id.'" class="pull-left media-thumb comecar">
                          <img alt="" src="'.$chat_foto.'" class="media-object">
						  </a>
						  <a href="javascript:;" nome="'.substr($chat_nome,0,20).'" id="'.$chat_id.'" class="comecar">
                      <div class="media-body">
                          <div class="media-status">
                             '.$exibir_chat_mensagens.'
                          </div>
                          <strong>'.substr($chat_nome,0,20).'</strong>
                          <small>'.$chat_setor.'</small>
						  </a>
                      </div>
				 	
                  </div><!-- media -->
              </li>';
					  
					  
				  }
				  
			  }
			  ?>              
              
             </div> 
          </ul>
		
        </div>
        
      </div>
      <!-- Right Slidebar end -->
<?php
}
?>
<!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
             <a style="color:#FFF" href="<?php echo $config_link_footer;?>" target="_blank"> <?php echo $config_footer;?></a>
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
      
