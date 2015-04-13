<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["id"];
$re    = mysql_query("select count(*) as total from users where id_user = $id AND nivel >=2");	
$total = mysql_result($re, 0, "total");

if($id ==1){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.parent.shadowbox.close();
    </SCRIPT>");
}

if($total == 1) {
	$re    = mysql_query("select * from users where id_user = $id AND nivel >=2");
	
	$dados = mysql_fetch_array($re);
	$nivel = $dados["nivel"];
	$senhaant = $dados["senha"];
	$re3    = mysql_query("select * from nivel_user where nivel = $nivel");
	
	$dados3 = mysql_fetch_array($re3);
	$nomenivel = strtoupper(utf8_encode($dados3["funcao"]));
	
		
}



//POST
if($_SERVER["REQUEST_METHOD"] == "POST") {

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
<form id="form1" name="form1" method="post" action="editar_user.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="nivelant" value="<?php echo $nivel; ?>" />
<input type="hidden" name="senha" value="<?php echo $senhaant; ?>" />
  <table width="350" border="0" align="center" class="full_table_edit">
  	<tr bgcolor="#CCCCCC" align="center">
	<td colspan="2"><strong>N&iacute;vel Atual: <?php echo $nomenivel; ?></strong></td></tr>
    <tr>
      <td>N&iacute;vel de Acesso</td>
      <td><select name="novonivel" class="textBox" id="novonivel">
        <option value="<?php echo $nivel; ?>" selected="selected">Manter N&iacute;vel</option>
        <?php
include("menu/config_drop.php");?>
        <?php
$sql = "SELECT * FROM nivel_user ORDER BY funcao";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['nivel'] . "'>" . strtoupper($row['funcao']) . "</option>";
}
?>
      </select></td>
    </tr>
    <tr>
      <td>Nome</td>
      <td><input name="nome" type="text" class="textBox" id="nome" value="<?php echo $dados["nome"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Usu&aacute;rio</td>
      <td><input name="usuario" type="text" class="textBox" id="usuario" value="<?php echo $dados["usuario"]; ?>" maxlength="100"/></td>
    </tr>

    <tr>
      <td>Senha</td>
      <td><input name="senha" type="text" class="textBox" id="senha" value="<?php echo $dados["senha"]; ?>" maxlength="30"/></td>
    </tr>
    <tr>
    <td>Mudar Senha</td>
    <td><input name="mudar" type="checkbox" id="mudar" value="1" /></td> 
    </tr>
    <tr>
      <td></td>
      <td width="224"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>                          
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