<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$turma_disc = $_GET["td"];


$sql_td = mysql_query("SELECT id_turma FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_td = mysql_fetch_array($sql_td);
$id_turma = $dados_td["id_turma"];

$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_disc 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
 
 
 //enviar post 
 if( isset ( $_POST[ 'Salvar' ] ) ) {
		              for( $i = 0 , $x = count( $_POST[ 'mat_aluno' ] ) ; $i < $x ; ++ $i ) {
						  $pesquisar = mysql_query("SELECT * FROM ced_notas WHERE  matricula = '".$_POST[ 'mat_aluno' ][ $i ]."' AND ref_ativ = '".$_POST[ 'ref_ativ' ][ $i ]."' AND turma_disc = '".$_POST[ 'cod_t_d' ][ $i ]."'");
						  $total = mysql_num_rows($pesquisar);
						  $status = str_replace(",",".",$_POST[ 'nota' ][ $i ]);
						  if(empty($status)){
							  $status = 0;
						  }
						  $maxnota = $_POST[ 'maxnota' ][ $i ];
						 
						  if($total == 0&&$status >0){
							mysql_query("INSERT INTO ced_notas (codnota, matricula, ref_ativ, turma_disc, grupo, nota) VALUES (NULL, '".$_POST[ 'mat_aluno' ][ $i ]."','".$_POST[ 'ref_ativ' ][ $i ]."', '$turma_disc','".$_POST[ 'grupoativ' ][ $i ]."','$status');");
						  } else {
							mysql_query("UPDATE ced_notas SET nota = '$status' WHERE  matricula = '".$_POST[ 'mat_aluno' ][ $i ]."' AND ref_ativ = '".$_POST[ 'ref_ativ' ][ $i ]."' AND turma_disc = '".$_POST[ 'cod_t_d' ][ $i ]."';");
						  }
							  
						 
		              }
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Notas atualizadas com sucesso');
						window.parent.location.reload();
						window.parent.Shadowbox.close();
						</SCRIPT>");	 
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
                              <b>Registro de Notas</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" >

  <table width="100%" border="1" align="center" class="full_table_list2">
        
    <tr bgcolor="#E3E3E3">
    <td><b>NOME</b></td>
   
    <?php
	//PEGA ATIVIDADES LANÇADAS PARA A TURMA DISCIPLINA
	$pesquisar = mysql_query("SELECT ref_id,cod_ativ, id_etapa, data, descricao  FROM ced_turma_ativ WHERE cod_turma_d = $turma_disc");
	$total = mysql_num_rows($pesquisar);
		while($dados_ativ = mysql_fetch_array($pesquisar)){
			$ref_id = $dados_ativ["ref_id"];
			$cod_ativ = $dados_ativ["cod_ativ"];
			$etapa_ativ = $dados_ativ["id_etapa"];
			//pesquisa o nome da etapa
			$sql_etapa = mysql_query("SELECT etapa FROM ced_etapas WHERE id_etapa = $etapa_ativ");
			$dados_etapa = mysql_fetch_array($sql_etapa);
			$nome_etapa = $dados_etapa["etapa"];
			$desc_ativ = $dados_ativ["descricao"];
			$data_ativ = substr($dados_ativ["data"],8,2)."/".substr($dados_ativ["data"],5,2)."/".substr($dados_ativ["data"],0,4);
			$nome_ativ = mysql_query("SELECT atividade FROM ced_desc_nota WHERE  codigo = $cod_ativ;");
			$dados_atividade = mysql_fetch_array($nome_ativ);
			$nome_atividade = $dados_atividade["atividade"];
			echo "<td><a href=\"editar_atividade.php?id_atividade=$ref_id&turma=$turma_disc\" title=\"$desc_ativ\"><center><b>$nome_atividade<br><font size='-1'>($data_ativ)</font><br><font size='-1'>($nome_etapa)</font></b></a><br><font-size='-2'><a href=\"excluir_atividade.php?id=$ref_id\">[EXCLUIR]</font></a></center></td>";
			}
	
	?>
    </tr>
<?php 
//PEGA MATRÍCULA E NOME DO ALUNO
	while($dados = mysql_fetch_array($sql)){
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		
			
		
?>


<?php
			
		echo "<tr><td>$nome</td>";
		//verifica cancelados
			$sql_cancelados = mysql_query("SELECT toc.nome, oco.data FROM ocorrencias oco
INNER JOIN tipo_ocorrencia toc
ON oco.n_ocorrencia = toc.id
WHERE oco.n_ocorrencia = 1 AND oco.matricula = $codigo AND oco.id_turma = $id_turma LIMIT 1");
			if(mysql_num_rows($sql_cancelados)>=1){
				$dados_cancelados = mysql_fetch_array($sql_cancelados);
				$nome_ocorrencia = $dados_cancelados["nome"];
				$data_ocorrencia = format_data($dados_cancelados["data"]);
				echo "<td align=\"center\" colspan=\"$total\">$nome_ocorrencia em $data_ocorrencia.</td></tr>";
			} else {
		
		//PEGA CODIGO DE ATIVIDADES
		$pesquisar = mysql_query("SELECT ref_id, cod_ativ, valor, grupo_ativ, data FROM ced_turma_ativ WHERE  cod_turma_d = $turma_disc;");
		$total = mysql_num_rows($pesquisar);
		while($dados_ativ = mysql_fetch_array($pesquisar)){
			$ref_id = $dados_ativ["ref_id"];
			$cod_ativ = $dados_ativ["cod_ativ"];
			$valor_ativ = $dados_ativ["valor"];
			$grupo_ativ = $dados_ativ["grupo_ativ"];
			$data_ativ = substr($dados_ativ["data"],8,2)."/".substr($dados_ativ["data"],5,2)."/".substr($dados_ativ["data"],0,4);
			$nome_ativ = mysql_query("SELECT atividade FROM ced_desc_nota WHERE  codigo = $cod_ativ;");
			$dados_atividade = mysql_fetch_array($nome_ativ);
			$nome_atividade = $dados_atividade["atividade"];
			//pesquisa notas anteriores
			$pesq_nota = mysql_query("SELECT nota FROM ced_notas WHERE matricula = $codigo AND ref_ativ = $ref_id AND turma_disc = $turma_disc");
			$contar_nota = mysql_num_rows($pesq_nota);
			if($contar_nota == 0){
				$nota_aluno = 0;
			} else {
				$dados_nota = mysql_fetch_array($pesq_nota);
				$nota_aluno = $dados_nota["nota"];
			}
			
			echo "<td align=\"center\"><input type=\"text\" name=\"nota[]\" id=\"nota[]\" value=\"$nota_aluno\" style=\"width:50px\" /> <b> | <font color=\"red\">$valor_ativ</font></b>
				<input type=\"hidden\" name=\"mat_aluno[]\" id=\"mat_aluno[]\" value=\"$codigo\" />
				<input type=\"hidden\" name=\"ref_ativ[]\" id=\"ref_ativ[]\" value=\"$ref_id\" />
				<input type=\"hidden\" name=\"cod_t_d[]\" id=\"cod_t_d[]\" value=\"$turma_disc\" />
				<input type=\"hidden\" name=\"grupoativ[]\" id=\"grupoativ[]\" value=\"$grupo_ativ\" />
				<input type=\"hidden\" name=\"maxnota[]\" id=\"maxnota[]\" value=\"$valor_ativ\" />
				</td>";
			}
		}
		
		
		
		"</tr>";
		
		
		
	}
	



?>
  
    
    <tr>
      <td colspan="<?php echo $total+1;?>" align="center"><input type="submit" name="Salvar" id="Salvar"  class="botao" value="Salvar"/></td>
    </tr>
  </table>
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
  <script language="javascript">
function SomenteNumero()  
{  
 if (event.keyCode<48 || event.keyCode>57)  
 {  
  return false;  
 }  
}  
</script>