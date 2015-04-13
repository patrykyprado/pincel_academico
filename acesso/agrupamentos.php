<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
require_once('includes/conectar_pdo.php');
require_once('includes/sql.php');

$sql_agrupamentos = func_buscar_agrupamentos();
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
                            <b>Agrupamentos</b>
                        </header>
                        <div class="panel-body">
                        <table width="100%">
                            <tr>
                                <td align="center"><b>Agrupamento</b></td>
                                <td align="center"><b>Início</b></td>
                                <td align="center"><b>Fim</b></td>
                                <td align="center"><b/>Disciplinas Agrupadas</b></td>
                                <td align="center"><b/>Professor</b></td>
                            </tr>
                            <?php
                            while($dados_agrupamento = $sql_agrupamentos->fetch(PDO::FETCH_ASSOC)) {
                                    $agrupamento_nome = $dados_agrupamento['agrupamento'].
                                    $agrupamento_id = $dados_agrupamento['id'];
                                    $agrupamento_data_inicio = $dados_agrupamento['data_inicio'];
                                    $agrupamento_data_fim = $dados_agrupamento['data_fim'];
                                    $agrupamento_unidade = $dados_agrupamento['nivel'];
                                    $agrupamento_cod_professor = $dados_agrupamento['cod_professor'];
                                    $agrupamento_nome_professor = $dados_agrupamento['nome_professor'];

                                    if(0 == $agrupamento_cod_professor) {
                                        $definir_professor = '<a href="javascript:abrir("definir_professor_agrupamento.php?id='.$agrupamento_id.'");">[DEFINIR]</a>';
                                    } else {
                                        $definir_professor = '<a href="javascript:abrir("definir_professor_agrupamento.php?id='.$agrupamento_id.'");">'.$agrupamento_nome_professor.'</a>';
                                    }
                                    echo '<tr>
                                <td align="center">'.$agrupamento_nome.'</td>
                                <td align="center"><b>'.format_data($agrupamento_data_inicio).'</b></td>
                                <td align="center"><b>'.format_data($agrupamento_data_fim).'</b></td>
                                <td align="center"><b/>'.$total_agrupados.'</b></td>
                                <td align="center">'.$definir_professor.'</td>
                            </tr>';
                            }
                            ?>
                        </table>
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