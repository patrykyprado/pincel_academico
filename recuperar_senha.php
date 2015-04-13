<?php
include('conectar.php');
$sql_app = mysql_query("SELECT * FROM config_app WHERE id_config = 1");
$dados_app = mysql_fetch_array($sql_app);

if($_SERVER["REQUEST_METHOD"]== "POST"){
	$post_usuario = $_POST["usuario"];
	$post_email = $_POST["email"];
	$sql_verificar = mysql_query("SELECT * FROM acessos_completos WHERE usuario like '$post_usuario' AND email like '$post_email'");	
	if(mysql_num_rows($sql_verificar)==0){
		$sql_verificar = mysql_query("SELECT * FROM users WHERE usuario like '$post_usuario' AND email like '$post_email'");	
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
        <img style="position:relative; left:0px; top:0px; border:0px;" src="<?php echo $dados_app["logo_app"]?>" alt="lock avatar">
            <h1><div id="time2"></div></h1>
            <?php 
if($erro==1){
	echo "<div class=\"erro\"><a style=\"color:#FFF\" href=\"recuperar_senha.php\">Usuário ou senha inválidos, tente novamente.<br>Caso não lembre seus dados de acesso clique aqui</a></div><br>";
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
             <form role=\"form\" class=\"form-inline\" action=\"#\" method=\"post\">
            
            	<table>
                <tr>
                	<td align=\"right\"><b>Usuário:</b></td>
                    <td> <input type=\"text\" placeholder=\"Usuário / Matrícula\" name=\"usuario\" id=\"exampleInputPassword2\" class=\"form-control lock-input\"></td>
                </tr>
                <tr>
                	<td  align=\"right\"><b>E-mail:</b></td>
                    <td><input type=\"text\" placeholder=\"E-mail\" name=\"email\" id=\"exampleInputPassword2\" class=\"form-control lock-input\"></td>
                </tr>
				
                <tr>
                <td colspan=\"2\" align=\"center\" style=\"padding-left:40px;\"><br><button class=\"btn btn-lock\" type=\"submit\">
                        Recuperar
                    </button></td>
                </tr>
                </table>
               
            </form>
 
 ";
 }
?>

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
