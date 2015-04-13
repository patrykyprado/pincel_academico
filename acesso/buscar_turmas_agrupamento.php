<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
require_once('includes/conectar_pdo.php');//nova conexão pdo
require_once('includes/sql.php');

if($_REQUEST['envio'] == 1){
    $sql_busca_disciplinas = func_busca_disciplinas_agrupamento($_REQUEST);
    $total_disciplinas = $sql_busca_disciplinas->rowCount();
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $total_agrupados = 0;
    for( $i = 0 , $x = count( $_POST[ 'turma_disc' ] ) ; $i < $x ; ++ $i ) {
        $dados = array();
        $dados['turma_disc'] = $_POST['turma_disc'][$i];
        $dados['agrupamento'] = $_POST['agrupamento'][$i];
        if(!empty($dados['agrupamento'])){
            //carrega o agrupamento
            $sql_busca_selecionado = func_agrupamento_dados($dados['agrupamento']);
            $dados_selecionado = $sql_busca_selecionado->fetch(PDO::FETCH_ASSOC);
            $dados['disciplinas'] = $dados_selecionado['disciplinas'].",".$dados['turma_disc'];
            //atualiza o agrupamento
            $sql_atualizar_agrupamento = func_agrupamento_atualizar($dados['agrupamento'],$dados['disciplinas']);
            if(1 == $sql_atualizar_agrupamento->rowCount())
                $total_agrupados +=1;
        }
    }
    echo "<script>
    alert('Foram inseridos ".$total_agrupados." turmas no agrupamento.');
    </script>";
}
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
                            <b>Agrupamento de Disciplinas</b><br>
                            <form action="agrupar_disciplinas.php" method="get">
                                <input type="hidden" name="envio" value="1" />
                                Disciplina: <input name="disciplina" value="<?php if(!empty($_REQUEST['disciplina']))
                                    echo $_REQUEST['disciplina'];?>" />
                                N&iacute;vel: <select name="nivel">
                                    <option value="" selected>Todos</option>
                                    <?php
                                    $sql_nivel = func_drop_nivel_ensino();
                                    while($dados_nivel = $sql_nivel->fetch(PDO::FETCH_ASSOC)){
                                        echo "<option value='".$dados_nivel['nivel']."'>".$dados_nivel['nivel']."</option>";
                                    }
                                    ?>
                                </select>
                                Grupo: <select name="grupo">
                                    <option value="" selected>Todos</option>
                                    <?php
                                    $sql_drop_grupos = func_drop_grupos_turmas();
                                    while($dados_grupos = $sql_drop_grupos->fetch(PDO::FETCH_ASSOC)){
                                        echo "<option value='".$dados_grupos['grupo']."'>".$dados_grupos['grupo']."</option>";
                                    }
                                    ?>
                                </select>

                                <input type="submit" value="Buscar"/>
                            </form>
                        </header>
                        <div class="panel-body">
                            <?php
                            if($total_disciplinas == 0) {
                                echo "<center>Nenhum resultado encontrado.</center>";
                            } else {
                                ?>
                                <form action="agrupar_disciplinas.php" method="POST">
                                    <table width="100%" border="1" class="table-bordered">
                                        <tr bgcolor="#CCCCCC" style="color: #ffffff">
                                            <td align="center"><b>Disciplina</b></td>
                                            <td align="center"><b>Grupo</b></td>
                                            <td align="center"><b>Nível</b></td>
                                            <td align="center"><b>Curso</b></td>
                                            <td align="center"><b>Módulo</b></td>
                                            <td align="center"><b>Unidade / Polo</b></td>
                                            <td align="center"><b>Agrupamento</b></td>
                                        </tr>
                                        <?php
                                        while($dados_disciplinas = $sql_busca_disciplinas->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <tr>
                                                <td><?php echo $dados_disciplinas['disciplina'];?></td>
                                                <td align="center"><?php echo $dados_disciplinas['grupo'];?></td>
                                                <td align="center"><?php echo $dados_disciplinas['nivel'];?></td>
                                                <td align="center"><?php echo $dados_disciplinas['curso'];?></td>
                                                <td align="center"><?php echo $dados_disciplinas['modulo'];?></td>
                                                <td align=""><?php echo $dados_disciplinas['unidade']." / ".$dados_disciplinas['polo'];?></td>
                                                <td align="center"><input name="turma_disc[]" type="hidden" value="<?php echo $dados_disciplinas['turma_disc'];?>" />
                                                    <select name="agrupamento[]">
                                                        <?php
                                                        //selecionado
                                                        $sql_busca_selecionado = func_agrupamento_selecionado($dados_disciplinas['turma_disc']);
                                                        $dados_selecionado = $sql_busca_selecionado->fetch(PDO::FETCH_ASSOC);
                                                        echo "<option value='".$dados_selecionado['id_agrupamento']."'>".$dados_selecionado['agrupamento']."</option>";

                                                        //while com ativos
                                                        $sql_drop_agrupamento_ativo = func_drop_agrupamentos_ativos();
                                                        while($dados_agrupamentos = $sql_drop_agrupamento_ativo->fetch(PDO::FETCH_ASSOC)){
                                                            echo "<option value='".$dados_agrupamentos['id_agrupamento']."'>".$dados_agrupamentos['agrupamento']."</option>";
                                                        }
                                                        ?>
                                                    </select></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="7" align="center"><br><input type="submit" value="Salvar Agrupamento"/></td>
                                        </tr>
                                    </table>
                                </form>
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



    <?php
    include('includes/footer.php');
    ?>
</section>
<?php
include('includes/js.php');
?>


</body>
</html>

<script language="javascript">
    function arrumaEnter (field, event) {
        var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
        if (keyCode == 13) {
            var i;
            for (i = 0; i < field.form.elements.length; i++)
                if (field == field.form.elements[i])
                    break;
            i = (i + 1) % field.form.elements.length;
            field.form.elements[i].focus();
            return false;
        }
        else
            return true;
    }
</script>
<script language="JavaScript">
    function abrir(URL) {

        var width = 900;
        var height = 500;

        var left = 300;
        var top = 0;

        window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

    }
</script>


<script language='JavaScript'>
    function validarAction(frm){
        frm.action = frm.tipo.value;
        frm.submit();
    }
</script>