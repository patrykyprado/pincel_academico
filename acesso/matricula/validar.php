<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Validação de Inscrição</title>
</head>

<?php 
include('conectar.php');


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
	$se_aluno = strtoupper(utf8_decode($_GET["se_aluno"]));
	$aluno = strtoupper(utf8_decode($_GET["aluno"]));
	
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
	$curso = $_GET["curso2"];
	$parcelas = $_GET["parcela"];
	$nome_conj = strtoupper(utf8_decode($_GET["nome_conj"]));
	$rg_conj = strtoupper(utf8_decode($_GET["rg_conj"]));
	$cpf_conj = strtoupper(utf8_decode($_GET["cpf_conj"])); 
	$nasc_conj = strtoupper(utf8_decode($_GET["nasc_conj"]));
	$nacio_conj = strtoupper(utf8_decode($_GET["nacio_conj"]));
	$dia_venc = strtoupper(utf8_decode($_GET["diavenc"]));
	
	//DADOS AUTOMÁTICOS
	$datacad = date("d/m/Y");
	$hora = date("H:i:s");
	$noticia = strtoupper(utf8_decode($_GET["noticia"]));
	
	
if(isset($_GET["aluno_resp"])){
	$nome_fin = $nome;
	$rg_fin = $rg;
	$email_fin = $email;
	$cpf_fin = $cpf; 
	$cep_fin = $cep; 
	$uf_fin = $uf;
	$cidade_fin = $cidade;
	$bairro_fin = $bairro;
	$end_fin = $endereco;
	$comp_fin = $complemento;
	$nasc_fin = $nascimento;
	$nacio_fin = $nacionalidade;
	$tel_fin = $telefone;
	$civil_fin = $civil;
} else {
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
	$civil_fin = strtoupper(utf8_decode($_GET["civil_fin"]));
	
}
	
	//VALIDA CAMPOS OBRIGATÓRIOS
	if(empty($_GET["nome"]) || empty($_GET["cpf"]) || empty($_GET["email"]) || empty($_GET["rg"]) ||empty($_GET["curso2"]) || $_GET["curso2"]== 'selecione' || $_GET["unidade"]== 'selecione' || $_GET["modal"]== 'selecione'){
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('Atenção! Você esqueceu de preencher algum dado necessário no formulário de cadastro, preencha-o e tente novamente.')
		history.back();
		</SCRIPT>");
	} else {
		
		$unidadepesq    = mysql_query("SELECT * FROM unidades WHERE sigla = '$buscar_unidade'");
		$dadosun = mysql_fetch_array($unidadepesq);
		$unidade = $dadosun["endereco"];
		
		$cursopesq    = mysql_query("SELECT * FROM cursosead WHERE codigo = '$curso'");
		$dadoscur = mysql_fetch_array($cursopesq);
		$nivel = $dadoscur["tipo"];
		$cursoemail = $dadoscur["curso"];
		$email_on = $dadoscur["email"];
		
		
		$modalpesq    = mysql_query("SELECT * FROM modalidade WHERE id_mod = '$modalidade'");
		$dadosmod = mysql_fetch_array($modalpesq);
		$modalnome = $dadosmod["modalidade"];
		
		//INSERE DADOS NA TABELA INSCRITOS
		mysql_query("INSERT INTO `inscritos` (`codigo`, `nome`, `civil`, `nacionalidade`, `email`, `cpf`, `rg`, `nascimento`, `cep`, `cidade`, `bairro`, `uf`, `endereco`, `complemento`, `telefone`, `celular`, `mae`, `pai`, `unidade`, `cargo`, `empresa`, `renda`, `formacao`, `escola`, `aluno`, `se_aluno`, `nome_fin`, `rg_fin`, `email_fin`, `cpf_fin`, `cep_fin`, `uf_fin`, `cidade_fin`, `bairro_fin`, `end_fin`, `comp_fin`, `nasc_fin`, `nacio_fin`, `tel_fin`, `nome_fia`, `rg_fia`, `email_fia`, `cpf_fia`, `cep_fia`, `uf_fia`, `cidade_fia`, `bairro_fia`, `end_fia`, `nasc_fia`, `nacio_fia`, `tel_fia`, `nome_conj`, `rg_conj`, `cpf_conj`, `nasc_conj`, `nacio_conj`, `datacad`, `hora`, `noticia`, `civil_fin`, `curso`, `parcelas`, `modalidade`, `dia_venc`) VALUES (NULL, '$nome', '$civil', '$nacionalidade', '$email', '$cpf', '$rg', '$nascimento', '$cep', '$cidade', '$bairro', '$uf', '$endereco', '$complemento', '$telefone', '$celular', '$mae', '$pai', '$unidade', '$cargo', '$empresa', '$renda', '$formacao', '$escola', '$aluno', '$se_aluno', '$nome_fin', '$rg_fin', '$email_fin', '$cpf_fin', '$cep_fin', '$uf_fin', '$cidade_fin', '$bairro_fin', '$end_fin', '$comp_fin', '$nasc_fin', '$nacio_fin', '$tel_fin', '$nome_fia', '$rg_fia', '$email_fia', '$cpf_fia', '$cep_fia', '$uf_fia', '$cidade_fia', '$bairro_fia', '$end_fia', '$nasc_fia', '$nacio_fia', '$tel_fia', '$nome_conj', '$rg_conj', '$cpf_conj', '$nasc_conj', '$nacio_conj', '$datacad', '$hora', '$noticia', '$civil_fin', '$curso', '$parcelas', '$modalidade','$dia_venc');");
		
		$destinatario = "$email";
		$assunto = "[CEDTEC] INFORMAÇÃO DE INSCRIÇÃO";
		$corpo = "
		<html>
		<head>
		  <title>[CEDTEC] INFORMAÇÃO DE INSCRIÇÃO</title>
		</head>
		<body>
		<h1>Olá, $nome!</h1>
		<p>
		<b>Seja bem-vindo(a) a Escola Técnica CEDTEC</b>. <br>
		<br>Você agora está em nosso cadastro como interessado no $nivel : $cursoemail na modalidade $modalnome.<br>
		Agora faltam apenas mais alguns passos para efetivar sua matrícula e fazer parte da melhor Escola Técnica do Brasil:<br>
		<b>1.</b> Imprimir contrato - <a href=\"http://cedtec.com.br/apps/matricula/pesq_inscritos.php?cpf=$cpf\"/>CLIQUE AQUI</a>.<br>
		<b>2.</b> Imprimir o boleto referente a 1ª parcela - <a href=\"http://cedtec.com.br/apps/matricula/pesq_inscritos.php?cpf=$cpf\"/>CLIQUE AQUI</a>.<br>
		<b>3.</b> Realizar o pagamento do boleto em qualquer agência bancária, caixas eletrônicos, casas lotéricas e outros locais de recebimento de títulos. Você também pode ir até a Escola e pagar o seu boleto , em dinheiro, na tesouraria.<br>
		<b>4.</b> Levar documentação necessária na escola conforme estabelecido pela instituição - <a href=\"http://cedtec.com.br\"/>CLIQUE AQUI</a><br><br>
		Você acabou de tomar uma grande decisão em sua vida! Fique sabendo que estamos contentes por nos escolher e deixar-nos fazer parte de sua história de sucesso.<br><br><br>
		<b><font size=\"+1\">Escola Técnica CEDTEC</font><br></b>
		<i>Educação Profissional Levada a Sério</i>
		<b> 
		</p>
		</body>
		</html>
		";
		 
		//para o envio em formato HTML
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		 
		//endereço do remitente
		$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";
		 
		//endereço de resposta, se queremos que seja diferente a do remitente
		$headers .= "Reply-To: comunicacao@cedtec.com.br". "\r\n";
		 
		//endereços que receberão uma copia oculta
		$headers .= "Bcc: christianocorrea@cedtec.com.br". "\r\n";
		if($email_on == 1){
			mail($destinatario,$assunto,$corpo,$headers);
		}
		echo "<div align='center'><h1>Olá, ".utf8_encode($nome)."!</h1>
		<b>Seja bem-vindo(a) a Escola Técnica CEDTEC.</b><br>
		<br>Você agora está em nosso cadastro como interessado no ".utf8_encode($nivel)." : ".utf8_encode($cursoemail)." na modalidade ".utf8_encode($modalnome)."<br><br>

Agora faltam apenas mais alguns passos para efetivar sua matrícula e fazer parte da melhor Escola Técnica do Brasil:<br>
<b>1.</b> Imprimir contrato - <a href=\"http://cedtec.com.br/apps/matricula/pesq_inscritos.php?cpf=$cpf\"/>CLIQUE AQUI</a>.<br>
<b>2.</b> Imprimir o boleto referente a 1ª parcela - <a href=\"http://cedtec.com.br/apps/matricula/pesq_inscritos.php?cpf=$cpf\"/>CLIQUE AQUI.</a><br>
<b>3.</b> Realizar o pagamento do boleto em qualquer agência bancária, caixas eletrônicos, casas lotéricas e outros locais de recebimento de títulos. Você também pode ir até a Escola e pagar o seu boleto , em dinheiro, na tesouraria.<br>
<b>4.</b> Levar documentação necessária na escola conforme estabelecido pela instituição - <a href=\"http://cedtec.com.br/\"/>CLIQUE AQUI</a><br><br>
Você acabou de tomar uma grande decisão em sua vida! Fique sabendo que estamos contentes por nos escolher e deixar-nos fazer parte de sua história de sucesso.<br><br>
<br><b><font size=\"+1\">Escola Técnica CEDTEC</font><br></b>
		<i>Educação Profissional Levada a Sério</i></div>";
				
			}
	

	
}


?>

<body>
<div class="imprimir" align="center"><a target="_blank" href="pesq_inscritos.php?cpf=<?php echo $cpf; ?>"><img src="icones/imprimir.png" alt="IMPRIMIR CONTRATO" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="boleto/boleto_banestes.php?cpf=<?php echo $cpf?>&amp;grupo=AutoCAD" target="_blank"><img src="icones/icone_boleto.png" alt="GERAR BOLETO" /></a></div>
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