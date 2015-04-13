<head>
<!-- CSS DE IMPRESSÃO -->
    <link href="css/imprimir.css" media="print" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" media="screen" rel="stylesheet">
    <style type="text/css">
    body,td,th {
	font-family: "Open Sans", sans-serif;
}
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php
include('includes/conectar.php');
include('includes/funcoes.php');
$post_senha_certa = 1;
$post_senha_dig = 1;

if($post_senha_certa != $post_senha_dig){
	echo "<script language=\"javascript\">
	alert('A senha digitada está incorreta.');
	history.back();
	</script>";
} else {


$get_curso = $_GET["curso"];
$cod_disc = $_GET["cod_disc"];
$nquestoes_baixo = $_GET["nquestoes_baixo"];
$nquestoes_medio = $_GET["nquestoes_medio"];
$nquestoes_alto = $_GET["nquestoes_alto"];
$get_valor = $_GET["valor"];
$get_data = $_GET["data"];
$get_anograde = $_GET["anograde"];
$get_modulo = $_GET["modulo"];

$cod_prova = $cod_disc."_".date("His");



//pega dados da disciplina
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disc' AND anograde LIKE '%$get_anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];
$curso_disciplina = $dados_disc2["curso"];
$nivel_disciplina = $dados_disc2["nivel"];
$modulo_disciplina = $dados_disc2["modulo"];
?>

  <body>

<div class="filtro" align="center">
<a href="javascript:window.print()">[IMPRIMIR]</a>
</div>
<div class="prova-escrita">
Cod_Prova: <?php echo $cod_prova;?>
<table width="100%" align="center" border="1" style="color:#000;font-family:Arial, Helvetica, sans-serif;font-size:12px;border:double;">
    <tr>
    	<td width="40%" colspan="2"><img src="images/logo-cedtec.png" /></td>
        <td colspan="2" align="center"><font size="+2"><b>Avalia&ccedil;&atilde;o</b></font></td>
    </tr>
    <tr>
    	<td colspan="2"><b>Curso: <?php echo $get_curso." Mód. ".$get_modulo;?></b></td>
        <td width="60%" colspan="2"><b>Componente Curricular: <?php echo $nome_disciplina; ?></b></td>
    </tr>
    <tr>
    	<td colspan="2"><b>Data: <?php echo $get_data; ?></b></td>
        <td><b>Valor: <?php echo $get_valor; ?></b></td>
        <td><b>Nota:</b></td>
    </tr>
    <tr>
    	<td colspan="4"><b>Nome do(a) Professor(a):</b></td>
    </tr>
    <tr>
    	<td colspan="4"><b>Nome do(a) Aluno(a):</b></td>
    </tr>
</table>
<br /><br />
<?php 
$sql_bd = mysql_query("SELECT * FROM view_simulado WHERE nome_bq LIKE '%$nome_disciplina%' AND cursos LIKE '%$get_curso%' LIMIT 1");
if(mysql_num_rows($sql_bd)==0){
	$sql_bd = mysql_query("SELECT * FROM view_simulado WHERE nome_bq LIKE '%$nome_disciplina%' AND cursos LIKE '%COMUM%' LIMIT 1");
}
$dados_bd = mysql_fetch_array($sql_bd);

//PEGA QUESTÕES BAIXO
$banco_baixo = $dados_bd["id_bq_1"];
//PEGA QUESTÕES MÉDIO
$banco_medio = $dados_bd["id_bq_2"];
//PEGA QUESTÕES ALTO

$banco_alto = $dados_bd["id_bq_3"];
$gabarito = "";
//MONTA QUESTÕES BAIXO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_baixo' AND simulado = 0 ORDER BY rand() LIMIT $nquestoes_baixo");
$num_questao = 1;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table class=\"full_table_list\" style=\"orphans:3; color:#000;\" width=\"100%\">
	<tr bgcolor=\"#D7D7D7\">
		<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" align=\"center\" valign=\"top\" width=\"17%\"><b>Questão $n_questao:</b></td>
		<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" colspan=\"2\" valign=\"top\" width=\"80%\"><b><font style=\"font-family:Arial, Helvetica, sans-serif; color:black;\">$questao_questao</font></b><td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "
		<tr>
			<td align=\"right\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\">$letra_opcao </td>
			<td colspan=\"2\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\"> $opcaoresposta</td>
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
 
 
 //MONTA QUESTÕES MÉDIO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_medio' AND simulado = 0 ORDER BY rand() LIMIT $nquestoes_medio");
$num_questao = $num_questao;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table class=\"full_table_list\" style=\"orphans:3;color:#000;\"  width=\"100%\">
	<tr bgcolor=\"#D7D7D7\">
		<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" align=\"center\" valign=\"top\" width=\"17%\"><b>Questão $n_questao:</b></td>
		<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" colspan=\"2\" valign=\"top\" width=\"80%\"><b><font style=\"font-family:Arial, Helvetica, sans-serif; color:black;\">$questao_questao</font></b><td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "
		<tr>
			<td align=\"right\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\">$letra_opcao </td>
			<td colspan=\"2\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\"> $opcaoresposta</td>
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

 //MONTA QUESTÕES ALTO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_alto' AND simulado = 0 ORDER BY rand() LIMIT $nquestoes_alto");
$num_questao = $num_questao;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table class=\"full_table_list\" style=\"orphans:3;color:#000;\" width=\"100%\">
	<tr bgcolor=\"#D7D7D7\">
		<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" align=\"center\" valign=\"top\" width=\"17%\"><b>Questão $n_questao:</b></td>
		<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" colspan=\"2\" valign=\"top\" width=\"80%\"><b><font style=\"font-family:Arial, Helvetica, sans-serif; color:black;\">$questao_questao</font></b><td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "
		<tr>
			<td align=\"right\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\">$letra_opcao </td>
			<td colspan=\"2\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\"> $opcaoresposta</td>
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
 
echo "</table>";

}

if($gabarito != ""){
	$explode_gabarito = explode(",", $gabarito);
	echo "
	<p class=\"break\">&nbsp;</p>
	<table align=\"center\" border=\"1\" width=\"200px\">
	<tr>
		<td colspan=\"3\" align=\"center\">Cod_Prova: $cod_prova</td>
	</tr>
	<tr>
		<td colspan=\"3\" align=\"center\"><b>GABARITO</b></td>
	</tr>
	<tr>
		<td align=\"center\"><b>Questão</b></td>
		<td><td align=\"center\"><b>Resposta</b></td>
	</tr>";
	for( $i = 0 , $x = count( $explode_gabarito ) ; $i < $x ; ++ $i ) {
		$resposta_explode = explode("-" ,$explode_gabarito[$i]);
		$questao = trim($resposta_explode[0]);
		$resposta = trim($resposta_explode[1]);
		echo "
		<tr>
			<td align=\"center\"><b>$questao</b></td>
			<td><td align=\"center\"><b>$resposta</b></td>
		</tr>
		";
		
	}
	echo "</table>";
	
}

?>
</div>

      <!--main content end-->

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