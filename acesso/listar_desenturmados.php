<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

//GET
$grupo = $_GET["grupo"];
$turma = $_GET["turma"];
$turno = trim($_GET["turno"]);
$polo_pesq = $_GET["polo"];
$id_turma = $_GET["id_turma"];

$turma_pesq = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$turma' AND turno LIKE '$turno' AND polo LIKE '$polo_pesq' AND id_turma = '$id_turma'");
$dados_turma = mysql_fetch_array($turma_pesq);
$nivel = $dados_turma["nivel"];
$curso = $dados_turma["curso"];
$modulo = $dados_turma["modulo"];
$grupo_turma = $dados_turma["grupo"];
$unidade = $dados_turma["unidade"];
$polo = $dados_turma["polo"];
$turno = trim($dados_turma["turno"]);
$max_alunos = $dados_turma["max_aluno"];

$sql = mysql_query("SELECT distinct codigo, nome, grupo, turno FROM geral WHERE grupo LIKE '$grupo' 
AND nivel LIKE '%$nivel%' AND curso LIKE '%$curso%' AND modulo LIKE '$modulo' 
AND unidade LIKE '%$unidade%' AND polo LIKE '%$polo%' AND turno LIKE '%$turno%'
AND codigo NOT IN (SELECT matricula FROM ced_turma_aluno A INNER JOIN
ced_turma B ON A.id_turma = B.id_turma WHERE A.polo LIKE '%$polo%' AND A.turno = '$turno' AND B.grupo LIKE '$grupo' AND modulo LIKE '$modulo')  ORDER BY nome");

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
                              <b>Enturma&ccedil;&atilde;o de Alunos<br>
                              <font size="-1"><b>TURMA:</b> <?php echo "<a rel=\"shadowbox\" href=\"detalhe_enturmacao.php?id=$turma&turno=$turno&polo=$polo&id_turma=$id_turma\" >[".$turma."] ".(format_curso($nivel)).": ".(format_curso($curso))." - (MOD. ".(format_curso($modulo)).") - ".(($unidade))." / ".format_curso(strtoupper($polo))."</a>";?></font></b>
                          </header>
                          <div class="panel-body">
<table width="100%" border="1" class="table table-hover" style="font-size:12px">
	<tr bgcolor="#DDDDDD">
    	<td><div align="center"><strong>Enturmar</strong></div></td>
        <td><div align="center"><strong>N&ordm; de Matricula</strong></div></td>
		<td><div align="center"><strong>Nome</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Turno</strong></div></td>
	</tr>

<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM ALUNO DESENTURMADO PARA O PERIODO E CURSO SELECIONADO')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo	   = $dados["codigo"];
		$nome          = strtoupper($dados["nome"]);
		$grupo	   = $dados["grupo"];
		$turno	   = strtoupper($dados["turno"]);
		
        echo "
	<tr>
		<td align=\"center\">
		<a rel=\"shadowbox\" href=\"enturmar_aluno.php?matricula=$codigo&turma=$turma&turno=$turno&polo=$polo&id_turma=$id_turma\"><font size=\"+1\"><div class=\"fa fa-group tooltips\" data-placement=\"right\" data-original-title=\"Enturmar Aluno\"></div></font></a>
		</td>
		<td><b><center>$codigo</b></center></td>
		<td>$nome</td>
		<td><center>$grupo</center></td>
		<td><center>$turno</center></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
	<tr bgcolor="#DDDDDD">
    	<td colspan="5"><div align="left"><strong>Alunos desenturmados: <?php echo $count;?></strong></div></td>

	</tr>
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
