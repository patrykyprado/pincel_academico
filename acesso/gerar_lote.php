<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$get_unidade = $_GET["unidade"];
$get_cc1 = $_GET["cc1"];
$get_cc2 = $_GET["cc2"];
$get_cc3 = $_GET["cc3"];
$inicio = $_GET["inicio"];
$fim = $_GET["fim"];
$limit_i = "0";
$limit = "50";
$get_tipo = "2";
if($get_tipo == 2){
	$get_tipo2 = 99;
} else {
	$get_tipo2 = 1;
}
//FILTRO CC1
if($get_cc1 !=""&&$get_cc2 ==""&&$get_cc3 ==""){
$sql = mysql_query("SELECT * FROM view_iss WHERE id_titulo NOT IN (select id_titulo from iss_xml) AND
cc1 = '$get_cc1' AND iss LIKE '%S%' AND valor_pagto >100
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6  LIMIT $limit_i , $limit");


$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_iss WHERE 
cc1 = '$get_cc1' AND valor_pagto >100
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6  LIMIT $limit_i , $limit");
$dados_soma = mysql_fetch_array($sql_soma);
}
//FILTRO CC1 / CC2
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 ==""){
$sql = mysql_query("SELECT * FROM view_iss WHERE id_titulo NOT IN (select id_titulo from iss_xml) AND
cc1 = '$get_cc1' AND cc3 <> '90' AND cc3 <> '90' AND cc2 = '$get_cc2' AND iss LIKE '%S%'  AND valor_pagto >100
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6  LIMIT $limit_i , $limit");


$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_iss WHERE 
cc1 = '$get_cc1' AND cc2 = '$get_cc2'   AND valor_pagto >100
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6  LIMIT $limit_i , $limit");
$dados_soma = mysql_fetch_array($sql_soma);
}
//FILTRO CC1 / CC2 / CC3
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 !=""){

$sql = mysql_query("SELECT * FROM view_iss WHERE id_titulo NOT IN (select id_titulo from iss_xml) AND
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'  AND iss LIKE '%S%'  AND valor_pagto >100
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6 LIMIT $limit_i , $limit");


$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_iss WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'  AND valor_pagto >100
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6 LIMIT $limit_i , $limit");
$dados_soma = mysql_fetch_array($sql_soma);
}

//PEGA OS DADOS DE CONTROLE DO XML 
$sql_controle = mysql_query("SELECT * FROM controle_lote WHERE unidade LIKE '%$get_unidade%' AND filial LIKE '%$get_cc2%'");
$controle = mysql_fetch_array($sql_controle);
$cnpj = $controle["cnpj"];
$inscricao_municipal = $controle["insc_municipal"];
$cod_trib = $controle["cod_trib_municip"];
$cod_cnae = $controle["cnae"];
$cod_municip = $controle["cod_municip"];
$n_lote = $controle["lote"];
$contar_lote = $controle["max_num"];
$simples_nacional = $controle["simples_nacional"];

$row = mysql_fetch_assoc($sql);
$total = mysql_num_rows($sql);


if ($total == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NÃO HÁ REGISTROS PARA CRIAR LOTE')
    history.back();
    </SCRIPT>");
	return;
}

$i = $contar_lote;


$emissao = date("Y-m-d")."T".date("H:i:s");
// abrindo o documento XML
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>

<EnviarLoteRpsEnvio><LoteRps>

<NumeroLote>".$n_lote."</NumeroLote>
<Cnpj>".$cnpj."</Cnpj>
<InscricaoMunicipal>".$inscricao_municipal."</InscricaoMunicipal>
<QuantidadeRps>".$total."</QuantidadeRps>
<ListaRps>";

// abrindo o while com os dados dos aniversariantes, isso delimita 
do { 

$cod_aluno = $row["cliente_fornecedor"];
//DADOS DO ALUNO
$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = '$cod_aluno'");
$dados_aluno = mysql_fetch_array($sql_aluno);

//NOME SEM ACENTUACAO
$trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ','/','.','-','º',',','Ã',);
$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y','','','','','','A',);
//$aluno = str_replace($trocarIsso, $porIsso, $dados_aluno["nome"]);
//$aluno = strtr($dados_aluno["nome"], "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC");

$aluno = remover_acentos($dados_aluno["nome"]);
$aluno_res = remover_acentos($dados_aluno["nome_fin"]);
//CPF SEM PONTUACAO
$trocarIsso2 = array('.','-');
$porIsso2 = array('','');
$aluno_cpf = str_replace($trocarIsso2, $porIsso2, $dados_aluno["cpf_fin"]);
$aluno_cep = str_replace($trocarIsso2, $porIsso2, $dados_aluno["cep"]);

//ENDERECO SEM ACENTUCAO
$aluno_end = remover_acentos($dados_aluno["endereco"]);
$aluno_uf = remover_acentos($dados_aluno["uf"]);
$aluno_cidade = remover_acentos($dados_aluno["cidade"]);
$aluno_bairro = remover_acentos($dados_aluno["bairro"]);


$aluno_comp = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($dados_aluno["complemento"]));;

//COD MUNICIPIO
$sql_municipio = mysql_query("SELECT * FROM cod_municipios WHERE uf LIKE '%$aluno_uf%' AND nome LIKE '%$aluno_cidade%'");
$dados_mun = mysql_fetch_array($sql_municipio);
$cont_mun = mysql_num_rows($sql_municipio);


if($cont_mun == 1){
$aluno_cod_municipio = $dados_mun["codigo"];
} else {
$aluno_cod_municipio = "00000000";
}


if(trim($aluno) == ""){
$aluno = "--";
} 
if(trim($aluno_bairro) == ""){
$aluno_bairro = "--";
} 
if(trim($aluno_cidade) == ""){
$aluno_cidade = "--";
} 
if(trim($aluno_comp) == ""){
$aluno_comp = "--";
} 
if(trim($aluno_cpf) == ""){
$aluno_cpf = "00000000000";
} 
if(trim($aluno_end) == ""){
$aluno_end = "--";
} 
if(trim($aluno_uf) == ""){
$aluno_uf = "ES";
} 
if(isset($aluno_num) == ""){
$aluno_num = "00";
} else {
$aluno_num = "00";
}

// abrindo um nó com o nome aniversariantes. cada nó neste, 

$xml .="

<Rps>
<InfRps>
<IdentificacaoRps>
<Numero>".$i."</Numero>
<Serie>M</Serie>
<Tipo>1</Tipo>
</IdentificacaoRps>

<DataEmissao>".$emissao."</DataEmissao>
<NaturezaOperacao>1</NaturezaOperacao>
<RegimeEspecialTributacao>6</RegimeEspecialTributacao>
<OptanteSimplesNacional>".$simples_nacional."</OptanteSimplesNacional>
<IncentivadorCultural>2</IncentivadorCultural>
<Status>1</Status>

<Servico>
<Valores>
<ValorServicos>".$row["valor_pagto"]."</ValorServicos>
<IssRetido>2</IssRetido>
<BaseCalculo>".$row["valor_pagto"]."</BaseCalculo>
<Aliquota>0</Aliquota>
</Valores>
<ItemListaServico>8.01</ItemListaServico>
<CodigoCnae>".$cod_cnae."</CodigoCnae>
<CodigoTributacaoMunicipio>".$cod_trib."</CodigoTributacaoMunicipio>
<Discriminacao>ALUNO: ".$aluno."- MENSALIDADE ".$row["parcela"]."</Discriminacao>
<CodigoMunicipio>".$cod_municip."</CodigoMunicipio>
</Servico>
<Prestador>
<Cnpj>".$cnpj."</Cnpj>
<InscricaoMunicipal>".$inscricao_municipal."</InscricaoMunicipal>
</Prestador>
<Tomador>
<IdentificacaoTomador>
<CpfCnpj>
<Cpf>".$aluno_cpf."</Cpf>
</CpfCnpj>
</IdentificacaoTomador>
<RazaoSocial>".$aluno_res."</RazaoSocial>
<Endereco>
<Endereco>".$aluno_end."</Endereco>
<Numero>".$aluno_num."</Numero>
<Complemento>".$aluno_comp."</Complemento>
<Bairro>".$aluno_bairro."</Bairro>
<CodigoMunicipio>".$cod_municip."</CodigoMunicipio>
<Uf>".$aluno_uf."</Uf>
<Cep>".$aluno_cep."</Cep>
</Endereco>
</Tomador>
</InfRps>
</Rps>
";
$titulo = $row["id_titulo"];
$data = date("Y-m-d");
$nome_lote = $n_lote.".xml";
mysql_query("INSERT INTO iss_xml (id_titulo, data, lote, empresa, filial, arquivo) VALUES ('$titulo','$data','$n_lote','$user_empresa', '$get_cc2', '$nome_lote' )");
$i+=1;
// fechando o while dos dados
} while ($row = mysql_fetch_assoc($sql));

// fechando o nó principal
$xml .="</ListaRps></LoteRps></EnviarLoteRpsEnvio>";
$nome_arquivo = date("d-m-Y his");
$ponteiro = fopen("lotes/".$n_lote.".xml", 'w'); //cria um arquivo com o nome backup.xml
fwrite($ponteiro, $xml); // salva conteúdo da variável $xml dentro do arquivo backup.xml
 
$ponteiro = fclose($ponteiro); //fecha o arquivo
 
$novo_lote= $n_lote +1;
$novo_i = $i+1;
mysql_query("UPDATE controle_lote SET lote = '$novo_lote', max_num = '$novo_i' WHERE unidade LIKE '%$get_unidade%'  AND filial LIKE '%$get_cc2%'");
// e liberando a consulta do banco, o que é sempre uma boa prática :)
mysql_free_result($sql);
echo "<script language=\"javascript\">
alert('Arquivo de lote $nome_lote gerado com sucesso!');
window.parent.location.reload();
window.parent.Shadowbox.close();
</script>";
?>

  <body>

  <section id="container" class="sidebar-closed">


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Arquivo Gerado</b>
                          </header>
                        <div class="panel-body">
Arquivo gerado com sucesso!
                          </div>
                          <div class="panel-footer">
                              <center><a onClick="ShadowClose()" href="javascript:parent.location.reload();">FECHAR</a></center>
                          </div>
                      </section>
                 
              </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('includes/footer.php');
 ?>
  </section>
 <?php 
 include('includes/js.php');
 ?>


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