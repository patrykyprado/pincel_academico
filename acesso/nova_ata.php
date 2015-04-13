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
$id_turma = $_GET['id'];
$id_etapa = $_GET['etapa'];

$max_falta = 25/100;
$min_nota = 60;

$tempoInicio = date('H:i:s');



//pega alunos da turma
$sql_alunos = func_alunos_turma($id_turma);
$total_alunos = $sql_alunos->rowCount();

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

//pega disciplinas da turma
$sql_disciplinas = func_disciplinas_turma($id_turma);
$total_disciplinas = $sql_disciplinas->rowCount();

$colspan_header = ($total_disciplinas*2) + 3;
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
   </style>
 </head>
 <body>
   <div id="exemplo">';
$html .='
<table border="1" cellspacing="0">
<thead>
<tr>
    <th colspan="'.$colspan_header.'">
    <table cellspacing="0" cellpadding="0" border="1" width="100%">
        <tr style="padding:0px;margin:0px:">
            <td rowspan="2" align="center" width="250px"><img src="images/logo-cedtec.png" /></td>
            <td><div class="titulo1">Curso: <br>'.strtoupper($turmaNivel).': '.strtoupper($turmaCurso).'</div></td>
            <td><div class="titulo1">Ano / Módulo: <br>'.$turmaModulo.'</div></td>
        </tr>
        <tr style="padding:0px;margin:0px:">
            <td><div class="titulo1">Unidade / Polo: <br>'.strtoupper($turmaUnidade).' / '.strtoupper($turmaPolo).'</div></td>
            <td><div class="titulo1">Grupo / Semestre: <br>'.$turmaGrupo.'</div></td>
        </tr>
    </table>
    </td>
</tr>
<tr>
    <th rowspan="2"><div class="titulo1">Nº</div></th>
    <th rowspan="2" width="250px"><div class="titulo1">Nome</div></th>';
    $disciplinas_cache_array = array();
    $i_disciplina = 0;
    foreach($sql_disciplinas as $dados_disciplina){
        $disciplinas_cache_array[$i_disciplina]['turma_disc'] = $dados_disciplina['turma_disc'];
        $disciplinas_cache_array[$i_disciplina]['ch'] = $dados_disciplina['ch'];
        $i_disciplina +=1;
        //gera cabeçalho com disciplinas da turma
        $html .= '
        <th colspan="2"><div class="titulo1">'.utf8_encode($dados_disciplina['disciplina']).'</div></th>';
    }
    $html .= '<th rowspan="2"><div class="titulo1">Resultado</div></th>
    </tr>
     <tr>';

    $disciplina_montar_topo = $disciplinas_cache_array;
    foreach($disciplina_montar_topo as $dados_topo){
        $html .= '<th><div class="corpo1">Nota</div></th> <th><div class="corpo1">Faltas</div></th>';
    }
    $html .='
    </tr>
    </thead>
    <tbody>';
    $n_aluno = 1;
    $obs_turma = '';
foreach($sql_alunos as $dados_alunos){
    $resultado_aluno = 0;
    $resultado_final = '<td bgcolor="#eed3d7"><div class="corpo1">Reprovado</div></td>';
    $exib_i= str_pad($n_aluno, 2,"0", STR_PAD_LEFT);
    //VERIFICA SE O ALUNO FOI CANCELADO
    $sql_ocorrencia = func_ocorrencias($dados_alunos['matricula'], $id_turma, 1);
    $total_ocorrencias = $sql_ocorrencia->rowCount();
    if($total_ocorrencias == 1){
        $dados_ocorrencia = $sql_ocorrencia->fetch(PDO::FETCH_ASSOC);
        $obs_turma .= '- O aluno '.$dados_alunos['nome'].' foi <b>'.strtoupper($dados_ocorrencia['nome_ocorrencia']).'</b> em '.format_data($dados_ocorrencia['data']).'.<br>';
    }
    $html .= '
    <tr>
        <td width="10px"><div class="corpo1"><b>'.$exib_i.'</b></div></td>
        <td><div class="corpo1">'.utf8_encode($dados_alunos['nome']).'</div></td>';
        $disciplinas_montar_notas = $disciplinas_cache_array;
        foreach($disciplinas_montar_notas as $disciplina_cod)
        {
            //PEGA NOTAS DA DISCIPLINA
            $sql_alunos_notas = func_calcular_nota_atividades($dados_alunos['matricula'],$disciplina_cod['turma_disc'],$id_etapa);
            $dados_aluno_nota = $sql_alunos_notas->fetch(PDO::FETCH_ASSOC);
            $max_falta_disciplina = $disciplina_cod['ch'] * $max_falta;
            //PEGA NOTAS DE RECUPERAÇÃO
            $sql_alunos_notas_recuperacao = func_calcular_nota($dados_alunos['matricula'],$disciplina_cod['turma_disc'],'C', $id_etapa);
            $dados_aluno_nota_rec = $sql_alunos_notas_recuperacao->fetch(PDO::FETCH_ASSOC);
            $nota_final = func_arredondar_nota($dados_turma,$dados_aluno_nota['notafinal']);
            if($dados_aluno_nota_rec['notafinal'] >= $nota_final){
                $nota_final = func_arredondar_nota($dados_turma,$dados_aluno_nota_rec['notafinal']);
            }
            //PEGA FALTAS DO ALUNO
            $sql_alunos_falta = func_contar_frequencia($dados_alunos['matricula'],$disciplina_cod['turma_disc'],'F');
            $dados_aluno_falta = $sql_alunos_falta->fetch(PDO::FETCH_ASSOC);
            $falta_total = 0;
            if(!empty($dados_aluno_falta['total'])){
                $falta_total = $dados_aluno_falta['total'];
            }

            //monta o resultado
            if($falta_total <= $max_falta_disciplina && $nota_final >= $min_nota){
                $resultado_aluno += 1;
            }
            $html .= '
            <td><div class="corpo1"><center>'.format_valor($nota_final).'</center></div>
                </td>
            <td><div class="corpo1"><center>'.$falta_total.'</center></div></td>';
        }
        if($resultado_aluno >= $total_disciplinas){
            $resultado_final = '<td><div class="corpo1">Aprovado</div></td>';
        }
        if($total_ocorrencias == 1){
            $resultado_final = '<td bgcolor="#eed3d7"><div class="corpo1">'.$dados_ocorrencia['nome_ocorrencia'].'</div></td>';
        }
        $html .= $resultado_final;
        ?>
    <?php
$n_aluno +=1;
}
if(!empty($obs_turma)){
    $observacoes_turma = '<tr>
    <td colspan="'.$colspan_header.'"><div class="titulo1">Observações da Turma</div></td>
</tr>
<tr>
    <td colspan="'.$colspan_header.'"><div class="corpo1">'.$obs_turma.'</div></td>
</tr>';
}
$html .= '
'.$observacoes_turma.'
</tbody>
</table>';
/*
 * <tfoot>
    <tr>
        <td colspan="'.($colspan_header/2).'">Assinatura</td>
        <td colspan="'.($colspan_header/2).'">Assinatura 2</td>
    </tr>
    </tfoot>
 */
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
func_gravar_log($user_usuario, 11,'Gerou uma ata de resultados da turma '.$id_turma.' com tempo de '.$tempoExecucao.'.', $user_ip);
// Salvo no diretório temporário do sistema
// e exibido para o usuário
$dompdf->stream(gerarNomeDocumentoTurma($dados_turma, 'pdf'));
?>