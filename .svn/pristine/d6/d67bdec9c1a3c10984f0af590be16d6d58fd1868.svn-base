<?php
// $test_modus = true;
if ($test_modus) {
	// TEST
	$cols[] = array ( 0 => '305-5741554-3930765' , 28 => 'Preisnachlass 1,28 für 7,99 UST Gutschein' );
	$cols[] = array ( 0 => '028-1432300-0235564' , 28 => 'Preisnachlass 1,28 für 7,99 UST Gutschein' );
	$cols[] = array ( 0 => '302-0971032-7924362' , 28 => '' );
	
	foreach ( $cols as $array ) {
		insert_into_amazon_order ( $db, $array );
	}
	return;
}

/**
 * \file simplemws.php
 * \brief Einfacher Amazon MWS Client
 *
 * \author Bert Klauninger
 * \author Martin Mollay
 * \version 0.2.0
 * \cond changelog
 * 2017-02-15 - Erstellt
 * 2017-02-21 - Daten in DB spielen
 * \
 */

header ( "Content-Type: text/plain" );
ini_set ( 'error_reporting', E_ALL );
ini_set ( 'display_errors', 1 );

include_once ('../config_newsletter.php');
/* Einstellungen */
$sql_host = $cfg_mysql['host_nl'];
$sql_user = $cfg_mysql['user_nl'];
$sql_pass = $cfg_mysql['password_nl'];
$sql_db = $cfg_mysql['db_nl'];

$db = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( "Could not connect to server $sql_host" );
mysqli_select_db ( $db, $sql_db ) or die ( "Could not select database $sql_db" );

$AMAZON_MWS_HOST = "mws.amazonservices.de";
//$MWS_MERCHANT = "A9CM2QKFG74GQ"; //Michi (Seller)
// $MWS_AUTH_TOKEN = ""; //TOKEN ist nicht notwendig

// MarketPlace von Michi
$AWS_ACCESS_KEY_ID = "AKIAIAAUHCDIR34F4FDA";
$SECRET_KEY = "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";

$query = mysqli_query ( $db, "SELECT mws_merchant_id_eu,user_id FROM setting WHERE mws_merchant_id_eu !='' and user_id != '' " ) or die ( mysqli_error ($con) );
while ( $array_simple = mysqli_fetch_array ( $query ) ) {
	
	$MWS_MERCHANT = $array_simple['mws_merchant_id_eu'];
	$user_id = $array_simple['user_id'];
	// echo "user: $user_id -> $MWS_MERCHANT\n";
	/* Report-Liste holen */
	$par = array ();
	$par['Action'] = 'GetReportList';
	$par['ReportTypeList.Type.1'] = '_GET_FLAT_FILE_ALL_ORDERS_DATA_BY_ORDER_DATE_';
	$r = call_amazon_mws ( $MWS_MERCHANT, $AWS_ACCESS_KEY_ID, $SECRET_KEY, $AMAZON_MWS_HOST, $par );
	
	$xml = new SimpleXMLElement ( $r );
	$report_id = $xml->GetReportListResult->ReportInfo[0]->ReportId;
	// echo("report_id = $report_id\n");
	
	/* Report holen */
	$par = array ();
	$par['Action'] = 'GetReport';
	$par['ReportId'] = $report_id;
	$r = call_amazon_mws ( $MWS_MERCHANT, $AWS_ACCESS_KEY_ID, $SECRET_KEY, $AMAZON_MWS_HOST, $par );
	// echo("$r\n");
	
	$lines = explode ( "\n", $r );
	
	/* Erste Zeile ist Titelzeile --> auslassen */
	for($i = 1; $i < count ( $lines ); ++ $i) {
		$cols = explode ( "\t", $lines[$i] );
		if (count ( $cols ) == 29) {
			// foreach ( $cols as $key => $value ) { $output .= "$key : $value , \t"; }
			// echo ($output . "\n");
			insert_into_amazon_order ( $db, $user_id, $cols );
			echo ("order-id: {$cols[0]}, promotion-id: {$cols[28]}");
		}
	}
}

/**
 * Eintragen in die Datenbank
 *
 * @param unknown $array        	
 */
function insert_into_amazon_order($db, $user_id, $array) {
	$array[28] = trim($array[28]);
	if ($array[28] AND $user_id) {
		mysqli_query ($db, "REPLACE INTO amazon_order SET
		order_id = '{$array[0]}',
		user_id = '$user_id',
		amazon_promotion_id = '{$array[28]}'" ) or die ( mysqli_error ($con) );
	}
}

/**
 * Abwicklung eines autorisierten Amazon MWS Aufrufes
 */
function call_amazon_mws($seller_id, $aws_access_key_id, $secret_key, $host, $par) {
	$par['AWSAccessKeyId'] = $aws_access_key_id;
	$par['Merchant'] = $seller_id;
	$par['SignatureVersion'] = 2;
	$par['Timestamp'] = gmdate ( 'Y-m-d\TH:i:s\Z' );
	$par['Version'] = '2009-01-01';
	$par['SignatureMethod'] = 'HmacSHA256';
	
	ksort ( $par );
	
	$request = '';
	foreach ( $par as $key => $value ) {
		if ($request != '') {
			$request .= '&';
		}
		$request .= $key . '=' . urlencode ( $value );
	}
	$to_sign = "POST\n$host\n/\n$request";
	
	$signature = urlencode ( base64_encode ( hash_hmac ( 'sha256', $to_sign, $secret_key, true ) ) );
	$request .= '&Signature=' . $signature;
	
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, "https://$host" );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $request );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	
	// echo("<pre>$to_sign\n\n$signature\n\n$request\n\n");
	
	return curl_exec ( $ch );
}

?>