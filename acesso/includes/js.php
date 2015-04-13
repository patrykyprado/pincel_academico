
  <script type="text/javascript" src="js/jquery.js"></script>
  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="js/functions.js"></script>
   <script type="text/javascript" src="chat/js/chat.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js" ></script>
    <script src="js/jquery.customSelect.min.js" ></script>
    <script src="js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="js/slidebars.min.js"></script>
<!--common script for all pages-->
	<script src="js/common-scripts.js"></script>
   
    <script src="js/count.js"></script>

  <script>

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
  
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
function pesquisar_titulo(){
var data;
var url_final;
do {
    data = prompt ("Digite o n�mero do t�tulo:");

} while(data == "");
if(confirm ("DESEJA VISUALIZAR O T�TULO N�:  "+data+"?"))
{
	url_final = "editar.php?id="+data;
window.parent.Shadowbox.open( { content : url_final 
                   , player : 'iframe' 
                   , title : 'T�tulo' 
                   //could include width/height/options if desired 
                   } 
                );
	
	
}
else
{
exit;
}

}
</SCRIPT> 
  
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

<?php
include('includes/contador.php');
?>
    
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


</script>
<script language="javascript">
<!--
function excluir_tentativa(matricula){
if(confirm (' ATENCAO: AO APAGAR A TENTATIVA SERA EXCLUIDA PERMANENTEMENTE O REGISTRO DA TENTATIVA DO ALUNO, DESEJA CONFIRMAR? '))
{
location.href="excluir_tentativa.php"+matricula;
}
else
{
return false;
}
}
//-->

</script>

<!-- Bloqueador de Tecla CTRL -->
<script language='JavaScript'>
function Verificar_ctrl()
{
var ctrl=window.event.ctrlKey;
var tecla=window.event.keyCode;
var mouse = window.event.button;
if (ctrl && tecla==67) {alert("Voc� n�o pode copiar texto dentro desse f�rum!"); event.keyCode=0; event.returnValue=false;}
if (mouse==2) {alert("Voc� n�o pode copiar texto dentro desse f�rum!"); event.keyCode=0; event.returnValue=false;}

}
    

</script>


<script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
