<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
//CONEXÃO PDO E SCRIPTS SQL
require_once('includes/conectar_pdo.php');
require_once('includes/sql.php');

$turma_d = $_REQUEST["id"];
$id_turma = $_REQUEST["id_turma"];
$cancelado_observacao = "";

//SELECIONA OS ALUNOS DA TURMA

$sql_alunos = func_alunos_turma($id_turma);

//PEGA OS DADOS DA TURMA E DA DISCIPLINA
$sql_turma_disc = func_dados_turma_disc($turma_d);
$dados_turma_disc = $sql_turma_disc->fetch(PDO::FETCH_ASSOC);
$turma_grupo = $dados_turma_disc["grupo"];
$turma_cod_turma = $dados_turma_disc["cod_turma"];
$turma_nome_disciplina = $dados_turma_disc["disciplina"];
$turma_cod_disciplina = $dados_turma_disc["cod_disciplina"];
$turma_grade = $dados_turma_disc["anograde"];
$turma_cod_prof = $dados_turma_disc["cod_prof"];
$turma_nome_professor = $dados_turma_disc["nome_professor"];
$turma_nivel = $dados_turma_disc["nivel"];
$turma_curso = $dados_turma_disc["curso"];
$turma_modulo = $dados_turma_disc["modulo"];
$turma_unidade = $dados_turma_disc["unidade"];
$turma_polo = $dados_turma_disc["polo"];
$turma_inicio = $dados_turma_disc["turma_inicio"];
$turma_fim = $dados_turma_disc["turma_fim"];
$turma_min_nota =  $dados_turma_disc["min_nota"];
$turma_min_falta =  $dados_turma_disc["min_freq"];
$turma_tipo_etapa = $dados_turma_disc["tipo_etapa"];
$turma_ch_disciplina = $dados_turma_disc["ch"];

//PEGA AS ETAPAS EXISTENTES NA TURMA
$sql_etapa_atividades = func_busca_etapas($turma_tipo_etapa);
$sql_etapa_nome = func_busca_etapas($turma_tipo_etapa);
//x=ch*min_falta/100

// query para selecionar todos os campos da tabela usu�rios se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca � a vari�vel que foi enviada pelo nosso formul�rio da p�gina anterior
$total_alunos = $sql_alunos->rowCount();
$sql_grupos_notas = func_grupos_nota('C');
$contar_grupos_notas = $sql_grupos_notas->rowCount();
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
    <b>Di&aacute;rio de Notas</b>
</header>
<div class="panel-body">
<form action="#"  method="post">
<table width="100%" border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:8px">


    <tr>
        <th colspan="2"><img src="images/logo-cedtec.png" /></th>
        <th colspan="<?php echo $count2;?>">Registro de Avalia&ccedil;&otilde;es e Resultado</th>
    </tr>

    <tr>
        <td colspan="2"><b>Curso:<br /><?php echo strtoupper($turma_nivel).": ".strtoupper($turma_curso)." - Módulo ".strtoupper($turma_modulo);?></b></td>
        <td><b>Ano/Semestre:<br /><?php echo $turma_grupo;?></b></td>
        <td><b>Unidade / Polo - Turma<br /><?php echo strtoupper($turma_unidade);?> <?php echo strtoupper($turma_polo);?> - <?php echo $turma_cod_turma;?></b></td>
    </tr>
    <tr>
        <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($turma_nome_disciplina);?></b></td>
        <td><b>Docente:<br /><?php echo $turma_cod_prof." - ".$turma_nome_professor;?></b></td>
        <td><b>C.H:<br /><?php echo $turma_ch_disciplina;?> h.</b></td>
    </tr>
</table>

<table width="100%" border="1" class="full_table_list"  style="font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<tr style="font-size:12px;">
    <td width="50px"><div align="center"></div></td>
    <td width="300px"><div align="center"></div></td>
    <?php
    while($dados_etapa = $sql_etapa_nome->fetch(PDO::FETCH_ASSOC)){
        $etapa_nome = $dados_etapa["etapa"];
        $etapa_cor = $dados_etapa["cor_etapa"];
        echo "<td bgcolor=\"$etapa_cor\" colspan=\"4\"><center><b>$etapa_nome</b></center></td>";
    }

    ?>
</tr>
<tr style="font-size:8px;">
    <td width="50px"><div align="center"><strong>N&ordm;</strong></div></td>
    <td width="300px"><div align="center"><strong>Nome</strong></div></td>

    <?php




    if ($contar_grupos_notas == 0) {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Não há grupos de notas informados para a turma, contate o administrador do sistema');
    </SCRIPT>");
    } else {
        // sen�o
        // se houver mais de um resultado diz quantos resultados existem
        while($dados_etapa = $sql_etapa_atividades->fetch(PDO::FETCH_ASSOC)){
            $etapa_cor = $dados_etapa["cor_etapa"];
            $sql_grupos_notas_2 = func_grupos_nota();
            while ($dados_grupos_notas = $sql_grupos_notas_2->fetch(PDO::FETCH_ASSOC)) {
                // enquanto houverem resultados...
                $cod_atividade = $dados_grupos_notas["codigo"];
                $grupo_ativi = $dados_grupos_notas["grupo"];
                $atividade = $dados_grupos_notas["atividade"];
                $max_nota_ativ = $dados_grupos_notas["max_nota"];
                echo "
			<td bgcolor=\"$etapa_cor\"><div align=\"center\"><strong>$atividade</strong></div></td>
			
			\n";
                // exibir a coluna nome e a coluna email
            }
            echo "<td align=\"center\" bgcolor=\"$etapa_cor\"><b>Nota Parcial</b></td>";
        }

    }
    ;?>
    <td bgcolor="#EEEE0" align="center"><b>Faltas</b></td>
    <td bgcolor="#EEEE0" align="center"><b>Nota Final</b></td>
    <td align="center"><b>Resultado</b></td>
</tr>


<?php

// conta quantos registros encontrados com a nossa especifica��o
if ($total_alunos == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Atenção, não há alunos enturmados na turma escolhida')
    </SCRIPT>");
} else {
    // sen�o
    // se houver mais de um resultado diz quantos resultados existem
    $i = 0;
    while ($dados_alunos = $sql_alunos->fetch(PDO::FETCH_ASSOC)) {
        // enquanto houverem resultados...
        $codigo = $dados_alunos["matricula"];
        $nome = $dados_alunos["nome"];
        $img_aluno = "img_".$codigo;;
        //PEGA A FOTO ACADEMICA DO ALUNO
        $sql_foto = func_dados_usuario($codigo);
        $dados_foto = $sql_foto->fetch(PDO::FETCH_ASSOC);
        $foto_academica = $dados_foto["foto_academica"];
        $nota_parcial = 0;
        $i +=1;
        echo "
	<tr>
		<td><b><center>$i</b></center></td>
		<td style=\"font-size:8px\"><a style=\"color:black;text-decoration:none;\" onDblClick=\"mostrarElemento('$img_aluno', 'inline');\" 
        onMouseOut=\"mostrarElemento('$img_aluno', 'none');\">$nome</a>
		<div id=\"$img_aluno\" style=\"display:none; position:fixed;\"><img src=\"$foto_academica\"/></div>
		</td>
		
		
		\n";
        //pega notas por etapa
        $sql_etapa_notas = func_busca_etapas($turma_tipo_etapa);
        $nota_final = 0;
        while($dados_etapa = $sql_etapa_notas->fetch(PDO::FETCH_ASSOC)){
            $etapa_id = $dados_etapa["id_etapa"];
            $etapa_cor = $dados_etapa["cor_etapa"];
            $etapa_min_nota = $dados_etapa["min_nota"];
            $sql_grupos_notas_3 = func_grupos_nota();
            $total_grupos_notas = $sql_grupos_notas_3->rowCount();
            $count3= $total_grupos_notas + 9;
            $nota_parcial = 0;

            while ($dados_grupos_notas_2 = $sql_grupos_notas_3->fetch(PDO::FETCH_ASSOC)) {
                // enquanto houverem resultados...
                //pesquisa notas anteriores

                // enquanto houverem resultados...
                $cod_atividade = $dados_grupos_notas_2["codigo"];
                $grupo_ativi = $dados_grupos_notas_2["grupo"];
                $atividade = $dados_grupos_notas_2["atividade"];

                //PESQUISA NOTA POR ATIVIDADE
                //$pesq_nota = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $turma_d AND grupo = '$grupo_ativi'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
                $sql_calcular_nota = func_calcular_nota($codigo, $turma_d, $grupo_ativi, $etapa_id);
                $contar_nota = $sql_calcular_nota->rowCount();
                if($contar_nota == 0){
                    $nota_aluno = "0,00";
                    $nota_parcial1 = 0;
                } else {
                    $dados_nota = $sql_calcular_nota->fetch(PDO::FETCH_ASSOC);
                    $nota_aluno = number_format($dados_nota["notafinal"], 2, ',', '');
                    $nota_parcial1 = $dados_nota["notafinal"];
                }
                $nota_parcial += $nota_parcial1;
                //NOTAS DE AVALIA��ES E ATIVIDADES
                $sql_notas_atividades = func_calcular_nota_atividades($codigo,$turma_d, $etapa_id);
                $dados_notas_atividades = $sql_notas_atividades->fetch(PDO::FETCH_ASSOC);
                $nota_atividades = $dados_notas_atividades["notafinal"];

                //NOTAS DE RECUPERA��O
                $sql_nota_recuperacao = func_calcular_nota($codigo, $turma_d, 'C', $etapa_id);
					$dados_notas_recuperacao = $sql_nota_recuperacao->fetch(PDO::FETCH_ASSOC);
					$nota_recuperacao = $dados_notas_recuperacao["notafinal"];
					
					if($nota_atividades >= $etapa_min_nota){
                        $exibir_nota_parcial = format_valor($nota_atividades);
                    }
					if($nota_recuperacao == 0){
                    $exibir_nota_parcial = format_valor($nota_atividades);
                }
					if($nota_recuperacao > 0&&$nota_atividades < $etapa_min_nota){
                    $exibir_nota_parcial = format_valor($nota_recuperacao);
					}
					if($nota_recuperacao < $nota_atividades){
                    $exibir_nota_parcial = format_valor($nota_atividades);
                }
					if($nota_recuperacao > $nota_atividades){
                        $exibir_nota_parcial = format_valor($nota_recuperacao);
					}
					$nota_final += str_replace(",",".",$exibir_nota_parcial)/3;
					$exibir_nota_final = format_valor($nota_final);
					echo "
					<td bgcolor=\"$etapa_cor\" align=\"center\">$nota_aluno</b></td>";
					
				
			}
            echo "<td align=\"center\" bgcolor=\"$etapa_cor\">$exibir_nota_parcial</td>";
        }
        // exibir a coluna nome e a coluna email
        //PEGA AS FALTAS
        $sql_falta = func_contar_frequencia($codigo, $turma_d, 'F');
        $dados_falta = $sql_falta->fetch(PDO::FETCH_ASSOC);
        $falta         = $dados_falta["total"];

        //GERA O RESULTADO FINAL
        if($falta > $max_falta || str_replace(",",".",$exibir_nota_final) < $min_nota){
            $exibir_resultado = "Reprovado";
        } else {
            $exibir_resultado = "Aprovado";
        }

        //verifica cancelados
        $sql_cancelados = func_verificar_cancelado($codigo, $id_turma);
        if($sql_cancelados->rowCount() >= 1){
            $dados_cancelados = $sql_cancelados->fetch(PDO::FETCH_ASSOC);
            $nome_ocorrencia = $dados_cancelados["nome"];
            $data_ocorrencia = format_data($dados_cancelados["data"]);
            $exibir_resultado = "Cancelado";
            $cancelado_observacao .= "Aluno(a) $nome, nº de matricula $codigo foi $nome_ocorrencia em $data_ocorrencia.<br>";
        }
        echo "
		<td bgcolor=\"#EEEE0\" align=\"center\"><b>$falta</b></td>
		<td bgcolor=\"#EEEE0\" align=\"center\"><b>$exibir_nota_final</b></td>
		<td align=\"center\"><b>$exibir_resultado</b></td>";
    }
}

?>
</form>
</table>

<table width="100%" border="1" style="font-size:8px; font-family:Arial, Helvetica, sans-serif;">
    <tr>
        <td colspan="4" align="center"><div style="font-size:8px; font-family:Arial, Helvetica, sans-serif">OBSERVA&Ccedil;&Otilde;ES</div></td>
    </tr>

    <?php
    // exibi os cancelados em observa��es
    echo "<tr><td colspan=\"4\">$cancelado_observacao</td></tr>";
    $sql_obs = func_obs_turma_disc($turma_d);

    if($sql_obs->rowCount() >= 1){
        echo "<tr>
			<td align=\"center\"><b>DATA</b></td>
			<td align=\"center\" colspan=\"3\"><b>DESCRI&Ccedil;&Atilde;O</b></td>
		</tr>";
        while($dados_obs = $sql_obs->fetch(PDO::FETCH_ASSOC)){
            $id_obs = $dados_obs["id_obs"];
            $data_obs = substr($dados_obs["data_obs"],8,2)."/".substr($dados_obs["data_obs"],5,2)."/".substr($dados_obs["data_obs"],0,4);
            $obs = $dados_obs["obs"];
            echo "<tr>
			<td align=\"center\">$data_obs</td>
			<td colspan=\"3\">$obs</td>
		</tr>";

        }
    } else {
        echo "<tr>
			<td colspan=\"4\" style=\"line-height:70px\"></td>
		</tr>
		";
    }


    ?>



    <tr>
        <td>
            <br />
            <div align="center">___/___/____<br />Data</div>
        </td>
        <td>
            <br />
            <div align="center">______________________<br />Docente</div>
        </td>

        <td>
            <br />
            <div align="center">___/___/____<br />Data</div>
        </td>

        <td>
            <br />
            <div align="center">______________________<br />Dire&ccedil;&atilde;o Pedag&oacute;gica</div>
        </td>

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
        alert("o n� de usu�rio �: "+id);
    }
    //-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

    function baixa (){
        var data;
        do {
            data = prompt ("DIGITE O N�MERO DO T�TULO?");

            var width = 700;
            var height = 500;
            var left = 300;
            var top = 0;
        } while (data == null || data == "");
        if(confirm ("DESEJA VISUALIZAR O T�TULO N�:  "+data))
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
//nome = id do campo que ir� receber o valor, esse campo deve da pagina que gerou o popup
//opener � elemento que faz a vincula��o/referencia entre a window pai com a window filho ou popup
        opener.document.getElementById('fornecedor').value = valor;
    }
    function enviar2(valor){
//nome = id do campo que ir� receber o valor, esse campo deve da pagina que gerou o popup
//opener � elemento que faz a vincula��o/referencia entre a window pai com a window filho ou popup
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