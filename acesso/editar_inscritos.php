<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
$id = $_GET["codigo"];


$re    = mysql_query("select count(*) as total from inscritos WHERE codigo = $id" );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from inscritos WHERE codigo LIKE $id");
	$dados = mysql_fetch_array($re);	
	$pesq = mysql_query("select * from inscritos WHERE codigo = $id" );
}
$nome = strtoupper($dados["nome"]);

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$id           = $_POST["id"];
	$nome = strtoupper($_POST["nome"]);
	$civil = strtoupper($_POST["civil"]); 
	$nacionalidade = strtoupper($_POST["nacionalidade"]); 
	$email = $_POST["email"]; 
	$cpf = strtoupper($_POST["cpf"]);
	$rg = strtoupper($_POST["rg"]); 
	$nascimento = strtoupper($_POST["nascimento"]); 
	$cep = strtoupper($_POST["cep"]); 
	$cidade = strtoupper($_POST["cidade"]); 
	$bairro = strtoupper($_POST["bairro"]); 
	$uf = strtoupper($_POST["uf"]); 
	$endereco = strtoupper($_POST["rua"])." Nº".$_POST["num"]; 
	$complemento = strtoupper($_POST["complemento"]); 
	$telefone = strtoupper($_POST["telefone"]); 
	$celular = strtoupper($_POST["celular"]); 
	$mae = strtoupper($_POST["mae"]); 
	$pai = strtoupper($_POST["pai"]); 
	
	//DADOS FINANCEIRO
	$nome_fin = strtoupper($_POST["nome_fin"]);
	$rg_fin = strtoupper($_POST["rg_fin"]);
	$email_fin = $_POST["email_fin"];
	$cpf_fin = strtoupper($_POST["cpf_fin"]); 
	$cep_fin = strtoupper($_POST["cep_fin"]); 
	$uf_fin = strtoupper($_POST["uf_fin"]);
	$cidade_fin = strtoupper($_POST["cidade_fin"]);
	$bairro_fin = strtoupper($_POST["bairro_fin"]);
	$end_fin = strtoupper($_POST["rua_fin"])." Nº".$_POST["num_fin"];
	$comp_fin = strtoupper($_POST["comp_fin"]);
	$nasc_fin = strtoupper($_POST["nasc_fin"]);
	$nacio_fin = strtoupper($_POST["nacio_fin"]);
	$tel_fin = strtoupper($_POST["tel_fin"]);
	
	//DADOS FIADOR
	$nome_fia = strtoupper($_POST["nome_fia"]);
	$rg_fia = strtoupper($_POST["rg_fia"]);
	$email_fia = $_POST["email_fia"];
	$cpf_fia = strtoupper($_POST["cpf_fia"]); 
	$cep_fia = strtoupper($_POST["cep_fia"]); 
	$uf_fia = strtoupper($_POST["uf_fia"]);
	$cidade_fia = strtoupper($_POST["cidade_fia"]);
	$bairro_fia = strtoupper($_POST["bairro_fia"]);
	$end_fia = strtoupper($_POST["rua_fia"])." Nº".$_POST["num_fia"];
	$nasc_fia = strtoupper($_POST["nasc_fia"]);
	$nacio_fia = strtoupper($_POST["nacio_fia"]);
	$tel_fia = strtoupper($_POST["tel_fia"]);
	
	$nome_conj = strtoupper($_POST["nome_conj"]);
	$rg_conj = strtoupper($_POST["rg_conj"]);
	$cpf_conj = strtoupper($_POST["cpf_conj"]); 
	$nasc_conj = strtoupper($_POST["nasc_conj"]);
	$nacio_conj = strtoupper($_POST["nacio_conj"]);


if(isset($_POST["mudar"])){
	$statusfinal = 1;
}else {
	$statusfinal = 0;
}
;


if(@mysql_query("UPDATE inscritos SET nome = '$nome', email = '$email', rg = '$rg', cpf='$cpf',nascimento = '$nascimento', civil='$civil',
telefone = '$telefone',celular = '$celular', nacionalidade='$nacionalidade',pai = '$pai', mae='$mae', cep='$cep',uf='$uf', cidade='$cidade',bairro='$bairro', endereco='$endereco',
complemento='$complemento', nome_fin='$nome_fin',nasc_fin='$nasc_fin', cpf_fin='$cpf_fin',rg_fin='$rg_fin', uf_fin='$uf_fin',cep_fin='$cep_fin',
end_fin='$end_fin', cidade_fin='$cidade_fin',bairro_fin='$bairro_fin', tel_fin='$tel_fin',comp_fin='$comp_fin', nacio_fin='$nacio_fin',
email_fin='$email_fin', nome_fia='$nome_fia',nasc_fia='$nasc_fia', cpf_fia='$cpf_fia',rg_fia='$rg_fia', cep_fia='$cep_fia',
end_fia='$end_fia', cidade_fia='$cidade_fia',uf_fia='$uf_fia', bairro_fia='$bairro_fia',tel_fia='$tel_fia', email_fia='$email_fia',
nome_conj='$nome_conj', nasc_conj='$nasc_conj',cpf_conj='$cpf_conj', rg_conj='$rg_conj',nacio_conj='$nacio_conj',nacio_fia='$nacio_fia' WHERE codigo = $id")
) {
	
	if(mysql_affected_rows() == 1){
		mysql_query("UPDATE geral SET nome = '$nome', email = '$email', rg = '$rg', cpf='$cpf',nascimento = '$nascimento', civil='$civil',
telefone = '$telefone',celular = '$celular', nacionalidade='$nacionalidade',pai = '$pai', mae='$mae', cep='$cep',uf='$uf', cidade='$cidade',bairro='$bairro', endereco='$endereco',
complemento='$complemento', nome_fin='$nome_fin',nasc_fin='$nasc_fin', cpf_fin='$cpf_fin',rg_fin='$rg_fin', uf_fin='$uf_fin',cep_fin='$cep_fin',
end_fin='$end_fin', cidade_fin='$cidade_fin',bairro_fin='$bairro_fin', tel_fin='$tel_fin',comp_fin='$comp_fin', nacio_fin='$nacio_fin',
email_fin='$email_fin', nome_fia='$nome_fia',nasc_fia='$nasc_fia', cpf_fia='$cpf_fia',rg_fia='$rg_fia', cep_fia='$cep_fia',
end_fia='$end_fia', cidade_fia='$cidade_fia',uf_fia='$uf_fia', bairro_fia='$bairro_fia',tel_fia='$tel_fia', email_fia='$email_fia',
nome_conj='$nome_conj', nasc_conj='$nasc_conj',cpf_conj='$cpf_conj', rg_conj='$rg_conj',nacio_conj='$nacio_conj',nacio_fia='$nacio_fia' WHERE codigo = $id");
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Dados atualizados com sucesso');
			window.parent.location.reload();
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
                          <header class="panel-heading">
                              <b>Edi&ccedil;&atilde;o dados</b>
                          </header>
                        <div class="panel-body">
                <form action="#" name="formulario" id="formulario" method="POST" onKeyPress="return arrumaEnter(this, event)">

                   <input name="id" type="hidden" id="id" placeholder="Insira o seu e-mail" required value="<?php echo strtolower($dados["codigo"]); ?>"onKeyPress="return arrumaEnter(this, event)"/>
                 
<table align="center" width="70%" border="0">
  <tr> 
  <td colspan="4" bgcolor="#CCCCCC"><center><strong>Dados do Aluno</strong></center></td>
  </tr>
  <tr> 
  <td>Matr&iacute;cula</td>
  <td colspan="3"><input name="mat" type="text" id="mat" style="width:300px"  required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)" readonly value="<?php echo $dados["codigo"]; ?>"/></td>
  </tr>
  <tr>
    <td>Nome</td>
    <td><input name="nome" type="text" id="nome" style="width:300px" placeholder="Nome Completo" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)" value="<?php echo $dados["nome"]; ?>"/></td>
    <td>E-mail</td>
    <td><input name="email"  style="width:300px" type="text" id="email" placeholder="Insira o seu e-mail" required value="<?php echo strtolower($dados["email"]); ?>"onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>RG</td>
    <td><input name="rg"  style="width:300px" type="text" id="rg" placeholder="Insira o Seu RG" required value="<?php echo $dados["rg"]; ?>" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>CPF</td>
    <td><input name="cpf"  style="width:300px" type="text" id="cpf" placeholder="Insira o Seu CPF" required value="<?php echo $dados["cpf"]; ?>" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>Data de Nascimento</td>
    <td><input name="nascimento"  style="width:300px" type="text" id="nascimento" placeholder="Data de Nascimento" required value="<?php echo $dados["nascimento"]; ?>" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>Estado Civil</td>
    <td><select name="civil" style="width:300px" size="1" id="civil" onKeyPress="return arrumaEnter(this, event)">
	      <option value="<?php echo $dados["civil"]; ?>"><?php echo $dados["civil"]; ?></option>
	      <option value="Casado">Casado</option>
	      <option value="Divorciado">Divorciado</option>
	      <option value="Solteiro">Solteiro</option></select></td>
  </tr>
  <tr>
  <td>Telefone</td>
  <td><input id="telefone"  style="width:300px" name="telefone" type="text" value="<?php echo $dados["telefone"]; ?>" placeholder="Informe o Telefone" required onKeyPress="return arrumaEnter(this, event)"/></td>
  <td>Celular</td>
  <td><input id="celular"  style="width:300px" name="celular" type="text" value="<?php echo $dados["celular"]; ?>" placeholder="Informe o Nº do seu celular" required onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
 <tr>
   <td>Nacionalidade</td>
   <td><input name="nacionalidade" style="width:300px" type="text" id="nacionalidade" value="<?php echo $dados["nacionalidade"]; ?>" placeholder="Nacionalidade do Aluno" style="text-transform:uppercase" required onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>Nome do Pai</td>
    <td><input name="pai" style="width:300px" type="text" required id="pai" value="<?php echo $dados["pai"]; ?>" placeholder="Nome do Pai"  style="width:300px" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
  
  <td>Nome da M&atilde;e</td>
  <td><input name="mae"  style="width:300px" type="text" id="mae" value="<?php echo $dados["mae"]; ?>" placeholder="Nome do Mãe" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr> 
  <td colspan="4" bgcolor="#CCCCCC"><center>
    <strong>Endere&ccedil;o do Aluno</strong>
  </center></td>
  </tr>
  <tr>
    <td height="28">CEP</td>
    <td colspan="3"><input  style="width:300px" id="cep" name="cep" type="text" maxlength="9" value="<?php echo $dados["cep"]; ?>" placeholder="Informe o CEP" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>UF</td>
    <td colspan="3"><input  style="width:300px" id="uf" name="uf" type="text" value="<?php echo $dados["uf"]; ?>" placeholder="Informe a UF" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>Cidade</td>
    <td colspan="3"><input  style="width:300px" id="cidade" name="cidade" type="text" value="<?php echo $dados["cidade"]; ?>" placeholder="Informe a Cidade" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
<tr>
	<td>Bairro</td>
    <td colspan="3"><input  style="width:300px" id="bairro" name="bairro" type="text" value="<?php echo $dados["bairro"]; ?>" placeholder="Informe o Bairro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td>Rua</td>
	<td colspan="3"><input style="width:300px" id="rua" name="rua" type="text" value="<?php echo $dados["endereco"]; ?>" placeholder="Nome da Rua / Logradouro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/><input id="num" name="num" type="text" value="" placeholder="Nº" style="text-transform:uppercase; width:30px;" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
	<td>Complemento</td>
    <td colspan="3"><input  style="width:300px" id="complemento" name="complemento" value="<?php echo $dados["complemento"]; ?>" type="text" placeholder="Complemento" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>

<tr> 
  <td colspan="4" bgcolor="#CCCCCC"><center>
    <strong>Dados do Respons&aacute;vel Financeiro</strong>
  </center></td>
  </tr>
 
  
  <tr>
    <td>Nome</td>
    <td><input name="nome_fin"  style="width:300px" type="text" id="nome_fin" placeholder="Nome Completo do Responsável Financeiro" value="<?php echo $dados["nome_fin"]; ?>" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>Data de Nascimento</td>
    <td><input name="nasc_fin"  style="width:300px" type="text" id="nasc_fin" placeholder="Data de Nascimento" value="<?php echo $dados["nasc_fin"]; ?>" required onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>CPF</td>
    <td><input name="cpf_fin"  style="width:300px" type="text" id="cpf_fin" placeholder="CPF do Responsável Financeiro" value="<?php echo $dados["cpf_fin"]; ?>" required onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>RG</td>
    <td><input name="rg_fin"  style="width:300px" type="text" id="rg_fin" placeholder="RG do Responsável Financeiro" value="<?php echo $dados["rg_fin"]; ?>" required onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td height="28">CEP</td>
    <td><input id="cep_fin"  style="width:300px" name="cep_fin" type="text" maxlength="9" placeholder="Informe o CEP" value="<?php echo $dados["cep_fin"]; ?>" required onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>Rua</td>
    <td><input id="rua_fin"  style="width:300px" name="rua_fin" type="text" placeholder="Nome da Rua / Logradouro" value="<?php echo $dados["end_fin"]; ?>" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/><input id="num_fin" name="num_fin" type="text" value="" placeholder="Nº" style="text-transform:uppercase; width:30px;" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>Cidade</td>
    <td><input id="cidade_fin"  style="width:300px" name="cidade_fin" type="text" placeholder="Informe a Cidade" value="<?php echo $dados["cidade_fin"]; ?>" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
<td>UF</td>
<td><input id="uf_fin"  style="width:300px" name="uf_fin" type="text" placeholder="Informe a UF" value="<?php echo $dados["uf_fin"]; ?>" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
<td>Bairro</td>
<td><input id="bairro_fin"  style="width:300px" name="bairro_fin" type="text" value="<?php echo $dados["bairro_fin"]; ?>" placeholder="Informe o Bairro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
                            
<td>Telefone</td>
<td><input id="tel_fin"  style="width:300px" name="tel_fin" type="text" value="<?php echo $dados["tel_fin"]; ?>" placeholder="Telefone do Responsável Financeiro" required onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
<td>Complemento</td>
<td><input id="comp_fin"  style="width:300px" name="comp_fin" type="text" value="<?php echo $dados["comp_fin"]; ?>" placeholder="Complemento" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
<td>Nacionalidade</td>
<td><input id="nacio_fin"  style="width:300px" name="nacio_fin" type="text" value="<?php echo $dados["nacio_fin"]; ?>" placeholder="Nacionalidade" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>
<td>E-mail</td>
<td><input id="email_fin"  style="width:300px" name="email_fin" type="text" placeholder="E-mail do Responsável Financeiro" value="<?php echo strtolower($dados["email_fin"]); ?>" onKeyPress="return arrumaEnter(this, event)"/></td>                       
</tr>
<tr> 
  <td colspan="4" bgcolor="#CCCCCC"><center>
    <strong>Dados do Fiador (Se Necess&aacute;rio)</strong>
  </center></td>
  </tr>
  
  <tr>
    <td>Nome</td>
    <td><input name="nome_fia"  style="width:300px" type="text" id="nome_fia" value="<?php echo $dados["nome_fia"]; ?>" placeholder="Nome Completo do Fiador" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>Data de Nascimento</td>
    <td><input name="nasc_fia"  style="width:300px" type="text" id="nasc_fia" value="<?php echo $dados["nasc_fia"]; ?>" placeholder="Data de Nascimento" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>CPF</td>
    <td><input name="cpf_fia"  style="width:300px" type="text" id="cpf_fia" value="<?php echo $dados["cpf_fia"]; ?>" placeholder="CPF do Fiador" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>RG</td>
    <td><input name="rg_fia"  style="width:300px" type="text" id="rg_fia" value="<?php echo $dados["rg_fia"]; ?>" placeholder="RG do Fiador" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  
  <tr>
    <td height="28">CEP</td>
    <td><input id="cep_fia"  style="width:300px" name="cep_fia" type="text" maxlength="9" value="<?php echo $dados["cep_fia"]; ?>" placeholder="Informe o CEP" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>Rua</td>
    <td><input id="rua_fia"  style="width:300px" name="rua_fia" type="text" value="<?php echo $dados["end_fia"]; ?>" placeholder="Nome da Rua / Logradouro" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/><input id="num_fia" name="num_fia" type="text" value="" placeholder="Nº" style="text-transform:uppercase; width:30px;" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>Cidade</td>
    <td><input id="cidade_fia"  style="width:300px" name="cidade_fia" type="text" value="<?php echo $dados["cidade_fia"]; ?>" placeholder="Informe a Cidade" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
<td>UF</td>
<td><input id="uf_fia"  style="width:300px" name="uf_fia" type="text" value="<?php echo $dados["uf_fia"]; ?>" placeholder="Informe a UF" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
<tr>

<td>Bairro</td>
<td><input id="bairro_fia"  style="width:300px" name="bairro_fia" value="<?php echo $dados["bairro_fia"]; ?>" type="text" placeholder="Informe o Bairro" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
<td>Nacionalidade</td>
<td><input id="nacio_fia"  style="width:300px" name="nacio_fia" type="text" value="<?php echo $dados["nacio_fia"]; ?>" placeholder="Nacionalidade" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
</tr>
  

<tr>
<td>Telefone</td>
<td><input id="tel_fia"  style="width:300px" name="tel_fia" type="text" value="<?php echo $dados["tel_fia"]; ?>" placeholder="Telefone do Fiador" onKeyPress="return arrumaEnter(this, event)"/></td>
<td>E-mail</td>
<td><input id="email_fia"  style="width:300px" name="email_fia" value="<?php echo $dados["email_fia"]; ?>" type="text" placeholder="E-mail do Fiador" onKeyPress="return arrumaEnter(this, event)"/></td>
                            
</tr>

<tr>
    <td>C&ocirc;njuge</td>
    <td><input name="nome_conj"  style="width:300px" type="text" id="nome_conj" value="<?php echo $dados["nome_conj"]; ?>" placeholder="Cônjuge do Fiador" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>Data de Nascimento</td>
    <td><input name="nasc_conj"  style="width:300px" type="text" id="nasc_conj"value="<?php echo $dados["nasc_conj"]; ?>" placeholder="Data de Nascimento" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
    <td>CPF</td>
    <td><input name="cpf_conj"  style="width:300px" type="text" id="cpf_conj" value="<?php echo $dados["cpf_conj"]; ?>" placeholder="CPF do Cônjuge" onKeyPress="return arrumaEnter(this, event)"/></td>
    <td>RG</td>
    <td><input name="rg_conj"  style="width:300px" type="text" id="rg_conj" value="<?php echo $dados["rg_conj"]; ?>" placeholder="RG do Cônjuge" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>
  <tr>
   <td>Nacionalidade</td>
   <td><input name="nacio_conj"  style="width:300px" type="text" id="nacio_conj" value="<?php echo $dados["nacio_conj"]; ?>" placeholder="Nacionalidade do Cônjuge" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/></td>
  </tr>

<tr>
<td colspan="4" align="center">
                            <input type="submit" name="Cadastrar" id="Cadastrar" value="Salvar Dados">
                            </td></tr>
                            
                            </table>

                </form> 
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