<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$data = date("Y-m-d");
$matricula = $_GET["id"];
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
                              <b>Enviar E-mail de Cobran&ccedil;a</b>
                          </header>
                        <div class="panel-body">
<?php



//SELECT
$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3  AND codigo = '$matricula' AND status = 0 LIMIT 1");
$dados = mysql_fetch_array($sql);

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
        // dados dos alunos
		$idcli			 = $dados["codigo"];
		$nome			 = strtoupper(($dados["nome"]));
		$sql3 = mysql_query("SELECT * FROM alunos WHERE codigo = '$idcli'");
		$dados2 = mysql_fetch_array($sql3);
		$email			 = $dados["email"];
		if($email == ""){
			$email == "cobranca@cedtec.com.br";
		}
		$aluno = (strtoupper($dados2["nome"]));
        
		//envio de e-mail
		$conferiremail = stripos($email,"@");
		$conferiremail2 = stripos($email,".");
		if($conferiremail == false || $conferiremail2 == false){
			$destinatario ="cobranca@cedtec.com.br";
		} else {
			$destinatario = "$email";
			}
		
		$assunto = "[CEDTEC] SISTEMA ACADÊMICO / FINANCEIRO";
		$corpo = "
		<html>
		<head>
		  <title>[CEDTEC] SISTEMA ACADÊMICO / FINANCEIRO</title>
		</head>
		<body>
		<h2>Caro aluno(a) $aluno,</h2>
		<p>Identificamos pendências no sistema acadêmico / financeiro.<br>
		  <br>
		  Para sua comodidade segue abaixo seu histórico financeiro. Você pode imprimir seu(s) boleto(s) vencidos clicando em &quot;IMPRIMIR&quot;.</p>
		<p>&nbsp;
		<table width=\"100%\">
        <th>TÍTULO</th>
		<th>PARCELA</th>
        <th>VENCIMENTO</th>
        <th>VALOR DO TÍTULO</th>
		<th>2ª VIA</th>";
		//DADOS DO TITULO PARA E-MAIL
		$sql4 = mysql_query("SELECT * FROM titulos WHERE cliente_fornecedor = '$idcli' AND vencimento < '$data' AND (data_pagto is null OR data_pagto = '') AND status = 0");
		while($dados3 = mysql_fetch_array($sql4)){
		
			$idtitulo          = $dados3["id_titulo"];
			$parcela          = $dados3["parcela"];
			$vencimento          = $dados3["vencimento"];
			$valorreal          = number_format($dados3["valor"], 2, ',', '');
			$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
			$conta =  $dados3["conta"];
			$contasel = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
			$dadosconta = mysql_fetch_array($contasel);
			$layout = $dadosconta["layout"];
			$corpo.= "<tr>
			<td>$idtitulo</td>
			<td>$parcela</td>
			<td>$venc</td>
			<td>$valorreal</td>
			<td><a href=\"http://cedtecvirtual.com.br/pincelatomico/boleto/$layout?id=$idtitulo&p=$parcela&id2=$idcli&refreshed=no\" target='_blank'>[IMPRIMIR]</a></td>
			</tr>";
		}
			
		$corpo .= "</table></p>
        
        
        OBS: o valor descrito acima refere-se ao valor da mensalidade sem juros, ao imprimir o boleto será gerado conforme multa e encargos previstos em contrato.<br>
		<p>Caso ja tenha efetuado o pagamento, pedimos que desconsidere este aviso.</p>
		<p>&nbsp;</p>
		<p>--<br>
		  Atenciosamente</p>
		<p><br>
		  <b><font size=\"+1\">Escola Técnica CEDTEC</font><br>
	      </b>
		  <i>Educação Profissional Levada a Sério</i> </p>
		</body>
		</html>";
		//para o envio em formato HTML
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
			window.alert('Foi enviado $count email para $nome ($destinatario).');
			window.parent.Shadowbox.close();
			
		</SCRIPT>");
        // exibir a coluna nome e a coluna email
    }


?>
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