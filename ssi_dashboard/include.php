<?php
$check_superuser_mode = true; // siehe config_main.php
include ('../login/config_main.inc.php');
$set_module = $_SESSION ['set_module'];

$service_offline = true;
$GLOBALS ['dashboard'] = true;

if ($_SESSION ['user_id'] == 40) {
	$set_module ['userlist'] = true;
	$set_module ['service'] = true;
}

$add_js = "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
// $add_js .= "<script type=\"text/javascript\" src=\"../ssi_smart/gadgets/gallery/fancybox3/jquery.fancybox.js\"></script>";
// $add_css .= "<link rel='stylesheet' type='text/css' href='../ssi_smart/gadgets/gallery/fancybox3/jquery.fancybox.css' />";

// Check ob diese Felder ausgefüllt worden sind
$array_check_userdata_fields = array ('firstname','secondname','gender','zip','city','country','confirm_agb' );

if ($array_company ['img_logo']) {
	$img_logo = "/company/$company_id/" . $array_company ['img_logo'];
} else {
	$img_logo = '../image/ssi_logo.png';
}

if ($img_logo) {
	$content = "<div align=center><img class='ui small image' src='$img_logo'></div>";
}

// Anzeige wenn User noch nicht verifiziert hat
if ($_SESSION ['user_verified'] == false) {
	$content .= "
	<br><div align=center><i class='icon ui disabled protect huge'></i><br><br><div class='ui compact huge message'>
	  <p>Bitte den Posteingang überprüfen und Email bestätigen um das System freizuschalten!<br><br>
	<button class='button ui orange tooltip icon'  id='send_verification' title='$tooltip_send_verification_again'><i class='mail icon'></i> Freischaltcode noch mal zusenden</button>
	<a href='' class='button ui blue icon tooltip' title='Wurde der Link bereits bestätigt?'><i class='icon refresh popup'></i> Seiten neu laden</a>
	</div></div>";
	return;
	exit ();
} // Prüft ob Userinfo vollständig ist
elseif (! check_userdata_complete ( $_SESSION ['user_id'], $array_check_userdata_fields )) {

	include_once ('../ssi_smart/smart_form/include_form.php');
	// include_once ('../ssi_smart/php_functions/functions.php');
	include ('ajax/form_userinfo_complite.php');
	return;
	exit ();
} // Prüft ob User bereits die erstn NL-Einstellungen erhalten hat und legt diese gegebenfalls an
elseif (! check_first_install ( $_SESSION ['user_id'] )) {
	// Newslettereinstellungen für neuen User anlegen
	include ('function_first_insert.php');

	generate_first_insert ( $_SESSION ['user_id'], $_SESSION ['mysql'] ['db_nl'] );
	// Marker wird gesetzt damit Parameter nicht nocheinmal angelegt werden
	$GLOBALS ['mysqli']->query ( "UPDATE ssi_company.user2company SET install_routine = 1 WHERE user_id = '{$_SESSION['user_id']}'" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
}

include ('function_selectdomain.php');

// $set_module[smart] = true;
// $set_module ['21days'] = true;

// $add_css .= "<link rel=stylesheet type='text/css' href='../login/css/basis.css'>";
$add_css = "\n<link rel='stylesheet' type='text/css' href='css/new_page.css' />";

// $content .= "<a id=button_tour onclick='javascript:startTour()' href='javascript:void(0);'>Tour starten</a>";

// http://usablica.github.io/intro.js/
$intro ['1'] = "data-step='1' data-position='right' data-intro='Faktura bearbeiten und Rechnungen verschicken' ";
$intro ['2'] = "data-step='2' data-position='right' data-intro='Kilometergeld verwalten f&uuml;r alle Fahrzeuge' ";
$intro ['3'] = "data-step='3' data-position='left' data-intro='W&auml;hle die Webseite zur Berarbeitung aus.' ";
$intro ['4'] = "data-step='4' data-position='left' data-intro='Versende Emails an eine gew&uuml;nschte Personengruppe.'  ";

// Anzeigen der Seite, welche zur Veröffentlichung angemeldet worden sind
if (in_array ( $_SESSION ['user_id'], $_SESSION ['array_superuser_id'] )) {

	$set_module ['userlist'] = true;
	$set_module ['setting'] = true;

	$select_set_public_page = select_set_public_page ();
	if ($select_set_public_page)
		// $content .= "<div class=center_button_field><div align=center>Seitenfreigabe<br><br><br><i class='smile huge icon'></i></div>$select_set_public_page</div>";
		$content .= "<div  title='Wähle und bearbeite deine Webseite' class='tooltip center_button_field'>Seitenfreigabe<div class=center_button_field_text><i class='smile huge icon'></i>$select_set_public_page</div></div>";
}

/**
 * *****************************************************************************
 * Main - Fields
 * *****************************************************************************
 */
$content .= "<br><br><div class='ui cards centered'>";

if ($set_module ['smart']) {
	$content .= call_smart_select ();
}

$content .= "</div>";

$content .= "<div class='ui link cards centered'>";

// if ($set_module ['intuition']) {
// $content .= call_field_small ( "Intuition", 'mug hot', '', '../ssi_intuition/', 'Intuitionstraining' );
// }

$modules ['newsletter'] = [ "Newsletter",'send outline','','../ssi_newsletter/','Versende wichtige Mail an deine Newsletterliste' ];

$modules ['paneon'] = [ "Paneon",'blue dove','','../ssi_paneon/','Paneon-Userverwaltung' ];

$modules ['faktura'] = [ "Faktura",'book','','../ssi_faktura/','Deine Buchhaltung immer im Griff' ];

$modules ['trader'] = [ "Trader",'wallet','','../ssi_trader/','Make your mouney' ];

$modules ['learning'] = [ "Learning",'student','','../ssi_learning/','Für Prüfungen üben' ];

$modules ['kmlist'] = [ "KM-Liste",'road','','../ssi_km/','Jeder Kilometer zählt :)' ];

$modules ['map'] = [ "Fruit-Map",'fruit-apple','','../ssi_map/','Maps' ];

$modules ['userlist'] = [ "User/Domain",'list','','../ssi_userlist/','User/Domain und andere Übersichten' ];

$modules ['setting'] = [ "Einstellungen",'settings layout','','../ssi_setting/','Registrierseite bearbeiten und andere Einstellungen' ];

$modules ['service'] = [ "Service",'configure','','../ssi_service/','Sicherheit, Reinigung, Überprüfungen' ];



foreach ( $modules as $module => $fields ) {
	
	if ($set_module [$module] || ($module === 'paneon' && in_array ( $user_id, [ 67,40,1312 ] ))) {
		$content .= call_field_small ( ...$fields );
	}
}

$content .= "</div><br>";

$content .= "
<div class='ui modal new_page'><div class='header'>Neue Webseite anlegen</div>
<div class='content'></div>
<div class='actions'>
<div class='ui button green approve'><i class='icon checkmark'></i> Webseite erzeugen</div>
<div class='ui button deny'>Schließen</div>
</div></div>";

$content .= "<div align=center><div class='ui label basic'>Version $center_version</div></div>";

// Zeigt an ob Chookie aktiviert ist
// $content .= "<div align=center><br><br><div style='max-width:800px;' class='ui inline cookie nag' ><span class='title'>Wir verwenden Cookies , um sicherzustellen um die beste Erfahrung der Webseite sicher zu stellen. </span><i class='close icon'></i></div></div>";

// Kleine Felder für andere Programme wie ssi_faktura,..
function call_field($title, $icon, $text, $link = false, $tooltip = false) {
	$output .= "<div style='width:410px; height:200px' class='card tooltip-top' title='$tooltip' >";

	if ($link)
		$output .= "<a href='$link'>";

	$output .= "<div class='content' align=center>";

	$output .= "<div class='ui small header'>$title</div>";
	if ($icon)
		$output .= "<i class='$icon huge icon'></i><br>";
	$output .= $text;
	$output .= "</div>";

	$output .= "</div>";

	if ($link)
		$output .= "</a>";

	return $output;
}

// Kleine Felder für andere Programme wie ssi_faktura,..
function call_field_small($title, $icon, $text, $link = false, $tooltip = false) {
	$output = "<a href='$link' style='width:130px; height:130px' class='card tooltip-top' title='$tooltip'>";

	$output .= "<div class='content' align=center>";

	$output .= "<div class='ui small header'>$title</div>";
	if ($icon)
		$output .= "<i class='$icon huge icon'></i><br>";
	$output .= $text;
	$output .= "</div>";

	$output .= "</a>";

	return $output;
}

// Wenn Wert zurück kommt, sind alle relevanten Felder ausgefüllt
function check_userdata_complete($user_id, $array_fields) {

	// Wenn nicht gesetzt ist
	$add_query = $add_query ?? '';

	foreach ( $array_fields as $value ) {
		$add_query .= " AND $value != '' ";
	}
	$query = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_company.user2company WHERE user_id = '$user_id' $add_query " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

	return mysqli_num_rows ( $query );
}

// Check Userinstallationsroutine für Newsletter
function check_first_install($user_id) {
	$query = $GLOBALS ['mysqli']->query ( "SELECT install_routine FROM ssi_company.user2company  WHERE user_id = '$user_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );
	return $array [0];
}

// Select und Anlegen Button für Smart-Kit
function call_smart_select() {
	$ii = 0;
	$div_item = '';

	// Ruft alle bestehenden Domains auf
	$query = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_company.domain a LEFT JOIN  {$_SESSION['db_smartkit']}.smart_page b ON a.page_id = b.page_id  WHERE a.user_id = '{$_SESSION['user_id']}' ORDER BY update_date desc" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $domain_array = mysqli_fetch_array ( $query ) ) {
		$ii ++;
		$page_id = $domain_array ['page_id'];
		$domain = $domain_array ['domain'];
		$div_item .= "<a href='../ssi_smart/index.php?page_select=$page_id' class='item' id='$page_id' data-value='$page_id' value='$page_id'>$domain (ID:$page_id)</a>";
	}

	// AUSLESEN DER ANZAHL MOEGLICHER SMART-SEITEN
	$query1 = $GLOBALS ['mysqli']->query ( "SELECT number_of_smartpage FROM ssi_company.user2company where user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array1 = mysqli_fetch_array ( $query1 );
	$number_of_smartpage = $array1 ['number_of_smartpage'];

	// AUSLESEN DER ANZAHL BESTEHENDER SMART-SEITEN
	$query2 = $GLOBALS ['mysqli']->query ( "SELECT COUNT(*) FROM smart_page where user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array2 = mysqli_fetch_array ( $query2 );
	$number_of_used_pages = $array2 [0];

	if ($number_of_smartpage > $number_of_used_pages) {
		$button_add = "<div class='ui bottom blue mini attached button' onclick='call_form_newpage()'><i class='add icon'></i>Neue Webseite anlegen</div>";
	}

	// Ausgabe wenn mehr als eine Page zur Verfügung steht
	if ($ii > 1) {
		$domain_select = "
		<div class='ui floating dropdown labeled search icon button'>
		  <i class='world icon'></i>
		  <span class='text'>Seite wählen</span>
	  		<div class='menu'>$div_item</div>
		</div>";
		$output = "<div class='content'><div class='ui small header'>Smart-Kit</div><i class='world huge icon'></i><br><br>$domain_select</div>$button_add";
	} else if ($ii == 1) {
		// Ausgabe bei Singlepage
		$_SESSION ['smart_page_id'] = $page_id;
		$output = "<a href='../ssi_smart/' class='content tooltip-top' title='Webseite zum bearbeiten öffnen'><div class='ui small header'>Smart-Kit</div><i class='world huge icon'></i><br><br><b>$domain</b></a>$button_add";
	} else {
		$output = "<a href=# class='content tooltip-top' title='Neue Webseite erzeugen' onclick='call_form_newpage()'><div class='ui small header'>Smart-Kit</div><i class='world huge icon'></i><br><br><b>Jetzt Webseite erzeugen</b></a>";
	}

	return "<div class='card' style='max-width:270px;' align=center>$output</div>";
}

?>