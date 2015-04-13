<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');

$get_turma_disc = $_GET["turma_disc"];

$sql_turma = mysql_query("SELECT ct.*
FROM ced_turma_disc ctd INNER JOIN ced_turma ct
ON ctd.id_turma = ct.id_turma
WHERE ctd.codigo = $get_turma_disc LIMIT 1");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_grupo = $dados_turma["grupo"];
$turma_curso = $dados_turma["curso"];
$turma_modulo = $dados_turma["modulo"];
$turma_unidade = trim($dados_turma["unidade"]);

if($turma_unidade == "EAD"){
	$comp_sql = " OR (grupo LIKE '%EAD%' AND curso LIKE '%GERAL%')";
} else {
	$comp_sql = "";
}

$sql_informativo_atual = mysql_query("SELECT * FROM ced_informativos WHERE (grupo LIKE '%$turma_grupo%' AND curso LIKE '%$turma_curso%' AND modulo = $turma_modulo) $comp_sql ORDER BY datahora DESC LIMIT 1");
$dados_informativo_atual = mysql_fetch_array($sql_informativo_atual);
$informativo_atual = $dados_informativo_atual["id_informativo"];

?>

<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 2000;
     }
</script>
    

<div id="central">


                      <section class="panel">
                      <div class="panel-heading">
                      <center><b>Informativos Acadêmicos</b></center>
                      </div>
                          <div class="panel-body">
<?php
$sql_informativos = mysql_query("SELECT * FROM ced_informativos WHERE (grupo LIKE '%$turma_grupo%' AND curso LIKE '%$turma_curso%' AND modulo = $turma_modulo) $comp_sql ORDER BY datahora DESC LIMIT 5");
if(mysql_num_rows($sql_informativos)==0){
	echo "<center>Não há nenhum informativo.</center>";	
} else {
	$contar_informativos = 0;
	while($dados_informativo = mysql_fetch_array($sql_informativos)){
		$informativo_id = "informativo_".$dados_informativo["id_informativo"];
		$informativo_titulo = $dados_informativo["titulo"];	
		$informativo_texto = $dados_informativo["conteudo"];
		$informativo_data = format_data_hora($dados_informativo["datahora"]);
		if($contar_informativos == 0){
			$informativo_status = "in";	
		} else {
			$informativo_status = "";
		}
		$contar_informativos +=1;
		echo "
		<div class=\"panel-heading-aviso\">
                                  <h4 class=\"panel-title\">
                                      <a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#$informativo_id\">
                                         <font color=\"#FFF\" size=\"-2\"> $informativo_titulo</font>
                                      </a><font color=\"#FFF\" size=\"-3\"> - $informativo_data</font>
                                  </h4>
                              </div>
                              <div id=\"$informativo_id\" class=\"panel-collapse collapse $informativo_status\">
                                  <div class=\"panel-body-aviso\">
                                      $informativo_texto
                                  </div>
                              </div>
		
		";
		
	}
}
?>
    </div>
                         
                      </section>

</div>

<?php

include('../includes/js_ead.php');

?>