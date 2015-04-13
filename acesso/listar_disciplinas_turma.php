<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$id_turma = $_GET["id_turma"];
//PESQUISA A TURMA
$turma_pesq = mysql_query("SELECT * FROM ced_turma WHERE id_turma = '$id_turma'");
$dados_turma = mysql_fetch_array($turma_pesq);
$cod_turma = $dados_turma["cod_turma"];
$nivel = $dados_turma["nivel"];
$curso = $dados_turma["curso"];
$modulo = $dados_turma["modulo"];
$unidade = $dados_turma["unidade"];
$polo = $dados_turma["polo"];
$turno = $dados_turma["turno"];
$grupo = $dados_turma["grupo"];
$anograde = $dados_turma["anograde"];
$tipo_etapa = $dados_turma["tipo_etapa"];


if($_SERVER["REQUEST_METHOD"]=="POST"){
	for( $i = 0 , $x = count( $_POST[ 'turma_disc' ] ) ; $i < $x ; ++ $i ) {
		$post_inicio = $_POST["data_inicio"][$i]." 00:00:00";
		$post_fim = $_POST["data_fim"][$i]." 23:59:59";
		$post_disc =  $_POST["turma_disc"][$i];
		mysql_query("UPDATE ced_turma_disc SET inicio = '".$post_inicio."', fim = '".$post_fim."' WHERE codigo = '".$_POST[ 'turma_disc' ][ $i ]."'");
	}
	echo "
	<script language=\"javascript\">
	alert('Datas atualizadas com sucesso!');
	</script>
	";
}
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
                              <b>Disciplinas / Turma
                              <br><font size="-1"><strong>Turma:</strong> <?php echo "[".$cod_turma."] ".strtoupper($nivel).": ".strtoupper($curso)." - (MOD. ".strtoupper($modulo).") - ".strtoupper($unidade)." / ".strtoupper($polo)." - ".$grupo;?></font></b>
                          </header>
                          <div class="panel-body">
                          <a rel="shadowbox" href="rel_alunos_turma.php?id=<?php echo $id_turma;?>" target="_blank">Lista de Assinatura</a></br>

<?php
$sql_etapas = mysql_query("SELECT * FROM ced_etapas WHERE tipo_etapa LIKE '%$tipo_etapa%'");
while($dados_etapas = mysql_fetch_array($sql_etapas)){
	$etapa_id = $dados_etapas["id_etapa"];
	$etapa_nome = $dados_etapas["etapa"];
	
	echo "<a href=\"nova_ata.php?id=$id_turma&etapa=$etapa_id\" target=\"_blank\">ATA DE RESULTADOS - $etapa_nome</a></br>";
}

if($tipo_etapa == 2){
	echo "<a target=\"_blank\" href=\"exibir_ata_final.php?id=$id_turma\">ATA DE RESULTADOS FINAIS</a></br>";
}
?>
<form id="form1" name="form1" method="POST" >
<?php
//SEPARA DISCIPLINAS POR BASE DE ENSINO
$sql_base_ensino = mysql_query("SELECT * FROM ced_base_ensino");

if(mysql_num_rows($sql_base_ensino)==0){
	echo "<script language=\"javascript\">
	alert('Erro. Nenhuma disciplina encontrada, tente novamente, caso o erro persista entre em contato com o administrador do sistema.');
	</script>";	
} else {
	while($dados_base = mysql_fetch_array($sql_base_ensino)){
		$id_base_ensino = $dados_base["id_base"];
		$base_ensino = $dados_base["base_ensino"];
		//PESQUISA AS DISCIPLINAS
		$sql_completo = "SELECT DISTINCT ct.*, ctd.codigo as turma_disc, d.disciplina, d.anograde,d.ch, ctd.cod_prof, ctd.inicio, ctd.fim
		FROM ced_turma_disc ctd
		INNER JOIN ced_turma ct
		ON ctd.id_turma = ct.id_turma
		INNER JOIN disciplinas d
		ON d.anograde = ct.anograde AND ctd.disciplina = d.cod_disciplina
		WHERE ct.id_turma = $id_turma AND d.base_ensino = $id_base_ensino
		ORDER BY ctd.inicio, ctd.fim, d.disciplina
		";
		$sql_disciplinas = mysql_query($sql_completo);
		$count = mysql_num_rows($sql_disciplinas);
		
?>
<table width="100%" border="1" class="full_table_list" style="font-size:12px">

<?php
//continua o while
// conta quantos registros encontrados com a nossa especifica��o
		if ($count == 0) {
		} else {
			// sen�o
			// se houver mais de um resultado diz quantos resultados existem
			echo "<tr bgcolor=\"#D4D4D4\">
    	<td align=\"center\" colspan=\"8\"><div align=\"center\"><font size=\"+1\"><strong>$base_ensino</strong></font></div></td> 
	</tr>
	<tr bgcolor=\"#D4D4D4\">
    	<td width=\"30%\"><div align=\"center\"><strong>Disciplina</strong></div></td>
        <td><div align=\"center\"><strong>Carga Hor&aacute;ria</strong></div></td>
        <td><div align=\"center\"><strong>Professor / Tutor</strong></div></td>
        <td><div align=\"center\"><strong>Di&aacute;rio Online</strong></div></td>
        <td><div align=\"center\"><strong>Avalia&ccedil;&atilde;o Online</strong></div></td>
        <td><div align=\"center\"><strong>Senha</strong></div></td>  
        <td><div align=\"center\"><strong>In&iacute;cio</strong></div></td>  
        <td><div align=\"center\"><strong>Fim</strong></div></td>  
	</tr>";
			while ($dados = mysql_fetch_array($sql_disciplinas)) {
				// enquanto houverem resultados...
				$codigo	   = $dados["turma_disc"];
				$ano_grade	   = $dados["ano_grade"];
				$cod_prof	   = $dados["cod_prof"];
				$exib_data_inicio	   = substr($dados["inicio"],0,10);
				$exib_data_fim	   = substr($dados["fim"],0,10);
				$disciplina = $dados["disciplina"];
				$ch = $dados["ch"];
				
				$sql_questionario = mysql_query("select * from ea_questionario WHERE turma_disc = '$codigo' LIMIT 1");
				if(mysql_num_rows($sql_questionario)==0){
					$exib_senha = "--";	
					$link_senha = "javascript:alert('Prova ainda n�o agendada');";
				} else {
					$dados_questionario = mysql_fetch_array($sql_questionario);
					$exib_senha = $dados_questionario["senha"];
					$id_questionario = $dados_questionario["id_questionario"];
					$link_senha = "javascript:abrir('resetar_senha_avaliacao.php?id=$id_questionario');";
				}
				
				if($cod_prof == 0){
					$nome_prof = '[DEFINIR]';
					
				} else {
					$prof_pesq = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$cod_prof'");
					$dados_prof = mysql_fetch_array($prof_pesq);
					$nome_prof = strtoupper(substr($dados_prof["nome"],0,10))."...";
				}
				
		
				
				echo "
			<tr>
				<td><a href=\"listar_aulas.php?id=$codigo&id_turma=$id_turma\">$disciplina</a></td>
				<td><center>$ch</center></td>
				<td><center><a rel=\"shadowbox\" href=\"definir_professor.php?id=$codigo\">$nome_prof</center></a></td>
				<td><div align=\"center\">
				<a target=\"_blank\" href=\"exibir_diario_impresso.php?id=$codigo&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa- fa-building-o tooltips\" data-placement=\"right\" data-original-title=\"Di�rio de Frequ�ncias\"></div></font></a>
				<a rel=\"shadowbox\" href=\"exibir_notas.php?id=$codigo&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa- fa-plus-square tooltips\" data-placement=\"right\" data-original-title=\"Di�rio de Notas\"></div></font></a>
				<a rel=\"shadowbox\" href=\"exibir_conteudo.php?id=$codigo&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa- fa-list-alt tooltips\" data-placement=\"right\" data-original-title=\"Conte�dos\"></div></font></a>
				<a rel=\"shadowbox\" href=\"exibir_forum_comentarios.php?id=$codigo&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa- fa-comments tooltips\" data-placement=\"right\" data-original-title=\"F�rum EAD\"></div></font></a>
				</td>
				<td><center>
				<a rel=\"shadowbox\" href=\"abrir_avaliacao.php?turma_disc=$codigo\"><font size=\"+1\"><div class=\"fa fa-calendar tooltips\" data-placement=\"right\" data-original-title=\"Agendar Avalia��o\"></div></font></a>
		</td>
				<td><center><a href=\"$link_senha\">$exib_senha</center></a></td>
				<td><center><input type=\"hidden\" name=\"turma_disc[]\" value=\"$codigo\">
				<input type=\"date\" name=\"data_inicio[]\" value=\"$exib_data_inicio\"></td>
				<td><center><input type=\"date\" name=\"data_fim[]\" value=\"$exib_data_fim\"></td>\n";

			}
		}
		echo "</table><br>";
	}
	
}
?>


<br><br>
<center><input type="submit" value="Atualizar Datas"></center>
</form>

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
					$('#curso').html('<option value="">� Selecione o Curso �</option>');
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
