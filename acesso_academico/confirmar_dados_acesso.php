<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST["nome_completo"])){
		$nome_completo = $_POST["nome_completo"];
	} else {
		$nome_completo = $user_nome;
	}
	$email = $_POST["email"];
	$nova_senha = $_POST["nova_senha"];
	$confirmar_senha = $_POST["confirmar_senha"];
	
	if($confirmar_senha != $nova_senha){
		echo "<script language=\"javascript\">
		alert('Senhas não conferem!');
		history.back();
		</script>";	
	} else {
		if($_SESSION["tipo_usuario"]==1){
			mysql_query("UPDATE users SET nome = '$nome_completo', email = '$email', senha='$nova_senha', status=0 WHERE id_user = '$user_iduser'");	
			echo "<script language=\"javascript\">
		alert('Dados atualizados com sucesso!');
		location.href='index.php';
		</script>";	
		} else {
			mysql_query("UPDATE acesso SET senha = '$nova_senha', status=0 WHERE codigo = $user_usuario");
			mysql_query("UPDATE alunos SET email = '$email' WHERE codigo = $user_usuario");
			echo "<script language=\"javascript\">
		alert('Dados atualizados com sucesso!');
		location.href='index.php';
		</script>";	
		}
		
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
                              <b>Confirma&ccedil;&atilde;o de Dados de Acesso</b>
                          </header>
                          <div class="panel-body">
                            <form name="form_turma" method="post" action="confirmar_dados_acesso.php" class="form-horizontal" id="default">
                              <fieldset title="Confirmação de dados" class="step" id="step1">
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Nome Completo</b></label>
                                          <div class="col-lg-10">
                                           <input required class="form-control input-sm m-bot15" name="nome_completo" type="text" value="<?php echo $user_nome;?>" <?php 
										   if($_SESSION["tipo_usuario"]==1){
											echo "";  
										   } else {
											echo "readonly";
										   }
										   ?>
                                           />
                                          
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>E-mail</b></label>
                                          <div class="col-lg-10">
                                          
                                <input required class="form-control input-sm m-bot15" name="email" type="text" value="<?php echo $user_email;?>"/>
                                          </div>
                                      </div>


                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Nova Senha</b></label>
                                          <div class="col-lg-10">
                                         <input required class="form-control input-sm m-bot15" name="nova_senha" type="password" value=""/>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Confirmar Senha</b></label>
                                          <div class="col-lg-10">
                                         <input class="form-control input-sm m-bot15" required name="confirmar_senha" type="password" value=""/>
                                          </div>
                                          <center><input type="submit" class="finish btn btn-danger" value="Salvar Dados"/></center>
                                      </div>


                                  </fieldset>

                                  
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