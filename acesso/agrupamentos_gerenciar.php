<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
require_once('includes/conectar_pdo.php');
require_once('includes/sql.php');

$sql_agrupamento = func_agrupamento_dados($_GET['id']);
$dados_agrupamento = $sql_agrupamento->fetch(PDO::FETCH_ASSOC);

?>


<body>

<section id="container" class="sidebar-closed" >


    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <b>Gerenciamento de Agrupamento:<br>
                                <font size="-1"><b>Nome:</b> <?php echo $dados_agrupamento['agrupamento'];?></font><br>
                                <font size="-1"><b>Per&iacute;odo:</b> <?php echo format_data($dados_agrupamento['data_inicio']);?> / <?php echo format_data($dados_agrupamento['data_fim']);?></font><br>
                                <a href="agrupamento_editar.php?id=<?php echo $dados_agrupamento['id_agrupamento'];?>"><font size="-2">Editar</font></a></b>
                        </header>
                        <div class="panel-body">
                            <?php
                            if(empty($dados_agrupamento['disciplinas'])) {
                                echo "<center>Nenhuma turma ainda foi agrupada nesse agrupamento.</center>";
                            } else {
                                $array_disciplina_turma = explode(',', $dados_agrupamento['disciplinas']);
                                foreach($array_disciplina_turma as $cod_turma_disc){
                                    echo '<table width="100%" class="table table-bordered">';
                                    $sql_turma_disc = func_busca_disciplinas_agrupamento($dados['turma_disc'] = $cod_turma_disc);
                                    $dados_turma_disc = $sql_turma_disc->fetch(PDO::FETCH_ASSOC);
                                    echo '<tr bgcolor="#7fffd4">
                                        <td>'.$cod_turma_disc.' - '.$dados_turma_disc['disciplina'].'<font size="-2">
                                        <a href="agrupamento_remover_disciplina.php?turma_disc='.$cod_turma_disc.'&id='.$_GET['id'].'">[Remover]</a></font></td>
                                        </tr>';
                                    echo '<tr bgcolor="#F2F5A9">
                                        <td><b>Grupo:</b> '.$dados_turma_disc['grupo'].'<br>
                                        <b>Unidade / Polo:</b> '.$dados_turma_disc['unidade'].' / '.$dados_turma_disc['polo'].'<br>
                                        <b>Nível:</b> '.$dados_turma_disc['nivel'].'<br>
                                        <b>Curso:</b> '.$dados_turma_disc['curso'].'<br>
                                        <b>Turno:</b> '.$dados_turma_disc['turno'].'<br>
                                        </td>
                                        </tr>';
                                    echo '</table>';
                                }
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