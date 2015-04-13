
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row">              
              
                  <div class="col-lg-12">
                      <section class="panel">
                      <div class="panel-heading">
                      <b>Avisos Importantes</b>
                      </div>
                          <div class="panel-body">
<?php
$sql_avisos = mysql_query("SELECT * FROM avisos WHERE nivel_user = $user_nivel OR nivel_user = 0 ORDER BY data_hora DESC LIMIT 3");
if(mysql_num_rows($sql_avisos)==0){
	echo "<center>Não há nenhum aviso.</center>";	
} else {
	$contar_avisos = 0;
	while($dados_avisos = mysql_fetch_array($sql_avisos)){
		$aviso_id = "aviso_".$dados_avisos["id_aviso"];
		$aviso_titulo = $dados_avisos["titulo_aviso"];	
		$aviso_texto = $dados_avisos["aviso"];
		$aviso_data = format_data_hora($dados_avisos["data_hora"]);
		if($contar_avisos == 0){
			$aviso_status = "in";	
		} else {
			$aviso_status = "";
		}
		$contar_avisos +=1;
		echo "
		<div class=\"panel-heading-aviso\">
                                  <h4 class=\"panel-title\">
                                      <a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#$aviso_id\">
                                          $aviso_titulo
                                      </a><font color=\"#FFF\" size=\"-3\"> - $aviso_data</font>
                                  </h4>
                              </div>
                              <div id=\"$aviso_id\" class=\"panel-collapse collapse $aviso_status\">
                                  <div class=\"panel-body-aviso\">
                                      $aviso_texto
                                  </div>
                              </div>
		
		";
		
	}
}
?>
    </div>
                         
                      </section>
                  </div>

              </div>

                      </section>
                      <!--weather statement end-->
                  </div>
              </div>

          </section>
      </section>