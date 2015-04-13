<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["id"];
include 'includes/conectar.php';

$sql_dados_disciplina = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $id");
$dados_disciplina = mysql_fetch_array($sql_dados_disciplina);
$ano_grade_disciplina = $dados_disciplina["ano_grade"];
$cod_disciplina = $dados_disciplina["disciplina"];

//PEGA CURSO DA DISCIPLINA
$sql_dados_disciplina2 = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$cod_disciplina%' AND anograde LIKE '%$ano_grade_disciplina%'");
$dados_disciplina2 = mysql_fetch_array($sql_dados_disciplina2);
$nome_disciplina = trim($dados_disciplina2["disciplina"]);
$curso_disciplina = trim($dados_disciplina2["curso"]);


//POST DE ATIVIDADE E QUESTIONÁRIO
 if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome_banco = $_POST["nome_banco"];
	if($nome_banco == "0"){
		echo "<script language=\"javascript\">
			alert('Não há questões disponíveis para montar a prova.');
			window.close();
		</script>
		";
		return;	
	}
	
	$valor = $_POST["valor"];
	$turma_disc = $_POST["id"];
	$curso_disciplina =  $_POST["curso_disciplina"];
	$comum = $_POST["comum"];
	if($comum == ""){
		$curso_disciplina = $curso_disciplina;
	} else {
		$curso_disciplina = "comum";
	}
	$ano_grade_disciplina =  $_POST["ano_grade_disciplina"];
	$cod_disciplina =  $_POST["cod_disciplina"];
	$tentativas = $_POST["tentativas"];
	if(isset($_POST["check_senha"])){
		$senha = "";
	} else {
		$senha = date("His");
	}
	
	$data_hora_inicio = $_POST["a_ini"]."-".$_POST["m_ini"]."-".$_POST["d_ini"]." ".$_POST["hh_ini"].":".$_POST["mm_ini"].":".$_POST["ss_ini"];
	$data_hora_fin = $_POST["a_fin"]."-".$_POST["m_fin"]."-".$_POST["d_fin"]." ".$_POST["hh_fin"].":".$_POST["mm_fin"].":".$_POST["ss_fin"];
	$data_atividade = $_POST["a_ini"]."-".$_POST["m_ini"]."-".$_POST["d_ini"];

	//PEGA BANCO DE QUESTOES BAIXO
	$sql_baixo = mysql_query("SELECT id_bq FROM ea_banco_questao WHERE nome_bq LIKE '%$nome_banco%' AND cursos LIKE '%$curso_disciplina%' AND grau LIKE '%baixo%' LIMIT 1");
	$dados_baixo = mysql_fetch_array($sql_baixo);
	$id_bq_baixo = $dados_baixo["id_bq"];
	$questoes_baixo = $_POST["n_questoes1"];
	
	//PEGA BANCO DE QUESTOES MEDIO
	$sql_medio = mysql_query("SELECT id_bq FROM ea_banco_questao WHERE nome_bq LIKE '%$nome_banco%' AND cursos LIKE '%$curso_disciplina%' AND grau LIKE '%medio%' LIMIT 1");
	$dados_medio = mysql_fetch_array($sql_medio);
	$id_bq_medio = $dados_medio["id_bq"];
	$questoes_medio = $_POST["n_questoes2"];
	
	//PEGA BANCO DE QUESTOES ALTO
	$sql_alto = mysql_query("SELECT id_bq FROM ea_banco_questao WHERE nome_bq LIKE '%$nome_banco%' AND cursos LIKE '%$curso_disciplina%' AND grau LIKE '%alto%' LIMIT 1");
	$dados_alto = mysql_fetch_array($sql_alto);
	$id_bq_alto = $dados_alto["id_bq"];
	$questoes_alto = $_POST["n_questoes3"];
	

		//INSERE DADOS NA TABELA CED_TURMA_ATIV
		mysql_query("INSERT INTO ced_turma_ativ (ref_id,cod_turma_d,grupo_ativ, cod_ativ,data, descricao,valor,id_etapa) VALUES (NULL, '$turma_disc','A','1000','$data_atividade','','$valor','4');");		
		//INSERE DADOS NA TABELA EA_QUESTIONARIO
		mysql_query("INSERT INTO ea_questionario (id_questionario, cod_disc, grupo, turma_disc, id_bq, qtd_questoes, id_bq2, 
		qtd_questoes2, id_bq3, qtd_questoes3, data_inicio, data_fim, valor, senha, tentativas) 
		VALUES (NULL, '$cod_disciplina', '$ano_grade_disciplina', '$turma_disc', '$id_bq_baixo', '$questoes_baixo',
		'$id_bq_medio', '$questoes_medio', '$id_bq_alto', '$questoes_alto', '$data_hora_inicio', '$data_hora_fin', '$valor',
		'$senha','$tentativas')");
		echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Atividade registrada com sucesso!!');
				window.location.href='abrir_avaliacao.php?turma_disc=$turma_disc';
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
                              <b>Agendamento: Avalia&ccedil;&otilde;es Online</b>
                          </header>
                        <div class="panel-body">
<form id="form1" name="form1" method="POST" action="cad_avaliacao.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="curso_disciplina" value="<?php echo $curso_disciplina; ?>" />
<input type="hidden" name="cod_disciplina" value="<?php echo $cod_disciplina; ?>" />
<input type="hidden" name="ano_grade_disciplina" value="<?php echo $ano_grade_disciplina; ?>" />
  <table width="430" border="0" align="center" class="full_table_cad">
        <td width="116">Disciplina</td>
      <td width="304"><input name="nome_disciplina" type="text" readonly id="nome_disciplina" value="<?php echo $dados_disciplina2["disciplina"]; ?>" maxlength="200"/></td>
    </tr>
    <tr>
      <td>Banco de Quest&otilde;es</td>
      <td><select style="width:300px;"name="nome_banco" class="textBox" id="nome_banco" onKeyPress="return arrumaEnter(this, event)">
	<?php
			include('menu/config_drop.php');?>
        <?php
$sql = "SELECT distinct nome_bq FROM ea_banco_questao WHERE (nome_bq LIKE '%$nome_disciplina%' AND cursos LIKE '%$curso_disciplina%') ORDER BY nome_bq";
$result = mysql_query($sql);
$comum = "";
if(mysql_num_rows($result)==0){
	$result=  mysql_query("SELECT distinct nome_bq FROM ea_banco_questao WHERE (nome_bq LIKE '%$nome_disciplina%' AND cursos LIKE '%comum%') ORDER BY nome_bq");
	$comum = "COMUM";
}
if(mysql_num_rows($result)==0){
	 echo "<option value='0'>SEM QUESTÕES DISPONÍVEIS</option>";
}
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . ($row['nome_bq']) . "'>" . (($row['nome_bq'])) . "</option>";
}
?>
      </select>
      <input name="comum" type="hidden" id="comum" value="<?php echo $comum;?>"/></td>
    </tr>
   <tr>
      <td>N&ordm; Quest&otilde;es (Grau: Baixo)</td>
      <td><input name="n_questoes1_exib" type="number" readonly id="n_questoes1_exib" value="5" maxlength="3"/>
      <input name="n_questoes1" type="hidden" id="n_questoes1" value="5" maxlength="5"/></td>
    </tr>
      <tr>
      <td>N&ordm; Quest&otilde;es (Grau: M&eacute;dio)</td>
      <td><input name="n_questoes2_exib" type="number" readonly id="n_questoes2_exib" value="3" maxlength="3"/>
      <input name="n_questoes2" type="hidden" id="n_questoes2" value="3" maxlength="5"/></td>
    </tr>
    </tr>
    <tr>
      <td>N&ordm; Quest&otilde;es (Grau: Alto)</td>
      <td><input name="n_questoes3_exib" type="number" readonly id="n_questoes3_exib" value="2" maxlength="3"/>
      <input name="n_questoes3" type="hidden" id="n_questoes3" value="2" maxlength="5"/></td>
    </tr>
    <tr>
      <td>N&ordm; de Tentativas</td>
      <td><input name="tentativas_exib" type="number" readonly id="tentativas_exib" value="1" maxlength="3"/>
      <input name="tentativas" type="hidden" id="tentativas" value="1" maxlength="5"/></td>
    </tr>
    <tr>
      <td>Valor</td>
      <td><input name="valor" type="number" id="valor" required="required" value="30" maxlength="10"/></td>
    </tr>
<tr>
    <td align="right">                   
     <b>Data de In&iacute;cio: </b>
     </td>
     <td> 
     <select name="d_ini" style="width:auto;" id="d_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">DD</option>
     <?php $dia = 1;
while($dia<=31){
	$dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
   echo "<option value='$dia'>$dia</option>";
   $dia++;
}?>
	</select>    
    
    
    <select  name="m_ini" style="width:auto;" id="m_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">MM</option>
     <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
	</select>
    
    <select  name="a_ini" style="width:auto;" id="a_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="0000">AAAA</option>
     <?php $ano = date('Y');
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
	</select></td>
    </tr>
    <tr>
    <td align="right"> 
	<b>Hor&aacute;rio de In&iacute;cio: </b>
    </td>
    <td>
     <select name="hh_ini" style="width:auto;" id="hh_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Hora</option>
     <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
	</select>    
    
    
    <select  name="mm_ini" style="width:auto;" id="mm_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Min.</option>
     <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
	</select>
    
    <select name="ss_ini" style="width:auto;" id="ss_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Seg.</option>
     <?php $ss = 0;
while($ss<=59){
	$ss = str_pad($ss, 2, "0", STR_PAD_LEFT);
   echo "<option value='$ss'>$ss</option>";
   $ss++;
}?>
	</select>
    </td>
    
</tr>

<tr>
    <td align="right">                   
     <b>Data Final: </b>
     </td>
     <td> 
     <select name="d_fin" style="width:auto;" id="d_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">DD</option>
     <?php $dia = 1;
while($dia<=31){
	$dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
   echo "<option value='$dia'>$dia</option>";
   $dia++;
}?>
	</select>    
    
    
    <select name="m_fin" style="width:auto;" id="m_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">MM</option>
     <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
	</select>
    
    <select name="a_fin" style="width:auto;" id="a_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="0000">AAAA</option>
     <?php $ano = date('Y');
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
	</select></td>
    </tr>
    <tr>
    <td align="right"> 
	<b>Hor&aacute;rio de T&eacute;rmino: </b>
    </td>
    <td>
     <select name="hh_fin" style="width:auto;" id="hh_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Hora</option>
     <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
	</select>    
    
    
    <select name="mm_fin" style="width:auto;" id="mm_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Min.</option>
     <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
	</select>
    
    <select name="ss_fin" style="width:auto;" id="ss_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="00">Seg.</option>
     <?php $ss = 0;
while($ss<=59){
	$ss = str_pad($ss, 2, "0", STR_PAD_LEFT);
   echo "<option value='$ss'>$ss</option>";
   $ss++;
}?>
	</select>
    </td>
    
</tr>
<tr>
	<td colspan="2" align="center"><input type="checkbox" name="check_senha"> Essa atividade n&atilde;o requer senha.<br><font size="-2">Aten&ccedil;&atilde;o: Caso essa op&ccedil;&atilde;o seja marcada a prova n&atilde;o ter&aacute; senha de acesso.</font></td>
</tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>            
                          </div>
                          <div class="panel-footer">
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