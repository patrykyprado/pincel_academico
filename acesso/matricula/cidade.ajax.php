<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( '177.70.22.184', 'underweb_pincel', 'CEDTEC2014Pincel' ) ;
	mysql_select_db( 'underweb_pincel', $con );

	$uf = mysql_real_escape_string( $_REQUEST['uf'] );

	$cidade = array();

	$sql = "SELECT * FROM cod_municipios WHERE uf LIKE '$uf'";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$cidade[] = array(
		    'cidade'			=> utf8_encode(strtoupper($row['nome']))
			
			
		);
	}

	echo( json_encode( $cidade ) );