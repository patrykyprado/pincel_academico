
  <script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../chat/js/functions.js"></script>
<script type="text/javascript" src="../chat/js/chat.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../js/jquery.scrollTo.min.js"></script>
    <script src="../js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="../assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="../js/owl.carousel.js" ></script>
    <script src="../js/jquery.customSelect.min.js" ></script>
    <script src="../js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="../js/slidebars.min.js"></script>
<!--common script for all pages-->
	<script src="../js/common-scripts.js"></script>
   
    <script src="../js/count.js"></script>

  <script>
function Verificar()   // Verifica��o das Teclas
{
    var tecla=window.event.keyCode;
    if (tecla==38 || tecla==37 || tecla==39 || tecla==40)    //Evita feclar via Teclado atrav�s do ALT+F4
    {
		
		event.keyCode=0; 
		event.returnValue=false;
    }
}
      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
			  autoPlay:true
		 });

	  });




      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
  

  
<script>

      //step wizard

      $(function() {
          $('#default').stepy({
              backLabel: 'Anterior',
              block: true,
              nextLabel: 'Pr�ximo',
              titleClick: true,
              titleTarget: '.stepy-tab'
          });
      });
  </script>
  
      <!--script for this page-->
    <script src="js/jquery.stepy.js"></script>

    
<script language="javascript">
countUp1(<?php echo $total_online;?>);
countUp2(<?php echo $total_ativos;?>);
countUp3(<?php echo $total_novos;?>);
countUp4(<?php echo $total_visitas;?>);

function countUp1(count)
{
    var div_by = 50,
        speed = Math.round(count / div_by),
        $display = $('.usuarios_online'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
}

function countUp2(count)
{
    var div_by = 50,
        speed = Math.round(count / div_by),
        $display = $('.alunos_ativos'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
}



function countUp3(count)
{
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.novas_matriculas'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
}



function countUp4(count)
{
    var div_by = 30,
        speed = Math.round(count / div_by),
        $display = $('.total_acessos'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
}

var sbx = window.parent.Shadowbox; 
function openTopSBX(el){ 
  if(sbx){ 
    sbx.open( { content : el.href 
                   , player : 'iframe' 
                   , title : el.title||'' 
                   //could include width/height/options if desired 
                   } 
                ); 
    return false; 
  }else{ //no Shadowbox in parent window! 
    return true; 
  } 
} 

function abrir_link(url){
	location.href = url;	
}
</script>
