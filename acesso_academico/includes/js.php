
  <script type="text/javascript" src="../acesso/js/jquery.js"></script>
<!--reservado chat-->
    <script src="../acesso/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../acesso/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../acesso/js/jquery.scrollTo.min.js"></script>
    <script src="../acesso/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="../acesso/js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="../acesso/js/sparkline-chart.js"></script>
    <script src="../acesso/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="../acesso/js/owl.carousel.js" ></script>
    <script src="../acesso/js/jquery.customSelect.min.js" ></script>
    <script src="../acesso/js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="../acesso/js/slidebars.min.js"></script>
<!--common script for all pages-->
	<script src="../acesso/js/common-scripts.js"></script>
   
    <script src="../acesso/js/count.js"></script>

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
		 $("a#abrir_modal").click();

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
              nextLabel: 'Próximo',
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
<script type="text/javascript" src="../acesso/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script src="../acesso/js/form-component.js"></script>