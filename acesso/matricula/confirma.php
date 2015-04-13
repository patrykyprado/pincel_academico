<head>
  <script language="JavaScript">  
function FormataCpf(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				vr = vr.replace("/", "");
				vr = vr.replace("-", "");
				tam = vr.length + 1;
				if (tecla != 14)
				{
					if (tam == 4)
						campo.value = vr.substr(0, 3) + '.';
					if (tam == 7)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 6) + '.';
					if (tam == 11)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(7, 3) + '-' + vr.substr(11, 2);
				}
			}   
			</script>
<?php require_once('boleto/Connections/local.php'); ?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>

<form action="pesq_inscritos2.php"  method="post" id="valr">
  			  <p align="center">
  			    <label for="item"></label>
  Entre com seu CPF para visualizar sua	inscri&ccedil;&atilde;o		  </p>
  			  <p align="center">
  			    <input type="text" maxlength="14" onKeyUp="FormataCpf(this,event)" name="cpf" id="cpf" />
  			  </p>
  <div align="left">
    <p align="center">&nbsp;</p>
    <p align="center">
      <input type="submit" name="busca" id="busca" value="Buscar" />
    </p>
  </div>
        </form>
</body>
