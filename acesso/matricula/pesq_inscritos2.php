<head>
<link rel='stylesheet' type='text/css' href='css/styles.css' />


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<table class="full_table_list" border"1" align="center">
	<tr style="font-size:17px">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Nome</strong></div></td>
        <td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Cadastro (Data / Hora)</strong></div></td>
	</tr>

<?php
include 'conectar.php';
$cpf = $_POST["cpf"];
$sql = mysql_query("SELECT * FROM inscritos WHERE cpf LIKE '$cpf' ");



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA INSCRIÇÃO ENCONTRADA PARA O CPF');
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo          = $dados["codigo"];
		$nome          = (strtoupper($dados["nome"]));
		$curso          = ($dados["curso"]);
		$unidade          = ($dados["unidade"]);
		$modelo          = ($dados["modalidade"]);
		$datahora		= $dados["datacad"].chr(10).$dados["hora"];
		$cursopesq    = mysql_query("SELECT * FROM cursosead WHERE codigo = '$curso'");
		$dadoscur = mysql_fetch_array($cursopesq);
		$conta = $dadoscur["conta"];
		$layoutpesq    = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
		$dadoslayout = mysql_fetch_array($layoutpesq);
		$layout = $dadoslayout["layout"];
		$nivel = ($dadoscur["tipo"]);
		$cursonome = ($dadoscur["curso"]);
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=\"contrato.php?codigo=$codigo&modelo=$curso\"/>[GERAR CONTRATO]</a> <a href=\"boleto/$layout?codigo=$codigo&modelo=$curso\"/>[BOLETO MATRÍCULA]</a></td>
		<td>&nbsp;$nome</a></td>
		<td align='center'>&nbsp;$nivel: $cursonome</td>
		<td align='center'>&nbsp;$unidade</td>
		<td align='center'>&nbsp;$datahora</td></tr>
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
    </script>