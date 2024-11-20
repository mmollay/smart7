<?php
/*
 * verbindet sich mit der Datenbank und schliesst die Session wieder
 */
function runSQL($rsql) {
	$GLOBALS ['mysqli'] = $GLOBALS ['mysqli'];
	$result = $GLOBALS ['mysqli']->query ( $rsql ) or die ( $rsql );
	return $result;
	$GLOBALS ['mysqli']->close ( $connect );
}
function number($wert) { // $euro ->
	if ($wert < 0)
		$color = "red";
	else
		$color = '';
	$euro = sprintf ( "%01.2f", $wert );
	$euro = number_format ( $euro, 2, ',', '.' );
	// $euro = number_format ($euro,2,'.',',');
	return "<span class='ui text $color'>$euro</span> &nbsp;";
}

/**
 * date_german2mysql
 * wandelt ein traditionelles deutsches Datum
 * nach MySQL (ISO-Date).
 */
function date_german2mysql($datum) {
	list ( $tag, $monat, $jahr ) = explode ( ".", $datum );

	return sprintf ( "%04d-%02d-%02d", $jahr, $monat, $tag );
}

/**
 * date_mysql2german
 * wandelt ein MySQL-DATE (ISO-Date)
 * in ein traditionelles deutsches Datum um.
 */
function date_mysql2german($datum) {
	list ( $jahr, $monat, $tag ) = explode ( "-", $datum );

	return sprintf ( "%02d.%02d.%04d", $tag, $monat, $jahr );
}
function nr_format($wert) {
	if ($wert) {
		$wert = number_format ( $wert, 2, '.', '' );
		return preg_replace ( "/\./", ',', $wert );
	}
}
// Wandelt deutsches Format in englisches um
function nr_format2english($wert1) {
	if ($wert1)
		return preg_replace ( "/,/", '.', $wert1 );
}

// Add in Logfile
function logfile($info, $message, $modul = false, $client_id = false, $bill_id = false, $status = false, $MessageID = false) {
	$GLOBALS ['mysqli']->query ( "INSERT INTO logfile SET
	user_id    = '{$_SESSION['user_id']}',
	client_id  = '$client_id',
	bill_id    = '$bill_id',
	remote_ip  = '{$_SERVER['REMOTE_ADDR']}',
	modul      = '$modul',
	info       = '$info',
    MessageID  = '$MessageID',
	status     = '$status',
	message   = '$message'
	" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
}

// http://www.erdkunde-wissen.de/erdkunde/statistiken/kurzel.htm
$array_country = array ('AT' => 'Österreich','BE' => 'Belgien','BG' => 'Bulgarien','CA' => 'Canada','DK' => 'Dänemark','DE' => 'Deutschland','EE' => 'Estland','FI' => 'Finnland','FR' => 'Frankreich','GR' => 'Griechenland','UK' => 'Großbritannien','IE' => 'Irland','IT' => 'Italien','IL' => 'Israel','JA' => 'Japan','LI' => 'Liechtenstein','LV' => 'Lettland','LT' => 'Litauen','LU' => 'Luxemburg','HR' => 'Kroatien','MT' => 'Malta','NL' => 'Niederlande','NO' => 'Norwegen','PL' => 'Polen','PT' => 'Portugal','RO' => 'Rumänien','SK' => 'Slowakei','SI' => 'Slowenien','ES' => 'Spanien','SE' => 'Schweden','CH' => 'Schweiz','CZ' => 'Tschechische Republik','TR' => 'Türkei','HU' => 'Ungarn','US' => 'USA','ZY' => 'Zypern','XX' => 'Andere' );

$laender ['en'] ['AT'] = "Austria";
$laender ['de'] ['AT'] = "Österreich";
$laender ['en'] ['AF'] = "Afghanistan";
$laender ['de'] ['AF'] = "Afghanistan";
$laender ['en'] ['AL'] = "Albania";
$laender ['de'] ['AL'] = "Albanien";
$laender ['en'] ['AS'] = "American Samoa";
$laender ['de'] ['AS'] = "Amerikanisch Samoa";
$laender ['en'] ['AD'] = "Andorra";
$laender ['de'] ['AD'] = "Andorra";
$laender ['en'] ['AO'] = "Angola";
$laender ['de'] ['AO'] = "Angola";
$laender ['en'] ['AI'] = "Anguilla";
$laender ['de'] ['AI'] = "Anguilla";
$laender ['en'] ['AQ'] = "Antarctica";
$laender ['de'] ['AQ'] = "Antarktis";
$laender ['en'] ['AG'] = "Antigua and Barbuda";
$laender ['de'] ['AG'] = "Antigua und Barbuda";
$laender ['en'] ['AR'] = "Argentina";
$laender ['de'] ['AR'] = "Argentinien";
$laender ['en'] ['AM'] = "Armenia";
$laender ['de'] ['AM'] = "Armenien";
$laender ['en'] ['AW'] = "Aruba";
$laender ['de'] ['AW'] = "Aruba";
$laender ['en'] ['AU'] = "Australia";
$laender ['de'] ['AU'] = "Australien";
$laender ['en'] ['AZ'] = "Azerbaijan";
$laender ['de'] ['AZ'] = "Aserbaidschan";
$laender ['en'] ['BS'] = "Bahamas";
$laender ['de'] ['BS'] = "Bahamas";
$laender ['en'] ['BH'] = "Bahrain";
$laender ['de'] ['BH'] = "Bahrain";
$laender ['en'] ['BD'] = "Bangladesh";
$laender ['de'] ['BD'] = "Bangladesh";
$laender ['en'] ['BB'] = "Barbados";
$laender ['de'] ['BB'] = "Barbados";
$laender ['en'] ['BY'] = "Belarus";
$laender ['de'] ['BY'] = "Weißrussland";
$laender ['en'] ['BE'] = "Belgium";
$laender ['de'] ['BE'] = "Belgien";
$laender ['en'] ['BZ'] = "Belize";
$laender ['de'] ['BZ'] = "Belize";
$laender ['en'] ['BJ'] = "Benin";
$laender ['de'] ['BJ'] = "Benin";
$laender ['en'] ['BM'] = "Bermuda";
$laender ['de'] ['BM'] = "Bermuda";
$laender ['en'] ['BT'] = "Bhutan";
$laender ['de'] ['BT'] = "Bhutan";
$laender ['en'] ['BO'] = "Bolivia";
$laender ['de'] ['BO'] = "Bolivien";
$laender ['en'] ['BA'] = "Bosnia and Herzegovina";
$laender ['de'] ['BA'] = "Bosnien Herzegowina";
$laender ['en'] ['BW'] = "Botswana";
$laender ['de'] ['BW'] = "Botswana";
$laender ['en'] ['BV'] = "Bouvet Island";
$laender ['de'] ['BV'] = "Bouvet Island";
$laender ['en'] ['BR'] = "Brazil";
$laender ['de'] ['BR'] = "Brasilien";
$laender ['en'] ['BN'] = "Brunei Darussalam";
$laender ['de'] ['BN'] = "Brunei Darussalam";
$laender ['en'] ['BG'] = "Bulgaria";
$laender ['de'] ['BG'] = "Bulgarien";
$laender ['en'] ['BF'] = "Burkina Faso";
$laender ['de'] ['BF'] = "Burkina Faso";
$laender ['en'] ['BI'] = "Burundi";
$laender ['de'] ['BI'] = "Burundi";
$laender ['en'] ['KH'] = "Cambodia";
$laender ['de'] ['KH'] = "Kambodscha";
$laender ['en'] ['CM'] = "Cameroon";
$laender ['de'] ['CM'] = "Kamerun";
$laender ['en'] ['CA'] = "Canada";
$laender ['de'] ['CA'] = "Kanada";
$laender ['en'] ['CV'] = "Cape Verde";
$laender ['de'] ['CV'] = "Kap Verde";
$laender ['en'] ['KY'] = "Cayman Islands";
$laender ['de'] ['KY'] = "Cayman Inseln";
$laender ['en'] ['CF'] = "Central African Republic";
$laender ['de'] ['CF'] = "Zentralafrikanische Republik";
$laender ['en'] ['TD'] = "Chad";
$laender ['de'] ['TD'] = "Tschad";
$laender ['en'] ['CL'] = "Chile";
$laender ['de'] ['CL'] = "Chile";
$laender ['en'] ['CN'] = "China";
$laender ['de'] ['CN'] = "China";
$laender ['en'] ['CO'] = "Colombia";
$laender ['de'] ['CO'] = "Kolumbien";
$laender ['en'] ['KM'] = "Comoros";
$laender ['de'] ['KM'] = "Comoros";
$laender ['en'] ['CG'] = "Congo";
$laender ['de'] ['CG'] = "Kongo";
$laender ['en'] ['CK'] = "Cook Islands";
$laender ['de'] ['CK'] = "Cook Inseln";
$laender ['en'] ['CR'] = "Costa Rica";
$laender ['de'] ['CR'] = "Costa Rica";
$laender ['en'] ['CI'] = "Côte d'Ivoire";
$laender ['de'] ['CI'] = "Elfenbeinküste";
$laender ['en'] ['HR'] = "Croatia";
$laender ['de'] ['HR'] = "Kroatien";
$laender ['en'] ['CU'] = "Cuba";
$laender ['de'] ['CU'] = "Kuba";
$laender ['en'] ['CZ'] = "Czech Republic";
$laender ['de'] ['CZ'] = "Tschechien";
$laender ['en'] ['DK'] = "Denmark";
$laender ['de'] ['DK'] = "Dänemark";
$laender ['en'] ['DJ'] = "Djibouti";
$laender ['de'] ['DJ'] = "Djibouti";
$laender ['en'] ['DO'] = "Dominican Republic";
$laender ['de'] ['DO'] = "Dominikanische Republik";
$laender ['en'] ['TP'] = "East Timor";
$laender ['de'] ['TP'] = "Osttimor";
$laender ['en'] ['EC'] = "Ecuador";
$laender ['de'] ['EC'] = "Ecuador";
$laender ['en'] ['EG'] = "Egypt";
$laender ['de'] ['EG'] = "Ägypten";
$laender ['en'] ['SV'] = "El salvador";
$laender ['de'] ['SV'] = "El Salvador";
$laender ['en'] ['GQ'] = "Equatorial Guinea";
$laender ['de'] ['GQ'] = "Äquatorial Guinea";
$laender ['en'] ['ER'] = "Eritrea";
$laender ['de'] ['ER'] = "Eritrea";
$laender ['en'] ['EE'] = "Estonia";
$laender ['de'] ['EE'] = "Estland";
$laender ['en'] ['ET'] = "Ethiopia";
$laender ['de'] ['ET'] = "Äthiopien";
$laender ['en'] ['FK'] = "Falkland Islands";
$laender ['de'] ['FK'] = "Falkland Inseln";
$laender ['en'] ['FO'] = "Faroe Islands";
$laender ['de'] ['FO'] = "Faroe Inseln";
$laender ['en'] ['FJ'] = "Fiji";
$laender ['de'] ['FJ'] = "Fiji";
$laender ['en'] ['FI'] = "Finland";
$laender ['de'] ['FI'] = "Finland";
$laender ['en'] ['FR'] = "France";
$laender ['de'] ['FR'] = "Frankreich";
$laender ['en'] ['GF'] = "French Guiana";
$laender ['de'] ['GF'] = "Französisch Guiana";
$laender ['en'] ['PF'] = "French Polynesia";
$laender ['de'] ['PF'] = "Französisch Polynesien";
$laender ['en'] ['GA'] = "Gabon";
$laender ['de'] ['GA'] = "Gabon";
$laender ['en'] ['GM'] = "Gambia";
$laender ['de'] ['GM'] = "Gambia";
$laender ['en'] ['GE'] = "Georgia";
$laender ['de'] ['GE'] = "Georgien";
$laender ['en'] ['DE'] = "Germany";
$laender ['de'] ['DE'] = "Deutschland";
$laender ['en'] ['GH'] = "Ghana";
$laender ['de'] ['GH'] = "Ghana";
$laender ['en'] ['GI'] = "Gibraltar";
$laender ['de'] ['GI'] = "Gibraltar";
$laender ['en'] ['GR'] = "Greece";
$laender ['de'] ['GR'] = "Griechenland";
$laender ['en'] ['GL'] = "Greenland";
$laender ['de'] ['GL'] = "Grönland";
$laender ['en'] ['GD'] = "Grenada";
$laender ['de'] ['GD'] = "Grenada";
$laender ['en'] ['GP'] = "Guadeloupe";
$laender ['de'] ['GP'] = "Guadeloupe";
$laender ['en'] ['GU'] = "Guam";
$laender ['de'] ['GU'] = "Guam";
$laender ['en'] ['GT'] = "Guatemala";
$laender ['de'] ['GT'] = "Guatemala";
$laender ['en'] ['GN'] = "Guinea";
$laender ['de'] ['GN'] = "Guinea";
$laender ['en'] ['GY'] = "Guyana";
$laender ['de'] ['GY'] = "Guyana";
$laender ['en'] ['HT'] = "Haiti";
$laender ['de'] ['HT'] = "Haiti";
$laender ['en'] ['VA'] = "Vatican";
$laender ['de'] ['VA'] = "Vatikan";
$laender ['en'] ['HN'] = "Honduras";
$laender ['de'] ['HN'] = "Honduras";
$laender ['en'] ['HU'] = "Hungary";
$laender ['de'] ['HU'] = "Ungarn";
$laender ['en'] ['IS'] = "Iceland";
$laender ['de'] ['IS'] = "Island";
$laender ['en'] ['IN'] = "India";
$laender ['de'] ['IN'] = "Indien";
$laender ['en'] ['ID'] = "Indonesia";
$laender ['de'] ['ID'] = "Indonesien";
$laender ['en'] ['IR'] = "Iran";
$laender ['de'] ['IR'] = "Iran";
$laender ['en'] ['IQ'] = "Iraq";
$laender ['de'] ['IQ'] = "Irak";
$laender ['en'] ['IE'] = "Ireland";
$laender ['de'] ['IE'] = "Irland";
$laender ['en'] ['IL'] = "Israel";
$laender ['de'] ['IL'] = "Israel";
$laender ['en'] ['IT'] = "Italy";
$laender ['de'] ['IT'] = "Italien";
$laender ['en'] ['JM'] = "Jamaica";
$laender ['de'] ['JM'] = "Jamaika";
$laender ['en'] ['JP'] = "Japan";
$laender ['de'] ['JP'] = "Japan";
$laender ['en'] ['JO'] = "Jordan";
$laender ['de'] ['JO'] = "Jordanien";
$laender ['en'] ['KZ'] = "Kazakstan";
$laender ['de'] ['KZ'] = "Kasachstan";
$laender ['en'] ['KE'] = "Kenya";
$laender ['de'] ['KE'] = "Kenia";
$laender ['en'] ['KI'] = "Kiribati";
$laender ['de'] ['KI'] = "Kiribati";
$laender ['en'] ['KW'] = "Kuwait";
$laender ['de'] ['KW'] = "Kuwait";
$laender ['en'] ['KG'] = "Kyrgystan";
$laender ['de'] ['KG'] = "Kirgistan";
$laender ['en'] ['LA'] = "Lao";
$laender ['de'] ['LA'] = "Laos";
$laender ['en'] ['LV'] = "Latvia";
$laender ['de'] ['LV'] = "Lettland";
$laender ['en'] ['LB'] = "Lebanon";
$laender ['de'] ['LB'] = "Libanon";
$laender ['en'] ['LS'] = "Lesotho";
$laender ['de'] ['LS'] = "Lesotho";
$laender ['en'] ['LI'] = "Liechtenstein";
$laender ['de'] ['LI'] = "Liechtenstein";
$laender ['en'] ['LT'] = "Lithuania";
$laender ['de'] ['LT'] = "Litauen";
$laender ['en'] ['LU'] = "Luxembourg";
$laender ['de'] ['LU'] = "Luxemburg";
$laender ['en'] ['MO'] = "Macau";
$laender ['de'] ['MO'] = "Macau";
$laender ['en'] ['MK'] = "Macedonia ";
$laender ['de'] ['MK'] = "Mazedonien";
$laender ['en'] ['MG'] = "Madagascar";
$laender ['de'] ['MG'] = "Madagaskar";
$laender ['en'] ['MW'] = "Malawi";
$laender ['de'] ['MW'] = "Malawi";
$laender ['en'] ['MY'] = "Malaysia";
$laender ['de'] ['MY'] = "Malaysia";
$laender ['en'] ['MV'] = "Maldives";
$laender ['de'] ['MV'] = "Malediven";
$laender ['en'] ['ML'] = "Mali";
$laender ['de'] ['ML'] = "Mali";
$laender ['en'] ['MT'] = "Malta";
$laender ['de'] ['MT'] = "Malta";
$laender ['en'] ['MR'] = "Mauritania";
$laender ['de'] ['MR'] = "Mauretanien";
$laender ['en'] ['MU'] = "Mauritius";
$laender ['de'] ['MU'] = "Mauritius";
$laender ['en'] ['YT'] = "Mayotte";
$laender ['de'] ['YT'] = "Mayotte";
$laender ['en'] ['MX'] = "Mexico";
$laender ['de'] ['MX'] = "Mexiko";
$laender ['en'] ['FM'] = "Micronesia";
$laender ['de'] ['FM'] = "Mikronesien";
$laender ['en'] ['MD'] = "Moldova";
$laender ['de'] ['MD'] = "Moldavien";
$laender ['en'] ['MC'] = "Monaco";
$laender ['de'] ['MC'] = "Monaco";
$laender ['en'] ['MN'] = "Mongolia";
$laender ['de'] ['MN'] = "Mongolei";
$laender ['en'] ['MS'] = "Montserrat";
$laender ['de'] ['MS'] = "Montserrat";
$laender ['en'] ['MA'] = "Morocco";
$laender ['de'] ['MA'] = "Marokko";
$laender ['en'] ['MZ'] = "Mozambique";
$laender ['de'] ['MZ'] = "Mosambik";
$laender ['en'] ['MM'] = "Myanmar";
$laender ['de'] ['MM'] = "Myanmar";
$laender ['en'] ['NA'] = "Namibia";
$laender ['de'] ['NA'] = "Namibia";
$laender ['en'] ['NR'] = "Nauru";
$laender ['de'] ['NR'] = "Nauru";
$laender ['en'] ['NP'] = "Nepal";
$laender ['de'] ['NP'] = "Nepal";
$laender ['en'] ['NL'] = "Netherlands";
$laender ['de'] ['NL'] = "Niederlande";
$laender ['en'] ['NZ'] = "New Zealand";
$laender ['de'] ['NZ'] = "Neuseeland";
$laender ['en'] ['NI'] = "Nicaragua";
$laender ['de'] ['NI'] = "Nicaragua";
$laender ['en'] ['NE'] = "Niger";
$laender ['de'] ['NE'] = "Niger";
$laender ['en'] ['NG'] = "Nigeria";
$laender ['de'] ['NG'] = "Nigeria";
$laender ['en'] ['NU'] = "Niue";
$laender ['de'] ['NU'] = "Niue";
$laender ['en'] ['NF'] = "Norfolk Island";
$laender ['de'] ['NF'] = "Norfolk Inseln";
$laender ['en'] ['KP'] = "North Korea";
$laender ['de'] ['KP'] = "Nord Korea";
$laender ['en'] ['NO'] = "Norway";
$laender ['de'] ['NO'] = "Norwegen";
$laender ['en'] ['OM'] = "Oman";
$laender ['de'] ['OM'] = "Oman";
$laender ['en'] ['PK'] = "Pakistan";
$laender ['de'] ['PK'] = "Pakistan";
$laender ['en'] ['PW'] = "Palau";
$laender ['de'] ['PW'] = "Palau";
$laender ['en'] ['PA'] = "Panama";
$laender ['de'] ['PA'] = "Panama";
$laender ['en'] ['PG'] = "Papua New Guinea";
$laender ['de'] ['PG'] = "Papua Neu Guinea";
$laender ['en'] ['PY'] = "Paraguay";
$laender ['de'] ['PY'] = "Paraguay";
$laender ['en'] ['PE'] = "Peru";
$laender ['de'] ['PE'] = "Peru";
$laender ['en'] ['PH'] = "Philippines";
$laender ['de'] ['PH'] = "Philippinen";
$laender ['en'] ['PL'] = "Poland";
$laender ['de'] ['PL'] = "Polen";
$laender ['en'] ['PT'] = "Portugal";
$laender ['de'] ['PT'] = "Portugal";
$laender ['en'] ['PR'] = "Puerto Rico";
$laender ['de'] ['PR'] = "Puerto Rico";
$laender ['en'] ['RO'] = "Romania";
$laender ['de'] ['RO'] = "Rumänien";
$laender ['en'] ['RU'] = "Russia";
$laender ['de'] ['RU'] = "Russland";
$laender ['en'] ['RW'] = "Rwanda";
$laender ['de'] ['RW'] = "Ruanda";
$laender ['en'] ['WS'] = "Samoa";
$laender ['de'] ['WS'] = "Samoa";
$laender ['en'] ['SM'] = "San Marino";
$laender ['de'] ['SM'] = "San Marino";
$laender ['en'] ['SA'] = "Saudi Arabia";
$laender ['de'] ['SA'] = "Saudi-Arabien";
$laender ['en'] ['SN'] = "Senegal";
$laender ['de'] ['SN'] = "Senegal";
$laender ['en'] ['SC'] = "Seychelles";
$laender ['de'] ['SC'] = "Seychellen";
$laender ['en'] ['SL'] = "Sierra Leone";
$laender ['de'] ['SL'] = "Sierra Leone";
$laender ['en'] ['SG'] = "Singapore";
$laender ['de'] ['SG'] = "Singapur";
$laender ['en'] ['SK'] = "Slovakia";
$laender ['de'] ['SK'] = "Slovakei";
$laender ['en'] ['SB'] = "Solomon Islands";
$laender ['de'] ['SB'] = "Solomon Inseln";
$laender ['en'] ['SO'] = "Somalia";
$laender ['de'] ['SO'] = "Somalia";
$laender ['en'] ['ZA'] = "South Africa";
$laender ['de'] ['ZA'] = "Südafrika";
$laender ['en'] ['KR'] = "South Korea";
$laender ['de'] ['KR'] = "Südkorea";
$laender ['en'] ['ES'] = "Spain";
$laender ['de'] ['ES'] = "Spanien";
$laender ['en'] ['LK'] = "Sri Lanka";
$laender ['de'] ['LK'] = "Sri Lanka";
$laender ['en'] ['SD'] = "Sudan";
$laender ['de'] ['SD'] = "Sudan";
$laender ['en'] ['SR'] = "Suriname";
$laender ['de'] ['SR'] = "Suriname";
$laender ['en'] ['SZ'] = "Swaziland";
$laender ['de'] ['SZ'] = "Swasiland";
$laender ['en'] ['SE'] = "Sweden";
$laender ['de'] ['SE'] = "Schweden";
$laender ['en'] ['CH'] = "Switzerland";
$laender ['de'] ['CH'] = "Schweiz";
$laender ['en'] ['SY'] = "Syria";
$laender ['de'] ['SY'] = "Syrien";
$laender ['en'] ['TW'] = "Taiwan";
$laender ['de'] ['TW'] = "Taiwan";
$laender ['en'] ['TJ'] = "Tajikistan";
$laender ['de'] ['TJ'] = "Tadschikistan";
$laender ['en'] ['TZ'] = "Tanzania";
$laender ['de'] ['TZ'] = "Tansania";
$laender ['en'] ['TH'] = "Thailand";
$laender ['de'] ['TH'] = "Thailand";
$laender ['en'] ['TG'] = "Togo";
$laender ['de'] ['TG'] = "Togo";
$laender ['en'] ['TO'] = "Tonga";
$laender ['de'] ['TO'] = "Tonga";
$laender ['en'] ['TT'] = "Trinidad and Tobago";
$laender ['de'] ['TT'] = "Trinidad und Tobago";
$laender ['en'] ['TN'] = "Tunisia";
$laender ['de'] ['TN'] = "Tunesien";
$laender ['en'] ['TR'] = "Turkey";
$laender ['de'] ['TR'] = "Türkei";
$laender ['en'] ['TM'] = "Turkmenistan";
$laender ['de'] ['TM'] = "Turkmenistan";
$laender ['en'] ['TV'] = "Tuvalu";
$laender ['de'] ['TV'] = "Tuvalu";
$laender ['en'] ['UG'] = "Uganda";
$laender ['de'] ['UG'] = "Uganda";
$laender ['en'] ['UA'] = "Ukraine";
$laender ['de'] ['UA'] = "Ukraine";
$laender ['en'] ['AE'] = "United Arab Emirates";
$laender ['de'] ['AE'] = "Vereinigte Arabische Emirate";
$laender ['en'] ['GB'] = "United Kingdom";
$laender ['de'] ['GB'] = "Vereinigtes Königreich";
$laender ['en'] ['US'] = "United States of America";
$laender ['de'] ['US'] = "Vereinigte Staaten von Amerika";
$laender ['en'] ['UY'] = "Uruguay";
$laender ['de'] ['UY'] = "Uruguay";
$laender ['en'] ['UZ'] = "Uzbekistan";
$laender ['de'] ['UZ'] = "Usbekistan";
$laender ['en'] ['VU'] = "Vanuatu";
$laender ['de'] ['VU'] = "Vanuatu";
$laender ['en'] ['VE'] = "Venezuela";
$laender ['de'] ['VE'] = "Venezuela";
$laender ['en'] ['VN'] = "Vietnam";
$laender ['de'] ['VN'] = "Vietnam";
$laender ['en'] ['VG'] = "Virgin Islands";
$laender ['de'] ['VG'] = "Virgin Islands";
$laender ['en'] ['EH'] = "Western Sahara";
$laender ['de'] ['EH'] = "Westsahara";
$laender ['en'] ['YE'] = "Yemen";
$laender ['de'] ['YE'] = "Jemen";
$laender ['en'] ['YU'] = "Yugoslavia";
$laender ['de'] ['YU'] = "Jugoslavien";
$laender ['en'] ['ZR'] = "Zaire";
$laender ['de'] ['ZR'] = "Zaire";
$laender ['en'] ['ZM'] = "Zambia";
$laender ['de'] ['ZM'] = "Sambia";
$laender ['en'] ['ZW'] = "Zimbabwe";
$laender ['de'] ['ZW'] = "Simbabwe";

asort ( $laender ['en'] );
asort ( $laender ['de'] );
function searchForId($id, $array) {
	foreach ( $array as $key => $val ) {
		if ($val ['name'] === $id) {
			return $val ['account_id'];
		}
	}
	return 0;
}

?>