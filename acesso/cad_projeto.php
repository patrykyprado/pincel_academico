 
  <!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
?>

<?php
$id = $_GET["id"];
$re    = mysql_query("select count(*) as total from cliente_fornecedor where codigo = $id");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("select * from cliente_fornecedor where codigo = $id");
	
	$dados = mysql_fetch_array($re);
}



//POST
if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$nome         = $_POST["nome"];
$fantasia         = $_POST["fantasia"];
$email         = $_POST["email"];
$tel         = $_POST["telefone"];
$tel2         = $_POST["telefone2"];
$cpf         = $_POST["cpf"];
$rg         = $_POST["rg"];
$cep         = $_POST["cep"];
$uf         = $_POST["uf"];
$cidade         = $_POST["cidade"];
$endereco         = $_POST["endereco"];
$num         = $_POST["numero"];
$complemento         = $_POST["complemento"];




if(@mysql_query("UPDATE cliente_fornecedor SET nome = '$nome',nome_fantasia = '$fantasia',
	email = '$email', telefone='$tel', telefone2= '$tel2',cpf_cnpj= '$cpf',rg= '$rg',cep= '$cep',uf= '$uf',cidade= '$cidade',endereco='$endereco',numero='$num', complemento = '$complemento' WHERE codigo = $id")) {
	
		if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Dados atualizados com sucesso');
			window.parent.location.reload();
			window.parent.Shadowbox.close();
			</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível atualizar os dados.";
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
                              <b>Cadastro de Projetos</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="post" action="cad_projeto.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="400" border="0" align="center">
    <tr>
      <td>Nome</td>
      <td><input name="nome" type="text" class="textBox" id="nome" value="<?php echo $dados["nome"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Nome Fantasia</td>
      <td><input name="fantasia" type="text" class="textBox" id="fantasia" value="<?php echo $dados["nome_fantasia"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>E-mail</td>
      <td><input name="email" type="text" class="textBox" id="email" value="<?php echo $dados["email"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Telefone</td>
      <td><input name="telefone" type="text" class="textBox" id="telefone" value="<?php echo $dados["telefone"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Outro Telefone</td>
      <td><input name="telefone2" type="text" class="textBox" id="telefone2" value="<?php echo $dados["telefone2"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>CPF / CNPJ</td>
      <td><input name="cpf" type="text" class="textBox" id="cpf" value="<?php echo $dados["cpf_cnpj"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>RG</td>
      <td><input name="rg" type="text" class="textBox" id="rg" value="<?php echo $dados["rg"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>CEP</td>
      <td><input name="cep" type="text" class="textBox" id="cep" value="<?php echo $dados["cep"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>UF</td>
      <td><input name="uf" type="text" class="textBox" id="uf" value="<?php echo $dados["uf"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Cidade</td>
      <td><input name="cidade" type="text" class="textBox" id="cidade" value="<?php echo $dados["cidade"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Endere&ccedil;o</td>
      <td><input name="endereco" type="text" class="textBox" id="endereco" value="<?php echo $dados["endereco"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>N&ordm;</td>
      <td><input name="numero" type="text" class="textBox" id="numero" value="<?php echo $dados["numero"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Complemento</td>
      <td><input name="complemento" type="text" class="textBox" id="complemento" value="<?php echo $dados["complemento"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td></td>
      <td width="224"><input type="submit" name="Submit" value="Salvar" style="cursor:pointer;"/></td>
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
