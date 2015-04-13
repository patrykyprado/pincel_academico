<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');


if($_SERVER["REQUEST_METHOD"] == "POST") {
$turma        = strtoupper($_POST["turma_sigla"]);
$grupo        = $_POST["grupo"];
$nivel        = trim(($_POST["nivel"]));
$curso        = trim(($_POST["curso"]));
$polo        = trim(($_POST["polo"]));
$unidade        = trim(($_POST["unidade"]));

$inicio        = $_POST["inicio"];
$final        = $_POST["final"];
$anograde        = $_POST["grade"];
$modulo        = $_POST["modulo"];
$turno        = $_POST["turno"];
$tipo_etapa        = $_POST["tipo_etapa"];


include('includes/conectar.php');


$sql_sig_curso = mysql_query("SELECT * FROM tbl_turma1 WHERE curso LIKE '%$curso%' AND nivel LIKE '%$nivel%'");
$dados_curso = mysql_fetch_array($sql_sig_curso);
$sigla_curso = $dados_curso["sigla_curso"];
if(trim($unidade) == "EAD"){
	$nome = strtoupper(substr($unidade,0,2)).$sigla_curso.$modulo.$turma;
} else {
	$nome = strtoupper(substr($polo,0,2)).$sigla_curso.$modulo.$turma;
}


$ver = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$nome' AND nivel LIKE '$nivel' AND unidade LIKE '%$unidade%' AND polo LIKE '%$polo%' AND curso LIKE '%$curso%' AND modulo LIKE '%$modulo%' AND grupo LIKE '%$grupo%' AND turno LIKE '%$turno%'");
$contar_turma = mysql_num_rows($ver);

if ($contar_turma >= 1) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('TURMA $turma J? EXISTE PARA O PERIODO INFORMADO');
	history.back();
    </SCRIPT>");
	return;
}



if(@mysql_query("INSERT INTO ced_turma (cod_turma,grupo,nivel,curso,modulo,unidade,polo,turno,anograde, inicio, fim, tipo_etapa) VALUES ('$nome' , '$grupo','$nivel','$curso','$modulo','$unidade','$polo','$turno','$anograde','$inicio','$final','$tipo_etapa')")) {


	if(mysql_affected_rows() == 1){
		//PESQUISA DISCIPLINAS DA TURMA
		$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE curso LIKE '%$curso%' AND nivel LIKE '%$nivel%' AND modulo LIKE '%$modulo%' AND anograde LIKE '%$anograde%'");
		
		//cadastra as disciplinas do aluno
		while ($dados2 = mysql_fetch_array($sql_disc)){
			$ver_id = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$nome' AND nivel LIKE '$nivel' AND unidade LIKE '%$unidade%' AND polo LIKE '%$polo%' AND curso LIKE '%$curso%' AND modulo LIKE '%$modulo%' AND grupo LIKE '%$grupo%' AND turno LIKE '%$turno%'");
			$ver_dados = mysql_fetch_array($ver_id);
			$id_turma = $ver_dados["id_turma"];
			$disciplina          = $dados2["cod_disciplina"];
			mysql_query("INSERT INTO  ced_turma_disc (codturma, disciplina, ano_grade, polo,id_turma,turno) VALUES ('$nome',  '$disciplina', '$anograde', '$polo', '$id_turma','$turno');");
		}
		echo "
		<script language=\"javascript\">
		alert('Turma: $nome - $unidade / $polo - $nivel em $curso cadastrada com sucesso!');
		</script>";
	}
} else {
	if(mysql_errno() == 1062) {
		echo $erros[mysql_errno()];
		exit;
	} else {	
		echo "Erro nao foi possivel efetuar o registro";
		exit;
	}	
	@mysql_close();
}

}
?>


  <body onLoad="setTimeout('previa()', 500)">

  <section id="container" >


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Cadastro de Turmas</b>
                          </header>
                          <div class="panel-body">
                              <div class="stepy-tab">
                                  <ul id="default-titles" class="stepy-titles clearfix">
                                      <li id="step1" class="current-step">
                                          <div>Curso</div>
                                      </li>
                                      <li id="step2" class="">
                                          <div>Unidade</div>
                                      </li>
                                      <li id="step3" class="">
                                          <div>Outros</div>
                                      </li>
                                      <li id="step4" class="">
                                          <div>Previsualizar</div>
                                      </li>
                                  </ul>
                              </div>
                            <form name="form_turma" method="post" action="cad_turma.php" class="form-horizontal" id="default">
                              <fieldset title="Curso" class="step" id="step1">
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Grade Curricular</b></label>
                                          <div class="col-lg-10">
                                           <select onChange="javascript:previa()" name="grade" class="form-control input-sm m-bot15">
                                           <option value="0" selected>- Selecione a Grade da Turma -</option>
											  <?php
                                        include("menu/config_drop.php");?>
                                              <?php
                                        $sql = "SELECT distinct anograde FROM disciplinas WHERE anograde NOT LIKE '%anograde%' ORDER BY anograde DESC";
                                        $result = mysql_query($sql);
                                        
                                        while ($row = mysql_fetch_array($result)) {
                                            echo "<option value='" . $row['anograde'] . "'>" . $row['anograde'] . "</option>";
                                        }
                                        ?>
                                          </select>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Organização</b></label>
                                          <div class="col-lg-10">
                                          
                                <select onChange="javascript:previa()"  name="tipo_etapa" class="form-control input-sm m-bot15" id="tipo_etapa" onkeypress="return arrumaEnter(this, event)">
                                                              <?php
                                                        include("menu/config_drop.php");?>
                                                              <?php
                                                                $sql = "SELECT * FROM ced_tipo_etapa";
                                                        
                                                        $result = mysql_query($sql);
                                                        
                                                        while ($row = mysql_fetch_array($result)) {
                                                            echo "<option value='" . $row['id_tipo'] . "'>" . $row['tipo'] . "</option>";
                                                        }
                                                        ?>
                                </select>  
                                          </div>
                                      </div>


                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Grupo</b></label>
                                          <div class="col-lg-10">
                                         <select onChange="javascript:previa()" name="grupo" class="form-control input-sm m-bot15">
                                           <option value="0" selected>- Selecione o Grupo da Turma -</option>
											<?php
											include("menu/config_drop.php");?>
												  <?php
											$sql = "SELECT DISTINCT grupo FROM grupos";
											$result = mysql_query($sql);
											
											while ($row = mysql_fetch_array($result)) {
												echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
											}
											?>
                                          </select>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Turno</b></label>
                                          <div class="col-lg-10">
                                         <select onChange="javascript:previa()" id="turno" name="turno" class="form-control input-sm m-bot15">
                                           <option value="" selected>- Selecione o Turno da Turma -</option>
											<?php
											include("menu/config_drop.php");?>
												  <?php
											$sql = "SELECT DISTINCT turno FROM cursosead";
											$result = mysql_query($sql);
											
											while ($row = mysql_fetch_array($result)) {
												echo "<option value='" . $row['turno'] . "'>" . $row['turno'] . "</option>";
											}
											?>
                                          </select>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Nível</b></label>
                                          <div class="col-lg-10">
                                           <select onChange="javascript:previa()" id="nivel" name="nivel" class="form-control input-sm m-bot15">
                                           <option value="0" selected>- Selecione o Nível de Ensino da Turma -</option>
											<?php
											include("menu/config_drop.php");?>
												  <?php
											$sql = "SELECT DISTINCT nivel FROM disciplinas WHERE nivel NOT LIKE '%nivel%'";
											$result = mysql_query($sql);
											
											while ($row = mysql_fetch_array($result)) {
												echo "<option value='" . ($row['nivel']) . "'>" . $row['nivel'] . "</option>";
											}
											?>
                                          </select>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Curso</b></label>
                                          <div class="col-lg-10">
                                           <select onChange="javascript:previa()" id="curso" name="curso" class="form-control input-sm m-bot15">
                                           <option value="0" selected>- Selecione o Curso da Turma -</option>
                                          </select>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>M?dulo</b></label>
                                          <div class="col-lg-10">
                                           <select onChange="javascript:previa()" id="modulo" name="modulo" class="form-control input-sm m-bot15">
                                           <option value="1" selected>M?dulo I</option>
                                           <option value="2" >M?dulo II</option>
                                           <option value="3" >M?dulo III</option>
                                          </select>
                                          </div>
                                      </div>

                                  </fieldset>
                              <fieldset title="Unidade" class="step" id="step2" >
                                      <legend></legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Unidade</b></label>
                                          <div class="col-lg-10">
                                           <select id="unidade" onChange="javascript:previa()" id="unidade" name="unidade" class="form-control input-sm m-bot15">
                                           <option value="0" selected>- Selecione a Unidade da Turma -</option>
											<?php
											include("menu/config_drop.php");?>
												  <?php
												  if($user_unidade ==""){
													$sql = "SELECT distinct unidade FROM unidades where categoria >0 OR unidade LIKE '%ead%' OR unidade LIKE '%qualificacao%'";
												  } else {
													  $sql = "SELECT distinct unidade FROM unidades where unidade LIKE '%$user_unidade%' ";
												  }
											$result = mysql_query($sql);
											
											while ($row = mysql_fetch_array($result)) {
												echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
											}
											?>
                                          </select>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Polo</b></label>
                                          <div class="col-lg-10">
                                           <select onChange="javascript:previa()" id="polo" name="polo" class="form-control input-sm m-bot15">
                                           <option value="0" selected>- Selecione a Polo da Turma -</option>
											<?php
											include("menu/config_drop.php");?>
												  <?php
												  if($user_unidade ==""){
													$sql = "SELECT distinct unidade FROM unidades where categoria >0  OR unidade LIKE '%qualificacao%'";
												  } else {
													  $sql = "SELECT distinct unidade FROM unidades";
												  }
											$result = mysql_query($sql);
											
											while ($row = mysql_fetch_array($result)) {
												echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
											}
											?>
                                          </select>
                                          </div>
                                      </div>
                                  </fieldset>
                                  <fieldset title="Outros" class="step" id="step3" >
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Turma</b></label>
                                          <div class="col-lg-10">
                                              <select onChange="javascript:previa()" name="turma_sigla" class="form-control" id="turma_sigla" onkeypress="return arrumaEnter(this, event)">
                                  <option value="A" selected="selected">A</option>
                                  <option value="B">B</option>
                                  <option value="C">C</option>
                                  <option value="D">D</option>
                                  <option value="E">E</option>
                                  <option value="F">F</option>
                                  <option value="G">G</option>
                                  <option value="H">H</option>
                                  <option value="I">I</option>
                                  <option value="J">J</option>
                                  <option value="K">K</option>
                                  <option value="L">L</option>

                            </select> 
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Data de In?cio</b></label>
                                          <div class="col-lg-10">
                                              <input onKeyPress="javascript:previa()" type="date" id="inicio" name="inicio" class="form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Data Final</b></label>
                                          <div class="col-lg-10">
                                              <input onKeyPress="javascript:previa()" type="date" id="final" name="final" class="form-control">
                                          </div>
                                      </div>

                                </fieldset>
                                <fieldset title="Pr?-visualizar" class="step" id="step4" >
                                  <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Organiza??o</b></label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static"><input type="text" readonly name="copy_tipo_etapa" style="width:500px"></p>
                                          </div>
                                      </div>
                                                                            <div class="form-group">
                                      <label class="col-lg-2 control-label"><b>Grade Curricular</b></label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static"><input type="text" readonly name="copy_grade" style="width:500px"></p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Grupo</b></label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static"><input type="text"  style="width:500px" readonly name="copy_grupo" class=""></p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Turno</b></label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static"><input type="text" style="width:500px" readonly name="copy_turno" class=""></p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Curso</b></label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static"><input type="text" style="width:500px" readonly name="copy_curso" class=""></p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Unidade / Polo</b></label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static"><input type="text" style="width:500px" readonly name="copy_unidade"></p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label"><b>Turma</b></label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static"><input type="text" style="width:500px" readonly name="copy_turma"></p>
                                          </div>
                                      </div>
                                  </fieldset>
                                  <input type="submit" class="finish btn btn-danger" value="Criar Turma"/>
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
			$('#nivel').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{nivel: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="0">- Selecione o Curso da Turma -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cursoexib + '">' + j[i].cursoexib + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="NULL">SELECIONE O CURSO</option>');
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


<SCRIPT LANGUAGE="JavaScript">
function previa()

{
	var data_inicio = document.form_turma.inicio.value.substring(8, 10) + '/' +document.form_turma.inicio.value.substring(5, 7) + '/' +document.form_turma.inicio.value.substring(0, 4);
	var data_final = document.form_turma.final.value.substring(8, 10) + '/' +document.form_turma.final.value.substring(5, 7) + '/' +document.form_turma.final.value.substring(0, 4);
   document.form_turma.copy_curso.value =document.form_turma.nivel.value +': ' + document.form_turma.curso.value + ' - M?d. ' + document.form_turma.modulo.value;
   document.form_turma.copy_grade.value = document.form_turma.grade.value;
   document.form_turma.copy_grupo.value = document.form_turma.grupo.value;
   document.form_turma.copy_turno.value = document.form_turma.turno.value;
   document.form_turma.copy_tipo_etapa.value = document.form_turma.tipo_etapa.value;
   document.form_turma.copy_turma.value = document.form_turma.turma_sigla.value + ' - De: '+ data_inicio + " at? "+data_final;
   document.form_turma.copy_unidade.value = document.form_turma.unidade.value +' / ' + document.form_turma.polo.value;
   setTimeout('previa()', 500);
}

</script> 