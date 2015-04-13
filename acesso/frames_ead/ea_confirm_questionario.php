<link href="http://fonts.googleapis.com/css?family=Nunito:300" rel="stylesheet" type="text/css">
<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 35;
     }
    </script>
<script language="JavaScript"> 
function pergunta(){ 
   if (confirm('ATENÇÃO: Deseja realmente finalizar a avaliação?')){ 
      document.form_prova.submit() 
   } 
} 
</script> 
<?php 
/* Define o limite de tempo do cache em 180 minutos */
$expira = 60*60*24*14;
header("Pragma: public");
header("Cache-Control: maxage=".$expira);
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');
$turma_disc = $_SESSION["prova_turma_disc"];
$cod_disc = $_SESSION["prova_cod_disc"];
$tipo = $_SESSION["prova_tipo"];


//pega dados da turma
$sql_turma_d = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_turma_d = mysql_fetch_array($sql_turma_d);
$id_turma = $dados_turma_d["id_turma"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = $dados_turma["curso"];
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$anograde = $dados_turma["anograde"];
$turma_polo = $dados_turma["polo"];
if($turma_modulo == 1){
$turma_modulo_exib = "I";
}

if($turma_modulo == 2){
$turma_modulo_exib = "II";
}

if($turma_modulo == 3){
$turma_modulo_exib = "III";
}



//pega dados da disciplina
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disc' AND anograde LIKE '%$anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];

//SALVA RESPOSTAS DOS ALUNOS
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$quest_id = $_POST[ 'id_questionario' ];
	$matricula = $user_usuario;
	$sql_ver_tentativa = mysql_query("SELECT max(tentativa) as tentativa FROM ea_q_feedback WHERE id_questionario = '$quest_id' AND matricula = '$user_usuario'");
	$dados_tentativa = mysql_fetch_array($sql_ver_tentativa);
	$tentativa = $dados_tentativa["tentativa"];
	$sql_max_tentativa = mysql_query("SELECT * FROM ea_questionario WHERE id_questionario = '$quest_id'");
	$dados_max_tentativa = mysql_fetch_array($sql_max_tentativa);
	$max_tentativa = $dados_max_tentativa["tentativas"];
	$teste_array = $_POST[ 'campo_nome' ];
	$datahora = date("Y-m-d H:i:s");
	if($tentativa >= $max_tentativa&&$tipo == 1){
		echo "<script language=\"javascript\">
	alert('Você ja realizou o máximo de tentativas permitidas para essa atividade');
	</script>";
	return;
	}
		for( $i = 0 , $x = count( $_POST[ 'cod_questao' ] ) ; $i < $x ; ++ $i ) {
			$cod_questao = $_POST[ 'cod_questao' ][$i];
			$id_resposta = $_POST[$cod_questao.'_option'];
			$id_opcao = $_POST[ 'id_opcao' ][$i];
			$tentativa_final = $tentativa + 1;
			if(isset($id_resposta)){
			foreach($id_resposta as $indice => $questao_select){
				$resposta = $questao_select;
				$sql_ver_valor = mysql_query("SELECT * FROM ea_resposta WHERE id_resposta = '$id_opcao' LIMIT 1");
				$dados_valor = mysql_fetch_array($sql_ver_valor);
				$valor = $dados_valor["valor"];
				if(trim($resposta) != "F"){
					mysql_query("INSERT INTO ea_q_feedback (id_feedback, id_questionario, cod_questao, id_opcao, resposta, matricula, valor, tentativa, tipo, datahora) VALUES (NULL,
					'$quest_id', '$cod_questao', '$id_opcao', '$resposta', '$matricula', '$valor', '$tentativa_final', 'A', '$datahora')");
				}
			}
			}
			}
		
	echo "<script language=\"javascript\">
	alert('Suas respostas foram salvas com sucesso.');
	</script>";
	 
	
	
$sql_dados_prova = mysql_query("SELECT t1.matricula, t1.id_questionario, t1.disciplina, t1.cod_disc,t1.grupo, t1.acerto_total, t1.max_acerto, t1.nota, ((t1.acerto_total/t1.max_acerto)*t1.nota) as nota_final
,t1.tentativa
 FROM (
(SELECT eqf.matricula, equ.id_questionario, equ.cod_disc, d.disciplina, equ.grupo, SUM(eqf.valor)  as acerto_total, ((equ.qtd_questoes + equ.qtd_questoes2 + equ.qtd_questoes3) * 100) as max_acerto, 
equ.valor as nota, eqf.tentativa FROM ea_q_feedback eqf
INNER JOIN 
ea_questionario equ
ON equ.id_questionario = eqf.id_questionario
LEFT JOIN disciplinas d
ON equ.cod_disc = d.cod_disciplina AND d.anograde LIKE equ.grupo
WHERE eqf.id_opcao = eqf.resposta AND
eqf.matricula LIKE '$user_usuario' AND eqf.id_questionario = $quest_id
 group by eqf.id_questionario, eqf.tentativa, eqf.matricula) 
as t1)");

}

?>
<div id="central" style="margin-bottom:100px;">
<?php
if(mysql_num_rows($sql_dados_prova) >=1){
	echo "<table class=\"full_table_cad\" align=\"center\" border=\"1\">
	<tr>
		<td align=\"center\"><b>Disciplina</b></td>
		<td align=\"center\"><b>Valor da Prova</b></td>
		<td align=\"center\"><b>Nota Obtida</b></td>
		<td align=\"center\"><b>Tentativa</b></td>
	</tr>
	";
	while($dados_provas = mysql_fetch_array($sql_dados_prova)){
		$prova_disciplina = $dados_provas["disciplina"];
		$prova_maxnota = number_format($dados_provas["nota"],2,",",".");
		$prova_notafinal = number_format($dados_provas["nota_final"],2,",",".");
		$prova_notafinal_insert= $dados_provas["nota_final"];
		$prova_tentativa = $dados_provas["tentativa"];	
		$prova_idquestionario = $dados_provas["id_questionario"];
		
		
		//PEGA DADOS DA ATIVIDADE AVALIAÇÃO ONLINE
		$sql_turma_atividade = mysql_query("SELECT * FROM ced_turma_ativ WHERE cod_turma_d = '$turma_disc' AND cod_ativ = 1000 LIMIT 1");
		$dados_turma_ativ = mysql_fetch_array($sql_turma_atividade);
		$cod_turma_ativ = $dados_turma_ativ["ref_id"];
	
		$verifica_nota = mysql_query("SELECT * FROM ced_notas WHERE matricula = '$user_usuario' AND ref_ativ = '$cod_turma_ativ'");
		if(mysql_num_rows($verifica_nota)==0){
			mysql_query("INSERT INTO ced_notas (codnota, matricula, ref_ativ, turma_disc, grupo, nota) 
			VALUES (NULL, '$user_usuario', '$cod_turma_ativ','$turma_disc', 'A', '$prova_notafinal_insert')");
		} else {
			mysql_query("UPDATE ced_notas SET nota = '$prova_notafinal_insert' WHERE matricula = '$user_usuario' AND ref_ativ = '$cod_turma_ativ'");
		}
		
			
		echo "<tr>
			<td>$prova_disciplina</td>
			<td align=\"center\">$prova_maxnota</td>
			<td align=\"center\">$prova_notafinal</td>
			<td align=\"center\">$prova_tentativa</td>
		<tr>";
	}
}


?>
</div>
<?php
include('../includes/js_ead.php');
?>


<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
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
