<head>
<link rel='stylesheet' type='text/css' href='css/styles.css' />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<table class="full_table_list" border="1" align="center">
	  <th colspan="4" style="font-size:18px">Clique  na linha do curso desejado</th>
	<tr>
		<td><div align="center"><strong>Nível</strong></div></td>
        <td><div align="center"><strong>Nome do Curso</strong></div></td>
        <td><div align="center"><strong>Complemento</strong></div></td>
         <td><div align="center"><strong>Turno</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
	</tr>

<?php
include 'conectar.php';
$unidade = $_GET["unidade"];
$sql = mysql_query("SELECT * FROM cursosead WHERE unidade LIKE '%$unidade%' ORDER BY tipo, curso ");

if ($unidade == 'selecione') {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Você precisa preencher os passos 1 e 2 antes de escolher o curso')
    window.close();
    </SCRIPT>");
}


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM CURSO DISPONÍVEL PARA A MODALIDADE E UNIDADE ESCOLHIDA')
    window.close();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo          = $dados["codigo"];
		$nivel          = (strtoupper($dados["tipo"]));
		$curso         = (strtoupper($dados["curso"]));
		$fiador         = (strtoupper($dados["fiador"]));
		$modulo         = (strtoupper($dados["modulo"]));
		$comp         = (strtoupper($dados["complemento"]));
		$turno         = (strtoupper($dados["turno"]));
		$grupo         = (strtoupper($dados["grupo"]));
		$nomeexib = $nivel.': '.$curso." | ".$turno;
        echo "
	<tr onclick=\"enviar('$codigo');enviar2('$nomeexib');enviarfiador('$fiador');\" style=\"cursor: hand;\><a href=\"#\" \">
		<td>$nivel</td>
		<td><a href=\"#\" onclick=\"enviar('$codigo');enviar2('$nomeexib');enviarfiador('$fiador');\">$curso</a></td>
		<td><a href=\"#\" onclick=\"enviar('$codigo');enviar2('$nomeexib');enviarfiador('$fiador');\">$complemento</a></td>
		<td><a href=\"#\" onclick=\"enviar('$codigo');enviar2('$nomeexib');enviarfiador('$fiador');\">$turno</a></td>
		<td><a href=\"#\" onclick=\"enviar('$codigo');enviar2('$nomeexib');enviarfiador('$fiador');\">$grupo</a></td>
		</tr>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

</table>
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
opener.document.getElementById('curso3').value = valor;
opener.document.getElementById('curso2').value = valor;
opener.document.getElementById('curso3').focus();
this.close();
}
function enviar2(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('curso').value = valor;
this.close();
}
function enviarfiador(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fiadorexib').value = valor;
this.close();
}
</script>
    </script>
    
    