<?php
function limpar_string($str) {  
         $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $str);  
         return $str;
}

function format_data($al)
{
	$exib = substr($al,8,2)."/".substr($al,5,2)."/".substr($al,0,4);
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
	$data_mes_nome = "Março";
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
	$map = array(
    'á' => 'a',
    'à' => 'a',
    'ã' => 'a',
    'â' => 'a',
    'é' => 'e',
    'ê' => 'e',
    'í' => 'i',
    'ó' => 'o',
    'ô' => 'o',
    'õ' => 'o',
    'ú' => 'u',
    'ü' => 'u',
    'ç' => 'c',
    'Á' => 'A',
    'À' => 'A',
    'Ã' => 'A',
    'Â' => 'A',
    'É' => 'E',
    'Ê' => 'E',
    'Í' => 'I',
    'Ó' => 'O',
    'Ô' => 'O',
    'Õ' => 'O',
    'Ú' => 'U',
    'Ü' => 'U',
    'Ç' => 'C'
);
 
return strtr($string, $map);

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

?>