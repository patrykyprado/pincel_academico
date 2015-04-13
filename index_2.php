<?php require_once('Connections/conexao.php'); 
 
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}



if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['senha'];
  $MM_fldUserAuthorization = "nivel";
  include('conectar.php');
  $sql_app = mysql_query("SELECT * FROM config_app WHERE id_config = 1");
  $dados_app = mysql_fetch_array($sql_app);
  if($dados_app["modo_manutencao"]==1){
	  header("Location: manutencao.php" );
  } else {
  
  //realiza login
  $login_usuario = (int)$loginUsername;
  $aluno_sql = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$login_usuario' AND senha LIKE '$password'");
  $total_aluno = mysql_num_rows($aluno_sql);
  if($total_aluno>=1){
	  $usuario_login = (int)$loginUsername;
	  $usuario_senha = $password;
	$sql_final =  "SELECT * FROM acessos_completos WHERE  usuario='$usuario_login' AND senha='$usuario_senha'";
	$redirect = "acesso_academico/index.php";
  } else {
	  $sql_final =  "SELECT * FROM users WHERE  usuario='$loginUsername' AND senha='$password'";
		$redirect = "acesso/index.php";
  }
  
  
  $MM_redirectLoginSuccess = $redirect;
  $MM_redirectLoginFailed = "index.php?erro=1&id=$loginUsername";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexao, $conexao);
  	
  $LoginRS__query=sprintf($sql_final,
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexao) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'nivel');
	$loginStrName = mysql_result($LoginRS,0,'nome');
	$loginAcessos = mysql_result($LoginRS,0,'acessos');
	$loginId_user = mysql_result($LoginRS,0,'id_user');
	$loginEmail = mysql_result($LoginRS,0,'email');
	$loginUnidade = mysql_result($LoginRS,0,'unidade');
	$loginEmpresa = mysql_result($LoginRS,0,'empresa');
	$loginFoto = mysql_result($LoginRS,0,'foto_perfil');
	$loginSenha = mysql_result($LoginRS,0,'senha');
	$loginSetor = mysql_result($LoginRS,0,'setor');
	
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['MM_Nome'] = $loginStrName;	
	$_SESSION['MM_Acessos'] = $loginAcessos;
	$_SESSION['MM_iduser'] = $loginId_user;	 
	$_SESSION['MM_email'] = $loginEmail;
	$_SESSION['MM_unidade'] = $loginUnidade;
	$_SESSION['MM_empresa'] = $loginEmpresa;
	$_SESSION['MM_Foto'] = $loginFoto;
	$_SESSION['MM_Senha'] = $loginSenha;
	$_SESSION['MM_Setor'] = $loginSetor;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
}
if(isset($_GET["erro"])){
	$erro = $_GET["erro"];
} else {
	$erro = 0;
}
include('conectar.php');
$sql_app = mysql_query("SELECT * FROM config_app WHERE id_config = 1");
$dados_app = mysql_fetch_array($sql_app);


if($_GET["rec"]==1){
	$post_usuario = $_GET["id"];
	$sql_verificar = mysql_query("SELECT * FROM acessos_completos WHERE usuario = '$post_usuario'");	
	if(mysql_num_rows($sql_verificar)==0){
		$sql_verificar = mysql_query("SELECT * FROM users WHERE usuario = '$post_usuario'");	
	}
	if(mysql_num_rows($sql_verificar)==0){
		echo "<script language=\"javascript\">
		alert('Dados não conferem, procure a secretaria para normalizar seu acesso.');
		location.href='index.php';
		</script>";
	} else {
		$dados_verificar = mysql_fetch_array($sql_verificar);
		$user_usuario = $dados_verificar["usuario"];
		$user_senha = $dados_verificar["senha"];
		$user_email = $dados_verificar["email"];
		$user_nome = $dados_verificar["nome"];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		 
		//endereço do remitente
		$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";		 
		//endereço de resposta, se queremos que seja diferente a do remitente
		$headers .= "Reply-To: patryky@cedtec.com.br". "\r\n";			 
		//endereços que receberão uma copia oculta
		$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";
		
		$mesagem1 = "Olá <b>$user_nome</b>,
		<br><br>
		Foi solicitado o lembrete de sua senha através do nosso site, segue abaixo dados de acesso:
		<br><br>
		<b>Usuário / Matrícula:</b> $user_usuario<br>
		<b>Senha:</b> $user_senha
		<br><br>
		Caso não tenha solicitado o lembrete de senha desconsidere este e-mail.
		<br><br>
		--<br>
		Atenciosamente<br>
		<b>Escola Técnica CEDTEC</b><br>
		<i>Educação Profissional Levada a Sério</i>";
		
		$assunto = "[CEDTEC] Lembrete de Senha";
		$destinatario =$user_email;
		mail($destinatario,$assunto,$mesagem1,$headers);
		echo "<script language=\"javascript\">
		alert('Seus dados de acesso foram enviados para o e-mail cadastrado.');
		location.href='index.php';
		</script>";

		
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Pincel At&ocirc;mico - Sistema Acad&ecirc;mico</title>

    <!-- Bootstrap core CSS -->
    <link href="acesso/css/bootstrap.min.css" rel="stylesheet">
    <link href="acesso/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="acesso/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="acesso/css/style.css" rel="stylesheet">
    <link href="acesso/css/style-responsive.css" rel="stylesheet" />
    <style type="text/css">
    body,td,th {
	font-family: "Open Sans", sans-serif;
}
    </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="acesso/js/html5shiv.js"></script>
    <script src="acesso/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="lock-screen" onload="startTime()">

    <div class="lock-wrapper">

        


      <div class="lock-box text-center">
        <h1><div id="time2"></div></h1>
          <?php 
if($erro==1){
	echo "<div class=\"erro\"><a style=\"color:#FFF\" href=\"index.php?rec=1&id=".$_GET["id"]."\">Usuário ou senha inválida!<br>Clique aqui e receba o seus dados de acesso diretamente no e-mail cadastrado.</a></div><br>";
}
if($erro==2){
	echo "<div class=\"erro\">Usuário bloqueado.</div><br>";
}
?>

<?php
 if($dados_app["modo_manutencao"]==1){
	echo "<div class=\"erro\">Estamos em manutenção temporária, tente novamente em alguns minutos.</div><br>"; 
 } else {
 echo "
             <form role=\"form\" class=\"form-inline\" target=\"_top\" action=\"#\" method=\"post\">
            
            	<table>
                <tr>
                	<td align=\"right\"><b>Usuário:</b></td>
                    <td> <input type=\"text\" placeholder=\"Usuário / Matrícula\" name=\"usuario\" id=\"exampleInputPassword2\" class=\"form-control lock-input\"></td>
                </tr>
                <tr>
                	<td  align=\"right\"><b>Senha:</b></td>
                    <td><input type=\"password\" placeholder=\"Senha\" name=\"senha\" id=\"exampleInputPassword2\" class=\"form-control lock-input\"></td>
                </tr>
				
                <tr>
                <td colspan=\"2\" align=\"center\" style=\"padding-left:40px;\"><br><button class=\"btn btn-lock\" type=\"submit\">
                        Acessar
                    </button></td>
                </tr>
                </table>
               
            </form>
  
 ";
 }
?>
<a style="color:#FFFFFF" href="recuperar_senha.php">Esqueceu a sua senha? Clique aqui e recupere.</a>
        </div> 
    </div>
<script>
        function startTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
            document.getElementById('time2').innerHTML=h+":"+m+":"+s;
            t=setTimeout(function(){startTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }
    </script>
</body>
</html>
