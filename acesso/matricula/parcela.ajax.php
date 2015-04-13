<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( '177.70.22.184', 'underweb_pincel', 'CEDTEC2014Pincel' ) ;
	mysql_select_db( 'underweb_pincel', $con );

	$curso2 = mysql_real_escape_string( $_REQUEST['curso3'] );

	$parcela = array();

	$sql = "SELECT * FROM cursosead WHERE codigo LIKE '%$curso2%'";
	$res = mysql_query( $sql );
	$row = mysql_fetch_array( $res );
	$parcelamin = $row['min_parcela'];
	$parcelamax = $row['max_parcela'];
	while ( $parcelamax >= $parcelamin ){
		if($parcelamax == 1){
			$parcela[] = array (
				'pagamentoexib'		=> $parcelamax.' x R$ '.number_format($row['valor']-($row['valor']*$row['desconto_avista']/100), 2, ',', ''),
				'pagamento'		=> $parcelamax,
				
				);
		}
		if($parcelamax >=2){
			$parcela[] = array (
				'pagamentoexib'		=> $parcelamax.' x R$ '.number_format(($row['valor']-($row['valor']*$row['desconto']/100))/$parcelamax, 2, ',', ''),
				'pagamento'		=> $parcelamax,
				
				);}
		$parcelamax -= 1;
	}
	
	/*while ( $row = mysql_fetch_array( $res ) ) {
		$parcela[] = array(
		    'pagamento'			=> 'A',
			
		);
	}*/

	echo( json_encode( $parcela ) );