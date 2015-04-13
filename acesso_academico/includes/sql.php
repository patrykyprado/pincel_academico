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
?>