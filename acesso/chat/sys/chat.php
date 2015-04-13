<?php
include('../../includes/conectar.php');
include('../../includes/restricao.php');

$acao = $_POST["acao"];

switch($acao){
	case 'verificar':
		
		$sql_verificar = mysql_query("SELECT id_de FROM chat_mensagens WHERE id_para = $user_iduser AND visto = 0 GROUP by id_de");
		if(mysql_num_rows($sql_verificar)==0){
			echo '';
		} else {
			$new = array();
			while($dados_verificar = mysql_fetch_array($sql_verificar)){
				$new[] = $dados_verificar["id_de"];
			}
			$new = json_encode($new);
			echo $new;
		}
		
	break;
	
	case 'inserir':
		$para = $_POST["para"];
		$mensagem = strip_tags($_POST['mensagem']);
		
		$sql_envio = mysql_query("SELECT * FROM users WHERE id_user = $user_iduser");
		$dados_envio = mysql_fetch_array($sql_envio);
		$pegar_nome = $dados_envio["nome"];
		if(mysql_query("INSERT INTO chat_mensagens (id_de, id_para, data, mensagem, visto) VALUES ('$user_iduser', '$para', NOW(), '$mensagem', '0')")){
			if(mysql_affected_rows()==1){
				echo '<li><span>'.$pegar_nome.' disse:</span><p>'.$mensagem.'</p></li>';
			} else {
				echo '<li><span>'.$pegar_nome.'</span><p>Sem conexão com a internet.</p></li>';
			}
		}
	break;
	
	case 'atualizar':
		$array = $_POST['array'];
		if($array != ''){
			
			foreach($array as $indice => $id){
				$sql_chat = mysql_query("SELECT * FROM chat_mensagens WHERE id_de = $user_iduser AND id_para = $id OR id_de = $id AND id_para = $user_iduser");
				$mensagem = "";
				while($dados_chat = mysql_fetch_array($sql_chat)){
					$chat_user = $dados_chat["id_de"];
					$sql_nome_usuario = mysql_query("SELECT * FROM users WHERE id_user = $chat_user"); 
					$dados_chat_nome = mysql_fetch_array($sql_nome_usuario);
					$nome_usuario = $dados_chat_nome["nome"];
					$mensagem .='<li><span>'.$nome_usuario.' disse:</span><p>'.$dados_chat['mensagem'].'</p></li>';
					mysql_query("UPDATE chat_mensagens SET visto = 1 WHERE id_de = $id AND id_para = $user_iduser AND visto = 0");
				}
				$new[$id] = $mensagem;
			}
			$new = json_encode($new);
			echo $new;
			
		} else {
			echo '';	
		}
	break;
	
}
?>