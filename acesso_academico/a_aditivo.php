<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["id"];
$ref = $_GET["ref"];

$re    = mysql_query("select count(*) as total from geral WHERE codigo = $id AND ref_id = $ref " );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from geral WHERE codigo LIKE '$id' AND ref_id = '$ref'");
	$dados = mysql_fetch_array($re);
	//VERIFICA SITUACAO FINANCEIRA E AUTORIZA REMATRÍCULA
	$data = date("Y-m-d");	
	$pesq = mysql_query("SELECT DISTINCT A.codigo, A.aluno, C.telefone, C.celular, C.tel_fin FROM g_cliente_fornecedor A  
	INNER JOIN titulos B ON A.codigo = B.cliente_fornecedor 
	INNER JOIN alunos C ON A.codigo = C.codigo 
	WHERE (B.data_pagto = '' OR B.data_pagto is null) 
	AND B.vencimento < '$data' AND B.status = 0 AND B.cliente_fornecedor = $id");
	$count_fin = mysql_num_rows($pesq);
}

$qtd = mysql_num_rows($re);
if($qtd == 0){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('A REMATRÍCULA PARA A SUA TURMA AINDA NÃO ESTÁ DISPONÍVEL')
    window.close();
    </SCRIPT>");}
	
if($count_fin > 0){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ POSSUI TÍTULOS EM ATRASO, VERIFIQUE SUA SITUAÇÃO COM O SETOR FINANCEIRO PARA PODER REALIZAR A REMATRÍCULA.')
    window.close();
    </SCRIPT>");
} else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('PARA EFETIVAR SUA REMATRÍCULA VOCÊ DEVE REALIZAR O PAGAMENTO DO BOLETO CLICANDO EM GERAR BOLETO E IMPRIMIR O ADITIVO. APÓS O PAGAMENTO DEVE-SE ENTREGAR O ADITIVO COM COMPROVANTE NA SECRETARIA DA ESCOLA.')
    </SCRIPT>");
}

$codigo = $dados["codigo"];
$nome = strtoupper($dados["nome"]);
$nome_fin = strtoupper($dados["nome_fin"]);
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
                              <b>Aditivo de Rematr&iacute;cula</b><br>
                              <font size="-2" style="font-weight:bold;" color="#FF0004">OBS: A rematr&iacute;cula somente ser&aacute; confirmada ap&oacute;s o pagamento do boleto de rematr&iacute;cula e entrega do aditivo de rematr&iacute;cula devidamente assinado na secretaria de sua unidade.</font>
                          </header>
                        <div class="panel-body" style="color:#000000">
<div id="filtro" class="filtro" align="center"><a href="javascript:print()"><img src="../images/imprimir.png" alt="IMPRIMIR CONTRATO" /></a> <a href="a_gerar_boleto.php?id=<?php echo $codigo;?>&ref_id=<?php echo $ref;?>"><img src="../images/icone_boleto.png" alt="GERAR BOLETO" /></a></div>
<BR />
<div style="background-color:#D5D5D5; border:solid 2px; text-align:center;"><strong>SE</strong><strong>GUNDO</strong><strong> </strong><strong>A</strong><strong>DITIVO</strong><strong> </strong><strong>A</strong><strong>O</strong><strong> </strong><strong>CONTRATO</strong><strong> </strong><strong>DE</strong><strong> </strong><strong>P</strong><strong>RESTA&Ccedil;&Atilde;O</strong><strong> </strong><strong>DE</strong><strong> SE</strong><strong>RVI&Ccedil;OS</strong><strong> EDUCACIONAIS &Agrave; DIST&Acirc;NCIA N&ordm; 01/<?php echo date("Y");?></strong>
</div><br /><br /><br />
<div style="background-color:#D5D5D5; border:solid 2px; width:300px; float:right">Pelo presente ADITIVO  ao <u>Contrato de</u> <u>Presta&ccedil;&atilde;o de Servi&ccedil;os  Educacionais &agrave;</u> <u>dist&acirc;ncia</u>, j&aacute; firmados entre as  partes e na melhor forma de direito, de um lado o:</div>
<br /><br /><br /><br /><p><strong>CEDTEC-CENTRO DE DESENVOLVIMENTO T&Eacute;CNICO -  LTDA</strong>, devidamente inscrito no CNPJ sob o n&ordm;. <strong>05.941.978/0001-71</strong>, com endere&ccedil;o na Avenida CIVIT, n&ordm;<br />
  911 &ndash; Parque Residencial Laranjeiras, Serra &ndash; ES, CEP: 29.165.032, neste  ato,  representado pelo seu Diretor Geral Corporativo e procurador, pelo Diretor por ele  nomeado, ou procurador devidamente constitu&iacute;do, doravante denominada <strong>CONTRATADA, </strong>e  de outro lado, <u><b><?php echo $nome_fin;?></b></u>&nbsp;como <strong>CONTRATANTE  &nbsp;</strong>assim  &nbsp;denominado, &nbsp;nos &nbsp;termos  &nbsp;da &nbsp;Lei  &nbsp;e  &nbsp;do &nbsp;Contrato &nbsp;de<br />
Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais n&ordm; 01/2014, assinado em ___/__/_____, para Presta&ccedil;&atilde;o&nbsp;&nbsp;de&nbsp;Servi&ccedil;os&nbsp;Educacionais ao aluno <b><u><?php echo $nome;?></u></b>&nbsp;, mat. n&ordm; <b><u><?php echo $codigo;?></u></b>&nbsp;, devidamente qualificado no seu requerimento de matr&iacute;cula. Tem entre si  justo e acordado o que se segue:</p>
<p><strong>CL&Aacute;USULA  PRIMEIRA</strong>: Constitui objeto deste termo aditivo a prorroga&ccedil;&atilde;o da  vig&ecirc;ncia do Contrato de Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais  por  mais um semestre letivo, per&iacute;odo <?php echo date("Y");?>.1, ao  fim do qual,  o <strong>CONTRATANTE </strong>dever&aacute;  renovar sua &nbsp;matr&iacute;cula &nbsp;mediante &nbsp;um  &nbsp;novo &nbsp;TERMO &nbsp;ADITIVO,  &nbsp;para&nbsp; que &nbsp;possa  realizar as disciplinas subsequentes, conforme a matriz curricular (fluxograma) e seu calend&aacute;rio, ambos definidos pela <strong>CONTRATADA</strong>.</p>
<p><strong>P</strong><strong>A</strong><strong>R&Aacute;GRAFO &Uacute;NICO: </strong>A configura&ccedil;&atilde;o formal da prorroga&ccedil;&atilde;o da vig&ecirc;ncia do Contrato de  Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais dar-se-&aacute;  pela  assinatura e entrega &nbsp;deste &nbsp;Termo &nbsp;Aditivo,  &nbsp;por &nbsp;parte&nbsp;  do &nbsp;<strong>CONTRATANTE</strong>, &nbsp;no &nbsp;Setor  &nbsp;da Secretaria  da <strong>CONTRATADA, </strong>bem como  pelo  pagamento  da primeira parcela do per&iacute;odo contratado.</p>
<p><strong>CL&Aacute;USULA  SEGUNDA: </strong>O presente Termo de Aditamento passa a fazer parte  integrante do Contrato de Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais &agrave; Dist&acirc;ncia n&ordm;<br />
  01/2014, permanecendo inalteradas todas  as  demais disposi&ccedil;&otilde;es  nele  contidas e  n&atilde;o  referidas no presente aditivo.</p>
<p>E por estarem, assim, justas e contratadas, assinam o presente  em  02 (duas) vias de igual teor e forma, juntamente com as testemunhas  abaixo.</p>
<div align="center"><p>_______________________,de______________de <?php echo date("Y");?>.</p></div>
<p><strong>CONTRATANTE: <u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></strong></p>
<p><strong>CONTRATADA: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u><br />
CEDTEC - CENTRO DE DESENVOLVIMENTO T&Eacute;CNICO  LTDA</strong></p>
<strong>Testemunhas:</strong><br />
Nome:____________________________    CPF:____________________<br />
Nome:____________________________ CPF:____________________ 
                          </div>
                      </section>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



  </section>
 <?php 
 include('includes/js.php');
 ?>


  </body>
</html>


    
