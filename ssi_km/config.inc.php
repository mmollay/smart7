<?php
include (__DIR__ . '/../login/config_main.inc.php');

$gaSql['db'] = "ssi_faktura";
mysqli_select_db ( $GLOBALS['mysqli'], $gaSql['db'] ) or die ( 'Could not select database ' . $gaSql['db'] );

if (! $_SESSION['SetYear'])
	$_SESSION['SetYear'] = date ( 'Y' );
$SetYear = $_SESSION['SetYear'];

// Load map function in Form
$load_map = true;

// $link_bmf = 'https://www.bmf.gv.at/services/publikationen/BMF-Steuerbuch_2012_deutsch.pdf?3vtn20';
$link_bmf = 'https://www.bmf.gv.at/steuern/fahrzeuge/kilometergeld.html';

// https://www.ris.bka.gv.at/GeltendeFassung.wxe?Abfrage=Bundesnormen&Gesetzesnummer=20001671

for($ii = '2011'; $ii <= $SetYear; $ii ++) {
	$km_array[$ii]['cost_per_km']['car'] = '0.42';
	$km_array[$ii]['cost_per_km']['bike'] = '0.38'; // und Zu Fuß
	$km_array[$ii]['cost_per_km']['motorbike'] = '0.24';
	
	$km_array[$ii]['cost_per_hour']['at'] = '2.20';
	
	$km_array[$ii]['cost_per_day']['at'] = '26.40';
	$km_array[$ii]['cost_per_night']['at'] = '15.00';
	$km_array[$ii]['cost_per_day']['de'] = '35.30';
	$km_array[$ii]['cost_per_night']['de'] = '27.90';
	$km_array[$ii]['cost_per_day']['es'] = '34.2';
	$km_array[$ii]['cost_per_night']['es'] = '30.5';
	$km_array[$ii]['cost_per_day']['ch'] = '36.80';
	$km_array[$ii]['cost_per_night']['ch'] = '32.70';
	$km_array[$ii]['cost_per_day']['hu'] = '26.6';
	$km_array[$ii]['cost_per_night']['hu'] = '26.6';
	$km_array[$ii]['cost_per_day']['gb_uk'] = '41.4';
	$km_array[$ii]['cost_per_night']['gb_uk'] = '41.4';
}

$km_array_country['at'] = 'Österreich';
$km_array_country['de'] = 'Deutschland';
$km_array_country['es'] = 'Spanien';
$km_array_country['ch'] = 'Schweiz';
$km_array_country['hu'] = 'Ungarn';
$km_array_country['gb_uk'] = 'Großbritannien (London)';

// Landeseinstellung
$default_country = 'at';

// Call HOME
$query = $GLOBALS['mysqli']->query ( "SELECT * FROM km_settings WHERE user_id = '{$_SESSION['user_id']}' and car_id ='{$_SESSION['car_id']}' " );
$array = mysqli_fetch_array ( $query );
$home_address = $array['home_address'];