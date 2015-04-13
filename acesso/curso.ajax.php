<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="iso-8859-1"', true );
include('includes/funcoes.php');
	$con = mysql_connect( '177.70.22.184', 'underweb_pincel', 'CEDTEC2014Pincel' ) ;
	mysql_select_db( 'underweb_pincel', $con );

	$nivel = utf8_decode(mysql_real_escape_string( $_REQUEST['nivel']));
	$curso = array();
	$trocarIsso = array('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','O','�','�','�','�',);
	$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y',);
	$nivel2 = remover_acentos($nivel);
	$sql = "SELECT DISTINCT curso FROM disciplinas WHERE nivel like '%$nivel%'";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$curso[] = array(
			'curso'			=> $row['curso'],
			'cursoexib'			=> utf8_encode(format_curso($row['curso']))
			
		);
	}

	echo( json_encode( $curso ) );
	
	
	?>