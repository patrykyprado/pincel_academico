<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["codigo"];

$re    = mysql_query("select count(*) as total from geral WHERE codigo = $id" );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from alunos WHERE codigo LIKE $id");
	$dados = mysql_fetch_array($re);	
	$pesq = mysql_query("select distinct ref_id, codigo, turno, curso, nivel, modulo, grupo, unidade, polo from geral WHERE codigo = $id" );
	$ocorrencias = mysql_query("select * from ocorrencias WHERE matricula = $id" );
	
	$sql_perfil    = mysql_query("select * from acessos_completos WHERE usuario = $id");
	$dados_perfil = mysql_fetch_array($sql_perfil);	
	$perfil_senha = substr($dados_perfil["senha"],0,3)."***";	
	
	//pega data de matricula
	$sql_matricula = mysql_query("SELECT * FROM baixas WHERE codigo = $id");
	$dados_matricula = mysql_fetch_array($sql_matricula);
	

}
$nome = strtoupper($dados["nome"]);
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
                              <b>Ficha de Matr&iacute;cula - <a href="ficha_dados.php?codigo=<?php echo $id; ?>">Outros dados</a></b>
                          </header>
                          </div>
                        <div class="panel-body">
<table width="98%" class="full_table_list" border="1" style="font-size:12px">
      <tr>
        <td width="15%" align="center"><img src="images/logo-color.png" /></td>
        <td colspan="3" align="center" ><B><font size="+1">FICHA DE MATR&Iacute;CULA - <?php echo $id; ?></font></B></td>
      </tr>
      <tr>
      <td colspan="4" bgcolor="#C0C0C0" align="center"><b>DADOS DO ALUNO</b></td>
      </tr>
      <tr cellpadding="3">
        <td colspan="3">Matr&iacutecula: <b><?php echo $dados["codigo"];?></b> <br />
        Aluno(a): <b><?php echo ($dados["nome"]);?></b><br />
		E-mail: <b><?php echo strtolower(($dados["email"]));?></b><br />
        Telefone(s): <b><?php echo ($dados["telefone"])." / ".($dados["celular"]);?></b><br />
        Endere&ccedil;o: <b><?php echo ($dados["endereco"]);?></b><br />
        Bairro: <b><?php echo ($dados["bairro"]);?></b><br />
        Cidade: <b><?php echo ($dados["cidade"]);?></b><br />
        CEP: <b><?php echo ($dados["cep"]);?></b><br />
        Data da Matr&iacutecula: <b><?php echo format_data($dados_matricula["data_pagto"]);?></b></td>
        <td width="38%" align="right"><a href="javascript:abrir('foto_academica.php?id=<?php echo $id;?>');"><img src="../<?php echo $dados_perfil["foto_academica"];?>" /></a></td>
      </tr>
      <tr cellpadding="3">
      <td colspan="4" bgcolor="#C0C0C0" align="center"><b>DADOS RESPONS&Aacute;VEL FINANCEIRO</b></td>
      </tr>
      <tr cellpadding="3">
      <td colspan="4">
		Nome: <b><?php echo strtoupper(($dados["nome_fin"]));?></b><br />
        CPF: <b><?php echo strtolower(($dados["cpf_fin"]));?></b><br />
        Bairro: <b><?php echo ($dados["bairro_fin"]);?></b><br />
        Cidade: <b><?php echo ($dados["cidade_fin"]);?></b><br />
        Telefone: <b><?php echo ($dados["tel_fin"]);?></b><br />
        </td>
    </tr>  
      
      
      <tr cellpadding="3">
        <td colspan="4" align="center"><B><a href="listar_cursos.php?id=<?php echo $id; ?>">CURSOS CONTRATADOS</B></a></td>
      </tr>
      <tr cellpadding="3">
        <td colspan="4"><table border="1" width="100%"><?php
        while ($dados2 = mysql_fetch_array($pesq)) {
        // enquanto houverem resultados...
		$curso          = ($dados2["curso"]);
		$nivel          = ($dados2["nivel"]);
		$modulo          = ($dados2["modulo"]);
		$grupo          = ($dados2["grupo"]);
		$turno          = ($dados2["turno"]);
		$unidade          = ($dados2["unidade"]);
		$polo          = ($dados2["polo"]);
		$ref_curso          = ($dados2["ref_id"]);
        echo "
		<tr>
			<td>Turno: <b>$turno</b></td>
			<td>$nivel: <b>$curso</b></td>
			<td>Ano/M&oacute;dulo: <b>$modulo</b></td>
			<td>Grupo/Semestre: <b>$grupo</b></td>
			<td>Unidade: <b>$unidade</b></td>
			<td>Polo: <b>$polo</b></td>
			<td align=\"center\"><b><a target=\"_blank\" href=\"copia_contrato.php?matricula=$id&ref_curso=$ref_curso\">[Contrato (2ª Via)]</b></td>
		</tr>
		
		
		\n";
        // exibir a coluna nome e a coluna email
    }
		?></table></td>
      </tr>
      <tr cellpadding="3">
        <td colspan="4" align="center"><strong><a href="javascript:abrir('cad_ocorrencia.php?id=<?php echo $id; ?>')">OBSERVA&Ccedil;&Otilde;ES E OCORR&Ecirc;NCIAS</a></strong></td>
      </tr>
      <tr cellpadding="3">
        <td colspan="4" valign="top"><table border="1" width="100%">
		<tr>
         <td width="1%"><b>ID.</b></td>
         <td width="10%"><b>Data Ocorr&ecirc;ncia</b></td>
         <td width="89%"><b>Ocorr&ecirc;ncia</b></td>
        </tr>
		<?php
        while ($dados3 = mysql_fetch_array($ocorrencias)) {
        // enquanto houverem resultados...
		$n_ocorrencia          = ($dados3["n_ocorrencia"]);
		$ocorrencia          = ($dados3["ocorrencia"]);
		$dataoc          = substr($dados3["data"],8,2)."/".substr($dados3["data"],5,2)."/".substr($dados3["data"],0,4);
        echo "
		<tr>
			<td><b>$n_ocorrencia</b></td>
			<td><b>$dataoc</b></td>
			<td><b>$ocorrencia</b></td>
		</tr>
		\n";
        // exibir a coluna nome e a coluna email
    	} 
		?></table></td>
      </tr>
</table>
<div class="filtro">
<table width="100%" class="" border="1">
<tr>
<td colspan="10" align="center" bgcolor="#D5D5D5"><b>Turmas Vinculadas</b></td>
</tr>
<?php
$sql_turmas = mysql_query("SELECT * FROM ced_turma_aluno WHERE matricula = $id ORDER BY id_turma");
if(mysql_num_rows($sql_turmas) >= 1){
	echo "<tr>
	<td align=\"center\"><b>Turma</b></td>
	<td align=\"center\"><b>N&iacute;vel</b></td>
	<td align=\"center\"><b>Curso</b></td>
	<td align=\"center\"><b>M&oacute;dulo</b></td>
	<td align=\"center\"><b>Unidade</b></td>
	<td align=\"center\"><b>Polo</b></td>
	<td align=\"center\"><b>Grupo</b></td>
	<td align=\"center\"><b>Boletim Acadêmico</b></td>
	<td align=\"center\"><b>Rematrícula</b></td>
	</tr>";
	while($dados_turmas = mysql_fetch_array($sql_turmas)){
		$id_turma = $dados_turmas["id_turma"];	
		$sql_turma2 = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma ORDER BY id_turma");
		$dados_turma2 = mysql_fetch_array($sql_turma2);
		$turma_nivel = strtoupper($dados_turma2["nivel"]);	
		$turma_curso = strtoupper($dados_turma2["curso"]);	
		$turma_modulo = strtoupper($dados_turma2["modulo"]);	
		$turma_unidade = trim(strtoupper($dados_turma2["unidade"]));	
		$turma_polo = strtoupper($dados_turma2["polo"]);
		$turma_grupo = strtoupper($dados_turma2["grupo"]);	
		$turma_cod = strtoupper($dados_turma2["cod_turma"]);
		if($turma_unidade != ""){	
			echo "<tr>
		<td align=\"center\"><b><a href=\"aproveitamento_disciplinas.php?id_turma=$id_turma&matricula=$id\">$turma_cod</a></b></td>
		<td align=\"center\"><b>$turma_nivel</b></td>
		<td align=\"center\"><b>$turma_curso</b></td>
		<td align=\"center\"><b>$turma_modulo</b></td>
		<td align=\"center\"><b>$turma_unidade</b></td>
		<td align=\"center\"><b>$turma_polo</b></td>
		<td align=\"center\"><b>$turma_grupo</b></td>
		<td align=\"center\"><b><a href=\"gerar_boletim_turma.php?id_turma=$id_turma&id_aluno=$id\" target=\"_blank\">[GERAR BOLETIM]</a></b></td>
		<td align=\"center\"><b><a href=\"gerar_rematricula.php?id_turma=$id_turma&matricula=$id&garantia=1\" target=\"_blank\">[REMATR&Iacute;CULA]</a></b></td>
		</tr>";
		}
	}
}


?>
</table>

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