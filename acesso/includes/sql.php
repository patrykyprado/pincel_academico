<?php

function buscar_aluno($buscar, $unidade, $empresa)
{
if($unidade =="" || $empresa == 20){
	$sql = "SELECT DISTINCT ca.matricula, a.nome, a.nome_fin, ca.curso, ca.unidade, ca.polo,ac.foto_perfil, ac.foto_academica, ac.senha, ac.email
		FROM alunos a
		INNER JOIN curso_aluno ca
		ON ca.matricula = a.codigo
		INNER JOIN acessos_completos ac
		ON ac.usuario = ca.matricula
		WHERE a.nome LIKE '%$buscar%' OR ca.matricula LIKE '$buscar' ORDER BY a.nome";

} else {
	$sql = "SELECT DISTINCT ca.matricula, a.nome, a.nome_fin, ca.curso, ca.unidade, ca.polo,ac.foto_perfil, ac.foto_academica, ac.senha, ac.email
		FROM alunos a
		INNER JOIN curso_aluno ca
		ON ca.matricula = a.codigo
		INNER JOIN acessos_completos ac
		ON ac.usuario = ca.matricula
		WHERE (ca.unidade LIKE '%$unidade%' OR ca.polo LIKE '%$unidade%') AND (a.nome LIKE '%$buscar%' OR a.nome_fin LIKE '%$buscar%' OR ca.matricula = '$buscar') ORDER BY a.nome";

}

	return $sql;
}




function func_cad_agrupamento($dados){
    global $conn;
    $sql_cad_agrupamento = "INSERT INTO agrupamentos
    (id_agrupamento, agrupamento, data_inicio, data_fim, unidade, nivel)
    VALUES
    (NULL, '".$dados['agrupamento']."', '".$dados['data_inicio']."',
    '".$dados['data_fim']."','".$dados['unidade']."','".$dados['nivel']."')";
    //INSERE OS DADOS DO AGRUPAMENTO NO BANCO DE DADOS
    $sql_inserir_agrupamento = $conn->prepare($sql_cad_agrupamento);
    $sql_inserir_agrupamento->execute();
    $total_inserido = $sql_inserir_agrupamento->rowCount();
    if($total_inserido == 0){
        return "<script language=\"javascript\">
        alert('Erro ao inserir agrupamento');
    </script>";
    } else {
        $nomeAgrupamento = $dados['agrupamento'];
        return "<script language=\"javascript\">
        alert('Agrupamento: $nomeAgrupamento foi cadastrado com sucesso!');
        location.href='cad_agrupamento.php';
        </script>";
    }

}

function func_drop_grupos_turmas(){
    global $conn;
    $sql_grupos = "SELECT DISTINCT grupo
    FROM ced_turma";
    //DROP DE GRUPOS
    $sql_drop_grupos = $conn->prepare($sql_grupos);
    $sql_drop_grupos->execute();
    return $sql_drop_grupos;
}

function func_drop_nivel_ensino(){
    global $conn;
    $sql_nivel = "SELECT DISTINCT nivel
    FROM disciplinas WHERE nivel NOT LIKE '%nivel%' AND TRIM(nivel) != ''";
    //DROP DE NIVEIS
    $sql_drop_nivel = $conn->prepare($sql_nivel);
    $sql_drop_nivel->execute();
    return $sql_drop_nivel;
}

function func_drop_unidade($userUnidade = null){
    global $conn;
    $sql_unidade = "SELECT * FROM unidades
    WHERE 1 = 1 AND categoria = 1 ";
    if(!empty($userUnidade)){
        $sql_unidade .= " AND unidade LIKE '%".$userUnidade."%'";
    } else {
        $sql_unidade .= " OR unidade LIKE '%EAD%'";
    }
    $sql_unidade .= " ORDER BY unidade";
    //DROP DE NIVEIS
    $sql_drop_unidade = $conn->prepare($sql_unidade);
    $sql_drop_unidade->execute();
    return $sql_drop_unidade;
}

function func_busca_disciplinas_agrupamento($dados){
    global $conn;
    $sql_disciplinas = "SELECT ct.cod_turma, ct.nivel, ct.curso, ct.modulo, ct.unidade,
ct.polo, ct.grupo, ctd.codigo AS turma_disc, d.disciplina
FROM ced_turma ct
INNER JOIN ced_turma_disc ctd
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON d.anograde = ct.anograde AND ctd.disciplina = d.cod_disciplina
WHERE 1 = 1 ";
    if(!empty($dados['disciplina'])){
        $sql_disciplinas .= " AND d.disciplina LIKE '%".$dados['disciplina']."%'";
    }
    if(!empty($dados['grupo'])){
        $sql_disciplinas .= " AND ct.grupo LIKE '%".$dados['grupo']."%'";
    }
    if(!empty($dados['nivel'])){
        $sql_disciplinas .= " AND ct.nivel LIKE '%".$dados['nivel']."%'";
    }
    $sql_disciplinas .= " ORDER BY d.disciplina, ct.nivel, ct.curso";
    //BUSCA DE DISCIPLINAS PARA AGRUPAMENTOS
    $sql_busca = $conn->prepare($sql_disciplinas);
    $sql_busca->execute();
    return $sql_busca;
}

function func_drop_agrupamentos_ativos(){
    global $conn;
    $sql_agrupamentos = "SELECT id_agrupamento, agrupamento FROM agrupamentos
WHERE CURRENT_DATE <= data_inicio";
    //DROP DE AGRUPAMENTOS ATIVOS NÃO INICIADOS
    $sql_drop_agrupamentos = $conn->prepare($sql_agrupamentos);
    $sql_drop_agrupamentos->execute();
    return $sql_drop_agrupamentos;
}

function func_agrupamento_selecionado($idAgrupamento){
    global $conn;
    $sql_agrupamentos = "SELECT * FROM agrupamentos
WHERE disciplinas IN (".$idAgrupamento.")";
    //DADOS DO AGRUPAMENTO SELECIONADO
    $sql_drop_agrupamentos = $conn->prepare($sql_agrupamentos);
    $sql_drop_agrupamentos->execute();
    return $sql_drop_agrupamentos;
}

function func_agrupamento_dados($idAgrupamento){
    global $conn;
    $sql_agrupamentos = "SELECT * FROM agrupamentos
WHERE id_agrupamento = {$idAgrupamento}";
    //DADOS DO AGRUPAMENTO SELECIONADO
    $sql_drop_agrupamentos = $conn->prepare($sql_agrupamentos);
    $sql_drop_agrupamentos->execute();
    return $sql_drop_agrupamentos;
}

function func_agrupamento_atualizar($idAgrupamento, $disciplinas){
    global $conn;
    $sql_agrupamentos = "UPDATE agrupamentos
    SET disciplinas = '".$disciplinas."'
WHERE id_agrupamento = {$idAgrupamento}";
    //ATUALIZA AGRUPAMENTO SELECIONADO
    $sql_drop_agrupamentos = $conn->prepare($sql_agrupamentos);
    $sql_drop_agrupamentos->execute();
    return $sql_drop_agrupamentos;
}

function func_alunos_turma($idTurma, $matricula = null){
    global $conn;
    $sql_alunos = "SELECT DISTINCT alu.codigo AS matricula, alu.nome
FROM ced_turma_aluno cta
INNER JOIN alunos alu
ON alu.codigo = cta.matricula
WHERE cta.id_turma = {$idTurma} ";
    if(!empty($matricula)){
      $sql_alunos .= " AND alu.codigo = {$matricula} ";
    }
    $sql_alunos .= "ORDER BY alu.nome";
    //BUSCA ALUNOS DA TURMA
    $sql_busca_alunos = $conn->prepare($sql_alunos);
    $sql_busca_alunos->execute();
    return $sql_busca_alunos;
}

function func_dados_turma_disc($turmaDisc){
    global $conn;
    $sql_turma_disc = "SELECT ct.cod_turma, d.cod_disciplina, d.disciplina, d.ch, d.anograde, ctd.cod_prof,
alu.nome as nome_professor, ctd.inicio, ctd.fim, ct.grupo, ct.nivel, ct.curso, ct.modulo, ct.unidade,
ct.polo, ct.inicio as turma_inicio, ct.fim as turma_fim, ct.min_nota, ct.min_freq, ct.tipo_etapa
FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN alunos alu
ON alu.codigo = ctd.cod_prof
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
WHERE ctd.codigo = {$turmaDisc}";
    //BUSCA DADOS DA DISCIPLINA TURMA
    $sql_dados_disc = $conn->prepare($sql_turma_disc);
    $sql_dados_disc->execute();
    return $sql_dados_disc;
}

function func_disciplinas_turma($idTurma){
    global $conn;
    $sql_turma_disc = "SELECT ctd.codigo as turma_disc, ct.cod_turma, d.cod_disciplina, d.disciplina, d.ch, d.anograde, ctd.cod_prof,
alu.nome as nome_professor, ctd.inicio, ctd.fim, ct.grupo, ct.nivel, ct.curso, ct.modulo, ct.unidade,
ct.polo, ct.inicio as turma_inicio, ct.fim as turma_fim, ct.min_nota, ct.min_freq, ct.tipo_etapa
FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN alunos alu
ON alu.codigo = ctd.cod_prof
INNER JOIN disciplinas d
ON d.cod_disciplina = ctd.disciplina AND d.anograde = ct.anograde
WHERE ct.id_turma = {$idTurma} AND d.disciplina NOT LIKE '%AMBIE%'";
    //BUSCA DADOS DA DISCIPLINA TURMA
    $sql_dados_disc = $conn->prepare($sql_turma_disc);
    $sql_dados_disc->execute();
    return $sql_dados_disc;
}

function func_busca_etapas($tipoEtapa){
    global $conn;
    $sql_etapas = "SELECT id_etapa, tipo_etapa, nivel, etapa, cor_etapa,
empresa, min_nota, max_nota, grupos_ativ
FROM ced_etapas
WHERE tipo_etapa = {$tipoEtapa}
ORDER BY etapa";
    //BUSCA DADOS DA ETAPA
    $sql_dados_etapas = $conn->prepare($sql_etapas);
    $sql_dados_etapas->execute();
    return $sql_dados_etapas;
}

function func_buscar_atividades($gruposAtiv){
    global $conn;
    $sql_atividades = "SELECT atividade, grupo
FROM ced_desc_nota
WHERE grupo IN (".$gruposAtiv.")";
    //BUSCA DADOS DAS ATIVIDADES DA TURMA
    $sql_dados_atividade = $conn->prepare($sql_atividades);
    $sql_dados_atividade->execute();
    return $sql_dados_atividade;
}

function func_grupos_nota($idGrupo = null){
    global $conn;
    $sql_grupos = "SELECT codigo, ensino, atividade, max_nota, grupo, subgrupo
FROM ced_desc_nota WHERE subgrupo LIKE '0'";
    if(!empty($idGrupo))
        $sql_grupos .= " AND grupo NOT LIKE '{$idGrupo}'";
    //BUSCA DADOS DE GRUPOS DE NOTAS
    $sql_grupos_notas = $conn->prepare($sql_grupos);
    $sql_grupos_notas->execute();
    return $sql_grupos_notas;
}

function func_dados_usuario($usuario){
    global $conn;
    $sql_usuario = "SELECT id_user, nome, usuario, senha, nivel, email,
exibir_email, sobre, foto_perfil, foto_academica
FROM acessos_completos
WHERE usuario = '{$usuario}'";
    //BUSCA DADOS DO USUÁRIO RECEBIDO PELO PARAMENTO USUARIO
    $sql_dados_usuario = $conn->prepare($sql_usuario);
    $sql_dados_usuario->execute();

    if(0 == $sql_dados_usuario->rowCount()){
        $sql_usuario = "SELECT id_user, nome,usuario, senha, foto_perfil, grupo, setor, email
FROM users
WHERE usuario = '{$usuario}'";
        //BUSCA DADOS DO USUÁRIO RECEBIDO PELO PARAMENTO USUARIO
        $sql_dados_usuario = $conn->prepare($sql_usuario);
        $sql_dados_usuario->execute();
    }

    return $sql_dados_usuario;
}

function func_calcular_nota($matricula, $turmaDisc, $grupoAtiv, $idEtapa){
    global $conn;
    $sql_nota = "SELECT sum(t1.nota) as notafinal
FROM (SELECT DISTINCT cn.matricula, cn.ref_ativ, cn.turma_disc, cn.grupo, cn.nota FROM
	ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	INNER JOIN ced_desc_nota cdn
	ON cdn.codigo = cta.cod_ativ
	WHERE cn.matricula = {$matricula} AND cn.turma_disc = {$turmaDisc} AND cdn.subgrupo = '{$grupoAtiv}'
	AND cta.id_etapa = $idEtapa) t1";
    //BUSCA DADOS DE GRUPOS DE NOTAS
    $sql_nota_final = $conn->prepare($sql_nota);
    $sql_nota_final->execute();
    return $sql_nota_final;
}

function func_calcular_nota_atividades($matricula, $turmaDisc, $idEtapa){
    global $conn;
    $sql_nota = "SELECT sum(t1.nota) as notafinal
FROM (SELECT DISTINCT cn.matricula, cn.ref_ativ, cn.turma_disc, cn.grupo, cn.nota FROM
	ced_notas cn
	INNER JOIN ced_turma_ativ cta
	ON cta.ref_id = cn.ref_ativ
	INNER JOIN ced_desc_nota cdn
	ON cdn.codigo = cta.cod_ativ
	WHERE cn.matricula = {$matricula} AND cn.turma_disc = {$turmaDisc} AND (cdn.subgrupo = 'A' OR cdn.subgrupo = 'B')
	AND cta.id_etapa = $idEtapa) t1";
    //BUSCA DADOS DE GRUPOS DE NOTAS
    $sql_nota_final = $conn->prepare($sql_nota);
    $sql_nota_final->execute();
    return $sql_nota_final;
}


function func_contar_frequencia($matricula, $turmaDisc, $status){
    global $conn;
    $sql_frequencia = "SELECT COUNT(cfa.n_aula) as total
    FROM ced_falta_aluno cfa
WHERE cfa.matricula = {$matricula} AND cfa.turma_disc = {$turmaDisc}
AND cfa.status LIKE '{$status}'";
    //BUSCA DADOS DE GRUPOS DE NOTAS
    $sql_total_frenquencia = $conn->prepare($sql_frequencia);
    $sql_total_frenquencia->execute();
    return $sql_total_frenquencia;
}

function func_verificar_cancelado($matricula, $idTurma){
    global $conn;
    $sql_cancelado = "SELECT toc.nome, oco.data
FROM ocorrencias oco
INNER JOIN tipo_ocorrencia toc
ON oco.n_ocorrencia = toc.id
WHERE oco.n_ocorrencia = 1 AND oco.matricula = {$matricula} AND oco.id_turma = {$idTurma} LIMIT 1'";
    //BUSCA DADOS DE GRUPOS DE NOTAS
    $sql_dados_cancelados = $conn->prepare($sql_cancelado);
    $sql_dados_cancelados->execute();
    return $sql_dados_cancelados;
}

function func_obs_turma_disc($turmaDisc, $matricula = 0){
    global $conn;
    $sql_obs = "SELECT id_obs, id_turma, turma_disc, tipo_obs, data_obs, obs, matricula
FROM ced_turma_obs
WHERE turma_disc = {$turmaDisc} AND matricula = {$matricula}";
    //BUSCA DADOS DE GRUPOS DE NOTAS
    $sql_obs_turma_disc = $conn->prepare($sql_obs);
    $sql_obs_turma_disc->execute();
    return $sql_obs_turma_disc;
}

function func_dados_turma($idTurma){
    global $conn;
    $sql_turma = "SELECT *
FROM ced_turma
WHERE id_turma = {$idTurma}";
    //BUSCA DADOS DE GRUPOS DE NOTAS
    $sql_dados_turma = $conn->prepare($sql_turma);
    $sql_dados_turma->execute();
    return $sql_dados_turma;
}


function func_arredondar_nota($dadosTurma, $nota){
    global $conn;
    $nota = number_format($nota, 2,'.','');
    $nota_exp = explode('.', $nota);
    $nota_int = $nota_exp[0];
    $nota_dec = '0.'.$nota_exp[1];
    //arredonda valores inteiros
    $sql_arredondar_int = "SELECT nova_nota FROM ced_regras_arredondar
WHERE ({$nota_int} BETWEEN min_nota AND max_nota)
AND nivel LIKE '%".$dadosTurma['nivel']."%' AND unidade LIKE '%".$dadosTurma['unidade']."%'";
    //BUSCA DADOS PARA ARREDONDAR NOTA SE HOUVER REGRA CADASTRADA
    $sql_dados_arredondar_int = $conn->prepare($sql_arredondar_int);
    $sql_dados_arredondar_int->execute();
    if($sql_dados_arredondar_int->rowCount() == 1){
        $dados_arredondar_int = $sql_dados_arredondar_int->fetch(PDO::FETCH_ASSOC);
        $nota_int = $dados_arredondar_int['nova_nota'];
    }
    //arredonda valores decimais
    $sql_arredondar_dec = "SELECT nova_nota FROM ced_regras_arredondar
WHERE ({$nota_dec} BETWEEN min_nota AND max_nota)
AND nivel LIKE '%".$dadosTurma['nivel']."%' AND unidade LIKE '%".$dadosTurma['unidade']."%'";
    //BUSCA DADOS PARA ARREDONDAR NOTA SE HOUVER REGRA CADASTRADA
    $sql_dados_arredondar_dec = $conn->prepare($sql_arredondar_dec);
    $sql_dados_arredondar_dec->execute();
    if($sql_dados_arredondar_dec->rowCount() == 1){
        $sql_dados_arredondar_dec = $sql_dados_arredondar_dec->fetch(PDO::FETCH_ASSOC);
        $nota_dec = $sql_dados_arredondar_dec['nova_nota'];
    }

    return $nota_int + $nota_dec;

}

function func_gravar_log($usuario, $codAcao, $Registro, $ipUsuario){
    global $conn;
    $sql_log = "INSERT INTO logs
(id_log, usuario, data_hora, cod_acao, acao, ip_usuario)
VALUES
(NULL, '".$usuario."', NOW(), '".$codAcao."', '".$Registro."', '".$ipUsuario."')";
    //GRAVA REGISTRO DE LOG
    $sql_gravar_log = $conn->prepare($sql_log);
    $sql_gravar_log->execute();
}

function func_ocorrencias($matricula = null, $idTurma = null, $nOcorrencia = null, $notIn = null){
    global $conn;
    $sql_ocorrencia = "SELECT oco.matricula, tio.nome as nome_ocorrencia, tio.ocorrencia, oco.data
FROM ocorrencias oco
INNER JOIN tipo_ocorrencia tio
ON tio.id = oco.n_ocorrencia
WHERE 1 = 1 ";
    if(!empty($matricula)){
        $sql_ocorrencia .= "AND oco.matricula = {$matricula} ";
    }
    if(!empty($idTurma)){
        $sql_ocorrencia .= "AND oco.id_turma = {$idTurma} ";
    }
    if(!empty($nOcorrencia)){
        $sql_ocorrencia .= "AND oco.n_ocorrencia = {$nOcorrencia} ";
    }
    if(!empty($notIn)){
        $sql_ocorrencia .= "AND oco.n_ocorrencia NOT IN (0, {$notIn}) ";
    }
    $sql_ocorrencia .= "ORDER BY oco.data DESC";
    //BUSCA OCORRENCIAS
    $sql_busca_ocorrencias = $conn->prepare($sql_ocorrencia);
    $sql_busca_ocorrencias->execute();
    return $sql_busca_ocorrencias;

}


function func_buscar_agrupamentos(){
    global $conn;
    $sql_agrupamentos = "SELECT agr.*, acc.nome as nome_professor
    FROM agrupamentos agr
    LEFT JOIN acessos_completos acc
    ON agr.cod_professor = acc.usuario
    ORDER BY agr.data_inicio DESC";
    //DROP DE AGRUPAMENTOS
    $sql_drop_agrupamentos = $conn->prepare($sql_agrupamentos);
    $sql_drop_agrupamentos->execute();
    return $sql_drop_agrupamentos;
}
?>