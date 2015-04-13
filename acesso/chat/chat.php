
<?php
	include('../includes/restricao.php');
	include_once "config.php";
?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title>Bem vindo ao Chat</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/chat.js"></script>

</head>

<body>
<div id="contatos">
	<ul>
    	<li><?php echo $user_iduser;?><a href="javascript:void(0);" nome="Renan Matias" id="113" class="comecar">Renan Matias</a></li>
    </ul>
    <ul>
    	<li><a href="javascript:void(0);" nome="Patryky Prado" id="1" class="comecar">Patryky Prado</a></li>
    </ul>
	
</div>
<div id="janelas"></div>
</body>
</html>

