<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["id"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$matricula           = $_POST["id"];
	$get_fin           = $_POST["fin"];
	$modulo = strtoupper(($_POST["mod"]));
	$curso = ($_POST["curso"]); 
	$nivel = ($_POST["tipo"]); 
	$turno = strtoupper(($_POST["turno"])); 
	$grupo = strtoupper(($_POST["grupo"])); 
	$unidade = strtoupper(($_POST["unidade"])); 


if($unidade == 'EAD') {
	$polo = strtoupper(($_POST["polo"])); 
} else {
	$polo = $unidade;
}

include('includes/conectar.php');



if(@mysql_query("INSERT INTO curso_aluno (matricula, nivel, curso, modulo, grupo, turno, unidade, polo)
VALUES ('$matricula','$nivel','$curso','$modulo','$grupo','$turno','$unidade','$polo')")) {
	
	if(mysql_affected_rows() == 1){

		//PEGA VALOR DA PARCELA DO CURSO
		$cursopesq    = mysql_query("SELECT * FROM cursos_rematricula WHERE nivel LIKE '%$nivel%' AND modulo = '$modulo' 
		AND curso LIKE '%$curso%' AND grupo LIKE '%$grupo%' ");
		if(mysql_num_rows($cursopesq)==0){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Período de rematrícula ainda não foi liberado no sistema, contate o setor financeiro.');
			window.parent.Shadowbox.close();
			</SCRIPT>");
			return;
		}
			$dadoscur = mysql_fetch_array($cursopesq);
			$curso_valor = $dadoscur["valor_parcela"];
			$parcelas = 2;
			$curso_vencimento = $dadoscur["inicio_vencimento"];
			$curso_conta = $dadoscur["conta"];
			
			
			
			// CENTRO DE CUSTO EMPRESA 1
			$cc1 = 10;
										
			// CENTRO DE CUSTO FILIAL 2
			$cc2 = mysql_query("SELECT * FROM cc2 WHERE nome_filial LIKE '%$unidade%'");
			$c2dados = mysql_fetch_array($cc2);
			$cc2final = $c2dados["id_filial"];
																
			// CENTRO DE CUSTO 3
			$cc3 = 21;
										
			// CENTRO DE CUSTO 4									
			$cc4 = mysql_query("SELECT * FROM cc4 WHERE nome_cc4 LIKE '%$nivel%'");
			$c4dados = mysql_fetch_array($cc4);
			$cc4final = $c4dados["cc4"];
										
			// CENTRO DE CUSTO DO CURSO 5
			$cc5    = mysql_query("SELECT * FROM cc5 WHERE nome_cc5 LIKE '%$curso%' AND id_cc5 LIKE '%$cc4final%'");
			$cdados = mysql_fetch_array($cc5);
			$cc5final = $cdados["cc5"];
										
			// CENTRO DE CUSTO FINAL
			$c_custo = $cc1.$cc2final.$cc3.$cc4final.$cc5final;
			
			
			//GERA TITULOS
			$vencimento = date("Y-m-d",strtotime(date("Y-m-d", strtotime($curso_vencimento)) . " +1 month"));
			$datadoc = date('Y-m-d');
			
			//pega dados de desconto se houver
	$sql_desconto = mysql_query("SELECT * FROM ced_bolsas WHERE matricula = '$matricula' AND curso = '$cod_curso'");
	if(mysql_num_rows($sql_desconto)==0){
		$desconto_bolsa = $desconto;	
	} else {
		$dados_desconto = mysql_fetch_array($sql_desconto);
		$desconto_bolsa = $dados_desconto["desconto"];
	}
			
			if($get_fin == 1){
				$parcela = 6;
			while($parcelas <= $parcela){
				if(@mysql_query("INSERT INTO titulos(cliente_fornecedor,dt_doc, descricao, vencimento, valor,desconto, parcela, tipo, c_custo,valor_pagto,conta) VALUES( $matricula,'$datadoc','Boleto de Aluno','$vencimento','$curso_valor','$desconto_bolsa','$parcelas','2','$c_custo','','$curso_conta')")) {
											
					if(mysql_affected_rows() == 1){
						$parcelas += 1;
						for ($i = 1; $i <= $parcelas; $i++)
						$vencimento = date("Y-m-d", strtotime(" " . $i-1 . " Month", strtotime($curso_vencimento)));
						}
					} else {
						if(mysql_errno() == 1062) {
							echo $erros[mysql_errno()];
								exit;
						} else {	
							echo "";
							exit;
						}
						}
						}	
			}
			
			//MENSAGEM DE CONFIRMAÇÃO
				echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Dados atualizados com sucesso');
				window.parent.Shadowbox.close();
				</SCRIPT>");
				return;
			}	
		
		} else {
			if(mysql_errno() == 1062) {
				echo $erros[mysql_errno()];
				exit;
			} else {	
				echo "Não foi possível atualizar os dados.";
				exit;
			}	
		}

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
                          <div class="filtro"><header class="panel-heading">
                              <b>Cadastro de Curso</b>
                          </header>
                          </div>
                        <div class="panel-body">
<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="430" border="0" align="center" class="full_table_cad">
        <td width="116">Matr&iacute;cula</td>
      <td width="304"><input name="nome" type="text" readonly class="textBox" id="nome" value="<?php echo $id; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>N&iacute;vel</td>
      <td><select style="width:300px;"name="tipo" class="textBox" id="tipo" onKeyPress="return arrumaEnter(this, event)">
        
	<option value="Selecione">- Selecione o Tipo -</option>	
	<?php
			include('menu/config_drop.php');?>
        <?php
$sql = "SELECT distinct tipo FROM cursosead ORDER BY tipo";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . ($row['tipo']) . "'>" . (($row['tipo'])) . "</option>";
}
?>
      </select></td>
    </tr>
   <tr>
      <td>Curso</td>
      <td><select style="width:300px;"name="curso" class="textBox" id="curso" onKeyPress="return arrumaEnter(this, event)">
        
      </select></td>
    </tr>
   <tr>
      <td>M&oacute;dulo</td>
      <td><select style="width:300px;"name="mod" class="textBox" id="mod" onKeyPress="return arrumaEnter(this, event)">
        <option value="1" selected="selected">M&oacute;dulo I</option>
        <option value="2">M&oacute;dulo II</option>
        <option value="3">M&oacute;dulo III</option>
        
      </select></td>
    </tr>
    <tr>
      <td>Turno</td>
      <td><select style="width:300px;"name="turno" class="textBox" id="turno" onKeyPress="return arrumaEnter(this, event)">
        <?php
$sql = "SELECT distinct turno FROM cursosead ORDER BY turno";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['turno'] . "'>" . (($row['turno'])) . "</option>";
}
?>
      </select></td>
    </tr>
    <tr>
      <td>Grupo</td>
      <td><select style="width:300px;"name="grupo" class="textBox" id="grupo" onKeyPress="return arrumaEnter(this, event)">

        <?php
$sql = "SELECT distinct grupo FROM grupos ORDER BY vencimento";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . (($row['grupo'])) . "</option>";
}
?>
      </select></td>
    </tr>
    
    <tr>
      <td>Unidade</td>
      <td><select style="width:300px;"name="unidade" class="textBox" id="unidade" onKeyPress="return arrumaEnter(this, event)">
   
        <?php
$sql = "SELECT distinct unidade FROM unidades ORDER BY unidade";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . strtoupper($row['unidade']) . "'>" . strtoupper($row['unidade']) . "</option>";
}
?>
      </select></td>
    </tr>
<tr>
      <td>Polo (somente se for unidade EAD)</td>
      <td><select style="width:300px;"name="polo" class="textBox" id="polo" onKeyPress="return arrumaEnter(this, event)">
        <?php
$sql = "SELECT distinct unidade FROM unidades WHERE unidade NOT LIKE 'EAD' ORDER BY unidade";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . strtoupper($row['unidade']) . "'>" . strtoupper($row['unidade']) . "</option>";
}
?>
      </select></td>
    </tr>
    
<tr>
      <td>Gerar Financeiro</td>
      <td><select style="width:300px;"name="fin" class="textBox" id="fin" onKeyPress="return arrumaEnter(this, event)">
       <option value="2" selected="selected">N&atilde;o</option>
       <option value="1">Sim</option>
      
      
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>

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
  
  	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cursoexib + '">' + j[i].cursoexib + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="selecione">– Selecione o Curso –</option>');
				}
			});
		});
		</script>
