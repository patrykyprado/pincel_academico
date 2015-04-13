<?php


	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );
    include('includes/funcoes.php');
	$con = mysql_connect( '177.70.22.184', 'underweb_pincel', 'CEDTEC2014Pincel' ) ;
	mysql_select_db( 'underweb_pincel', $con );

	$unidade = mysql_real_escape_string( trim($_REQUEST['unidade']) );
	$conta = array();
	session_start();
	$user_unidade = $_SESSION["MM_unidade"];
	if($user_unidade == "" && strtoupper($unidade)=="CORPORATIVO"){
		$comp_sql = "OR conta LIKE '%pertel%'";	
	} else {
		$comp_sql = "";		
	}
	$sql = "SELECT * FROM contas WHERE conta LIKE '%$unidade%' AND conta LIKE '%$user_unidade%' $comp_sql ORDER BY conta";
	$res = mysql_query( $sql );

	while ( $row = mysql_fetch_array( $res ) ) {
		$conta[] = array(
			'ref_conta'			=> $row['ref_conta'],
			'conta'			=> utf8_encode($row['conta']),
			
		);
	}

	echo( json_encode( $conta ) );
	
	?>