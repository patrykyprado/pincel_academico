<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
if($_SERVER["REQUEST_METHOD"] == "GET") {
include('includes/conectar.php');
$matricula = $_GET["matricula"];
$questionario = $_GET["questionario"];
$tentativa = $_GET["tentativa"];
$atual = date("Y-m-d");
$ipativo = $_SERVER["REMOTE_ADDR"];

if(mysql_query("delete from ea_q_feedback where matricula = '$matricula' AND id_questionario = '$questionario' AND tentativa = '$tentativa'")) {
	if(mysql_affected_rows() == 1){
		mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
	VALUES ('$user_usuario','$atual','09','EXCLUIU A TENTATIVA $tentativa DO ALUNO $matricula REFERENTE AO QUESTIONARIO $questionario','$ipativo');");
		echo "<SCRIPT LANGUAGE='JavaScript'>
    alert('TENTATIVA EXCLUIDA COM SUCESSO');
    window.close();
    </SCRIPT>";
	}	
}
} else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOC&Ecirc; N&Atilde;O TEM PERMISSÃO PARA EXCLUIR TENTATIVAS');
    history.back(1);
    </SCRIPT>");
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
                              <b>Tentativa Excluida</b>
                          </header>
                        <div class="panel-body">              
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