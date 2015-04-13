<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

//GET DE PESQUISA
$inicio = $_GET['dataini'];
$fim = $_GET['datafin'];

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
                              <b>Pesquisa de T&iacute;tulos a Receber</b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="get" action="buscar_receitas.php">
Nome: 
    <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Filtrar" id="Buscar" value="Pesquisar" />
  <input class="botao" type="button" name="acessar" id="acessar" onclick="javascript:pesquisar()" value="PESQUISAR TITULO" />
</form>
<form id="form1" name="form1" method="get" action="data_receitas.php">
  De: 
  <input type="date" name="dataini" id="dataini" value="<?php echo $inicio;?>"/>
At&eacute;: 
<input type="date" name="datafin" id="datafin" value="<?php echo $fim;?>" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<BR />
<hr>
 <table width="100%" border="1" class="table table-hover">
	<tr bgcolor="#DFDFDF">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Cliente / Fornecedor</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';
if($user_unidade==""){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 2 AND (vencimento BETWEEN '$inicio' AND '$fim') AND valor_pagto = 0 AND data_pagto =''");
} else {
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 2 AND (vencimento BETWEEN '$inicio' AND '$fim') AND valor_pagto = 0 AND data_pagto ='' AND conta_nome LIKE '%$user_unidade%'");
}

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
  while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = strtoupper($dados["nome"]);
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"];
		$valortitulofinal	= number_format($valortitulo, 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = $dados["valor_pagto"];
		$ccusto          = $dados["c_custo"];
		$layout          = $dados["layout"];
		$conta          = $dados["conta_nome"];
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
        echo "
	<tr>
		<td valign=\"middle\" align='center'>&nbsp;<a rel=\"shadowbox\" href=\"editar.php?id=$idtitulo\"><font size=\"+1\"><div class=\"fa fa-edit tooltips\" data-placement=\"right\" data-original-title=\"Editar Título\"></div></font></a> <a href=\"../boleto/$layout?id=$idtitulo&p=$parcela&id2=$idcli&refreshed=no\" target=\"_blank\"><font size=\"+1\"><div class=\"fa fa-barcode tooltips\" data-placement=\"right\" data-original-title=\"Gerar Boleto\"></div></font></a></td>
		<td>&nbsp;<a href='buscar_receitas2.php?id=$idcli&aluno=$cliente'>$cliente</a></td>
		<td align=\"center\">$parcela</td>
		<td>$venc</td>
		<td><center>R$ $valortitulofinal</center></td>
		<td>$conta</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
</table>
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
    
    
<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('projeto').disabled = false;  
    } else {  
        document.getElementById('projeto').disabled = true;  
    }  
}  
</script> 
