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
$nome_arquivo = $get_cod_disc."_".$get_aula."-".substr($get_anograde,0,4);
if (isset($_POST['acao']) && $_POST['acao']=="Salvar"){
	
	$foto = $_FILES['foto'];	
	$previsto = $_POST["previsto"];
	$redim = new Redimensiona();
	$src=$redim->Redimensionar($foto, 700, "../planejamentos",$nome_arquivo);
	$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
	if(mysql_num_rows($sql_verificar_previsto)>=1){
		$dados_previsto = mysql_fetch_array($sql_verificar_previsto);
		if(mysql_query("UPDATE conteudo_previsto SET arquivo = '$src' WHERE cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'")){
		if(mysql_affected_rows()>=1){
			echo "<script language=\"javascript\">
			alert('Planejamento atualizado!!');
			window.close();
			window.opener.location.reload()</script>";
		}
	}

	} else {
		if(mysql_query("INSERT INTO conteudo_previsto (n_aula, cod_disc, ano_grade, arquivo, previsto) VALUES ('$get_aula', '$get_cod_disc', '$get_anograde', '$src', '$previsto')")){
		if(mysql_affected_rows()==1){
			echo "<script language=\"javascript\">
			alert('Planejamento inserido!!');
			window.close();
			window.opener.location.reload()</script>";
		}
		}
		
		
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
                              <b>Alterar Planejamento Previsto</b>
                          </header>
                        <div class="panel-body">
<form method="post" action="" enctype="multipart/form-data">
	<label>Arquivo: <input type="file" name="foto" /></label>
    <textarea name="previsto" class="ckeditor"></textarea>   
    <input type="submit" value="Salvar" />
    <input type="hidden" name="acao" value="Salvar" />
</form>
<?php
if (isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
	echo "<img src=\"$src\">";
}

?>
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