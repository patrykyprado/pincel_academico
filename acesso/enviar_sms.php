<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
ini_set('display_errors', "on");
ini_set('error_reporting', E_ALL & ~E_NOTICE);
include_once '../cliente_sms/HumanClientMain.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	

	// Exemplo para testar a lista no lay-out C
	$msg_list  = "5527998391088;Esse SMS foi enviado pelo sistema PINCEL ATÔMICO.;021;CEDTEC;19/11/2014 12:52:00"."\n";
	$msg_list .= $_POST["num_cel"].";".$_POST["mensagem"].";020;CEDTEC;19/11/2014 12:52:00"."\n";
	//conecta o usuário
	$humanMultipleSend = new HumanMultipleSend("cedtec", "CqXSw3hF");
	$response = $humanMultipleSend->sendMultipleList(HumanMultipleSend::TYPE_E, $msg_list);
	foreach ($response as $resp) {
		echo $resp->getCode() . " - " . $resp->getMessage() . "<br />";
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
                              <b>Envio de SMS</b>
                          </header>
                          <div class="panel-body">
<form action="#" method="post">
<input name="num_cel" />
<br>
<textarea name="mensagem"></textarea>
<br>
<input value="Enviar" type="submit"/>
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