<?php
function limpar_string($str) {  
         $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $str);  
         return $str;
}
function func_nota_aluno($matricula, $turma_disc, $etapa){
	$sql_nota = mysql_query("SELECT notafinal FROM view_boletim_notas
WHERE matricula = $matricula AND turma_disc = $turma_disc AND subgrupo <> 'C' AND id_etapa = $etapa");
	if(mysql_num_rows($sql_nota)==0){
		$nota_aluno = 0;	
	} else {
		$dados_nota = mysql_fetch_array($sql_nota);
		$nota_aluno = $dados_nota['notafinal'];	
	}
	
	$nota_final = $nota_aluno;
	return format_valor($nota_final);
}

function format_data($al)
{
    $exib = substr($al,8,2)."/".substr($al,5,2)."/".substr($al,0,4);
    return $exib;
}

function format_data_us($data)
{
    $exib = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
    return $exib;
}

function format_data_hora($al)
{
	$exib = substr($al,8,2)."/".substr($al,5,2)."/".substr($al,0,4)." ".substr($al,11,10);
	return $exib;
}
function ShadowClose() {
    window.parent.Shadowbox.close();
    window.location.reload();
}
function formatar_sms($cel)
{
	$cel_filtrado = preg_replace("/[^0-9]/", "", $cel);
	if(strlen($cel_filtrado) <= 11&&strlen($cel_filtrado>0)){
		if(substr($cel_filtrado,0,1)==3){
			$cel_filtrado = "N�mero Inv�lido";
			return $cel_filtrado;
		}
		if(substr($cel_filtrado,0,2)==273){
			$cel_filtrado = "N�mero Inv�lido";
			return $cel_filtrado;	
		}
		if(substr($cel_filtrado,0,1)==9){
			$cel_filtrado = "5527".$cel_filtrado;
			return $cel_filtrado;	
		}
		
		$cel_filtrado = "55".$cel_filtrado;
	} else {
		$cel_filtrado = "N�mero Inv�lido";	
	}
	return $cel_filtrado;
}
function not($al)
{
	$exib = $al;
	return $exib;
}

function format_email($al)
{
	$exib = strtolower($al);
	return $exib;
}

function format_valor($al)
{
	$exib = number_format($al,2,",",".");
	return $exib;
}

function format_curso($al)
{
	$exib = ucwords(strtolower($al));
	return $exib;
}

function format_mes($data_mes)
{
if($data_mes == '01'){
	$data_mes_nome = "Janeiro";
}
if($data_mes == '02'){
	$data_mes_nome = "Fevereiro";
}
if($data_mes == '03'){
	$data_mes_nome = "Mar�o";
}
if($data_mes == '04'){
	$data_mes_nome = "Abril";
}
if($data_mes == '05'){
	$data_mes_nome = "Maio";
}
if($data_mes == '06'){
	$data_mes_nome = "Junho";
}
if($data_mes == '07'){
	$data_mes_nome = "Julho";
}
if($data_mes == '08'){
	$data_mes_nome = "Agosto";
}
if($data_mes == '09'){
	$data_mes_nome = "Setembro";
}
if($data_mes == '10'){
	$data_mes_nome = "Outubro";
}
if($data_mes == '11'){
	$data_mes_nome = "Novembro";
}
if($data_mes == '12'){
	$data_mes_nome = "Dezembro";
}
return $data_mes_nome;
}

function format_data_escrita($data){
	$ano = substr($data,0,4);
	$mes = substr($data,5,2);
	$dia = substr($data,8,2);
	
	$mes_escrito = format_mes($mes);
	
	return $dia." de ".$mes_escrito." de ".$ano;
}

function format_data_escrita_BR($data){
	$ano = substr($data,6,4);
	$mes = substr($data,3,2);
	$dia = substr($data,0,2);
	
	$mes_escrito = format_mes($mes);
	
	return $dia." de ".$mes_escrito." de ".$ano;
}


function remover_acentos($string) {
	return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($string));

}
function arredondamento($string){
	$string = floatval($string);
	if(strpos($string,".")== FALSE){
		return $string;
	} else {
		$exp_string = explode(".",$string);
		$n1 = $exp_string[0];
		$n2 = $exp_string[1];
		if($n2 <= 5){
			$n2_soma = 0.5;	
		}
		if($n2 > 5){
			$n2_soma = 1;
		}
		$nota = $n1 + $n2_soma;
		return $nota;
	}
	
}

function converter_data($string){
	return substr($string,6,4)."-".substr($string,3,2)."-".substr($string,0,2);
}

function format_letra($letra)
{
if($letra == '1'){
	$letra_exib = "A)";
}
if($letra == '2'){
	$letra_exib = "B)";
}
if($letra == '3'){
	$letra_exib = "C)";
}
if($letra == '4'){
	$letra_exib = "D)";
}
if($letra == '5'){
	$letra_exib = "E)";
}
if($letra == '6'){
	$letra_exib = "F)";
}
if($letra == '7'){
	$letra_exib = "G)";
}
if($letra == '8'){
	$letra_exib = "H)";
}
if($letra == '9'){
	$letra_exib = "I)";
}
return $letra_exib;
}


function func_buscar_aluno($busca,$campos,$tipo_busca)
{
    global $conn;
    switch ($tipo_busca){
        case 1:
            $sql_alunos = "SELECT $campos FROM alunos WHERE nome LIKE '%$busca%' OR nome_fia LIKE '%$busca%' OR nome_fin LIKE '%$busca%'";
             break;
        case 2:
            $sql_alunos = "SELECT $campos FROM cliente_fornecedor WHERE (nome LIKE '%$busca%' OR nome_fantasia LIKE '%$busca%') AND tipo = 2";
            break;
        case 4:
            $sql_alunos = "SELECT $campos FROM cliente_fornecedor WHERE (nome LIKE '%$busca%' OR nome_fantasia LIKE '%$busca%') AND tipo = 4";
            break;
		case 10:
			$sql_alunos = "SELECT $campos FROM alunos WHERE codigo = $busca";
            break;

    }
    //PEGA OS DADOS PARA MONTAR O DROP CC2
    $sql_buscar_alunos = $conn->prepare($sql_alunos);
    $sql_buscar_alunos->execute();
    return $sql_buscar_alunos;
}

function func_buscar_titulos($user_unidade,$id_cliente)
{
    global $conn;
	
	if($user_unidade == "" || $user_unidade == "PERTEL"){
		$sql_titulos = "SELECT * FROM geral_titulos WHERE (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id_cliente' ORDER BY vencimento";
	} else {
		$sql_titulos = "SELECT * FROM geral_titulos WHERE (conta_nome LIKE '%$user_unidade%' OR conta_nome LIKE '%livraria%' OR conta_nome LIKE '%pertel%' OR conta_nome LIKE '%EAD%') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id_cliente' ORDER BY vencimento";
	}    
    //PEGA OS DADOS PARA MONTAR O DROP CC2
    $sql_buscar_titulos = $conn->prepare($sql_titulos);
    $sql_buscar_titulos->execute();
    return $sql_buscar_titulos;
}

function func_calculo_juros($data_atual,$id_titulo)
{
    global $conn;
	$sql_calculo = "SELECT t1.id_titulo, t1.vencimento, t1.valor, t1.dias_atraso , 
t1.multa, t1.juros_dia, t1.honorario,
t1.multa+t1.juros_dia+t1.honorario as acrescimos_totais,
t1.valor+t1.multa+t1.juros_dia+t1.honorario as valor_calculado

FROM (
SELECT id_titulo, vencimento,data_pagto, valor_pagto, valor, DATEDIFF(NOW(), vencimento) as dias_atraso,  status,

IF(DATEDIFF(NOW(), vencimento) >=1,0.02*valor,0) as multa,
IF(DATEDIFF(NOW(), vencimento) >=1,((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*(valor),0) as juros_dia,
IF(DATEDIFF(NOW(), vencimento) >=11,0.10*(valor+(((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*valor)+(0.02*valor)),0) as honorario


FROM titulos 
) as t1
WHERE (t1.data_pagto = '' OR t1.data_pagto IS NULL) AND t1.vencimento < '$data_atual' AND t1.status = 0 AND t1.id_titulo = $id_titulo";  
    //PEGA OS DADOS PARA MONTAR O DROP CC2
    $sql_calcular_juros = $conn->prepare($sql_calculo);
    $sql_calcular_juros->execute();
    return $sql_calcular_juros;
}

function memedCache($consulta, $tempo = 7200) {
    $chave = md5($consulta);

    $mem = new Memcache;
    $mem->addServer($_SERVER['HTTP_HOST']);

    $query = $mem->get($chave);
    if ($query === false) {
        $query = mysql_query($consulta);
        $mem->set($chave, $query, 0, $tempo);
    }

    return $query;
}

function gerarNomeDocumentoTurma($dadosTurma,$extensao){
    $curso_exp = explode(' ', $dadosTurma['nivel']);
    $pt1 = substr($curso_exp[0],0,1).substr($curso_exp[1],0,1);
    $pt2 = strtoupper(substr($dadosTurma['curso'],0,3)).$dadosTurma['modulo'];
    $pt3 = '('.$dadosTurma['turno'].str_replace('/', '',$dadosTurma['grupo']).')';

    return $pt1.'-'.$pt2.' '.$pt3.' '.date('dmY His').'.'.$extensao;
}

function calcularTempoExecucao($tempoInicio, $tempoFim){
    $tempoInicio = DateTime::createFromFormat('H:i:s', $tempoInicio);
    $tempoFim = DateTime::createFromFormat('H:i:s', $tempoFim);
    return  $tempoInicio->diff($tempoFim)->format('%H:%I:%S');
}
?>