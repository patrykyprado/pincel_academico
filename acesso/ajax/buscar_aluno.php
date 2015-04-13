
<?php
	include('../includes/head_teste.php');
	include('../includes/conectar.php');
	include('../includes/restricao.php');
	include('../includes/funcoes.php');
	
	
	$busca = $_POST['busca'];
	
	//Verifica se variavel busca esta vazia
	if($busca == ""){
		echo "<center>Digite o nome ou matrícula do aluno desejado!</center>";
		exit;
	}
	
	//Select para fazer a busca
	$sql = mysql_query("SELECT DISTINCT ca.matricula, a.nome, a.nome_fin, ca.curso, ca.unidade, ca.polo,ac.foto_perfil, ac.foto_academica, ac.senha, ac.email
		FROM alunos a
		INNER JOIN curso_aluno ca
		ON ca.matricula = a.codigo
		INNER JOIN acessos_completos ac
		ON ac.usuario = ca.matricula
		WHERE a.nome LIKE '%$busca%' OR ca.matricula LIKE '$busca' ORDER BY a.nome") 
	or die ("Não foi possível realizar a consulta.");
	$total_rows = mysql_num_rows($sql);
	
	//Aqui verifica se veio algum resultado
	 if($total_rows == 0){
		
		echo "<center>Nenhum resultado encontrado</center>";
	 }
	 else{
		
		//Loop com resultado do select
		while ($dados = mysql_fetch_array($sql)) {
			$matricula          = $dados["matricula"];
			$aluno          = $dados["nome"];
			$financeiro          = $dados["nome_fin"];
			$curso          = format_curso($dados["curso"]);
			$unidade_aluno         = $dados["unidade"];
			$polo         = $dados["polo"];
			$foto_academica = "../".$dados["foto_academica"];
			$foto_perfil = $dados["foto_perfil"];
			if($user_nivel == 1 || $user_nivel == 333){
				$senha = $dados["senha"];
			} else {
				$senha = substr($dados["senha"],0,3)."***";
			}
			$email = $dados["email"];
		 
		 echo "
		<div class=\"col-md-6 col-sm-6\">
                  <div class=\"panel\">
                      <div class=\"panel-body\">
                          <div class=\"media\">
							  <a class=\"pull-left\" href=\"ficha.php?codigo=$matricula\" rel=\"shadowbox\">
                                  <img class=\"thumb media-object\" width=\"175px\" height=\"175px\" src=\"$foto_academica\" alt=\"\">
                              </a>
                              <div class=\"media-body\">
                                  <h4><font size=\"-1\">$aluno<br></font>
								  <font size=\"-2\">$financeiro</font>
								  </h4>
                                  <ul class=\"social-links\">
                                      <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"ficha.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Ficha do Aluno\"><i class=\"fa fa-folder\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"editar_dados.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Edição de dados\"><i class=\"fa fa-edit\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"ficha_dados.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Ficha de dados\"><i class=\"fa fa-eye\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"financeiro_aluno.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Extrato Financeiro\"><i class=\"fa fa-money\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"boletim_aluno.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Boletim Acadêmico\"><i class=\"fa fa-file-text\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"declaracao_aluno.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Declarações\"><i class=\"fa fa-archive\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"aproveitamento_aluno.php?codigo=$matricula\" rel=\"shadowbox\" data-original-title=\"Aproveitamento de Estudos\"><i class=\"fa fa-check\"></i></a></li>
									  <li><a title=\"\" data-placement=\"top\" data-toggle=\"tooltip\" class=\"tooltips\" href=\"javascript:excluir('resetar_senha.php?codigo=$matricula');\" data-original-title=\"Gerar Nova Senha\"><i class=\"fa fa-unlock-alt\"></i></a></li>
									  
                                  </ul>
								  <font size=\"-2\">
                                  <address>
                                      <strong>Matrícula: </strong> $matricula<br>
									  <strong>Senha: </strong> $senha<br>
									  <strong>E-mail: </strong> $email<br>
                                      <strong>Curso: </strong> $curso<br>
									  <strong>Unidade: </strong> $unidade_aluno<br>
									  <strong>Polo: </strong> $polo<br>
                                  </address>
								  </font>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
		
		
		
		";
		
	
		}
	 }
