<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );
	include('includes/funcoes.php');
	$con = mysql_connect( '177.70.22.184', 'underweb_pincel', 'CEDTEC2014Pincel' ) ;
	mysql_select_db( 'underweb_pincel', $con );

	$empresa = mysql_real_escape_string( $_REQUEST['empresa'] );
	$unidade = array();
	session_start();
	$user_unidade = $_SESSION["MM_unidade"];
	if($empresa == "*"){
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0 ";
	} else {
		$sql = "SELECT distinct unidade FROM unidades WHERE empresa LIKE '%$empresa%' AND unidade LIKE '%$user_unidade%' ORDER BY unidade";
	}
	if($user_unidade == "" || $user_unidade == "PERTEL"){
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0 OR unidade LIKE '%corporativo%' OR unidade LIKE '%EAD%' OR unidade LIKE '%Qualificacao%'";
	}
	$res = mysql_query( $sql );

	while ( $row = mysql_fetch_array( $res ) ) {
		$unidade[] = array(
			'unidade_exib'			=> utf8_encode($row['unidade']),
			'unidade'			=> remover_acentos(($row['unidade']))
		);
	}

	echo( json_encode( $unidade ) );
	
	
	?>