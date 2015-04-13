<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$turma_d = $_GET["id"];
$id_turma = $_GET["id_turma"];
$cancelado_observacao = "";

//SELECIONA OS ALUNOS

$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");

//PEGA O CODIGO E GRUPO DA TURMA
$turma_pesq1 = mysql_query("SELECT A.*, B.grupo as grupo FROM ced_turma_disc A INNER JOIN ced_turma B ON B.cod_turma = A.codturma where A.codigo LIKE '$turma_d' AND B.id_turma = $id_turma");
$dados_turma1 = mysql_fetch_array($turma_pesq1);
$grupo_turma = $dados_turma1["grupo"];
$cod_turma = $dados_turma1["codturma"];
$cod_disciplina = $dados_turma1["disciplina"];
$grade_disciplina = $dados_turma1["ano_grade"];
$cod_prof = $dados_turma1["cod_prof"];
$id_turma = $dados_turma1["id_turma"];

//PEGA O NOME DO PROFESSOR
$prof_pesq = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = $cod_prof");
$dados_prof = mysql_fetch_array($prof_pesq);
$nome_professor = $dados_prof["nome"];


//PEGA OS DADOS DA TURMA
$turma_pesq2 = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$cod_turma' AND grupo LIKE '$grupo_turma' AND id_turma = $id_turma");
$dados_turma2 = mysql_fetch_array($turma_pesq2);
$cod_turma = $dados_turma2["cod_turma"];
$grupo_turma = $dados_turma2["grupo"];
$nivel_turma = $dados_turma2["nivel"];
$curso_turma = $dados_turma2["curso"];
$modulo_turma = $dados_turma2["modulo"];
$unidade_turma = $dados_turma2["unidade"];
$polo_turma = $dados_turma2["polo"];
$inicio_turma = $dados_turma2["inicio"];
$fim_turma = $dados_turma2["fim"];
$min_nota = $dados_turma2["min_nota"];
$min_falta = $dados_turma2["min_freq"];
$tipo_etapa = $dados_turma2["tipo_etapa"];

//PEGA AS ETAPAS EXISTENTES NA TURMA
$sql_etapa_atividades = mysql_query("SELECT * FROM ced_etapas WHERE tipo_etapa = $tipo_etapa");
$sql_etapa_nome = mysql_query("SELECT * FROM ced_etapas WHERE tipo_etapa = $tipo_etapa");

//PEGA OS DADOS DA DISCIPLINA
$disc_pesq = mysql_query("SELECT * FROM disciplinas WHERE anograde = '$grade_disciplina' AND cod_disciplina = '$cod_disciplina'");
$dados_disc = mysql_fetch_array($disc_pesq);
$nome_disciplina = $dados_disc["disciplina"];
$ch_disciplina = $dados_disc["ch"];


$max_falta = ($ch_disciplina*$min_falta)/100;
//x=ch*min_falta/100

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
$sql2 = mysql_query("SELECT * FROM ced_desc_nota WHERE subgrupo LIKE '0' AND grupo NOT LIKE 'C'");
$count2 = mysql_num_rows($sql2);
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
                              <b>Di&aacute;rio de Notas</b>
                          </header>
                        <div class="panel-body">
<form action="#"  method="post">
<table width="100%" border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:8px">

    
    <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count2;?>">Registro de Avalia&ccedil;&otilde;es e Resultado</th>
    </tr>
    
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Módulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table width="100%" border="1" class="full_table_list"  style="font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<tr style="font-size:12px;">
	<td width="50px"><div align="center"></div></td>
     <td width="300px"><div align="center"></div></td>
     <?php
	 while($dados_etapa = mysql_fetch_array($sql_etapa_nome)){
		 $etapa_nome = $dados_etapa["etapa"];
		 $etapa_cor = $dados_etapa["cor_etapa"];
		 echo "<td bgcolor=\"$etapa_cor\" colspan=\"4\"><center><b>$etapa_nome</b></center></td>";
	 }
	 
	 ?>
</tr>
    <tr style="font-size:8px;">
    	<td width="50px"><div align="center"><strong>N&ordm;</strong></div></td>
        <td width="300px"><div align="center"><strong>Nome</strong></div></td>
        
<?php 




if ($count2 == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	while($dados_etapa = mysql_fetch_array($sql_etapa_atividades)){
		$etapa_cor = $dados_etapa["cor_etapa"];
		$sql2 = mysql_query("SELECT * FROM ced_desc_nota WHERE subgrupo LIKE '0'");
		while ($dados2 = mysql_fetch_array($sql2)) {
			// enquanto houverem resultados...
			$cod_atividade = $dados2["codigo"];
			$grupo_ativi = $dados2["grupo"];
			$atividade = $dados2["atividade"];
			$max_nota_ativ = $dados2["max_nota"];
			echo "
			<td bgcolor=\"$etapa_cor\"><div align=\"center\"><strong>$atividade</strong></div></td>
			
			\n";
			// exibir a coluna nome e a coluna email
		}
		echo "<td align=\"center\" bgcolor=\"$etapa_cor\"><b>Nota Parcial</b></td>";
	}
	
}
;?>
<td bgcolor="#EEEE0" align="center"><b>Faltas</b></td>
<td bgcolor="#EEEE0" align="center"><b>Nota Final</b></td>
<td align="center"><b>Resultado</b></td>
	</tr>


<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA TURMA ENCONTRADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$i = 0;
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$img_aluno = "img_".$codigo;;
		//PEGA A FOTO ACADEMICA DO ALUNO
		$sql_foto = mysql_query("SELECT * FROM acessos_completos WHERE usuario = $codigo");
		$dados_foto = mysql_fetch_array($sql_foto);
		$foto_academica = $dados_foto["foto_academica"];
		
		$nota_parcial = 0;
		
		
		$i +=1;

		
        echo "
	<tr>
		<td><b><center>$i</b></center></td>
		<td style=\"font-size:8px\"><a style=\"color:black;text-decoration:none;\" onDblClick=\"mostrarElemento('$img_aluno', 'inline');\" 
        onMouseOut=\"mostrarElemento('$img_aluno', 'none');\">$nome</a>
		<div id=\"$img_aluno\" style=\"display:none; position:fixed;\"><img src=\"$foto_academica\"/></div>
		</td>
		
		
		\n";
		//pega notas por etapa
		$sql_etapa_notas = mysql_query("SELECT * FROM ced_etapas WHERE tipo_etapa = $tipo_etapa");
		$nota_final = 0;
		while($dados_etapa = mysql_fetch_array($sql_etapa_notas)){
			$etapa_id = $dados_etapa["id_etapa"];
			$etapa_cor = $dados_etapa["cor_etapa"];
			$etapa_min_nota = $dados_etapa["min_nota"];
			$sql2 = mysql_query("SELECT * FROM ced_desc_nota WHERE subgrupo LIKE '0'");
			$count2 = mysql_num_rows($sql2);
			$count3= $count2+9;
			$nota_parcial = 0;
			
			while ($dados2 = mysql_fetch_array($sql2)) {
				// enquanto houverem resultados...
				//pesquisa notas anteriores
	
					// enquanto houverem resultados...
					$cod_atividade = $dados2["codigo"];
					$grupo_ativi = $dados2["grupo"];
					$atividade = $dados2["atividade"];
					
					//PESQUISA NOTA POR ATIVIDADE
					//$pesq_nota = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $turma_d AND grupo = '$grupo_ativi'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");


$pesq_nota = mysql_query("
						SELECT sum(t1.nota) as notafinal FROM 
						(SELECT DISTINCT cn.matricula, cn.ref_ativ, cn.turma_disc, cn.grupo, cn.nota FROM 
	ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	INNER JOIN ced_desc_nota cdn
	ON cdn.codigo = cta.cod_ativ
	WHERE cn.matricula = $codigo AND cn.turma_disc = $turma_d AND cdn.subgrupo = '$grupo_ativi'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
	AND cta.id_etapa = $etapa_id) t1");
					$contar_nota = mysql_num_rows($pesq_nota);
					if($contar_nota == 0){
						$nota_aluno = "0,00";
						$nota_parcial1 = 0;
					} else {
						$dados_nota = mysql_fetch_array($pesq_nota);
						$nota_aluno = number_format($dados_nota["notafinal"], 2, ',', '');
						$nota_parcial1 = $dados_nota["notafinal"];
					}
					$nota_parcial += $nota_parcial1; 
					//NOTAS DE AVALIAÇÕES E ATIVIDADES
$pesq_notas_atividades = mysql_query("
						SELECT sum(t1.nota) as notafinal FROM 
						(SELECT DISTINCT cn.matricula, cn.ref_ativ, cn.turma_disc, cn.grupo, cn.nota FROM 
	ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	INNER JOIN ced_desc_nota cdn
	ON cdn.codigo = cta.cod_ativ
	WHERE cn.matricula = $codigo AND cn.turma_disc = $turma_d AND (cdn.subgrupo = 'A' OR cdn.subgrupo = 'B')  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
	AND cta.id_etapa = $etapa_id) t1");

					$dados_notas_atividades = mysql_fetch_array($pesq_notas_atividades);
					$nota_atividades = $dados_notas_atividades["notafinal"];
					
					//NOTAS DE RECUPERAÇÃO
					$pesq_notas_recuperação = mysql_query("
					SELECT SUM(cn.nota)as notafinal FROM 
ced_notas cn
INNER JOIN ced_turma_ativ cta
ON cta.ref_id = cn.ref_ativ
WHERE cn.matricula = $codigo AND cn.turma_disc = $turma_d AND cn.grupo = 'C'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
AND cta.id_etapa = $etapa_id");
					$dados_notas_recuperação = mysql_fetch_array($pesq_notas_recuperação);
					$nota_recuperação = $dados_notas_recuperação["notafinal"];
					
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
					$nota_final += str_replace(",",".",$exibir_nota_parcial)/3;
					$exibir_nota_final = format_valor($nota_final);
					echo "
					<td bgcolor=\"$etapa_cor\" align=\"center\">$nota_aluno</b></td>";
					
				
			}
			echo "<td align=\"center\" bgcolor=\"$etapa_cor\">$exibir_nota_parcial</td>";
		}
        // exibir a coluna nome e a coluna email
		//PEGA AS FALTAS
		$sql_falta = mysql_query("SELECT COUNT(DISTINCT n_aula) as falta_total FROM ced_falta_aluno WHERE matricula = '$codigo' AND turma_disc = '$turma_d' AND status LIKE 'F' AND data IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
		$dados_falta = mysql_fetch_array($sql_falta);
		$falta         = $dados_falta["falta_total"];
		
		//GERA O RESULTADO FINAL
		if($falta > $max_falta || str_replace(",",".",$exibir_nota_final) < $min_nota){
			$exibir_resultado = "Reprovado";	
		} else {
			$exibir_resultado = "Aprovado";	
		}
		
		//verifica cancelados
		$sql_cancelados = mysql_query("SELECT toc.nome, oco.data FROM ocorrencias oco
INNER JOIN tipo_ocorrencia toc
ON oco.n_ocorrencia = toc.id
WHERE oco.n_ocorrencia = 1 AND oco.matricula = $codigo AND oco.id_turma = $id_turma LIMIT 1");
		if(mysql_num_rows($sql_cancelados)>=1){
			$dados_cancelados = mysql_fetch_array($sql_cancelados);
			$nome_ocorrencia = $dados_cancelados["nome"];
			$data_ocorrencia = format_data($dados_cancelados["data"]);
			$exibir_resultado = "Cancelado";
			$cancelado_observacao .= "Aluno(a) $nome, nº de matricula $codigo foi $nome_ocorrencia em $data_ocorrencia.<br>";
		}
		echo "
		<td bgcolor=\"#EEEE0\" align=\"center\"><b>$falta</b></td>
		<td bgcolor=\"#EEEE0\" align=\"center\"><b>$exibir_nota_final</b></td>
		<td align=\"center\"><b>$exibir_resultado</b></td>";
    }
}

?>
</form>
</table>

<table width="100%" border="1" style="font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<tr>
<td colspan="4" align="center"><div style="font-size:8px; font-family:Arial, Helvetica, sans-serif">OBSERVA&Ccedil;&Otilde;ES</div></td>
</tr>

<?php
// exibi os cancelados em observações
echo "<tr><td colspan=\"4\">$cancelado_observacao</td></tr>";
$p_obs = mysql_query("SELECT * FROM ced_turma_obs WHERE turma_disc = $turma_d AND matricula = 0");

if(mysql_num_rows($p_obs)>=1){
	echo "<tr>
			<td align=\"center\"><b>DATA</b></td>
			<td align=\"center\" colspan=\"3\"><b>DESCRI&Ccedil;&Atilde;O</b></td>
		</tr>";
	while($dados_obs = mysql_fetch_array($p_obs)){
		$id_obs = $dados_obs["id_obs"];
		$data_obs = substr($dados_obs["data_obs"],8,2)."/".substr($dados_obs["data_obs"],5,2)."/".substr($dados_obs["data_obs"],0,4);
		$obs = $dados_obs["obs"];
		echo "<tr>
			<td align=\"center\>$data_obs</td>
			<td colspan=\"3\">$obs</td>
		</tr>";
	
	}
} else {
	echo "<tr>
			<td colspan=\"4\" style=\"line-height:70px\"></td>
		</tr>
		";
}


?>



<tr>
<td>
<br />
<div align="center">___/___/____<br />Data</div>
</td>
<td>
<br />
<div align="center">______________________<br />Docente</div>
</td>

<td>
<br />
<div align="center">___/___/____<br />Data</div>
</td>

<td>
<br />
<div align="center">______________________<br />Dire&ccedil;&atilde;o Pedag&oacute;gica</div>
</td>

</tr>
</table>

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