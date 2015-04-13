<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');


$turma = $_GET["turma"];
$p_turno = $_GET["turno"];
$id_turma = $_GET["id_turma"];
$p_polo = trim($_GET["polo"]);
$turma_pesq = mysql_query("SELECT * FROM ced_turma WHERE id_turma LIKE '$id_turma'");
$dados_turma = mysql_fetch_array($turma_pesq);
$max_aluno = $dados_turma["max_aluno"];
$nivel = $dados_turma["nivel"];
$curso = $dados_turma["curso"];
$modulo = $dados_turma["modulo"];
$unidade = $dados_turma["unidade"];
$polo = $dados_turma["polo"];
$turno = $dados_turma["turno"];
$grupo = $dados_turma["grupo"];
$anograde = $dados_turma["anograde"];
if($modulo == 1){
	$moduloexib = "I";
}
if($modulo == 2){
	$moduloexib = "II";
}
if($modulo == 3){
	$moduloexib = "III";
}
if($modulo == 4){
	$moduloexib = "IV";
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
                              <b>Enturma&ccedil;&atilde;o de Aluno</b>
                          </header>
                        <div class="panel-body">
<table width="100%" border="1" class="table table-hover" align="center">
		<tr>
    <th><img src="images/logo-color.png" width="70" /><br />Pincel At&ocirc;mico <br /><font size="-5"><?php echo date("d/m/Y h:m:s");?></font></th>
    <th colspan="2"><center><?php echo "Ano / Módulo: ".$moduloexib; ?><br /><?php echo "[".$turma."] ".$nivel.": ".$curso;?><br /><?php echo $turno;?></center></th>
    </tr>
	<tr bgcolor="#DDDDDD">
        <td><div align="center"><strong>Matr&iacute;cula</strong></div></td>
        <td><div align="center"><strong>Nome</strong></div></td>
	</tr>
<?php

//verifica alunos enturmados
$sql = mysql_query("SELECT * FROM alunos WHERE codigo IN (SELECT cta.matricula FROM ced_turma_aluno cta
INNER JOIN ced_turma ct 
ON ct.id_turma = cta.id_turma WHERE ct.grupo LIKE '$grupo') ORDER BY nome");
//verifica alunos não enturmados
$sql2 = mysql_query("SELECT distinct codigo, nome, grupo FROM geral WHERE grupo LIKE '$grupo' 
AND nivel LIKE '%$nivel%' AND curso LIKE '%$curso%' AND modulo LIKE '%$modulo%' 
AND unidade LIKE '%$unidade%' AND polo LIKE '%$polo%' AND turno LIKE '%$turno%'
AND codigo NOT IN (SELECT A.matricula FROM ced_turma_aluno A 
INNER JOIN ced_turma B ON A.id_turma = B.id_turma WHERE B.grupo LIKE '$grupo' AND B.modulo = '$modulo' AND B.turno LIKE '%$turno%') ORDER BY rand()");




// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$enturmado = mysql_num_rows($sql);
$desenturmado = mysql_num_rows($sql2);
$vagas = $max_aluno - $enturmado;

// conta quantos registros encontrados com a nossa especificação
if ($desenturmado == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM ALUNO DESENTURMADO PARA SER INSERIDO NESSA TURMA');
	window.close();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
$enturmados_atual = 0;
    while (($dados = mysql_fetch_array($sql2))) {
        // enquanto houverem resultados...
		$codigo          = $dados["codigo"];
		$nome          = strtoupper($dados["nome"]);
		$enturmados_atual +=1;
		mysql_query("INSERT INTO  ced_turma_aluno (matricula ,codturma,turno,polo,anograde,id_turma,agrupamento) VALUES ('$codigo', '$turma', '$turno','$polo','$anograde','$id_turma','$id_turma')");
		echo "
		<tr>
        <td><div align=\"center\"><strong>$codigo</strong></div></td>
        <td><div ><strong>$nome</strong></div></td>
	</tr>";
		
		
		
		//PESQUISA DISCIPLINAS DA TURMA
		$sql_disc = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma = '$id_turma'");
		//cadastra as disciplinas do aluno
		while ($dados2 = mysql_fetch_array($sql_disc)){
			$disciplina          = $dados2["codigo"];
			mysql_query("INSERT INTO  ced_aluno_disc (matricula ,turma_disc) VALUES ('$codigo',  '$disciplina');");
		}
		
	
	}
	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('$enturmados_atual alunos enturmados.');
			</SCRIPT>");
		

        // exibir a coluna nome e a coluna email
    
}

?>
               
              </table>           </div>
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