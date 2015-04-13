<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["id"];
$ref = $_GET["ref_id"];

$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from curso_aluno WHERE matricula = $id AND ref_id = $ref ORDER BY ref_id DESC LIMIT 1");
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
}

$grupo = $dados["grupo"];
$modulo = trim($dados["modulo"])+1;
$curso = trim(remover_acentos($dados["curso"]));
$nivel = trim(remover_acentos($dados["nivel"]));

if($modulo >=3){
	$modulo = 3;	
}

$ver_remat    = mysql_query("select * from rematricula WHERE codigo = $id AND grupo LIKE '%$grupo%' AND modulo LIKE '%$modulo%'");

$total_remat = mysql_num_rows($ver_remat);
if($total_remat >=1){
	//REDIRECIONA PARA O BOLETO
	$p_boleto = mysql_query("SELECT * FROM titulos WHERE status = 99 AND descricao LIKE '%REM2015-CED%' AND cliente_fornecedor = $id AND (data_pagto IS NULL OR data_pagto LIKE '')");
	$dados_boleto = mysql_fetch_array($p_boleto);
	$id_titulo = $dados_boleto["id_titulo"];
	header("Location: ../boleto/boleto_santander.php?id=$id_titulo&p=1&id2=$id");
}  else {
	mysql_query("INSERT INTO rematricula (codigo, grupo, modulo) VALUES ('$id','$grupo','$modulo');");
	
	
	$p_curso = mysql_query("SELECT * FROM cursos_rematricula WHERE nivel LIKE '%$nivel%' AND curso LIKE '%$curso%' AND modulo = $modulo LIMIT 1");
	$dados_curso = mysql_fetch_array($p_curso);
	$valor = $dados_curso["valor_parcela"];
	$conta = $dados_curso["conta"];
	$data_venc_final = date("Y-m-d", strtotime('+2 day'));
	mysql_query("DELETE FROM titulos WHERE STATUS = 99 AND descricao LIKE '%REM2015-CED%' AND cliente_fornecedor = $id AND (data_pagto IS NULL OR data_pagto LIKE '');");
	mysql_query("INSERT INTO titulos (id_titulo, cliente_fornecedor, descricao,parcela, vencimento, valor,status,tipo,conta,c_custo) VALUES (NULL,'$id','BOLETO REMATRÍCULA - $curso - REM2015-CED',1,'$data_venc_final','$valor',99,2,'$conta','10EA212101');");
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('PARA FINALIZAR SUA REMATRÍCULA REALIZE O PAGAMENTO DO BOLETO E ENTREGUE-O JUNTO COM O ADITIVO NA SECRETARIA DA ESCOLA.')
    </SCRIPT>");
	sleep(5);
	
	
	//REDIRECIONA PARA O BOLETO
	$p_boleto = mysql_query("SELECT * FROM titulos WHERE status = 99 AND descricao LIKE '%REM2015-CED%' AND cliente_fornecedor = $id AND (data_pagto IS NULL OR data_pagto LIKE '')");
	$dados_boleto = mysql_fetch_array($p_boleto);
	$id_titulo = $dados_boleto["id_titulo"];
	mysql_query("DELETE FROM rematricula");
	header("Location: ../boleto/boleto_santander.php?id=$id_titulo&p=1&id2=$id");
	
	
}

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
                              <b>Boleto de Rematr&iacute;cula</b><br>
                              <font size="-2" style="font-weight:bold;" color="#FF0004">OBS: A rematr&iacute;cula somente ser&aacute; confirmada ap&oacute;s o pagamento do boleto de rematr&iacute;cula e entrega do aditivo de rematr&iacute;cula devidamente assinado na secretaria de sua unidade.</font>
                          </header>
                        <div class="panel-body" style="color:#000000">
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


    
