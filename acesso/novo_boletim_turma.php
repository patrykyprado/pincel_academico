<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 19/03/15
 * Time: 14:36
 */
require_once('includes/restricao.php');
require_once('includes/conectar_pdo.php');
require_once('includes/funcoes.php');
require_once('includes/sql.php');
$id_turma = $_GET['id_turma'];
$id_aluno = 0;
if(isset($_GET['id_aluno'])){
    $id_aluno = $_GET['id_aluno'];
}
//pega os alunos selecionados
$sql_alunos = func_alunos_turma($id_turma, $id_aluno);
$total_alunos = $sql_alunos->rowCount();
$max_falta = 25/100;
$min_nota = 60;
$tempoInicio = date('H:i:s');

//pega dados da turma
$sql_turma = func_dados_turma($id_turma);
$dados_turma = $sql_turma->fetch(PDO::FETCH_ASSOC);
$turmaNivel = $dados_turma['nivel'];
$turmaCurso = $dados_turma['curso'];
$turmaModulo = $dados_turma['modulo'];
$turmaGrupo = $dados_turma['grupo'];
$turmaUnidade = $dados_turma['unidade'];
$turmaPolo = $dados_turma['polo'];
$turmaTurno = $dados_turma['turno'];
$turmaEmpresa = $dados_turma['empresa'];
$turmaTipoEtapa = $dados_turma['tipo_etapa'];

//pega disciplinas da turma
$sql_disciplinas = func_disciplinas_turma($id_turma);
$total_disciplinas = $sql_disciplinas->rowCount();
$colspan_header = ($total_disciplinas*2) + 3;
$disciplinas_cache_array = array();
$i_disciplina = 0;
foreach($sql_disciplinas as $dados_disciplina){
    $disciplinas_cache_array[$i_disciplina]['turma_disc'] = $dados_disciplina['turma_disc'];
    $disciplinas_cache_array[$i_disciplina]['disciplina'] = $dados_disciplina['disciplina'];
    $disciplinas_cache_array[$i_disciplina]['ch'] = $dados_disciplina['ch'];
    $i_disciplina +=1;
}
//pega etapas da turma e monta cache
$sql_etapas = func_busca_etapas($turmaTipoEtapa);
$etapas_cache_array = array();
$i_etapa = 0;
$colspan_header2 = $colspan_header / $sql_etapas->rowCount();
$colspan_header = $sql_etapas->rowCount() + $colspan_header + 5;
foreach($sql_etapas as $dados_etapa){
    $etapas_cache_array[$i_etapa]['id_etapa'] = $dados_etapa['id_etapa'];
    $etapas_cache_array[$i_etapa]['tipo_etapa'] = $dados_etapa['tipo_etapa'];
    $etapas_cache_array[$i_etapa]['nivel'] = $dados_etapa['nivel'];
    $etapas_cache_array[$i_etapa]['etapa'] = $dados_etapa['etapa'];
    $etapas_cache_array[$i_etapa]['cor_etapa'] = $dados_etapa['cor_etapa'];
    $etapas_cache_array[$i_etapa]['empresa'] = $dados_etapa['empresa'];
    $etapas_cache_array[$i_etapa]['min_nota'] = $dados_etapa['min_nota'];
    $etapas_cache_array[$i_etapa]['max_nota'] = $dados_etapa['max_nota'];
    $etapas_cache_array[$i_etapa]['grupos_ativ'] = $dados_etapa['grupos_ativ'];
    $i_etapa +=1;
}


// Incluímos a biblioteca DOMPDF
require_once("../dompdf/dompdf_config.inc.php");
// Instanciamos a classe
$dompdf = new DOMPDF();
$html = '
 <html>
 <head>
   <style="text/css">
     body {
       font-family: Calibri, DejaVu Sans, Arial;
       margin: 0;
       padding: 0;
       border: none;
       font-size: 13px;
     }
     .titulo1 {
        font-size: 10px;
        color: #292B36;
        font-weight: bold;
        font-family: tahoma, verdana, arial, sans-serif;
     }
     .corpo1 {
        font-size: 8px;
        color: #292B36;
        font-family: tahoma, verdana, arial, sans-serif;
     }
     .quebrar-pagina {
       page-break-after: always;
     }
   </style>
 </head>
 <body>
   <div id="exemplo">';
foreach($sql_alunos as $dados_alunos){
    $html .='
<table border="1" cellspacing="0" width="100%">
<thead>
<tr>
    <th colspan="'.$colspan_header.'">
    <table cellspacing="0" cellpadding="0" border="1" width="100%">
        <tr>
            <td colspan="3" align="center"><div class="titulo1">Boletim Acadêmico</div></td>
        </tr>
        <tr style="padding:0px;margin:0px:">
            <td rowspan="2" align="center" width="250px"><img src="images/logo-cedtec.png" /></td>
            <td><div class="titulo1">Curso: <br>'.strtoupper($turmaNivel).': '.strtoupper($turmaCurso).'</div></td>
            <td><div class="titulo1">Ano / Módulo: <br>'.$turmaModulo.'</div></td>
        </tr>
        <tr style="padding:0px;margin:0px:">
            <td><div class="titulo1">Unidade / Polo: <br>'.strtoupper($turmaUnidade).' / '.strtoupper($turmaPolo).'</div></td>
            <td><div class="titulo1">Grupo / Semestre: <br>'.$turmaGrupo.'</div></td>
        </tr>
        <tr>
            <td colspan="3"><div class="titulo1">Aluno(a):<br>'.$dados_alunos['matricula'].' | '.$dados_alunos['nome'].'</div></td>
        </tr>
    </table>
    </td>
</tr>
</thead>
<tbody>
    <tr>
        <td align="center" rowspan="2"><div class="titulo1">Componente Curricular / Disciplina</div></td>';
    $sql_etapas_nome = $etapas_cache_array;
    foreach($sql_etapas_nome as $dados_etapa){
        $html .= '<td align="center" bgcolor="'.$dados_etapa['cor_etapa'].'" colspan="'.$colspan_header2.'"><div class="titulo1">'.utf8_encode($dados_etapa['etapa']).'</div></td>';
    }
    $html .='
    </tr>
    <tr>';
    //busca as atividades da etapa
    $sql_etapa_atividade = $etapas_cache_array;
    foreach($sql_etapa_atividade as $dados_etapa_atividades){
        $sql_atividades = func_buscar_atividades($dados_etapa_atividades['grupos_ativ']);
        $total_atividades = $sql_atividades->rowCount();
        foreach($sql_atividades as $dados_atividades){
            $html .= '<td align="center" bgcolor="'.$dados_etapa_atividades['cor_etapa'].'" colspan="'.$colspan_header2/$total_atividades.'"><div class="titulo1">'.utf8_encode($dados_atividades['atividade']).'</div></td>';
        }
        $html .= '<td align="center" bgcolor="'.$dados_etapa_atividades['cor_etapa'].'"><div class="titulo1">Nota Parcial</div></td>';
    }
    $html .= '
<td align="center" bgcolor="yellow"><div class="titulo1">Faltas</div></td>
<td align="center" bgcolor="yellow"><div class="titulo1">Nota Final</div></td>
<td align="center"><div class="titulo1">Resultado</div></td>
</tr>';
    $sql_disciplinas_aluno = $disciplinas_cache_array;
    foreach($sql_disciplinas_aluno as $dados_disciplina_aluno){
        $html .= '
        <tr>
        <td><div class="titulo1">'.utf8_encode($dados_disciplina_aluno['disciplina']).'</div></td>';
        $sql_etapas_notas = $etapas_cache_array;
        $nota_parcial_aluno = 0;
        $nota_recuperacao_aluno = 0;
        $nota_final_aluno = 0;
        $min_nota_aprovacao = 0;
        foreach($sql_etapas_notas as $dados_etapas_notas){
            //busca as atividades da etapa
            $sql_atividades_notas = func_buscar_atividades($dados_etapas_notas['grupos_ativ']);
            $total_atividades_notas = $sql_atividades_notas->rowCount();
            $min_nota_aprovacao += $dados_etapas_notas['min_nota'];
            foreach($sql_atividades_notas as $dados_atividades_notas){
                $sql_calcular_nota_aluno = func_calcular_nota($dados_alunos['matricula'], $dados_disciplina_aluno['turma_disc'], $dados_atividades_notas['grupo'], $dados_etapas_notas['id_etapa']);
                if($sql_calcular_nota_aluno->rowCount() == 1){
                    $dados_calcular_nota_aluno = $sql_calcular_nota_aluno->fetch(PDO::FETCH_ASSOC);
                    $nota_atividade_aluno = $dados_calcular_nota_aluno['notafinal'];
                } else {
                    $nota_atividade_aluno = 0;
                }
                if($dados_atividades_notas['grupo'] != 'C'){
                    $nota_parcial_aluno += $nota_atividade_aluno;
                } else {
                    $nota_recuperacao_aluno += $nota_atividade_aluno;
                }
                if($nota_recuperacao_aluno > $nota_parcial_aluno){
                    $nota_parcial_aluno = $nota_recuperacao_aluno;
                }
                $html .= '<td align="center" bgcolor="'.$dados_etapas_notas['cor_etapa'].'" colspan="'.$colspan_header2/$total_atividades_notas.'"><div class="titulo1">'.format_valor($nota_atividade_aluno).'</div></td>';
            }
            $html .= '<td align="center" bgcolor="'.$dados_etapas_notas['cor_etapa'].'"><div class="titulo1">'.format_valor($nota_parcial_aluno).'</div></td>';
            $nota_final_aluno += $nota_parcial_aluno;
        }
        //pega faltas do aluno
        $sql_falta_aluno = func_contar_frequencia($dados_alunos['matricula'], $dados_disciplina_aluno['turma_disc'], 'F');
        $faltas_aluno = 0;
        if($sql_falta_aluno->rowCount() >= 1){
            $dados_falta_aluno = $sql_falta_aluno->fetch(PDO::FETCH_ASSOC);
            $faltas_aluno = $dados_falta_aluno['total'];
        }
        $resultado_aluno = 'Reprovado';
        if($nota_final_aluno >= $min_nota_aprovacao){
            $resultado_aluno = 'Aprovado';
        }
        $html .= '<td align="center" bgcolor="yellow"><div class="titulo1">'.($faltas_aluno).'</div></td>';
        $html .= '<td align="center" bgcolor="yellow"><div class="titulo1">'.format_valor($nota_final_aluno).'</div></td>';
        $html .= '<td align="center"><div class="titulo1">'.($resultado_aluno).'</div></td>';
        $html .='</tr>';
    }
    $html .='
</tbody>
</table>
<div class="quebrar-pagina">-</div> ';
}

$html .='
   </div>
 </body>
 </html>';
// Passamos o conteúdo que será convertido para PDF
$dompdf->load_html($html);
// Definimos o tamanho do papel e
// sua orientação (retrato ou paisagem)
$dompdf->set_paper('A4','landscape');

// O arquivo é convertido
$dompdf->render();
//GRAVAR LOG NA TABELA DE LOGS
$tempoFim= date('H:i:s');
$tempoExecucao = calcularTempoExecucao($tempoInicio, $tempoFim);
func_gravar_log($user_usuario, 12,'Gerou '.$total_alunos.' boletins academicos da turma '.$id_turma.' com tempo de '.$tempoExecucao.'.', $user_ip);
// Salvo no diretório temporário do sistema
// e exibido para o usuário
$dompdf->stream(gerarNomeDocumentoTurma($dados_turma, 'pdf'));
?>