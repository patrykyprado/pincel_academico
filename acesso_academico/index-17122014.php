<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
?> 
  <body>

  <section id="container" >
<?php
include ('includes/topo.php');
include ('includes/funcoes.php');
include ('includes/menu_lateral.php');


if($user_nivel == 90){
if(isset($_GET["id_turma"])){
	$get_id_turma = $_GET["id_turma"];
	$sql_get_turma = " AND ct.id_turma = '$get_id_turma'";
} else {
	$get_id_turma = "";
	$sql_get_turma = "";
}

$sql_turmas_user = mysql_query("SELECT ct.id_turma, ct.anograde, ct.grupo, ct.nivel, ct.tipo_etapa
FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON cta.id_turma = ct.id_turma
WHERE cta.matricula = $user_usuario $sql_get_turma
ORDER BY cta.anograde, ct.modulo DESC LIMIT 1");
if(mysql_num_rows($sql_turmas_user)>=1){
$dados_turmas_user = mysql_fetch_array($sql_turmas_user);
$user_turma_id_turma = $dados_turmas_user["id_turma"];
$user_turma_anograde = $dados_turmas_user["anograde"];
$user_turma_grupo = $dados_turmas_user["grupo"];
$user_turma_nivel = $dados_turmas_user["nivel"];
$user_tipo_etapa = $dados_turmas_user["tipo_etapa"];
} else {
	$user_turma_id_turma = "nada";
	$user_turma_anograde = "";
	$user_turma_grupo = "";
}

$sql_turma_dados =  mysql_query("SELECT * FROM ced_turma WHERE id_turma = '$user_turma_id_turma' ");
$total_turmas = mysql_num_rows($sql_turmas_user);

if(mysql_num_rows($sql_turma_dados)>=1){
	$dados_turma_aluno = mysql_fetch_array($sql_turma_dados);
	$aluno_unidade = trim($dados_turma_aluno["unidade"]);
	$aluno_modulo = trim($dados_turma_aluno["modulo"]);
} else {
	$aluno_unidade = "";
	$aluno_modulo = "";
}
?>
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row">              
              
                  <div class="col-lg-12">
                      <section class="panel">
                      <div class="panel-heading">
                      <b><a data-toggle="modal" id="abrir_modal" href="#aviso">Resumo Acadêmico</a></b>
                      
                      
                      
     <div align="left" style="font-size:10px;" class="task-option">               
                      <form action="index.php" method="GET" ><b>Turma Selecionada: </b><select style="width:auto; font-weight:bold;"name="id_turma" id="id_turma" onKeyPress="return arrumaEnter(this, event)">
<?php




$sql = "SELECT DISTINCT ct.cod_turma, ct.grupo, ct.nivel, ct.curso, ct.modulo, ct.unidade, ct.polo, ct.turno, ct.id_turma 
FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON ct.id_turma = cta.id_turma
WHERE cta.matricula = '$user_usuario' AND ct.id_turma NOT IN ('$user_turma_id_turma')";
$result = mysql_query($sql);
$sql_select = "SELECT DISTINCT ct.cod_turma, ct.grupo, ct.nivel, ct.curso, ct.modulo, ct.unidade, ct.polo, ct.turno, ct.id_turma 
FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON ct.id_turma = cta.id_turma
WHERE cta.matricula = '$user_usuario' AND cta.id_turma = $user_turma_id_turma
";
$result_select = mysql_query($sql_select);
while ($row2 = mysql_fetch_array($result_select)) {
    echo "<option selected='selected' value='" . ($row2['id_turma']) . "'>" .format_curso($row2['nivel']).": ".format_curso($row2['curso'])." M&oacute;d. ".$row2['modulo']." (Polo: ".$row2["polo"]." - ".$row2['grupo'].")"."</option>";
}

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . ($row['id_turma']) . "'>" .format_curso($row['nivel']).": ".format_curso($row['curso'])." M&oacute;d. ".$row['modulo']." (Polo: ".$row["polo"]." - ".$row['grupo'].")</option>";
}
?>
      </select>
      <input type="submit" value="Ver" />
</form></div>
                      </div>
                          <div class="panel-body">
    <?php 
	
	$sql_etapa_atividades = mysql_query("SELECT cor_etapa, id_etapa, min_nota FROM ced_etapas WHERE tipo_etapa = '$user_tipo_etapa'");
	$sql_etapa_nome = mysql_query("SELECT cor_etapa, id_etapa, min_nota FROM ced_etapas WHERE tipo_etapa = '$user_tipo_etapa'");
	$sql_turma_disc = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma = $user_turma_id_turma ORDER BY inicio");
	echo "
	<table border=\"1\" width=\"100%\" style=\"font-size:11px; font-family:Arial, Helvetica, sans-serif; line-height:10px\">
	<tr>
	<td></td>
  	";
	
	//MONTA AS ETAPAS
	while($dados_etapa = mysql_fetch_array($sql_etapa_nome)){
		$etapa_nome = $dados_etapa["etapa"];
		$etapa_cor = $dados_etapa["cor_etapa"];
		echo "<td align=\"center\" bgcolor=\"$etapa_cor\" colspan=\"4\"><b>$etapa_nome</b></td>";
		
	}
	if(strtoupper($user_turma_nivel)=="ENSINO MEDIO"){
		$exibir_virtual_topo = "";
		$exibir_professor_topo = "";
	} else {
		$exibir_virtual_topo = "<td align=\"center\" bgcolor=\"#D5D5D5\"><b>--</b></td>";
		$exibir_professor_topo = "<td align=\"center\" bgcolor=\"#D5D5D5\"><b>Professor</b></td>";
		
	}
	
	echo "
	</tr>
    <tr>
		$exibir_virtual_topo
		<td align=\"center\" bgcolor=\"#D5D5D5\" width=\"30%\"><b>Componente Curricular / Disciplina</b></td>";
	while($dados_etapa = mysql_fetch_array($sql_etapa_atividades)){
		$etapa_cor = $dados_etapa["cor_etapa"];
		$sql_atividades = mysql_query("SELECT atividade FROM ced_desc_nota WHERE subgrupo LIKE 0 ORDER BY codigo");
		while($dados_atividades = mysql_fetch_array($sql_atividades)){
			$atividade = ($dados_atividades["atividade"]);	
			echo "<td align=\"center\" bgcolor=\"$etapa_cor\"><b>$atividade</b></td>";
		}
		echo"<td align=\"center\" bgcolor=\"$etapa_cor\"><b>Nota Parcial</b></td>
		";
	}
	echo "<td bgcolor=\"#EEEE0\" align=\"center\"><b>Faltas</b></td>
<td bgcolor=\"#EEEE0\" align=\"center\"><b>Nota Final</b></td>
$exibir_professor_topo
</tr>";
		while($dados_turma_disc = mysql_fetch_array($sql_turma_disc)){
			$nota_min_aprov = 0;
			$turma_disc = $dados_turma_disc["codigo"];
			$cod_disc = $dados_turma_disc["disciplina"];
			$cod_professor = $dados_turma_disc["cod_prof"];
			$ano_grade = $dados_turma_disc["ano_grade"];
			$sql_disciplina = mysql_query("SELECT disciplina FROM disciplinas WHERE cod_disciplina = '$cod_disc' AND anograde LIKE '$ano_grade'");
			$dados_disciplina = mysql_fetch_array($sql_disciplina);
			$disciplina = format_curso(($dados_disciplina["disciplina"]));
			$nota_final = 0;
			
			//pega dados do professor
			$sql_prof = mysql_query("SELECT nome FROM acessos_completos WHERE usuario = $cod_professor");
			$dados_prof = mysql_fetch_array($sql_prof);
			$nome_professor = format_curso($dados_prof["nome"]);
			
			if(strtoupper($user_turma_nivel)=="ENSINO MEDIO"){
				$link_disciplina = "href='ea_disciplina.php?turma_disc=$turma_disc&coddisc=$cod_disc&anograde=$ano_grade'";
				$exibir_virtual_baixo = "";	
				$exibir_professor_baixo = "";
			} else {
				$link_disciplina = "";
				$exibir_virtual_baixo = "<td align=\"center\"><b><a href=\"ea_disciplina.php?turma_disc=$turma_disc&coddisc=$cod_disc&anograde=$ano_grade\">[CEDTEC VIRTUAL]</a></b></td>
				";	
				$exibir_professor_baixo = "<td align=\"center\"><a rel=\"shadowbox\" href=\"mensagem_tutor.php?id=$cod_professor&turma_disc=$turma_disc\">$nome_professor</a></td>";
			}
			
			echo "
			<tr>
				$exibir_virtual_baixo
				<td><a $link_disciplina>$disciplina</a></td>
		";	
		//NOTAS POR ETAPA
		$sql_etapa_notas = mysql_query("SELECT cor_etapa, id_etapa, min_nota FROM ced_etapas WHERE tipo_etapa LIKE '%$user_tipo_etapa%'");
		while($dados_etapa = mysql_fetch_array($sql_etapa_notas)){
			$etapa_cor = $dados_etapa["cor_etapa"];
			$etapa_id = $dados_etapa["id_etapa"];
			$etapa_min_nota = $dados_etapa["min_nota"];
			
			
			//PESQUISA NOTA DE AVALIAÇÕES
			$pesq_nota_a = mysql_query("
			SELECT SUM(cn.nota)as notafinal FROM 
ced_notas cn
INNER JOIN ced_turma_ativ cta
ON cta.ref_id = cn.ref_ativ
INNER JOIN ced_desc_nota cdn
ON cdn.codigo = cta.cod_ativ
WHERE cn.matricula = $user_usuario AND cn.turma_disc = $turma_disc AND cdn.subgrupo = 'A'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
AND cta.id_etapa = $etapa_id");
			$contar_nota_a = mysql_num_rows($pesq_nota_a);
			if($contar_nota_a == 0){
				$nota_aluno_a = "0,00";
				$nota_parcial1 = 0;
			} else {
				$dados_nota_a = mysql_fetch_array($pesq_nota_a);
				$nota_aluno_a = number_format($dados_nota_a["notafinal"], 2, ',', '');
				$nota_parcial1 = $dados_nota_a["notafinal"];
			}
			//PESQUISA NOTA DE ATIVIDADES DIVERSIFICADAS
			$pesq_nota_b = mysql_query("
SELECT sum(t1.nota) as notafinal FROM (SELECT DISTINCT cn.matricula, cn.ref_ativ, cn.turma_disc, cn.grupo, cn.nota FROM
	ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	INNER JOIN ced_desc_nota cdn
	ON cdn.codigo = cta.cod_ativ
	WHERE cn.matricula = $user_usuario AND cn.turma_disc = $turma_disc AND (cdn.subgrupo = 'B')  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
	AND cta.id_etapa = $etapa_id) t1");
			$contar_nota_b = mysql_num_rows($pesq_nota_b);
			if($contar_nota_b == 0){
				$nota_aluno_b = "0,00";
				$nota_parcial2 = 0;
			} else {
				$dados_nota_b = mysql_fetch_array($pesq_nota_b);
				$nota_aluno_b = number_format($dados_nota_b["notafinal"], 2, ',', '');
				$nota_parcial2 = $dados_nota_b["notafinal"];
			}
			//PESQUISA NOTA DE RECUPERAÇÃO
			$pesq_nota_c = mysql_query("
			SELECT SUM(cn.nota)as notafinal FROM 
ced_notas cn
INNER JOIN ced_turma_ativ cta
ON cta.ref_id = cn.ref_ativ
INNER JOIN ced_desc_nota cdn
ON cdn.codigo = cta.cod_ativ
WHERE cn.matricula = $user_usuario AND cn.turma_disc = $turma_disc AND cdn.subgrupo = 'C'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
AND cta.id_etapa = $etapa_id");
			$contar_nota_c = mysql_num_rows($pesq_nota_c);
			if($contar_nota_c == 0){
				$nota_aluno_c = "0,00";
				$nota_parcial3 = 0;
			} else {
				$dados_nota_c = mysql_fetch_array($pesq_nota_c);
				$nota_aluno_c = number_format($dados_nota_c["notafinal"], 2, ',', '');
				$nota_parcial3 = $dados_nota_c["notafinal"];
			}
			$nota_atividades = $nota_parcial1 + $nota_parcial2;
			$nota_recuperação = $nota_parcial3;
			
			if($nota_atividades >= $etapa_min_nota){
				$exibir_nota_parcial = format_valor($nota_atividades);
			}
			if($nota_recuperação == 0){
				$exibir_nota_parcial = format_valor($nota_atividades);
			}
			if($nota_recuperação > 0&&$nota_atividades < $etapa_min_nota){
				$exibir_nota_parcial = format_valor($nota_recuperação);
			}
			if($nota_recuperação < $nota_atividades){
				$exibir_nota_parcial = format_valor($nota_atividades);
			}
			if($nota_recuperação > $nota_atividades){
				$exibir_nota_parcial = format_valor($nota_recuperação);
			}
			if(str_replace(",",".",$exibir_nota_parcial) < $etapa_min_nota){
				$cor_nota = "red";	
			} else {
				$cor_nota = "green";
			}
			
			$nota_min_aprov += $etapa_min_nota; 
			$nota_final += str_replace(",",".",$exibir_nota_parcial); 
			echo "
			<td align=\"center\" bgcolor=\"$etapa_cor\"><a rel=\"shadowbox\" href=\"
	a_detalhes_nota.php?matricula=$user_usuario&td=$turma_disc&grupo=A&etapa=$etapa_id\">$nota_aluno_a</a></td>
			<td align=\"center\" bgcolor=\"$etapa_cor\"><a rel=\"shadowbox\" href=\"a_detalhes_nota.php?matricula=$user_usuario&td=$turma_disc&grupo=B&etapa=$etapa_id\">$nota_aluno_b</a></td>
			<td align=\"center\" bgcolor=\"$etapa_cor\"><a rel=\"shadowbox\" href=\"a_detalhes_nota.php?matricula=$user_usuario&td=$turma_disc&grupo=C&etapa=$etapa_id\">$nota_aluno_c</a></td>
			<td align=\"center\" bgcolor=\"$etapa_cor\"><font color=\"$cor_nota\">$exibir_nota_parcial</font></td>
			";
			
		}
		//PEGA AS FALTAS
		$sql_falta = mysql_query("SELECT COUNT(DISTINCT n_aula) as falta_total FROM ced_falta_aluno WHERE matricula = '$user_usuario' AND turma_disc = '$turma_disc' AND status LIKE 'F' AND data IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_disc')");
		$dados_falta = mysql_fetch_array($sql_falta);
		$falta         = $dados_falta["falta_total"];
		$exibir_nota_final = format_valor($nota_final);
		if(str_replace(",",".",$exibir_nota_final) < $nota_min_aprov){
				$cor_nota_final = "red";	

			} else {
				$cor_nota_final = "green";
			}
		echo "<td bgcolor=\"#EEEE0\" align=\"center\"><b>$falta</b></td>
<td bgcolor=\"#EEEE0\" align=\"center\"><b><font color=\"$cor_nota_final\">$exibir_nota_final</font></b></td>
$exibir_professor_baixo
</tr>";
	}
	?>
<tr>
    <td colspan="20" valign="top"><b>
    Legenda:<br>
    Notas em <font color="red">[VERMELHO]</font> est&atilde;o abaixo da m&eacute;dia.<br>
    Notas em <font color="green">[VERDE]</font> est&atilde;o dentro da m&eacute;dia de aprova&ccedil;&atilde;o.<br>
    Para visualizar o detalhamento de notas clique sobre a nota.
    <br>
    <?php 
	$sql_obs = mysql_query("SELECT * FROM obs_nivel WHERE nivel_obs LIKE '%$user_turma_nivel%'");
	$dados_obs = mysql_fetch_array($sql_obs);
	$observacao_geral = ($dados_obs["obs"]);
	echo $observacao_geral;?></td>
    </tr>
</table>
    </div>
                         
                      </section>
                  </div>
                  
                  <div class="col-lg-12">
                      <section class="panel">
                      <div class="panel-heading">
                      <b>Resumo Financeiro</b>
                      </div>
                          <div class="panel-body">

<?php
$sql_fin_pendente = mysql_query("SELECT * FROM geral_titulos WHERE codigo LIKE $user_usuario AND tipo_titulo=2 AND status = 0 AND (data_pagto LIKE '' OR data_pagto IS NULL) ORDER BY vencimento");
$total_boletos_pendentes = mysql_num_rows($sql_fin_pendente);
if(mysql_num_rows($sql_fin_pendente)>=1){
	echo "
	<div class=\"panel-heading-aviso\">
                                  <h4 class=\"panel-title\">
                                      <a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#financeiro_pendente\">
                                          Boletos a Pagar <font size=\"-2\">($total_boletos_pendentes)</font>                                      </a>
                                  </h4>
                              </div>
<div id=\"financeiro_pendente\" class=\"panel-collapse collapse in\">
                                  <div class=\"panel-body-aviso\">
	<table width=\"100%\" border=\"1\" bordercolorlight=\"#CCCCCC\" class=\"full_table_list\">
	<tr bgcolor=\"#BEBEBE\">
		<td><div align=\"center\"><strong>T&Iacute;TULO</strong></div></td>
        <td><div align=\"center\"><strong>VENCIMENTO</strong></div></td>
        <td><div align=\"center\"><strong>VALOR</strong></div></td>
		<td><div align=\"center\"><strong>SITUAÇÃO</strong></div></td>
        <td><div align=\"center\"><strong>2&ordf; VIA</strong></div></td>
		
    </tr>";
	
}
while($l_fin = mysql_fetch_array($sql_fin_pendente)) {
	$id2         = $l_fin["id_titulo"];
	$layout         = $l_fin["layout"];
	$parcela		= $l_fin["parcela"];
	$vencimento         = substr($l_fin["vencimento"],8,2)."/".substr($l_fin["vencimento"],5,2)."/".substr($l_fin["vencimento"],0,4);
	$data_pagto         = substr($l_fin["data_pagto"],8,2)."/".substr($l_fin["data_pagto"],5,2)."/".substr($l_fin["data_pagto"],0,4);
	$valor_tit         = number_format($l_fin["valor"],2,",",".");
	$valor_pagto         = number_format($l_fin["valor_pagto"],2,",",".");
	if($data_pagto == "//"){
		$data_pagto = "A Pagar";
	}
	//INICIA CALCULO DINÂMICO DE JUROS
		$data_atual = date("Y-m-d");
		$sql_calculo = mysql_query("SELECT t1.id_titulo, t1.vencimento, t1.valor, t1.dias_atraso , 
t1.multa, t1.juros_dia, t1.honorario,
t1.multa+t1.juros_dia+t1.honorario as acrescimos_totais,
t1.valor+t1.multa+t1.juros_dia+t1.honorario as valor_calculado

FROM (
SELECT id_titulo, vencimento,data_pagto, valor_pagto, valor, DATEDIFF(NOW(), vencimento) as dias_atraso,  status,

IF(DATEDIFF(NOW(), vencimento) >=1,0.02*valor,0) as multa,
IF(DATEDIFF(NOW(), vencimento) >=1,((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*valor,0) as juros_dia,
IF(DATEDIFF(NOW(), vencimento) >=11,0.10*(valor+((DATEDIFF(NOW(), vencimento)* 0.00233)*valor)+(0.02*valor)),0) as honorario


FROM titulos 
) as t1
WHERE (t1.data_pagto = '' OR t1.data_pagto IS NULL) AND t1.vencimento < '$data_atual' AND t1.status = 0 AND t1.id_titulo = $id2");
		$cor_vencido = "";
		$situacao = "A Vencer";
		if(mysql_num_rows($sql_calculo)==1){
			$dados_calculo = mysql_fetch_array($sql_calculo);
			$valor_tit = format_valor($dados_calculo["valor_calculado"]);
			$cor_vencido = "bgcolor=\"#FFE4E1\"";
			$situacao = "Vencido";
		}
	
	echo "
	<tr $cor_vencido align='center'>
		<td>&nbsp;$id2</td>
		<td>&nbsp;$vencimento</td>
		<td>R$&nbsp;$valor_tit</td>
		<td>$situacao</td>	
		<td>&nbsp;<a href=\"../boleto/$layout?id=$id2&p=$parcela&id2=$user_usuario&refreshed=no\" target='_blank'>[IMPRIMIR]</a></td>
	</tr>
	";
}
if(mysql_num_rows($sql_fin_pendente)>=1){
	echo "</table>
	</div>
</div>";
}
?>


<?php
//pega boletos pagos
$sql_fin_pagos = mysql_query("SELECT * FROM geral_titulos WHERE codigo LIKE $user_usuario AND tipo_titulo=2 AND status = 0 AND (data_pagto NOT LIKE '') ORDER BY vencimento");
$total_boletos_pagos = mysql_num_rows($sql_fin_pagos);
if(mysql_num_rows($sql_fin_pagos)>=1){
	echo "
	<div class=\"panel-heading-aviso\">
                                  <h4 class=\"panel-title\">
                                      <a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#financeiro_pagos\">
                                          Boletos Pagos <font size=\"-2\">($total_boletos_pagos)</font>                                      </a>
                                  </h4>
                              </div>
<div id=\"financeiro_pagos\" class=\"panel-collapse collapse\">
                                  <div class=\"panel-body-aviso\">
	<table width=\"100%\" border=\"1\" bordercolorlight=\"#CCCCCC\" class=\"full_table_list\">
	<tr>
		<td><div align=\"center\"><strong>T&Iacute;TULO</strong></div></td>
        <td><div align=\"center\"><strong>VENCIMENTO</strong></div></td>
        <td bgcolor=\"#D5D5D5\"><div align=\"center\"><strong>VALOR</strong></div></td>
        <td><div align=\"center\"><strong>DATA DE PAGAMENTO</strong></div></td>
        <td><div align=\"center\"><strong>VALOR DE PAGAMENTO</strong></div></td>
    </tr>";
	
}
while($l_fin = mysql_fetch_array($sql_fin_pagos)) {
	$id2         = $l_fin["id_titulo"];
	$layout         = $l_fin["layout"];
	$parcela		= $l_fin["parcela"];
	$vencimento         = substr($l_fin["vencimento"],8,2)."/".substr($l_fin["vencimento"],5,2)."/".substr($l_fin["vencimento"],0,4);
	$data_pagto         = substr($l_fin["data_pagto"],8,2)."/".substr($l_fin["data_pagto"],5,2)."/".substr($l_fin["data_pagto"],0,4);
	$valor_tit         = number_format($l_fin["valor"],2,",",".");
	$valor_pagto         = number_format($l_fin["valor_pagto"],2,",",".");
	if($data_pagto == "//"){
		$data_pagto = "A Pagar";
	}	
	echo "
	<tr align='center'>
		<td>&nbsp;$id2</td>
		<td>&nbsp;$vencimento</td>
		<td>R$&nbsp;$valor_tit</td>	
		<td>&nbsp;$data_pagto</td>
		<td>R$&nbsp;$valor_pagto</td>
	</tr>
	";
}
if(mysql_num_rows($sql_fin_pagos)>=1){
	echo "</table>
	</div>
</div>";
}
?>


    </div>
                         
                      </section>
                  </div>

              </div>

                      </section>
                      <!--weather statement end-->
                  </div>
              </div>

          </section>
      </section>

<?php
} else {

include('incs/inc_professor.php');

}
//verifica restrição de usuário
$sql_status_user = mysql_query("SELECT * FROM users WHERE id_user = '$user_iduser'");
$_SESSION["tipo_usuario"] = 1;
if(mysql_num_rows($sql_status_user)==0){
	$_SESSION["tipo_usuario"] = 2;
	$sql_status_user = mysql_query("SELECT * FROM acesso WHERE codigo = $user_usuario");
}
$dados_status_user = mysql_fetch_array($sql_status_user);
$restricao_login = $dados_status_user["status"];
if($restricao_login == 1){
	header("Location: confirmar_dados_acesso.php"); 	
}
if($restricao_login == 2){
	header("Location: ../index.php?erro=2"); 	
}
?>


 <?php 
 include('includes/footer.php');
 ?>
  </section>
<?php
 include('includes/js.php');?>


  </body>
</html>
