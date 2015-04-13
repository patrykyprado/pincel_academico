<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Validação de Inscrição</title>
</head>

<?php 
$host = 'dbmy0052.whservidor.com'; // endereço do seu mysql
$user = 'cedtec1_5'; // usuário
$pass = 'BDPA2013ced'; // senha
$con = mysql_connect($host,$user,$pass); // função de conexão
$db = 'cedtec1_5'; // nome do banco de dados
mysql_select_db($db,$con) or print mysql_error(); // seleção do banco de dados


if($_SERVER["REQUEST_METHOD"] == "GET") {
	//DADOS ALUNO
	$modalidade = strtoupper(utf8_decode($_GET["modal"]));
	$nome = strtoupper(utf8_decode($_GET["nome"]));
	$civil = strtoupper(utf8_decode($_GET["civil"])); 
	$nacionalidade = strtoupper(utf8_decode($_GET["nacionalidade"])); 
	$email = $_GET["email"]; 
	$cpf = strtoupper(utf8_decode($_GET["cpf"]));
	$rg = strtoupper(utf8_decode($_GET["rg"])); 
	$nascimento = strtoupper(utf8_decode($_GET["nascimento"])); 
	$cep = strtoupper(utf8_decode($_GET["cep"])); 
	$cidade = strtoupper(utf8_decode($_GET["cidade"])); 
	$bairro = strtoupper(utf8_decode($_GET["bairro"])); 
	$uf = strtoupper(utf8_decode($_GET["uf"])); 
	$endereco = strtoupper(utf8_decode($_GET["rua"].chr(10).$_GET["num"])); 
	$complemento = strtoupper(utf8_decode($_GET["complemento"])); 
	$telefone = strtoupper(utf8_decode($_GET["telefone"])); 
	$celular = strtoupper(utf8_decode($_GET["celular"])); 
	$mae = strtoupper(utf8_decode($_GET["mae"])); 
	$pai = strtoupper(utf8_decode($_GET["pai"])); 
	$buscar_unidade = strtoupper(utf8_decode($_GET["unidade"])); 
	$cargo = strtoupper(utf8_decode($_GET["cargo"])); 
	$empresa = strtoupper(utf8_decode($_GET["empresa"])); 
	$renda = strtoupper(utf8_decode($_GET["renda"])); 
	$formacao = strtoupper(utf8_decode($_GET["formacao"])); 
	$escola = strtoupper(utf8_decode($_GET["escola"])); 
	$curso = strtoupper(utf8_decode($_GET["curso2"])); 
	$aluno = strtoupper(utf8_decode($_GET["aluno"])); 
	$se_aluno = strtoupper(utf8_decode($_GET["se_aluno"]));
	
	//DADOS FINANCEIRO
	$nome_fin = strtoupper(utf8_decode($_GET["nome_fin"]));
	$rg_fin = strtoupper(utf8_decode($_GET["rg_fin"]));
	$email_fin = $_GET["email_fin"];
	$cpf_fin = strtoupper(utf8_decode($_GET["cpf_fin"])); 
	$cep_fin = strtoupper(utf8_decode($_GET["cep_fin"])); 
	$uf_fin = strtoupper(utf8_decode($_GET["uf_fin"]));
	$cidade_fin = strtoupper(utf8_decode($_GET["cidade_fin"]));
	$bairro_fin = strtoupper(utf8_decode($_GET["bairro_fin"]));
	$end_fin = strtoupper(utf8_decode($_GET["rua_fin"].chr(10).$_GET["num_fin"]));
	$comp_fin = strtoupper(utf8_decode($_GET["comp_fin"]));
	$nasc_fin = strtoupper(utf8_decode($_GET["nasc_fin"]));
	$nacio_fin = strtoupper(utf8_decode($_GET["nacio_fin"]));
	$tel_fin = strtoupper(utf8_decode($_GET["tel_fin"]));
	
	//DADOS FIADOR
	$nome_fia = strtoupper(utf8_decode($_GET["nome_fia"]));
	$rg_fia = strtoupper(utf8_decode($_GET["rg_fia"]));
	$email_fia = $_GET["email_fia"];
	$cpf_fia = strtoupper(utf8_decode($_GET["cpf_fia"])); 
	$cep_fia = strtoupper(utf8_decode($_GET["cep_fia"])); 
	$uf_fia = strtoupper(utf8_decode($_GET["uf_fia"]));
	$cidade_fia = strtoupper(utf8_decode($_GET["cidade_fia"]));
	$bairro_fia = strtoupper(utf8_decode($_GET["bairro_fia"]));
	$end_fia = strtoupper(utf8_decode($_GET["rua_fia"].chr(10).$_GET["num_fia"]));
	$nasc_fia = strtoupper(utf8_decode($_GET["nasc_fia"]));
	$nacio_fia = strtoupper(utf8_decode($_GET["nacio_fia"]));
	$tel_fia = strtoupper(utf8_decode($_GET["tel_fia"]));
	
	$nome_conj = strtoupper(utf8_decode($_GET["nome_conj"]));
	$rg_conj = strtoupper(utf8_decode($_GET["rg_conj"]));
	$cpf_conj = strtoupper(utf8_decode($_GET["cpf_conj"])); 
	$nasc_conj = strtoupper(utf8_decode($_GET["nasc_conj"]));
	$nacio_conj = strtoupper(utf8_decode($_GET["nacio_conj"]));
	
	//DADOS AUTOMÁTICOS
	$datacad = date("d/m/Y");
	$hora = date("H:i:s");
	$noticia = strtoupper(utf8_decode($_GET["noticia"]));
	
	//VALIDA CAMPOS OBRIGATÓRIOS
	if(empty($_GET["nome"]) || empty($_GET["cpf"]) || empty($_GET["email"]) || empty($_GET["rg"]) ||empty($_GET["curso2"]) || $_GET["curso2"]== 'selecione' || $_GET["unidade"]== 'selecione' || $_GET["nivel"]== 'selecione' || $_GET["modal"]== 'selecione'){
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('Atenção! Você esqueceu de preencher algum dado necessário no formulário de cadastro, preencha-o e tente novamente.')
		history.back();
		</SCRIPT>");
	} else {
		
		$unidadepesq    = mysql_query("SELECT * FROM unidades WHERE sigla = '$buscar_unidade'");
		$dadosun = mysql_fetch_array($unidadepesq);
		$unidade = $dadosun["endereco"];
		
		//INSERE DADOS NA TABELA INSCRITOS
		mysql_query("INSERT INTO `inscritos` (`codigo`, `nome`, `civil`, `nacionalidade`, `email`, `cpf`, `rg`, `nascimento`, `cep`, `cidade`, `bairro`, `uf`, `endereco`, `complemento`, `telefone`, `celular`, `mae`, `pai`, `unidade`, `cargo`, `empresa`, `renda`, `formacao`, `escola`, `curso`, `modalidade`, `aluno`, `se_aluno`, `nome_fin`, `rg_fin`, `email_fin`, `cpf_fin`, `cep_fin`, `uf_fin`, `cidade_fin`, `bairro_fin`, `end_fin`, `comp_fin`, `nasc_fin`, `nacio_fin`, `tel_fin`, `nome_fia`, `rg_fia`, `email_fia`, `cpf_fia`, `cep_fia`, `uf_fia`, `cidade_fia`, `bairro_fia`, `end_fia`, `nasc_fia`, `nacio_fia`, `tel_fia`, `nome_conj`, `rg_conj`, `cpf_conj`, `nasc_conj`, `nacio_conj`, `datacad`, `hora`, `noticia`, `grupo`, `vencimento`) VALUES (NULL, '$nome', '$civil', '$nacionalidade', '$email', '$cpf', '$rg', '$nascimento', '$cep', '$cidade', '$bairro', '$uf', '$endereco', '$complemento', '$telefone', '$celular', '$mae', '$pai', '$unidade', '$cargo', '$empresa', '$renda', '$formacao', '$escola', '$curso', '$modalidade', '$aluno', '$se_aluno', '$nome_fin', '$rg_fin', '$email_fin', '$cpf_fin', '$cep_fin', '$uf_fin', '$cidade_fin', '$bairro_fin', '$end_fin', '$comp_fin', '$nasc_fin', '$nacio_fin', '$tel_fin', '$nome_fia', '$rg_fia', '$email_fia', '$cpf_fia', '$cep_fia', '$uf_fia', '$cidade_fia', '$bairro_fia', '$end_fia', '$nasc_fia', '$nacio_fia', '$tel_fia', '$nome_conj', '$rg_conj', '$cpf_conj', '$nasc_conj', '$nacio_conj', '$datacad', '$hora', '$noticia', '$grupo', '$vencimento');");
		
		
	}
	

	
}


?>

<body>
</body>
</html>

<script>  
function backspace(evt) {
    var tecla = (window.event)?event.keyCode:evt.which;
    var backspace = 8;
    if (backspace == tecla) {
        return false;
    }
}
document.onkeydown = backspace;
</script>