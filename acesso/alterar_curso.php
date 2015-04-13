<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["codigo"];
$sql = mysql_query("select * from geral WHERE ref_id = '$id'");
$dados = mysql_fetch_array($sql);
$nivelpes= $dados["nivel"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$id           = $_POST["id"];
	$modulo = strtoupper(($_POST["modulo"]));
	$curso = strtoupper(($_POST["curso"])); 
	$nivel = strtoupper(($_POST["nivel"]));
	$grupo = strtoupper(($_POST["grupo"])); 
	$polo = strtoupper(($_POST["polo"])); 
	$turno = strtoupper(($_POST["turno"])); 

if(isset($_POST["mudar"])){
	$statusfinal = 1;
}else {
	$statusfinal = 0;
}



if(@mysql_query("UPDATE geral SET curso = '$curso', modulo = '$modulo', nivel = '$nivel' , grupo = '$grupo', polo = '$polo', turno = '$turno' WHERE ref_id = '$id'")) {
	
	if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Dados atualizados com sucesso');
			window.close();
			window.opener.Shadowbox.location.reload();
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
                          <header class="panel-heading">
                              <b>Editar Curso</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />

  <table width="430" border="0" align="center" class="full_table_cad">
        <td width="116">Matr&iacute;cula</td>
      <td width="304"><input name="nome" type="text" readonly class="textBox" id="nome" value="<?php echo $dados["matricula"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Grupo</td>
      <td><?php
			include('includes/config_drop.php');
		?>
		  <select name="grupo" id="grupo" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["grupo"]; ?>"><?php echo ($dados["grupo"]); ?></option>
		    <?php
				$sql = "SELECT distinct grupo
						FROM grupos
						ORDER BY grupo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.($row['grupo']).'">'.($row['grupo']).'</option>';
				}
			?></select></td>
    </tr>
    <tr>
      <td>Turno</td>
      <td>
		  <select name="turno" id="turno" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["turno"]; ?>"><?php echo ($dados["turno"]); ?></option>
		    <?php
				$sql = "SELECT distinct turno
						FROM cursosead
						ORDER BY turno";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.($row['turno']).'">'.($row['turno']).'</option>';
				}
			?></select></td>
    </tr>
    <tr>
      <td>N&iacute;vel</td>
      <td>
		  <select name="nivel" id="nivel" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["nivel"]; ?>">- Selecione o Nivel -</option>
		    <?php
				$sql = "SELECT distinct tipo
						FROM cursosead WHERE tipo NOT LIKE '%-%'
						ORDER BY tipo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.($row['tipo']).'">'.($row['tipo']).'</option>';
				}
			?></select></td>
    </tr>
    <tr>
      <td>M&oacute;dulo</td>
      <td><select name="modulo" size="1" id="modulo" onKeyPress="return arrumaEnter(this, event)">
	      <option value="<?php echo $dados["modulo"]; ?>">Selecione...</option>
	      <option value="1">M&oacute;d. I</option>
	      <option value="2">M&oacute;d. II</option>
	      <option value="3">M&oacute;d. III</option></select></td>
    </tr>
    <tr>
      <td>Curso</td>
      <td>
		  <select name="curso" id="curso" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["curso"]; ?>">- Selecione o Curso -</option>
		    <?php
				$sql = "SELECT distinct curso, tipo
						FROM cursosead WHERE tipo NOT LIKE '%-%'
						ORDER BY tipo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.($row['curso']).'">'.($row['tipo']).": ".($row['curso']).'</option>';
				}
			?></select></td>
    </tr>

<tr>
      <td>Polo</td>
      <td>
		  <select name="polo" id="polo" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["polo"]; ?>"><?php echo $dados["polo"]; ?></option>
		    <?php
				$sql = "SELECT distinct unidade
						FROM unidades
						ORDER BY unidade";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['unidade'].'">'.$row['unidade'].'</option>';
				}
			?></select></td>
    </tr>

    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

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