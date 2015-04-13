$(document).ready(function(){
$(function(){
	$('body').delegate('.mensagem', 'keydown', function(e){
		var campo = $(this);
		var mensagem = campo.val();
		var to = $(this).attr('id');
		
		if(e.keyCode == 13){
			if(mensagem != ''){
				
				$.post('sys/chat.php',{
					acao: 'inserir',
					mensagem: mensagem,
					para: to
				
				}, function(retorno){
					$('#jan_'+to+' ul.listar').append(retorno);
					campo.val('');
					$('#jan_'+to+' ul.listar').scrollTop(300000);
				});
				
			}
		}
		if(e.keyCode ==27){
			var id = $(this).attr('id');
			var parent = $(this).parent().parent().hide();
			$('#contatos a#'+id+'').addClass('comecar');
			var n = janelas.length;
			for(i = 0; i < n; i++){
				if(janelas[i] != undefined) {
					if(janelas[i] == id){
						delete janelas[i];
					}
				}
					
			}
		}
		
	})
});











var janelas = new Array();


	function add_janelas(id, nome){
		var html_add = '<div class="janela" id="jan_'+id+'"><div class="topo" id="'+id+'"><span>'+nome+'</span><a href="javascript:void(0);" id="fechar">X</a></div><div id="corpo_chat"><div class="mensagens"><ul class="listar"></ul></div><input type="text" name="mensagem" class="mensagem" id="'+id+'" maxlength="255"/></div></div>';
		$('#janelas').append(html_add);	
	}
	
	function abrir_janelas(x){
		$('#contatos ul li a').each(function(){
			var link = $(this);
			var id = link.attr('id');
			if(id == x){
				link.click();	
			}
			
		});
	}
	
	function verificar_msgs(){
		setInterval(function(){
			
			$.post('sys/chat.php',{
				acao:'verificar'
			}, function(x){
				if(x != ''){
					$.playSound('http://cedtecvirtual.com.br/chat_alert.ogg');
					for(i in x){
						abrir_janelas(x[i]);
					}
				} else {}
			}, 'jSON');
		},2000);	
	}
	verificar_msgs();
	$('body').on('click', '.janela', function(){
		var id = $(this).children('.topo').attr('id');
		$.post('sys/chat.php',{
			acao: 'mudar_status',
			user: id
			});
	});
		
	

	$('body').on('click', '.comecar', function(){
		var id = $(this).attr('id');
		var nome = $(this).attr('nome');
		janelas.push(id);
		for(var i = 0; i < janelas.length; i++){
			if(janelas[i] == undefined){
				janelas.splice(i,1);
				i--;
			}
		}
		
		add_janelas(id,nome);
		$(this).removeClass('comecar');
		return false;
	});
	
	$('body').on('click', 'a#fechar', function(){
		var id = $(this).parent().attr('id');
		var parent = $(this).parent().parent().hide();
		$('#contatos a#'+id+'').addClass('comecar');
		var n = janelas.length;
		for(i = 0; i < n; i++){
			if(janelas[i] != undefined) {
				if(janelas[i] == id){
					delete janelas[i];
				}
			}
				
		}
	});
	
	$('body').delegate('.topo', 'click', function(){
		var pai = $(this).parent();
		var isto = $(this);
		if(pai.children('#corpo_chat').is(':hidden')){
			isto.removeClass('fixar');
			pai.children('#corpo_chat').toggle(100);
		} else {
			isto.addClass('fixar');
			pai.children('#corpo_chat').toggle(100);
		}
	});
	
	setInterval(function(){
		$.post("sys/chat.php",{
			acao: 'atualizar',
			array: janelas
			
		},function(x){
			if(x != ''){
				for(i in x){
					$('#jan_'+i+' ul.listar').html(x[i]);
					$('#jan_'+i+' ul.listar').scrollTop(3000000);
				}
			}
		}, 'jSON');
	}, 2000);

});

(function($){

  $.extend({
    playSound: function(){
      return $("<embed src='"+arguments[0]+".mp3' hidden='true' autostart='true' loop='false' class='playSound'>" + "<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='"+arguments[0]+".ogg' /><source src='"+arguments[0]+".ogg' /></audio>").appendTo('body');
    }
  });




})(jQuery);