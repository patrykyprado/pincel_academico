<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

//GET DE PESQUISA
$buscar = $_GET["buscar"];
$tipo_cliente = $_GET["tipo_cliente"];

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
                              <b>Pesquisa de T&iacute;tulos a Receber</b>
                          </header>
                          <div class="panel-body">
<form id="form2" name="form1" method="get" action="buscar_receitas.php">
  Nome:
  <input type="text" value="<?php echo $_GET["buscar"];?>" name="buscar" id="buscar" />
  <input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
  <br>
<input type="radio" name="tipo_cliente" id="tipo_cliente" checked value="1"> Aluno | <input type="radio" name="tipo_cliente" id="tipo_cliente" value="2"> Cliente/Fornecedor
</form>
<br><br>
<form id="form1" name="form1" method="get" action="data_receitas.php">
  De: 
  <input type="date" name="dataini" id="dataini" />
At&eacute;: 
<input type="date" name="datafin" id="datafin" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<BR />
<hr>
    
<table class="table table-hover" border="1" align="center">
	<tr style="font-size:14px">
		<td><div align="center"><strong>MATR&Iacute;CULA</strong></div></td>
        <td><div align="center"><strong>NOME</strong></div></td>
        <td><div align="center"><strong>RESP. FINANCEIRO</strong></div></td>
	</tr>
    
<?php
if($user_unidade == 0){
	$sql = mysql_query("SELECT distinct codigo,aluno,financeiro FROM g_cliente_fornecedor WHERE aluno LIKE '%$buscar%' OR financeiro LIKE '%$buscar%' OR codigo LIKE '%$buscar%' ORDER BY aluno");
	$sql2 = mysql_query("SELECT * FROM cliente_fornecedor WHERE (nome LIKE '%$buscar%' OR nome_fantasia LIKE '%$buscar%' OR codigo LIKE '%$buscar%') AND codigo NOT IN (select codigo from alunos)");
} else {
	$sql = mysql_query("SELECT distinct codigo,aluno,financeiro FROM g_cliente_fornecedor WHERE (aluno LIKE '%$buscar%' OR financeiro LIKE '%$buscar%' OR codigo LIKE '%$buscar%') AND unidade LIKE '%$user_unidade%'  ORDER BY aluno");
	$sql2 = mysql_query("SELECT * FROM cliente_fornecedor WHERE (nome LIKE '%$buscar%' OR nome_fantasia LIKE '%$buscar%' OR codigo LIKE '%$buscar%') AND codigo NOT IN (select codigo from alunos)");
}
// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
$count2 = mysql_num_rows($sql2);

// conta quantos registros encontrados com a nossa especificação
if ($count == 0&&$count2 == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    alert('NENHUM RESULTADO ENCONTRADO');
    history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	if($tipo_cliente == 1){
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idcli			 = $dados["codigo"];
		$nome			 = (strtoupper($dados["aluno"]));
		$financeiro			 = (strtoupper($dados["financeiro"]));
        echo "
	<tr>
		<td align=\"center\"><b>$idcli</b></td>
		<td>&nbsp;<a href='buscar_receitas2.php?id=$idcli&aluno=$nome'>$nome</a></td>
		<td>&nbsp;$financeiro</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
	}
	if($tipo_cliente == 2){
	while ($dados2 = mysql_fetch_array($sql2)) {
        // enquanto houverem resultados...
		$idcli			 = $dados2["codigo"];
		$nome			 = strtoupper($dados2["nome"]);
		$financeiro			 = strtoupper($dados2["nome_fantasia"]);
        echo "
	<tr>
		<td align=\"center\"><b>$idcli</b></td>
		<td>&nbsp;<a href='buscar_receitas2.php?id=$idcli&aluno=$nome'>$nome</a></td>
		<td>&nbsp;$financeiro</td>
		\n";
        // exibir a coluna nome e a coluna email
	}
    }
}

?>

</table>
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
    
    
<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('projeto').disabled = false;  
    } else {  
        document.getElementById('projeto').disabled = true;  
    }  
}  
</script> 
