<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
$busca = $_GET["nome"];
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
                              <b>Listar Cliente / Fornecedor</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="get" action="cliente_despesas_pagas.php">
Cliente / Fornecedor: <input type="text" value="<?php echo $busca;?>" name="nome" id="nome" /> 
<input type="submit" name="Filtrar" id="Filtrar" value="Buscar Cliente/Fornecedor" />
</form>
<br>
<form id="form1" name="form1" method="get" action="data_despesas_pagas.php">
Conta: 
    <select name="conta" class="textBox" id="conta" style="width:auto;">
    <option value="*" selected="selected">- Selecione a Conta -</option>
    <?php
include ('menu/config_drop.php');?>
    <?php
if($user_unidade == ""){
	$sql = "SELECT * FROM contas ORDER BY conta";
} else {
	$sql = "SELECT * FROM contas WHERE conta LIKE '%$user_unidade%' ORDER BY conta";
}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['ref_conta'] . "'>" . $row['conta'] . "</option>";
}
?>
  </select>
  De: 
  <input type="date" name="dataini" id="dataini" />
At&eacute;: 
<input type="date" name="datafin" id="datafin" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<hr>
<table class="table table-hover" border="1" align="center">
	<tr bgcolor="#E4E4E4" style="font-size:12px">
		<td><div align="center"><strong>C&oacute;digo</strong></div></td>
		<td><div align="center"><strong>Cliente / Fornecedor</strong></div></td>
        <td><div align="center"><strong>Telefones</strong></div></td>
	</tr>
<?php
include 'includes/conectar.php';

$sql = mysql_query("SELECT * FROM cliente_fornecedor WHERE tipo = 2 AND nome like '%$busca%' ORDER BY nome ");

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
		$codigo          = $dados["codigo"];
		$nome          = strtoupper($dados["nome"]);
		$tel          = $dados["telefone"];
		$tel2          = $dados["telefone2"];
        echo "
	<tr>
		<td align='center'>
		<a rel=\"shadowbox\" href=\"listar_despesas_pagas_cliente.php?id=$codigo&tipo=1\"><font size=\"+1\"><div class=\"fa fa-minus-square tooltips\" data-placement=\"right\" data-original-title=\"Títulos Pagos\"></div></font></a>
		
		<a rel=\"shadowbox\" href=\"listar_despesas_pagas_cliente.php?id=$codigo&tipo=2\"><font size=\"+1\"><div class=\"fa fa-plus-square tooltips\" data-placement=\"right\" data-original-title=\"Títulos Recebidos\"></div></font></a>
		</td>
		<td>$nome</a></td>
		<td>&nbsp;$tel / $tel2</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
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
