<head>
<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');

$get_informativo = $_GET["id_informativo"];
$sql_informativo_atual = mysql_query("SELECT * FROM ced_informativos WHERE id_informativo = $get_informativo");
if(mysql_num_rows($sql_informativo_atual)==0){
	$informativo_atual = "<center>Não há novos informativos para a sua turma.</center>";
} else {
	$dados_informativo_atual = mysql_fetch_array($sql_informativo_atual);
	$informativo_atual = $dados_informativo_atual["conteudo"];
}

?>
<meta charset="iso-8859-1">
</head>
<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_corpo_msg").height = document.getElementById("central").scrollHeight + 300;
     }
</script>
    

<div id="central">
<?php echo $informativo_atual;?>

</div>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>