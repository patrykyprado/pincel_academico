<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
?>
<body>

<section id="container" >
    <?php
    include ('includes/topo.php');
    include ('includes/funcoes.php');
    include ('includes/menu_lateral.php');
    ?>
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">

                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-heading">
                            <b><a data-toggle="modal" id="abrir_modal" href="#modal_aviso">Resumo Acad&ecirc;mico</a></b>



                            <div align="left" style="font-size:10px;" class="task-option">
                                <form action="index.php" method="GET" ><b>Turma Selecionada: </b><select style="width:auto; font-weight:bold;"name="id_turma" id="id_turma" onKeyPress="return arrumaEnter(this, event)">
                            </div>

                    </section>
                </div>

                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-heading">
                            <b>Resumo Financeiro</b>
                        </div>
                        <div class="panel-body">
                        </div>

                    </section>
                </div>

            </div>

        </section>
        <!--weather statement end-->
        </div>
        </div>

    </section>
</section>

<?php
//verifica restri��o de usu�rio
$sql_status_user = mysql_query("SELECT * FROM users WHERE id_user = '$user_iduser'");
$_SESSION["tipo_usuario"] = 1;
if(mysql_num_rows($sql_status_user)==0){
    $_SESSION["tipo_usuario"] = 2;
    $sql_status_user = mysql_query("SELECT * FROM acesso WHERE codigo = $user_usuario");
}
$dados_status_user = mysql_fetch_array($sql_status_user);
$restricao_login = $dados_status_user["status"];
if($restricao_login == 1){
    header("Location: confirmar_dados_acesso.php");
}
if($restricao_login == 2){
    header("Location: ../index.php?erro=2");
}
?>


<?php
include('includes/footer.php');
?>
</section>
<?php
include('includes/js.php');?>


</body>
</html>
