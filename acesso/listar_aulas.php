<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$turma_d = $_GET["id"];
$id_turma = $_GET["id_turma"];

$sql = mysql_query("SELECT * FROM v_aluno_disc WHERE turma_disc = $turma_d ORDER BY nome");

//PEGA O CODIGO E GRUPO DA TURMA
$turma_pesq1 = mysql_query("select * from ced_view_tdt where codigo LIKE '$turma_d'");
$dados_turma1 = mysql_fetch_array($turma_pesq1);
$grupo_turma = $dados_turma1["grupo"];
$cod_turma = $dados_turma1["codturma"];
$cod_disciplina = $dados_turma1["disciplina"];
$grade_disciplina = $dados_turma1["ano_grade"];
$cod_prof = $dados_turma1["cod_prof"];

//PEGA O NOME DO PROFESSOR
$prof_pesq = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = $cod_prof");
$dados_prof = mysql_fetch_array($prof_pesq);
$nome_professor = $dados_prof["nome"];


//PEGA OS DADOS DA TURMA
$turma_pesq2 = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma2 = mysql_fetch_array($turma_pesq2);
$cod_turma = $dados_turma2["cod_turma"];
$grupo_turma = $dados_turma2["grupo"];
$nivel_turma = $dados_turma2["nivel"];
$curso_turma = $dados_turma2["curso"];
$modulo_turma = $dados_turma2["modulo"];
$turno_turma = $dados_turma2["turno"];
$unidade_turma = $dados_turma2["unidade"];
$polo_turma = $dados_turma2["polo"];
$inicio_turma = $dados_turma2["inicio"];
$fim_turma = $dados_turma2["fim"];


//PEGA OS DADOS DA DISCIPLINA
$disc_pesq = mysql_query("SELECT * FROM disciplinas WHERE anograde = '$grade_disciplina' AND cod_disciplina = '$cod_disciplina'");
$dados_disc = mysql_fetch_array($disc_pesq);
$nome_disciplina = $dados_disc["disciplina"];
$nome_disciplina2 = $dados_disc["disciplina"];
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
                              <a href="#"><span class="label label-danger">Registro de Frequência</span></a>
                              <a href="listar_notas.php?id=<?php echo $turma_d?>&id_turma=<?php echo $id_turma;?>"><span class="label label-inverse">Registro de Notas</span></a>
                          </header>
                          <div class="panel-body">
<form action="#"  method="post">

<table width="100%" border="1" class="full_table_list" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
    
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Módulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>C&oacute;d. Turma:<br /><?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina2);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
    
<table width="100%" border="1" class="full_table_list"  style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<tr style="font-size:12px;">
<td><div align="center"><strong>N&ordm; Aula</strong></div></td>
<td><div align="center"><strong>Data / Aula</strong></div></td>
<td><div align="center"><strong>Frequ&ecirc;ncia</strong></div></td>
<td><div align="center"><strong>Visualizar Di&aacute;rio</strong></div></td>
</tr>	

<?php 
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = 1;
    while ($ch_contar <= $ch_disciplina) {
		//VERIFICAR DATA DA AULA E LANÇA
		$data_sql = mysql_query("SELECT * FROM ced_data_aula WHERE n_aula = $ch_contar AND turma_disc = '$turma_d'");
		$data_dados = mysql_fetch_array($data_sql);
		$exibir_data = substr($data_dados["data_aula"],8,2)."/".substr($data_dados["data_aula"],5,2)."/".substr($data_dados["data_aula"],0,4);
		$exibir_data2 = $data_dados["data_aula"];
		if($exibir_data =="//"){
			$exibir_data = "----";
			$exibir_frequencia = "Aula ainda não registrada.";
			$cad_aula = "<div align=\"center\"><font size=\"+1\"><strong><a rel=\"shadowbox\" href=\"cad_aula.php?aula=$ch_contar&td=$turma_d&prof=$nome_professor&disciplina=$nome_disciplina&curso=$curso_turma&cod_disc=$cod_disciplina&anograde=$grade_disciplina\"><div class=\"tooltips\" data-placement=\"right\" data-original-title=\"Registrar Aula $ch_contar\">$ch_contar</div></a></font></strong></div>";
		} else {
			$exibir_frequencia = "<a rel=\"shadowbox\"  href=\"lancar_falta.php?n_aula=$ch_contar&data_aula=$exibir_data2&td=$turma_d\"><font size=\"+1\"><div class=\"fa fa- fa-building-o tooltips\" data-placement=\"top\" data-original-title=\"Registrar Frequência\"></div></font></a>
			
			<a target=\"_blank\"  href=\"exibir_diario2.php?id=$turma_d&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa- fa-building-o tooltips\" data-placement=\"top\" data-original-title=\"Diário Digital (Frequência)\"></div></font></a>";
			$cad_aula = "<div align=\"center\"><font size=\"+1\"><strong>$ch_contar</font></strong></div>";
		}
		if($exibir_data != "----"){
			$exibir_data = "<a rel=\"shadowbox\" href=\"alterar_aula.php?aula=$ch_contar&td=$turma_d&prof=$nome_professor&disciplina=$nome_disciplina&curso=$curso_turma&cod_disc=$cod_disciplina&anograde=$grade_disciplina\"/>".$exibir_data."</a>";
		}
        // enquanto houverem resultados...
        echo "<tr>
		<td>$cad_aula
		</td>
		<td><div align=\"center\"><font size=\"+1\"><b>$exibir_data</b></font></div></td>
		<td><div align=\"center\">$exibir_frequencia</td>
		<td align=\"center\"><a rel=\"shadowbox\" href=\"exibir_diario.php?id=$turma_d&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa- fa-building-o tooltips\" data-placement=\"top\" data-original-title=\"Diário de Frequências\"></div></font></a>
		<a rel=\"shadowbox\" href=\"exibir_notas.php?id=$turma_d&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa- fa-plus-square tooltips\" data-placement=\"top\" data-original-title=\"Diário de Notas\"></div></font></a>
		<a rel=\"shadowbox\" href=\"exibir_conteudo.php?id=$turma_d&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa- fa-list-alt tooltips\" data-placement=\"top\" data-original-title=\"Conteúdos\"></div></font></a></td>
		</tr>
		\n";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
;?>
    
    
</form>
</table>
</div>
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
