<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$id_turma = $_GET["id_turma"];
$matricula = $_GET["matricula"];
$turma_disc = $_GET["turma_disc"];

//PEGA DADOS DO ALUNO
$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = $matricula");
$dados_aluno = mysql_fetch_array($sql_aluno);

//PEGA DADOS DA DISCIPLINA
$sql_disciplinas = mysql_query("SELECT ctd.codigo, d.disciplina, d.ch 
FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
WHERE ct.id_turma = $id_turma");


if($_SERVER["REQUEST_METHOD"] == "POST") {
$data_solicitacao = $_POST["data_solicitacao"];
$id_turma = $_POST["id_turma"];
$matricula = $_POST["matricula"];
$turma_disc = $_POST["turma_disc"];

	//PEGA AS DISCIPLINAS SELECIONADAS
	for( $i = 0 , $x = count( $_POST[ 'disciplina' ] ) ; $i < $x ; ++ $i ) {
		$post_cod_disciplina = $_POST[ 'disciplina' ][$i];
		$justificativas = "";
		for( $i2 = 0 , $x2 = count( $_POST[ 'justificativa' ] ) ; $i2 < $x2 ; ++ $i2 ) {
			$justificativas .= $_POST[ 'justificativa' ][$i2].",";
		}
		mysql_query("INSERT INTO ced_aproveitamento (id_aproveitamento, matricula, id_turma, turma_disc, data_solicitacao, justificativas) VALUES (NULL, '$matricula', '$id_turma', '$post_cod_disciplina', '$data_solicitacao', '$justificativas')");

		
	}
	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Solicitação Registrada Com Sucesso!!');
			window.parent.location.reload();
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
                          <div class="filtro"><header class="panel-heading">
                              <b>Solicita&ccedil;&atilde;o de Aproveitamento de Estudos</b>
                          </header>
                          </div>
                        <div class="panel-body">
<form id="form1" name="form1" method="POST"  enctype="multipart/form-data" action="solicitacao_aproveitamento.php">
<input type="hidden" name="matricula" value="<?php echo $matricula; ?>" />
<input type="hidden" name="turma_disc" value="<?php echo $turma_disc; ?>" />
<input type="hidden" name="id_turma" value="<?php echo $id_turma; ?>" />

  <table width="70%" border="0" align="center" class="full_table_cad">
  <tr>
        <td width="116"><b>Matr&iacute;cula</b></td>
      <td width="304"><input name="nome" type="text" readonly class="textBox" id="nome" value="<?php echo $matricula; ?>" maxlength="100"/></td>
    </tr>
    <tr>
        <td width="116"><b>Nome</b></td>
      <td width="304"><input name="nome" style="width:400px;" type="text" readonly class="textBox" id="nome" value="<?php echo $dados_aluno["nome"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td><b>Data de Solicita&ccedil;&atilde;o</b></td>
      <td><input name="data_solicitacao" type="date" class="textBox" id="data_solicitacao" value="<?php echo date("Y-m-d")?>"  maxlength="100"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#DBDBDB"><b>Disciplinas</b></td>
      </tr>
       <tr>
      <td colspan="2">
      <?php 
	  while($dados_disciplinas = mysql_fetch_array($sql_disciplinas)){
		  $disciplina_codigo = $dados_disciplinas["codigo"];
		  $disciplina_nome = $dados_disciplinas["disciplina"];
		  echo "
		  <input type=\"checkbox\" name=\"disciplina[]\" id=\"disciplina[]\" value=\"$disciplina_codigo\" /> $disciplina_nome<br>";
	  }
	  
	  ?>
      
      
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#DBDBDB"><b>Justificativa</b></td>
      </tr>
       <tr>
      <td colspan="2">
      <input type="checkbox" name="justificativa[]" value="1" /> Aproveitamento de estudos e experi&ecirc;ncias anteriores de cursos: T&eacute;cnico, Superior ou Ensino M&eacute;dio Profissionalizante.<br>
      <input type="checkbox" name="justificativa[]" value="2" /> Aproveitamento de estudos e experiências anteriores de cursos de Qualificação Profissional.<br>
      <input type="checkbox" name="justificativa[]" value="3" /> Aproveitamento de experiências anteriores no exercício profissional.<br>
      <input type="checkbox" name="justificativa[]" value="4" /> Reprovação no módulo cursado, solicitando dispensa do(s) componente(s) curricular(es) aprovados.<br>
      <input type="checkbox" name="justificativa[]" value="5" /> Nova opção de curso na instituição, solicitando aproveitamento de estudos para o(s) componente(s) curricular(es) aprovado(s).<br>
      <input type="checkbox" name="justificativa[]" value="6" /> Reingresso em curso da instituição com grade curricular que sofreu alterações.<br>
      </td>
    </tr>
           <tr>
      <td colspan="2" align="center">
      	<br><br><input type="submit" value="Enviar Solicitação"/>
      </td>
    </tr>
    
 
  </table>

</form>
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
  <script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('turma').disabled = false;  
    } else {  
        document.getElementById('turma').disabled = true;  
    }  
}  
</script> 