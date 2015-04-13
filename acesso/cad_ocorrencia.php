<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');

$id = $_GET["id"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$matricula           = $_POST["id"];
	$tipo = strtoupper(($_POST["tipo"]));
	$ocorrencia = ($_POST["ocorrencia"]); 
	
	
	if(isset($_POST["turma"])){
		$id_turma =$_POST["turma"];
	} else {
		$id_turma = "";
	}
	if($user_nivel == 9){
		$data = date("Y-m-d");
	} else {
		$data = $_POST["data"]; 
	}
	if($tipo == 1&&$id_turma == ""){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('PARA CANCELAR O ALUNO VOCÊ DEVE ESCOLHER A TURMA');
			history.back();
			</SCRIPT>");
			return;
	}
	
$turma_disc = "";




if(@mysql_query("INSERT INTO ocorrencias (matricula, n_ocorrencia, ocorrencia, data,id_turma,turma_disc)
VALUES ('$matricula','$tipo','$ocorrencia','$data','$id_turma','$turma_disc')")) {
	
	if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('OCORRENCIA INSERIDA COM SUCESSO');
			window.close();
			window.opener.location.reload();
			</SCRIPT>");
			return;
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

  <section id="container" class="sidebar-closed">


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <div class="filtro"><header class="panel-heading">
                              <b>Cadastro de Ocorr&ecirc;ncia</b>
                          </header>
                          </div>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="430" border="0" align="center" class="full_table_cad">
        <td width="116">Matr&iacute;cula</td>
      <td width="304"><input name="nome" type="text" readonly class="textBox" id="nome" value="<?php echo $id; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Data</td>
      <td><input name="data" type="date" class="textBox" id="data" value="<?php echo date("Y-m-d")?>"  maxlength="100"/></td>
    </tr>
    <tr>
      <td>Tipo de Ocorr&ecirc;ncia</td>
      <td><select style="width:300px;"name="tipo" class="textBox" id="tipo" onkeypress="return arrumaEnter(this, event)">
        <option value="Selecione">- Selecione o Tipo -</option>
        <?php
include("menu/config_drop.php");?>
        <?php
$sql = "SELECT * FROM tipo_ocorrencia ORDER BY id";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . (($row['ocorrencia'])) . "</option>";
}
?>
      </select></td>
    </tr>
    
    <tr>
      <td>Turma</td>
      <td><input type="checkbox" id="check" onclick="habilitar();"  /><select disabled="disabled" style="width:600px;"name="turma" class="textBox" id="turma" onkeypress="return arrumaEnter(this, event)">
        <option value="0">- Escolha a Turma -</option>
        <?php
include("menu/config_drop.php");?>
        <?php
$sql = "SELECT * FROM ced_turma_aluno A INNER JOIN ced_turma B ON A.id_turma = B.id_turma WHERE matricula = $id ORDER BY A.anograde";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_turma'] . "'>" . $row['nivel'] .": ".$row['curso'] ." - Mod. ".$row['modulo'] ." (".$row['cod_turma'] . ") - " . $row['grupo'] . "</option>";
}
?>
      </select></td>
    </tr>

    <tr valign="top">
      <td>Ocorr&ecirc;ncia</td>
      <td><textarea name="ocorrencia" cols="20" rows="10" style="width:400px"class="textBox" id="ocorrencia"></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>
</div>

                          </div>
                          <div class="panel-footer">
                              <center><a onClick="window.parent.Shadowbox.close();">FECHAR</a></center>
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
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('turma').disabled = false;  
    } else {  
        document.getElementById('turma').disabled = true;  
    }  
}  
</script> 