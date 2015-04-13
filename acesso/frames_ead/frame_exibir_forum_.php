<link href="http://fonts.googleapis.com/css?family=Nunito:300" rel="stylesheet" type="text/css">
<body  style="font-family:font-family: 'Nunito', sans-serif;">
<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 35;
     }
    </script>
    
<?php 
include('../includes/conectar.php');
include('../menu/tabela_ead.php');

$turma_disc = $_GET["turma_disc"];
$cod_disc = $_GET["coddisc"];
$anograde = $_GET["anograde"];
$id_forum = $_GET["id_forum"];
$cod_ativ = $_GET["cod_ativ"];


if(isset($_GET["edicao"])){
	$_SESSION["edicao"] = $_GET["edicao"];
	$edicao = $_GET["edicao"];
} else {
	$_SESSION["edicao"] = 0;
	$edicao = 0;
}
$sql_atividade = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' AND cod_ativ = '$cod_ativ' ORDER BY ordem_ativ");
$dados_atividade = mysql_fetch_array($sql_atividade);
$conteudo_atividade = $dados_atividade["conteudo"];
$tipo_atividade = $dados_atividade["tipo"];

$sql_tipo_atividade = mysql_query("SELECT * FROM ea_tipo_ativ WHERE  cod_tipo = '$tipo_atividade'");
$dados_tipo_atividade = mysql_fetch_array($sql_tipo_atividade);

$nome_atividade = $dados_tipo_atividade["tipo"];


//PEGA NOME DO TOPICO
$sql_forum = mysql_query("SELECT * FROM ea_forum WHERE id_forum = $id_forum");
$dados_forum = mysql_fetch_array($sql_forum);
$forum_topico = $dados_forum["titulo"];
$forum_inicio = $dados_forum["data_inicio"];
$forum_fim = $dados_forum["data_fim"];
$forum_descricao = $dados_forum["descricao"];

//verifica os posts existentes para o fórum
$sql_post_forum = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $id_forum AND post_resposta = 0 ORDER BY data_modif ASC");
$total_post_forum = mysql_num_rows($sql_post_forum);

$sql_forum = mysql_query("SELECT * FROM ea_forum WHERE cod_ativ = '$cod_ativ' AND turma_disc = '$turma_disc' ORDER BY data_criacao");
$total_forum = mysql_num_rows($sql_forum);
?>
<div id="central" style="margin-bottom:100px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade." - ".$forum_topico);
?>
</font> 
<font size="-1" color="#FFFFFF">(<?php echo format_data($forum_inicio)." à ".format_data($forum_fim);?>)</font>

</td>
</tr>
<tr>
<td colspan="3" bgcolor="#D5D5D5" align="left">
<?php echo $forum_descricao;?>
</td>
</tr>

</table>

<hr>

<?php 
if($total_post_forum >=1){
	while($dados_post = mysql_fetch_array($sql_post_forum)){
		$post_matricula = trim($dados_post["matricula"]);
		$post_data =format_data_hora($dados_post["data_modif"]);
		$post_comentario =$dados_post["comentario"];
		$post_comentario_nota = format_valor($dados_post["nota_comentario"]);
		$post_id =$dados_post["id_post"];
		
		//PEGA DADOS DO USUÁRIO QUE POSTOU
		$sql_dados_usuario = mysql_query("SELECT * FROM users WHERE usuario LIKE '$post_matricula'");
		if(mysql_num_rows($sql_dados_usuario)==0){
			$sql_dados_usuario = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$post_matricula'");
		} else {
			$sql_dados_usuario = $sql_dados_usuario;
		}
		$dados_usuario = mysql_fetch_array($sql_dados_usuario);
		$usuario_nome = format_curso($dados_usuario["nome"]);
		$usuario_foto = "../".$dados_usuario["foto_perfil"];
		echo "
		<table width=\"100%\" style=\"font-family: Nunito, sans-serif;\" border=\"1px solid\" cellpadding=\"0\" cellspacing=\"0\">
<tr >	
<td width=\"15%\" bgcolor=\"#bfd2cc\" valign=\"top\">
<div style=\"padding:10px; font-family:font-family: 'Nunito', sans-serif;\" align=\"center\">$usuario_nome
<br />
<a href=\"javascript:abrir('../ficha.php?codigo=$post_matricula');\"><img src=\"$usuario_foto\" width=\"80px\" height=\"80px\"></a>
<br />
Aluno(a)  <img src=\"../icones/icone_filtrar.png\"><br>
<font size=\"-2\">$post_data</font>
<br><br><br>
Nota: 0,00
</div>
</td>
<td colspan=\"2\" bgcolor=\"#e3faf2\" valign=\"top\">
<div style=\"padding:10px\">
$post_comentario
</div></td>
</tr>
		";
		//PEGA RESPOSTAS DOS TUTORES/ADMINISTRADORES
		$sql_post_forum_adm = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $id_forum AND post_resposta LIKE '$post_id' ORDER BY data_modif ASC");
		if(mysql_num_rows($sql_post_forum_adm)>=1){
			while($dados_post_forum_adm = mysql_fetch_array($sql_post_forum_adm)){
				$post_matricula2 = $dados_post_forum_adm["matricula"];
				$post_data2 =format_data_hora($dados_post_forum_adm["data_modif"]);
				$post_comentario2 =$dados_post_forum_adm["comentario"];
				$post_comentario_nota2 = format_valor($dados_post_forum_adm["nota_comentario"]);
				$post_id2 =$dados_post_forum_adm["id_post"];
				
				//PEGA DADOS DO USUÁRIO QUE POSTOU
				$sql_dados_usuario2 = mysql_query("SELECT * FROM users WHERE usuario LIKE '$post_matricula2'");
				if(mysql_num_rows($sql_dados_usuario2)==0){
					$sql_dados_usuario2 = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$post_matricula2'");
				} else {
					$sql_dados_usuario2 = $sql_dados_usuario2;
				}
				$dados_usuario2 = mysql_fetch_array($sql_dados_usuario2);
				$usuario_nome2 = format_curso($dados_usuario2["nome"]);
				$usuario_foto2 = "../".$dados_usuario2["foto_perfil"];
				echo "
				<tr >	
<td width=\"15%\" bgcolor=\"#d9ece6\" valign=\"top\">
<div style=\"padding:10px; font-family:font-family: 'Nunito', sans-serif;\" align=\"center\">$usuario_nome2
<br />
<a href=\"javascript:abrir('../ficha.php?codigo=$post_matricula2');\"><img src=\"$usuario_foto2\" width=\"80px\" height=\"80px\"></a>
<br />
Professor / Tutor(a)<br>
<font size=\"-2\">$post_data2</font>
</div>
</td>
<td colspan=\"2\" bgcolor=\"#f5fffc\" valign=\"top\">
<div style=\"padding:10px\">
$post_comentario2
</div></td>
</tr>
				";
			}
			
		}
		echo "</table><br>";
		
	}
	
}
?>

<tr>
<td colspan="3" align="right">
<a href="javascript:abrir('responder_forum.php?id=<?php echo $id_forum;?>&user_resposta=0');">[Responder Fórum]</a>
</td>
</tr>
<tr>
<td colspan="3" align="right">
</td>
</tr>
</table>
<br /><br />
</div>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>

</body>