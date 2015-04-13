<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["id"];
$id2 = $_GET["id2"];


$re    = mysql_query("select count(*) as total from view_tit_ccusto where id_titulo = $id AND id_custo = $id2");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("select * from view_tit_ccusto where id_titulo = $id AND id_custo = $id2");
	$dados = mysql_fetch_array($re);
	$b_cc1 = $dados["cc1"];
	$b_cc2 = $dados["cc2"];
	$b_cc3 = $dados["cc3"];
	$b_cc4 = $dados["cc4"];
	$b_cc5 = $dados["cc5"];
	$b_cc6 = $dados["cc6"];
	
	
	//BUSCA NOME CC1
		$sql_cc1 = mysql_query("SELECT * FROM cc1 WHERE id_empresa = '$b_cc1'");
		$d_cc1 = mysql_fetch_array($sql_cc1);
		$nome_cc1 = $d_cc1["nome_cc1"];
		if(trim($nome_cc1) == ""){
			$nome_cc1 = "----";
		}
		
		//BUSCA NOME CC2
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial = '$b_cc2'");
		$d_cc2 = mysql_fetch_array($sql_cc2);
		$nome_cc2 = $d_cc2["nome_filial"];
		if(trim($nome_cc2) == ""){
			$nome_cc2 = "----";
		}
		
		//BUSCA NOME CC3
		$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = '$b_cc3'");
		$d_cc3 = mysql_fetch_array($sql_cc3);
		$nome_cc3 = $d_cc3["nome_cc3"];
		if(trim($nome_cc3) == ""){
			$nome_cc3 = "----";
		}
		
		
		//BUSCA NOME CC4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 = '$b_cc4'");
		$d_cc4 = mysql_fetch_array($sql_cc4);
		$nome_cc4 = $d_cc4["nome_cc4"];
		if(trim($nome_cc4) == ""){
			$nome_cc4 = "----";
		}
		
		//BUSCA NOME CC5
		$sql_cc5 = mysql_query("SELECT * FROM cc5 WHERE cc5 = '$b_cc5' AND id_cc5 = '$b_cc4'");
		$d_cc5 = mysql_fetch_array($sql_cc5);
		$nome_cc5 = $d_cc5["nome_cc5"];
		if(trim($nome_cc5) == ""){
			$nome_cc5 = "----";
		}
		
		//BUSCA NOME CC6
		$sql_cc6 = mysql_query("SELECT * FROM cc6 WHERE id_cc6 = '$b_cc6'");
		$d_cc6 = mysql_fetch_array($sql_cc6);
		$nome_cc6 = $d_cc6["nome_cc6"];
		if(trim($nome_cc6) == ""){
			$nome_cc6 = "----";
		}


		
}
//POST
if($_SERVER["REQUEST_METHOD"] == "POST") {
$titulo           = $_POST["cod_titulo"];
$id_custo         = $_POST["id_custo"];
$cc1         = $_POST["cc1"];
$cc2         = $_POST["cc2"];
$cc3         = $_POST["cc3"];
$cc4         = $_POST["cc4"];
$cc5         = $_POST["cc5"];
$cc6         = $_POST["cc6"];




include('includes/conectar.php');
if(isset($_POST["ativo"])&&$recebido == 0){
	$status = 1;
} else {
	$status = 0;
}


//UPDATE
	if(@mysql_query("UPDATE c_custo SET cc1 = '$cc1',cc2 = '$cc2',cc3 = '$cc3',
	cc4 = '$cc4', cc5='$cc5', cc6= '$cc6' WHERE codigo = $titulo AND id_custo = $id_custo")) {
	
		if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('CENTRO DE CUSTO ALTERADO COM SUCESSO');
			window.close();
			window.opener.location.reload();
			</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível alterar o título.";
			exit;
		}	
		@mysql_close();
	}

}
?>

  <body>

  <section id="container" class="sidebar-closed">


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Editar Centro de Custo</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="editar_ccusto.php" onsubmit="return confirma(this)">
<br />
<table width="50%" border="1" align="center">
<tr align="center">
    <td align="right">
      <b>T&iacute;tulo</b>
     </td>
     <td align="left">
    <input type="text" name="titulo" id="titulo" readonly value="<?php echo $dados["id_titulo"];?>" /></td></td>
  </tr>
<tr align="center">
    <td align="right">
      <b>Pagamento</b>
     </td>
     <td align="left">
    <input type="text" name="titulo" id="titulo" readonly value="<?php echo substr($dados["data_pagto"],8,2)."/".substr($dados["data_pagto"],5,2)."/".substr($dados["data_pagto"],0,4);?>" /></td>
  </tr>
<tr align="center">
    <td align="right">
      <b>Valor</b></td>
      <td align="left">
    <input type="text" name="titulo" id="titulo" readonly value="<?php echo number_format($dados["valor"],2,",",".");?>" /></td>
  </tr>
<tr align="center">
    <td valign="top" colspan="2">
      <b>Descricao</b>
      <textarea name="titulo" style="width:400px; height:70px;" readonly id="titulo"><?php echo $dados["descricao"];?></textarea>
      
      <input type="hidden" name="cod_titulo" id="cod_titulo" value="<?php echo $id;?>" />
      <input type="hidden" name="id_custo" id="id_custo" value="<?php echo $id2;?>" /></td>
  </tr>
  <tr align="center">
    <td  align="center"><b>Centro de Custo (Antigo)</b></td>
    <td align="center"><b>Centro de Custo (Novo)</b></td>
  </tr>
  
  
  <tr align="center">
    <td>
      <input type="text" name="cc1a" id="cc1a" readonly value="<?php echo $nome_cc1;?>" /></td>
    <td><select name="cc1" style="width:300px;" class="textBox" id="cc1" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc1;?>">SELECIONE A EMPRESA</option>
      <?php
include("menu/config_drop.php");?>
      <?php
if($user_empresa == 0){
		$sql = "SELECT * FROM cc1 ";
	  } else {
		$sql = "SELECT * FROM cc1 WHERE id_empresa = $user_empresa ";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc2a" id="cc2a" readonly value="<?php echo $nome_cc2;?>"/></td>
    <td><select name="cc2" style="width:300px;" class="textBox" id="cc2" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc2;?>">SELECIONE A FILIAL</option>
      <?php
include("menu/config_drop.php");?>
      <?php
if($user_empresa == 0){
		$sql = "SELECT * FROM cc2 ";
	  } else {
		$sql = "SELECT * FROM cc2 WHERE nome_filial LIKE '%$user_unidade%' AND niveltxt LIKE '%geral%' ";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filial'] . "'>" . $row['nome_filial'] . "</option>";
}
?>
    </select>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc3a" id="cc3a" readonly value="<?php echo $nome_cc3;?>" /></td>
    <td><select name="cc3" style="width:300px;" class="textBox" id="cc3" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc3;?>">SELECIONE</option>
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM cc3 ORDER BY id_cc3";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc3'] . "'>" . $row['nome_cc3'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc4a" id="cc4a" readonly value="<?php echo $nome_cc4;?>" /></td>
    <td><select name="cc4" style="width:300px;" class="textBox" id="cc4" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc4;?>">SELECIONE</option>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc5a" id="cc5a" readonly value="<?php echo $nome_cc5;?>" /></td>
    <td><select name="cc5" style="width:300px;" class="textBox" id="cc5" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc5;?>">SELECIONE</option>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc6a" id="cc6a" readonly value="<?php echo $nome_cc6;?>"/></td>
    <td><select name="cc6" style="width:300px;" class="textBox" id="cc6" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc6;?>">SELECIONE</option>
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM cc6 ORDER BY id_cc6";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc6'] . "'>" . $row['nome_cc6'] . "</option>";
}
?>
    </select></td>
    </tr>
</table>
<center><input type="submit" name="Submit" value="Salvar" style="cursor:pointer;"/></center>
 

</form>
                          </div>
                          <div class="panel-footer">
                              <center><a onClick="ShadowClose()" href="javascript:parent.location.reload();">FECHAR</a></center>
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


    

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o cliente/fornecedor? '))
{
location.href="apagar_forn.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar_forn.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
function enviar(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor2').value = valor;
this.close();
}
</script>
    </script>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
     
<script>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 
  
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
					$('#cc4').html('<option value="">Ã¢â‚¬â€œ CC4 Ã¢â‚¬â€œ</option>');
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
					$('#cc5').html('<option value="">Ã¢â‚¬â€œ CC5 Ã¢â‚¬â€œ</option>');
				}
			});
		});
		</script>