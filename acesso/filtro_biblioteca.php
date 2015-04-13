<head>
<!-- CSS DE IMPRESSÃO -->
    <link href="css/imprimir.css" media="print" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" media="screen" rel="stylesheet">
    <style type="text/css">
    body,td,th {
	font-family: "Open Sans", sans-serif;
}
    </style>
    <script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("filtro_biblioteca").height = document.getElementById("frame").scrollHeight + 35;
     }
    </script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
 <?php 
 include('includes/funcoes.php');
 include('includes/conectar.php');
 
 // Declaração da pagina inicial  
$pagina = $_GET["pagina"];  
if($pagina == "") {  
    $pagina = "1";  
}
// Maximo de registros por pagina  
$maximo = 30;
// Calculando o registro inicial  
$inicio = $pagina - 1;  
$inicio = $maximo * $inicio;

// Calculando pagina anterior  
$menos = $pagina - 1;  

// Calculando pagina posterior  
$mais = $pagina + 1;


 if(isset($_GET["letra"])){
	$sql_letra = " WHERE descricao LIKE '".$_GET["letra"]."%'"; 
 } else {
	$sql_letra = "";
 }
 if(isset($_GET["buscar_livro"])){
	$sql_busca = " WHERE descricao LIKE '%".$_GET["buscar_livro"]."%' OR curso LIKE '%".$_GET["buscar_livro"]."%'"; 
 } else {
	$sql_busca = "";
 }
 
 $sql_biblioteca = mysql_query("SELECT * FROM biblioteca_digital $sql_letra $sql_busca ORDER BY descricao LIMIT $inicio, $maximo");
 $sql_biblioteca_contar = mysql_query("SELECT * FROM biblioteca_digital $sql_letra $sql_busca");
 $total_livros = mysql_num_rows($sql_biblioteca_contar);
?>

<body>
<div id="frame" style="background-color:#FFF">
<?php
if($total_livros == 0){
	echo "<br><br><br><center><b>Nenhum arquivo encontrado. Pesquise novamente.</b></center><br><br><br>";	
} else {
	echo "<table class=\"table table-hover\" width=\"100%\">
	<tr bgcolor=\"#DCDCDC\">
		<td align=\"center\"><b>Material</b></td>
		<td align=\"center\"><b>Título</b></td>
		<td align=\"center\"><b>Curso</b></td>
		<td align=\"center\"><b>Módulo</b></td>
	</tr>";
	while($dados_livros = mysql_fetch_array($sql_biblioteca)){
		$livro_titulo = $dados_livros["descricao"];
		$livro_curso = $dados_livros["curso"];
		$livro_categoria = $dados_livros["categoria"];
		$livro_link = $dados_livros["link"];	
		echo "
		<tr>
			<td align=\"center\">
			<a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"$livro_link\" class=\"btn btn-xs btn-success\"><img width=\"30px\" height=\"30px\" src=\"img/livro.jpg\"/></a></td>
			<td><a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"$livro_link\" class=\"btn btn-xs btn-success\">$livro_titulo</a></td>
			<td><a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"$livro_link\" class=\"btn btn-xs btn-success\">$livro_curso</a></td>
			<td><a target=\"_top\" onclick=\"return openTopSBX(this);\" href=\"$livro_link\" class=\"btn btn-xs btn-success\">$livro_categoria</a></td>
		</tr>";
	}
	echo "</table>";	
}
?>


<div class="pagination" align="center">                          

<?php
$pgs = ceil($total_livros / $maximo);  
    if($pgs > 1 ) {  
        // Mostragem de pagina  
        if($menos > 0) {  
           echo "<li class=\"pagination\"><a href=\"?pagina=$menos&\">«</a></li>
		   ";  
        }  
        // Listando as paginas  
        for($i=1;$i <= $pgs;$i++) {  
            if($i != $pagina) {  
               echo "<li class=\"pagination_box\"><a href=\"?pagina=".($i)."\">$i</a></li>
			   ";  
            } else {  
                echo "<li class=\"pagination_box\"><strong lass='texto_paginacao_pgatual'>".$i."</strong></li>";  
            }  
        }  
        if($mais <= $pgs) {  
           echo "<li class=\"pagination_box\"><a href=\"?pagina=$mais&\">»</a></li>
		   ";  
        }  
    }    

?>
</div>
</div>
</body>
<?php
	include("includes/js.php");
?>

<script language="javascript">
var sbx = window.parent.Shadowbox; 
function openTopSBX(el){ 
  if(sbx){ 
    sbx.open( { content : el.href 
                   , player : 'iframe' 
                   , title : el.title||'' 
                   //could include width/height/options if desired 
                   } 
                ); 
    return false; 
  }else{ //no Shadowbox in parent window! 
    return true; 
  } 
} 
</script>