<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$turma_d = $_GET["id"];
$id_turma = $_GET["id_turma"];

//SELECIONA OS ALUNOS

$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");

//PEGA O CODIGO E GRUPO DA TURMA
$turma_pesq1 = mysql_query("SELECT disciplina, ano_grade, cod_prof FROM ced_turma_disc WHERE codigo = $turma_d");
$dados_turma1 = mysql_fetch_array($turma_pesq1);
$cod_disciplina = $dados_turma1["disciplina"];
$grade_disciplina = $dados_turma1["ano_grade"];
$cod_prof = $dados_turma1["cod_prof"];

//PEGA O NOME DO PROFESSOR
$prof_pesq = mysql_query("SELECT nome FROM cliente_fornecedor WHERE codigo = $cod_prof");
$dados_prof = mysql_fetch_array($prof_pesq);
$nome_professor = $dados_prof["nome"];


//PEGA OS DADOS DA TURMA
$turma_pesq2 = mysql_query("SELECT cod_turma, grupo, nivel, curso, modulo, unidade, polo, inicio, fim, tipo_etapa FROM ced_turma WHERE id_turma = $id_turma");
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
$tipo_etapa = $dados_turma2["tipo_etapa"];

//PEGA AS ETAPAS EXISTENTES NA TURMA
$sql_etapa_atividades = mysql_query("SELECT id_etapa, etapa, cor_etapa, min_nota, max_nota, grupos_ativ FROM ced_etapas WHERE tipo_etapa LIKE '%$tipo_etapa%'");
$sql_etapa_nome = mysql_query("SELECT id_etapa, etapa, cor_etapa, min_nota, max_nota, grupos_ativ FROM ced_etapas WHERE tipo_etapa LIKE '%$tipo_etapa%'");



//PEGA OS DADOS DA DISCIPLINA
$disc_pesq = mysql_query("SELECT disciplina, ch FROM disciplinas WHERE anograde = '$grade_disciplina' AND cod_disciplina = '$cod_disciplina'");
$dados_disc = mysql_fetch_array($disc_pesq);
$nome_disciplina = $dados_disc["disciplina"];
$ch_disciplina = $dados_disc["ch"];


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
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
                              <a href="listar_aulas.php?id=<?php echo $turma_d?>&id_turma=<?php echo $id_turma;?>"><span class="label label-inverse">Registro de Frequ&ecirc;ncia</span></a>
                              <a href="#"><span class="label label-danger">Registro de Notas</span></a>
                          </header>
                          <div class="panel-body">
<?php
$sql2 = mysql_query("SELECT atividade, grupo, subgrupo,max_nota FROM ced_desc_nota WHERE subgrupo LIKE '0'");
$count2 = mysql_num_rows($sql2) * mysql_num_rows($sql_etapa_atividades);
?>

<form action="#"  method="post">
<table width="100%" border="1" class="full_table_list" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">

    
    <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count2;?>">Registro de Avalia&ccedil;&otilde;es e Resultado</th>
    </tr>
    
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Módulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Turma:<br /><?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table width="100%" border="1" class="full_table_list"  style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<tr style="font-size:12px;">
	<td width="50px"><div align="center"></div></td>
     <td width="300px"><div align="center"></div></td>
     <?php
	 while($dados_etapa = mysql_fetch_array($sql_etapa_nome)){
		 $etapa_nome = $dados_etapa["etapa"];
		 $etapa_cor = $dados_etapa["cor_etapa"];
		 $colspan_etapa = 4;
		 $etapa_id = $dados_etapa["id_etapa"];	
		 $link_etapa = "$etapa_nome";
		$rowspan = 0;
		if($etapa_id == 3){
			$colspan_etapa = 3;	
		}
		if($etapa_id == 5){
			$colspan_etapa = 1;	
			$rowspan = 2;
			$link_etapa = "<a rel=\"shadowbox\" href=\"lancar_atividade.php?ativ=C&turma=$turma_d&grupo=$grupo_turma\">$etapa_nome</a>";
		}
		 echo "<td bgcolor=\"$etapa_cor\" rowspan=\"$rowspan\" colspan=\"$colspan_etapa\"><center><b>$link_etapa</b></center></td>";
	 }
	 
	 ?>
</tr>
    <tr style="font-size:10px;">
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
		$etapa_id = $dados_etapa["id_etapa"];
		$etapa_ativs = $dados_etapa["grupos_ativ"];
		$sql2 = mysql_query("SELECT codigo, grupo, atividade, max_nota FROM ced_desc_nota WHERE subgrupo LIKE '0' AND  grupo IN ($etapa_ativs)");
		while ($dados2 = mysql_fetch_array($sql2)) {
			// enquanto houverem resultados...
			$cod_atividade = $dados2["codigo"];
			$grupo_ativi = $dados2["grupo"];
			$atividade = $dados2["atividade"];
			$max_nota_ativ = $dados2["max_nota"];
			if($etapa_id != 5){
				echo "
				<td bgcolor=\"$etapa_cor\"><div align=\"center\"><strong><a rel=\"shadowbox\" href=\"lancar_atividade.php?ativ=$grupo_ativi&turma=$turma_d&grupo=$grupo_turma\">$atividade</a></strong></div></td>
			
			\n";
			}
		}
		if($etapa_id != 5){
			echo "<td align=\"center\" bgcolor=\"$etapa_cor\"><b>Nota Parcial</b></td>";
		}
	}
	
}
;?>
<td bgcolor="#EEEE0" align="center"><b>Nota Final</b></td>
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
		$sql_foto = mysql_query("SELECT foto_academica FROM acessos_completos WHERE usuario = $codigo");
		$dados_foto = mysql_fetch_array($sql_foto);
		$foto_academica = $dados_foto["foto_academica"];
		
		$nota_parcial = 0;
		
		
		$i +=1;

		
        echo "
	<tr>
		<td><b><center>$i</b></center></td>
		<td style=\"font-size:10px\"><a style=\"color:black;text-decoration:none;\" onDblClick=\"mostrarElemento('$img_aluno', 'inline');\" 
        onMouseOut=\"mostrarElemento('$img_aluno', 'none');\">$nome</a>
		<div id=\"$img_aluno\" style=\"display:none; position:fixed;\"><img src=\"$foto_academica\"/></div>
		</td>
		
		
		\n";
				
		//pega notas por etapa
		$sql_etapa_notas = mysql_query("SELECT id_etapa, cor_etapa, min_nota FROM ced_etapas WHERE tipo_etapa LIKE '%$tipo_etapa%'");
		$nota_final = 0;
		//VERIFICA SE ALUNO ESTÁ CANCELADO E EXIBE O STATUS
			$sql_cancelados = mysql_query("SELECT toc.nome, oco.data FROM ocorrencias oco
INNER JOIN tipo_ocorrencia toc
ON oco.n_ocorrencia = toc.id
WHERE oco.n_ocorrencia = 1 AND oco.matricula = $codigo AND oco.id_turma = $id_turma LIMIT 1");
			if(mysql_num_rows($sql_cancelados)>=1){
				$dados_cancelados = mysql_fetch_array($sql_cancelados);
				$nome_ocorrencia = $dados_cancelados["nome"];
				$data_ocorrencia = format_data($dados_cancelados["data"]);
				echo "<td align=\"center\" colspan=\"$count3\">$nome_ocorrencia em $data_ocorrencia.</td></tr>";
			} else {
		while($dados_etapa = mysql_fetch_array($sql_etapa_notas)){
			$etapa_id = $dados_etapa["id_etapa"];
			$etapa_cor = $dados_etapa["cor_etapa"];
			$etapa_min_nota = $dados_etapa["min_nota"];
			$sql2 = mysql_query("SELECT codigo, grupo, atividade, max_nota FROM ced_desc_nota WHERE subgrupo LIKE '0'");
			$count2 = mysql_num_rows($sql2);
			$count3= $count2+12;
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
						
						//NOTA DE RECUPERAÇÃO FINAL
						$pesq_nota_f = mysql_query("
						SELECT SUM(cn.nota)as notafinal FROM 
	ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	INNER JOIN ced_desc_nota cdn
	ON cdn.codigo = cta.cod_ativ
	WHERE cn.matricula = $codigo AND cn.turma_disc = $turma_d AND cdn.subgrupo = 'C'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
	AND cta.id_etapa = 5");
						$dados_nota_f = mysql_fetch_array($pesq_nota_f);
						$nota_aluno_f = $dados_nota_f["notafinal"];
						
						
						//NOTAS DE RECUPERAÇÃO
						$pesq_notas_recuperação = mysql_query("
						SELECT SUM(cn.nota)as notafinal FROM 
	ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	INNER JOIN ced_desc_nota cdn
	ON cdn.codigo = cta.cod_ativ
	WHERE cn.matricula = $codigo AND cn.turma_disc = $turma_d AND cdn.subgrupo = 'C'  AND cn.ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)
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
						if($etapa_id != 5){
							$nota_final += str_replace(",",".",$exibir_nota_parcial)/3;
						}						
						$exibir_nota_final = format_valor($nota_final);
						if($etapa_id != 3&&$grupo_ativi != "C"&&$etapa_id != 5){
							echo "
							<td bgcolor=\"$etapa_cor\" align=\"center\"><a target=\"blank\" href=\"lancar_nota.php?td=$turma_d&etapa=$etapa_id\">$nota_aluno</a></b></td>";
						}
						if($etapa_id != 3&&$grupo_ativi == "C"&&$etapa_id != 5){
							echo "
							<td bgcolor=\"$etapa_cor\" align=\"center\"><a target=\"blank\" href=\"lancar_nota.php?td=$turma_d&etapa=$etapa_id\">$nota_aluno</a></b></td>";
						}
						if($etapa_id == 3&&$grupo_ativi != "C"&&$etapa_id != 5){
							echo "
							<td bgcolor=\"$etapa_cor\" align=\"center\"><a target=\"blank\" href=\"lancar_nota.php?td=$turma_d&etapa=$etapa_id\">$nota_aluno</a></b></td>";
						}
					
				}
				echo "<td align=\"center\" bgcolor=\"$etapa_cor\">$exibir_nota_parcial</td>
				";
				
			}
			if($nota_aluno_f > str_replace(",",".",$nota_final)){
				$nota_final = format_valor($nota_aluno_f);
				$exibir_nota_final = $nota_final;
			}
			// exibir a coluna nome e a coluna email
			echo "<td bgcolor=\"#EEEE0\" align=\"center\"><b>$exibir_nota_final </b></td>";
		}
	}
	echo "<tr>
<td colspan=\"$count3\">$count alunos.</td></tr>";
}

?>
</form>
</table>
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

    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#nivel').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">- Selecione o Curso -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">' + j[i].cursoexib + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="">– Selecione o Curso –</option>');
				}
			});
		});
		</script>
        
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
    
    
<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('projeto').disabled = false;  
    } else {  
        document.getElementById('projeto').disabled = true;  
    }  
}  
</script> 
<script language="JavaScript">  
        function mostrarElemento(id, visibilidade) {  
            document.getElementById(id).style.display = visibilidade;  
        }  
    </script>  