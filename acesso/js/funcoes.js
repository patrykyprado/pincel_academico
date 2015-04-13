$(document).ready(function(){


$('body').on('dblclick', '#frequencia', function(){
		var n_aula = $(this).attr('n_aula');
		var matricula = $(this).attr('matricula');
		var tipo = $(this).attr('tipo');
		var turma_disc = $(this).attr('turma_disc');
		var data_aula = $(this).attr('data_aula');
		if(tipo == "P" || tipo == "J"){
			$("#"+matricula+"_"+n_aula).html("<b><font color=\"red\">F</font></b>");
			$(this).attr('tipo','F');
			
			//envia o post
			$.post('sys/chamada.php',{
			acao: 'chamada',
			n_aula: n_aula,
			matricula: matricula,
			turma_disc: turma_disc,
			data_aula: data_aula,
			tipo: 'F'
			});
			
		} 
		if(tipo == "F"){
			$("#"+matricula+"_"+n_aula).html("<a href=\"javascript:void(0);\"><b><font color=\"blue\">.</font></b></a>");
			$(this).attr('tipo','P');	
			
			//envia o post
			$.post('sys/chamada.php',{
			acao: 'chamada',
			n_aula: n_aula,
			matricula: matricula,
			turma_disc: turma_disc,
			data_aula: data_aula,
			tipo: 'P'
			});
		}
		
		return false;
	});
	
	
$('body').on('dblclick', '#email_atividade', function(){
		var nome_disciplina = $(this).attr('nome_disciplina');
		var matricula = $(this).attr('matricula');
		var tipo = $(this).attr('tipo');
		var turma_disc = $(this).attr('turma_disc');
		
		//envia o post
		$.post('../acesso/sys/enviar_email_atividade.php',{
			acao: 'enviar_email_atividade',
			nome_disciplina: nome_disciplina,
			matricula: matricula,
			turma_disc: turma_disc,
			id_atividade: id_atividade,
			tipo: tipo
				
		}, function(retorno){
			alert(retorno);
		});
	return false;
});
	
$('body').on('keyup', '#nota', function(){
		var max_nota = parseFloat($(this).attr('maxnota'));
		var matricula = ($(this).attr('matricula'));
		var ref_ativ = ($(this).attr('ref_ativ'));
		var turma_disc = ($(this).attr('turma_disc'));
		var grupo_ativ = ($(this).attr('grupoativ'));
		var id_etapa = ($(this).attr('id_etapa'));
		var nova_nota = parseFloat($(this).val().replace(",","."));
		if(nova_nota > max_nota){
			alert('A nota digitada deve ser menor que '+max_nota);
		} else {
			//envia o post
			$.post('sys/chamada.php',{
			acao: 'nota',
			matricula: matricula,
			turma_disc: turma_disc,
			grupo_ativ: grupo_ativ,
			ref_ativ: ref_ativ,
			nova_nota: nova_nota,
			id_etapa: id_etapa
			});
		}
		return false;
	});
	



})(jQuery);


