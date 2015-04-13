<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

$busca = $_GET["buscar"];
$modalidade = "";
if($busca == "EAD" || $busca == "ead"){
	$modalidade = "OR modalidade = 2";
} 
if($busca == "PRESENCIAL" || $busca == "presencial"){ 
	$modalidade = "OR modalidade = 1";
}

$sql = mysql_query("SELECT * FROM inscritos WHERE noticia <> 'MANUAL' AND nome LIKE '%$busca%' OR nome_fin LIKE  '%$busca%' OR cidade LIKE  '%$busca%'  OR bairro LIKE  '%$busca%' OR curso LIKE  '%$busca%' OR unidade LIKE  '%$busca%' OR codigo LIKE '%$busca%' $modalidade  AND cpf NOT IN (select cpf from alunos) order by codigo");


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
                              <b>Relat&oacute;rio: Interessados</b>
                          </header>
                          <div class="panel-body">

<form id="form2" name="form1" method="GET" action="buscar_mat_interessados.php">
  <b>Nome/Matr&iacute;cula:</b>
  <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
  <label><strong>Resultados encontrados:</strong> <?php echo $count; ?></label>
</form>
<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr bgcolor="#DDDDDD">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>N&ordm; de Matricula</strong></div></td>
		<td><div align="center"><strong>Nome</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Modalidade</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>Telefones</strong></div></td>
        <td><div align="center"><strong>Data de Inscri&ccedil;&atilde;o</strong></div></td>
	</tr>

<?php

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
		$codigo	   = $dados["codigo"];
		$nome          = (strtoupper($dados["nome"]));
		$curso	   = ($dados["curso"]);
		$exp_unidade = explode("-",$dados["unidade"]);
		$unidade	   = ($exp_unidade[0]);
		$datacad = $dados["datacad"];
		if($dados["modalidade"] == 1){
			$mod_exib = "Presencial";
		} else {
			$mod_exib = "EAD";
		}
		
		$telefones	   = $dados["telefone"]." / ".$dados["celular"];
		$cursopesq2   = mysql_query("SELECT * FROM cursosead WHERE codigo = '$curso'");
		$dadoscur2 = mysql_fetch_array($cursopesq2);
		$curso2 = (strtoupper($dadoscur2["tipo"].": ".$dadoscur2["curso"]));
		$grupo = $dadoscur2["grupo"];
		if($user_nivel != 6){
			$botao_acao = "<td align='center'><a rel=\"shadowbox\" href=\"matricular.php?id=$codigo\"><font size=\"+1\"><div class=\"fa fa-plus tooltips\" data-placement=\"right\" data-original-title=\"Matricular Aluno\"></div></font></a> <a rel=\"shadowbox\" href=\"gerar_desconto.php?id=$codigo\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Gerar Desconto\"></div></font></a><a rel=\"shadowbox\" href=\"editar_inscritos.php?codigo=$codigo\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Editar Dados\"></div></font></a></td>";
		} else {
			$botao_acao = "<td align='center'> <a rel=\"shadowbox\" href=\"editar_inscritos.php?codigo=$codigo\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Editar Dados\"></div></font></a></td>";

		}
        echo "
	<tr>
		$botao_acao
		<td><b><center>$codigo</b></center></td>
		<td>$nome</td>
		<td>$unidade</td>
		<td>$mod_exib</td>
		<td>$grupo</td>
		<td>$curso2</td>
		<td>$telefones</td>
		<td>$datacad</td>
		\n";
        // exibir a coluna nome e a coluna email
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