<?php require_once('Connections/local.php'); ?>
<?php require_once('conectar.php'); ?>
<title>Boleto CEDTEC Virtual</title>
<div align="center"><a href="javascript:window.print()">Imprimir essa Página </a>
<a href="javascript:window.print()"><img src="clique.gif" width="36" height="36" /></a></div>
<?php


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//

//

$maxRows_Recordset1 = 100;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
$codigo = $_GET['cpf'];


	mysql_select_db($database_local, $local);
	//
	$query_Recordset1 = sprintf("SELECT codigo, civil, nome, cpf, nascimento, endereco, bairro, uf, cep, email, telefone, mae, pai, unidade, cargo, graduacao, expe_ead, afirma, curso, financeiro, cpf_fin, datacad, hora, login, valor, rg, endereco2, uf2, nascimento2, nacionalidade, email2, telefone2, rg2, celular, cidade, bairrofin, cidadefin, noticia FROM ead where cpf like '$codigo'", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"));

	$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
	$Recordset1 = mysql_query($query_limit_Recordset1, $local) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	
	
 
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

if ( $totalRows_Recordset1 == 0) 
echo"<script laguage='javascript'>alert('Sem Resultados!!!');history.go(-1);</script>";

?>





<?php
function CalculaDigitoMod11($NumDado, $NumDig, $LimMult){

  $Dado = $NumDado;
  for($n=1; $n<=$NumDig; $n++){
    $Soma = 0;
    $Mult = 2;
    for($i=strlen($Dado) - 1; $i>=0; $i--){
      $Soma += $Mult * intval(substr($Dado,$i,1));
      if(++$Mult > $LimMult) $Mult = 2;
    }
    $Dado .= strval(fmod(fmod(($Soma * 10), 11), 10));
  }
  return substr($Dado, strlen($Dado)-$NumDig);
}


$dvnum = CalculaDigitoMod11($row_Recordset1['codigo'], 2, 12);
$codigocli = $row_Recordset1['codigo'];
$nome = $row_Recordset1['nome'];
$rg = $row_Recordset1['cpf'];
$endereco = $row_Recordset1['endereco'];
$cidade = $row_Recordset1['bairro'];
$estado = $row_Recordset1['uf'];
$cep = $row_Recordset1['cep'];
$frase = $row_Recordset1['curso'];
$frase2 = explode("R$", $frase);
$valor = substr($frase, -3, 3);
$curso1 = $row_Recordset1['curso'];

if ($nome == ""){
echo"<script laguage='javascript'>alert('Preencha seu nome');history.go(-1);</script>";
}
if ($rg == ""){
echo"<script laguage='javascript'>alert('Preencha numero do CPF');history.go(-1);</script>";
}
if ($cidade == ""){
echo"<script laguage='javascript'>alert('Preencha sua cidade');history.go(-1);</script>";
}
if ($endereco == ""){
echo"<script laguage='javascript'>alert('Preencha seu endereço');history.go(-1);</script>";
}
// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 1;
$taxa_boleto = 0.00;
$data_venc = "25/07/2013";
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "$codigocli";  // Nosso numero sem o DV - REGRA: Máximo de 8 caracteres!
$dadosboleto["numero_documento"] = "00$codigocli";	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$nome    --- CPF : $rg";
$dadosboleto["endereco1"] = "Endereo :  $endereco ";
$dadosboleto["endereco2"] = "$cidade - $estado -  CEP: $cep  ";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "$curso1";
$dadosboleto["demonstrativo2"] = "Valor de pagamento Único<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "CEDTEC virtual: www.escolacedtec.com.br";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, ";
$dadosboleto["instrucoes2"] = "- Não receber após o Vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: cedtecvirtual@cedtecvirtual.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema de Pré Matrícula CEDTEC - www.escolacedtec.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - BANESTES
$dadosboleto["conta"] = "22.418.545"; 	// Num da conta corrente
$dadosboleto["agencia"] = "552"; 	    // Num da agência

// DADOS PERSONALIZADOS - BANESTES
$dadosboleto["carteira"] = "11"; // Carteira do Tipo COBRANÇA SEM REGISTRO (Carteira 00) - Não é Carteira 11
$dadosboleto["tipo_cobranca"] = "2";  // 2- Sem registro; 
									  // 3- Caucionada; 
									  // 4,5,6 e 7-Cobrança com registro

// SEUS DADOS
$dadosboleto["identificacao"] = "Centro de Desenvolvimento Técnico";
$dadosboleto["cpf_cnpj"] = "05.941.978/0001-71";
$dadosboleto["endereco"] = "Rodovia 262, S/N - Jardim América - CEP 29.140-261";
$dadosboleto["cidade_uf"] = "Cariacica - ES";
$dadosboleto["cedente"] = "Centro de Desenvolvimento Técnico";

// NÃO ALTERAR!
include("include/funcoes_banestes.php"); 
include("include/layout_banestes.php");
?>
