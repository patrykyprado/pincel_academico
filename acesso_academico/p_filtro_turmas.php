<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$buscar = $_GET["grupo"];

$sql = mysql_query("SELECT ct.*, ctd.* FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
 WHERE ct.grupo LIKE '%$buscar%' AND ctd.cod_prof = '$user_usuario' ORDER BY d.disciplina");

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
                              <b>Turmas</b>
                          </header>
                          <div class="panel-body">
<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr>
    	<td><div align="center"><strong>Turma</strong></div></td>
        <td><div align="center"><strong>Disciplina</strong></div></td>
		<td><div align="center"><strong>Carga Hor&aacute;ria</strong></div></td>
        <td><div align="center"><strong>Di&aacute;rio</strong></div></td>
        <td><div align="center"><strong>Avalia&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>Sala Virtual</strong></div></td>
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
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$cod_turma	   = $dados["codturma"];
		$turma_disciplina	   = $dados["codigo"];
		$cod_disciplina	   = $dados["disciplina"];
		$ano_grade	   = $dados["ano_grade"];
		$id_turma	   = $dados["id_turma"];
		$encerrado	   = $dados["encerrado"];
		
		//PEGA DADOS DO AGRUPAMENTO SE TIVER
		$sql_agrupamento = mysql_query("SELECT * FROM agrupamentos WHERE disciplinas LIKE '%$turma_disciplina%'");
		if(mysql_num_rows($sql_agrupamento)==0){
			$nome_agrupamento = "[Acessar]";
		} else {
			$dados_agrupamento = mysql_fetch_array($sql_agrupamento);
			$nome_agrupamento = "[".$dados_agrupamento["agrupamento"]."]";	
		}
		
		//DADOS DA TURMA
		$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE anograde LIKE '%$ano_grade%' AND cod_turma = '$cod_turma' AND id_turma = $id_turma");
		$dados_turma = mysql_fetch_array($sql_turma);
		$nivel = $dados_turma["nivel"];
		$curso = $dados_turma["curso"];
		$modulo = $dados_turma["modulo"];
		$unidade = $dados_turma["unidade"];
		$polo = $dados_turma["polo"];
		$turno = $dados_turma["turno"];
		$id_turma = $dados_turma["id_turma"];
		$max_alunos = $dados_turma["max_aluno"];
		
		//DADOS DA DISCIPLINA
		$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE anograde LIKE '%$ano_grade%' AND cod_disciplina = '$cod_disciplina' ORDER BY disciplina");
		$dados_disc = mysql_fetch_array($sql_disc);
		$nome_disc = $dados_disc["disciplina"];
		$ch_disc = $dados_disc["ch"];
		if($encerrado == 1) {
			$botao_chamada = "Encerrado";
			$botao_avaliacao = "Encerrado";
			$botao_sala_virtual = "Encerrado";
		} else {
			$botao_chamada = "<a href=\"p_listar_aulas.php?id=$turma_disciplina&id_turma=$id_turma\"><center>Chamada</center></a>";
			$botao_avaliacao = "<a href=\"p_listar_notas.php?id=$turma_disciplina&id_turma=$id_turma\"><center>Avalia&ccedil;&otilde;es</center></a>";
			$botao_sala_virtual = "<a href=\"ea_disciplina.php?turma_disc=$turma_disciplina&coddisc=$cod_disciplina&anograde=$ano_grade\"><center>$nome_agrupamento</center></a>";
		}
		
        echo "
	<tr>
		<td><a href=\"javascript:abrir('p_detalhe_turma.php?id=$cod_turma&turno=$turno&polo=$polo&id_turma=$id_turma')\" >[".$cod_turma."] ".strtoupper($nivel).": ".strtoupper($curso)." - (MOD. ".strtoupper($modulo).") - ".strtoupper($unidade)." / ".strtoupper($polo)."</a></center></a></td>
		<td>$nome_disc </td>
		<td><center>$ch_disc</center></td>
		<td align=\"center\">$botao_chamada</td>
		<td align=\"center\">$botao_avaliacao</td>
		<td align=\"center\">$botao_sala_virtual</td>
		\n";
        
    }
}

?>

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
