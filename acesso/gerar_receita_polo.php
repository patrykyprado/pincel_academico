<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$get_unidade = $_GET["unidade"];
$get_polo = $_GET["polo"];
$get_inicio = converter_data($_GET["inicio"]);
$get_fim = converter_data($_GET["fim"]);
$exibir_inicio = $_GET["inicio"];
$exibir_fim = $_GET["fim"];

if($get_unidade == ""){
	echo "<script language=\"javascript\">alert('Você deve selecionar a unidade'); window.close();</script>";
} else {
	$sql_unidade = " ct.unidade LIKE '%$get_unidade%'";	
}
if($get_polo == ""){
	$sql_polo = "";
	$exibir_polo = "Geral";
} else {
	$sql_polo = " AND ct.polo LIKE '%$get_polo%'";	
	$exibir_polo = $get_polo;
}


$sql_receita_polo = mysql_query("SELECT t1.nivel, t1.curso, t1.modulo, t1.unidade, t1.polo, SUM(t1.total) AS qtd_alunos,
(SELECT COUNT(DISTINCT cta.matricula,ct.unidade,ct.modulo, ct.polo, ct.grupo) FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON cta.id_turma = ct.id_turma
WHERE $sql_unidade $sql_polo AND (NOW() BETWEEN ct.inicio AND ct.fim)
GROUP BY ct.unidade) AS total
  FROM (
SELECT cta.matricula, ct.nivel, ct.modulo, ct.curso, ct.grupo, ct.unidade, ct.polo, COUNT(DISTINCT cta.matricula, ct.nivel, ct.curso,ct.modulo, ct.grupo, ct.unidade, ct.polo) AS total FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON cta.id_turma = ct.id_turma
WHERE $sql_unidade $sql_polo AND (NOW() BETWEEN ct.inicio AND ct.fim)
GROUP BY ct.nivel, ct.curso, ct.grupo, ct.unidade, ct.polo,ct.modulo) t1
GROUP BY t1.nivel, t1.curso, t1.unidade, t1.polo,t1.modulo
ORDER BY t1.unidade, t1.polo, t1.nivel, t1.curso, t1.modulo

");

$get_unidade_cc2 = substr($get_unidade,0,2);
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Relat&oacute;rio: Receita / Polo</b>
                          </header>
                          <div class="panel-body">
<?php

	if(mysql_num_rows($sql_receita_polo)>=1){
		echo "<table class=\"table-bordered table-striped\" width=\"100%\">
		<tr>
		<td align=\"center\"><img src=\"images/logo-cedtec.png\"/></td>
		<td colspan=\"6\"><b>Unidade:</b> $get_unidade<br>
		<b>Polo:</b> $exibir_polo<br>
		<b>Período:</b> $exibir_inicio até $exibir_fim.
		</td>
		</tr>
		<tr>
			<td align=\"center\"><b>Nível</b></td>
			<td align=\"center\"><b>Curso</b></td>
			<td align=\"center\"><b>Módulo</b></td>
			<td align=\"center\"><b>Unidade</b></td>
			<td align=\"center\"><b>Polo</b></td>
			<td align=\"center\"><b>Qtd. Alunos</b></td>
			<td align=\"center\"><b>Receita Polo</b></td>
		</tr>
		";
		//variaveis globais
		$total_alunos = 0;
		$total_receita_sem_cobranca = 0;
		$total_receita_cobranca = 0;
		while($dados_receita_polo = mysql_fetch_array($sql_receita_polo)){
			$receita_nivel = format_curso($dados_receita_polo["nivel"]);
			$receita_curso = format_curso($dados_receita_polo["curso"]);
			$receita_unidade = ($dados_receita_polo["unidade"]);
			$receita_polo = ($dados_receita_polo["polo"]);
			$receita_modulo = ($dados_receita_polo["modulo"]);
			$receita_total_alunos = ($dados_receita_polo["total"]);
			$receita_qtd_alunos = ($dados_receita_polo["qtd_alunos"]);
			$total_alunos += $receita_qtd_alunos;
			//receita atual
			$sql_receitas_atuais = mysql_query("SELECT SUM(tit.valor_pagto) AS valor_total 
			,(SELECT SUM(tit.valor_pagto) AS valor_total FROM 
			titulos tit
			INNER JOIN c_custo ccu
			ON tit.id_titulo = ccu.codigo
			INNER JOIN contas con
			ON tit.conta = con.ref_conta
			WHERE (tit.data_pagto BETWEEN '$get_inicio' AND '$get_fim') 
			AND tit.tipo = 2 AND ccu.cc2 = '$get_unidade_cc2' AND ccu.cc3 = '21') AS valor_total_cob
			FROM 
			titulos tit
			INNER JOIN c_custo ccu
			ON tit.id_titulo = ccu.codigo
			INNER JOIN contas con
			ON tit.conta = con.ref_conta
			WHERE (tit.data_pagto BETWEEN '$get_inicio' AND '$get_fim') 
			AND tit.tipo = 2 AND con.conta LIKE '%$get_unidade%' AND ccu.cc3 = '21'
			");
			$dados_receitas_atuais = mysql_fetch_array($sql_receitas_atuais);
			$receita_cobranca = $dados_receitas_atuais["valor_total_cob"];
			$receita_sem_cobranca = $dados_receitas_atuais["valor_total"];
			
			$receita_total_cobranca = (($receita_qtd_alunos / $receita_total_alunos) * $receita_cobranca);
			$receita_total_sem_cobranca = (($receita_qtd_alunos / $receita_total_alunos) * $receita_sem_cobranca);
			$total_receita_cobranca += $receita_total_cobranca;
			$total_receita_sem_cobranca +=$receita_total_sem_cobranca;
			$receita_total_cobranca = format_valor($receita_total_cobranca);
			$receita_total_sem_cobranca = format_valor($receita_total_sem_cobranca);
			echo "
			<tr>
				<td>$receita_nivel</td>
				<td align=\"\">$receita_curso</td>
				<td align=\"center\">$receita_modulo</td>
				<td align=\"center\">$receita_unidade</td>
				<td align=\"center\">$receita_polo</td>
				<td align=\"center\">$receita_qtd_alunos</td>
				<td> R$ $receita_total_sem_cobranca</td>
			</tr>
			";
			
		}
		$total_receita_cobranca_a = $total_receita_cobranca;
		$total_receita_sem_cobranca_a = $total_receita_sem_cobranca; 
		$total_receita_cobranca = format_valor($total_receita_cobranca);
		$total_receita_sem_cobranca = format_valor($total_receita_sem_cobranca);
		echo "<tr>
		<td colspan=\"5\" align=\"right\">Total: </td>
		<td align=\"center\"><b>$total_alunos</b></td>
		<td align=\"\"><b>R$ $total_receita_sem_cobranca</b></td>
		
		</tr>
		</table>";
		
		$sql_receitas = mysql_query("SELECT SUM(tit.valor_pagto) AS valor_total, con.conta AS conta FROM 
titulos tit
INNER JOIN c_custo ccu
ON tit.id_titulo = ccu.codigo
INNER JOIN contas con
ON tit.conta = con.ref_conta
WHERE (tit.data_pagto BETWEEN '$get_inicio' AND '$get_fim') 
AND tit.tipo = 2 AND ccu.cc2 = '$get_unidade_cc2' AND ccu.cc3 = '21'
GROUP BY tit.conta");

		if(mysql_num_rows($sql_receitas)>=1){
			echo "<table class=\"table-bordered table-striped\" width=\"100%\">
			<tr>
				<td align=\"center\" colspan=\"2\">Receitas / Conta</td>
			</tr>
			<tr>
				<td align=\"center\"><b>Conta</b></td>
				<td align=\"center\"><b>Receita</b></td>
			</tr>";
			while($dados_receitas = mysql_fetch_array($sql_receitas)){
				$receitas_conta = $dados_receitas["conta"];
				$receitas_valor = format_valor($dados_receitas["valor_total"]);	
				echo "<tr>
				<td align=\"left\" width=\"300px\">$receitas_conta</td>
				<td> R$ $receitas_valor</td>
			</tr>";
			}
			echo "</table>";
			
		}
		
		$sql_tabela_final = mysql_query("SELECT t1.unidade, t1.polo, SUM(t1.total) AS qtd_alunos
  FROM (
SELECT cta.matricula, ct.nivel, ct.curso, ct.grupo, ct.unidade, ct.polo, COUNT(DISTINCT cta.matricula, ct.nivel, ct.curso, ct.grupo, ct.unidade, ct.polo) AS total FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON cta.id_turma = ct.id_turma
WHERE $sql_unidade $sql_polo AND (NOW() BETWEEN ct.inicio AND ct.fim)
GROUP BY ct.nivel, ct.curso, ct.grupo, ct.unidade, ct.polo) t1
GROUP BY t1.unidade, t1.polo
ORDER BY t1.unidade, t1.polo");
		if(mysql_num_rows($sql_tabela_final)>=1){
			echo "<table class=\"table-bordered table-striped\" width=\"100%\">
			<tr>
				<td align=\"center\" colspan=\"4\">Receitas / Unidade / Polo</td>
			</tr>
			<tr>
				<td align=\"center\"><b>Unidade</b></td>
				<td align=\"center\"><b>Polo</b></td>
				<td align=\"center\"><b>Receita Polo</b></td>
			</tr>";
			while($dados_tabela_final = mysql_fetch_array($sql_tabela_final)){
				$tabela_unidade = $dados_tabela_final["unidade"];
				$tabela_polo = $dados_tabela_final["polo"];
				$tabela_receita_sem_cobranca = format_valor(($dados_tabela_final["qtd_alunos"]/$total_alunos)*$total_receita_sem_cobranca_a);
				$tabela_receita_cobranca = format_valor(($dados_tabela_final["qtd_alunos"]/$total_alunos)*$total_receita_cobranca_a);
				echo "<tr>
				<td align=\"center\">$tabela_unidade</td>
				<td align=\"center\">$tabela_polo</td>
				<td align=\"\">R$ $tabela_receita_sem_cobranca</td>
			</tr>";
				
			}
			echo "</table>";
		}
	}
?>
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
        
<script language="javascript">
function arrumaEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
var i;
for (i = 0; i < field.form.elements.length; i++)
if (field == field.form.elements[i])
break;
i = (i + 1) % field.form.elements.length;
field.form.elements[i].focus();
return false;
}
else
return true;
}
</script>
    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
    

 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script>