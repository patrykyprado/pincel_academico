


      <!--header start-->
      <header class="header white-bg">
            <!--logo start-->
            <a href="index.php" class="logo">Pincel<span> At&ocirc;mico</span></a>
            <!--logo end-->
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
					<li>
                    <a data-placement="bottom" data-original-title="Imprimir Página Atual" data-toggle="tooltip" class="tooltips" href="javascript:window.print();"><i class="fa fa-print"></i></a>
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img class="img_perfil" alt="" src="../<?php echo $user_foto;?>">
                            <span class="username"><?php echo $user_nome?></span>
                            
                        </a>
                        
                    </li>
                   
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      
<?php
function format_tempo($inicio, $fim){
	
									$unix_data1 = strtotime($inicio);
									$unix_data2 = strtotime($fim);
									
									$nHoras   = ($unix_data2 - $unix_data1) / 3600;
									$nMinutos = (($unix_data2 - $unix_data1) % 3600) / 60;
									
									if($nHoras < 1){
										$exib_tempo = floor($nMinutos)." min." ;
									} else {
										$exib_tempo = floor($nHoras)." hora(s)." ;
									}
									if($nHoras >=24){
										$exib_tempo = floor($nHoras/24)." dia(s)";
									}
									return $exib_tempo;
}