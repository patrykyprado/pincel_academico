<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');


if( isset ( $_POST[ 'salvar' ] ) ) {
//DADOS DO CURSO
$grupo = (($_POST["grupo"]));
$unidade = (($_POST["unidade"]));
$polo = (($_POST["polo"]));
$nivel = strtoupper(($_POST["nivel"]));
$curso = strtoupper(($_POST["curso"]));
$modulo = $_POST["modulo"];

//DADOS PESSOAIS
$nome = $_POST["nome"];
$civil = $_POST["civil"];
$profissao = $_POST["profissao"];
$pai = $_POST["pai"];
$mae = $_POST["mae"];
$rg = $_POST["rg"];
$cpf = $_POST["cpf"];
$naturalidade = $_POST["naturalidade"];
$nacionalidade = $_POST["nacionalidade"];
$nascimento = $_POST["nascimento"];
$email = $_POST["email"];
$escola = $_POST["escolaridade"];
$empresa = $_POST["empresa"];

//ENDEREÇO
$rua = $_POST["rua"];
$bairro = $_POST["bairro"];
$cidade = $_POST["cidade"];
$cep = $_POST["cep"];
$uf = $_POST["uf"];
$telefone = $_POST["telefone"];
$celular = $_POST["celular"];




if(@mysql_query("INSERT INTO ced_alunos_qualificacao (matricula, nome, civil, profissao, pai, mae, cpf, rg, naturalidade, nacionalidade, nascimento, email, escolaridade, empresa, rua, bairro, cidade, cep, uf, telefone, celular, unidade, polo, nivel, curso, modulo, grupo) VALUES (NULL,UPPER('$nome'),'$civil'
,'$profissao','$pai','$mae','$cpf','$rg', '$naturalidade', '$nacionalidade', '$nascimento', '$email', '$escola', '$empresa', '$rua', '$bairro', '$cidade', '$cep', '$uf', '$telefone', '$celular', '$unidade','$polo', '$nivel', '$curso', '$modulo', '$grupo');")){
	echo "<script language=\"javascript\">
	alert('ALUNO CADASTRADO COM SUCESSO');
	</script>";	
}



};
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
                              <b>Cadastro de Aluno (Qualifica&ccedil;&atilde;o)</b>
                          </header>
                          <div class="panel-body">
<form method="post" action="#">
<table class="full_table_list2" width="80%" align="center">
<tr>
	<td bgcolor="#D5D5D5" colspan="4" align="center"><b>Dados do Curso</b></td>
</tr>
<tr>
<td>Grupo:</td>
<td colspan="3">
<select id="grupo" onChange="javascript:previa()" name="grupo">
                                           <option value="0" selected>- Selecione o Grupo -</option>
												  <?php
											$sql = "SELECT DISTINCT grupo FROM grupos WHERE grupo LIKE 'Q2%'";
												
											$result = mysql_query($sql);
											
											while ($row = mysql_fetch_array($result)) {
												echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
											}
											?>

                                          </select>
</td>

</tr>
<tr>
<td>Unidade:</td>
<td>
<select onChange="javascript:previa()" id="unidade" name="unidade">
                                           <option value="0" selected>- Selecione a Unidade -</option>
											<?php
											include("menu/config_drop.php");?>
												  <?php
												  if($user_unidade ==""){
													$sql = "SELECT distinct unidade FROM unidades where categoria >0 OR unidade LIKE '%ead%' OR unidade LIKE '%Qualificacao%'";
												  } else {
													  $sql = "SELECT distinct unidade FROM unidades where unidade LIKE '%$user_unidade%' ";
												  }
											$result = mysql_query($sql);
											
											while ($row = mysql_fetch_array($result)) {
												echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
											}
											?>
                                          </select>
</td>
<td>Polo:</td>
<td>
<select onChange="javascript:previa()" id="polo" name="polo">
                                           <option value="0" selected>- Selecione o Polo -</option>
											<?php
											include("menu/config_drop.php");?>
												  <?php
												  if($user_unidade ==""){
													$sql = "SELECT distinct unidade FROM unidades where categoria >0 OR unidade LIKE '%ead%'  OR unidade LIKE '%Qualificacao%'";
												  } else {
													  $sql = "SELECT distinct unidade FROM unidades where unidade LIKE '%$user_unidade%'";
												  }
											$result = mysql_query($sql);
											
											while ($row = mysql_fetch_array($result)) {
												echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
											}
											?>
                                          </select>
</td>
</tr>
<tr>
<td>N&iacute;vel:</td>
<td>
<select name="nivel" class="textBox" id="nivel" onKeyPress="return arrumaEnter(this, event)">
        
	<option value="selecione">- Selecione o Nivel -</option>	
	<?php
include('menu/config_drop.php');?>
        <?php
$sql = "SELECT distinct nivel FROM disciplinas WHERE nivel NOT LIKE '%nivel%' ORDER BY nivel";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['nivel']. "'>" . (($row['nivel'])) . "</option>";
}
?>
      </select>
</td>
<td>Curso:</td>
<td>
<select name="curso" class="textBox" id="tipo" onKeyPress="return arrumaEnter(this, event)">
        
	<option value="selecione">- Selecione o Curso -</option>	
	<?php
include('menu/config_drop.php');?>
        <?php
$sql = "SELECT distinct curso FROM disciplinas WHERE curso NOT LIKE '%curso%' ORDER BY curso";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['curso']. "'>" . (($row['curso'])) . "</option>";
}
?>
      </select> M&oacute;dulo: <input name="modulo" type="text" value="1" style="width:30px;" />
</td>
</tr>
<tr>
	<td bgcolor="#D5D5D5" colspan="4" align="center"><b>Dados Pessoais</b></td>
</tr>
<tr>
<td width="132">Nome Completo:</td>
<td colspan="3"><input name="nome" style="width:500px" type="text" /></td>
</tr>

<tr>
<td width="132">Estado Civil:</td>
<td><select name="civil" size="1" id="civil" onKeyPress="return arrumaEnter(this, event)">
	      <option value="">Selecione...</option>
	      <option value="Casado(a)">Casado</option>
	      <option value="Divorciado(a)">Divorciado</option>
	      <option value="Solteiro(a)">Solteiro</option>
          <option value="Viúvo(a)">Vi&uacute;vo(a)</option></select></td>
<td width="132">Profiss&atilde;o:</td>
<td><input name="profissao" type="text" /></td>
</tr>
<tr>
<td width="132">Nome do Pai:</td>
<td colspan="3"><input name="pai" style="width:500px" type="text" /></td>
</tr>
<tr>
<td width="132">Nome da M&atilde;e:</td>
<td colspan="3"><input name="mae" style="width:500px" type="text" /></td>
</tr>


<tr>
<td>N&uacute;mero RG:</td>
<td><input name="rg" type="text" onKeyUp="Mascara('RG',this,event)" maxlength="14" /> <font size="-2">Somente n&uacute;meros</font></td>
<td>CPF:</td>
<td><input name="cpf" type="text" onKeyUp="Mascara('CPF',this,event)" maxlength="14" /> <font size="-2">Somente n&uacute;meros</font></td>
</tr>

<tr>
<td>Naturalidade:</td>
<td><input name="naturalidade" type="text" /></td>
<td>Nacionalidade:</td>
<td><input name="nacionalidade" type="text" /></td>
</tr>
<tr>
<td>Data de Nascimento:</td>
<td><input name="nascimento" onKeyUp="Mascara('DATA',this,event)" maxlength="10" type="text" style="width:100px" /> <font size="-2">Somente n&uacute;meros</font></td>
<td>E-mail:</td>
<td><input name="email" type="text" /></td>
</tr>
<tr>
<td>Escolaridade:</td>
<td><input name="escolaridade" type="text" /></td>
<td>Nome da Empresa:</td>
<td><input name="empresa" type="text" /></td>
</tr>
<tr>
	<td bgcolor="#D5D5D5" colspan="4" align="center"><b>Endere&ccedil;o</b></td>
</tr>
<tr>
<td>Rua/Avenida:</td>
<td><input name="rua" type="text" /></td>
<td>Bairro:</td>
<td><input name="bairro" type="text" /></td>
</tr>
<tr>
<td>Cidade:</td>
<td><input name="cidade" type="text" /></td>
<td>CEP:</td>
<td><input name="cep" type="text" /> UF:<select name="uf" id="uf" style="width:auto;" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <?php
				$sql = "SELECT DISTINCT uf
						FROM cod_municipios
						ORDER BY uf";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					if(trim($row['uf']) == "ES"){
						echo '<option selected="selected" value="'.trim($row['uf']).'">'.$row['uf'].'</option>';
					} else {
						echo '<option value="'.trim($row['uf']).'">'.$row['uf'].'</option>';
					}
				}
			?>
                            </select></td>
</tr>
<tr>
<td>Telefone:</td>
<td><input name="telefone" onKeyUp="Mascara('TEL',this,event)" type="text" /></td>
<td>Celular:</td>
<td><input name="celular" onKeyUp="Mascara('TEL',this,event)" type="text" /></td>
</tr>

<tr>
<td colspan="4" align="center"><input name="salvar" id="salvar" type="submit" value="Salvar" /></td>

</tr>
</table>
</form>
</div>
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
    

 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script>
  
<script language="JavaScript" type="text/javascript">
function Mascara(tipo, campo, teclaPress) {
	if (window.event)
	{
		var tecla = teclaPress.keyCode;
	} else {
		tecla = teclaPress.which;
	}
 
	var s = new String(campo.value);
	// Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
	s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');
 
	tam = s.length + 1;
 
	if ( tecla != 9 && tecla != 8 ) {
		switch (tipo)
		{
		case 'CPF' :
			if (tam > 3 && tam < 7)
				campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
			if (tam >= 7 && tam < 10)
				campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
			if (tam >= 10 && tam < 12)
				campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
		break;
 
		case 'CNPJ' :
 
			if (tam > 2 && tam < 6)
				campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
			if (tam >= 6 && tam < 9)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
			if (tam >= 9 && tam < 13)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
			if (tam >= 13 && tam < 15)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
		break;
 
		case 'TEL' :
			if (tam > 2 && tam < 4)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
			if (tam >= 7 && tam < 11)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
		break;
 
		case 'DATA' :
			if (tam > 2 && tam < 4)
				campo.value = s.substr(0,2) + '/' + s.substr(2, tam);
			if (tam > 4 && tam < 11)
				campo.value = s.substr(0,2) + '/' + s.substr(2,2) + '/' + s.substr(4,tam-4);
		break;
		
		case 'CEP' :
			if (tam > 5 && tam < 7)
				campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
		break;
		}
	}
}
</script>