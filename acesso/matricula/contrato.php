<head>
<link rel='stylesheet' type='text/css' href='css/styles.css' />
<link rel="stylesheet" href="css/print.css" type="text/css" media="print">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<div class="contrato">
<?php
include 'conectar.php';
$codigo = $_GET["codigo"];
$codcurso = $_GET["modelo"];
$cursopesq    = mysql_query("SELECT * FROM cursosead WHERE codigo = '$codcurso'");
$dadoscur = mysql_fetch_array($cursopesq);
$mod = explode('-',$dadoscur["tipo"]);
$modelo2 = trim((strtoupper($mod[0])));
$modelo = $dadoscur["tipo"];
$conta = $dadoscur["conta"];
$cursocontratado = $dadoscur["curso"];
$layoutpesq    = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
$dadoslayout = mysql_fetch_array($layoutpesq);
$layout = $dadoslayout["layout"];



$sql = mysql_query("SELECT * FROM inscritos WHERE codigo LIKE '$codigo' ");
$dados2 = mysql_fetch_array($sql);
$polo2 = explode('-',$dados2["unidade"]);
$pesq_cont = $dados2["modalidade"];

$sql4 = mysql_query("SELECT * FROM modalidade WHERE id_mod LIKE '$pesq_cont' ");
$pesq_modal = mysql_fetch_array($sql4);
$modalidade_exib = $pesq_modal["modalidade"];
$pes_polo = $polo2[0];
$parcelas = $dados2["parcelas"];
$valorcontratado = $dadoscur["valor"];

if($pesq_cont==2){
	$tipocontrato = "EA";
	$empresacontrato = "EA";
}
//SERRA
if($pesq_cont==1&&$modelo2=="CURSO TÉCNICO"&&$pes_polo=="SERRA "){
	$tipocontrato = "CT";
	$empresacontrato = "LA";
}
if($pesq_cont==1&&$modelo2=="ENSINO MÉDIO PROFISSIONALIZANTE"&&$pes_polo=="SERRA "){
	$tipocontrato = "EM";
	$empresacontrato = "LA-EM";
}
if($pesq_cont==1&&$modelo2=="ENSINO MÉDIO"&&$pes_polo=="SERRA "){
	$tipocontrato = "EM";
	$empresacontrato = "LA-EM";
}

if($pesq_cont==1&&$modelo2=="QUALIFICAÇÃO"&&$pes_polo=="SERRA "){
	$tipocontrato = "EA";
	$empresacontrato = "LA";
}
//CARIACICA
if($pesq_cont==1&&$modelo2=="CURSO TÉCNICO"&&$pes_polo=="CARIACICA "){
	$tipocontrato = "CT";
	$empresacontrato = "CA";
}
if($pesq_cont==1&&$modelo2=="ENSINO MÉDIO PROFISSIONALIZANTE"&&$pes_polo=="CARIACICA "){
	$tipocontrato = "EM";
	$empresacontrato = "CA";
}
if($pesq_cont==1&&$modelo2=="ENSINO MÉDIO"&&$pes_polo=="CARIACICA "){
	$tipocontrato = "EM";
	$empresacontrato = "CA";
}
if($pesq_cont==1&&$modelo2=="QUALIFICAÇÃO"&&$pes_polo=="CARIACICA "){
	$tipocontrato = "EA";
	$empresacontrato = "CA";
}
//GUARAPARI
if($pesq_cont==1&&$modelo2=="CURSO TÉCNICO"&&$pes_polo=="GUARAPARI "){
	$tipocontrato = "CT";
	$empresacontrato = "GA";
}
if($pesq_cont==1&&$modelo2=="ENSINO MÉDIO PROFISSIONALIZANTE"&&$pes_polo=="GUARAPARI "){
	$tipocontrato = "EM";
	$empresacontrato = "GA";
}
if($pesq_cont==1&&$modelo2=="ENSINO MÉDIO"&&$pes_polo=="GUARAPARI "){
	$tipocontrato = "EM";
	$empresacontrato = "GA";
}
if($pesq_cont==1&&$modelo2=="QUALIFICAÇÃO"&&$pes_polo=="GUARAPARI "){
	$tipocontrato = "EA";
	$empresacontrato = "GA";
}

//RECIFE
if($pesq_cont==1&&$modelo2=="CURSO TÉCNICO"&&$pes_polo=="RECIFE "){
	$tipocontrato = "EA";
	$empresacontrato = "PE";
}
if($pesq_cont==1&&$modelo2=="ENSINO MÉDIO PROFISSIONALIZANTE"&&$pes_polo=="RECIFE "){
	$tipocontrato = "EA";
	$empresacontrato = "PE";
}
if($pesq_cont==1&&$modelo2=="ENSINO MÉDIO"&&$pes_polo=="RECIFE "){
	$tipocontrato = "EA";
	$empresacontrato = "PE";
}
if($pesq_cont==1&&$modelo2=="QUALIFICAÇÃO"&&$pes_polo=="RECIFE "){
	$tipocontrato = "EA";
	$empresacontrato = "PE";
}


if($pesq_cont==1){
	$sql3 = mysql_query("SELECT * FROM empresa_contrato WHERE tipocontrato = '$tipocontrato' AND cidade = '$pes_polo'");
	$sql4 = mysql_query("SELECT * FROM empresa_contrato WHERE tipocontrato = '$tipocontrato' AND cidade = '$pes_polo'");
} else {
	$sql3 = mysql_query("SELECT * FROM empresa_contrato WHERE tipocontrato = '$tipocontrato'");}


$dados3 = mysql_fetch_array($sql3);
$dados4 = mysql_fetch_array($sql4);
$sql2 = mysql_query("SELECT * FROM clausulas WHERE tipo = 'REM-EM' AND item >=1 ORDER BY item,subitem");
$sqlcab = mysql_query("SELECT * FROM clausulas WHERE tipo = 'REM-EM' AND item =0");

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
?>
<div id="noprint" class="noprint" align="center"><a href="javascript:print()"><img src="icones/imprimir.png" alt="IMPRIMIR CONTRATO" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="boleto/<?php echo $layout?>?codigo=<?php echo $codigo;?>&modelo=<?php echo $codcurso;?>" target="_blank"><img src="icones/icone_boleto.png" alt="GERAR BOLETO" /></a></div>
  <div align="center" style="font-size:16px"><strong>CONTRATO DE PRESTA&Ccedil;&Atilde;O  DE SERVI&Ccedil;OS EDUCACIONAIS</strong><br />
  <strong>IDENTIFICA&Ccedil;&Atilde;O E QUALIFICA&Ccedil;&Atilde;O DAS PARTES E DO SERVI&Ccedil;O CONTRATADO</strong><br /><br /></div>
<div style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
 <strong><?php echo ($dados3["nome"]);?></strong>, devidamente inscrito no CNPJ sob  o n&ordm;. <strong><?php echo ($dados3["cnpj"]);?></strong>,  com endere&ccedil;o na <strong><?php echo ($dados3["endereco"]);?></strong> &ndash;<strong> <?php echo ($dados3["bairro"]);?> </strong>, <strong><?php echo ($dados3["cidade"]);?></strong> &ndash; <strong><?php echo $dados3["uf"];?></strong>,  CEP:<strong> <?php echo $dados3["cep"];?></strong>, neste ato representado pelo seu Diretor Geral  Corporativo e procurador, pelo Diretor por ele nomeado, ou procurador  devidamente constitu&iacute;do.<br />
  <strong>POLO</strong>:<u> <?php echo $polo2[0];?></u><br />
Endere&ccedil;o:<u> <?php echo ($dados2["unidade"]);?></u><br><b>Curso Contratado:</b> <?php echo $modelo2;?>: <u> <?php echo ($cursocontratado);?> (<?php echo ($modalidade_exib);?>)</u> <br><b>Valor Contratado (ano/m&oacute;dulo):</b> R$ <?php echo number_format($valorcontratado, 2, ',', '');?>  </p>
<p><table width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; border-style:solid; border-width:1px;"><tr><td><strong>CONTRATANTE (*)</strong>:<u> <?php echo ($dados2["nome_fin"]);?></u> Data de Nascimento:<u><?php echo ($dados2["nasc_fin"]);?></u> Nacionalidade: <u> <?php echo ($dados2["nacio_fin"]);?></u> Estado  Civil: <u><?php echo ($dados2["civil_fin"]);?></u><br />
  Profiss&atilde;o:<u> <?php echo ($dados2["cargo"]);?> </u>CPF:<u> <?php echo ($dados2["cpf_fin"]);?> </u> RG:<u> <?php echo ($dados2["rg_fin"]);?> </u><br />
  Endere&ccedil;o:<u> <?php echo ($dados2["end_fin"]);?> </u><br />
  Bairro: <u> <?php echo ($dados2["bairro_fin"]);?> </u> Cidade:<u> <?php echo ($dados2["cidade_fin"]);?> </u> UF:<u> <?php echo ($dados2["uf_fin"]);?> </u> CEP:<u> <?php echo ($dados2["cep_fin"]);?> </u><br />
  Telefone(s):<u> <?php echo ($dados2["tel_fin"]);?> </u>  E-mail:<u> <?php echo ($dados2["email_fin"]);?> </u><br /></td></tr>
<tr><td><strong>* O aluno somente poder&aacute; figurar como contratante se for maior de 18  anos de idade ou emancipado.</strong></td></tr></table></p>
<p><table width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; border-style:solid; border-width:1px;"><tr><td><strong>ALUNO:</strong><u> <?php echo ($dados2["nome"]);?></u> Data de Nascimento:<u><?php echo ($dados2["nascimento"]);?></u>  Nacionalidade: <u> <?php echo ($dados2["nacionalidade"]);?></u> Estado  Civil: <u><?php echo ($dados2["civil"]);?></u><br />
  CPF: <u> <?php echo ($dados2["cpf"]);?></u> RG:<u> <?php echo ($dados2["rg"]);?></u> Endere&ccedil;o:<u> <?php echo ($dados2["endereco"]);?> </u><br />
  Bairro:<u> <?php echo ($dados2["bairro"]);?></u>  Cidade:<u> <?php echo ($dados2["cidade"]);?></u> UF:<u> <?php echo ($dados2["uf"]);?></u> CEP:<u> <?php echo ($dados2["cep"]);?></u><br />
Telefone(s):<u> <?php echo ($dados2["telefone"]);?> / <?php echo ($dados2["celular"]);?></u> E-mail:<u> <?php echo ($dados2["email"]);?></u></td></tr></table></p>
<?php
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA INSCRIÇÃO ENCONTRADA PARA O CPF');
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados3 = mysql_fetch_array($sqlcab)) {
        // enquanto houverem resultados...
		$item          = $dados3["item"];
		$subitem          = $dados3["subitem"];
		$clausula          = ($dados3["clausula"]);
		
        echo "$clausula
		<br>";
        // exibir a coluna nome e a coluna email
    }
}

?>
<div align="center" style="background:#CCC; font-weight:bold; font-size:14px;"> 
  <p><b>ATEN&Ccedil;&Atilde;O: LEIA ANTES DE ASSINAR. Em caso de d&uacute;vidas fa&ccedil;a as consultas necess&aacute;rias. </b></div></p>
<p>
  <?php
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA INSCRIÇÃO ENCONTRADA PARA O CPF');
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql2)) {
        // enquanto houverem resultados...
		$item          = $dados["item"];
		$subitem          = $dados["subitem"];
		$clausula          = ($dados["clausula"]);
		
        echo "<b>$item.$subitem -</b> $clausula
		<br>";
        // exibir a coluna nome e a coluna email
    }
}

?>
</p>
Para dirimir as quest&otilde;es originadas neste contrato, as partes contratantes elegem o foro de <?php echo ($dados4["cidade"]);?> -  <?php echo ($dados4["uf"]);?>, com exclus&atilde;o de qualquer outro, por mais privilegiado que seja. E, por estarem de pleno acordo, assinam este instrumento em 02 (duas) vias de igual teor e forma, anverso e verso, em papel A4, na presen&ccedil;a das testemunhas abaixo. <br>
<p>A bem da verdade firmo o presente  para que surta os devidos efeitos legais.</p>
<p>____________________(<?php echo ($dados4["uf"]);?>), ________ de  _______________________ de ______________</p>
<table width="100%" border="0">
  <tr>
    <td><DIV align="center">___________________________________<br /><B>CONTRATADA</B></DIV></td>
    <td><DIV align="center">___________________________________<br /><B>CONTRATANTE</B></DIV></td>
  </tr>
</table>
<p align="center">&nbsp;</p>
<p>TESTEMUNHAS: </p>
<p>1)________________________________<br />
  CPF:______________________________</p>
<p>2)________________________________<br />
  CPF:______________________________</p>
</div>
<div style="page-break-after:always"></div>
<div style="page-break-after:always"></div>
<p align="center"><strong>Anexo I - Da Garantia  Contratual</strong></p>
<p><strong> </strong></p>
<p>Como  garantia deste contrato, o <strong>CONTRATANTE</strong> indica a modalidade fian&ccedil;a pessoal ora prestada pelo <strong>FIADOR</strong> abaixo qualificado, que, como <strong><u>principal pagador e solidariamente respons&aacute;vel at&eacute; a conclus&atilde;o do  curso, compromete-se por si e seus herdeiros, ilimitadamente, a satisfazer  todas as obriga&ccedil;&otilde;es pecuni&aacute;rias aqui contra&iacute;das, como tamb&eacute;m, as d&iacute;vidas que,  decorrentes deste instrumento, venham a ser constitu&iacute;das por for&ccedil;a de  renova&ccedil;&otilde;es de matr&iacute;cula para m&oacute;dulo subsequente ou de parcelamentos (morat&oacute;ria)  de parcelas mensais em atraso e, ainda por todos os acess&oacute;rios da d&iacute;vida  principal, inclusive as despesas extrajudiciais e judiciais</u></strong>, nos termos  do art. 821 e 822 da Lei 10.406 de 10 de janeiro de 2002.</p>
<p><table width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; border-style:solid; border-width:1px;"><tr><td><strong>FIADOR:</strong><u> <?php echo ($dados2["nome_fia"]);?></u> <br />
Data de Nascimento:<u><?php echo ($dados2["nasc_fia"]);?></u> Nacionalidade: <u> <?php echo ($dados2["nacio_fia"]);?></u> <br />
CPF:<u> <?php echo ($dados2["cpf_fia"]);?></u> RG:<u> <?php echo ($dados2["rg_fia"]);?><BR />
</u><strong>C&Ocirc;NJUGE:</strong><u> <?php echo ($dados2["nome_conj"]);?></u> <br />
Data de Nascimento:<u><?php echo ($dados2["nasc_conj"]);?></u> Nacionalidade: <u> <?php echo ($dados2["nacio_conj"]);?></u> <br />
CPF:<u> <?php echo ($dados2["cpf_conj"]);?></u> RG:<u> <?php echo ($dados2["rg_conj"]);?></u><br />
Endere&ccedil;o:<u> <?php echo ($dados2["end_fia"]);?></u><br />
Bairro:<u> <?php echo ($dados2["bairro_fia"]);?></u> Cidade:<u> <?php echo ($dados2["cidade_fia"]);?></u> UF:<u> <?php echo ($dados2["uf_fia"]);?></u> CEP:<u> <?php echo ($dados2["cep_fia"]);?></u><br />
Telefone(s):<u> <?php echo ($dados2["tel_fia"]);?></u> E-mail:<u> <?php echo ($dados2["email_fia"]);?></u></td></tr></table></p>


<p>____________________(<?php echo ($dados4["uf"]);?>), ________ de  _______________________ de ______________</p>
<table width="100%" border="0">
  <tr>
    <td><DIV align="center">___________________________________<br />
      <B>CONTRATADA</B></DIV></td>
    <td><DIV align="center">___________________________________<br />
      <B>CONTRATANTE</B></DIV></td>
  </tr>
  <tr>
    <td><DIV align="center">___________________________________<br />
      <B>ALUNO</B></DIV></td>
    <td><DIV align="center">___________________________________<br />
      <B>FIADOR</B></DIV></td>
  </tr>
  <tr>
    <td colspan="2"><DIV align="center">___________________________________<br />
      <B>C&Ocirc;NJUGE DO FIADOR</B></DIV></td>
</table>
</div>
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
    </script>