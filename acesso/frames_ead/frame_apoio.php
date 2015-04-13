<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementsByName("frm-noticias").height = 100;
     }
    </script>
    
<?php 
include('../includes/conectar.php');
$cod_disc = $_GET["cod_disc"];
$cod_ativ = $_GET["cod_ativ"];
$turma_disc = $_GET["turma_disc"];
$anograde = $_GET["anograde"];
if(isset($_GET["edicao"])){
	$_SESSION["edicao"] = $_GET["edicao"];
	$edicao = $_GET["edicao"];
} else {
	$_SESSION["edicao"] = 0;
	$edicao = 0;
}
$sql_atividade = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' AND cod_ativ = '$cod_ativ' ORDER BY ordem_ativ");
$dados_atividade = mysql_fetch_array($sql_atividade);
$conteudo_atividade = $dados_atividade["conteudo"];
$tipo_atividade = $dados_atividade["tipo"];

$sql_tipo_atividade = mysql_query("SELECT * FROM ea_tipo_ativ WHERE  cod_tipo = '$tipo_atividade'");
$dados_tipo_atividade = mysql_fetch_array($sql_tipo_atividade);

$nome_atividade = $dados_tipo_atividade["tipo"];

?>
<div id="central">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#2a3542" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade);
?>
</font>
 - 
<font size="-1" color="#FFFFFF">(Alguns links e conte&uacute;dos sugeridos nesta disciplina n&atilde;o s&atilde;o de propriedade do CEDTEC. Pedimos aten&ccedil;&atilde;o em rela&ccedil;&atilde;o aos direitos autorais e de propriedade dos seus autores).</font>
</td>
</tr>
</table>

<hr>

<?php
$sql_apoio = mysql_query("SELECT * FROM ea_tipo_apoio");
while($dados_apoio = mysql_fetch_array($sql_apoio)){
	$apoio_tipo = $dados_apoio["tipo_apoio"];
	$apoio_id = $dados_apoio["id_apoio"];
	
	echo "
<table width=\"100%\" align=\"center\" cellpadding=\"4\" cellspacing=\"4\">
<tr>
<td colspan=\"3\" align=\"left\"><font size=\"+2\"><b>$apoio_tipo</b></font>
</td>
</tr>
";
	$sql_buscar_material = mysql_query("SELECT * FROM ea_apoio WHERE (tipo_apoio = $apoio_id AND ano_grade LIKE '$anograde' AND cod_disc LIKE '$cod_disc') OR (tipo_apoio = $apoio_id AND turma_disc LIKE '$turma_disc')");	
	while($dados_material = mysql_fetch_array($sql_buscar_material)){
		$material_titulo = $dados_material["titulo"];
		$material_conteudo = $dados_material["conteudo"];

			echo "
			<tr>
<td colspan=\"3\" align=\"left\"> &emsp; &emsp; &bull; <b><a target=\"_blank\" href=\"$material_conteudo\">$material_titulo</a></b>
</td>
</tr>";
	}

}
?>
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