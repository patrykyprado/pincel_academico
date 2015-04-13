<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
?>

  <body>

  <section id="container" >
<?php
include ('includes/topo_inside.php');
$get_id_mensagem = $_GET["id"];
$sql_ver_mensagem = mysql_query("SELECT * FROM alertas WHERE id_alert = $get_id_mensagem");
$dados_ver_mensagem = mysql_fetch_array($sql_ver_mensagem);
mysql_query("UPDATE alertas SET visto = 1 WHERE id_alert = $get_id_mensagem");
$pesq_de = $dados_ver_mensagem["de"];
//PEGA O REMETENTE DA MENSAGEM
		$sql_remetente = mysql_query("SELECT * FROM users WHERE usuario LIKE '$pesq_de'");
		if(mysql_num_rows($sql_remetente)>= 1){
			$dados_remetente = mysql_fetch_array($sql_remetente);
		} else {
			$sql_remetente = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$pesq_de'");
			$dados_remetente = mysql_fetch_array($sql_remetente);
		}
		$de_nome = $dados_remetente["nome"];
		$de_foto = $dados_remetente["foto_perfil"];
		if(strlen($de_nome)>=15){
			$de_nome = substr($de_nome,0,15)."...";
		}
if(trim($dados_ver_mensagem["titulo"])== ""){
	$titulo_msg = "{Sem Título}";
} else {
	$titulo_msg = $dados_ver_mensagem["titulo"];
}


?>

<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b><?php echo $titulo_msg?></b>
                              <br>
                              <font size="-2">
                              <b>De:</b> <?php echo $de_nome;?><br>
                              <b>Data e Hora:</b> <?php echo format_data_hora($dados_ver_mensagem["datahora"]);?><br>
                              </font>
                          </header>
                          <div class="panel-body">
                              <?php echo $dados_ver_mensagem["texto"]?>
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
