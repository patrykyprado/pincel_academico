<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
require_once('../acesso/includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
require_once('../acesso/includes/conectar_pdo.php');
require_once('../acesso/includes/sql.php');

?>


<body>

<section id="container" >


    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <b>Bem-vindo ao Portal Acadêmico Pincel Atômico</b>
                        </header>
                        <div class="panel-body">
<?php

if($user_nivel == 90){
    if(isset($_GET["id_turma"])){
        $get_id_turma = $_GET["id_turma"];
    } else {
        $get_id_turma = "";
    }
?>
<table width="100%" border="1" style="border: solid 0.5px;">
    <tr>
        <td colspan="10" align="center" bgcolor="#d3d3d3"><b>Resumo Acadêmico</b></td>
    </tr>
    <tr>
        <td align="center"><b>--</b></td>
        <td align="center" bgcolor="#d3d3d3"><b>Disciplina</b></td>
    </tr>
</table>

<?php
}
?>
                        </div>


                    </section>
                </div>
            </div>
            <!-- page end-->
        </section>
    </section>
    <!--main content end-->




</section>
<?php
include('includes/js.php');
?>


</body>
</html>
