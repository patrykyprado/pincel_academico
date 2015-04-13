<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
$nome        = $_POST["nome"];
$fantasia        = "";
$email         = $_POST["email"];
$cpf      = $_POST["cpf"];
$rg      = $_POST["rg"];
$telefone      = $_POST["tel"];
$telefone2      = $_POST["tel2"];
$endereco      = $_POST["rua"];
$numero      = $_POST["num"];
$complemento      = $_POST["comp"];
$cep      = $_POST["cep"];
$uf      = $_POST["uf"];
$cidade      = $_POST["cidade"];
$tipo      = $_POST["tipo"];
if($tipo == 1){
	$curso ="CLIENTE";
	$turma ="CLIENTE";	
}
if($tipo == 2){
	$curso ="FORNECEDOR";
	$turma ="FORNECEDOR";	
}
if($tipo == 3){
	$curso ="ALUNO";
	$turma ="ALUNO";	
}
if($tipo == 4){
	$curso ="FUNCIONÁRIO";
	$turma ="FUNCIONÁRIO";	
}

include('includes/conectar.php');
if(@mysql_query("INSERT INTO inscritos (codigo,cpf,noticia) VALUES (NULL , '$cpf','MANUAL')")) {

	if(mysql_affected_rows() == 1){
		echo "<script language=\"javascript\">
		alert('Cadastrado com sucesso!');
		</script>";
		$re2 = mysql_query("SELECT * FROM inscritos WHERE cpf LIKE '%$cpf%' AND noticia LIKE 'MANUAL' ORDER BY codigo DESC LIMIT 1");
		while($dados = mysql_fetch_array($re2)) {
			$cod2 = $dados["codigo"];
			}
			mysql_query("INSERT INTO cliente_fornecedor VALUES ('$cod2' , UPPER('$fantasia') ,UPPER('$nome') , '$email','$telefone','$telefone2','$cpf', '$rg','$uf','$cidade','$endereco','$numero','$complemento', '$cep','$tipo','$curso','$turma')");
	}	

} else {
	if(mysql_errno() == 1062) {
		echo $erros[mysql_errno()];
		exit;
	} else {	
		echo "Erro nao foi possivel efetuar o registro";
		exit;
	}	
	@mysql_close();
}

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
                              <b>Cadastro de Funcion&aacute;rio</b>
                          </header>
                          <div class="panel-body">
                <form action="cad_func.php" method="POST" onKeyPress="return arrumaEnter(this, event)">
<table  width="50%" align="center">
<tr>
	<td align="right" width="20%"><b>Nome:</b></td>
    <td><input id="nome" name="nome" type="text" style="width:400px" placeholder="Informe o Nome" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>CNPJ / CPF:</b></td>
    
                                <td><input id="cpf" style="width:400px" name="cpf" type="text" placeholder="Informe o CNPJ/CPF" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>E-mail:</b></td>
    <td><input id="email" name="email" type="text" style="width:400px" placeholder="Informe o E-mail" onKeyPress="return arrumaEnter(this, event)"/>
    </td>
</tr>
<tr>
	<td align="right"><b>Telefone:</b></td>
    <td><input id="tel" name="tel" style="width:400px" type="text" placeholder="Informe o Telefone" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>2&ordm; Telefone:</b></td>
    <td><input id="tel2" name="tel2" type="text" style="width:400px" placeholder="Informe Outro Telefone" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>RG:</b></td>
    <td><input id="rg" name="rg" type="text" style="width:400px" placeholder="Informe o RG" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>CEP:</b></td>
    <td><input id="cep" name="cep" type="text" style="width:400px" maxlength="9" placeholder="Informe o CEP" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>Rua:</b></td>
    <td><input id="rua" name="rua" type="text" style="width:400px" placeholder="Nome da Rua / Logradouro" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>N&uacute;mero:</b></td>
    <td><input id="num" style="width:400px" name="num" type="text" placeholder="Número" onKeyPress="return arrumaEnter(this, event)"/>
    </td>
</tr>
<tr>
	<td align="right"><b>Bairro:</b></td>
    <td><input id="bairro" style="width:400px" name="bairro" type="text" placeholder="Informe o Bairro" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>Complemento:</b></td>
<td><input id="comp" name="comp" style="width:400px" type="text" placeholder="Complemento" onKeyPress="return arrumaEnter(this, event)"/>
</td>
</tr>
<tr>
	<td align="right"><b>Cidade:</b></td>
    <td><input id="cidade" style="width:400px" name="cidade" type="text" placeholder="Informe a Cidade" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td align="right"><b>Estado:</b></td>
    <td><input id="uf" name="uf" style="width:400px" type="text" placeholder="Informe o UF" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr><input id="tipo" name="tipo" type="hidden" placeholder="TIPO" required onKeyPress="return arrumaEnter(this, event)" value="4"/><tr>
	<td align="center" colspan="2"><input type="submit" name="Cadastrar" id="Cadastrar" value="Cadastrar"></td>
</tr>
         
</table>
                </form>   
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
