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
	$re    = mysql_query("select * from cliente_fornecedor where codigo = $id");
	
	$dados = mysql_fetch_array($re);
}



//POST
if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$nome         = $_POST["nome"];
$fantasia         = $_POST["fantasia"];
$email         = $_POST["email"];
$tel         = $_POST["telefone"];
$tel2         = $_POST["telefone2"];
$cpf         = $_POST["cpf"];
$rg         = $_POST["rg"];
$cep         = $_POST["cep"];
$uf         = $_POST["uf"];
$cidade         = $_POST["cidade"];
$endereco         = $_POST["endereco"];
$num         = $_POST["numero"];
$complemento         = $_POST["complemento"];




if(@mysql_query("UPDATE cliente_fornecedor SET nome = '$nome',nome_fantasia = '$fantasia',
	email = '$email', telefone='$tel', telefone2= '$tel2',cpf_cnpj= '$cpf',rg= '$rg',cep= '$cep',uf= '$uf',cidade= '$cidade',endereco='$endereco',numero='$num', complemento = '$complemento' WHERE codigo = $id")) {
	
		if(mysql_affected_rows() == 1){
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
<form id="form1" name="form1" method="post" action="editar_forn.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="400" border="0" align="center">
    <tr>
      <td>Nome</td>
      <td><input name="nome" type="text" class="textBox" id="nome" value="<?php echo $dados["nome"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Nome Fantasia</td>
      <td><input name="fantasia" type="text" class="textBox" id="fantasia" value="<?php echo $dados["nome_fantasia"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>E-mail</td>
      <td><input name="email" type="text" class="textBox" id="email" value="<?php echo $dados["email"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Telefone</td>
      <td><input name="telefone" type="text" class="textBox" id="telefone" value="<?php echo $dados["telefone"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Outro Telefone</td>
      <td><input name="telefone2" type="text" class="textBox" id="telefone2" value="<?php echo $dados["telefone2"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>CPF / CNPJ</td>
      <td><input name="cpf" type="text" class="textBox" id="cpf" value="<?php echo $dados["cpf_cnpj"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>RG</td>
      <td><input name="rg" type="text" class="textBox" id="rg" value="<?php echo $dados["rg"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>CEP</td>
      <td><input name="cep" type="text" class="textBox" id="cep" value="<?php echo $dados["cep"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>UF</td>
      <td><input name="uf" type="text" class="textBox" id="uf" value="<?php echo $dados["uf"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Cidade</td>
      <td><input name="cidade" type="text" class="textBox" id="cidade" value="<?php echo $dados["cidade"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Endere&ccedil;o</td>
      <td><input name="endereco" type="text" class="textBox" id="endereco" value="<?php echo $dados["endereco"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>N&ordm;</td>
      <td><input name="numero" type="text" class="textBox" id="numero" value="<?php echo $dados["numero"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Complemento</td>
      <td><input name="complemento" type="text" class="textBox" id="complemento" value="<?php echo $dados["complemento"]; ?>" maxlength="100"/></td>
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