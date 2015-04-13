<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head_ead.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$turma_disc = $_GET["turma_disc"];
$get_professor = $_GET["id"];

//PEGA O USUARIO TUTOR/PROFESSOR
$sql_professor = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = '$turma_disc'");
$dados_professor = mysql_fetch_array($sql_professor);
$codigo_professor = $dados_professor["cod_prof"];
$codigo_turma = $dados_professor["id_turma"];
$codigo_disciplina = $dados_professor["disciplina"];

//PEGA DADOS DA TURMA
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $codigo_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_grade = $dados_turma["anograde"];
$turma_nivel = $dados_turma["nivel"];
$turma_curso = $dados_turma["curso"];
$turma_modulo = $dados_turma["modulo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
$turma_grupo = $dados_turma["grupo"];



//PEGA DADOS DA DISCIPLINA
$sql_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina like '$codigo_disciplina' AND anograde LIKE '$turma_grade'");
$dados_disciplina = mysql_fetch_array($sql_disciplina);
$nome_disciplina = $dados_disciplina["disciplina"];


//PEGA DADOS DO PROFESSOR
$sql_dados_professor = mysql_query("SELECT * FROM acessos_completos WHERE usuario = $get_professor");
$dados_professor_completo = mysql_fetch_array($sql_dados_professor);
$professor_nome = format_curso($dados_professor_completo["nome"]);
$professor_email = format_curso($dados_professor_completo["email"]);

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$destinatario = $professor_email;
	$assunto = "[CEDTEC Virtual] Nova Mensagem - $nome_disciplina";
	$corpo .= "
	<b>Matrícula:</b> $user_usuario<br>
	<b>Nome:</b> $user_nome<br>
	<b>E-mail:</b> $user_email<br>
	<b>Unidade / Polo:</b> $turma_unidade - $turma_polo<br>
	<b>Curso:</b> $turma_nivel - $turma_curso<br>
	<b>Módulo:</b> $turma_modulo<br>
	<b>Grupo:</b> $turma_grupo<br>
	<b>Disciplina:</b> $nome_disciplina<br>
	<b>Mensagem:</b><br><br>";
	$corpo .= $_POST["email_conteudo"];
	
	//para o envio em formato HTML
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									 
	//endereço do remitente
	$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";
								 
	//endereço de resposta, se queremos que seja diferente a do remitente
	$headers .= "Reply-To: $user_email". "\r\n";
									 
	//endereços que receberão uma copia oculta
	$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";
	mail($destinatario,$assunto,$corpo,$headers);
	$datahora = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO ced_emails_enviados (id_email, datahora, de, para, assunto, conteudo)
	VALUES (NULL,'$datahora', '$user_usuario', '$destinatario', '$assunto','$corpo');
	");
	echo "<script language=\"javascript\">
	alert('E-mail enviado com sucesso!');
	window.parent.Shadowbox.close();
	</script>";	
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
                              <b>Enviar e-mail ao Professor</b><br>
                              <font size="-1"><b>Professor:</b> <?php echo $professor_nome;?></font>
                          </header>
                        <div class="panel-body">
						<form action="#" method="POST">
                        <div style="width:100%; background:#E3E3E3; background-color:#E3E3E3;  padding:10px; text-align:center">Mensagem</center></div>
                        <textarea name="email_conteudo" id="email_conteudo" style="width:100%; height:200px;"></textarea><br><br>
                        <center><input type="submit" value="Enviar E-mail"></center>
                        
                        </form>
                          
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