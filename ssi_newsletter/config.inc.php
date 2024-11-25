<?php
/**
 * config.inc.php - Konstanten fuer den NEWSLETTER-VERSANDT
 *
 * @author Martin Mollay
 *         @last-changed 2018-05-27
 *
 */
//session_start ();
// include ('config_newsletter.php');
include (__DIR__ . '/../login/config_main.inc.php');
include_once (__DIR__.'/mysql.inc');

$_SESSION['user_id'] = $_COOKIE['user_id'] ?? $_SESSION['user_id'];
$_SESSION['db_smartkit'] = $_COOKIE['db_smartkit'] ?? $_SESSION['db_smartkit'];
$_SESSION['company'] = $_COOKIE['company'] ?? $_SESSION['company'];

date_default_timezone_set ( 'Europe/Vienna' );

// Import - Parameter
$array_import = array ("email" => "Email","firstname" => "Vorname","secondname" => "Nachnname","sex" => "Gender{f=Frau,m=Herr,c=Firma}","title" => "Title","client_number" => "Kundennummer","company_1" => "Firma 1","company_2" => "Firma 2","street" => "Straße","zip" => "PLZ","city" => "Stadt",
		"country" => "Land","telefon" => "Telefon","web" => "Internet","birth" => "Geburtsdatum","placeholder1" => "Platzhalter 1","placeholder2" => "Platzhalter 2","placeholder3" => "Platzhalter 3" );


if (isset($_COOKIE['array__template_import'])) {
	$array_import1 = explode(',', $_COOKIE['array__template_import']);
	$array_import = array_intersect_key($array_import, array_flip($array_import1));
}

// echo $setJS;

// Aktuelles Userpaket
$user_paket = 'standard';

// Kosten per Montho FREE
$paket ['free'] ['name'] = 'Free'; // Name of Pakets
$paket ['free'] ['email'] = 500; // Emails per Month
$paket ['free'] ['traffic'] = 1024 * 1024 * 1024 * 0.1; // per Month in MB
$paket ['free'] ['space'] = 1024 * 1024 * 1024 * 0.1; // generell in MB
$paket ['free'] ['attachment'] = 1024 * 1024 * 0.125; // 200 kb Attachment Size per send
$paket ['free'] ['fileSizeLimit'] = '1MB';

// Cost per Month 9,9-
$paket ['light'] ['name'] = 'Light';
$paket ['light'] ['email'] = 10000;
$paket ['light'] ['traffic'] = 1024 * 1024 * 1024 * 2;
$paket ['light'] ['space'] = 1024 * 1024 * 1024 * 0.25;
$paket ['light'] ['attachment'] = 1024 * 1024 * 5;
$paket ['light'] ['fileSizeLimit'] = '5MB';

// Cost per Month 29,9-
$paket ['standard'] ['name'] = 'Standard';
$paket ['standard'] ['email'] = 40000;
$paket ['standard'] ['traffic'] = 1024 * 1024 * 1024 * 4;
$paket ['standard'] ['space'] = 1024 * 1024 * 1024 * 1;
$paket ['standard'] ['attachment'] = 1024 * 1024 * 30;
$paket ['standard'] ['fileSizeLimit'] = '30MB';

// Cost per Month 49,9-
$paket ['profi'] ['name'] = 'Profi';
$paket ['profi'] ['email'] = 100000;
$paket ['profi'] ['traffic'] = 1024 * 1024 * 1024 * 10;
$paket ['profi'] ['space'] = 1024 * 1024 * 1024 * 2;
$paket ['profi'] ['attachment'] = 1024 * 1024 * 100;
$paket ['profi'] ['fileSizeLimit'] = '100MB';

// Versandsystem API
$delivery_system_array ['mailjet'] = 'Mailjet (default)';
$delivery_system_array ['phpmailer'] = 'Phpmailer (keine Statistik)';

// New Upload - Folder
$upload_dir = $document_root . "/smart_users/{$_SESSION['company']}/user{$_SESSION['user_id']}/newsletter"; // Bei Upload muss der absolute Serverpfad verwendet werden

// $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/smart_users/{$_SESSION['company']}/user{$_SESSION['user_id']}/newsletter"; // Bei Upload muss der absolute Serverpfad verwendet werden
$upload_url = "../smart_users/{$_SESSION['company']}/user{$_SESSION['user_id']}/newsletter";

exec ( "mkdir $upload_dir" );
exec ( "mkdir $upload_dir/user" );

$array_value_tag = call_array_tags ();
// $array_value_event = call_array_event ();

$array_time_unit = array ("day" => "Tag(en)","hour" => "Stund(en)","minutes" => "Minut(en)" );

// Wenn keine Smart_page gewählt wurde wird diese, sofern vorhanden ausgelesen
if (! $_SESSION ['smart_page_id'] and $_SESSION ['db_smartkit']) {
	$query = $GLOBALS ['mysqli']->query ( "SELECT page_id FROM {$_SESSION['db_smartkit']}.smart_page WHERE user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );
	$_SESSION ['smart_page_id'] = $array ['page_id'];
}

mysqli_select_db ( $GLOBALS ['mysqli'], 'ssi_newsletter2' ) or die ( 'Could not select database ssi_newsletter' );


// Optionen für Select abrufen
$query = $GLOBALS ['mysqli']->query ( "SELECT * from sender where user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
while ( $aFormValues = mysqli_fetch_array ( $query ) ) {
	$smtp_server = $aFormValues ['smtp_server'];
	$from_name = $aFormValues ['from_name'];
	$from_email = $aFormValues ['from_email'];
	if ($smtp_server)
		$smtp_server = "=> $smtp_server";
	$from_array [$aFormValues ['id']] = "$from_name ($from_email) $smtp_server";
}

// Email auf die Versendet (INFO) werden darf - und auch freigegeben zum Senden (Absender)
$query = $GLOBALS ['mysqli']->query ( "SELECT * from verification where user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
while ( $aFormValues = mysqli_fetch_array ( $query ) ) {
	$verify_id = $aFormValues ['verify_id'];
	$email = $aFormValues ['email'];
	$array_alert_mail [$verify_id] = "$email";
}


//Delete form status_los - Logsfiles oder then 2 Years
// $query = $GLOBALS ['mysqli']->query ( "delete from status_log where timestamp < now() - interval 2 YEAR" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
 //$query = $GLOBALS ['mysqli']->query ( "delete from logfile where timestamp < now() - interval 2 YEAR" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

// $query = $GLOBALS ['mysqli']->query ( "OPTIMIZE TABLE `status_log`" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

