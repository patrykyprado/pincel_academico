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
 include('includes/funcoes.php');
 ?>
<?php
include('includes/conectar.php');
$id_turma = $_GET["id_turma"];
?>
<div class="filtro"><center><br><br><br><a href="gerar_rematricula.php?id_turma=<?php echo $id_turma;?>&garantia=1">[IMPRIMIR ADITIVOS]</a> |

<a href="javascript:window.print();">[IMPRIMIR BOLETOS]</a></center><br><br><br></div>
<?php
$garantia_contratual = $_GET["garantia"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_cod_turma = $dados_turma["cod_turma"];
$turma_nivel = format_curso($dados_turma["nivel"]);
$turma_curso = format_curso($dados_turma["curso"]);
$turma_modulo = $dados_turma["modulo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
$turma_turno = $dados_turma["turno"];
$turma_grupo = $dados_turma["grupo"];
$turma_anograde = $dados_turma["anograde"];
$turma_tipo_etapa = $dados_turma["tipo_etapa"];
$turma_empresa = $dados_turma["empresa"];

if($turma_modulo == 1){
	$modulo_exib = "I"; 	
}
if($turma_modulo == 2){
	$modulo_exib = "II"; 	
}
if($turma_modulo == 3){
	$modulo_exib = "III"; 
}

if(strtoupper(trim($turma_unidade)) == "SERRA"){
	$cc2 = "LA";
}
if(strtoupper(trim($turma_unidade)) == "CARIACICA"){
	$cc2 = "CA";
}
if(strtoupper(trim($turma_unidade)) == "GUARAPARI"){
	$cc2 = "GA";
}

$sql_empresa = mysql_query("SELECT razao, uf, cidade, endereco, bairro, cep, cnpj FROM cc2 WHERE id_filial LIKE '$cc2'");
$dados_empresa = mysql_fetch_array($sql_empresa);
$empresa_nome = $dados_empresa["razao"];
$empresa_cnpj = $dados_empresa["cnpj"];
$empresa_endereco = $dados_empresa["endereco"]." - ".$dados_empresa["bairro"].", ".$dados_empresa["cidade"]." - ".$dados_empresa["uf"].", CEP: ".$dados_empresa["cep"];
$empresa_endereco = "Avenida  CIVIT, nº 911 – Parque Residencial Laranjeiras, Serra – ES, CEP: 29.165.032";
?>


<?
	$sql_alunos = mysql_query("SELECT DISTINCT alu.*
FROM ced_turma_aluno cta 
INNER JOIN alunos alu
ON cta.matricula = alu.codigo
WHERE cta.id_turma = $id_turma ORDER BY alu.nome
");
	if(mysql_num_rows($sql_alunos)==0){
		"";
	} else {
		while($dados_aluno_turma = mysql_fetch_array($sql_alunos)){
			$aluno_matricula = $dados_aluno_turma["codigo"];
			
			//pega o boleto
			$sql_boleto = mysql_query("SELECT * FROM titulos WHERE cliente_fornecedor = '$aluno_matricula' AND parcela = 1 AND documento_fiscal LIKE '%201501-%' LIMIT 1");
			$dados_boleto = mysql_fetch_array($sql_boleto);
			$id_titulo = $dados_boleto["id_titulo"];
			$parcela = $dados_boleto["parcela"];
			
			$link = "../boleto/boleto_santander2.php?id=".$id_titulo."&p=".$parcela."&id2=".$aluno_matricula."&refreshed=no";
			echo '<iframe src="'.$link.'" width="100%" scrolling="no" height="97%"></iframe>';

		}
	}
?>
</body>



    

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