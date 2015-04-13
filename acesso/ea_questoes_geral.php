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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body style="overflow:auto;">
<?php
include('includes/conectar.php');
include('includes/funcoes.php');
$post_senha_certa = 1;
$post_senha_dig = 1;

if($post_senha_certa != $post_senha_dig){
	echo "<script language=\"javascript\">
	alert('A senha digitada está incorreta.');
	history.back();
	</script>";
} else {
$id_bqs = $_GET["id_bqs"];

$sql_bancos_questoes = mysql_query("SELECT DISTINCT cursos, nome_bq FROM ea_banco_questao WHERE id_bq IN ($id_bqs)");
$dados_banco_questoes = mysql_fetch_array($sql_bancos_questoes);
$curso_prova = $dados_banco_questoes["cursos"];
$disciplina_prova = $dados_banco_questoes["nome_bq"];

$cod_prova = $cod_disc."_".date("His");



?>

  <body>

<div class="filtro" align="center">
<a href="javascript:window.print()">[IMPRIMIR]</a>
</div>
<div class="prova-escrita">
Cod_Prova: <?php echo $cod_prova;?>
<table width="100%" align="center" border="1" style="color:#000;font-family:Arial, Helvetica, sans-serif;font-size:12px;border:double;">
    <tr>
    	<td width="40%" colspan="2"><img src="images/logo-cedtec.png" /></td>
        <td colspan="2" align="center"><font size="+2"><b>Avalia&ccedil;&atilde;o</b></font></td>
    </tr>
    <tr>
    	<td colspan="2"><b>Curso: <?php echo $curso_prova;?></b></td>
        <td width="60%" colspan="2"><b>Componente Curricular: <?php echo $disciplina_prova; ?></b></td>
    </tr>
</table>
<br /><br />
<?php 

//MONTA TODAS AS QUESTÕES EM FORMATO DE IMPRESSÃO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq IN ($id_bqs) ORDER BY rand()");
$num_questao = 1;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_id_bq = $dados_questao["id_bq"];
	//verifica o nível da questão
	$sql_nivel_questao = mysql_query("SELECT grau FROM ea_banco_questao WHERE id_bq = $questao_id_bq");
	$dados_nivel_questao = mysql_fetch_array($sql_nivel_questao);
	$grau_questao = substr($dados_nivel_questao["grau"],0,1); 
	if($grau_questao == "A"){//alto
		$cor_grau = "#CD5C5C";
	} 
	if($grau_questao == "M"){//medio
		$cor_grau = "#1E90FF";
	}
	if($grau_questao == "B"){//Baixo
		$cor_grau = "#3CB371";
	}
	
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table class=\"full_table_list\" style=\"orphans:3; color:#000;\" width=\"100%\">
	<tr bgcolor=\"#D7D7D7\">
		<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" align=\"center\" valign=\"top\" width=\"17%\"><b>Questão $n_questao:</b></td>
		<td style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;\" colspan=\"2\" valign=\"top\" width=\"80%\"><b><font style=\"font-family:Arial, Helvetica, sans-serif; color:black;\">$questao_questao</font></b></td>
		<td bgcolor=\"$cor_grau\" style=\"color:#FFFAFA;\" align=\"center\">$grau_questao</td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		if($opcaovalor >=1){
			$cor_resposta = "#FFFF00";
		} else {
			$cor_resposta = "";	
		}
		echo "
		<tr bgcolor=\"$cor_resposta\">
			<td align=\"right\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\">$letra_opcao </td>
			<td colspan=\"2\" style=\"font-family:Arial, Helvetica, sans-serif;font-size:10px;\"> $opcaoresposta</td>
		<tr>
		";
		$num_opcao += 1;
		if($opcaovalor >=1){
			$letra_opcao_correta = substr($letra_opcao,0,1);
			$gabarito .= "$n_questao - $letra_opcao_correta ,";	
		}
	}
	$num_questao +=1;
	
 }
 
 
echo "</table>";

}

?>
</div>

      <!--main content end-->

  </section>



  </body>
</html>


  