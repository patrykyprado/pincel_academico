<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
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
                              <b>Relat&oacute;rio: Matrículas do Dia</b>
                          </header>
                        <div class="panel-body">
<?php



$get_query = "SELECT DISTINCT codigo as Matrícula, nome as Nome, Dtpaga as 'Data de Matrícula', unidade as Unidade, polo as Polo FROM geral WHERE unidade like '%$user_unidade%' AND (Dtpaga BETWEEN SUBSTRING(NOW(),1,10) AND SUBSTRING(NOW(),1,10))";

// Declaração da pagina inicial  
$pagina = $_GET["pagina"];  
if($pagina == "") {  
    $pagina = "1";  
} 
$orderby = $_GET["orderby"];  
if($orderby == "") {  
    $orderby = " ORDER BY nome DESC";  
} else {
	$orderby = " ORDER BY $orderby";
}

// Maximo de registros por pagina  
$maximo = 100;

// Calculando o registro inicial  
$inicio = $pagina - 1;  
$inicio = $maximo * $inicio;

$sql_query = "$get_query $orderby LIMIT $inicio,$maximo";
$sql_relatorio = mysql_query($sql_query);

$sql_query_max = "$get_query $orderby";
$sql_relatorio_max = mysql_query($sql_query_max);

$total_resultados = mysql_num_rows($sql_relatorio);
$max_resultados = mysql_num_rows($sql_relatorio_max);
$total_span=mysql_num_fields($sql_relatorio);

// Conta os resultados no total da minha query  
$final_query = "FROM usuarios_online";
$strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";  
$query    = mysql_query($strCount);  
$row      = mysql_fetch_array($query);  
$total    = $row["num_registros"];  

if($total<=0) {  
    echo "<center>Nenhum registro encontrado.</center>";  
} else {  

// Calculando pagina anterior  
    $menos = $pagina - 1;  

// Calculando pagina posterior  
    $mais = $pagina + 1;


?>
<table class="table table-striped table-hover table-bordered" id="editable-sample">
<tr>
<?php //colunas

$i = 0;
while ($i < mysql_num_fields($sql_relatorio)){
	 $meta = mysql_fetch_field($sql_relatorio, $i);
	 $exib_topo_coluna = str_replace("_"," ", $meta->name);
	 
	 echo 
	 "<td align=\"center\" bgcolor=\"#C0C0C0\"><b><a href=\"?orderby=".$meta->name."\">".$exib_topo_coluna."</a></b></td>";
	 $i++;

}
?>
</tr>

<?php //dados das linhas

$sql_relatorio2 = mysql_query($sql_query);
while($dados_relatorio = mysql_fetch_array($sql_relatorio2)){
	echo "<tr>";
	$i2 =0;
	while ($i2 < mysql_num_fields($sql_relatorio2)){
	 $meta2 = mysql_fetch_field($sql_relatorio2, $i2);
	 //configurações do campo
	 $campo_width="auto";
	 $campo_align="";
	 $campo_funcao="not";
	 $sql_campo=mysql_query(("SELECT * FROM config_campos WHERE campo LIKE '%".$meta2->name."%'"));
	 if(mysql_num_rows($sql_campo)==1){
	 	$dados_campo = mysql_fetch_array($sql_campo);
	 	$campo_width = $dados_campo["width"];
		$campo_align= $dados_campo["align"];
		$campo_funcao= $dados_campo["funcao"];
	 }
	 
	 echo 
	 "<td width=\"$campo_width\" align=\"$campo_align\">".$campo_funcao($dados_relatorio[$meta2->name])."</td>";
	 $i2++;
	}
	echo "</tr>";
}
?>
</table>
<?php
$pgs = ceil($total / $maximo);  
    if($pgs > 1 ) {  
        // Mostragem de pagina  
        if($menos > 0) {  
           echo "<a href=\"?pagina=$menos&\" class='texto_paginacao'>Anterior</a> ";  
        }  
        // Listando as paginas  
        for($i=1;$i <= $pgs;$i++) {  
            if($i != $pagina) {  
               echo "  <a href=\"?pagina=".($i)."\" class='texto_paginacao'>$i</a>";  
            } else {  
                echo "  <strong lass='texto_paginacao_pgatual'>".$i."</strong>";  
            }  
        }  
        if($mais <= $pgs) {  
           echo "   <a href=\"?pagina=$mais\" class='texto_paginacao'>Próxima</a>";  
        }  
    }  
}  

?>

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