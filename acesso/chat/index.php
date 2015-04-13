<?php
	session_start();
	include_once "config.php";
	include_once "classes/bd.class.php";
	BD::conn();
?>

<!doctype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta charset="iso-8859-1">
<title>Entre no Chat</title>
<style type="text/css">
	*{
	margin:0; padding:0;	
	}
	body{
		background:#E1E1E1;	
	}
	div#formulario{width:500px; padding:5px; height:90px; background:#fff; border:1px solid #333333;
	position:absolute; left:50%; top: 50%;margin-left:-250px; margin-top:-45px;
	}
	div#formulario span{font:18px "Trebuchet MS", tahora, arial;color:#003366; float:left; width:100%; margin-bottom:10px;
	
	}
	div#formulario input[type=text]{padding:5px; width:490px; border:1px solid #ccc; outline:none; font:16px  tahoma, arial; color:#666
	}
	
	div#formulario input[type=text]:focus{
	border-color:#1100F7;		
	}
	div#formulario input[type=submit]{
	padding:4px 6px; background:#069; font:15px tahoma, arial; color: #fff; border:1px solicd #036;
	float:left; margin-top:5px;text-align:center; width:95px; text-shadow:#000 0 1px 0;
	}
</style>
</head>

<body>
<?php
	if(isset($_POST['acao']) && $_POST['acao']=='logar'):
			$usuario = $_POST['usuario'];
			$senha = $_POST['senha'];
			
			if($usuario == '' || $senha = ''){
				
			} else {
				$pegar_user = BD::conn()->prepare("SELECT id FROM 'users' WHERE usuario = ? AND senha = ?");
				$pegar_user->execute(array($usuario,$senha));
				if($pegar_user->rowCount() == 0){
					echo "<script>alert('Usuário não encontrado');</script>";
				} else {
					$fetch = $pegar_user->fetchObject();
					$_SESSION["id_user"] = $fetch->id_user;
					echo "<script>alert('Usuário Logado');location.href='chat.php'</script>";
				}
			}
	endif;
?>
<div id="formulario">
        <span>Digite seu usuario</span>
        <form action="" method="post" enctype="multipart/form-data">
            <label>
                <input type="text" name="usuario"/>
                <input type="password" name="senha"/>
            </label>
            <input type="hidden" name="acao" value="logar"/>
            <input type="submit" value="Logar"/>
        </form>
    </div>
    
</body>
</html>