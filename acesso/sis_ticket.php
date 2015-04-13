<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

//Verifica os tickets em aberto
$sql_de_envio = "SELECT ct.id_ticket, ct.ano_ticket, ct.de, ct.situacao, ct.responsavel, ctt.tipo, ct.datahora, cts.situacao as nome_situacao FROM ced_ticket ct
INNER JOIN ced_tipo_ticket ctt
ON ct.tipo = ctt.id_tipo
INNER JOIN ced_tipo_situacao cts
ON cts.id_situacao = ct.situacao
WHERE $user_nivel IN (ctt.nivel) AND cts.situacao != 4 AND ct.id_resposta = 0 ORDER BY ct.datahora DESC";
$sql_ticket = mysql_query($sql_de_envio);
$total_ticket = mysql_num_rows($sql_ticket);
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
	echo "<table class=\"table table-striped table-hover table-bordered\" id=\"editable-sample\">
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
		$ticket_situacao = $dados_ticket["nome_situacao"];
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
			$ticket_responsavel_exib = "Nenhum.";
		} else {
			$dados_usuario_ticket = mysql_fetch_array($sql_usuario_ticket);
			$ticket_responsavel_exib = $dados_usuario_ticket["nome"];
		}
		
		
		echo "<tr>
	<td align=\"center\"><a href=\"abrir_ticket.php?id_ticket=$ticket_id\">$ticket_num</a></td>
    <td><a href=\"abrir_ticket.php?id_ticket=$ticket_id\">$ticket_setor</a></td>
    <td><a href=\"abrir_ticket.php?id_ticket=$ticket_id\">$ticket_de_exib</a></td>
    <td align=\"center\"><a href=\"abrir_ticket.php?id_ticket=$ticket_id\">$ticket_datahora</a></td>
    <td align=\"center\">
	<a href=\"abrir_ticket.php?id_ticket=$ticket_id\">$ticket_situacao</a>
	</td>
    <td><a href=\"abrir_ticket.php?id_ticket=$ticket_id\">$ticket_responsavel_exib</a></td>
</tr>";
	}
}
?>
</table>


<?php
$pgs = ceil($total / $maximo);  
    if($pgs > 1 ) {  
        // Mostragem de pagina  
        if($menos > 0) {  
           echo "<a href=\"?pagina=$menos&\" class='texto_paginacao'>Anterior</a> ";  
        }  
        // Listando as paginas  
        for($i=1;$i <= $pgs;$i++) {  
            if($i != $pagina) {  
               echo "  <a href=\"?pagina=".($i)."\" class='texto_paginacao'>$i</a>";  
            } else {  
                echo "  <strong lass='texto_paginacao_pgatual'>".$i."</strong>";  
            }  
        }  
        if($mais <= $pgs) {  
           echo "   <a href=\"?pagina=$mais\" class='texto_paginacao'>Próxima</a>";  
        }  
    }  


?>

</form>
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
        