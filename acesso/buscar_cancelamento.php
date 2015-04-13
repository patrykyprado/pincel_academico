<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["codigo"];
$alunobusca = mysql_query("SELECT nome FROM alunos WHERE codigo = $id");
$dadosaluno = mysql_fetch_array($alunobusca);
$alunonome = $dadosaluno["nome"];
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
                              <b>C&oacute;digo do Aluno: <?php echo $id; ?>
                              <br>Nome do Aluno: <?php echo $alunonome; ?></b>
                          </header>
                          <div class="panel-body">

<table class="table table-hover" width="100%" border="1" style="font-size:12px;">
	<tr bgcolor="#DFDFDF">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>C&oacute;d. Turma</strong></div></td>
        <td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>M&oacute;dulo</strong></div></td>
        <td><div align="center"><strong>Turno</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Polo</strong></div></td>
	</tr>

<?php

$sql = mysql_query("SELECT DISTINCT ct.* 
FROM ced_turma_aluno cta
INNER JOIN  ced_turma ct
ON ct.id_turma = cta.id_turma
WHERE cta.matricula = $id ORDER BY ct.grupo
");



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA TURMA VINCULADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	

    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$id_turma          = $dados["id_turma"];
		$grupo_turma          = $dados["grupo"];
		$cod_turma          = $dados["cod_turma"];
		$curso_turma          = $dados["nivel"].": ".$dados["curso"];
		$modulo_turma          = $dados["modulo"];
		$turno_turma          = $dados["turno"];
		$unidade_turma          = $dados["unidade"];
		$polo_turma          = $dados["polo"];
		
		
		
		
		
        echo "
	<tr bgcolor=\"$bgstatus\">
		<td valign=\"middle\" align='center'><a target=\"frame_cancel\" href=\"cancelamento_disciplinas_turma.php?id_turma=$id_turma&id_aluno=$id\"><font size=\"+1\"><div class=\"fa fa-th-list tooltips\" data-placement=\"right\" data-original-title=\"Cancelar Aluno\"></div></font></a></td>
		<td  valign=\"middle\" align=\"center\">$grupo_turma</td>
		<td  valign=\"middle\" align=\"center\">$cod_turma</td>
		<td  valign=\"middle\" align=\"center\">$curso_turma </td>
		<td  valign=\"middle\" align=\"center\">$modulo_turma</td>
		<td  valign=\"middle\" align=\"center\">$turno_turma</td>
		<td  valign=\"middle\" align=\"center\">$unidade_turma</td>
		<td  valign=\"middle\" align=\"center\">$polo_turma</td>

		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

</table>
</form>

<iframe name="frame_cancel" id="frame_cancel" frameborder="0" width="100%"></iframe>
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
 