<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
?>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
// usuário
$user 				=$_SESSION['MM_Username'];
$atual = date("Y-m-d H:i:s");
$ipativo = $_SERVER["REMOTE_ADDR"];
//usuário

$fornecedor        = $_POST["fornecedor"];
$vencimento        = $_POST["vencimento"];
$valor        = $_POST["valor"];
$parcela        = $_POST["parcela"];
$tipo        = $_POST["tipo"];
$dt_doc        = $_POST["dt_doc"];
$desc        = $_POST["descricao"];
$conta 		= $_POST["conta"];
$cc1 		= $user_empresa;
$cc2 		= $_POST["cc2"];
$cc3 		= $_POST["cc3"];
$cc4 		= $_POST["cc4"];
$cc5 		= $_POST["cc5"];
$cc6 		= $_POST["cc6"];
$nfe 		= $_POST["nfe"];
$ccusto        = $cc1.$cc2.$cc3.$cc4.$cc5.$cc6;
$venc = $vencimento;
$valorfinal = $valor/$parcela;
$parcelas = 1;
$valordocfinal		= str_replace(",",".",$valor);
$acrescimo		= str_replace(",",".",$_POST["acrescimo"]);
$desconto		= str_replace(",",".",$_POST["desconto"]);

if($cc3=="19"&&$cc4=="1901"&&$cc5=="003"){
	$status = 2;
} else {
	$status = 0;
}

if($tipo == "selecione"){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('VOCÊ DEVE SELECIONAR O TIPO DE TÍTULO');
		history.back();
		</SCRIPT>");
		return;
		}
		
if(isset($_POST["projeto"])){
	$projeto = $_POST["projeto"];
} else {
	$projeto = "";
	}
	
if($cc3 == 17&&$projeto == ""){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('PARA CADASTRAR UM INVESTIMENTO É NECESSÁRIO SELECIONAR UM PROJETO');
		history.back();
		</SCRIPT>");
		return;
		}


if($cc3 == 17 || $cc3== 00){
	$ebitda = 'N';
} else {
	$ebitda = 'S'; 
}
		
if($tipo == 1){
	$tiponome = "SAÍDA";
}
if($tipo == 2){
	$tiponome = "ENTRADA";
}


	
while($parcelas <= $parcela){
	if(@mysql_query("INSERT INTO titulos (id_titulo, documento_fiscal,projeto, dt_doc, cliente_fornecedor, descricao, vencimento, valor, acrescimo, desconto, juros1, juros2, juros3, juros4, atraso, parcela, data_pagto, valor_pagto, tipo, c_custo, conta, saldo, processamento, status) VALUES (NULL ,'$nfe','$projeto','$dt_doc','$fornecedor','$desc','$vencimento','$valordocfinal','$acrescimo','$desconto','0','0','0','0','NÃO','$parcelas','','', '$tipo','$ccusto','$conta','','','$status')")) {
		if($parcelas == $parcela){
			echo "<script language=\"javascript\">
	alert('$parcela Títulos Gerados Com Sucesso');
	</script>";}
		if(mysql_affected_rows() == 1){
			mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
VALUES ('$user','$atual','03','GEROU UM TITULO DE $tiponome NO VALOR DE R$ $valordocfinal PARA O CLIENTE/FORNECEDOR - $fornecedor','$ipativo');");
			
			$parcelas += 1;
			for ($i = 1; $i <= $parcelas; $i++)
				$vencimento = date("Y-m-d", strtotime(" " . $i-1 . " Month", strtotime($venc)));
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Título não gerado";
			exit;
		}
		@mysql_close();
	}
}
}





$tipo_titulo = $_GET["tipo"];

if($tipo_titulo == 1){
	$tipo_nome = "A Pagar";
	$tipo_sinal = "-";
} else {
	$tipo_nome = "A Receber";
	$tipo_sinal = "+";
}
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
                              <b>Cadastro de Títulos - <?php echo $tipo_nome;?></b>
                          </header>
                          <div class="panel-body">
<form id="form1" name="form1" method="post" action="#">
  <font size="+2" style="text-align:left"></font>
  <table width="95%" border="0" align="center" cellspacing="5" class="full_table_list2" style="text-align:left">
    <td colspan="2" align="center" bgcolor="#C0C0C0"><font size="+1">Informa&ccedil;&otilde;es T&iacute;tulos</font></td>
  	<td width="40%" align="center" bgcolor="#C0C0C0"><font size="+1">Centro de Custo</font></td>
  <tr>
    <td>Conta:</td>
    <td><select name="conta" style="width:300px" class="textBox" id="conta" onKeyPress="return arrumaEnter(this, event)">
      <?php
include("includes/config_drop.php");?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT * FROM contas ORDER BY conta";
	  } else {
		 $sql = "SELECT * FROM contas WHERE conta LIKE '%$user_unidade%' ORDER BY conta";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['ref_conta'] . "'>" . $row['conta'] . "</option>";
}
?>
      </select></td>
    <td align="center"><select name="cc2"  class="textBox" id="cc2" style="width:200px" onKeyPress="return arrumaEnter(this, event)">
      <option value="NULL">SELECIONE A FILIAL</option>
      <?php
include("includes/config_drop.php");?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT * FROM cc2 WHERE niveltxt like '%GERAL%' ORDER BY nome_filial ";
	  } else {
		 $sql = "SELECT * FROM cc2 WHERE nome_filial LIKE '%$user_unidade%' AND niveltxt like '%GERAL%' ORDER BY nome_filial ";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filial'] . "'>" . $row['nome_filial'] . "</option>";
}
?>
      </select></td>
  </tr>
  <tr>
    <td width="18%">Cliente / Fornecedor:</td>
    <td width="45%"><div class="tooltips" data-placement="left" data-original-title="Clique para pesquisar o cliente / fornecedor"><input type="hidden" name="fornecedor" id="fornecedor" onKeyPress="return arrumaEnter(this, event)" />
      <input type="text" name="fornecedor2" id="fornecedor2" readonly onclick="javascript:abrir('pesquisar_clientefornecedor.php')" onKeyPress="return arrumaEnter(this, event)" style="width:300px" /></div></td>
    <td align="center"><select name="cc3" class="textBox"  style="width:200px;" id="cc3" onKeyPress="return arrumaEnter(this, event)">
    <option value="NULL">SELECIONE</option>
      <?php
include("includes/config_drop.php");?>
      <?php
$sql = "SELECT * FROM cc3 WHERE  tipo LIKE '%$tipo_sinal%' OR id_cc3 = '90' ORDER BY id_cc3";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc3'] . "'>" . $row['nome_cc3'] . "</option>";
}
?>
      </select></td>
  </tr>
  <tr>
    <td>Nota Fiscal:</td>
    <td><input type="text" name="nfe" id="nfe" onKeyPress="return arrumaEnter(this, event)" /></td>
    <td align="center"><select name="cc4" class="textBox" id="cc4"  style="width:200px;" onKeyPress="return arrumaEnter(this, event)">
    <option value="NULL">SELECIONE</option>
      
      </select></td>
  </tr>
  <tr>
    <td>Data do Documento:</td>
    <td><input type="date" name="dt_doc" id="dt_doc" onKeyPress="return arrumaEnter(this, event)" />
    </td>
    <td align="center"><select name="cc5" class="textBox" id="cc5" style="width:200px;" onKeyPress="return arrumaEnter(this, event)">
    <option value="NULL">SELECIONE</option>
      </select></td>
  </tr>
  <tr>
    <td>Vencimento (1&ordf; Parcela):</td>
    <td><input type="date" name="vencimento" id="vencimento" onKeyPress="return arrumaEnter(this, event)" /></td>
    <td align="center"><select name="cc6" class="textBox" style="width:200px;" id="cc6" onKeyPress="return arrumaEnter(this, event)">
      <option value="00">SELECIONE</option>
        <?php
include("includes/config_drop.php");?>
        <?php
$sql = "SELECT * FROM cc6 ORDER BY id_cc6";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc6'] . "'>" .$row['nome_cc6'] . "</option>";
}
?>
    </select>
      <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo_titulo;?>" onkeypress="return arrumaEnter(this, event)"/></td>
    </tr>
  <tr>
    <td>Qtd. Parcela:</td>
    <td><input type="text" name="parcela" id="parcela" value="1" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td align="center">Compet&ecirc;ncia (M&ecirc;s / Ano)</td>
    </tr>
  <tr>
    <td>Valor da Parcela:</td>
    <td><input type="text" name="valor" id="valor" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td align="center"><select name="mes_comp" style="width:auto;" id="mes_comp" onkeypress="return arrumaEnter(this, event)">
      <option value="00">MM</option>
     <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
    </select>
      /
  <select name="ano_comp" style="width:auto;" id="ano_comp" onkeypress="return arrumaEnter(this, event)">
    <option value="0000">AAAA</option>
    <?php $ano = date('Y')-1;
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
</select></td>
    </tr>
  <tr>
    <td>Acr&eacute;scimo:</td>
    <td><input type="text" name="acrescimo" id="acrescimo" value="0" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td bgcolor="#C0C0C0" align="center"><font size="+1">Projeto</font></td>
    </tr>
  <tr>
    <td>Desconto:</td>
    <td><input type="text" name="desconto" id="desconto" value="0"onKeyPress="return arrumaEnter(this, event)"/></td>
    <td align="center"><input type="checkbox" id="check" onclick="habilitar();" />
      <select name="projeto" id="projeto" onkeypress="return arrumaEnter(this, event)" disabled="disabled">
        <option value="NENHUM">SELECIONE O PROJETO</option>
        <?php
include("includes/config_drop.php");?>
        <?php
$sql = "SELECT * FROM projetos ORDER BY projeto ";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['codigo'] . "'>" . $row['projeto'] . "</option>";
}
?>
      </select></td>
    </tr>
  <tr>
    <td>Descri&ccedil;&atilde;o:</td>
    <td colspan="2"><textarea name="descricao" cols="50" style="width:600px" rows="5" id="descricao" onKeyPress="return arrumaEnter(this, event)"></textarea></td>
  </tr>

  
  <tr>
  <td colspan="3" align="center"><input type="submit" name="salvar" id="salvar" value="Cadastrar" /></td>
  </tr>
</table>

</form>
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

	    <script type="text/javascript">
		$(function(){
			$('#cc3').change(function(){
				if( $(this).val() ) {
					$('#cc4').hide();
					$('.carregando').show();
					$.getJSON('cc4.ajax.php?search=',{cc3: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc4 + '">' + j[i].nome_cc4 + '</option>';
						}	
						$('#cc4').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc4').html('<option value="">– CC4 –</option>');
				}
			});
		});
		</script>
        




	    <script type="text/javascript">
		$(function(){
			$('#cc4').change(function(){
				if( $(this).val() ) {
					$('#cc5').hide();
					$('.carregando').show();
					$.getJSON('cc5.ajax.php?search=',{cc4: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc5 + '">' + j[i].nome_cc5 + '</option>';
						}	
						$('#cc5').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc5').html('<option value="">– CC5 –</option>');
				}
			});
		});
		</script>
        
        
        
	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#fornecedor').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
						}	
						$('#fornecedor').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#fornecedor').html('<option value="">– Cliente-Fornecedor –</option>');
				}
			});
		});
		</script>
        
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
