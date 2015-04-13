      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
<?php 
$sql_menu = mysql_query("SELECT * FROM ced_menu WHERE (acessos LIKE '%$user_acessos%' OR id_pessoas LIKE '%$user_iduser%') ORDER BY ordem");
	
	while($dados_menu = mysql_fetch_array($sql_menu)){
		$menu_id =$dados_menu["id_menu"]; 
		$menu_nome =$dados_menu["menu"]; 
		$menu_submenu =$dados_menu["submenu"];
		$menu_link =$dados_menu["link"]; 
		
		if($menu_submenu == 0){
			echo "
			<li>
                      <a class=\"active\" href=\"$menu_link\">
                          <i class=\"fa fa-home\"></i>
                          <span>$menu_nome</span>
                      </a>
                  </li>
			";	
		} else {
			echo "
				<li class=\"sub-menu\">
                      <a href=\"javascript:;\" >
                          <i class=\"fa fa-laptop\"></i>
                          <span>$menu_nome</span>
                      </a>
					  <ul class=\"sub\">
			";
			
			$sql_submenu = mysql_query("SELECT * FROM ced_submenu WHERE id_menu = $menu_id AND id_submenu = 0 AND (acessos LIKE '%$user_acessos%' OR id_pessoas LIKE '%$user_iduser%') ORDER BY ordem");
 			$contar_submenu = mysql_num_rows($sql_submenu);
			while($dados_submenu = mysql_fetch_array($sql_submenu)){
				$submenu_nome = $dados_submenu["nome_submenu"];
				$submenu_link = $dados_submenu["link"];
				$submenu_id = $dados_submenu["id_sub"];
				$submenu_submenu = $dados_submenu["submenu"];
				$submenu_id_submenu = $dados_submenu["id_submenu"];
				if($submenu_submenu == 0){
					echo "
						  <li><a  href=\"$submenu_link\" target=\"_self\">$submenu_nome</a></li>	
					";	
				} else {
					echo "
						  <li class=\"sub-menu\"><a  href=\"$submenu_link\" target=\"_self\">$submenu_nome</a>
						  <ul class=\"sub\">	
					";	
					$sql_submenu2 = mysql_query("SELECT * FROM ced_submenu WHERE id_menu = $menu_id AND id_submenu = $submenu_id AND (acessos LIKE '%$user_acessos%' OR id_pessoas LIKE '%$user_iduser%') ORDER BY ordem");
 					$contar_submenu2 = mysql_num_rows($sql_submenu2);
					while($dados_submenu2 = mysql_fetch_array($sql_submenu2)){
						$submenu2_nome = $dados_submenu2["nome_submenu"];
						$submenu2_link = $dados_submenu2["link"];
						echo "
						  <li><a  href=\"$submenu2_link\" target=\"_self\">$submenu2_nome</a></li>	
						";
						$contar_submenu2 -=1;
						if($contar_submenu2 == 0){
							echo "</li></ul>";
						}
						
					}
					
				}
				
				
				
				$contar_submenu -= 1;
				if($contar_submenu == 0){
					echo "</ul>
					  </li>";	
				}
			}
			
			
		}
		
	}

?>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->