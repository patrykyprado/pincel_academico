<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id_turma = $_GET["id_turma"];
$matricula = $_GET["matricula"];

//PEGA DADOS DA TURMA
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_curso = $dados_turma["curso"];
$turma_nivel = $dados_turma["nivel"];
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
$turma_grade = $dados_turma["anograde"];


//PEGA DISCIPLINAS DA TURMA
$sql_disciplinas = mysql_query("SELECT ctd.codigo, d.disciplina, d.ch 
FROM ced_turma_disc ctd
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = '$turma_grade'
WHERE ctd.id_turma = $id_turma");

//POST
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$tabela_resposta = "";
	for( $i = 0 , $x = count( $_POST[ 'id_aproveitamento' ] ) ; $i < $x ; ++ $i ) {
		$post_id_aproveitamento = $_POST[ 'id_aproveitamento' ][$i];
		$post_nota = $_POST[ 'nota' ][$i];
		$post_escola = $_POST[ 'instituicao' ][$i];
		$post_conclusao = $_POST[ 'conclusao' ][$i];
		$post_status = $_POST[ 'status' ][$i];
		//PEGA E-MAIL DO ALUNO PARA ENVIAR RESPOSTA
		$sql_disciplinas_respostas = mysql_query("SELECT alu.nome, alu.email, d.disciplina, ct.nivel, ct.curso, ct.modulo, ct.unidade, ct.polo, ct.grupo
FROM alunos alu INNER JOIN ced_aproveitamento cap ON cap.matricula = alu.codigo
INNER JOIN ced_turma_disc ctd
ON ctd.codigo = cap.turma_disc
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON d.anograde = ct.anograde AND ctd.disciplina = d.cod_disciplina WHERE cap.id_aproveitamento = $post_id_aproveitamento");
		$dados_resposta = mysql_fetch_array($sql_disciplinas_respostas);
		$email_resposta = $dados_resposta["email"];
		$aluno_resposta = $dados_resposta["nome"];
		$aluno_turma = $dados_resposta["nivel"].": ".$dados_resposta["curso"]." - Mód. ".$dados_resposta["modulo"]."<br><b>Grupo/Semestre:</b> ".$dados_resposta["grupo"]."<br>"."<b>Unidade/Polo:</b> ".$dados_resposta["unidade"]." / ".$dados_resposta["polo"];
		if($post_status == 0){
			$resposta_texto = "<font color=\"blue\">Pendente</font>";
			
		}
		if($post_status == 1){
			$resposta_texto = "<font color=\"green\">Deferido</font>";

		}
		if($post_status == 2){
			$resposta_texto = "<font color=\"red\">Indeferido</font>";
		}
		$tabela_resposta .= "<tr>
		<td>".$dados_resposta["disciplina"]."</td>
		<td align=\"center\">".format_valor($post_nota)."</td>
		<td align=\"center\">".$resposta_texto."</td>
		</tr>"; 
		$data_hora_aproveitamento = date("Y-m-d H:i:s");
		mysql_query("UPDATE ced_aproveitamento SET nota = '$post_nota', instituicao = '$post_escola', conclusao = '$post_conclusao', status = '$post_status', autorizacao = '$user_usuario', datahora_aprovacao = '$data_hora_atual' WHERE id_aproveitamento = $post_id_aproveitamento");

	}
	
		//envia e-mail
		$conferiremail = stripos($email_resposta,"@");
		$conferiremail2 = stripos($email_resposta,".");
		if($conferiremail == false || $conferiremail2 == false){
			$destinatario ="cobranca@cedtec.com.br";
		} else {
			$destinatario = "$email_resposta";
			}
		
		$assunto = "[CEDTEC] Resposta Aproveitamento de Estudos";
		$corpo = "
		<html>
		<head>
		  <title>[CEDTEC] Resposta Aproveitamento de Estudos</title>
		</head>
		<body>
		<h2>Prezado aluno(a) $aluno_resposta,</h2>
		<p>Em resposta ao seu requerimento para aproveitamento de estudos e/ou experiências anteriores, considerando a análise e parecer do Coordenador de Curso, segue abaixo resultado:<br>
		<b>Turma:</b> $aluno_turma
		<br><br>
		<table border=\"1\" style=\"border:solid;\" align=\"center\" width=\"100%\">
		<tr bgcolor=\"#DCDCDC\">
			<td align=\"center\"><b>Disciplina</b></td>
			<td align=\"center\"><b>Nota de Aproveitamento</b></td>
			<td align=\"center\"><b>Resultado</b></td>
		</tr>
		$tabela_resposta
		</table>
		<br><br><br>
		Observações:<br>
		- Processo registrado e arquivado na secretaria da escola. <br>
		- Nota miníma para aprovação: 60,00 pontos. <br> <br> <br>
		Legenda: <br> 
		
		*<font color=\"blue\">Pendente</font>: Processo em análise.<br>
		*<font color=\"green\">Deferido</font>: Processo concluído e aprovado.<br>
		*<font color=\"red\">Indeferido</font>: Processo concluído e reprovado.<br>
		
		";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
		//endereço do remitente
		$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";
		 
		//endereço de resposta, se queremos que seja diferente a do remitente
		$headers .= "Reply-To: comunicacao@cedtec.com.br". "\r\n";
			 
		//endereços que receberão uma copia oculta
		$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";
		mail($destinatario,$assunto,$corpo,$headers);
	
	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Alterações foram salvas com sucesso!');
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
                              <b>Aproveitamento de Estudos</b>
                          </header>
                          </div>
                        <div class="panel-body">
<form action="ver_aproveitamento.php" method="post">
<table border="1" class="table table-hover">
<tr bgcolor="#CFCFCF">
	<td align="center"><b>Disciplina</b></td>
    <td align="center"><b>Carga Hor&aacute;ria</b></td>
    <td align="center"><b>Situa&ccedil;&atilde;o Atual</b></td>
    <td align="center"><b>Nota Aprov.</b></td>
    <td align="center"><b>Escola Aprov.</b></td>
    <td align="center"><b>Ano Aprov.</b></td>
    <td align="center"><b>Situa&ccedil;&atilde;o Aprov.</b></td>
</tr>

<?
while($dados_disciplinas = mysql_fetch_array($sql_disciplinas)){
	$disciplina_cod = $dados_disciplinas["codigo"];
	$disciplina_nome = $dados_disciplinas["disciplina"];
	$disciplina_ch = $dados_disciplinas["ch"];
	
	//VERIFICA SE HÁ ALGUM APROVEITAMENTO SOLICITADO
	$sql_aproveitamento = mysql_query("SELECT * FROM ced_aproveitamento WHERE id_turma = $id_turma AND turma_disc = $disciplina_cod");
	if(mysql_num_rows($sql_aproveitamento)==0){
		$aproveitamento_status = "Não Solicitado";
		$campo_nota = "--";
		$campo_escola = "--";
		$campo_conclusao = "--";
		$campo_situacao = "--";
	} else {
		$dados_aproveitamento = mysql_fetch_array($sql_aproveitamento);
		$aproveitamento_codigo = $dados_aproveitamento["status"];
		$aproveitamento_id = $dados_aproveitamento["id_aproveitamento"];
		$aproveitamento_nota = $dados_aproveitamento["nota"];
		$aproveitamento_institucao = $dados_aproveitamento["instituicao"];
		$aproveitamento_conclusao = $dados_aproveitamento["conclusao"];
		if($aproveitamento_codigo == 0){
			$aproveitamento_status = "<font color=\"blue\">Pendente</font>";
			
		}
		if($aproveitamento_codigo == 1){
			$aproveitamento_status = "<font color=\"green\">Deferido</font>";

		}
		if($aproveitamento_codigo == 2){
			$aproveitamento_status = "<font color=\"red\">Indeferido</font>";
		}
		
		$campo_nota = "<input type=\"hidden\" name=\"id_aproveitamento[]\" value=\"$aproveitamento_id\"/>
		<input type=\"text\" name=\"nota[]\" value=\"$aproveitamento_nota\"/>";
		$campo_escola = "<input type=\"text\" name=\"instituicao[]\" value=\"$aproveitamento_institucao\"/>";
		$campo_conclusao = "<input type=\"text\" name=\"conclusao[]\" value=\"$aproveitamento_conclusao\"/>";
		$campo_situacao = "<select name=\"status[]\">
     <option value=\"$aproveitamento_codigo\" selected>$aproveitamento_status</option>
     <option value=\"0\">Pendente</option>
     <option value=\"1\">Deferido</option>
     <option value=\"2\">Indeferido</option>
     </select>";
	}
	
	echo "
	<tr>
	<td>$disciplina_nome</td>
    <td align=\"center\">$disciplina_ch</td>
    <td align=\"center\"><b>$aproveitamento_status</b></td>
	<td align=\"center\">$campo_nota</td>
	<td align=\"center\">$campo_escola</td>
	<td align=\"center\">$campo_conclusao</td>
	<td align=\"center\">$campo_situacao</td>
</tr>
	";
}

?>
</table>
<center><input type="submit" value="Salvar Alterações"></center>
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