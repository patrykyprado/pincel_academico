<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$get_ticket = $_GET["id_ticket"];
//Verifica os tickets em aberto
$sql_de_envio = "SELECT DISTINCT ct.id_ticket, ct.ano_ticket, ct.de, ct.situacao as id_situacao, cts.situacao, ct.responsavel, ct.tipo as id_tipo,ctt.tipo, ct.datahora, ct.texto FROM ced_ticket ct
INNER JOIN ced_tipo_ticket ctt
ON ct.tipo = ctt.id_tipo  
INNER JOIN ced_tipo_situacao cts
ON cts.id_situacao = ct.situacao
WHERE ct.id_ticket = $get_ticket AND ct.id_resposta = 0";
$sql_ticket = mysql_query($sql_de_envio);
$total_ticket = mysql_num_rows($sql_ticket);

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$post_resposta = $_POST["resposta_ticket"];
	if($post_resposta == ""){
		echo "<script language=\"javascript\">alert('Você deve digitar um texto para responder ao ticket. $post_resposta');</script>";
	} else {
		$datahora_ticket = date("Y-m-d H:i:s");
		if(mysql_query("INSERT INTO ced_ticket (id_ticket, id_resposta,de,  texto, datahora, visto) VALUES (NULL, '$get_ticket', '$user_usuario', '$post_resposta', '$datahora_ticket',0)")){
			if(mysql_affected_rows()==1){
				echo "<script language=\"javascript\">alert('Resposta enviada com sucesso');</script>";
			} else {
				echo "<script language=\"javascript\">alert('Erro ao responder ticket.');
				location.href=\"abrir_ticket.php?id_ticket=$get_ticket\";</script>";
			}
			
		}
	}
}	
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Sistema de Tickets - CEDTEC</b><br>
                              <a rel="shadowbox" href="add_ticket.php"><button type="button" class="btn btn-primary tooltips" data-placement="right" data-original-title="Clique aqui para criar um novo ticket de suporte."><i class="fa fa-plus"></i> Novo T&iacute;cket de Suporte</button></a>
                              <a href="sis_ticket.php?ver=geral"><button type="button" class="btn btn-primary tooltips" data-placement="right" data-original-title="Clique aqui para visualizar todos os tickets."><i class="fa fa-eye"></i> Ver Todos</button></a>
                              <a href="sis_ticket.php?ver=abertos"><button type="button" class="btn btn-danger tooltips" data-placement="right" data-original-title="Clique aqui para vistualizar tickets que ainda não foram finalizados."><i class="fa fa-eye"></i> Ver Abertos</button></a>
                          </header>
                          <div class="panel-body">
<?php



$get_query = $sql_de_envio;

// Declaração da pagina inicial  
$pagina = $_GET["pagina"];  
if($pagina == "") {  
    $pagina = "1";  
} 

// Maximo de registros por pagina  
$maximo = 50;

// Calculando o registro inicial  
$inicio = $pagina - 1;  
$inicio = $maximo * $inicio;


// Conta os resultados no total da minha query  
$total    = $total_ticket;  
?>

<?php //dados das linhas
if($total_ticket==0){
	echo "<center>Nenhum ticket encontrado.</center>";  
} else {
	echo "<table class=\"table table-hover table-bordered\" id=\"editable-sample\">
<tr>
	<td align=\"center\"><b>Num. Ticket</b></td>
    <td align=\"center\"><b>Setor</b></td>
    <td align=\"center\"><b>Criado Por:</b></td>
    <td align=\"center\"><b>Data / Hora</b></td>
    <td align=\"center\"><b>Situação</b></td>
    <td align=\"center\"><b>Responsável</b></td>
</tr>
";
	while($dados_ticket = mysql_fetch_array($sql_ticket)){
		$ticket_num = $dados_ticket["id_ticket"]."-".$dados_ticket["ano_ticket"];
		$ticket_id = $dados_ticket["id_ticket"];
		$ticket_setor = $dados_ticket["tipo"];
		$ticket_de = $dados_ticket["de"];
		$ticket_id_situacao = $dados_ticket["id_situacao"];
		$ticket_situacao = $dados_ticket["situacao"];
		$ticket_texto = $dados_ticket["texto"];
		$ticket_id_tipo = $dados_ticket["id_tipo"];
		$ticket_responsavel = $dados_ticket["responsavel"];
		$ticket_datahora = format_data_hora($dados_ticket["datahora"]);
		
		//PEGA NOME DO USUÁRIO QUE ENVIOU
		$sql_usuario_ticket = mysql_query("SELECT nome FROM acessos_completos WHERE usuario = '$ticket_de'");
		if(mysql_num_rows($sql_usuario_ticket)==0){
			$sql_usuario_ticket = mysql_query("SELECT nome FROM users WHERE usuario = '$ticket_de'");	
		}
		$dados_usuario_ticket = mysql_fetch_array($sql_usuario_ticket);
		$ticket_de_exib = $dados_usuario_ticket["nome"];
		
		//PEGA NOME DO USUÁRIO RESPONSÁVEL
		$sql_usuario_ticket = mysql_query("SELECT nome FROM acessos_completos WHERE usuario = '$ticket_responsavel'");
		if(mysql_num_rows($sql_usuario_ticket)==0){
			$sql_usuario_ticket = mysql_query("SELECT nome FROM users WHERE usuario = '$ticket_responsavel'");	
		}
		if(mysql_num_rows($sql_usuario_ticket)==0){
			$ticket_responsavel_exib = "<a rel=\"shadowbox\" href=\"atribuir_ticket.php?id_ticket=$ticket_id\">Nenhum.</a>";
		} else {
			$dados_usuario_ticket = mysql_fetch_array($sql_usuario_ticket);
			$ticket_responsavel_exib = $dados_usuario_ticket["nome"];
		}
		
		if($user_nivel == 1){
			//PEGA TODOS OS SETORES E EXIBI PARA O ADM
			$ticket_setor_exib = "<select name=\"ticket_setor\" id=\"ticket_setor\" id_ticket=\"$ticket_id\">
			<option value=\"$ticket_id_tipo\" selected>$ticket_setor</option>
			";
			$sql_tipo_ticket = mysql_query("SELECT tipo, id_tipo FROM ced_tipo_ticket WHERE id_tipo != $ticket_id_tipo ORDER BY tipo");
			while($dados_tipo_ticket = mysql_fetch_array($sql_tipo_ticket)){
				$tipo_ticket_tipo = $dados_tipo_ticket["tipo"];
				$tipo_ticket_id_tipo = $dados_tipo_ticket["id_tipo"];
				$ticket_setor_exib .= "<option value=\"$tipo_ticket_id_tipo\">$tipo_ticket_tipo</option>";
			}
			
			$ticket_setor_exib .="</select>";
			
			
		} else {
			$ticket_setor_exib = $ticket_setor;
		}
		
		
		//PEGA TODOS AS SITUAÇÕES E EXIBI
			$ticket_situacoes_exib = "<select name=\"ticket_setor\" id=\"ticket_setor\" id_ticket=\"$ticket_id\">
			<option value=\"$ticket_id_situacao\" selected>$ticket_situacao</option>
			";
			$sql_situacoes_ticket = mysql_query("SELECT situacao, id_situacao FROM ced_tipo_situacao WHERE id_situacao != $ticket_id_situacao ORDER BY situacao");
			while($dados_situacoes_ticket = mysql_fetch_array($sql_situacoes_ticket)){
				$situacao_ticket_situacao = $dados_situacoes_ticket["situacao"];
				$situacao_ticket_id_situacao = $dados_situacoes_ticket["id_situacao"];
				$ticket_situacoes_exib .= "<option value=\"$situacao_ticket_id_situacao\">$situacao_ticket_situacao</option>";
			}
			$ticket_situacoes_exib .="</select>";
		
		echo "<tr>
	<td align=\"center\">$ticket_num</td>
    <td>$ticket_setor_exib</td>
    <td>$ticket_de_exib</td>
    <td align=\"center\">$ticket_datahora</td>
    <td align=\"center\">
	$ticket_situacoes_exib
	</td>
    <td>$ticket_responsavel_exib</td>
</tr>";
	}
	echo "
	<tr>
		<td bgcolor=\"#E1E1E1\" colspan=\"6\" align=\"center\"><b>Descrição do Ticket</b></td>
	</tr>
	<tr>
		<td colspan=\"6\">$ticket_texto</td>
	</tr>
	
	</table>";
	$sql_respostas_ticket =mysql_query("SELECT texto, de, datahora FROM ced_ticket WHERE id_resposta = $ticket_id ORDER BY datahora");
	if(mysql_num_rows($sql_respostas_ticket)>=1){
		echo "<table class=\"table table-hover table-bordered\" id=\"editable-sample\">";
		
		
		while($dados_respostas = mysql_fetch_array($sql_respostas_ticket)){
			$resposta_texto = $dados_respostas["texto"];
			$resposta_de = $dados_respostas["de"];
			$resposta_datahora = format_data_hora($dados_respostas["datahora"]);
			
			
			//PEGA NOME DO USUÁRIO QUE RESPONDEU
			$sql_usuario_resposta = mysql_query("SELECT nome FROM acessos_completos WHERE usuario = '$resposta_de'");
			if(mysql_num_rows($sql_usuario_resposta)==0){
				$sql_usuario_resposta = mysql_query("SELECT nome FROM users WHERE usuario = '$ticket_de'");	
			}
			$dados_usuario_resposta = mysql_fetch_array($sql_usuario_resposta);
			$resposta_de_exib = $dados_usuario_resposta["nome"];
			echo "
<tr bgcolor=\"#BCBCBC\">
	<td width=\"200px\"><b>Num. Ticket:<br></b>$ticket_num</td>
    <td><b>Resposta de:<br></b>$resposta_de_exib<br></td>
	<td><b>Data de Resposta:</b><br><font size=\"-2\">$resposta_datahora</font></font></td>
</tr>
<tr>
	<td colspan=\"3\">$resposta_texto</td>
</tr>";
		}
		echo "</table>";
	}
}

?>



<center><a data-toggle="modal" href="#responder_ticket"><button type="button" class="btn btn-primary tooltips" data-placement="right" data-original-title="Clique aqui para responder esse ticket."><i class="fa fa-edit"></i> Responder Ticket</button></a></center>
<!-- Modal -->
                              <div class="modal fade" id="responder_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                          
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Responder Ticket</h4>
                                          </div>
                                          <div class="modal-body">
<form action="#" method="POST">
                                              <textarea name="resposta_ticket" id="resposta_ticket" class="ckeditor"></textarea>
<input type="submit" class="btn btn-success" value="Enviar"/>
                                              
                                              </form>
                                          </div>
                                          <div class="modal-footer">
                                       
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Fechar</button>
                                          </div>
                                         
                                      
                                  </div>
                                  </div>
                                  </div>

                              <!-- modal -->

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
        