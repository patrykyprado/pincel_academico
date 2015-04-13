<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["id"];

$re    = mysql_query("select count(*) as total from cliente_fornecedor where codigo = $id");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("SELECT A.*, B.email as email_aluno FROM ced_professor A INNER JOIN alunos B ON A.cod_user = B.codigo WHERE codigo = $id");
	$dados = mysql_fetch_array($re);
	
	
	$sql_senha = mysql_query("SELECT * FROM acesso where codigo = $id");
	$dados2 = mysql_fetch_array($sql_senha);
		
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$email         = $_POST["email"];


$nome         = $_POST["nome"];
$cpf         = $_POST["cpf"];
$nascimento         = $_POST["nascimento"];
$documento         = $_POST["documento"];
$emissor         = $_POST["emissor"];
$telefone         = $_POST["telefone"];
$endereco         = $_POST["endereco"];
$bairro         = $_POST["bairro"];
$cidade         = $_POST["cidade"];
$uf         = $_POST["uf"];

$senha         = $_POST["senha"];


include('includes/conectar.php');

mysql_query("UPDATE acesso SET senha = '$senha' WHERE codigo = $id");
if(@mysql_query("UPDATE ced_professor SET email = '$email', CPF = '$cpf', Nome = '$nome', Nascimento = '$nascimento', Documento = '$documento',
Emissor = '$emissor', Telefone = '$telefone', Endereco = '$endereco', Bairro = '$bairro',Cidade = '$cidade', UF = '$uf'  WHERE cod_user = $id")) {
	
		if(mysql_affected_rows() == 1){
			mysql_query("UPDATE acesso_completo SET email_aluno = '$email' WHERE codigo = $id");
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Dados atualizados com sucesso');
			window.parent.location.reload();
			window.parent.Shadowbox.close();
			</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível atualizar os dados.";
			exit;
		}	
		@mysql_close();
	}

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
                              <b>Edi&ccedil;&atilde;o de Usu&aacute;rio</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="editar_professor.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="400" border="0" align="center">
    <tr>
      <td>Nome</td>
      <td><input name="nome" type="text" class="textBox" id="nome" value="<?php echo $dados["Nome"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>E-mail</td>
      <td><input name="email" type="text" class="textBox" id="email" value="<?php echo $dados["email_aluno"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>CPF</td>
      <td><input name="cpf" type="text" class="textBox" id="cpf" value="<?php echo $dados["CPF"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>Nascimento</td>
      <td><input name="nascimento" type="text" class="textBox" id="nascimento" value="<?php echo $dados["Nascimento"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>Documento</td>
      <td><input name="documento" type="text" class="textBox" id="documento" value="<?php echo $dados["Documento"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Emissor</td>
      <td><input name="emissor" type="text" class="textBox" id="emissor" value="<?php echo $dados["Emissor"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Telefone</td>
      <td><input name="telefone" type="text" class="textBox" id="telefone" value="<?php echo $dados["Telefone"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Endereco</td>
      <td><input name="endereco" type="text" class="textBox" id="endereco" value="<?php echo $dados["Endereco"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Bairro</td>
      <td><input name="bairro" type="text" class="textBox" id="bairro" value="<?php echo $dados["Bairro"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>Cidade</td>
      <td><input name="cidade" type="text" class="textBox" id="cidade" value="<?php echo $dados["Cidade"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>UF</td>
      <td><input name="uf" type="text" class="textBox" id="uf" value="<?php echo $dados["UF"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Senha</td>
      <td><input name="senha" type="text" class="textBox" id="senha" value="<?php echo $dados2["senha"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td></td>
      <td width="224"><input type="submit" name="Submit" value="Salvar" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>                          
                          </div>
                          <div class="panel-footer">
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