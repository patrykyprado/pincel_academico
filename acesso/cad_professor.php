<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');


if($_SERVER["REQUEST_METHOD"] == "POST") {
$nome        = $_POST["nome"];
$email         = $_POST["email"];
$cpf      = $_POST["cpf"];
$rg      = $_POST["rg"];
$emissor      = $_POST["emissor"];
$admissao      = $_POST["admissao"];
$bairro      = $_POST["bairro"];
$telefone      = $_POST["tel"];
$endereco      = $_POST["rua"];
$uf      = $_POST["uf"];
$cidade      = $_POST["cidade"];
$tipo      = $_POST["tipo"];
if($tipo == 1){
	$curso ="PROFESSOR";
	$turma ="PROFESSOR";	
}
if($tipo == 2){
	$curso ="FORNECEDOR";
	$turma ="FORNECEDOR";	
}
if($tipo == 3){
	$curso ="ALUNO";
	$turma ="ALUNO";	
}
if($tipo == 4){
	$curso ="FUNCIONÁRIO";
	$turma ="FUNCIONÁRIO";	
}

include('includes/conectar.php');
if(@mysql_query("INSERT INTO ced_professor (cod_user, CPF,Nome, Nascimento, Civil, Documento, Emissor, Telefone, Admissao, Endereco, Bairro, Cidade, UF, email)
VALUES (NULL , '$cpf','$nome', '$nascimento', '$civil', '$rg', '$emissor', '$telefone','$admissao','$endereco','$bairro','$cidade','$uf','$email')")) {

	if(mysql_affected_rows() == 1){
		echo "
		<script language=\"javascript\">
		alert('Professor cadastrado com sucesso.');
		</script>";
		$ver = mysql_query("select * from ced_professor where cpf LIKE '%$cpf%' LIMIT 1");
		$dados_ver = mysql_fetch_array($ver);
		$cod2 = $dados_ver["cod_user"];
		$nome_usuario = strtoupper(strstr($nome," ",-60));
		$sobrenome_usuario = strtoupper(strstr($nome," "));
		include('includes/conectar_md.php');
		mysql_query("INSERT INTO ced_user (username,password, firstname,lastname, email,city, country, lang, timezone, confirmed,mnethostid) VALUES ('$cod2',MD5('$cod2'),'$nome_usuario','$sobrenome_usuario','$email','PROFESSOR','BR','pt_br',99,1,1)");
		
		$conferiremail = stripos($email,"@");
		$conferiremail2 = stripos($email,".");
		if($conferiremail == false || $conferiremail2 == false){
			$destinatario ="cobranca@cedtec.com.br";
		} else {
			$destinatario = "$email";
			}
		
		$assunto = "[CEDTEC] SISTEMA ACADÊMICO";
		$corpo = "
		<html>
		<head>
		  <title>[CEDTEC] SISTEMA ACADÊMICO</title>
		</head>
		<body>
		<h2>Caro Professor(a) $nome_usuario,</h2>
		<p>Seja bem-vindo ao CEDTEC.<br>
		  <br>
		  Para sua comodidade segue abaixo seus dados de acesso ao sistema acadêmico como professor.</p>
		<br>
		Usuário: $cod2
		Senha: $cod2
		";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
		//endereço do remitente
		$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";
		 
		//endereço de resposta, se queremos que seja diferente a do remitente
		$headers .= "Reply-To: comunicacao@cedtec.com.br". "\r\n";
			 
		//endereços que receberão uma copia oculta
		$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";
		mail($destinatario,$assunto,$corpo,$headers);
		
		
		
	}

} else {
	if(mysql_errno() == 1062) {
		echo $erros[mysql_errno()];
		exit;
	} else {	
		echo "Erro nao foi possivel efetuar o registro";
		exit;
	}	
	@mysql_close();
}

}
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Cadastro de Professor</b>
                          </header>
                          <div class="panel-body">
                <form action="cad_professor.php" method="POST" onKeyPress="return arrumaEnter(this, event)">
                <table  width="50%" align="center">
<tr>
	<td align="right" width="20%"><b>Nome:</b></td>
    <td><input id="nome" name="nome" type="text" placeholder="Informe o Nome" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>CPF:</b></td>
    <td><input id="cpf" name="cpf" type="text" placeholder="Informe o CPF" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>E-mail:</b></td>
    <td><input id="email" name="email" type="text" placeholder="Informe o E-mail" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>Telefone:</b></td>
    <td><input id="tel" name="tel" type="text" placeholder="Informe o Telefone" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>RG:</b></td>
    <td><input id="rg" name="rg" type="text" placeholder="Informe o RG" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>Emissor:</b></td>
    <td><input id="emissor" name="emissor" type="text" placeholder="Informe o Orgão Emissor" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>Rua:</b></td>
    <td><input id="rua" name="rua" type="text" placeholder="Nome da Rua / Logradouro" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>N&uacute;mero:</b></td>
    <td><input id="num" name="num" type="text" placeholder="Número" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>Bairro:</b></td>
    <td><input id="bairro" name="bairro" type="text" placeholder="Informe o Bairro" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>Cidade:</b></td>
    <td><input id="cidade" name="cidade" type="text" placeholder="Informe a Cidade" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>UF:</b></td>
    <td><input id="uf" name="uf" type="text" placeholder="Informe o UF" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right" width="20%"><b>Admiss&atilde;o:</b></td>
    <td><input id="admissao" name="admissao" type="date" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
                          <input id="tipo" name="tipo" type="hidden" placeholder="TIPO" required onKeyPress="return arrumaEnter(this, event)" value="1"/>
<tr>
    <td colspan="2" align="center"><input type="submit" name="Cadastrar" id="Cadastrar" value="Cadastrar"></td>
</tr>


                </form>  
                
                </table>  
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

	    <script type="text/javascript">
		$(function(){
			$('#cc3').change(function(){
				if( $(this).val() ) {
					$('#cc4').hide();
					$('.carregando').show();
					$.getJSON('cc4.ajax.php?search=',{cc3: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc4 + '">' + j[i].nome_cc4 + '</option>';
						}	
						$('#cc4').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc4').html('<option value="">– CC4 –</option>');
				}
			});
		});
		</script>
        




	    <script type="text/javascript">
		$(function(){
			$('#cc4').change(function(){
				if( $(this).val() ) {
					$('#cc5').hide();
					$('.carregando').show();
					$.getJSON('cc5.ajax.php?search=',{cc4: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc5 + '">' + j[i].nome_cc5 + '</option>';
						}	
						$('#cc5').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc5').html('<option value="">– CC5 –</option>');
				}
			});
		});
		</script>
        
        
        
	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#fornecedor').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
						}	
						$('#fornecedor').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#fornecedor').html('<option value="">– Cliente-Fornecedor –</option>');
				}
			});
		});
		</script>
        
<script language="javascript">
function arrumaEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
var i;
for (i = 0; i < field.form.elements.length; i++)
if (field == field.form.elements[i])
break;
i = (i + 1) % field.form.elements.length;
field.form.elements[i].focus();
return false;
}
else
return true;
}
</script>
    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
    
    
<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('projeto').disabled = false;  
    } else {  
        document.getElementById('projeto').disabled = true;  
    }  
}  
</script> 
