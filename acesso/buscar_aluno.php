<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

//GET
$busca = $_GET["buscar"];
?>


  <body>

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                          <header class="panel-heading">
                              <b>Listar Alunos</b>
                          </header>
                          <header class="panel-body">
                              <form id="form2" name="form1" method="get" action="buscar_aluno.php">
  Nome: <input type="text" name="buscar" id="buscar" value="<?php echo $busca;?>" />
  <input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
</form>
                          </header>
              </section>
              <div class="directory-info-row" style="margin-top:-10px;">
              <div class="row">
<?php
include 'includes/conectar2.php';
include 'includes/sql.php';



$sql = buscar_aluno($busca,$user_unidade, $user_empresa); //Função que determina o sql

$query = $mysqli->query($sql);
$count = $query->num_rows;
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO');
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados = $query->fetch_array(MYSQLI_ASSOC)) {
        // enquanto houverem resultados...
		$matricula          = $dados["matricula"];
		$aluno          = $dados["nome"];
		$financeiro          = $dados["nome_fin"];
		$curso          = format_curso($dados["curso"]);
		$unidade_aluno         = $dados["unidade"];
		$polo         = $dados["polo"];
		$foto_academica = "../".$dados["foto_academica"];
		$foto_perfil = $dados["foto_perfil"];
		if($user_nivel == 1 || $user_nivel == 333){
			$senha = $dados["senha"];
		} else {
			$senha = substr($dados["senha"],0,3)."***";
		}
		$email = $dados["email"];
		echo "
		<div class=\"col-md-6 col-sm-6\">
                  <div class=\"panel\">
                      <div class=\"panel-body\">
                          <div class=\"media\">
							  <a class=\"pull-left\" href=\"ficha.php?codigo=$matricula\" rel=\"shadowbox\">
                                  <img class=\"thumb media-object\" width=\"175px\" height=\"175px\" src=\"$foto_academica\" alt=\"\">
                              </a>
                              <div class=\"media-body\">
                                  <h4><font size=\"-1\">$aluno<br></font>
								  <font size=\"-2\">$financeiro</font>
								  </h4>
                                  <ul class=\"social-links\">
                                      <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"ficha.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Ficha do Aluno\"><i class=\"fa fa-folder\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"editar_dados.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Edição de dados\"><i class=\"fa fa-edit\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"ficha_dados.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Ficha de dados\"><i class=\"fa fa-eye\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"financeiro_aluno.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Extrato Financeiro\"><i class=\"fa fa-money\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"boletim_aluno.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Boletim Acadêmico\"><i class=\"fa fa-file-text\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"declaracao_aluno.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Declarações\"><i class=\"fa fa-archive\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"aproveitamento_aluno.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Aproveitamento de Estudos\"><i class=\"fa fa-check\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"enviar_sms_individual.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Enviar SMS\"><i class=\"fa fa-envelope\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"javascript:excluir('resetar_senha.php?codigo=$matricula');\" data-original-title=\"Gerar Nova Senha\"><i class=\"fa fa-unlock-alt\"></i></a></li>
									  
                                  </ul>
								  <font size=\"-2\">
                                  <address>
                                      <strong>Matrícula: </strong> $matricula<br>
									  <strong>Senha: </strong> $senha<br>
									  <strong>E-mail: </strong> $email<br>
                                      <strong>Curso: </strong> $curso<br>
									  <strong>Unidade: </strong> $unidade_aluno<br>
									  <strong>Polo: </strong> $polo<br>
                                  </address>
								  </font>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
		
		
		
		";
        // exibir a coluna nome e a coluna email
    }
}

?>         
              
              
              
              







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

function excluir(URL){


if(confirm ("Atenção: Deseja realmente gerar uma nova senha do aluno? A nova senha será - cedtec"))
{
	  var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
}
else
{
exit;
}
}
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
