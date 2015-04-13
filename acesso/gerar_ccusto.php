<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

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
                              <b>Relat&oacute;rio: Gerencial</b>
                          </header>
                        <div class="panel-body">
<?php


//PEGA OS DADOS DO POST
$get_cc1 = $_GET["cc1"];
$get_cc2 = $_GET["cc2"];
$get_cc3 = $_GET["cc3"];
$get_cc4 = $_GET["cc4"];
$get_cc5 = $_GET["cc5"];
$get_cc6 = $_GET["cc6"];
$get_layout = $_GET["layout"];

$dataini = $_GET["inicio"];
$diaini = substr($dataini,0,2);
$mesini = substr($dataini,3,2);
$anoini = substr($dataini,6,4);
$inicio = $anoini."-".$mesini."-".$diaini;

$datafin = $_GET["fim"];
$diafin = substr($datafin,0,2);
$mesfin = substr($datafin,3,2);
$anofin = substr($datafin,6,4);
$fim = $anofin."-".$mesfin."-".$diafin;

$get_tiporel = $_GET["tipo_rel"];

$exib_data_ini = substr($inicio,8,2)."/".substr($inicio,5,2)."/".substr($inicio,0,4);
$exib_data_fim = substr($fim,8,2)."/".substr($fim,5,2)."/".substr($fim,0,4);

$get_ebitda= $_GET["ebitda"];
if($get_ebitda == "geral"){
	$ebitda = "";	
} else {
	$ebitda = "AND ebitda LIKE '%$get_ebitda%'";	
}


if($get_cc1 != ""&&$get_cc2 == ""&&$get_cc3 == ""&&$get_cc4 == ""&&$get_cc5 == ""&&$get_cc6 == ""&&$get_tiporel==2){
//FILTRO CC1 CONSOLIDADO
if($get_cc1 != ""&&$get_cc2 == ""&&$get_cc3 == ""&&$get_cc4 == ""&&$get_cc5 == ""&&$get_cc6 == ""&&$get_tiporel==2){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND data_pagto <> '' AND cc3 <> '90'  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
$count = mysql_num_rows($sql);


// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
	$cc1 = mysql_query("SELECT * FROM cc1 WHERE id_empresa = $get_cc1");
	$dados_cc1 = mysql_fetch_array($cc1);
	$nome_cc1 = ($dados_cc1["razao"]);
	$nome_cc1_r = ($dados_cc1["nome_cc1"]);
	$link_logo = $dados_cc1["logo"];
	//PEGA O CC2
	$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
	$contar_cc2 = (mysql_num_rows($sql_cc2)*2)+5;
	echo "<table align=\"center\" class=\"full_table_list\" width=\"auto\" border=\"1\">
	<thead><tr style=\"font-size:12px;\">
	<td colspan=\"$contar_cc2\" valign=\"middle\"><div style=\"float:left; width:20%\"><img src=\"$link_logo\"></div> <div style=\"float:left; width:80%\" align=\"center\"><b>$nome_cc1<br> $exib_data_ini - $exib_data_fim</b></div></td>
	</tr></thead><tr><td align=\"center\" class=\"table_tamanho1\" colspan=\"3\">RELAT&Oacute;RIO CONSOLIDADO</td>";
	
	
	//monta as linhas com nomes do cc3
	while($dados_cc2 = mysql_fetch_array($sql_cc2)){
		$id_cc2 = $dados_cc2["id_filial"];
		$titulo_cc2 = ($dados_cc2["nome_filial"]);
		echo "
		<td class=\"table_tamanho1\" bgcolor=\"#C0C0C0\" ><b>$titulo_cc2</b></td>
		<td class=\"table_tamanho1\" bgcolor=\"#C0C0C0\" align=\"center\"><b>%</b></td>
		";
	}
	echo "<td class=\"table_tamanho1\" bgcolor=\"#00FF7F\" ><b>$nome_cc1_r</b></td>
		<td class=\"table_tamanho1\" bgcolor=\"#00FF7F\" align=\"center\"><b>%</b></td></tr>
<tbody>";//CEDTEC
	
}
	//PEGA O CC3 receita ou deduções
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 21 OR id_cc3 = 30 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			
			
			//PEGA % DE DEDUCOES
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc2["total_cc2"] > 0&&$id_cc3 <>21){//conta total
				$exib = number_format((($dados_sum_cc2["total_cc2"]/$dados_sum_receita_total["total_cc2_total"])*100),2,",",".");
			} else {
				$exib = "0,00";
			}
			if($dados_sum_cc2["total_cc2"] > 0&&$id_cc3 ==21){
				$exib = "100,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		
		//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$total_cc1 = number_format($dados_sum_cc1["total_cc1"],2,",",".");
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc1["total_cc1"] != 0&&$dados_sum_receita_total["total_cc2_total"] != 0){
				$exib = number_format((($dados_sum_cc1["total_cc1"]/$dados_sum_receita_total["total_cc2_total"])*100),2,",",".");
			} else {
				$exib = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
		</tr>"; //fecha a linha e acrescenta o total da empresa
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				//PEGA % DE DEDUCOES
				$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
				$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
				if($dados_sum_cc4["total_cc4"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_receita_total["total_cc2_total"])*100),2,",",".");
				} else {
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/1)*100),2,",",".");
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$valor_test = $dados_sum_cc1["total_cc1"];
			$sql_sum_cc1_cc3 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 = '$id_cc4' $filtro $ebitda");
			$dados_sum_cc1_cc3 = mysql_fetch_array($sql_sum_cc1_cc3);
			$total_cc1_cc3 = number_format($dados_sum_cc1_cc3["total_cc1"],2,",",".");
			$valor_test2 = $dados_sum_cc1_cc3["total_cc1"];
			
			
			if($dados_sum_cc1_cc3["total_cc1"] =! 0){
				$p_total_cc1_cc3 = number_format((($valor_test2/$valor_test)*100),2,",",".");
			} else {
				$p_total_cc1_cc3 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc3</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$p_total_cc1_cc3</font></b></td>
		</tr>"; //fecha a linha e acrescenta o total final //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] !=0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$sql_sum_cc1_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 NOT IN (select cc4 from cc4) $filtro $ebitda");
			$dados_sum_cc1_cc4 = mysql_fetch_array($sql_sum_cc1_cc4);
			$total_cc1_cc4 = number_format($dados_sum_cc1_cc4["total_cc1"],2,",",".");
			if($dados_sum_cc1_cc4["total_cc1"] != 0){
				$percent_total_cc1_cc4 = number_format((($dados_sum_cc1_cc4["total_cc1"]/$dados_sum_cc1["total_cc1"])*100),2,",",".");
			} else {
				$percent_total_cc1_cc4 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc4</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$percent_total_cc1_cc4</font></b></td>
		</tr>"; //fecha a linha e acrescenta o total final
			
			
			
			//RECEITA LIQUIDA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Receita L&iacute;quida (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						if($receita_liquida1!=0){
							$percent_liquido = number_format((($receita_liquida1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_liquido = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$receita_liquida</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_liquido</b></td>";
						
							
					}
					//PEGA A RECEITA BRUTA DA EMPRESA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 where relatorio = 1) AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 where relatorio = 1) AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						if($receita_liquida1!=0){
							$percent_liquido = number_format((($receita_liquida1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_liquido = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$receita_liquida</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_liquido</b></td>
							</tr>";
					
					
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";
	}
	
//segunda parte
	
}
	//PEGA O CC3 CUSTOS
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 10 OR id_cc3 = 13 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			
			if($dados_sum_cc2["total_cc2"] > 0){
				//PEGA % DE DEDUCOES
				$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
				$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
				$exib = number_format(($dados_sum_cc2["total_cc2"]/$dados_sum_receita_total["total_cc2_total"])*100,2,",",".");
			} else {
				$exib = "0,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$total_cc1 = number_format($dados_sum_cc1["total_cc1"],2,",",".");
			//PEGA % DE DEDUCOES
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc1["total_cc1"] != 0&&$dados_sum_receita_total["total_cc2_total"] != 0){
				$exib = number_format(($dados_sum_cc1["total_cc1"]/$dados_sum_receita_total["total_cc2_total"])*100,2,",",".");
			} else {
				$exib = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
		</tr>"; //fecha a linha e acrescenta o total da empresa //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				//PEGA % DE DEDUCOES

				$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
				$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
				if($dados_sum_cc4["total_cc4"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_receita_total["total_cc2_total"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$valor_test = $dados_sum_cc1["total_cc1"];
			$sql_sum_cc1_cc3 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 = '$id_cc4' $filtro $ebitda");
			$dados_sum_cc1_cc3 = mysql_fetch_array($sql_sum_cc1_cc3);
			$total_cc1_cc3 = number_format($dados_sum_cc1_cc3["total_cc1"],2,",",".");
			$valor_test2 = $dados_sum_cc1_cc3["total_cc1"];
			if($dados_sum_cc1_cc3["total_cc1"] =! 0){
				$p_total_cc1_cc3 = number_format((($valor_test2/$valor_test)*100),2,",",".");
			} else {
				$p_total_cc1_cc3 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc3</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$p_total_cc1_cc3</font></b></td>
		</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 =  "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$sql_sum_cc1_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 NOT IN (select cc4 from cc4) $filtro $ebitda");
			$dados_sum_cc1_cc4 = mysql_fetch_array($sql_sum_cc1_cc4);
			$total_cc1_cc4 = number_format($dados_sum_cc1_cc4["total_cc1"],2,",",".");
			if($dados_sum_cc1_cc4["total_cc1"] != 0){
				$percent_total_cc1_cc4 = number_format((($dados_sum_cc1_cc4["total_cc1"]/$dados_sum_cc1["total_cc1"])*100),2,",",".");
			} else {
				$percent_total_cc1_cc4 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc4</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$percent_total_cc1_cc4</font></b></td>
		</tr>";
			//RECEITA BRUTA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado Bruto (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						$resultado_bruto = number_format($resultado_bruto1,2,",",".");
						
						if($resultado_bruto1!=0){
							$percent_bruto = number_format((($resultado_bruto1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_bruto = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_bruto</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_bruto</b></td>";
						
							
					}
					
					//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1)AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						$resultado_bruto = number_format($resultado_bruto1,2,",",".");
						
						if($resultado_bruto1!=0){
							$percent_bruto = number_format((($resultado_bruto1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_bruto = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_bruto</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_bruto</b></td></tr>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";
		

//terceira parte
	
}
	//PEGA O CC3 DESPESAS
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 15 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			//PEGA % DE DEDUCOES
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc2["total_cc2"] > 0&&$dados_sum_receita_total["total_cc2_total"] >0 ){
				$exib = number_format(($dados_sum_cc2["total_cc2"]/$dados_sum_receita_total["total_cc2_total"])*100,2,",",".");
			} else {
				$exib = "0,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$total_cc1 = number_format($dados_sum_cc1["total_cc1"],2,",",".");
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc1["total_cc1"] != 0&&$dados_sum_receita_total["total_cc2_total"] !=0){
				$exib = number_format(($dados_sum_cc1["total_cc1"]/$dados_sum_receita_total["total_cc2_total"])*100,2,",",".");
			} else {
				$exib = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
		</tr>"; //fecha a linha e acrescenta o total da empresa //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
				$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
				if($dados_sum_cc4["total_cc4"] !=0&&$dados_sum_receita_total["total_cc2_total"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_receita_total["total_cc2_total"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$valor_test = $dados_sum_cc1["total_cc1"];
			$sql_sum_cc1_cc3 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 = '$id_cc4' $filtro $ebitda");
			$dados_sum_cc1_cc3 = mysql_fetch_array($sql_sum_cc1_cc3);
			$total_cc1_cc3 = number_format($dados_sum_cc1_cc3["total_cc1"],2,",",".");
			$valor_test2 = $dados_sum_cc1_cc3["total_cc1"];
			if($dados_sum_cc1_cc3["total_cc1"] =! 0){
				$p_total_cc1_cc3 = number_format((($valor_test2/$valor_test)*100),2,",",".");
			} else {
				$p_total_cc1_cc3 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc3</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$p_total_cc1_cc3</font></b></td>
		</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$sql_sum_cc1_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 NOT IN (select cc4 from cc4) $filtro $ebitda");
			$dados_sum_cc1_cc4 = mysql_fetch_array($sql_sum_cc1_cc4);
			$total_cc1_cc4 = number_format($dados_sum_cc1_cc4["total_cc1"],2,",",".");
			if($dados_sum_cc1_cc4["total_cc1"] != 0){
				$percent_total_cc1_cc4 = number_format((($dados_sum_cc1_cc4["total_cc1"]/$dados_sum_cc1["total_cc1"])*100),2,",",".");
			} else {
				$percent_total_cc1_cc4 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc4</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$percent_total_cc1_cc4</font></b></td>
		</tr>";
			//RECEITA BRUTA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado Líquido - EBITDA (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						$resultado_bruto = number_format($resultado_bruto1,2,",",".");
						
						
						//PEGA AS DESPESAS
						$sql_cc2_desp = mysql_query("SELECT SUM(valor_pagto) as total_cc2_despesas FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 15) $filtro $ebitda");
						$sum_despesas = mysql_fetch_array($sql_cc2_desp);
						$resultado_ebitda1 = $resultado_bruto1 - $sum_despesas["total_cc2_despesas"];
						$resultado_ebitda = number_format($resultado_ebitda1,2,",",".");
						
						
						if($resultado_ebitda1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_ebitda = number_format((($resultado_ebitda1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_ebitda = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_ebitda</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_ebitda</b></td>";
						
							
					}
					
					//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						$resultado_bruto = number_format($resultado_bruto1,2,",",".");
						
						
						//PEGA AS DESPESAS
						$sql_cc2_desp = mysql_query("SELECT SUM(valor_pagto) as total_cc2_despesas FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND (cc3 = 15) $filtro $ebitda");
						$sum_despesas = mysql_fetch_array($sql_cc2_desp);
						$resultado_ebitda1 = $resultado_bruto1 - $sum_despesas["total_cc2_despesas"];
						$resultado_ebitda = number_format($resultado_ebitda1,2,",",".");
						
						
						if($resultado_ebitda1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_ebitda = number_format((($resultado_ebitda1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_ebitda = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_ebitda</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_ebitda</b></td></tr>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";




//quarta parte
	
}
	//PEGA O CC3 INVESTIMENTOS
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 17 OR id_cc3 = 23 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2  = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc2["total_cc2"] != 0&&$dados_sum_receita_total["total_cc2_total"] !=0){
				$exib = number_format(($dados_sum_cc2["total_cc2"]/$dados_sum_receita_total["total_cc2_total"])*100,2,",",".");
			} else {
				$exib = "0,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$total_cc1 = number_format($dados_sum_cc1["total_cc1"],2,",",".");
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc1["total_cc1"] != 0&&$dados_sum_receita_total["total_cc2_total"] != 0){
				$exib = number_format(($dados_sum_cc1["total_cc1"]/$dados_sum_receita_total["total_cc2_total"])*100,2,",",".");
			} else {
				$exib = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
		</tr>"; //fecha a linha e acrescenta o total da empresa //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2  = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
				$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
				if($dados_sum_cc4["total_cc4"] !=0&&$dados_sum_receita_total["total_cc2_total"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_receita_total["total_cc2_total"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$valor_test = $dados_sum_cc1["total_cc1"];
			$sql_sum_cc1_cc3 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 = '$id_cc4' $filtro $ebitda");
			$dados_sum_cc1_cc3 = mysql_fetch_array($sql_sum_cc1_cc3);
			$total_cc1_cc3 = number_format($dados_sum_cc1_cc3["total_cc1"],2,",",".");
			$valor_test2 = $dados_sum_cc1_cc3["total_cc1"];
			if($valor_test2 !=0&&$valor_test !=0){
				$p_total_cc1_cc3 = number_format((($valor_test2/$valor_test)*100),2,",",".");
			} else {
				$p_total_cc1_cc3 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc3</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$p_total_cc1_cc3</font></b></td>
		</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$sql_sum_cc1_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 NOT IN (select cc4 from cc4) $filtro $ebitda");
			$dados_sum_cc1_cc4 = mysql_fetch_array($sql_sum_cc1_cc4);
			$total_cc1_cc4 = number_format($dados_sum_cc1_cc4["total_cc1"],2,",",".");
			if($dados_sum_cc1_cc4["total_cc1"] != 0){
				$percent_total_cc1_cc4 = number_format((($dados_sum_cc1_cc4["total_cc1"]/$dados_sum_cc1["total_cc1"])*100),2,",",".");
			} else {
				$percent_total_cc1_cc4 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc4</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$percent_total_cc1_cc4</font></b></td>
		</tr>";
			//RECEITA BRUTA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado de Investimentos (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
						
						$resultado_invest1 = $sum_rinvest["total_rinvest"] - $sum_invest["total_invest"];
						$resultado_invest = number_format($resultado_invest1,2,",",".");
						
						
						
						if($resultado_invest1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_invest = number_format((($resultado_invest1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_invest = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_invest</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_invest</b></td>";
						
							
					}
					
					//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
						
						$resultado_invest1 = $sum_rinvest["total_rinvest"] - $sum_invest["total_invest"];
						$resultado_invest = number_format($resultado_invest1,2,",",".");
						
						
						
						if($resultado_invest1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_invest = number_format((($resultado_invest1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_invest = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_invest</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_invest</b></td>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";
			
			


//quinta parte
	
}
	//PEGA O CC3 CUSTOS
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 19 OR id_cc3 = 25 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2  = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc2["total_cc2"] != 0&&$dados_sum_receita_total["total_cc2_total"] != 0){
				$exib = number_format(($dados_sum_cc2["total_cc2"]/$dados_sum_receita_total["total_cc2_total"])*100,2,",",".");
			} else {
				$exib = "0,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$total_cc1 = number_format($dados_sum_cc1["total_cc1"],2,",",".");
			$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
			if($dados_sum_cc1["total_cc1"] != 0){
				$exib = number_format(($dados_sum_cc1["total_cc1"]/$dados_sum_receita_total["total_cc2_total"])*100,2,",",".");
			} else {
				$exib = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
		</tr>"; //fecha a linha e acrescenta o total da empresa //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				$sql_sum_receita_total = mysql_query("SELECT SUM(valor_pagto) as total_cc2_total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2  = '$id_cc2' AND cc3 = '21' $filtro $ebitda");
				$dados_sum_receita_total = mysql_fetch_array($sql_sum_receita_total);
				if($dados_sum_cc4["total_cc4"] !=0&&$dados_sum_receita_total["total_cc2_total"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_receita_total["total_cc2_total"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '21' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$valor_test = $dados_sum_cc1["total_cc1"];
			$sql_sum_cc1_cc3 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 = '$id_cc4' $filtro $ebitda");
			$dados_sum_cc1_cc3 = mysql_fetch_array($sql_sum_cc1_cc3);
			$total_cc1_cc3 = number_format($dados_sum_cc1_cc3["total_cc1"],2,",",".");
			$valor_test2 = $dados_sum_cc1_cc3["total_cc1"];
			if($valor_test2 !=0&&$valor_test !=0){
				$p_total_cc1_cc3 = number_format((($valor_test2/$valor_test)*100),2,",",".");
			} else {
				$p_total_cc1_cc3 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc3</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$p_total_cc1_cc3</font></b></td>
		</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$sql_sum_cc1_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' AND cc4 NOT IN (select cc4 from cc4) $filtro $ebitda");
			$dados_sum_cc1_cc4 = mysql_fetch_array($sql_sum_cc1_cc4);
			$total_cc1_cc4 = number_format($dados_sum_cc1_cc4["total_cc1"],2,",",".");
			if($dados_sum_cc1_cc4["total_cc1"] != 0){
				$percent_total_cc1_cc4 = number_format((($dados_sum_cc1_cc4["total_cc1"]/$dados_sum_cc1["total_cc1"])*100),2,",",".");
			} else {
				$percent_total_cc1_cc4 = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1_cc4</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$percent_total_cc1_cc4</font></b></td>
		</tr>";
			//RECEITA BRUTA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado de Financiamentos (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
					
						//PEGA O FINANCIAMENTO +
						$sql_rfin = mysql_query("SELECT SUM(valor_pagto) as total_rfin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 25 $filtro $ebitda");
						$sum_rfin = mysql_fetch_array($sql_rfin);
						//PEGA O FINANCIAMENTO -
						$sql_fin = mysql_query("SELECT SUM(valor_pagto) as total_fin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 19 $filtro $ebitda");
						$sum_fin = mysql_fetch_array($sql_fin);
						
						$resultado_fin1 = $sum_rfin["total_rfin"] - $sum_fin["total_fin"];
						$resultado_fin = number_format($resultado_fin1,2,",",".");
						
						
						
						if($resultado_fin1!=0){
							$percent_fin = number_format((($resultado_fin1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_fin = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_fin</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_fin</b></td>";
						
							
					}
					
					//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
					
						//PEGA O FINANCIAMENTO +
						$sql_rfin = mysql_query("SELECT SUM(valor_pagto) as total_rfin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND cc3 = 25 $filtro $ebitda");
						$sum_rfin = mysql_fetch_array($sql_rfin);
						//PEGA O FINANCIAMENTO -
						$sql_fin = mysql_query("SELECT SUM(valor_pagto) as total_fin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 where relatorio = 1) AND cc3 = 19 $filtro $ebitda");
						$sum_fin = mysql_fetch_array($sql_fin);
						
						$resultado_fin1 = $sum_rfin["total_rfin"] - $sum_fin["total_fin"];
						$resultado_fin = number_format($resultado_fin1,2,",",".");
						
						
						
						if($resultado_fin1!=0){
							$percent_fin = number_format((($resultado_fin1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_fin = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_fin</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_fin</b></td>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";


//sexta parte

}	//PEGA O CC3 CUSTOS

		//RECEITA BRUTA
				$contador_cc3 = 1;
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado Financeiro (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE relatorio = 1 AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						
						//PEGA AS DESPESAS
						$sql_cc2_desp = mysql_query("SELECT SUM(valor_pagto) as total_cc2_despesas FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 15) $filtro $ebitda");
						$sum_despesas = mysql_fetch_array($sql_cc2_desp);
						$resultado_ebitda1 = $resultado_bruto1 - $sum_despesas["total_cc2_despesas"];
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
						$resultado_invest1 = $sum_rinvest["total_rinvest"] - $sum_invest["total_invest"];
						
					
						//PEGA O FINANCIAMENTO +
						$sql_rfin = mysql_query("SELECT SUM(valor_pagto) as total_rfin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 25 $filtro $ebitda");
						$sum_rfin = mysql_fetch_array($sql_rfin);
						//PEGA O FINANCIAMENTO -
						$sql_fin = mysql_query("SELECT SUM(valor_pagto) as total_fin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 19 $filtro $ebitda");
						$sum_fin = mysql_fetch_array($sql_fin);
						$resultado_fin1 = $sum_rfin["total_rfin"] - $sum_fin["total_fin"];

						
						//GERA O RESULTADO FINANCEIRO
						$resultado_financeiro1 = $resultado_ebitda1 + $resultado_invest1 +$resultado_fin1;
						$resultado_financeiro = number_format($resultado_financeiro1,2,",",".");
						
						if($resultado_financeiro1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_financeiro = number_format((($resultado_financeiro1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_financeiro = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_financeiro</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_financeiro</b></td>";
						
							
					}
					
					//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						
						//PEGA AS DESPESAS
						$sql_cc2_desp = mysql_query("SELECT SUM(valor_pagto) as total_cc2_despesas FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND (cc3 = 15) $filtro $ebitda");
						$sum_despesas = mysql_fetch_array($sql_cc2_desp);
						$resultado_ebitda1 = $resultado_bruto1 - $sum_despesas["total_cc2_despesas"];
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
						$resultado_invest1 = $sum_rinvest["total_rinvest"] - $sum_invest["total_invest"];
						
					
						//PEGA O FINANCIAMENTO +
						$sql_rfin = mysql_query("SELECT SUM(valor_pagto) as total_rfin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 25 $filtro $ebitda");
						$sum_rfin = mysql_fetch_array($sql_rfin);
						//PEGA O FINANCIAMENTO -
						$sql_fin = mysql_query("SELECT SUM(valor_pagto) as total_fin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (SELECT id_filial FROM cc2 WHERE relatorio = 1) AND cc3 = 19 $filtro $ebitda");
						$sum_fin = mysql_fetch_array($sql_fin);
						$resultado_fin1 = $sum_rfin["total_rfin"] - $sum_fin["total_fin"];

						
						//GERA O RESULTADO FINANCEIRO
						$resultado_financeiro1 = $resultado_ebitda1 + $resultado_invest1 +$resultado_fin1;
						$resultado_financeiro = number_format($resultado_financeiro1,2,",",".");
						
						if($resultado_financeiro1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_financeiro = number_format((($resultado_financeiro1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_financeiro = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_financeiro</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_financeiro</b></td>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr></tbody>";






	//final do IF




}//final consolidado








if($get_cc1 != ""&&$get_cc2 != ""&&$get_cc3 == ""&&$get_cc4 == ""&&$get_cc5 == ""&&$get_cc6 == ""&&$get_tiporel==2){
//FILTRO CC1 CONSOLIDADO
if($get_cc1 != ""&&$get_cc2 != ""&&$get_cc3 == ""&&$get_cc4 == ""&&$get_cc5 == ""&&$get_cc6 == ""&&$get_tiporel==2){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND data_pagto <> '' AND cc3 <> '90'  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
$count = mysql_num_rows($sql);


// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
	$cc1 = mysql_query("SELECT * FROM cc1 WHERE id_empresa = $get_cc1");
	$dados_cc1 = mysql_fetch_array($cc1);
	$nome_cc1 = ($dados_cc1["razao"]);
	$link_logo = $dados_cc1["logo"];
	//PEGA O CC2
	$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
	$contar_cc2 = (mysql_num_rows($sql_cc2)*2)+3;
	echo "<table align=\"center\" class=\"full_table_list\" width=\"auto\" border=\"1\">
	<tr style=\"font-size:12px;\">
	<td colspan=\"$contar_cc2\" valign=\"middle\"><div style=\"float:left; width:20%\"><img src=\"$link_logo\"></div> <div style=\"float:left; width:80%\" align=\"center\"><b>$nome_cc1<br> $exib_data_ini - $exib_data_fim</b></div></td>
	</tr><tr><td align=\"center\" class=\"table_tamanho1\" colspan=\"3\">RELAT&Oacute;RIO CONSOLIDADO</td>";
	
	
	//monta as linhas com nomes do cc3
	while($dados_cc2 = mysql_fetch_array($sql_cc2)){
		$id_cc2 = $dados_cc2["id_filial"];
		$titulo_cc2 = ($dados_cc2["nome_filial"]);
		echo "
		<td class=\"table_tamanho1\" bgcolor=\"#C0C0C0\" ><b>$titulo_cc2</b></td>
		<td class=\"table_tamanho1\" bgcolor=\"#C0C0C0\" align=\"center\"><b>%</b></td>
		";
	}
	echo "</tr>";
	
}
	//PEGA O CC3 receita ou deduções
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 21 OR id_cc3 = 30 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			if($dados_sum_cc2["total_cc2"] > 0){
				$exib = "100,00";
			} else {
				$exib = "0,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		echo "</tr>"; //fecha a linha e acrescenta o total da empresa //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($dados_sum_cc4["total_cc4"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			echo "</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//RECEITA LIQUIDA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Receita L&iacute;quida (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						if($receita_liquida1!=0){
							$percent_liquido = number_format((($receita_liquida1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_liquido = "0";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$receita_liquida</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_liquido</b></td>";
						
							
					}
					
					echo "</tr>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";
	}
	
//segunda parte
	
}
	//PEGA O CC3 CUSTOS
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 10 OR id_cc3 = 13 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			if($dados_sum_cc2["total_cc2"] > 0){
				$exib = "100,00";
			} else {
				$exib = "0,00";

			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		//PEGA VALORES CC1
			$sql_sum_cc1 = mysql_query("SELECT SUM(valor_pagto) as total_cc1 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 IN (select id_filial from cc2 WHERE relatorio =1) AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc1 = mysql_fetch_array($sql_sum_cc1);
			$total_cc1 = number_format($dados_sum_cc1["total_cc1"],2,",",".");
			if($dados_sum_cc1["total_cc1"] != 0){
				$exib = "100,00";
			} else {
				$exib = "0,00";
			}
		echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc1</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
		</tr>"; //fecha a linha e acrescenta o total da empresa //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($dados_sum_cc4["total_cc4"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			echo "</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//RECEITA BRUTA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado Bruto (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						$resultado_bruto = number_format($resultado_bruto1,2,",",".");
						
						if($resultado_bruto1!=0){
							$percent_bruto = number_format((($resultado_bruto1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_bruto = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_bruto</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_bruto</b></td>";
						
							
					}
					
					echo "</tr>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";
		

//terceira parte
	
}
	//PEGA O CC3 CUSTOS
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 15 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			if($dados_sum_cc2["total_cc2"] > 0){
				$exib = "100,00";
			} else {
				$exib = "0,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		echo "</tr>"; //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($dados_sum_cc4["total_cc4"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			echo "</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//RECEITA BRUTA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado Líquido - EBITDA (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						$receita_liquida = number_format($receita_liquida1,2,",",".");
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						$resultado_bruto = number_format($resultado_bruto1,2,",",".");
						
						
						//PEGA AS DESPESAS
						$sql_cc2_desp = mysql_query("SELECT SUM(valor_pagto) as total_cc2_despesas FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 15) $filtro $ebitda");
						$sum_despesas = mysql_fetch_array($sql_cc2_desp);
						$resultado_ebitda1 = $resultado_bruto1 - $sum_despesas["total_cc2_despesas"];
						$resultado_ebitda = number_format($resultado_ebitda1,2,",",".");
						
						
						if($resultado_ebitda1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_ebitda = number_format((($resultado_ebitda1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_ebitda = "100,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_ebitda</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_ebitda</b></td>";
						
							
					}
					
					echo "</tr>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";




//quarta parte
	
}
	//PEGA O CC3 CUSTOS
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 17 OR id_cc3 = 23 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		
		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			if($dados_sum_cc2["total_cc2"] > 0){
				$exib = "100,00";
			} else {
				$exib = "0,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		echo "</tr>"; //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($dados_sum_cc4["total_cc4"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			echo "</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//RECEITA BRUTA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado de Investimentos (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
						
						$resultado_invest1 = $sum_rinvest["total_rinvest"] - $sum_invest["total_invest"];
						$resultado_invest = number_format($resultado_invest1,2,",",".");
						
						
						
						if($resultado_invest1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_invest = number_format((($resultado_invest1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_invest = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_invest</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_invest</b></td>";
						
							
					}
					
					echo "</tr>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";
			
			


//quinta parte
	
}
	//PEGA O CC3 CUSTOS
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = 19 OR id_cc3 = 25 ORDER BY ordem");
	$contador_cc3 = mysql_num_rows($sql_cc3);
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$tipo_cc3 = $dados_cc3["tipo"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		if($tipo_cc3 == "+"){
			$tipo_cor = "blue";
		} else {
			$tipo_cor = "red";
		}
		echo "
			<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\"><b>$id_cc3</b></td>
			<td class=\"table_tamanho2\" colspan=\"2\" bgcolor=\"#EAEAEA\"><b>$titulo_cc3</b></td>"; //abre a linha
		

		
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
		//monta as linhas com nomes do cc3
		while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
			$id_cc2 = $dados_cc2["id_filial"];
			$filtro = "AND (data_pagto BETWEEN '$inicio' AND '$fim')";
			//PEGA VALORES CC2 e cc3
			$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
			$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
			$total_cc2 = number_format($dados_sum_cc2["total_cc2"],2,",",".");
			if($dados_sum_cc2["total_cc2"] > 0){
				$exib = "100,00";
			} else {
				$exib = "0,00";
			}
			echo "<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"right\"><b><font color=\"$tipo_cor\">$tipo_cc3 $total_cc2</font></b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#EAEAEA\" align=\"center\"><b><font color=\"$tipo_cor\">$exib</font></b></td>
			";
		}
		echo "</tr>"; //fecha a linha
		
		//pega dados cc4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' ORDER BY nome_cc4"); 
		while($dados_cc4 = mysql_fetch_array($sql_cc4)){
			$id_cc4 = $dados_cc4["cc4"];
			$titulo_cc4 = ($dados_cc4["nome_cc4"]);
			echo "
				<tr>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc3</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$id_cc4</b></td>
				<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>$titulo_cc4</b></td>"; //abre a linha
			
			
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				//PEGA VALORES CC2 - cc4
				$sql_sum_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3'  AND cc4 = '$id_cc4' $filtro $ebitda");
				$dados_sum_cc4 = mysql_fetch_array($sql_sum_cc4);
				$total_cc4 = number_format($dados_sum_cc4["total_cc4"],2,",",".");
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($dados_sum_cc4["total_cc4"] !=0){
					$percent_total_cc4 = number_format((($dados_sum_cc4["total_cc4"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$percent_total_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$percent_total_cc4</font></td>
				";
				
				
			}
			echo "</tr>"; //fecha a linha
			//PEGA VALORES QUE NÃO ESTÃO NO CC4 SE TIVER
			
		}
			echo "<tr>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>00</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>0000</b></td>
			<td class=\"table_tamanho1\" bgcolor=\"#FFFFFF\"><b>Indefinidos</b></td>	";
			$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
			//monta as linhas com nomes do cc3
			 
			while($dados_cc2 = mysql_fetch_array($sql_cc2)){ //gera as colunas das filiais
				$id_cc2 = $dados_cc2["id_filial"];
				$sql_sum_not_cc4 = mysql_query("SELECT SUM(valor_pagto) as total_cc4_not FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro  AND cc4 NOT IN (select cc4 from cc4) $ebitda");
				$sum_not_cc4 = mysql_fetch_array($sql_sum_not_cc4);
				$total_not_cc4 = number_format($sum_not_cc4["total_cc4_not"],2,",",".");
				
				//pega porcentagem
				$sql_sum_cc2 = mysql_query("SELECT SUM(valor_pagto) as total_cc2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2' AND cc3 = '$id_cc3' $filtro $ebitda");
				$dados_sum_cc2 = mysql_fetch_array($sql_sum_cc2);
				if($sum_not_cc4["total_cc4_not"] >0){
				$p_total_not_cc4 = number_format((($sum_not_cc4["total_cc4_not"]/$dados_sum_cc2["total_cc2"])*100),2,",",".");
				} else {
					$p_total_not_cc4 = "0,00";
				}
				echo "<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$tipo_cc3 $total_not_cc4</font></td>
				<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFFFF\"><font color=\"$tipo_cor\">$p_total_not_cc4</font></td>
				";
					
			}
			//RECEITA BRUTA
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado de Financiamentos (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
					
						//PEGA O FINANCIAMENTO +
						$sql_rfin = mysql_query("SELECT SUM(valor_pagto) as total_rfin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 25 $filtro $ebitda");
						$sum_rfin = mysql_fetch_array($sql_rfin);
						//PEGA O FINANCIAMENTO -
						$sql_fin = mysql_query("SELECT SUM(valor_pagto) as total_fin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 19 $filtro $ebitda");
						$sum_fin = mysql_fetch_array($sql_fin);
						
						$resultado_fin1 = $sum_rfin["total_rfin"] - $sum_fin["total_fin"];
						$resultado_fin = number_format($resultado_fin1,2,",",".");
						
						
						
						if($resultado_fin1!=0){
							$percent_fin = number_format((($resultado_fin1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_fin = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_fin</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_fin</b></td>";
						
							
					}
					
					echo "</tr>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";


//sexta parte

}	//PEGA O CC3 CUSTOS

		//RECEITA BRUTA
				$contador_cc3 = 1;
				if($contador_cc3 ==1){
					$receita_liquida1 = 0;
					echo "<tr><td class=\"table_tamanho2\" colspan=\"3\" bgcolor=\"#FFFF00\"><b>Resultado Financeiro (R$)</b></td>
					";
					$sql_cc2_liq = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_cc2' AND empresa = $get_cc1 ORDER BY id_filial");
					//monta o resultado liquido
					while($dados_cc2_liq = mysql_fetch_array($sql_cc2_liq)){ //gera as colunas das filiais
						$id_cc2_liq = $dados_cc2_liq["id_filial"];
						
						//PEGA A RECEITA BRUTA
						$sql_reccc2_liq = mysql_query("SELECT SUM(valor_pagto) as total_cc2_rec FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 21 $filtro $ebitda");
						$rec_sum_cc2_liq = mysql_fetch_array($sql_reccc2_liq);
						
						//PEGA AS DEDUÇÕES
						$sql_cc2_ded = mysql_query("SELECT SUM(valor_pagto) as total_cc2_ded FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 30 $filtro $ebitda");
						$ded_sum_cc2 = mysql_fetch_array($sql_cc2_ded);
						$receita_liquida1 = $rec_sum_cc2_liq["total_cc2_rec"] - $ded_sum_cc2["total_cc2_ded"];
						
						//PEGA OS CUSTOS
						$sql_cc2_custos = mysql_query("SELECT SUM(valor_pagto) as total_cc2_custos FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 10 OR cc3 = 13) $filtro $ebitda");
						$sum_custos = mysql_fetch_array($sql_cc2_custos);
						$resultado_bruto1 = $receita_liquida1 - $sum_custos["total_cc2_custos"];
						
						//PEGA AS DESPESAS
						$sql_cc2_desp = mysql_query("SELECT SUM(valor_pagto) as total_cc2_despesas FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND (cc3 = 15) $filtro $ebitda");
						$sum_despesas = mysql_fetch_array($sql_cc2_desp);
						$resultado_ebitda1 = $resultado_bruto1 - $sum_despesas["total_cc2_despesas"];
						
						//PEGA O INVESTIMENTO +
						$sql_rinvest = mysql_query("SELECT SUM(valor_pagto) as total_rinvest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 23 $filtro $ebitda");
						$sum_rinvest = mysql_fetch_array($sql_rinvest);
						//PEGA O INVESTIMENTO -
						$sql_invest = mysql_query("SELECT SUM(valor_pagto) as total_invest FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 17 $filtro $ebitda");
						$sum_invest = mysql_fetch_array($sql_invest);
						$resultado_invest1 = $sum_rinvest["total_rinvest"] - $sum_invest["total_invest"];
						
					
						//PEGA O FINANCIAMENTO +
						$sql_rfin = mysql_query("SELECT SUM(valor_pagto) as total_rfin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 25 $filtro $ebitda");
						$sum_rfin = mysql_fetch_array($sql_rfin);
						//PEGA O FINANCIAMENTO -
						$sql_fin = mysql_query("SELECT SUM(valor_pagto) as total_fin FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$id_cc2_liq' AND cc3 = 19 $filtro $ebitda");
						$sum_fin = mysql_fetch_array($sql_fin);
						$resultado_fin1 = $sum_rfin["total_rfin"] - $sum_fin["total_fin"];

						
						//GERA O RESULTADO FINANCEIRO
						$resultado_financeiro1 = $resultado_ebitda1 + $resultado_invest1 +$resultado_fin1;
						$resultado_financeiro = number_format($resultado_financeiro1,2,",",".");
						
						if($resultado_financeiro1!=0&&$rec_sum_cc2_liq["total_cc2_rec"]!=0){
							$percent_financeiro = number_format((($resultado_financeiro1/$rec_sum_cc2_liq["total_cc2_rec"])*100),2,",",".");
						} else {
							$percent_financeiro = "0,00";
						}
						echo "
							<td class=\"table_tamanho1\" align=\"right\" bgcolor=\"#FFFF00\"><b>$resultado_financeiro</b></td>
							<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#FFFF00\"><b>$percent_financeiro</b></td>";
						
							
					}
					
					echo "</tr>";
					$contador_cc3 -=1;
				} else {
					$contador_cc3 -=1;
				}
			echo "</tr>
			<tr><td colspan=\"$contar_cc2\" bgcolor=\"#FFFFFF\" style=\"line-height:5px;height:5px;\"></td></tr>";






	//final do IF




}//final consolidado cc2













//FILTRO CC1 GERENCIAL
if($get_cc1 != ""&&$get_cc2 == ""&&$get_cc3 == ""&&$get_cc4 == ""&&$get_cc5 == ""&&$get_cc6 == ""&&$get_tiporel==1){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND data_pagto <> '' AND cc3 <> '90'  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
$count = mysql_num_rows($sql);


// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
	$cc1 = mysql_query("SELECT * FROM cc1 WHERE id_empresa = $get_cc1");
	$dados_cc1 = mysql_fetch_array($cc1);
	$nome_cc1 = ($dados_cc1["razao"]);
	$link_logo = $dados_cc1["logo"];
	echo "<table align=\"center\" class=\"full_table_custo\" width=\"auto\" border=\"1\">
	<tr style=\"font-size:12px;\">
	<td colspan=\"13\" valign=\"middle\"><img src=\"$link_logo\"> <b>$nome_cc1<br><center> $exib_data_ini - $exib_data_fim</center></b></td>
	</tr>";
	
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 <> '90' ORDER BY ordem");
	//monta as linhas com nomes do cc3
	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		$tipo_cc3 = ($dados_cc3["tipo"]);
		//SELECT DADOS = CC1
		//SOMATÓRIO TOTAL
		$sql_cc1_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc3 <> '90'  AND cc3 = '$id_cc3' AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		$dados_sum_cc1 = mysql_fetch_array($sql_cc1_sum);
		$total = number_format($dados_sum_cc1["total"], 2, ',', '.');
		echo "<tr>
		<td bgcolor=\"#E9E9E9\">----</td>
		<td bgcolor=\"#E9E9E9\" colspan=\"4\"><font size=\"+1\"><b>$titulo_cc3</b></font></td>
		<td bgcolor=\"#E9E9E9\" align=\"right\"><font size=\"+1\">$tipo_cc3 R$ $total</font></td>
		</tr>";
		
		
		
	
		
		//verifica se possui resultado
		if($get_layout == 1){ //verifica o tipo do relatório (ANALITICO)
		$sql_cc1 = mysql_query("SELECT * FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc3 = '$id_cc3' AND cc3 <> '90'  AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		$contar = mysql_num_rows($sql_cc1);
		if($contar >=1){
			echo "<tr>
			<td bgcolor=\"#D6D6D6\">----</td>
			<td bgcolor=\"#D6D6D6\"><center>----</center></td>
			<td bgcolor=\"#D6D6D6\"><center>----</center></td>
			<td bgcolor=\"#D6D6D6\"><center>Unidade</center></td>
			<td bgcolor=\"#D6D6D6\"><center><b>Cliente / Fornecedor</b></center></td>
			<td bgcolor=\"#D6D6D6\"><center><b>Data</b></center></td>
			<td bgcolor=\"#D6D6D6\"><center><b>Valor</b></center></td>
			</tr>";
		}
		while($d_tit1 = mysql_fetch_array($sql_cc1)){
			$id_titulo          = $d_tit1["id_titulo"];
			$id_cliente			 = $d_tit1["cliente_fornecedor"];
			$vencimento			 = $d_tit1["vencimento"];
			$valor			 = number_format($d_tit1["valor"], 2, ',', '.');
			$datapagt			 = $d_tit1["data_pagto"];
			$valor_pagto			 = number_format($d_tit1["valor_pagto"], 2, ',', '.');
			$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
			$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
			$b_cc1			 = $d_tit1["cc1"];
			$b_cc2			 = $d_tit1["cc2"];
			$b_cc3			 = $d_tit1["cc3"];
			$b_cc4			 = $d_tit1["cc4"];
			$b_cc5			 = $d_tit1["cc5"];
			$b_cc6			 = $d_tit1["cc6"];
			$conta			 = $d_tit1["conta"];
			$id_custo			 = $d_tit1["id_custo"];
			$tipo			 = $d_tit1["tipo"];
			//nome do cliente
			$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = '$id_cliente'");
			$total = mysql_num_rows($sql_cliente);
			if($total >= 1){
				$d_cliente = mysql_fetch_array($sql_cliente);
				$nome_cliente = substr(($d_cliente["nome"]),0,20);
			} else {
				$sql_cliente = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = '$id_cliente'");
				$d_cliente = mysql_fetch_array($sql_cliente);
				$nome_cliente = substr(($d_cliente["nome"]),0,20);
			}
			$sql_cc2_n = mysql_query("SELECT * FROM cc2 WHERE id_filial = '$b_cc2'");
			$d_cc2_n = mysql_fetch_array($sql_cc2_n);
			$nome_cc2_n = ($d_cc2_n["nome_filial"]);
			if(trim($nome_cc2_n) == ""){
				$nome_cc2_n = "----";
			}
			echo "<tr>
			<td bgcolor=\"#FFE4C4\">----</td>
			<td bgcolor=\"#FFE4C4\"><center>----</center></td>
			<td bgcolor=\"#FFE4C4\"><center>----</center></td>
			<td bgcolor=\"#FFE4C4\">$nome_cc2_n</td>
			<td bgcolor=\"#FFE4C4\"><b><a rel=\"shadowbox\" href=\"editar_ccusto.php?id=$id_titulo&id2=$id_custo\">$nome_cliente</a></b></td>
			<td bgcolor=\"#FFE4C4\"><center>$pagamento</center></td>
			<td bgcolor=\"#FFE4C4\" align=\"right\">R$ $valor_pagto</td>
			
			</tr>
			";
		}//final do WHILE d_tit1
		}
	}//final do WHILE DADOS CC3
	//despesa
	$sql_sum_despesa = mysql_query("SELECT SUM( valor_pagto ) as total2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc3 <> '90' AND cc5 <> '200' AND cc5 <> '300'  AND tipo = 1  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
	$dados_sum_despesa = mysql_fetch_array($sql_sum_despesa);
	$total_despesa = number_format($dados_sum_despesa["total2"], 2, ',', '.');
	//receita
	$sql_sum_receita = mysql_query("SELECT SUM( valor_pagto ) as total2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc3 <> '90' AND cc4 <> '2120' AND data_pagto <> '' AND cc5 <> '200' AND cc5 <> '300' AND (tipo = 2 OR tipo = 99)  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
	$dados_sum_receita = mysql_fetch_array($sql_sum_receita);
	$total_receita= number_format($dados_sum_receita["total2"], 2, ',', '.');
	$resultado_financeiro =number_format($dados_sum_receita["total2"] - $dados_sum_despesa["total2"], 2, ',', '.');
	$resultado_financeiro2 =$dados_sum_receita["total2"] - $dados_sum_despesa["total2"];
	$resultado_ebitda = number_format(($resultado_financeiro2 / $dados_sum_receita["total2"])*100, 2, ',', '.');
	
	
	echo "<tr>
		<td colspan=\"8\" align=\"right\"><font color=\"red\"><b>Despesa:</b> R$ $total_despesa</font></b></td>
		
	</tr>
	<tr>
		<td colspan=\"8\" align=\"right\"><font color=\"blue\"><b>Receita: R$ $total_receita</font></b></td>
	</tr>
	<tr>
		<td colspan=\"7\" align=\"right\"><b>Saldo Financeiro Final: R$ $resultado_financeiro</b> </td>
		<td align=\"center\">$resultado_ebitda %</td>
	</tr>";
	}//final do ELSE
	

}//final do IF







//FILTRO CC2
if($get_cc1 != ""&&$get_cc2 != ""&&$get_cc3 == ""&&$get_cc4 == ""&&$get_cc5 == ""&&$get_cc6 == ""&&$get_tiporel==1){
$sql = mysql_query("SELECT * FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND data_pagto <> '' AND cc2 = '$get_cc2' AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
$count = mysql_num_rows($sql);


// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
	$cc1 = mysql_query("SELECT * FROM cc1 WHERE id_empresa = $get_cc1");
	$dados_cc1 = mysql_fetch_array($cc1);
	$nome_cc1 = ($dados_cc1["razao"]);
	$link_logo = $dados_cc1["logo"];
	
	$cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial = '$get_cc2'");
	$dados_cc2 = mysql_fetch_array($cc2);
	$nome_cc2 = ($dados_cc2["nome_filial"]);
	echo "<table align=\"center\" class=\"full_table_custo\" width=\"auto\" border=\"1\">
	<tr style=\"font-size:12px;\">
	<td colspan=\"7\" valign=\"middle\"><img src=\"$link_logo\"> <b>$nome_cc1 <br><center> $exib_data_ini - $exib_data_fim</center></b></td>
	<td><b>Filial:<br> <font size=\"-2\">$nome_cc2</font></b></td>
	</tr>";
	
	$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 <> '90' ORDER BY ordem");
	//monta as linhas com nomes do cc3

	while($dados_cc3 = mysql_fetch_array($sql_cc3)){
		$id_cc3 = $dados_cc3["id_cc3"];
		$titulo_cc3 = ($dados_cc3["nome_cc3"]);
		$tipo_cc3 = ($dados_cc3["tipo"]);
		//SELECT DADOS = CC1
		//SOMATÓRIO TOTAL patryky
		$sql_cc1_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$get_cc2' AND cc3 <> '90' AND cc3 = '$id_cc3' AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		$dados_sum_cc1 = mysql_fetch_array($sql_cc1_sum);
		$total = number_format($dados_sum_cc1["total"], 2, ',', '.');
		echo "<tr>
		<td bgcolor=\"#BEBEBE\">----</td>
		<td bgcolor=\"#BEBEBE\" colspan=\"6\"><font size=\"+1\"><b>$titulo_cc3</b></font></td>
		<td bgcolor=\"#BEBEBE\" align=\"right\"><font size=\"+1\">$tipo_cc3 R$ $total</font></td>
		</tr>";

			
		
	$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$id_cc3%' AND cc4 NOT LIKE '90%' ORDER BY nome_cc4");
	//monta as linhas com nomes do cc4
	$contar_cc4 = mysql_num_rows($sql_cc4);
	while($dados_cc4 = mysql_fetch_array($sql_cc4)){
		$id_cc4 = $dados_cc4["cc4"];
		$titulo_cc4 = ($dados_cc4["nome_cc4"]);
		//SELECT DADOS = CC1
		//SOMATÓRIO TOTAL 
		$sql_cc4_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$get_cc2' AND cc3 <> '90' AND cc3 = '$id_cc3' AND cc4 = '$id_cc4' AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		$dados_sum_cc4 = mysql_fetch_array($sql_cc4_sum);
		$total4 = number_format($dados_sum_cc4["total"], 2, ',', '.');
		$percent_total = 0;
		$total5 = $dados_sum_cc4["total"];
		
		//GERA % DE VALORES
		$sql_cc1_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$get_cc2' AND cc3 <> '90' AND cc3 = '$id_cc3' AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		$dados_sum_cc1 = mysql_fetch_array($sql_cc1_sum);
		if($dados_sum_cc1["total"] > 0){	
			$percent_total = number_format(($total5/$dados_sum_cc1["total"]*100), 2, ',', '.');
		} else {
			$percent_total = 0;
		}
		if($total4 > 0){
			
			echo "<tr>
			<td bgcolor=\"#F5F5F5\">----</td>
			<td bgcolor=\"#F5F5F5\">----</td>
			<td bgcolor=\"#F5F5F5\" colspan=\"4\"><b>$titulo_cc4</b></td>
			<td bgcolor=\"#F5F5F5\" align=\"right\">$tipo_cc3 R$ $total4</td>
			<td bgcolor=\"#F5F5F5\" align=\"center\">$percent_total %</td>
			</tr>";
		}
		
		
		
	if($get_layout == 2){
	//DADOS CC5 
	$sql_cc5 = mysql_query("SELECT * FROM cc5 WHERE id_cc5 LIKE '$id_cc4' ORDER BY nome_cc5");
	//monta as linhas com nomes do cc5
	while($dados_cc5 = mysql_fetch_array($sql_cc5)){
		$id_cc5 = $dados_cc5["cc5"];
		$titulo_cc5 = ($dados_cc5["nome_cc5"]);
		
		//SOMATÓRIO TOTAL  cc5
		$sql_cc5_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$get_cc2' AND cc3 <> '90' AND cc3 = '$id_cc3' AND cc4 = '$id_cc4' AND cc5 LIKE '$id_cc5' AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		$dados_sum_cc5 = mysql_fetch_array($sql_cc5_sum);
		$total_cc5 = number_format($dados_sum_cc5["total"], 2, ',', '.');
		
		
		
		if($dados_sum_cc5["total"] > 0){
			//% total cc5
			$percent_total_cc5 = number_format((($dados_sum_cc5["total"]/$total5)*100),2,',','.');
			echo "<tr>
			<td>----</td>
			<td >----</td>
			<td>----</td>
			<td colspan=\"3\"><font size=\"-2\"><b>$titulo_cc5</b></font></td>
			<td align=\"right\"><font size=\"-2\">$tipo_cc3 R$ $total_cc5</font></td>
			<td align=\"center\"><font size=\"-2\">$percent_total_cc5 %</font></td>
			</tr>";
		}
		} // fecha while
		
	}
		
		
		if($get_layout == 1){ //verifica o tipo do relatório
		//verifica se possui resultado
		$sql_cc1 = mysql_query("SELECT * FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc3 = '$id_cc3'  AND cc2 = '$get_cc2' AND cc4 = '$id_cc4' AND cc3 <> '90'  AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda ORDER BY cc5");
		$contar = mysql_num_rows($sql_cc1);
		if($contar >=1){
			echo "<tr>
			<td bgcolor=\"#D6D6D6\"><center>----</center></td>
			<td bgcolor=\"#D6D6D6\"><center>----</center></td>
			<td bgcolor=\"#D6D6D6\"><center>----</center></td>
			<td bgcolor=\"#D6D6D6\"><b>Cliente / Fornecedor</b></td>
			<td bgcolor=\"#D6D6D6\"><b>Descrição</b></td>
			<td bgcolor=\"#D6D6D6\"><b>Data</b></td>
			<td bgcolor=\"#D6D6D6\"><b>Valor</b></td>
			<td bgcolor=\"#D6D6D6\"><b>CC5</b></td>
			</tr>";
		}
		while($d_tit1 = mysql_fetch_array($sql_cc1)){
			$id_titulo          = $d_tit1["id_titulo"];
			$id_cliente			 = $d_tit1["cliente_fornecedor"];
			$vencimento			 = $d_tit1["vencimento"];
			$valor			 = number_format($d_tit1["valor"], 2, ',', '.');
			$datapagt			 = $d_tit1["data_pagto"];
			$valor_pagto			 = number_format($d_tit1["valor_pagto"], 2, ',', '.');
			$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
			$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
			$b_cc1			 = $d_tit1["cc1"];
			$descricao			 = utf8_decode((substr($d_tit1["descricao"],0,20)));
			$b_cc2			 = $d_tit1["cc2"];
			$b_cc3			 = $d_tit1["cc3"];
			$b_cc4			 = $d_tit1["cc4"];
			$b_cc5			 = $d_tit1["cc5"];
			$b_cc6			 = $d_tit1["cc6"];
			$conta			 = $d_tit1["conta"];
			$id_custo			 = $d_tit1["id_custo"];
			$tipo			 = $d_tit1["tipo"];
			//nome do cliente
			$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = '$id_cliente'");
			$total = mysql_num_rows($sql_cliente);
			if($total >= 1){
				$d_cliente = mysql_fetch_array($sql_cliente);
				$nome_cliente = substr(($d_cliente["nome"]),0,20);
			} else {
				$sql_cliente = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = '$id_cliente'");
				$d_cliente = mysql_fetch_array($sql_cliente);
				$nome_cliente = substr(($d_cliente["nome"]),0,20);
			}
			//BUSCA NOME CC5
			$sql_cc5 = mysql_query("SELECT * FROM cc5 WHERE cc5 = '$b_cc5' AND id_cc5 = '$b_cc4'");
			$d_cc5 = mysql_fetch_array($sql_cc5);
			$nome_cc5 = ($d_cc5["nome_cc5"]);
			if(trim($nome_cc5) == ""){
				$nome_cc5 = "----";
			}
			echo "<tr>
			<td bgcolor=\"#FFE4C4\">----</td>
			<td bgcolor=\"#FFE4C4\"><center>----</center></td>
			<td bgcolor=\"#FFE4C4\"><center>----</center></td>
			<td bgcolor=\"#FFE4C4\"><a  rel=\"shadowbox\"  href=\"editar_ccusto.php?id=$id_titulo&id2=$id_custo\"><b>$nome_cliente...</b></a></td>
			<td bgcolor=\"#FFE4C4\">$descricao</td>
			<td bgcolor=\"#FFE4C4\"><center>$pagamento</center></td>
			<td bgcolor=\"#FFE4C4\" align=\"right\">R$ $valor_pagto</td>
			<td bgcolor=\"#FFE4C4\" align=\"right\">$nome_cc5</td>
			</tr>
			";
		}//final do WHILE d_tit1
		
		}//verifica se é sintético
		$contar_cc4 -=1;
		if($contar_cc4 == 0){
			//SOMATÓRIO TOTAL 
		$sql_cc4_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$get_cc2' AND cc3 <> '90' AND cc3 = '$id_cc3' AND cc4 NOT IN (select cc4 from cc4) AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		$dados_sum_cc4 = mysql_fetch_array($sql_cc4_sum);
		$total4 = number_format($dados_sum_cc4["total"], 2, ',', '.');
		$percent_total = 0;
		$total5 = $dados_sum_cc4["total"];
		if($dados_sum_cc1["total"] > 0){	
			$percent_total = number_format(($total5/$dados_sum_cc1["total"]*100), 2, ',', '.');
		} else {
			$percent_total = 0;
		}
		//GERA % DE VALORES
		$sql_cc1_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$get_cc2' AND cc3 <> '90' AND cc3 = '$id_cc3' AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		$dados_sum_cc1 = mysql_fetch_array($sql_cc1_sum);
			echo "<tr>
			<td bgcolor=\"#F5F5F5\">----</td>
			<td bgcolor=\"#F5F5F5\">----</td>
			<td bgcolor=\"#F5F5F5\" colspan=\"4\"><b>Indefinidos</b></td>
			<td bgcolor=\"#F5F5F5\" align=\"right\">$tipo_cc3 R$ $total4</td>
			<td bgcolor=\"#F5F5F5\" align=\"center\">$percent_total %</td>
			</tr>";
		if($get_layout ==1){
		$sql_cc1_indef = mysql_query("SELECT * FROM view_tit_ccusto WHERE cc1 = '$get_cc1' AND cc2 = '$get_cc2' AND cc3 <> '90' AND cc3 = '$id_cc3' AND cc4 NOT IN (select cc4 from cc4) AND data_pagto <> ''  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
		while($d_tit1 = mysql_fetch_array($sql_cc1_indef)){
			$id_titulo          = $d_tit1["id_titulo"];
			$id_cliente			 = $d_tit1["cliente_fornecedor"];
			$vencimento			 = $d_tit1["vencimento"];
			$valor			 = number_format($d_tit1["valor"], 2, ',', '.');
			$datapagt			 = $d_tit1["data_pagto"];
			$valor_pagto			 = number_format($d_tit1["valor_pagto"], 2, ',', '.');
			$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
			$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
			$b_cc1			 = $d_tit1["cc1"];
			$descricao			 = utf8_decode((substr($d_tit1["descricao"],0,20)));
			$b_cc2			 = $d_tit1["cc2"];
			$b_cc3			 = $d_tit1["cc3"];
			$b_cc4			 = $d_tit1["cc4"];
			$b_cc5			 = $d_tit1["cc5"];
			$b_cc6			 = $d_tit1["cc6"];
			$conta			 = $d_tit1["conta"];
			$id_custo			 = $d_tit1["id_custo"];
			$tipo			 = $d_tit1["tipo"];
			//nome do cliente
			$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = '$id_cliente'");
			$total = mysql_num_rows($sql_cliente);
			if($total >= 1){
				$d_cliente = mysql_fetch_array($sql_cliente);
				$nome_cliente = substr(($d_cliente["nome"]),0,20);
			} else {
				$sql_cliente = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = '$id_cliente'");
				$d_cliente = mysql_fetch_array($sql_cliente);
				$nome_cliente = substr(($d_cliente["nome"]),0,20);
			}
			//BUSCA NOME CC5
			$sql_cc5 = mysql_query("SELECT * FROM cc5 WHERE cc5 = '$b_cc5' AND id_cc5 = '$b_cc4'");
			$d_cc5 = mysql_fetch_array($sql_cc5);
			$nome_cc5 = ($d_cc5["nome_cc5"]);
			if(trim($nome_cc5) == ""){
				$nome_cc5 = "----";
			}
			echo "<tr>
			<td bgcolor=\"#FFE4C4\">----</td>
			<td bgcolor=\"#FFE4C4\"><center>----</center></td>
			<td bgcolor=\"#FFE4C4\"><center>----</center></td>
			<td bgcolor=\"#FFE4C4\"><a  rel=\"shadowbox\"  href=\"editar_ccusto.php?id=$id_titulo&id2=$id_custo\"><b>$nome_cliente...</b></a></td>
			<td bgcolor=\"#FFE4C4\">$descricao</td>
			<td bgcolor=\"#FFE4C4\"><center>$pagamento</center></td>
			<td bgcolor=\"#FFE4C4\" align=\"right\">R$ $valor_pagto</td>
			<td bgcolor=\"#FFE4C4\" align=\"right\">$nome_cc5</td>
			</tr>
			";
		}	
			
		}//layout indefinidos
			
			
		}
	}//final do WHILE DADOS CC4
	echo "<tr style=\"line-height: 5px; height:5px\" rowspan=\"3\" ><td bordercolor=\"#FFFFFF\" style=\"line-height: 5px; height:5px\" colspan=\"8\" bgcolor=\"#FFFFFF\"><center> </center></td></tr>"; //separação de linhas
	}//final do WHILE DADOS CC3
	//despesa
	$sql_sum_despesa = mysql_query("SELECT SUM( valor_pagto ) as total2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1'  AND cc2 = '$get_cc2' AND cc3 <> '90' AND data_pagto <> '' AND tipo = 1 AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
	$dados_sum_despesa = mysql_fetch_array($sql_sum_despesa);
	$total_despesa = number_format($dados_sum_despesa["total2"], 2, ',', '.');
	//receita
	$sql_sum_receita = mysql_query("SELECT SUM( valor_pagto ) as total2 FROM view_tit_ccusto WHERE cc1 = '$get_cc1'  AND cc2 = '$get_cc2' AND  cc3 <> '90' AND data_pagto <> '' AND (tipo = 2 OR tipo = 99)  AND (data_pagto BETWEEN '$inicio' AND '$fim') $ebitda");
	$dados_sum_receita = mysql_fetch_array($sql_sum_receita);
	$total_receita= number_format($dados_sum_receita["total2"], 2, ',', '.');
	$resultado_financeiro =number_format($dados_sum_receita["total2"] - $dados_sum_despesa["total2"], 2, ',', '.');
	$resultado_financeiro2 =$dados_sum_receita["total2"] - $dados_sum_despesa["total2"];
	$resultado_ebitda = number_format(($resultado_financeiro2 / $dados_sum_receita["total2"])*100, 2, ',', '.');
	
	echo "<tr>
		<td colspan=\"8\" align=\"right\"><font color=\"red\"><b>Despesa:</b> R$ $total_despesa</font></b></td>
		
		
	</tr>
	<tr>
		<td colspan=\"8\" align=\"right\"><font color=\"blue\"><b>Receita: R$ $total_receita</font></b></td>
	</tr>
	<tr>
		<td colspan=\"7\" align=\"right\"><b>Saldo Financeiro Final: R$ $resultado_financeiro</b> </td>
		<td align=\"center\">$resultado_ebitda %</td>
	</tr>";
	}//final do ELSE
	

}//final do IF




?>


</table>                          </div>
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