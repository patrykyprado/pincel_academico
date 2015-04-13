acao: 'enviar_email_atividade',
			nome_disciplina: nome_disciplina,
			matricula: matricula,
			turma_disc: turma_disc,
			id_atividade: id_atividade,
			tipo: tipo
<?php
include('../../includes/conectar.php');
include('../../includes/restricao.php');
include('../../includes/funcoes.php');

$acao = $_POST['acao'];
$nome_disciplina = $_POST['nome_disciplina'];
$matricula = $_POST['matricula'];
$turma_disc = $_POST['turma_disc'];
$id_atividade = $_POST['id_atividade'];
$tipo = $_POST['tipo'];

//PEGA DADOS DO ALUNO
$sql_aluno = mysql_query("SELECT nome, email FROM alunos WHERE codigo = $matricula");
$dados_aluno = mysql_fetch_array($sql_aluno);
$nome_aluno = $dados_aluno["nome"];
$email_aluno = $dados_aluno["email"];

//PEGA DADOS DA ATIVIDADE
if($tipo == 1){
	$sql_atividade = mysql_query("SELECT titulo, data_inicio, data_fim, max_nota FROM ea_forum WHERE id_forum IN ($id_atividade) LIMIT 1");	
} else {
	$sql_atividade = mysql_query("SELECT titulo, data_inicio, data_fim, max_nota FROM ea_estudo_dirigido WHERE id_estudo IN ($id_atividade) LIMIT 1");		
}
$dados_atividade = mysql_fetch_array($sql_atividade);
$titulo_atividade = $dados_atividade["titulo"];
$inicio_atividade = $dados_atividade["data_inicio"];
$fim_atividade = $dados_atividade["data_fim"];
$nota_atividade = format_valor($dados_atividade["max_nota"]);

switch($acao){
	case 'enviar_email_atividade':
		
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
	
}

?>