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
$cliente = $_GET['codigo'];


	mysql_select_db($database_local, $local);
	//
	$query_Recordset1 = sprintf("SELECT * FROM inscritos WHERE codigo LIKE '$cliente'", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"));

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

$codigocli = $row_Recordset1['codigo'];
$nome = $row_Recordset1['nome'];
$rg = $row_Recordset1['cpf'];
$nome_fin = $row_Recordset1['nome_fin'];
$cpf_fin = $row_Recordset1['cpf_fin'];
$endereco = $row_Recordset1['end_fin'];
$cidade = $row_Recordset1['cidade_fin'];
$cep = $row_Recordset1['cep_fin'];
$uf = $row_Recordset1['uf_fin'];
$parcelas = $row_Recordset1['parcelas'];
//pega dados do curso
$codcurso = $_GET["modelo"];
$cursopesq    = mysql_query("SELECT * FROM cursosead WHERE codigo = '$codcurso'");
$dadoscur = mysql_fetch_array($cursopesq);
$mod = explode('-',$dadoscur["tipo"]);
$modelo2 = trim(strtoupper($mod[0]));
$modelo = $dadoscur["tipo"];
$nomecurso = $dadoscur["curso"];
if($parcelas ==1){
	$desconto = $dadoscur["desconto_avista"];
} else {
	$desconto = $dadoscur["desconto"];}
$conta = $dadoscur["conta"];
$contapesq    = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
$dadosconta = mysql_fetch_array($contapesq);

$pesq_cont = $row_Recordset1["modalidade"];
$valor_mensal = $dadoscur["valor"]/$parcelas;



$valor_desconto = $valor_mensal - (($desconto*$valor_mensal)/100);
$valor = $valor_mensal;

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0.00;
if($pesq_cont == 2){
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));
	$data_venc2 = date("m/Y");
}else {
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));
	$data_venc2 = date("m/Y");}  // Prazo de X dias OU informe data: "13/04/2006"; 



$codigoboleto = $row_Recordset1['codigo'];
$conferirvalor = stripos($valor,",");
if($conferirvalor == true){
	$valortotal == $valor;
	$valortotal_desconto == $valor_desconto;
	}
if($conferirvalor == false){
	$valortotal = number_format($valor, 2, ',', '');
	$valortotal_desconto = number_format($valor_desconto, 2, ',', '');
	}

?>


<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>         |
// | Desenvolvimento Boleto Santander-Banespa : Fabio R. Lenharo                |
// +----------------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$taxa_boleto = 0;
//date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = "$valortotal"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado_desconto = "$valortotal_desconto";
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_cobrado_desconto = str_replace(",", ".",$valor_cobrado_desconto);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
$valor_boleto_desconto=number_format($valor_cobrado_desconto, 2, ',', '');

$dadosboleto["nosso_numero"] = $codigoboleto;  // Nosso numero sem o DV - REGRA: Máximo de 7 caracteres!
$dadosboleto["numero_documento"] = "00$codigoboleto";	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$nome_fin    --- CNPJ/CPF : $cpf_fin";
$dadosboleto["endereco1"] = "Endereco :  $endereco - $cidade / $uf";
$dadosboleto["endereco2"] = "CEP: $cep  ";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Aluno(a): $nome    --- CNPJ/CPF : $rg <br>- $modelo | $nomecurso - Matrícula";
$dadosboleto["demonstrativo3"] = "- Valor da mensalidade: R$ $valor_boleto.<br>- CEDTEC: www.cedtec.com.br";
$dadosboleto["demonstrativo2"] = "- Valor da mensalidade com desconto: R$ $valor_boleto_desconto.";
$dadosboleto["instrucoes1"] = "- Sr. Caixa,";
$dadosboleto["instrucoes2"] = "- Não receber após o vencimento.";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: comunicacao@cedtec.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Pincel Atômico - www.cedtec.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS PERSONALIZADOS - SANTANDER BANESPA
$dadosboleto["codigo_cliente"] = $dadosconta["cedente"]; // Código do Cliente (PSK) (Somente 7 digitos)
$dadosboleto["ponto_venda"] = $dadosconta["agencia"]; // Ponto de Venda = Agencia
$dadosboleto["carteira"] = "101";  // Cobrança Simples - SEM Registro
$dadosboleto["carteira_descricao"] = "101SRCR";  // Descrição da Carteira

// SEUS DADOS
$dadosboleto["identificacao"] =  $dadosconta["razao"];
$dadosboleto["cpf_cnpj"] = substr($dadosconta["cnpj"],0,2).".".substr($dadosconta["cnpj"],2,3).".".substr($dadosconta["cnpj"],5,3)."/".substr($dadosconta["cnpj"],8,4)."-".substr($dadosconta["cnpj"],12,2);
$dadosboleto["endereco"] = "";//$dados2["endereco"].chr(10)."-".chr(10).$dados2["bairro"].chr(10)."- CEP".chr(10).$dados2["cep"];
$dadosboleto["cidade_uf"] = "";//$dados2["cidade"];
$dadosboleto["cedente"] = $dadosconta["razao"];

// NÃO ALTERAR!
include("include/funcoes_santander_banespa.php"); 
include("include/layout_santander_banespa.php");
?>
