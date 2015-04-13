<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id_turma = $_GET["id"];
$etapa = $_GET["etapa"];
$cancelado_observacao = "";

//PEGA NOME DA ETAPA
$sql_etapa = mysql_query("SELECT * FROM ced_etapas WHERE id_etapa = $etapa");
$dados_etapa = mysql_fetch_array($sql_etapa);
$nome_etapa = $dados_etapa["etapa"];

//SELECIONA OS ALUNOS
$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.id_turma = $id_turma 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");


//PEGA OS DADOS DA TURMA
$turma_pesq2 = mysql_query("SELECT * FROM ced_turma WHERE  id_turma = $id_turma");
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
$min_freq = $dados_turma2["min_freq"];



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
$contar_resultado = 0;

$sql2 = mysql_query("SELECT ctd.* FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON ctd.disciplina = d.cod_disciplina AND ct.anograde = d.anograde
WHERE d.base_ensino = 1 AND ct.id_turma = $id_turma
ORDER BY d.disciplina");
$count2 = mysql_num_rows($sql2);


//PEGA NOME DA BASE
$id_base_1 = 1;
$sql_base = mysql_query("SELECT * FROM ced_base_ensino WHERE id_base = $id_base_1");
$dados_base = mysql_fetch_array($sql_base);
$nome_base = $dados_base["base_ensino"];
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
                              <b>Ata de Resultados</b>
                          </header>
                        <div class="panel-body">
<table width="100%" border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">

    
    <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th align="center" colspan="<?php echo $count2;?>">Ata de Resultados Finais - <?php echo $nome_etapa?></th>
    </tr>
    
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Ano/Módulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
	</table>
    
<table width="100%" border="1">
    <tr style="line-height:20px">
    	<td class="diario_frequencia_header" colspan="2"><div align="center" class=""><strong></strong></div></td>
        <td class="diario_frequencia_header" colspan="60"><div align="center"  class=""><strong><?php echo $nome_base;?></strong></div></td>
        </tr>
        
    <tr style="line-height:10px">
    	<td class="diario_frequencia_header" rowspan="2"><div align="center" class=""><strong>N&ordm;</strong></div></td>
        <td class="diario_frequencia_header" rowspan="2" width="20%"><div align="center"  class=""><strong>Nome</strong></div></td>
        
        
<?php 


if ($count2 == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
	
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados2 = mysql_fetch_array($sql2)) {
        // enquanto houverem resultados...
		$cod_tdisc = $dados2["codigo"];
		$cod_disciplina = $dados2["disciplina"];
		$ano_grade = $dados2["ano_grade"];
		$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina ='$cod_disciplina' AND anograde= '$ano_grade' AND base_ensino = 1 ORDER BY disciplina");
		$dados_disc = mysql_fetch_array($sql_disc);
		$nome_disciplina = $dados_disc["disciplina"];
		$ch_disciplina = $dados_disc["ch"];
        echo "
		<td colspan=\"2\" class=\"diario_frequencia_header\" width=\"70px\"><div align=\"center\" class=\"diario_frequencia_header\"><strong>$nome_disciplina</strong></div><br>
		
		</td>
	
		
		
		
		\n";
    }
	echo "<td colspan=\"2\" style=\"line-height:10px\" width=\"70px\"><div align=\"center\" class=\"diario_frequencia_header\"><strong>Resultado</strong></div>
		
		</td>";
	$contador = $count2;
	//<td rowspan=\"2\"><div align=\"center\" class=\"\"><strong>Resultado</strong></div>
	echo "
	
	</td><tr style=\"line-height:10px\">";
	 while ($contador >=1) {
		 echo"
  <td class=\"diario_frequencia_header\" align=\"center\" bgcolor=\"#FFFAFA\"><b>Faltas</b></td>
  <td class=\"diario_frequencia_header\" align=\"center\" bgcolor=\"#F5F5F5\"><b>Nota</b></td>";
  $contador -=1;
  }
  echo "<td colspan=\"2\" style=\"line-height:10px\" width=\"70px\"><div align=\"center\" class=\"diario_frequencia_header\"><strong>--</strong></div>
		
		</td>";
}
;?>
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
		//verifica cancelados
		$sql_cancelados = mysql_query("SELECT toc.nome, oco.data FROM ocorrencias oco
	INNER JOIN tipo_ocorrencia toc
	ON oco.n_ocorrencia = toc.id
	WHERE oco.n_ocorrencia = 1 AND oco.matricula = $codigo AND oco.id_turma = $id_turma LIMIT 1");
		if(mysql_num_rows($sql_cancelados)>=1){
			$dados_cancelados = mysql_fetch_array($sql_cancelados);
			$nome_ocorrencia = $dados_cancelados["nome"];
			$data_ocorrencia = format_data($dados_cancelados["data"]);
			$cancelado_observacao .= "Aluno(a) $nome, nº de matricula $codigo foi $nome_ocorrencia em $data_ocorrencia.<br>";
		}
		
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr style=\"line-height:10px\">
		<td style=\"font-size:07px;\"><b><center>$exib_i</b></center></td>
		<td style=\"font-size:07px;\"><b>$nome</b></td>
		
		
		\n";
		
		//verifica ocorrencias	
		$sql_cancel = mysql_query("SELECT * FROM ocorrencias WHERE matricula = $codigo AND id_turma = $id_turma AND (n_ocorrencia = 1 OR n_ocorrencia = 2 OR n_ocorrencia = 10) LIMIT 1");
		$count_cancel = mysql_num_rows($sql_cancel);
	
		if($count_cancel >=1){
			$dados_cancel = mysql_fetch_array($sql_cancel);
			$data_cancel = substr($dados_cancel["data"],8,2)."/".substr($dados_cancel["data"],5,2)."/".substr($dados_cancel["data"],0,4);
			$id_ocorrencia = $dados_cancel["n_ocorrencia"];
			$sql_ocorrencia = mysql_query("SELECT * FROM tipo_ocorrencia WHERE id = $id_ocorrencia");
			$dados_ocorrencia = mysql_fetch_array($sql_ocorrencia);
			$nome_ocorrencia = $dados_ocorrencia["nome"];
			$contador2 = $count2*2 +1;
			echo "<td colspan=\"$contador2\" class=\"diario_frequencia_corpo\" align=\"center\">$nome_ocorrencia em $data_cancel</td>";
		} else {
		//PEGA OS DADOS DAS DISCIPLINAS
		$sql3 = mysql_query("SELECT ctd.* FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON ctd.disciplina = d.cod_disciplina AND ct.anograde = d.anograde
WHERE d.base_ensino = 1 AND ct.id_turma = $id_turma
ORDER BY d.disciplina");
		while ($dados3 = mysql_fetch_array($sql3)) {
        // enquanto houverem resultados...
			$cod_tdisc2 = $dados3["codigo"];
			$cod_disciplina2 = $dados3["disciplina"];
			$ano_grade2 = $dados3["ano_grade"];
			//PEGA AS NOTAS DA DISCIPLINA
			$pesq_nota = mysql_query("
SELECT sum(t1.nota) as notafinal FROM 
					(SELECT DISTINCT cn.matricula, cn.ref_ativ, cn.turma_disc, cn.grupo, cn.nota FROM 
ced_notas cn
INNER JOIN ced_turma_ativ cta
ON cta.ref_id = cn.ref_ativ
INNER JOIN ced_desc_nota cdn
ON cdn.codigo = cta.cod_ativ
WHERE cn.matricula = $codigo AND cn.turma_disc = $cod_tdisc2 AND cdn.subgrupo <> 'C'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
AND cta.id_etapa = $etapa) t1
			");
			$dados_nota2 = mysql_fetch_array($pesq_nota);
			$nota1 = $dados_nota2["notafinal"];
			if($nota1 < $min_nota){
				$pesq_rec = mysql_query("SELECT SUM(nota) as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $cod_tdisc2 AND grupo = 'C'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ  WHERE id_etapa = $etapa)");
				$dados_rec = mysql_fetch_array($pesq_rec);
				$nota_final1 = $dados_rec["notafinal"];
			} else {
				$nota_final1 = $nota1;
			}
			
			if($nota_final1 <= $nota1){//verifica se a nota da recuperação é menor que soma das notas
				$nota_final1 = $nota1;
			}
			
			$nota_final = number_format($nota_final1, 2, ',', '');
			
			
			
			//PEGA AS FALTAS
			$sql_falta = mysql_query("SELECT COUNT(*) as falta_total FROM ced_falta_aluno WHERE matricula = '$codigo' AND turma_disc = '$cod_tdisc2' AND status LIKE 'F' AND data IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$cod_tdisc2');");
			$dados_falta = mysql_fetch_array($sql_falta);
			$falta         = $dados_falta["falta_total"];
			
			if($nota_final1 >=$min_nota&&$falta<=(($min_freq*$ch_disciplina)/100)){
				$contar_resultado +=1;	
			} else {
				$contar_resultado +=0;	
			}
		
			echo "<td class=\"diario_frequencia_corpo\" align=\"center\" bgcolor=\"#FFFAFA\">$falta</td>
			
			<td class=\"diario_frequencia_corpo\" align=\"center\" bgcolor=\"#F5F5F5\">$nota_final</td>";
		}
		// exibi resultado final
		if($contar_resultado >= $count2){
			$exibir_resultado = "Aprovado";
		} else {
			$exibir_resultado = "Reprovado";
		}
			
		
		echo "<td class=\"diario_frequencia_corpo\" align=\"center\" bgcolor=\"#F5F5F5\" colspan=\"2\">$exibir_resultado</td>";
		$contar_resultado = 0;
	}
} //fecha tudo
}
?>
</form>
</table>

<table class="full_table_list" width="100%" border="1" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<tr>
<td colspan="4" align="center"><div style="font-size:10px; font-family:Arial, Helvetica, sans-serif">OBSERVA&Ccedil;&Otilde;ES</div></td>
</tr>
<tr class="diario_frequencia_corpo"><td colspan="4"><?php echo $cancelado_observacao;?></td></tr>
<?php
$p_obs = mysql_query("SELECT * FROM ced_turma_obs WHERE id_turma = $id_turma AND matricula = 0");
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