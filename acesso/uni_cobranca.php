<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$dias_atraso = 10;
$data_ini = date("Y-m-d");
$data_fim =  date("Y-m-d", time() - ($dias_atraso * 86400));
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
                              <b>Cobran&ccedil;a de Alunos (E-mail)</b>
                          </header>
                          <div class="panel-body">
<table width="80%" border="1" class="table table-striped" align="center">

	<tr bgcolor="#D7D7D7">
		<td><div align="center"><strong>ALUNO</strong></div></td>
		<td><div align="center"><strong>VALOR DO D&Eacute;BITO</strong></div></td>
        <td><div align="center"><strong>ENVIAR E-MAIL</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';


//SELECT

$sql = mysql_query("SELECT codigo, nome, SUM( valor ) as VALORTOTAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND (vencimento between '$data_fim' AND '$data_ini') AND conta_nome LIKE '%$user_unidade%'  AND status = 0  GROUP BY codigo ORDER BY nome");
$sql_max = mysql_query("SELECT SUM( valor ) as VALOR_FINAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND (vencimento between '$data_fim' AND '$data_ini')  AND conta_nome LIKE '%$user_unidade%'  AND status = 0 ORDER BY nome");
$total_valor = mysql_fetch_array($sql_max);
$sql_max2 = mysql_query("SELECT SUM( valor_pagto ) as VALOR_FATURADO FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto <> '' OR data_pagto is not null) AND tipo = 3 AND (vencimento between '$data_fim' AND '$data_ini')  AND conta_nome LIKE '%$user_unidade%'  AND status = 0 ORDER BY nome");
$total_faturado = mysql_fetch_array($sql_max2);
// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
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
		$idcli			 = $dados["codigo"];
		$nome			 = $dados["nome"];
		$valortotal			 = number_format($dados["VALORTOTAL"], 2, ',', '.');
		$sql3 = mysql_query("SELECT * FROM alunos WHERE codigo = '$idcli'");
		$dados2 = mysql_fetch_array($sql3);
		$aluno = format_curso(strtoupper($dados2["nome"]));
        echo "
	<tr>
		<td>&nbsp;$aluno</td>
		<td align='center'>R$ &nbsp;$valortotal</td>
		<td align=\"center\">	
		<a rel=\"shadowbox\" href=\"enviar_emails.php?id=$idcli\" ><font size=\"+1\"><div class=\"fa fa-envelope tooltips\" data-placement=\"right\" data-original-title=\"Enviar E-mail\"></div></font></a>
		</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="8">
<strong>Valor a Receber: <font color="#FF0000">R$ <?php echo number_format($total_valor["VALOR_FINAL"], 2, ',', '.');?></font></strong></td>
  
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
