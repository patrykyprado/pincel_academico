<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$post_senha_certa = 1;
$post_senha_dig = 1;

if($post_senha_certa != $post_senha_dig){
	echo "<script language=\"javascript\">
	alert('A senha digitada está incorreta.');
	history.back();
	</script>";
} else {

$get_matricula = $_GET["matricula"];
$get_tentativa = $_GET["tentativa"];
$get_questionario = $_GET["questionario"];

//PEGA DADOS DO QUESTIONARIO
$sql_questionario = mysql_query("SELECT * 
FROM ea_questionario eaq
INNER JOIN disciplinas dis
ON eaq.cod_disc = dis.cod_disciplina AND eaq.grupo = dis.anograde
WHERE eaq.id_questionario = '$get_questionario'");
$dados_questionario = mysql_fetch_array($sql_questionario);
$questionario_nivel = $dados_questionario["nivel"];
$questionario_curso = $dados_questionario["curso"];
$questionario_modulo = $dados_questionario["modulo"];
$questionario_disciplina = $dados_questionario["disciplina"];
$questionario_valor = $dados_questionario["valor"];
$questionario_questoes = $dados_questionario["qtd_questoes"] + $dados_questionario["qtd_questoes2"] + $dados_questionario["qtd_questoes3"];

if($questionario_modulo == 1) {
	$questionario_modulo_exib = "I";	
}
if($questionario_modulo == 2) {
	$questionario_modulo_exib = "II";	
}
if($questionario_modulo == 3) {
	$questionario_modulo_exib = "III";	
}

//pega dados do aluno
$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = '$get_matricula'");
$dados_aluno = mysql_fetch_array($sql_aluno);
$nome_aluno = format_curso($dados_aluno["nome"]);
//pega dados da revisão
$sql_revisao_1 = "SELECT * FROM ea_q_feedback WHERE matricula = '$get_matricula' AND tentativa = '$get_tentativa' AND id_questionario = '$get_questionario' AND id_opcao = resposta";
$sql_revisao = mysql_query($sql_revisao_1);

//PEGA DATA E HORA DA HORA
$sql_revisao_limit = mysql_query($sql_revisao_1." LIMIT 1");
$dados_revisao_limit = mysql_fetch_array($sql_revisao_limit);
$data_hora_prova = format_data_hora($dados_revisao_limit["datahora"]);


//CALCULA A NOTA DO ALUNO NA PROVA
$sql_nota = mysql_query("SELECT sum(valor) as total_acerto FROM ea_q_feedback 
WHERE matricula = '$get_matricula' AND tentativa = '$get_tentativa' AND id_questionario = '$get_questionario' AND id_opcao = resposta 
GROUP BY matricula, tentativa, id_questionario");
$dados_nota = mysql_fetch_array($sql_nota);
$total_acerto = $dados_nota["total_acerto"]/100;

//calcula nota final
$nota_final = $total_acerto*($questionario_valor/$questionario_questoes);
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
                              <b>Revis&atilde;o de Prova</b>
                          </header>
                        <div class="panel-body">
<div class="prova-escrita" style="margin-bottom:100px;">

<table width="100%" align="center" border="1" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border:double;">
    <tr>
    	<td width="40%" colspan="2"><img src="images/logo-cedtec.png" /></td>
        <td colspan="2" align="center"><font size="+2"><b>Avalia&ccedil;&atilde;o</b></font></td>
    </tr>
    <tr>
    	<td colspan="2"><b><?php echo $questionario_nivel.": ".$questionario_curso." Mód. ".$questionario_modulo_exib;?></b></td>
        <td width="60%" colspan="2"><b>Componente Curricular: <?php echo $questionario_disciplina; ?></b></td>
    </tr>
    <tr>
    	<td colspan="2"><b>Data: <?php echo $data_hora_prova; ?></b></td>
        <td><b>Valor: <?php echo format_valor($questionario_valor); ?></b></td>
        <td><b>Nota: <?php echo format_valor($nota_final); ?></b></td>
    </tr>
    <tr>
    	<td colspan="4"><b>Nome do(a) Aluno(a):</b> <?php echo $nome_aluno; ?></td>
    </tr>
</table>
<br /><br />
<?php 
$num_questao = 1;
while($dados_revisao = mysql_fetch_array($sql_revisao)){
	$rev_cod_questao = $dados_revisao["cod_questao"];
	$rev_resposta_valor = $dados_revisao["valor"];
	$rev_id_opcao = $dados_revisao["id_opcao"];
	$rev_resposta = $dados_revisao["resposta"];
	$rev_datahora = format_data_hora($dados_revisao["datahora"]);
	//MONTA QUESTÃO DO ALUNO
	$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE cod_questao LIKE '$rev_cod_questao'");
	while($dados_questao = mysql_fetch_array($sql_questoes)){
		$questao_id = $dados_questao["id_questao"];
		$questao_questao = $dados_questao["questao"];
		$questao_cod = $dados_questao["cod_questao"];
		$questao_tipo = $dados_questao["tipo"];
		$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
		echo "
		<table class=\"full_table_list\" border=\"1\" width=\"100%\">
		<tr bgcolor=\"#C1C1C1\">
			<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" align=\"center\" valign=\"top\" width=\"17%\"><b>Questão $n_questao:</b><td>
			<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" colspan=\"2\" valign=\"top\" width=\"80%\"><b><font style=\"font-family:Arial, Helvetica, sans-serif; color:black;\">$questao_questao</font></b><td>
		</tr>";
		
		//PEGA AS RESPOSTAS
		$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod'");
		$num_opcao = 1;
		while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
			$opcaoid = $dados_opcoes["id_resposta"];
			$opcaovalor = $dados_opcoes["valor"];
			$opcaoresposta = $dados_opcoes["resposta"];	
			$letra_opcao = format_letra($num_opcao);
			if($rev_resposta == $opcaoid){
				$resposta_marcada = "<font size=\"+1\">X</font>";	
			} else {
				$resposta_marcada = "";	
			}
			if($opcaovalor >=1){
				$cor_resposta = "bgcolor=\"yellow\"";
			} else {
				$cor_resposta = "";
			}
			echo "
			<tr>
				<td align=\"right\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\" $cor_resposta>$resposta_marcada $letra_opcao </td>
				<td colspan=\"2\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\" $cor_resposta> $opcaoresposta</td>
			<tr>
			";
			$num_opcao += 1;
			if($opcaovalor >=1){
				$letra_opcao_correta = substr($letra_opcao,0,1);
				$gabarito .= "$n_questao - $letra_opcao_correta ,";	
			}
		}
		$num_questao +=1;
		
	 }
}
	mysql_close();
}

?>
</table>
</div>                          </div>
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