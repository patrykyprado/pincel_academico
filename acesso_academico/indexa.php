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
$sql_disciplinas = mysql_query("SELECT ctd.codigo, d.disciplina, ct.anograde, d.cod_disciplina
FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND ct.anograde = d.anograde
WHERE ct.id_turma = $user_turma_id_turma
ORDER BY ctd.inicio");
if(mysql_num_rows($sql_disciplinas) == 0){
	echo "<center>Não há disciplinas.</center>";
} else {
	//monta cabeçalho da tabela de notas
	echo "<table border=\"1\" width=\"100%\">
	<tr>
		<td bgcolor=\"#CCC\" align=\"center\"><b>--</b></td>
		<td bgcolor=\"#CCC\" align=\"center\"><b>Componente Curricular</b></td>";
		//PEGA O NOME DA ETAPA
		$sql_etapa_nome = mysql_query("SELECT etapa, cor_etapa,grupos_ativ FROM ced_etapas WHERE tipo_etapa = $user_tipo_etapa");
		
		while($dados_etapa_nome = mysql_fetch_array($sql_etapa_nome)){
			$nome_etapa = $dados_etapa_nome["etapa"];	
			$cor_etapa = $dados_etapa_nome["cor_etapa"];
			$ativs_etapa = $dados_etapa_nome["grupos_ativ"];
			$sql_atividades_etapa = mysql_query("SELECT atividade, grupo FROM ced_desc_nota WHERE grupo IN ($ativs_etapa)");
			
			echo "<td bgcolor=\"$cor_etapa\">
			<table width=\"320px\" border=\"1\">
			<tr>
				<td align=\"center\" colspan=\"6\"><b><font size=\"-1\">$nome_etapa</b></font></td>
			</tr>
			<tr>";
			$total_span_atividades = mysql_num_rows($sql_atividades_etapa);
			while($dados_atividades = mysql_fetch_array($sql_atividades_etapa)){
				$nome_atividade = $dados_atividades["atividade"];
				$grupo_atividade = $dados_atividades["grupo"];
				echo"
			
				<td align=\"center\" width=\"80px\"><b><font size=\"-3\">$nome_atividade</b></font></td>
			
			
			";	
			}
			
			echo "
			<td align=\"center\" width=\"80px\"><b><font size=\"-3\">Nota Parcial</b></font></td>
			</tr>
			</table>
			</td>
			<td bgcolor=\"#EEFB8F\" align=\"center\">
				<b>Faltas</b>
			</td>
			";
		}
	echo "
	</tr>
	";	
	//monta o corpo das notas
	while($dados_disciplinas = mysql_fetch_array($sql_disciplinas)){
		$disciplinas_turma_disc = $dados_disciplinas["codigo"];
		$disciplinas_cod_disc =  $dados_disciplinas["cod_disciplina"];
		$disciplinas_ano_grade = $dados_disciplinas["anograde"];
		$disciplinas_nome = $dados_disciplinas["disciplina"];
		$sql_etapa_notas = mysql_query("SELECT id_etapa, etapa, cor_etapa,grupos_ativ FROM ced_etapas WHERE tipo_etapa = $user_tipo_etapa");
		echo "<tr><td align=\"center\"><b><a href=\"ea_disciplina.php?turma_disc=$disciplinas_turma_disc&coddisc=$disciplinas_cod_disc&anograde=$disciplinas_ano_grade\">[CEDTEC VIRTUAL]</a></b></td>
		<td>$disciplinas_nome</td>
		";
		while($dados_etapa_nota = mysql_fetch_array($sql_etapa_notas)){
			$id_etapa = $dados_etapa_nota["id_etapa"];
			$ativs_etapa = $dados_etapa_nota["grupos_ativ"];
			echo "
			<td><table width=\"320px\" border=\"1\">
			<tr>
			";
			$sql_atividades_etapa_notas = mysql_query("SELECT atividade, grupo FROM ced_desc_nota WHERE grupo IN ($ativs_etapa)");
			$nota_parcial = 0;
			while($dados_atividades_etapa = mysql_fetch_array($sql_atividades_etapa_notas)){
				$atividades_etapa_grupo = $dados_atividades_etapa["grupo"];
				
				//PESQUISA NOTA DE AVALIAÇÕES
			$pesq_nota_a = mysql_query("
			SELECT SUM(cn.nota)as notafinal FROM 
			ced_notas cn
			INNER JOIN ced_turma_ativ cta
			ON cta.ref_id = cn.ref_ativ
			INNER JOIN ced_desc_nota cdn
			ON cdn.codigo = cta.cod_ativ
			WHERE cn.matricula = $user_usuario AND cn.turma_disc = $disciplinas_turma_disc AND cdn.subgrupo = '$atividades_etapa_grupo'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
			AND cta.id_etapa = $id_etapa");
			$contar_nota_a = mysql_num_rows($pesq_nota_a);
			if($contar_nota_a == 0){
				$nota_parcial += 0;
				$nota = 0;
			} else {
				$dados_nota_a = mysql_fetch_array($pesq_nota_a);
				$nota_parcial += $dados_nota_a["notafinal"];
				$nota = $dados_nota_a["notafinal"];
			}
			$exibir_nota = format_valor($nota);
			$exibir_nota_parcial = format_valor($nota_parcial);
				
				echo "<td width=\"80\" align=\"center\"><b><font size=\"-3\">$exibir_nota</b></font></td>";
			}
			
			echo "<td width=\"80\" align=\"center\"><b><font size=\"-3\">$exibir_nota_parcial</b></font></td></tr></table></td>";	
		}
				
		
	}
	
	echo "</table>";
}

?>
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
$sql_fin_pendente = mysql_query("
SELECT tit.id_titulo, tit.vencimento, tit.valor, tit.parcela, tit.data_pagto, tit.valor_pagto, 
DATEDIFF(NOW(), tit.vencimento) AS dias_atraso,  tit.status,
IF(DATEDIFF(NOW(), tit.vencimento) >=1,0.02*tit.valor,0) AS multa,
IF(DATEDIFF(NOW(), tit.vencimento) >=1,((DATEDIFF(NOW(), tit.vencimento)-1)* 0.00233)*valor,0) AS juros_dia,
IF(DATEDIFF(NOW(), tit.vencimento) >=11,0.10*(tit.valor+((DATEDIFF(NOW(), tit.vencimento)* 0.00233)*tit.valor)+(0.02*tit.valor)),0) AS honorario,
con.layout
FROM titulos tit
INNER JOIN alunos alu
ON tit.cliente_fornecedor = alu.codigo
INNER JOIN contas con
ON con.ref_conta = tit.conta
WHERE alu.codigo = $user_usuario AND tit.tipo=2 AND tit.status = 0 AND (trim(tit.data_pagto) LIKE '' OR tit.data_pagto IS NULL) ORDER BY tit.vencimento");
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
	$vencimento         = format_data($l_fin["vencimento"],8,2);
	$data_pagto         = format_data($l_fin["data_pagto"]);
	$valor_tit         = format_valor($l_fin["valor"]);
	$valor_pagto         = format_valor($l_fin["valor_pagto"]);
	if($data_pagto == "//"){
		$data_pagto = "A Pagar";
	}
		$cor_vencido = "";
		$situacao = "A Vencer";
		if($l_fin["dias_atraso"]>=1){

			$valor_tit = format_valor($l_fin["valor"]+$l_fin["juros_dia"]+$l_fin["honorario"]);
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
$sql_fin_pagos = mysql_query("SELECT id_titulo, vencimento, valor, data_pagto, valor_pagto FROM titulos WHERE cliente_fornecedor = $user_usuario AND tipo=2 AND status = 0 AND (data_pagto NOT LIKE '' AND valor >0) ORDER BY vencimento");
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
	$vencimento         = format_data($l_fin["vencimento"]);
	$data_pagto         = format_data($l_fin["data_pagto"]);
	$valor_tit         = format_valor($l_fin["valor"]);
	$valor_pagto         = format_valor($l_fin["valor_pagto"]);	
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
