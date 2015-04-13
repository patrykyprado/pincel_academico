<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');
require_once('includes/conectar_pdo.php');//nova conex�o pdo
require_once('includes/sql.php');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_POST['data_inicio'] = format_data_us($_POST['inicio']);
    $_POST['data_fim'] = format_data_us($_POST['fim']);
    $_POST['agrupamento'] = $_POST['nome_agrupamento'];
    $_POST['nivel'] = $_POST['nivel'];
    $_POST['unidade'] = $_POST['unidade'];

    $sql_inserir_agrupamento = func_cad_agrupamento($_POST);
    echo $sql_inserir_agrupamento;

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
                            <b>Cadastro de Agrupamento</b>
                        </header>
                        <div class="panel-body">
<form action="cad_agrupamento.php" method="POST">
    <table align="center" width="30%">
        <tr>
            <td><b>Nome do Agrupamento</b></td>
            <td><input type="text" required="required" name="nome_agrupamento" /></td>
        </tr>
        <tr>
            <td><b>Unidade: </b></td>
            <td><select name="unidade">
                    <?php
                    $sql_unidade = func_drop_unidade($user_unidade);
                    while($dados_unidade = $sql_unidade->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value='".$dados_unidade['unidade']."'>".$dados_unidade['unidade']."</option>";
                    }
                    ?>
                </select></td>
        </tr>
        <tr>
            <td><b>N&iacute;vel: </b></td>
            <td><select name="nivel">
                    <?php
                    $sql_nivel = func_drop_nivel_ensino();
                    while($dados_nivel = $sql_nivel->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value='".$dados_nivel['nivel']."'>".$dados_nivel['nivel']."</option>";
                    }
                    ?>
                </select></td>
        </tr>
        <tr>
            <td><b>Data de In&iacute;cio</b></td>
            <td><input required="required" class="default-date-picker" type="text"  maxlength="10" name="inicio" /></td>
        </tr>
        <tr>
            <td><b>Data de Fim</b></td>
            <td><input required="required" class="default-date-picker" type="text" maxlength="10" name="fim" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="Salvar" /></td>
        </tr>
    </table>
</form>
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

<?php include("includes/js_data.php");?>