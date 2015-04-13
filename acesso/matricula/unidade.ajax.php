<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( '177.70.22.184', 'underweb_pincel', 'CEDTEC2014Pincel' ) ;
			mysql_select_db( 'underweb_pincel', $con );

	$modal = mysql_real_escape_string( $_REQUEST['modal'] );

	$unidade = array();

	$sql = "SELECT * FROM unidades WHERE categoria = $modal";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$unidade[] = array(
			'unidade'	=> $row['unidade'],
			'endereco'			=> $row['endereco'],
			'sigla'		=> $row['sigla'],
		);
	}

	echo( json_encode( $unidade ) );