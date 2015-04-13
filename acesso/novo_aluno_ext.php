<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');


if( isset ( $_POST[ 'salvar' ] ) ) {
$nome = $_POST["nome"];
$cpf = $_POST["cpf"];
$email = $_POST["email"];
$nascimento = $_POST["nascimento"];
$modulo = $_POST["modulo"];
$curso = strtoupper(($_POST["curso"]));
$nivel = strtoupper(($_POST["nivel"]));
$unidade = strtoupper($user_unidade);

if(@mysql_query("INSERT INTO alunos_ext (codigo, nome, cpf,email,nascimento,modulo,curso,unidade,nivel,empresa) VALUES (NULL,'$nome','$cpf'
,'$email','$nascimento','$modulo','$curso','$unidade','$nivel','$user_empresa');")){
	echo "<script language=\"javascript\">
	alert('ALUNO CADASTRADO COM SUCESSO');
	</script>";
	$sql_acesso = mysql_query("SELECT * FROM alunos_ext WHERE cpf LIKE '$cpf' AND unidade LIKE '%$user_unidade%' LIMIT 1");
	$dados_acesso = mysql_fetch_array($sql_acesso);
	$usuario_pincel = $dados_acesso["codigo"];
	$senha_pincel = $dados_acesso["codigo"];
	
	$destinatario = $email;
	$assunto = "[PINCEL ATÔMICO] INFORMAÇÕES DE ACESSO";
		$corpo = "
		<html>
		<head>
		  <title>[CEDTEC] INFORMAÇÕES DE ACESSO</title>
		</head>
		<body>
		<h1>Olá, $nome!</h1>
		<p>
		<b>Seu cadastro foi efetivado no sistema acadêmico Pincel Atômico - Escola Técnica $user_unidade - no curso $curso</b>. <br>
		<br>Para acessar basta digitar o link em seu navegador http://cedtecvirtual.com.br ou, se preferir <a href=\"http://cedtecvirtual.com.br \">CLIQUE AQUI</a> e utilize os dados de acesso abaixo:<br>
		<b>Usuário:</b> $usuario_pincel <br>
		<b>Senha:</b> $senha_pincel
		<br><br><br>--<br>
		<b><font size=\"-1\">Sistema Acadêmico Pincel Atômico</font><br></b>
		<b><font size=\"-2\">Escola Técnica CEDTEC</font><br></b>
		<b> 
		</p>
		</body>
		</html>
		";
		 
		//para o envio em formato HTML
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		//endereço do remitente
		$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";
		 
		//endereço de resposta, se queremos que seja diferente a do remitente
		$headers .= "Reply-To: cobranca.cedtec@gmail.com". "\r\n";
		 
		//endereços que receberão uma copia oculta
		$headers .= "Bcc: ". "\r\n";
		mail($destinatario,$assunto,$corpo,$headers);
	
}



};
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
                              <b>Cadastro de Aluno</b>
                          </header>
                          <div class="panel-body">
<form method="post" action="#">
<table class="full_table_list2" width="60%" align="center">
<tr>
<td width="132">Nome:</td>
<td width="356"><input name="nome" style="width:500px" type="text" /></td>
</tr>
<tr>
<td>CPF:</td>
<td><input name="cpf" type="text" onKeyUp="Mascara('CPF',this,event)" maxlength="14" /> <font size="-2">Somente n&uacute;meros</font></td>
</tr>
<tr>
<td>E-mail:</td>
<td><input name="email" type="text" /></td>
</tr>
<tr>
<td>Data de Nascimento:</td>
<td><input name="nascimento" onKeyUp="Mascara('DATA',this,event)" maxlength="10" type="text" style="width:100px" /> <font size="-2">Somente n&uacute;meros</font></td>
</tr>
<tr>
<td>N&iacute;vel</td>
<td>
<select name="nivel" class="textBox" id="nivel" onKeyPress="return arrumaEnter(this, event)">
        
	<option value="selecione">- Selecione o Nivel -</option>	
	<?php
include('menu/config_drop.php');?>
        <?php
$sql = "SELECT distinct nivel FROM disciplinas WHERE nivel NOT LIKE '%nivel%' ORDER BY nivel";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['nivel']. "'>" . (($row['nivel'])) . "</option>";
}
?>
      </select>
</td>
</tr>
<tr>
<td>Curso</td>
<td>
<select name="curso" class="textBox" id="tipo" onKeyPress="return arrumaEnter(this, event)">
        
	<option value="selecione">- Selecione o Curso -</option>	
	<?php
include('menu/config_drop.php');?>
        <?php
$sql = "SELECT distinct curso FROM disciplinas WHERE curso NOT LIKE '%curso%' ORDER BY curso";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['curso']. "'>" . (($row['curso'])) . "</option>";
}
?>
      </select>
</td>
</tr>
<tr>
<td>M&oacute;dulo:</td>
<td><input name="modulo" type="text" value="1" style="width:30px;" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input name="salvar" id="salvar" type="submit" value="Salvar" /></td>

</tr>
</table>
</form>
</div>
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
    

 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script>
  
<script language="JavaScript" type="text/javascript">
function Mascara(tipo, campo, teclaPress) {
	if (window.event)
	{
		var tecla = teclaPress.keyCode;
	} else {
		tecla = teclaPress.which;
	}
 
	var s = new String(campo.value);
	// Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
	s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');
 
	tam = s.length + 1;
 
	if ( tecla != 9 && tecla != 8 ) {
		switch (tipo)
		{
		case 'CPF' :
			if (tam > 3 && tam < 7)
				campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
			if (tam >= 7 && tam < 10)
				campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
			if (tam >= 10 && tam < 12)
				campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
		break;
 
		case 'CNPJ' :
 
			if (tam > 2 && tam < 6)
				campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
			if (tam >= 6 && tam < 9)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
			if (tam >= 9 && tam < 13)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
			if (tam >= 13 && tam < 15)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
		break;
 
		case 'TEL' :
			if (tam > 2 && tam < 4)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
			if (tam >= 7 && tam < 11)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
		break;
 
		case 'DATA' :
			if (tam > 2 && tam < 4)
				campo.value = s.substr(0,2) + '/' + s.substr(2, tam);
			if (tam > 4 && tam < 11)
				campo.value = s.substr(0,2) + '/' + s.substr(2,2) + '/' + s.substr(4,tam-4);
		break;
		
		case 'CEP' :
			if (tam > 5 && tam < 7)
				campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
		break;
		}
	}
}
</script>