<script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
    

    
	    <script type="text/javascript">
		$(function(){
			$('#modal').change(function(){
				if( $(this).val() ) {
					$('#unidade').hide();
					$('#curso2').html('<option value="selecione">–Selecione o Curso–</option>');
					$('#parcela').html('<option value="selecione">–Forma de Pagamento–</option>');
					$('#curso').val('');
					$('#curso3').val('');
					$('#curso2').val('');
					$('.carregando').show();
					$.getJSON('unidade.ajax.php?search=',{modal: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="selecione">–Selecione o Polo–</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].sigla + '">' + j[i].unidade + '</option>';
						}	
						$('#unidade').html(options).show();
						$('.carregando').hide();
						if( $('#fiadorexib').val()==1 ) {
							document.form1.diavenc.style.visibility = "none";
							$('#diavenc').hide();
							$('#msg').hide();
							$('#msg2').show();
							$('#fiador').show();
							$('#sem_fiador').hide();
							$('#nome_fia').show();
							$('#nasc_fia').show();
							$('#nacio_fia').show();
							$('#cpf_fia').show();
							$('#rg_fia').show();
							$('#cep_fia').show();
							$('#rua_fia').show();
							$('#cidade_fia').show();
							$('#uf_fia').show();
							$('#num_fia').show();
							$('#bairro_fia').show();
							$('#comp_fia').show();
							$('#tel_fia').show();
							$('#email_fia').show();
							$('#nome_conj').show();
							$('#nasc_conj').show();
							$('#cpf_conj').show();
							$('#rg_conj').show();
							$('#nacio_conj').show();
							}
						if( $('#fiadorexib').val()==0 ) {
							document.form1.diavenc.style.visibility = "visible";
							$('#nome_fia').hide();
							$('#nasc_fia').hide();
							$('#nacio_fia').hide();
							$('#cpf_fia').hide();
							$('#rg_fia').hide();
							$('#cep_fia').hide();
							$('#rua_fia').hide();
							$('#cidade_fia').hide();
							$('#uf_fia').hide();
							$('#num_fia').hide();
							$('#bairro_fia').hide();
							$('#comp_fia').hide();
							$('#tel_fia').hide();
							$('#email_fia').hide();
							$('#nome_conj').hide();
							$('#nasc_conj').hide();
							$('#cpf_conj').hide();
							$('#rg_conj').hide();
							$('#nacio_conj').hide();
							$('#msg').show();
							$('#msg2').hide();
							$('#fiador').hide();
							$('#sem_fiador').show();
							
							}
							
					});
				} else {
					$('#unidade').html('<option value="selecione">– Escolha o Polo –</option>');
				}
			});
		});
		</script>

        <script type="text/javascript">
		$(function(){
			$('#uf').change(function(){
				if( $(this).val() ) {
					$('#cidade').hide();
					$.getJSON('cidade.ajax.php?search=',{uf: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option selected value="selecione">– Escolha a Cidade –</option>';
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cidade + '">'+ j[i].cidade + '</option>';
						}	
						$('#cidade').html(options).show();
						$('.carregando').hide();

					});
				} else {
					$('#cidade').html('<option value="selecione">– Escolha a Cidade –</option>');
				}
			});
		});
		</script>

        <script type="text/javascript">
		$(function(){
			$('#unidade').change(function(){
				if( $(this).val() ) {
					$('#curso2').hide();
					$('#parcela').html('<option value="selecione">–Forma de Pagamento–</option>');
					$('.carregando').show();
					$('#curso').val('');
					$('#curso3').val('');
					$('#curso2').val('');
					$.getJSON('curso.ajax.php?search=',{unidade: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option selected value="selecione">– Escolha o Curso –</option>';
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cod_curso + '">'+ j[i].tipo + ': ' + j[i].curso2 + '</option>';
						}	
						$('#curso2').html(options).show();
						$('.carregando').hide();

					});
				} else {
					$('#curso2').html('<option value="selecione">– Escolha o Curso –</option>');
				}
			});
		});
		</script>
        <script type="text/javascript">
		$(function(){
			$('#curso3').focus(function(){
				if( $(this).val() ) {
					$('#parcela').hide();
					$('.carregando').show();
					$.getJSON('parcela.ajax.php?search=',{curso3: $(this).val(), ajax: 'true'}, function(j){
						var options = '';
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].pagamento + '">'+ j[i].pagamentoexib + '</option>';
						}	
						$('#parcela').html(options).show();
						$('.carregando').hide();
						if( $('#fiadorexib').val()==1 ) {
							document.form1.diavenc.style.visibility = "none";
							$('#diavenc').hide();
							$('#msg').hide();
							$('#msg2').show();
							$('#fiador').show();
							$('#sem_fiador').hide();
							$('#nome_fia').show();
							$('#nasc_fia').show();
							$('#nacio_fia').show();
							$('#cpf_fia').show();
							$('#rg_fia').show();
							$('#cep_fia').show();
							$('#rua_fia').show();
							$('#cidade_fia').show();
							$('#uf_fia').show();
							$('#num_fia').show();
							$('#bairro_fia').show();
							$('#comp_fia').show();
							$('#tel_fia').show();
							$('#email_fia').show();
							$('#nome_conj').show();
							$('#nasc_conj').show();
							$('#cpf_conj').show();
							$('#rg_conj').show();
							$('#nacio_conj').show();
							}
						if( $('#fiadorexib').val()==0 ) {
							document.form1.diavenc.style.visibility = "visible";
							$('#nome_fia').hide();
							$('#nasc_fia').hide();
							$('#nacio_fia').hide();
							$('#cpf_fia').hide();
							$('#rg_fia').hide();
							$('#cep_fia').hide();
							$('#rua_fia').hide();
							$('#cidade_fia').hide();
							$('#uf_fia').hide();
							$('#num_fia').hide();
							$('#bairro_fia').hide();
							$('#comp_fia').hide();
							$('#tel_fia').hide();
							$('#email_fia').hide();
							$('#nome_conj').hide();
							$('#nasc_conj').hide();
							$('#cpf_conj').hide();
							$('#rg_conj').hide();
							$('#nacio_conj').hide();
							$('#msg').show();
							$('#msg2').hide();
							$('#fiador').hide();
							$('#sem_fiador').show();
							
							}

					});
				} else {
					$('#parcela').html('<option value="selecione">– Forma de Pagamento –</option>');
				}
			});
		});
		</script>
        
        
        
        <script src="http://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="js/gmaps.js" type="text/javascript"></script>
        <script src="js/cep.js" type="text/javascript"></script>
        <link href="css/main.css" rel="stylesheet" />
        <link href="css/960.css" rel="stylesheet" />
        <link href="css/bootstrap.css" rel="stylesheet" />

        <script>
            $(function(){
                wscep({map: 'map1',auto:true});
                wsmap('08615-000','555','map2');
            })
        </script>

	
	<script type="text/javascript" src="java/jquery.min.js"></script>
	<script type="text/javascript" src="java/jquery.multipage.js"></script>
	<link rel="stylesheet" href="css/jquery.multipage.css" />
	<script type="text/javascript" src="java/jquery.tagsinput.js"></script>
	<link rel="stylesheet" href="css/jquery.tagsinput.css" />			     <script type="text/javascript">
	
	
		$(window).ready(function() {
            $('#multipage').multipage();
		});

		function generateTabs(tabs) { 

			html = '';
			for (var i in tabs) { 
				tab = tabs[i];
				html = html + '<li class="multipage_tab"><a href="#" onclick="return $(\'#multipage\').gotopage(' + tab.number + ');">' + tab.title + '</a></li>';				
			}
			$('<ul class="multipage_tabs" id="multipage_tabs">'+html+'<div class="clearer"></div></ul>').insertBefore('#multipage');
		}
		function setActiveTab(selector,page) { 
			$('#multipage_tabs li').each(function(index){ 
				if ((index+1)==page) { 
					$(this).addClass('active');
				} else {
					$(this).removeClass('active');
				}
			});			
		}

		function transition(from,to) {
			$(from).fadeOut('fast',function(){$(to).fadeIn('fast');});

		}
		function textpages(obj,page,pages) { 
			$(obj).html(page + ' of ' + pages);
		}

	</script>
<div class="topmatricula" align="center">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC" ><strong>Para se matr&iacute;cular no CEDTEC:</strong></td></tr>
	  <tr style="font-size:11px;">
	    <td width="50%" >
          <p><b>S&atilde;o poucos passos!</b></p>
          <p><b>1</b> - Comece preenchendo todos os campos abaixo;</p>
          <p><b>2</b> - Confira as informa&ccedil;&otilde;es e clique no bot&atilde;o&nbsp;<strong>Pr&oacute;ximo Passo.</strong>;</p>
          <p><b>3</b>- Ao final, imprima seu Contrato e Boleto;</p>
        </td>
        <td valign="top"><p><b>4</b> - Ap&oacute;s o pagamento do Boleto, deve-se enviar o Contrato Assinado (Presencial ou via Sedex) para o Polo selecionado.</p>
          <p><i><b>Envio via sedex:</b> C&oacute;pias autenticadas e contrato com todas as p&aacute;ginas rubricadas e assinaturas na ultima p&aacute;gina com firma reconhecida.</i></p><br />
          <strong>OBS:</strong> Se preferir, v&aacute; at&eacute; uma unidade CEDTEC e fa&ccedil;a sua matr&iacute;cula na secretaria da escola.</td>
        </tr>
        <tr>
        </table>
		</div>
	<form id="multipage" name="form1" action="validar.php">
		<fieldset id="page_one">
            <legend>1&ordm; Passo</legend><div style="background-color:#066; color:#FFF; text-align:center; font-weight:bold;">Escolha do curso</div>
			<table>
            <tr>
            <td width="20px">1</td>
            <td>
<div class="input-prepend">
                                <span class="add-on">Modalidade de Ensino</span>
                                <?php
			$con = mysql_connect( '177.70.22.184', 'underweb_pincel', 'CEDTEC2014Pincel' ) ;
			mysql_select_db( 'underweb_pincel', $con );
		?>
		  <select name="modal" id="modal" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <option value="selecione">- Modalidade de Ensino -</option>
		    <?php
				$sql = "SELECT *
						FROM modalidade
						ORDER BY modalidade";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['id_mod'].'">'.($row['modalidade']).'</option>';
				}
			?>
                            </select></div></td>
                            <td style="font-size:9px"> Presencial ou Ensino a Dist&acirc;ncia (EAD)</td></tr>
                            
   <tr><td width="20px">2</td><td><div class="input-prepend">
                                <span class="add-on">Polo / Unidade</span>
                                <select name="unidade" id="unidade" style="border-style: ridge; border-width: 1px" size="1" tabindex="6" onKeyPress="return arrumaEnter(this, event)">
	      <option value="selecione"selected="selected" >-Selecione o Polo-</option>

        </select>
                            </div></td><td style="font-size:9px"> Em qual unidade voc&ecirc; quer estudar?
                            </td></tr>
                            </table>
                            <table><tr><td width="20px" valign="top" style="padding-top:8px;">3</td><td>
  <div class="input-prepend">
                                <span class="add-on">Escolha o Curso</span>
                                <input type="text" name="curso" id="curso" readonly onclick="javascript:abrir('pesquisar_cursos.php')" onKeyPress="return arrumaEnter(this, event)" style="width:500px" placeholder="Clique aqui e escolha o seu curso" /><input type="text" name="curso3" id="curso3" style="width:0px" readonly onclick="javascript:abrir('pesquisar_cursos.php')"  onKeyPress="return arrumaEnter(this, event)"  />
                                <input type="hidden" name="curso2" id="curso2"  onKeyPress="return arrumaEnter(this, event)"  />
                                <input type="hidden" name="fiadorexib" id="fiadorexib"  onKeyPress="return arrumaEnter(this, event)"  />
                                
                            </div>
                            </td></tr>
                            <tr><td width="20px" valign="top" style="padding-top:8px;">4</td><td>
  <div class="input-prepend">
                                <span class="add-on">Forma de Pagamento</span>
                                <select name="parcela" id="parcela" onKeyPress="return arrumaEnter(this, event)">
                                <option value="selecione" selected="selected">-Forma de Pagamento-</option></select>
                                <select name="diavenc" style="visibility:hidden" size="1" id="diavenc" onKeyPress="return arrumaEnter(this, event)">
          <option value="10">MELHOR DIA DE VENCIMENTO</option>
	      <option value="10">10</option>
	      <option value="25">25</option>
          </select>
                                
                            </div>
                            </td></tr>
                            </table>
                            <div align="center" style="color:#C00;">Consulte na secretaria para verificar descontos de conv&ecirc;nios e datas de vencimento.</div>
            
            	
		</fieldset>
		<fieldset id="page_two">
			<legend>2&ordm; Passo</legend><div style="background-color:#066; color:#FFF; text-align:center; font-weight:bold;">Dados do Aluno</div>
  <table align="center" width="100%">
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input name="nome" type="text" id="nome" placeholder="Nome do Aluno" required style="text-transform:uppercase; height:30px" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">E-mail</span>
                                <input name="email" type="text" id="email" placeholder="E-mail do aluno" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">N&ordm; de Identidade</span>
                                <input name="rg" type="text" id="rg" placeholder="Identidade do aluno" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf" type="text" id="cpf" placeholder="CPF do aluno" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nascimento" type="text" id="nascimento" placeholder="Nascimento do aluno" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Estado Civil</span>
                                <select name="civil" size="1" id="civil" onKeyPress="return arrumaEnter(this, event)">
	      <option>Selecione...</option>
	      <option value="Casado(a)">Casado</option>
	      <option value="Divorciado(a)">Divorciado</option>
	      <option value="Solteiro(a)">Solteiro</option>
          <option value="Viúvo(a)">Vi&uacute;vo(a)</option></select>
	      
                            </div></td>
  </tr>
  <tr>
  <td><div class="input-prepend">
                                <span class="add-on">Telefone Residencial</span>
                                <input id="telefone" name="telefone" type="text" placeholder="Informe o Telefone" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
  </td>
  <td><div class="input-prepend">
                                <span class="add-on">Celular</span>
                                <input id="celular" name="celular" type="text" placeholder="Informe o Nº do seu celular" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
 <tr>
   <td><div class="input-prepend">
                                <span class="add-on">Nacionalidade</span>
                                <input name="nacionalidade" type="text" id="nacionalidade" placeholder="Nacionalidade do Aluno" style="text-transform:uppercase" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
   <td><div class="input-prepend">
                                <span class="add-on">Como ficou sabendo?</span>
                                <select name="noticia" id="noticia" class="textBox" onKeyPress="return arrumaEnter(this, event)">
	      <option value="Facebook">Facebook</option>
	      <option value="Site do CEDTEC">Site do CEDTEC</option>
	      <option value="Email">E-mail</option>
	      <option value="Outdoor">Outdoor</option>
          <option value="Panfletos">Panfletos</option>
	      <option value="Ve&iacute;culos de Som">Ve&iacute;culos de Som</option>
	      <option value="TV Gazeta">TV Gazeta</option>
          <option value="TV Tribuna">TV Tribuna</option>
          <option value="TV Vitória">TV Vit&oacute;ria</option>
          <option value="TV Band">TV BAND</option>
          <option value="Tribuna FM">Tribuna FM</option>
          <option value="Litoral">Litoral FM</option>
	      <option value="CBN">CBN</option>
	      <option value="Rede Sim">Rede Sim</option>
          <option value="Radio Praia do Canto">Radio Praia do Canto</option>
          <option value="Super FM">Super FM</option>
          <option value="Jovem Pan">Jovem Pan</option>
	      <option value="Outras Radios">Outras Radios</option></select>
                            </div></td>
  </tr>
  <tr>
  <td><div class="input-prepend">
                                <span class="add-on">Nome do Pai</span>
                                <input name="pai" type="text" required id="pai" placeholder="Nome do Pai" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
  </td>
  <td><div class="input-prepend">
                                <span class="add-on">Nome da M&atilde;e</span>
                                <input name="mae" type="text" id="mae" placeholder="Nome da Mãe" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
  <td>
<div class="input-prepend">
                                <span class="add-on">Aluno CEDTEC?</span>
                                <select name="aluno" id="aluno" class="textBox" onKeyPress="return arrumaEnter(this, event)">
	      <option value="Sim">Sim</option>
	      <option value="Nao" selected="selected" >Nao</option>
        </select> 
                            </div>
  </td>
  <td>
  <div class="input-prepend">
                                <span class="add-on">Matr&iacute;cula CEDTEC</span>
                                <input name="se_aluno" type="text" id="se_aluno" placeholder="Somente aluno / ex-aluno" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
  </td>
  </tr>
   
<tr>
	<td><div class="input-prepend">
                                <span class="add-on">Forma&ccedil;&atilde;o</span>
                               <select name="formacao" id="formacao" style="border-style: ridge; border-width: 1px" size="1" tabindex="6" onKeyPress="return arrumaEnter(this, event)">
	      <option selected="selected">Selecione...</option>
	      <option value="Cursando 3? ano Ensino M?dio">Cursando 3&ordm; ano Ensino M&eacute;dio</option>
	      <option value="2? Grau Completo">2&ordm; Grau Completo</option>
          <option value="Ensino Fundamental Completo">Ensino Fundamental Completo</option>
	      <option value="2? Grau Completo - T?cnic">2&ordm; Grau Completo - T&eacute;cnic</option>
	      <option value="Graduado">Graduado</option>
	      <option value="P?s-graduado e ou Doutorado">P&oacute;s-graduado e ou Doutorado</option>
        </select>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Escola</span>
                                <input name="escola" type="text" id="escola" placeholder="Ultima escola" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
  <tr> 
  <td><div class="input-prepend">
                                <span class="add-on">Profiss&atilde;o</span>
                                <input name="cargo" type="text" id="cargo" placeholder="Profissão do aluno" style="text-transform:uppercase"onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  <td><div class="input-prepend">
                                <span class="add-on">Empresa</span>
                                <input name="empresa" type="text" id="empresa" placeholder="Empresa em que trabalha" style="text-transform:uppercase; width:300px;" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
  <td>
  <div class="input-prepend">
                                <span class="add-on">Renda</span>
                                <input name="renda" type="text" id="renda" placeholder="Renda Familiar" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
  </td>
  </tr>
</table>

            
		</fieldset>
		<fieldset id="page_three">
			<legend>3&ordm; Passo</legend><div style="background-color:#066; color:#FFF; text-align:center; font-weight:bold;">Endere&ccedil;o do Aluno</div>
<table>

  <tr>
    <td height="28"><div class="input-prepend cep-label">
                                <span class="add-on">CEP</span>
                                <input id="cep" name="cep" type="text" maxlength="9" placeholder="Informe o CEP" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Estado</span>
                                <select name="uf" id="uf" style="width:auto;" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <?php
				$sql = "SELECT DISTINCT uf
						FROM cod_municipios
						ORDER BY uf";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					if(trim($row['uf']) == "ES"){
						echo '<option selected="selected" value="'.trim($row['uf']).'">'.$row['uf'].'</option>';
					} else {
						echo '<option value="'.trim($row['uf']).'">'.$row['uf'].'</option>';
					}
				}
			?>
                            </select>
                            </div></td>
    <td></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Cidade</span>
                                <select name="cidade" id="cidade" style="width:auto;" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    				<option value="">- Selecione a Cidade -</option>
                            <?php
				$sql = "SELECT *
						FROM cod_municipios
						WHERE uf LIKE 'ES'";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.(strtoupper(trim($row['nome']))).'">'.(strtoupper(trim($row['nome']))).'</option>';
				}
			?>
                            </select>
                            </div></td>
    <td></td>
  </tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Bairro</span>
                                <input id="bairro" name="bairro" type="text" placeholder="Informe o Bairro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td></td>
</tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Rua</span>
                                <input id="rua" name="rua" type="text" placeholder="Nome da Rua / Logradouro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td></td>
</tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">N&ordm;</span>
                                <input id="num" name="num" type="text" placeholder="Número" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td></td>
</tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Complemento</span>
                                <input id="complemento" name="complemento" type="text" placeholder="Complemento" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
                            </table>
                            <div class="grid_7 map" id="map1" style="float:right"></div>


	
		</fieldset>
        <fieldset id="page_four">
        <legend>4&ordm; Passo</legend><div style="background-color:#066; color:#FFF; text-align:center; font-weight:bold;">Respons&aacute;vel Financeiro (Contratante)</div>
<table>
<tr>
<td colspan="2"><div align="center"><strong><br>* O Aluno somente poder&aacute; figurar como contratante se for maior de 18 anos de idade ou emancipado.
  
  Mesmo o contratante sendo o aluno os campos abaixo s&atilde;o obrigat&oacute;rios.
</strong></div><br></td>
</tr>  
<tr>
<td colspan="2"><strong>Aluno contratante:</strong> Clique aqui para repetir os dados do aluno:
                                <input type="checkbox" name="aluno_resp" onclick="enable_text(this.checked)" value="sim" >
</td>

</tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input name="nome_fin" type="text" id="nome2" placeholder="Nome Completo do Responsável Financeiro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nasc_fin" type="text" id="nasc_fin" placeholder="Data de Nascimento" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf_fin" type="text" id="cpf_fin" placeholder="CPF do Responsável Financeiro" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input name="rg_fin" type="text" id="rg_fin" placeholder="RG do Responsável Financeiro" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  
  
  
  
  <tr>
    <td height="28"><div class="input-prepend">
                                <span class="add-on">CEP</span>
                                <input id="cep_fin" name="cep_fin" type="text" maxlength="9" placeholder="Informe o CEP" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Rua</span>
                                <input id="rua_fin" name="rua_fin" type="text" placeholder="Nome da Rua / Logradouro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Cidade</span>
                                <input id="cidade_fin" name="cidade_fin" type="text" placeholder="Informe a Cidade" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td><div class="input-prepend">
                                <span class="add-on">Estado</span>
                                <input id="uf_fin" name="uf_fin" type="text" placeholder="Informe o estado" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">N&ordm;</span>
                                <input id="num_fin" name="num_fin" type="text" placeholder="Número" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>

<td><div class="input-prepend">
                                <span class="add-on">Bairro</span>
                                <input id="bairro_fin" name="bairro_fin" type="text" placeholder="Informe o Bairro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
  
  
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Complemento</span>
                                <input id="comp_fin" name="comp_fin" type="text" placeholder="Complemento" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>

<td><div class="input-prepend">
                                <span class="add-on">Nacionalidade</span>
                                <input id="nacio_fin" name="nacio_fin" type="text" placeholder="Nacionalidade" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
  
  
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Telefone</span>
                                <input id="tel_fin" name="tel_fin" type="text" placeholder="Telefone do Responsável Financeiro" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td><div class="input-prepend">
                                <span class="add-on">E-mail</span>
                                <input id="email_fin" name="email_fin" type="text" placeholder="E-mail do Responsável Financeiro" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
                            
</tr>
<tr>
    <td><div class="input-prepend">
                                <span class="add-on">Estado Civil</span>
                                <select name="civil_fin" size="1" id="civil" onKeyPress="return arrumaEnter(this, event)">
	      <option value="Solteiro(a)">Selecione...</option>
	      <option value="Casado(a)">Casado(a)</option>
	      <option value="Divorciado(a)">Divorciado(a)</option>
	      <option value="Solteiro(a)">Solteiro(a)</option>
          <option value="Viúvo(a)">Vi&uacute;vo(a)</option></select>
	      
                            </div></td>
    <td></td>
  </tr>

</table>
            
            
            		
		</fieldset>
       
        <fieldset id="page_five">
        <legend>5&ordm; Passo</legend> <label id="sem_fiador" name="sem_fiador"><div style="background-color:#066; color:#FFF; text-align:center; font-weight:bold; vertical-align:middle; height:60px; font-size:24px;"><br />Clique em  <b>CONFIRMAR</b> para concluir sua inscri&ccedil;&atilde;o</div></label><label id="fiador" name="fiador"> <div style="background-color:#066; color:#FFF; text-align:center; font-weight:bold;">Dados do Fiador</div>
<table>
<tr>
<td colspan="2"><div align="center"><label id="msg2" name="msg2" style="font-size:12px; color:
#C00"><strong><br>
  * O Fiador n&atilde;o deve possuir restri&ccedil;&atilde;o de CPF *<br />
  * O Aluno n&atilde;o pode se caracterizar como Fiador* 
</strong><br /></label>
<label name="msg" id="msg" style="font-size:12px; color:
#C00"><strong>Voc&ecirc; selecionou a modalidade Ensino a Dist&acirc;ncia. Nessa modalidade n&atilde;o &eacute; necess&aacute;ria a apresenta&ccedil;&atilde;o de fiador. Confirme sua inscri&ccedil;&atilde;o clicando no bot&atilde;o <font color="#000000">Confirmar</font></strong></label><br /></div></td>
</tr>
 
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input name="nome_fia" type="text" id="nome_fia" placeholder="Nome Completo do Fiador" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nasc_fia" type="text" id="nasc_fia" placeholder="Data de Nascimento" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf_fia" type="text" id="cpf_fia" placeholder="CPF do Fiador" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input name="rg_fia" type="text" id="rg_fia" placeholder="RG do Fiador" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  
  <tr>
    <td height="28"><div class="input-prepend">
                                <span class="add-on">CEP</span>
                                <input id="cep_fia" name="cep_fia" type="text" maxlength="9" placeholder="Informe o CEP" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Rua</span>
                                <input id="rua_fia" name="rua_fia" type="text" placeholder="Nome da Rua / Logradouro" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Cidade</span>
                                <input id="cidade_fia" name="cidade_fia" type="text" placeholder="Informe a Cidade" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td><div class="input-prepend">
                                <span class="add-on">Estado</span>
                                <input id="uf_fia" name="uf_fia" type="text" placeholder="Informe o seu estado" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">N&ordm;</span>
                                <input id="num_fia" name="num_fia" type="text" placeholder="Número" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>

<td><div class="input-prepend">
                                <span class="add-on">Bairro</span>
                                <input id="bairro_fia" name="bairro_fia" type="text" placeholder="Informe o Bairro" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
  
  
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Complemento</span>
                                <input id="comp_fia" name="comp_fia" type="text" placeholder="Complemento" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>

<td><div class="input-prepend">
                                <span class="add-on">Nacionalidade</span>
                                <input id="nacio_fia" name="nacio_fia" type="text" placeholder="Nacionalidade" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
  
  
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Telefone</span>
                                <input id="tel_fia" name="tel_fia" type="text" placeholder="Telefone do Fiador" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td><div class="input-prepend">
                                <span class="add-on">E-mail</span>
                                <input id="email_fia" name="email_fia" type="text" placeholder="E-mail do Fiador" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
                            
</tr>
<tr>
<td colspan="2"><hr /></td>
<tr>
<td colspan="2" align="center">Os dados abaixo somente s&atilde;o necess&aacute;rios caso o Fiador tenha C&ocirc;njuge.</td></tr>
</tr>
<tr>
    <td><div class="input-prepend">
                                <span class="add-on">C&ocirc;njuge</span>
                                <input name="nome_conj" type="text" id="nome_conj" placeholder="Cônjuge do Fiador" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nasc_conj" type="text" id="nasc_conj" placeholder="Data de Nascimento" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf_conj" type="text" id="cpf_conj" placeholder="CPF do Cônjuge" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input name="rg_conj" type="text" id="rg_conj" placeholder="RG do Cônjuge" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
   <td><div class="input-prepend">
                                <span class="add-on">Nacionalidade</span>
                                <input name="nacio_conj" type="text" id="nacio_conj" placeholder="Nacionalidade do Cônjuge" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
   <td></td>
  </tr></table></label>
            
            
            		
		</fieldset>

		<input type="submit" value="Confirmar" />
	</form>
    
<script language="JavaScript">
<!--

function enable_text(status)
{
if(status!=''){	
document.form1.nome_fin.value = document.form1.nome.value;
document.form1.nome_fin.disabled = status;
document.form1.nasc_fin.value = document.form1.nascimento.value;
document.form1.nasc_fin.disabled = status;
document.form1.cpf_fin.value = document.form1.cpf.value;
document.form1.cpf_fin.disabled = status;
document.form1.rg_fin.value = document.form1.rg.value;
document.form1.rg_fin.disabled = status;
document.form1.cep_fin.value = document.form1.cep.value;
document.form1.cep_fin.disabled = status;
document.form1.rua_fin.value = document.form1.rua.value;
document.form1.rua_fin.disabled = status;
document.form1.cidade_fin.value = document.form1.cidade.value;
document.form1.cidade_fin.disabled = status;
document.form1.uf_fin.value = document.form1.uf.value;
document.form1.uf_fin.disabled = status;
document.form1.num_fin.value = document.form1.num.value;
document.form1.num_fin.disabled = status;
document.form1.bairro_fin.value = document.form1.bairro.value;
document.form1.bairro_fin.disabled = status;
document.form1.nacio_fin.value = document.form1.nacionalidade.value;
document.form1.nacio_fin.disabled = status;
document.form1.comp_fin.value = document.form1.complemento.value;
document.form1.comp_fin.disabled = status;
document.form1.tel_fin.value = document.form1.telefone.value;
document.form1.tel_fin.disabled = status;
document.form1.email_fin.value = document.form1.email.value;
document.form1.email_fin.disabled = status;
document.form1.civil_fin.value = document.form1.civil.value;
document.form1.civil_fin.disabled = status;
} else {
document.form1.nome_fin.value = '';
document.form1.nome_fin.disabled = '';
document.form1.nasc_fin.value = '';
document.form1.nasc_fin.disabled = '';
document.form1.cpf_fin.value = '';
document.form1.cpf_fin.disabled = '';
document.form1.cep_fin.value = '';
document.form1.cep_fin.disabled = '';
document.form1.rua_fin.value = '';
document.form1.rua_fin.disabled = '';
document.form1.uf_fin.value = '';
document.form1.uf_fin.disabled = '';
document.form1.num_fin.value = '';
document.form1.num_fin.disabled = '';
document.form1.bairro_fin.value = '';
document.form1.bairro_fin.disabled = '';
document.form1.comp_fin.value = '';
document.form1.comp_fin.disabled = '';
document.form1.nacio_fin.value = '';
document.form1.nacio_fin.disabled = '';
document.form1.tel_fin.value = '';
document.form1.tel_fin.disabled = '';
document.form1.email_fin.value = '';
document.form1.email_fin.disabled = '';
document.form1.cidade_fin.value = '';
document.form1.cidade_fin.disabled = '';
document.form1.rg_fin.value = '';
document.form1.rg_fin.disabled = '';
document.form1.comp_fin.value = '';
document.form1.comp_fin.disabled = '';
document.form1.nacio_fin.value = '';
document.form1.nacio_fin.disabled = '';
document.form1.tel_fin.value = '';
document.form1.tel_fin.disabled = '';
document.form1.email_fin.value = '';
document.form1.email_fin.disabled = '';
document.form1.civil_fin.value = '';
document.form1.civil_fin.disabled = '';




}}


//-->
</script>
    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
      var unidade = document.form1.unidade.value;
      var left = 0;
      var top = 0;
     
      window.open(URL+'?unidade='+unidade,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>