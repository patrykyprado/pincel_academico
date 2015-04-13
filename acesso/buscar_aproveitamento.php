<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

//GET
$get_nome = $_GET["nome"];
$get_status = $_GET["status"];
$get_inicio = $_GET["inicio"];
$get_fim = $_GET["fim"];



$sql_base = "SELECT DISTINCT cap.matricula, alu.nome, ct.id_turma, ct.nivel, ct.curso, ct.modulo, ct.grupo,ct.unidade, ct.polo, ct.anograde, cap.data_solicitacao
FROM ced_aproveitamento cap
INNER JOIN alunos alu
ON alu.codigo = cap.matricula
INNER JOIN ced_turma ct
ON ct.id_turma = cap.id_turma";

//MONTA O FILTRO
if(trim($get_nome) == ""){
	$filtro_nome = " WHERE alu.nome LIKE '%%'";	
} else {
	$filtro_nome = " WHERE alu.nome LIKE '%$get_nome%'";	
}

if(trim($get_status) == ""){
	$filtro_status = "";	
} else {
	$filtro_status = " AND cap.status = $get_status";	
}

if(trim($get_inicio) == "" || trim($get_fim) == ""){
	$filtro_data = "";	
} else {
	$filtro_data = " AND cap.data_solicitacao BETWEEN '$get_inicio' AND '$get_fim'";	
}

$filtro_completo = $sql_base.$filtro_nome.$filtro_status.$filtro_data;
$sql_final = mysql_query($filtro_completo);
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                          <header class="panel-heading">
                              <b>Aproveitamento de Estudos</b>
                          </header>
                          <header class="panel-body">
<table class="table table-hover" border="1">
<tr bgcolor="#E1E1E1">
	<td align="center"><b>Matr&iacute;cula</b></td>
    <td align="center"><b>Nome</b></td>
    <td align="center"><b>N&iacute;vel</b></td>
    <td align="center"><b>Curso</b></td>
    <td align="center"><b>M&oacute;dulo</b></td>
    <td align="center"><b>Grupo</b></td>
    <td align="center"><b>Unidade</b></td>
    <td align="center"><b>Polo</b></td>
    <td align="center"><b>Data da Solicita&ccedil;&atilde;o</b></td>
</tr>
<?php

if(mysql_num_rows($sql_final)>=1){
	while($dados_aproveitamento = mysql_fetch_array($sql_final)){
		$aproveitamento_matricula = $dados_aproveitamento["matricula"];	
		$aproveitamento_nome = $dados_aproveitamento["nome"];	
		$aproveitamento_nivel = $dados_aproveitamento["nivel"];	
		$aproveitamento_curso = $dados_aproveitamento["curso"];	
		$aproveitamento_turma = $dados_aproveitamento["id_turma"];	
		$aproveitamento_modulo = $dados_aproveitamento["modulo"];	
		$aproveitamento_grupo = $dados_aproveitamento["grupo"];	
		$aproveitamento_unidade = $dados_aproveitamento["unidade"];	
		$aproveitamento_polo = $dados_aproveitamento["polo"];	
		$aproveitamento_solicitacao = format_data($dados_aproveitamento["data_solicitacao"]);	
		echo "
		<tr>
	<td align=\"center\">$aproveitamento_matricula</td>
    <td><a rel=\"shadowbox\" href=\"ver_aproveitamento.php?matricula=$aproveitamento_matricula&id_turma=$aproveitamento_turma\">$aproveitamento_nome</a></td>
    <td><a rel=\"shadowbox\" href=\"ver_aproveitamento.php?matricula=$aproveitamento_matricula&id_turma=$aproveitamento_turma\">$aproveitamento_nivel</a></td>
    <td><a rel=\"shadowbox\" href=\"ver_aproveitamento.php?matricula=$aproveitamento_matricula&id_turma=$aproveitamento_turma\">$aproveitamento_curso</a></td>
    <td align=\"center\"><a rel=\"shadowbox\" href=\"ver_aproveitamento.php?matricula=$aproveitamento_matricula&id_turma=$aproveitamento_turma\">$aproveitamento_modulo</a></td>
    <td align=\"center\"><a rel=\"shadowbox\" href=\"ver_aproveitamento.php?matricula=$aproveitamento_matricula&id_turma=$aproveitamento_turma\">$aproveitamento_grupo</a></td>
    <td align=\"center\"><a rel=\"shadowbox\" href=\"ver_aproveitamento.php?matricula=$aproveitamento_matricula&id_turma=$aproveitamento_turma\">$aproveitamento_unidade</a></td>
    <td align=\"center\"><a rel=\"shadowbox\" href=\"ver_aproveitamento.php?matricula=$aproveitamento_matricula&id_turma=$aproveitamento_turma\">$aproveitamento_polo</a></td>
    <td align=\"center\"><a rel=\"shadowbox\" href=\"ver_aproveitamento.php?matricula=$aproveitamento_matricula&id_turma=$aproveitamento_turma\">$aproveitamento_solicitacao</a></td>
</tr>";
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
		$(function(){
			$('#cc3').change(function(){
				if( $(this).val() ) {
					$('#cc4').hide();
					$('.carregando').show();
					$.getJSON('cc4.ajax.php?search=',{cc3: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc4 + '">' + j[i].nome_cc4 + '</option>';
						}	
						$('#cc4').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc4').html('<option value="">– CC4 –</option>');
				}
			});
		});
		</script>
        




	    <script type="text/javascript">
		$(function(){
			$('#cc4').change(function(){
				if( $(this).val() ) {
					$('#cc5').hide();
					$('.carregando').show();
					$.getJSON('cc5.ajax.php?search=',{cc4: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc5 + '">' + j[i].nome_cc5 + '</option>';
						}	
						$('#cc5').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc5').html('<option value="">– CC5 –</option>');
				}
			});
		});

function excluir(URL){


if(confirm ("Atenção: Deseja realmente gerar uma nova senha do aluno? A nova senha será - cedtec"))
{
	  var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
}
else
{
exit;
}
}
		</script>
        
        
        
	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#fornecedor').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
						}	
						$('#fornecedor').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#fornecedor').html('<option value="">– Cliente-Fornecedor –</option>');
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
