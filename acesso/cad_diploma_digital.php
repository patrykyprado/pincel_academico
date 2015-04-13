<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
if($_SERVER["REQUEST_METHOD"] == "POST") {
//usuário
if(eregi("[^0-9]",$_POST["cpf"])){
echo "<script language=\"javascript\">
		alert('No campo CPF, somente são permitidos números!');
		</script>";
exit;
}

$nome        = $_POST["nome"];
$cpf        = $_POST["cpf"];
$unidade        = $_POST["unidade"];
$curso        = $_POST["curso"];
$conclusao        = $_POST["conclusao"];
$registro        = $_POST["registro"];
$livro        = $_POST["livro"];
$folha        = $_POST["folha"];
$data        = $_POST["data"];
$sistec        = $_POST["sistec"];

if(mysql_query("INSERT INTO tbaluno (codigo, NOME, CPF, CURSO, CONCLUSAO, REGISTRO, LIVRO, FOLHA, DIPLOENTREGUE, SISTEC, Unidade)
VALUES (NULL, '$nome', '$cpf', '$curso', '$conclusao', '$registro', '$livro', '$folha', '$data', 'sistec', '$unidade');")){
	if(mysql_affected_rows()==1){
		echo "<script language=\"javascript\">
		alert('Salvo com sucesso!');
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
                              <b>Diploma Digital</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="post" action="#">
<table class="full_table_list" width="100%">
<tr>
	<td width="70"><b>Nome:</b></td>
    <td><input style="width:500px" name="nome" id="nome"/></td>
</tr>
<tr>
	<td><b>CPF:</b></td>
    <td><input name="cpf" id="cpf"/></td>
</tr>
<tr>
	<td><b>Unidade:</b></td>
    <td><select name="unidade" style="width:auto" class="textBox" id="unidade" onKeyPress="return arrumaEnter(this, event)">
      <?php
include("includes/config_drop.php");?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0 ORDER BY unidade";
	  } else {
		 $sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0 AND unidade LIKE '%$user_unidade%' OR unidade LIKE '%EAD%' ORDER BY unidade";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
      </select></td>
</tr>
<tr>
	<td><b>Curso:</b></td>
    <td><select name="curso" style="width:auto" class="textBox" id="curso" onKeyPress="return arrumaEnter(this, event)">
      <?php
include("includes/config_drop.php");?>
      <?php
		$sql = "SELECT distinct curso FROM disciplinas ORDER BY curso";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['curso'] . "'>" . $row['curso'] . "</option>";
}
?>
      </select></td>
</tr>
<tr>
	<td><b>Conclus&atilde;o:</b></td>
    <td><input style="width:500px" name="conclusao" id="conclusao"/></td>
</tr>
<tr>
	<td colspan="2"><b>Registro:</b> <input style="width:80px" name="registro" id="registro"/> 
    <b>Livro:</b> <input style="width:50px" name="livro" id="livro"/> 
    <b>Folha:</b> <input style="width:50px" name="folha" id="folha"/> </td>

</tr>
<tr>
	<td><b>Data de Entrega:</b></td>
    <td><input type="date" name="data" id="data"/></td>
</tr>
<tr>
	<td><b>SISTEC:</b></td>
    <td><input name="sistec" id="sistec"/></td>
</tr>

<tr>
	<td colspan="2" align="center"><input type="submit"  value="Salvar"/></td>
</tr>
</table>
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