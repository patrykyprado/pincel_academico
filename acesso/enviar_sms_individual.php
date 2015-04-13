<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$get_codigo = $_GET["codigo"];
ini_set('display_errors', "on");
ini_set('error_reporting', E_ALL & ~E_NOTICE);
include_once '../cliente_sms/HumanClientMain.php';

$sql_controle_sms = mysql_query("SELECT * FROM controle_sms");
$dados_controle_sms = mysql_fetch_array($sql_controle_sms);
$usuario_sms = $dados_controle_sms["usuario_sms"];
$senha_sms = $dados_controle_sms["senha_sms"];
$contador_sms = $dados_controle_sms["contador"];
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
                              <b>Resumo de Envio (SMS): Alunos</b>
                          </header>
                          <div class="panel-body">
<form action="#" method="POST">
<textarea name="sms" maxlength="170" id="sms" style="width:100%; height:100px;"></textarea><br>
<center><input value="Enviar SMS" type="submit"/></center>
</form>
<?php


if($_SERVER["REQUEST_METHOD"] == "POST"){
	$post_msg = $_POST["sms"];
	$sql_sms = mysql_query("SELECT codigo, nome, celular FROM alunos WHERE codigo = $get_codigo");
	$msg_list  = "5527998450730;$post_msg;$contador_sms;CEDTEC;19/11/2014 12:52:00"."\n";
	$contador_sms +=1;
	echo "<table border=\"1\" width=\"100%\">
	<tr bgcolor=\"#E8E8E8\">
		<td align=\"center\"><b>Código</b></td>
		<td align=\"center\"><b>Nome</b></td>
		<td align=\"center\"><b>Envio de SMS</b></td>
	</tr>
	";
	
	
	while($dados_sms = mysql_fetch_array($sql_sms)){
		$matricula_aluno = $dados_sms["codigo"];
		$nome_aluno_1 = explode(" ",format_curso($dados_sms["nome"]));
		$nome_aluno = $nome_aluno_1[0]." ".$nome_aluno_1[1]." ".$nome_aluno_1[2];
		$celular_aluno = formatar_sms($dados_sms["celular"]);
		if($celular_aluno == "Número Inválido"){
			$mensagem_sms = "O SMS não foi enviado pois o número do aluno está no formato incorreto.";	
		} else {
			$mensagem_sms = "SMS enviado com sucesso!";
			$msg_list .= $celular_aluno.";$post_msg;$contador_sms;CEDTEC;07/01/2015 12:00:00"."\n";
			$contador_sms +=1;
			$data_hora_atual = date("Y-m-d H:i:s");
			mysql_query("INSERT INTO sms_logs (id_log, usuario, para,numero, data_hora) 
			VALUES (NULL, '$user_usuario','$nome_aluno','$celular_aluno','$data_hora_atual')");
		}
		
		echo "<tr>
		<td align=\"center\"><b>$matricula_aluno</b></td>
		<td align=\"left\">$nome_aluno</td>
		<td align=\"left\">$mensagem_sms</td>
	</tr>";
	}
	echo "</table>";
	//conecta o usuário
	mysql_query("UPDATE controle_sms SET contador = $contador_sms");
	$humanMultipleSend = new HumanMultipleSend("$usuario_sms", "$senha_sms");
	$response = $humanMultipleSend->sendMultipleList(HumanMultipleSend::TYPE_E, $msg_list);
	foreach ($response as $resp) {
		//echo $resp->getCode() . " - " . $resp->getMessage() . "<br />";
	}
}
?>
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
 