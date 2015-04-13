<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

if($_SERVER['REQUEST_METHOD']=="POST"){

$nome= $_POST["nome"];
$email= $_POST["email"];
$pai= $_POST["pai"];
$mae= $_POST["mae"];
$telefone= $_POST["telefone"];
$telefone2= $_POST["telefone_2"];
$telefone3= $_POST["telefone_3"];
$escola= $_POST["escola"];
$unidade= $_POST["unidade"];
$curso= $_POST["curso"];
$datacadastro= date("Y-m-d H:i:s");


if(mysql_query("INSERT INTO cad_bolsao ( nome, email, pai, mae, telefone, telefone_2, telefone_3, escola, unidade, curso, data_cadastro)
VALUES ('$nome', '$email', '$pai','$mae', '$telefone','$telfefone_2', '$telefone_3','$escola', '$unidade', '$curso', '$datacadastro');")){	
	if(mysql_affected_rows()==1){
		echo "<script language=\"javascript\">
		alert('Inscrição realizada com sucesso');
		location.href= 'cad_bolsao.php'
		</script>";
		
	} else {
		echo "<script language=\"javascript\">
		alert('Está faltando algum dado. Tente novamente');
		history.back();
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
                              <b>Cadastro de Bols&atilde;o</b>
                          </header>
                          <div class="panel-body">
<form action="cad_bolsao.php" method="post">
  
  <center> <table style="width: 625px;" border="0">

    <tbody><tr>

      <td width="69">Nome:</td>

      <td width="546"><input id="nome" required maxlength="60" name="nome" size="70" type="text" /></td>

    </tr>

    <tr>

      <td>Email:</td>

      <td><input id="email" maxlength="60" name="email" size="70" type="text" /></td>

    </tr>

     <tr>

      <td>Pai:</td>

      <td><input id="pai" maxlength="60" name="pai" size="70" type="text" /></td>

    </tr>
     <tr>

      <td>M&atilde;e:</td>

      <td><input id="mae" maxlength="60" name="mae" size="70" type="text" /></td>

    </tr>
    
      <tr>

      <td>Telefone:</td>

      <td><input id="telefone" maxlength="60" name="telefone" size="70" type="text" /></td>

    </tr>
    
     <tr>

      <td>Telefone2:</td>

      <td><input id="telefone_2" maxlength="60" name="telefone_2" size="70" type="text" /></td>

    </tr>
     <tr>

      <td>Telefone3:</td>

      <td><input id="telefone_3" maxlength="60" name="telefone_3" size="70" type="text" /></td>

    </tr>
    <tr>

      <td>Escola:</td>

      <td><input id="escola" maxlength="60" name="escola" size="70" type="text" /></td>

    </tr>
    
 
    <tr>

      <td>Unidade:</td>

      <td>
        <select name="unidade" id="unidade">
          <option value="Cariacica">Cariacica</option>
          <option value="Serra">Serra</option>
        </select></td>

    </tr>
 
 <tr>

      <td>Curso:</td>

      <td>
        <select name="curso" id="curso">
          <option value="Ensino M&eacute;dio">Ensino M&eacute;dio</option>
          <option value="Ensino M&eacute;dio Integrado">Ensino M&eacute;dio Integrado</option>
        </select></td>

    </tr>
    
    
   
   
        <span class="style1">      </span></td>

    </tr>
    
    

    <tr>

      
    <tr>

      <td colspan="2" align="center">
        <input id="cadastrar" name="cadastrar" type="submit" value="Cadastrar" /> 
          <input id="limpar" name="limpar" type="reset" value="Limpar" /></td>

    </tr>

  </tbody></table></center>

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