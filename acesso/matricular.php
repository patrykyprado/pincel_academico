<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["id"];

$re    = mysql_query("select count(*) as total from inscritos where codigo = $id");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("select * from inscritos where codigo = $id");
	$dados = mysql_fetch_array($re);
	$curso2 =  $dados["curso"];
	
	$re2    = mysql_query("SELECT * FROM cursosead WHERE codigo = $curso2");
	$dados2 = mysql_fetch_array($re2);
		
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$mat = mysql_query("SELECT * FROM inscritos WHERE codigo = $id");
$dados = mysql_fetch_array($mat);

$cod2 = $dados["codigo"];
$nome = $dados["nome"];
$nacionalidade = $dados["nacionalidade"];
$civil = $dados["civil"];
$email2 = $dados["email"];
$cpf = $dados["cpf"];
$rg = $dados["rg"];
$nascimento = $dados["nascimento"];
$cep = $dados["cep"];
$cidade = $dados["cidade"];
$bairro = $dados["bairro"];
$uf = $dados["uf"];
$endereco = $dados["endereco"];
$complemento = $dados["complemento"];
$tel2 = $dados["telefone"];	
$tel3 = $dados["celular"];
$mae = $dados["mae"];
$pai = $dados["pai"];
$cargo = $dados["cargo"];
$empresa = $dados["empresa"];
$renda = $dados["renda"];
$formacao = $dados["formacao"];
$escola = $dados["escola"];
$aluno = $dados["aluno"];
$se_aluno = $dados["se_aluno"];
								
								
//OUTROS DADOS
$fin2 = $dados["nome_fin"];
$civil_fin = $dados["civil_fin"];
$email_fin = $dados["email_fin"];
$rg2 = $dados["rg_fin"];
$cpf2 = $dados["cpf_fin"];	
$cep2 = $dados["cep_fin"];
$uf_fin = $dados["uf_fin"];				
$cidade_fin = $dados["cidade_fin"];
$bairro2 = $dados["bairro_fin"];
$end_fin = $dados["end_fin"];
$comp_fin = $dados["comp_fin"];
$nasc_fin = $dados["nasc_fin"];
$nacio_fin = $dados["nacio_fin"];
$tel_fin = $dados["tel_fin"];
$nome_fia = $dados["nome_fia"];
$rg_fia = $dados["rg_fia"];
$email_fia = $dados["email_fia"];
$cpf_fia = $dados["cpf_fia"];
$cep_fia = $dados["cep_fia"];
$uf_fia = $dados["uf_fia"];
$cidade_fia = $dados["cidade_fia"];
$bairro_fia = $dados["bairro_fia"];
$end_fia = $dados["end_fia"];
$nasc_fia = $dados["nasc_fia"];
$nacio_fia = $dados["nacio_fia"];
$tel_fia = $dados["tel_fia"];
$nome_conj = $dados["nome_conj"];
$rg_conj = $dados["rg_conj"];
$cpf_conj = $dados["cpf_fia"];
$nasc_conj = $dados["nasc_fia"];
$nacio_conj = $dados["nacio_conj"];
$datacad = $dados["datacad"];
$hora = $dados["hora"];
$noticia = $dados["noticia"];
$unidade = $dados["unidade"];
$dia_venc = $dados["dia_venc"];	
								
//dados do curso
$modalidade = $dados["modalidade"];
$parcela = $dados["parcelas"];
$curso2 = $dados["curso"];


$cursopesq2   = mysql_query("SELECT * FROM cursosead WHERE codigo = '$curso2'");
$dadoscur2 = mysql_fetch_array($cursopesq2);
$curso3 = strtoupper($dadoscur2["curso"]);
$nivel = strtoupper($dadoscur2["tipo"]);
$turno = strtoupper($dadoscur2["turno"]);
$modcurso = $dadoscur2["modulo"];
$venc_curso = substr($dadoscur2["vencimento"],0,7)."-".$dia_venc;
$contapadrao = $dadoscur2["conta"];
$grupo_curso = trim(strtoupper($dadoscur2["grupo"]));
$desconto_sistema = trim(strtoupper($dadoscur2["desconto_sistema"]));
$desconto = $dadoscur2["desconto"];
$desconto_1 = $dadoscur2["desconto_1"];
$valor = $dadoscur2["valor"]/$parcela;
//pega dados de desconto se houver
$sql_desconto = mysql_query("SELECT * FROM ced_bolsas WHERE matricula = '$id' AND curso = '$curso2'");
if(mysql_num_rows($sql_desconto)==0){
	$desconto_bolsa = $desconto;	
} else {
	$dados_desconto = mysql_fetch_array($sql_desconto);
	$desconto_bolsa = $dados_desconto["desconto"];
}

if($modalidade == 2){
		$unidade_bolsa = "EAD";
		$polo_bolsa = $unidade;	
	} else {
		$unidade_bolsa = $unidade;
		$polo_bolsa = $unidade;
	}
	$data_inicio = date("Y-m-d");
	$descricao = "Desconto gerado pelo SISTEMA";
	$origem = $grupo_curso;

if($desconto_sistema ==1){
	mysql_query("INSERT INTO ced_bolsas (id_bolsa, matricula, unidade, polo, curso, desconto_1, desconto, inicio_desconto, autorizado, descricao, origem) VALUES (NULL, '$id','$unidade_bolsa', '$polo_bolsa', '$curso2',
	'$desconto_1', '$desconto_bolsa', '$data_inicio', 'Sistema', '$descricao', '$origem')");
}


if($modalidade ==1){
	$unidade = $dados["unidade"];
	$unidade2 = strstr($unidade,"-",-34);
	$senha = str_replace("/","",$nascimento);
	$nome_usuario = strstr($nome," ",-60);
	$sobrenome_usuario = strstr($nome," ");
	$polo = strstr($unidade,"-",-34);
} else {
	$unidade = $dados["unidade"];
	$unidade2= "EAD";
	$senha = str_replace("/","",$nascimento);
	$nome_usuario = strstr($nome," ",-60);
	$sobrenome_usuario = strstr($nome," ");
	$polo = strstr($unidade,"-",-34);
}

$datapag = date("Y-m-d");

$grupopesq = mysql_query("SELECT * FROM grupos WHERE status = 1 AND grupo LIKE '%$grupo_curso%'");
$grdados = mysql_fetch_array($grupopesq);
$grupo = $grdados["grupo"];
$venc_grupo = $grdados["vencimento"];

$venc	= $dados["vencimento"];
$vencimento = $venc_curso;




// CENTRO DE CUSTO EMPRESA 1
$cc1 = 10;
									
// CENTRO DE CUSTO FILIAL 2
$cc2final = $dadoscur2["filial"];

									
// CENTRO DE CUSTO 3
$cc3 = 21;
									
// CENTRO DE CUSTO 4
$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$cc3%' AND nome_cc4 LIKE '%$nivel%'  LIMIT 1");
$c4dados = mysql_fetch_array($sql_cc4);
$cc4 = $c4dados["cc4"];

									
// CENTRO DE CUSTO DO CURSO 5
$cc5    = mysql_query("SELECT * FROM cc5 WHERE id_cc5 LIKE '$cc4' AND nome_cc5 LIKE '%$curso3%'");
$cdados = mysql_fetch_array($cc5);
$cc5final = $cdados["cc5"];
									
// CENTRO DE CUSTO FINAL
$c_custo = $cc1.$cc2final.$cc3.$cc4.$cc5final;

//INSERE DADOS NO MOODLE SE FOR ALUNO EAD									
if($modalidade == 2 ||$modalidade == 1){
	include('includes/conectar_md.php');
	mysql_query("INSERT INTO ced_user (username,password, firstname,lastname, email,city, country, lang, timezone, confirmed,mnethostid) VALUES ('$cod2',MD5('$senha'),'$nome_usuario','$sobrenome_usuario','$email2','$polo','BR','pt_br',99,1,1)");
}	


//CRIA ACESSO AO ACADÊMICO DO ALUNO
include('includes/conectar.php');
mysql_query("INSERT INTO acesso (codigo, senha, status, nivel) VALUES ('$cod2','$senha', '1','1')");
mysql_query("INSERT INTO comp_acesso (id_user, usuario, nivel, acessos,unidade,empresa,foto_perfil) VALUES (NULL,'$cod2','90','90', 'CEDTEC','10','images/perfil/sem_foto.jpg')");	

//INSERE DADOS NA TABELA CLIENTE FORNECEDOR
mysql_query("INSERT INTO cliente_fornecedor (codigo, nome, email, telefone,telefone2,cpf_cnpj,rg,endereco,numero,complemento,cep,tipo) VALUES ('$cod2','$fin2', '$email2','$tel2','$tel3','$cpf2','$rg2','$bairro2','9999','ALUNO','$cep2','3')");
//INSERE DADOS NA TABELA ALUNOS
mysql_query("INSERT INTO `alunos` (`codigo`, `nome`, `civil`, `nacionalidade`, `email`, `cpf`, `rg`, `nascimento`, `cep`, `cidade`, `bairro`, `uf`, `endereco`, `complemento`, `telefone`, `celular`, `mae`, `pai`, `cargo`, `empresa`, `renda`, `formacao`, `escola`, `aluno`, `se_aluno`, `nome_fin`, `rg_fin`, `email_fin`, `cpf_fin`, `cep_fin`, `uf_fin`, `cidade_fin`, `bairro_fin`, `end_fin`, `comp_fin`, `nasc_fin`, `nacio_fin`, `tel_fin`, `nome_fia`, `rg_fia`, `email_fia`, `cpf_fia`, `cep_fia`, `uf_fia`, `cidade_fia`, `bairro_fia`, `end_fia`, `nasc_fia`, `nacio_fia`, `tel_fia`, `nome_conj`, `rg_conj`, `cpf_conj`, `nasc_conj`, `nacio_conj`, `datacad`, `hora`, `noticia`, `civil_fin`) VALUES ($cod2, '$nome', '$civil', '$nacionalidade', '$email2', '$cpf', '$rg', '$nascimento', '$cep', '$cidade', '$bairro', '$uf', '$endereco', '$complemento', '$tel2', '$tel3', '$mae', '$pai', '$cargo', '$empresa', '$renda', '$formacao', '$escola', '$aluno', '$se_aluno', '$fin2', '$rg2', '$email_fin', '$cpf2', '$cep2', '$uf_fin', '$cidade_fin', '$bairro2', '$end_fin', '$comp_fin', '$nasc_fin', '$nacio_fin', '$tel_fin', '$nome_fia', '$rg_fia', '$email_fia', '$cpf_fia', '$cep_fia', '$uf_fia', '$cidade_fia', '$bairro_fia', '$end_fia', '$nasc_fia', '$nacio_fia', '$tel_fia', '$nome_conj', '$rg_conj', '$cpf_conj', '$nasc_conj', '$nacio_conj', '$datacad', '$hora', '$noticia', '$civil_fin');");
//INSERE DADOS NA TABELA CURSO_ALUNO
mysql_query("INSERT INTO curso_aluno (matricula, nivel, curso,modulo, grupo, turno, unidade, polo) VALUES ('$cod2','$nivel', '$curso3','$modcurso','$grupo_curso','$turno','$unidade2','$polo')");
//ATUALIZA VENCIMENTO
mysql_query("UPDATE inscritos SET vencimento = '$venc_grupo' WHERE codigo = $cod2");
//ATUALIZA TABELA BAIXAS
mysql_query("INSERT INTO  baixas (`codigo` ,`valor_pagto` ,`data_pagto`) VALUES ('$cod2',  '$valor',  '$datapag');");






//INSERI DADOS NA TABELA TITULOS
$re = mysql_query("SELECT * FROM inscritos WHERE codigo = $id");
	while($l = mysql_fetch_array($re)) {
		$parcela = $dados["parcelas"];
		$parcelas		= 1;
		$processamento2 = date("Y-m-d H:i:s:").microtime();
		$datahoje = date("Y-m-d");
			while($parcelas <= $parcela){
				if(@mysql_query("INSERT INTO titulos(cliente_fornecedor,dt_doc, descricao, vencimento, valor, desconto, parcela, tipo, c_custo,valor_pagto,conta) VALUES( (SELECT codigo FROM inscritos WHERE codigo LIKE $id),'$contapadrao', 'Boleto Aluno','$vencimento','$valor','$desconto_bolsa','$parcelas','2','$c_custo','','$contapadrao')")) {			
						if(mysql_affected_rows() == 1){
							$parcelas += 1;
				//CALCULA SALDO APÓS MATRÍCULA NOVA
								for ($i = 1; $i <= $parcelas; $i++)
									$vencimento = date("Y-m-d", strtotime(" " . $i-1 . " Month", strtotime($venc_curso)));
									}	
						} else {
							if(mysql_errno() == 1062) {
								echo $erros[mysql_errno()];
								exit;
						} else {	
								echo "";
								exit;
							}
						@mysql_close();
						}
								}
								}
	
	}
$destinatario = "$email2";
$assunto = "[CEDTEC] Acesso Portal Acadêmico CEDTEC";
$corpo = "
								<html>
								<head>
								  <title>[CEDTEC] Bem-vindo ao CEDTEC</title>
								</head>
								<body>
								<h2>Caro(a) $nome,</h2>
								<p>Sua matrícula já foi efetivada e agora você é um &quot;aluno CEDTEC&quot;.<br>
								  Para acessar seu ambiente acadêmico basta clicar em &quot;Sistema Acadêmico&quot; no nosso site. Digite a sua matrícula (usuário) e a senha inicial.</p>
								<p><b>Usuário/Matrícula:</b> $cod2<br>
       							<b>Senha:</b> $senha</p>
								<p>A senha inicial é a sua data de nascimento com todos os dígitos sem as barras. Altere sua senha no primeiro acesso evitando senhas óbvias.                                
								<p>No ambiente acadêmico você terá acesso aos seus dados acadêmicos e financeiros, poderá emitir declarações e acessar o EAD CEDTEC.                                
								<p>                                
								<p>Seja bem-vindo ao CEDTEC!
								<p>&nbsp;</p>
								<p>--<br>
								  Atenciosamente</p>
								<p><br>
								  <b><font size=\"+1\">Escola Técnica CEDTEC</font><br>
								  </b>
								  <i>Educação Profissional Levada a Sério</i> </p>
								</body>
								</html>";
//para o envio em formato HTML
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									 
//endereço do remitente
$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";
								 
//endereço de resposta, se queremos que seja diferente a do remitente
$headers .= "Reply-To: comunicacao@cedtec.com.br". "\r\n";
									 
//endereços que receberão uma copia oculta
$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";
mail($destinatario,$assunto,$corpo,$headers);
if($vencimento !=""){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('MATRÍCULADO COM SUCESSO!!')
    window.close();
    </SCRIPT>");
}
?>

  <body>

  <section id="container" class="sidebar-closed">


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Confirma&ccedil;&atilde;o de Matr&iacute;cula</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="matricular.php">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="100%" border="1" class="table table-hover" align="center">
    <tr>
      <td width="20%" align="right">Matr&iacute;cula</td>
      <td width="80%"><input name="matricula" style="width:100%" type="text" class="textBox" id="aluno" value="<?php echo $dados["codigo"]; ?>" maxlength="10" readonly/></td>
    </tr>
    
    <tr>
      <td width="20%" align="right">Nome</td>
      <td width="80%"><input name="aluno" style="width:100%" type="text" class="textBox" id="aluno" value="<?php echo $dados["nome"]; ?>" maxlength="10" readonly/></td>
    </tr>
	<tr>
      <td align="right">Unidade</td>
      <td><input name="unidade" type="text" style="width:100%" class="textBox" id="unidade" value="<?php echo $dados["unidade"]; ?>" maxlength="10" readonly/></td>
    </tr>
    <tr>
      <td align="right">Curso</td>
      <td><input name="curso" type="text" style="width:100%" class="textBox" id="curso" value="<?php echo $dados2["tipo"].": ".$dados2["curso"]; ?>" maxlength="10" readonly/></td>
    </tr>

    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" value="Receber Matrícula" style="cursor:pointer;" /></td>
    </tr>
  </table>
</form>

                          </div>
                          <div class="panel-footer">
                              <center><a onClick="ShadowClose()" href="javascript:parent.location.reload();">FECHAR</a></center>
                          </div>
                      </section>
                 
              </div>
              </div>
              
              <!-- page end-->
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


    

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o cliente/fornecedor? '))
{
location.href="apagar_forn.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar_forn.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
function enviar(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor2').value = valor;
this.close();
}
</script>
    </script>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
     
<script>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 