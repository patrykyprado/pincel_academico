<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head_inside.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
include_once ("includes/Redimensiona.php");
$get_anograde = $_GET["anograde"];
$get_cod_disc = $_GET["cod_disc"];
$get_aula = $_GET["aula"];

$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
if(mysql_num_rows($sql_verificar_previsto)==1){
	$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
} else {
	$sql_nome_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$get_cod_disc%' AND anograde LIKE '%$get_anograde%' LIMIT 1");
	$dados_disciplina = mysql_fetch_array($sql_nome_disciplina);
	$nome_disciplina = $dados_disciplina["disciplina"];
	
	$sql_cod_disc = mysql_query("SELECT * FROM disciplinas WHERE disciplina LIKE '%$nome_disciplina%' AND anograde LIKE '%$get_anograde%'");
	$codigos_disciplinas = "";
	$contar_codigos = mysql_num_rows($sql_cod_disc);
while($dados_disc = mysql_fetch_array($sql_cod_disc)){
		if($contar_codigos >=2){
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."',";
		} else {
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."'";
		}
		$contar_codigos -=1;
}
$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc IN ($codigos_disciplinas) AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
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
                              <b>Visualizar Planejamento Previsto</b>
                          </header>
                        <div class="panel-body">
<center><img src="<?php echo $dados_previsto["arquivo"];?>" width="700" /></center>

                          </div>
                          <div class="panel-footer">
                              <center><a onClick="ShadowClose()" href="javascript:parent.location.reload();">FECHAR</a></center>
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