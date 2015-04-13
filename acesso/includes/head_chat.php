<?php 
include('../../includes/conectar.php');
$sql_config = mysql_query("SELECT * FROM config_app");
$dados_config = mysql_fetch_array($sql_config);
$config_titulo = $dados_config["titulo_app"];
$config_nome_app = $dados_config["nome_app"];
$config_footer = $dados_config["footer"];
$config_link_footer = $dados_config["link_footer"];

?>
  <head>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Patryky Prado de Oliveira">
    <meta name="keyword" content="Sistema Acadêmico, CEDTEC, Pincel Atômico">
    <link rel="shortcut icon" href="img/favicon.png">

    <title><?php echo $config_titulo;?></title>
    <link rel="stylesheet" type="text/css" href="assets/shadowbox/shadowbox.css">
    <script type="text/javascript" src="assets/shadowbox/shadowbox.js"></script>
    <script type="text/javascript">
    Shadowbox.init({
        handleOversize: "drag",
        modal: true
    });
    </script>

	<!-- CSS DE IMPRESSÃO -->
    <link href="css/imprimir.css" media="print" rel="stylesheet">
    <style  type="text/css">
	paginar {page-break-after: always;
	}
	@media print {
    paginar {page-break-after: always;
	}
	}
	</style>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">

      <!--right slidebar-->
      <link href="css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>