<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["turma_disc"]; 
include 'includes/conectar.php';

$sql = mysql_query("select * from ea_questionario WHERE turma_disc = $id");

$count = mysql_num_rows($sql);
if($count == 0){
	$botao_novo = "- <a href=\"cad_avaliacao.php?id=$id\">[Nova Avaliação]</a>";
} else {
	$botao_novo = "";	
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
                              <b>Agendamento: Avalia&ccedil;&otilde;es Online <?php echo $botao_novo;?></b>
                          </header>
                        <div class="panel-body">
<table class="table table-hover" border="1" cellspacing="3">
	<tr style="font-size:17px">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
	  <td><div align="center"><strong>Disciplina</strong></div></td>
        <td><div align="center"><strong>Data Inicial</strong></div></td>
        <td><div align="center"><strong>Data Final</strong></div></td>
        <td><div align="center"><strong>Quest&otilde;es</strong></div></td>
        <td><div align="center"><strong>Valor</strong></div></td>
        <td><div align="center"><strong>Tentativa(s)</strong></div></td>
        <td><div align="center"><strong>Senha</strong></div></td>
        <td><div align="center"><strong>Revis&atilde;o de Tentativas</strong></div></td>
        
	</tr>

<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$id_questionario          = ($dados["id_questionario"]);
		$data_inicio          = format_data_hora($dados["data_inicio"]);
		$data_fim          = format_data_hora($dados["data_fim"]);
		$valor          = number_format($dados["valor"],2,",",".");
		$senha          = ($dados["senha"]);
		$tentativas          = ($dados["tentativas"]);
		$cod_disc          = ($dados["cod_disc"]);
		$grupo          = ($dados["grupo"]);
		$qtd_questoes = $dados["qtd_questoes"] + $dados["qtd_questoes2"] + $dados["qtd_questoes3"];
		
		
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=javascript:abrir('alterar_avaliacao.php?codigo=$id_questionario')>[EDITAR]</a></td>
		<td>&nbsp;$cod_disc</td>
		<td align='center'>$data_inicio</td>
		<td align='center'>$data_fim</td>
		<td align='center'>$qtd_questoes</td>
		<td><center>$valor</center></td>
		<td align='center'>$tentativas</td>
		<td align='center'><a href=\"resetar_senha_avaliacao.php?id=$id_questionario\">$senha</a></td>
		<td align='center'><a href=\"revisao_tentativas_avaliacao.php?id=$id_questionario\">[VER]</a></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
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