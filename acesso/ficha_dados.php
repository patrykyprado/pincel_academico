<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["codigo"];
$re    = mysql_query("select count(*) as total from geral WHERE codigo = $id" );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from alunos WHERE codigo LIKE $id");
	$dados = mysql_fetch_array($re);		
}
$nome = strtoupper($dados["nome"]);
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
                          <div class="filtro"><header class="panel-heading">
                              <b>Ficha de Dados</b>
                          </header>
                          </div>
                        <div class="panel-body">
  <table width="100%" border="1">
  	<tr>
    <td colspan="2" height="147" bgcolor="#CCCCCC"><div style="float:left" align="Left"><strong><img src="images/logo-color.png" width="130" />
    </strong></div>
    <div align="center" style="margin-left:-15px"><br /><br /><br /><br />
    <B><font size="+1">FICHA DE DADOS - <?php echo $id;?></font></B><br />
    </div>
    <div style="float:right"><br />
    Data de Matricula: <?php echo strtoupper($dados["datacad"]); ?><br />
      Hora: <?php echo strtoupper($dados["hora"]); ?></div></td>
    </tr>
    <tr>
      <td width="22%"><strong>Nome do Aluno:</strong></td>
      <td width="78%"><?php echo (strtoupper($dados["nome"])); ?></td>
    </tr>
    <tr>
      <td><strong>Data de Nascimento:</strong></td>
      <td><?php echo $dados["nascimento"]; ?></td>
    </tr>
    <tr>
      <td><strong>Estado Civil:</strong></td>
      <td><?php echo strtoupper($dados["civil"]); ?></td>
    </tr>
    <tr>
      <td><strong>RG:</strong></td>
      <td><?php echo $dados["rg"]; ?></td>
    </tr>
    <tr>
      <td><strong>CPF:</strong></td>
      <td><?php echo $dados["cpf"]; ?></td>
    </tr>
    <tr>
      <td><strong>E-mail:</strong></td>
      <td><?php echo $dados["email"]; ?></td>
    </tr>
    <tr>
      <td><strong>Telefone(s):</strong></td>
      <td><?php echo $dados["telefone"]; ?> / <?php echo $dados["celular"]; ?> </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#ABABAB"><div align="center" class="titulo">INFORMA&Ccedil;&Otilde;ES ADICIONAIS</div></td>
    </tr>
    <tr>
      <td><strong>Pai:</strong></td>
      <td><?php echo (strtoupper($dados["pai"])); ?></td>
    </tr>
    <tr>
      <td><strong>M&atilde;e:</strong></td>
      <td><?php echo (strtoupper($dados["mae"])); ?></td>
    </tr>
    <tr>
      <td><strong>Unidade:</strong></td>
      <td><?php echo (strtoupper($dados["unidade"])); ?></td>
    </tr>
     <tr>
      <td><strong>Polo:</strong></td>
      <td><?php echo (strtoupper($dados["polo"])); ?></td>
    </tr>
    <tr>
      <td><strong>Curso:</strong></td>
      <td><?php echo (strtoupper($dados["curso"])); ?></td>
    </tr>

    <tr>
      <td colspan="2" bgcolor="#ABABAB"><div align="center" class="titulo">ENDERE&Ccedil;O</div></td>
    </tr>
    <tr>
      <td><strong>Endere&ccedil;o:</strong></td>
      <td><?php echo (strtoupper($dados["endereco"])); ?></td>
    </tr>
    <tr>
      <td><strong>Bairro: </strong></td>
      <td><?php echo (strtoupper($dados["bairro"])); ?> - <?php echo strtoupper($dados["uf"]); ?></td>
    </tr>
    <tr>
      <td><strong>CEP:</strong></td>
      <td><?php echo $dados["cep"]; ?></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#ABABAB"><div align="center" class="titulo">FINANCEIRO</div></td>
    </tr>
    <tr>
      <td><strong>Respons&aacute;vel Fin.:</strong></td>
      <td><?php echo (strtoupper($dados["nome_fin"])); ?></td>
    </tr>
    <tr>
      <td><strong>CPF:</strong></td>
      <td><?php echo $dados["cpf_fin"]; ?></td>
    </tr>
    <tr>
      <td><strong>Endere&ccedil;o:</strong></td>
      <td><?php echo (strtoupper($dados["end_fin"])); ?></td>
    </tr>
    <tr>
      <td><strong>Bairro: </strong></td>
      <td><?php echo (strtoupper($dados["bairro_fin"])); ?></td>
    </tr>
    <tr>
      <td><strong>Cidade: </strong></td>
      <td><?php echo (strtoupper($dados["cidade_fin"])); ?></td>
    </tr>
    <tr>
      <td><strong>E-mail:</strong></td>
      <td><?php echo strtoupper($dados["email_fin"]); ?></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#C0C0C0"><div align="center" class="titulo"><font size="+1">DADOS FIADOR</font></div></td>
    </tr>
    <tr>
      <td><strong>Nome:</strong></td>
      <td><?php echo utf8_encode(strtoupper($dados["nome_fia"])); ?></td>
    </tr>
    <tr>
      <td><strong>CPF:</strong></td>
      <td><?php echo $dados["cpf_fia"]; ?></td>
    </tr>
    <tr>
      <td><strong>CEP:</strong></td>
      <td><?php echo strtoupper($dados["cep_fia"]); ?></td>
    </tr>
    <tr>
      <td><strong>Endere&ccedil;o:</strong></td>
      <td><?php echo utf8_encode(strtoupper($dados["end_fia"])); ?></td>
    </tr>
    <tr>
      <td><strong>Bairro: </strong></td>
      <td><?php echo utf8_encode(strtoupper($dados["bairro_fia"])); ?></td>
    </tr>
    <tr>
      <td><strong>Cidade: </strong></td>
      <td><?php echo utf8_encode(strtoupper($dados["cidade_fia"])); ?></td>
    </tr>
    <tr>
      <td><strong>E-mail:</strong></td>
      <td><?php echo strtoupper($dados["email_fia"]); ?></td>
    </tr>
    <tr>
      <td><strong>Telefone(s):</strong></td>
      <td><?php echo strtoupper($dados["tel_fia"]); ?></td>
    </tr>
</table>

</div>

                          </div>
                          <div class="panel-footer">
                              <center><a onClick="window.parent.Shadowbox.close();">FECHAR</a></center>
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