<title>Boleto CEDTEC Virtual</title>
<div align="center"><a href="javascript:window.print()">Imprimir essa Página </a>
</div>
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


$dvnum = CalculaDigitoMod11($_POST['codigo'], 2, 12);
$codigocli = $_POST['codigo'];
$nome = $_POST['nome'];
$rg = $_POST['cpf'];
$endereco = $_POST['endereco'];
$cidade = $_POST['bairro'];
$estado = $_POST['uf'];
$cep = $_POST['cep'];
$valor = $_POST['valor'];
$curso1 = $_POST['curso2'];

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
$dias_de_prazo_para_pagamento = 10;
$taxa_boleto = 2.50;
//$data_venc = "21/09/2012";
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
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
$dadosboleto["conta"] = "18.431.304"; 	// Num da conta corrente
$dadosboleto["agencia"] = "552"; 	    // Num da agência

// DADOS PERSONALIZADOS - BANESTES
$dadosboleto["carteira"] = "11"; // Carteira do Tipo COBRANÇA SEM REGISTRO (Carteira 00) - Não é Carteira 11
$dadosboleto["tipo_cobranca"] = "2";  // 2- Sem registro; 
									  // 3- Caucionada; 
									  // 4,5,6 e 7-Cobrança com registro

// SEUS DADOS
$dadosboleto["identificacao"] = "Centro de Desenvolvimento Técnico";
$dadosboleto["cpf_cnpj"] = "05.941.978/0006-86";
$dadosboleto["endereco"] = "Rodovia 262, S/N - Jardim América - CEP 29.140-261";
$dadosboleto["cidade_uf"] = "Cariacica - ES";
$dadosboleto["cedente"] = "Centro de Desenvolvimento Técnico";

// NÃO ALTERAR!
include("include/funcoes_banestes.php"); 
include("include/layout_banestes.php");
?>
