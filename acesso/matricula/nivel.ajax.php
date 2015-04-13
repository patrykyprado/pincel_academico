<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( '177.70.22.184', 'underweb_pincel', 'CEDTEC2014Pincel' ) ;
	mysql_select_db( 'underweb_pincel', $con );

	$unidade = mysql_real_escape_string( $_REQUEST['unidade'] );
	$unid = substr($unidade,0,2);

	$nivel = array();

	$sql = "SELECT * FROM nivel WHERE unidade LIKE '%$unidade%' ORDER BY nivel";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$nivel[] = array(
			'cod_nivel'			=> $row['cod_nivel'].$row['unidade'],
			'nivel'			=> utf8_encode($row['nivel']),
			
		);
	}

	echo( json_encode( $nivel ) );