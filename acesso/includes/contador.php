<?php
session_start();
$expira_em  = 30; //DEFINE EM MINUTOS A EXPIRAÇÃO DO ACESSO DO USUARIO
$sessao     = session_id();
$ip         = $_SERVER['REMOTE_ADDR'];
$tempo_on   = date('Y-m-d H:i:s');
$tempo_fim  = date('Y-m-d H:i:s',mktime(date('H'),date('i') - $expira_em,date('s'),date('m'),date('d'),date('Y')));
$user_usuario = $_SESSION['MM_Username'];
$user_nivel = $_SESSION['MM_UserGroup'];
$user_empresa = $_SESSION['MM_empresa'];
$user_unidade = $_SESSION['MM_unidade'];
$user_email = $_SESSION['MM_email'];
$user_acessos = $_SESSION['MM_Acessos'];
$user_iduser = $_SESSION['MM_iduser'];
$user_nome = $_SESSION['MM_Nome'];
$user_foto = $_SESSION['MM_Foto'];
$user_senha = $_SESSION['MM_Senha'];
$ArrPATH = explode("/",$_SERVER['PHP_SELF']);
$acesso_pagina_atual = $ArrPATH[count($ArrPATH)-1];
include('conectar.php');

//EXCLUI USUARIOS QUE ESTEJAM INATIVOS NO TEMPO DEFINIDO COMO EXPIRAÇÃO
$sql_desconectar = mysql_query("SELECT * FROM usuarios_online WHERE tempo <= '$tempo_fim'");
while($dados_desconectar = mysql_fetch_array($sql_desconectar)){
	$id_desconectar = $dados_desconectar["id"];
	$usuario_desconectar = $dados_desconectar["usuario"];
	mysql_query("DELETE FROM usuarios_online WHERE id = $id_desconectar");
	mysql_query("UPDATE users SET chat_status = 1 WHERE usuario = '$usuario_desconectar'");
}


//SELECIONA USUARIO
$sql = mysql_query("SELECT id FROM usuarios_online WHERE usuario='$user_usuario'");
$total = mysql_num_rows($sql);
if($total){
  mysql_query("UPDATE usuarios_online SET tempo='$tempo_on', pagina_atual='$acesso_pagina_atual' WHERE usuario='$user_usuario'");
   mysql_query("UPDATE users SET chat_status = 2 WHERE chat_status != 0 AND id_user = $user_iduser");
}else{
  mysql_query("INSERT INTO 
usuarios_online(sessao,empresa,usuario,nivel,unidade,email,acessos,nome,senha,tempo,ip,pagina_atual)
VALUES('$sessao','$user_empresa','$user_usuario','$user_nivel','$user_unidade','$user_email','$user_acessos','$user_nome','$user_senha','$tempo_on','$ip','$acesso_pagina_atual')");
  $sql_c = mysql_query("SELECT id FROM contador");
  $total_c = mysql_num_rows($sql_c);
  //atualiza status do usuário
  mysql_query("UPDATE users SET chat_status = 2 WHERE id_user = $user_iduser");
  if($total_c){
    mysql_query("UPDATE contador SET visitas=visitas+1");
  }else{
    mysql_query("INSERT INTO contador(visitas)VALUES(1)");
  }
}
//ONLINES
$sql_o = mysql_query("SELECT id FROM usuarios_online");
$total_online = mysql_num_rows($sql_o);
//VISITAS
$sql_v = mysql_query("SELECT visitas FROM contador LIMIT 1");
$d_v = mysql_fetch_object($sql_v);
$total_visitas = $d_v->visitas;

//ALUNOS ATIVOS
$sql_ativos = mysql_query("SELECT SUM(t1.Total) as ativos FROM
(SELECT ct.id_turma, ct.cod_turma as 'Cod. Turma', ct.grupo as Grupo, ct.unidade as Unidade, ct.polo as Polo, ct.turno as Turno,
ct.nivel as Nível, ct.curso as Curso, ct.modulo as Módulo, COUNT(DISTINCT cta.matricula) as Total 
FROM ced_turma ct
INNER JOIN ced_turma_aluno cta
ON cta.id_turma = ct.id_turma
WHERE ct.unidade LIKE '%$user_unidade%' AND now() BETWEEN ct.inicio AND ct.fim
GROUP BY cta.id_turma ORDER BY ct.grupo, ct.nivel, ct.curso, ct.modulo) t1");
$d_ativos = mysql_fetch_array($sql_ativos);
$total_ativos = $d_ativos["ativos"];

//ALUNOS NOVOS MATRÍCULADOS
$sql_novos = mysql_query("SELECT count(DISTINCT codigo) as total FROM geral WHERE unidade like '%$user_unidade%' AND (Dtpaga BETWEEN SUBSTRING(NOW(),1,10) AND SUBSTRING(NOW(),1,10))");
$d_novos = mysql_fetch_array($sql_novos);
$total_novos = $d_novos["total"];


?>