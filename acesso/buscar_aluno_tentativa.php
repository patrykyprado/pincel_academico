<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
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
                              <b>Relat&oacute;rio: Tentativas de Provas</b>
                          </header>
                          <div class="panel-body">
<form id="form2" name="form1" method="POST" action="buscar_aluno_tentativa.php">
  Nome:
  <input type="text" name="buscar" value="<?php 
 if(isset($_POST["buscar"])){
	 echo trim($_POST["buscar"]);
 } else {
	  echo "";
 }
 ?>" id="buscar" />
  <input type="submit" name="a" id="a" value="Buscar" />
</form>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$busca = $_POST["buscar"];
	echo "<table class=\"full_table_list\" width=\"100%\" border=\"1\" cellspacing=\"3\">
	<tr bgcolor=\"#D9D9D9\" style=\"font-size:10px\">
		<td><div align=\"center\"><strong>Matr&iacute;cula</strong></div></td>
        <td><div align=\"center\"><strong>Nome</strong></div></td>
        <td><div align=\"center\"><strong>Curso</strong></div></td>
		<td><div align=\"center\"><strong>M&oacute;dulo</strong></div></td>
        <td><div align=\"center\"><strong>Unidade</strong></div></td>
        <td><div align=\"center\"><strong>Polo</strong></div></td>
		<td><div align=\"center\"><strong>Disciplina</strong></div></td>
        <td><div align=\"center\"><strong>Tentativa</strong></div></td>
        <td><div align=\"center\"><strong>Data da Avalia&ccedil;&atilde;o</strong></div></td>
		<td><div align=\"center\"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align=\"center\"><strong>Revisão</strong></div></td>
	</tr>";
	?>
<?php

if($user_unidade ==""){
	$sql = mysql_query("SELECT eqf.matricula, alu.nome, eqf.id_questionario,eaq.cod_disc,ct.anograde, ct.unidade, ct.curso,ct.nivel,ct.modulo, ct.polo, eqf.tentativa, eqf.datahora
FROM ea_q_feedback eqf
INNER JOIN alunos alu
ON alu.codigo = eqf.matricula
INNER JOIN ea_questionario eaq
ON eaq.id_questionario = eqf.id_questionario
INNER JOIN ced_turma_disc ctd
ON ctd.codigo = eaq.turma_disc
LEFT JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
WHERE alu.nome LIKE '%$busca%' OR eqf.matricula LIKE '%$busca%'
GROUP BY eqf.id_questionario, eqf.matricula ORDER BY alu.nome");
} else {
	$sql = mysql_query("SELECT eqf.matricula, alu.nome, eqf.id_questionario,eaq.cod_disc,ct.anograde, ct.unidade, ct.curso,ct.nivel,ct.modulo, ct.polo, eqf.tentativa, eqf.datahora
FROM ea_q_feedback eqf
INNER JOIN alunos alu
ON alu.codigo = eqf.matricula
INNER JOIN ea_questionario eaq
ON eaq.id_questionario = eqf.id_questionario
INNER JOIN ced_turma_disc ctd
ON ctd.codigo = eaq.turma_disc
LEFT JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
WHERE (alu.nome LIKE '%$busca%' OR eqf.matricula LIKE '%$busca%') AND ct.unidade LIKE '%$user_unidade%'
GROUP BY eqf.id_questionario, eqf.matricula ORDER BY alu.nome");}


$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$matricula          = $dados["matricula"];
		$aluno          = $dados["nome"];
		$id_questionario          = $dados["id_questionario"];
		$unidade         = $dados["unidade"];
		$polo         = $dados["polo"];
		$modulo         = $dados["modulo"];
		$curso         = format_curso($dados["curso"]);
		$nivel         = format_curso($dados["nivel"]);
		$cod_disc         = $dados["cod_disc"];
		$tentativa         = $dados["tentativa"];
		$anograde         = $dados["anograde"];
		$datahora         = format_data_hora($dados["datahora"]);
		
		//pega o nome da disciplina
		$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$cod_disc%' AND anograde LIKE '%$anograde%'");
		$dados_disc = mysql_fetch_array($sql_disc);
		$nome_disciplina = $dados_disc["disciplina"];


        echo "<tr>
		<td><div align=\"center\"><strong>$matricula</strong></div></td>
        <td><div>$aluno</div></td>
        <td><div>$nivel: $curso</strong></div></td>
		<td><div>$modulo</strong></div></td>
        <td><div>$unidade</div></td>
        <td><div>$polo</div></td>
		<td><div>$nome_disciplina</div></td>
        <td><div align=\"center\">$tentativa</div></td>
        <td><div align=\"center\">$datahora</div></td>
		<td><div align=\"center\"><strong>		
		<a rel=\"shadowbox\" href=\"excluir_tentativa.php?matricula=$matricula&tentativa=$tentativa&questionario=$id_questionario\"><font size=\"+1\"><div class=\"fa fa-trash-o tooltips\" data-placement=\"right\" data-original-title=\"Excluir Tentativa\"></div></font></a>
		</div></td>
		<td><div align=\"center\"><strong>		
		<a rel=\"shadowbox\" href=\"revisao_prova.php?matricula=$matricula&tentativa=$tentativa&questionario=$id_questionario\"><font size=\"+1\"><div class=\"fa fa-eye tooltips\" data-placement=\"right\" data-original-title=\"Visualizar Tentativa de Prova\"></div></font></a>
		</div></td>
	
		</tr>
		\n";
        // exibir a coluna nome e a coluna email
    }
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
        
        
