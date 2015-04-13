<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$n_aula = $_GET["n_aula"];
$data_aula = $_GET["data_aula"];
$turma_disc = $_GET["td"];

$sql = mysql_query("
SELECT DISTINCT vad.matricula, vad.nome, cta.id_turma FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_disc 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");



//enviar post 
 if( isset ( $_POST[ 'Submit' ] ) ) {
		              for( $i = 0 , $x = count( $_POST[ 'id' ] ) ; $i < $x ; ++ $i ) {
						  $pesquisar = mysql_query("SELECT * FROM ced_falta_aluno WHERE  matricula = '".$_POST[ 'id' ][ $i ]."' AND n_aula = '$n_aula' AND turma_disc = '$turma_disc' AND data = '$data_aula' ;");
						  $total = mysql_num_rows($pesquisar);
						  $status = $_POST[ 'falta' ][ $i ];
						  if($total == 0&&$status != "P"){
							mysql_query("INSERT INTO ced_falta_aluno (matricula,turma_disc,data, n_aula,status) VALUES ('".$_POST[ 'id' ][ $i ]."','$turma_disc', '$data_aula','$n_aula','".$_POST[ 'falta' ][ $i ]."');");
						  } else {
							mysql_query("UPDATE ced_falta_aluno SET status = '".$_POST[ 'falta' ][ $i ]."' WHERE  matricula = '".$_POST[ 'id' ][ $i ]."' AND n_aula = '$n_aula' AND turma_disc = '$turma_disc' AND data = '$data_aula';");
						  }
						 
		              }
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Frequências registradas com sucesso!!');
						window.parent.Shadowbox.close();
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
                              <b>Registro de Frequ&ecirc;ncia</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">

  <table width="70%" border="1" align="center" class="table table-hover">
          <td width="116" align="center"><b>NOME</b></td>
      <td width="304">&nbsp;</td>
    </tr>
    
<?php 
	while($dados = mysql_fetch_array($sql)){
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$id_turma = $dados["id_turma"];
		$pesquisar = mysql_query("SELECT * FROM ced_falta_aluno WHERE  matricula = '$codigo' AND n_aula = '$n_aula' AND turma_disc = '$turma_disc' AND data = '$data_aula' ;");
		$total = mysql_num_rows($pesquisar);
		if($total == 1){
			$falta_dados = mysql_fetch_array($pesquisar);
			$exibir_falta = $falta_dados["status"];
		} else {
			$value = "P";
			$exibir_falta = "Presente";
		}
		if($exibir_falta == "F"){
			$value = "F";
			$exibir_falta = "Falta";
		}
		if($exibir_falta == "J"){
			$value = "J";
			$exibir_falta = "Justificado";
		}
		if($exibir_falta == "P"){
			$value = "P";
			$exibir_falta = "Presente";
		}
		
		//verifica cancelados
			$sql_cancelados = mysql_query("SELECT toc.nome, oco.data FROM ocorrencias oco
INNER JOIN tipo_ocorrencia toc
ON oco.n_ocorrencia = toc.id
WHERE oco.n_ocorrencia = 1 AND oco.matricula = $codigo AND oco.id_turma = $id_turma LIMIT 1");
			if(mysql_num_rows($sql_cancelados)>=1){
				$dados_cancelados = mysql_fetch_array($sql_cancelados);
				$nome_ocorrencia = $dados_cancelados["nome"];
				$data_ocorrencia = format_data($dados_cancelados["data"]);
				echo "<tr><td>
					$nome</td>
					<td>
					$nome_ocorrencia em $data_ocorrencia.</td></tr>";
			} else {
		
				echo "<tr><td>
					<input type=\"hidden\" name=\"id[]\" value=\"$codigo\" />$nome</td>
					<td>
					<select name=\"falta[]\">
					
		  <option value=\"$value\" selected=\"selected\">$exibir_falta</option>
		  <option value=\"P\">Presente</option>
		  <option value=\"F\">Falta</option>
		  <option value=\"J\">Justificativa</option>
		</select></td></tr>";
				
			}
	}
	
?>
  
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

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