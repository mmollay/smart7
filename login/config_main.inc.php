<?php
error_reporting ( E_ERROR | E_PARSE );
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
//ini_set('error_log', __DIR__.'fehlerprotokolldatei.log');

session_start ();
require_once (__DIR__ . '/../vendor/autoload.php');
require_once (__DIR__ . '/function_security.php');
require_once (__DIR__ . '/../ssi_smart/php_functions/functions.php');
require_once (__DIR__ . '/../ssi_smart/admin/function.inc.php');

$_SESSION ['smart_version'] = "9.0(b)";

$document_root = '/var/www/ssi';
// Domains welche auf das Center zugreifen dürfen
$login_domain_array = array ('center.ssi.at','unicenter.ssi.at','develop.ssi.at','center-beta.ssi.at' );

$array_version = array ('stable' => 'Stable','beta' => 'Beta' );

/**
 * ********************************************
 * Email - Mail - Jet //DEFAULT
 * ********************************************
 */
include ('config_mail.php');
// Bei Uni-User Testung
// $unimode = 1;

/**
 * ********************************************
 * Config - Newsletter
 * ********************************************
 */
$cfg_mysql ['user_nl'] = 'smart';
$cfg_mysql ['password_nl'] = 'Eiddswwenph21;';
$cfg_mysql ['host_nl'] = 'localhost';
$cfg_mysql ['db_nl'] = 'ssi_newsletter2';

/**
 * ********************************************
 * Default - Datenbankverbindung
 * ********************************************
 */
// $company_id = 1; //Default - company_id
$cfg_mysql ['user'] = 'smart';
$cfg_mysql ['password'] = 'Eiddswwenph21;';

$cfg_mysql ['server'] = 'localhost';

$cfg_mysql ['db'] = 'ssi_smart1'; // Default db - SSI

$cfg_mysql ['db_nl'] = 'ssi_newsletter2'; // NEWSLETTER
$cfg_mysql ['db_map'] = 'ssi_fruitmap'; // FRUITMAP
$cfg_mysql ['db_bazar'] = 'ssi_bazar'; // BAZAR
$cfg_mysql ['db_21'] = 'ssi_21'; // 21Day
$cfg_mysql ['db_learning'] = 'ssi_learning'; // 21Day
$cfg_mysql ['db_faktura'] = 'ssi_faktura'; // Faktura (Default)
$cfg_mysql ['db_em'] = 'em_gemeinschaft'; // EM - Gemeinschaft

if ($unimode ?? false) {
	$cfg_mysql ['db'] = 'ssi_smart7'; // Default db - SSI
	$cfg_mysql ['db_faktura'] = 'ssi_faktura94'; // Faktura
	$_SERVER ['HTTP_HOST'] = $HTTP_HOST = 'unicenter.ssi.at';
}

// $cfg_mysql['db_faktura'] = 'ssi_faktura1287'; // Faktura

/**
 * ******************************************************************************
 * Verfügbare Module Module, werden je nach Company und deren User freigeschalten
 * ******************************************************************************
 */
$str_array_modules ['setting'] = 'Einstellungen';
$str_array_modules ['smart'] = 'Smart-Kit';
$str_array_modules ['construct'] = 'Constructor-Kit (alt)';
$str_array_modules ['newsletter'] = 'Newsletter';
$str_array_modules ['faktura'] = 'Faktura';
$str_array_modules ['kmlist'] = 'Km-Abrechnung';
$str_array_modules ['days21'] = '21 Days';
$str_array_modules ['userlist'] = 'Userlist';
$str_array_modules ['learning'] = 'Lernen';
$str_array_modules ['map'] = 'Fruit-Map';
$str_array_modules ['intuition'] = 'intuition';
$str_array_modules ['paneon'] = 'Paneon';
$str_array_modules ['trader'] = 'Trader';

$_SESSION ['date_default_timezone_set'] = 'Europe/Berlin';
// $_SESSION[date_default_timezone_set] = 'Europe/Athens';

date_default_timezone_set ( $_SESSION ['date_default_timezone_set'] );
/**
 * ***************************************************
 * COMPANY - Daten abrufen
 * ***************************************************
 */
$GLOBALS ['mysqli'] = new mysqli ( $cfg_mysql ['server'], $cfg_mysql ['user'], $cfg_mysql ['password'], 'ssi_company' ) or die ( "Could not open connection to server {$cfg_mysql['server']}" );

if ($first_install ?? false)
	return;

if (in_array ( $_SERVER ['HTTP_HOST'], $login_domain_array )) {
	// Prüft Domains auf Zugriffsrechte
	if (! $HTTP_HOST)
		$HTTP_HOST = 'center.ssi.at';
	// Abruf der Company_id
	$company_id = call_company_id ( $HTTP_HOST );
} elseif ($_SERVER ['HTTP_HOST'] == 'develop.ssi.at') {
	// Diese Domain ist für den Entwicklungsserver
	$HTTP_HOST = 'center2.ssi.at';
	$_SESSION ['develop_mode'] = true;
	$document_root = '/var/www/develop';
	$company_id = 1;
} elseif ($_SERVER ['HTTP_HOST'] == 'localhost') {
	// Zum testen am localhost (Test-Rechner)
	$company_id = 1;
	$_SESSION ['develop_mode'] = true;
	$HTTP_HOST = 'center.ssi.at';
	// /$HTTP_HOST = 'www.ssi.at';
} else {
	$HTTP_HOST = $_SERVER ['HTTP_HOST'];
	// Neue Version geht mit allen Domains mit SSL - Zertifikat
	$company_id = call_company_id_v2 ( $HTTP_HOST );
	// Wenn Domain nicht vorkommt wird überprüft ob es sich um eine eingetragene im System handelt "center.xxx.at"
	if (! $company_id) {
		$HTTP_HOST = $_SERVER ['HTTP_HOST'];
		$company_id = call_company_id ( $HTTP_HOST );
	}
}

// Wenn kein Company_id nicht existiert wird abgebrochen
if (! $company_id) {
	$abortpage ['message'] = "Die Domain \"" . $HTTP_HOST . "\" hat keine Zugriffsrechte.<br> Bitte wenden Sie sich an den Administratior!<br><a href = 'https://www.ssi.at'>www.ssi.at</a>";
	$abortpage ['class'] = "message error";
	include (__DIR__ . '/../pages/error.php');
	exit ();
}

// Auslesen der Option-Daten Der Company
$array_company = call_company_option ( $company_id );

$_SESSION ['db_smartkit'] = $array_company ['db_smartkit'];
$_SESSION ['company'] = $array_company ['matchcode'];
$_SESSION ['company_title'] = $array_company ['title'];
$_SESSION ['company_id'] = $company_id;
$_SESSION ['smart_company_id'] = $company_id;

$_SESSION ['array_superuser_id'] = array ($array_company ['superuser_id'] );
$_SESSION ['path_template'] = $path_template = "/var/www/templates/smart/{$_SESSION['company']}/"; // TODO: wird Durch ID getauscht (bsp.: ../../templates/smart/3/
$_SESSION ['path_user'] = "/smart_users/{$_SESSION['company']}/"; // TODO: wird Durch ID getauscht (bsp.: ../../templates/smart/3/

$_SESSION['MailConfig']['return_path'] = $array_company['smtp_email'] ?? null;
$_SESSION['MailConfig']['from_email'] = $array_company['smtp_email'] ?? null;
$_SESSION['MailConfig']['from_title'] = $array_company['smtp_title'] ?? null;
$_SESSION['MailConfig']['smtp_host'] = $MailConfig['smtp_host'] ?? null;
$_SESSION['MailConfig']['smtp_user'] = $MailConfig['smtp_user'] ?? null;
$_SESSION['MailConfig']['smtp_password'] = $MailConfig['smtp_password'] ?? null;
$_SESSION['MailConfig']['smtp_port'] = $MailConfig['smtp_port'] ?? null;
$_SESSION['MailConfig']['smtp_secure'] = $MailConfig['smtp_secure'] ?? null;
// Mailjet
$_SESSION['MailConfig']['mailjet_smtp_user'] = $MailConfig['mailjet_smtp_user'] ?? null;
$_SESSION['MailConfig']['mailjet_smtp_password'] = $MailConfig['mailjet_smtp_password'] ?? null;


$_SESSION ['mysql'] ['db'] = $_SESSION ['db_smartkit'];
$_SESSION ['mysql'] ['user'] = $cfg_mysql ['user'];
$_SESSION ['mysql'] ['password'] = $cfg_mysql ['password'];
$_SESSION ['mysql'] ['server'] = $cfg_mysql ['server'];

// NEWSLETTER
$_SESSION ['mysql'] ['db_nl'] = $cfg_mysql ['db_nl'];

// FRUITMAP
$_SESSION ['mysql'] ['db_map'] = $cfg_mysql ['db_map'];

// BAZAR
$_SESSION ['mysql'] ['db_bazar'] = $cfg_mysql ['db_bazar'];

// 21Day
$_SESSION ['mysql'] ['db_21'] = $cfg_mysql ['db_21'];

// Learning
$_SESSION ['mysql'] ['db_learning'] = $cfg_mysql ['db_learning'];

// Learning
$_SESSION ['mysql'] ['db_faktura'] = $cfg_mysql ['db_faktura'];

// EM-Gemeinschaft
$_SESSION ['mysql'] ['db_em'] = $cfg_mysql ['db_em'];

// recaptcha for pages
$_SESSION ['recaptcha'] ['site_key'] = '6LfEMPoSAAAAAPhkGpA8prIoj8NG1EZluwvdo-7i';
$_SESSION ['recaptcha'] ['secret_key'] = '6LfEMPoSAAAAAEGZnkWPkgCTNWBzFGzg05Pi6QYL';

if (isset($_COOKIE ["smart_page_id"]))
	$_SESSION ['smart_page_id'] = $_COOKIE ["smart_page_id"];

if (isset($_COOKIE ["site_id"]))
	$_SESSION ['site_id'] = $_COOKIE ["site_id"];

if (! $_SESSION ['page_lang'])
	$_SESSION ['page_lang'] = 'de';

// FÜR PRÄSENTATION
// $company_domain_list = array ('em-gemeinschaft.at' => 'em-gemeinschaft.at', 'ssi.at' => "ssi.at" , "wnn.at" => "wnn.at" );

unset ( $_SESSION ['set_module'] );
$superuser_passwd = $array_company ['company_password'];

mysqli_select_db ( $GLOBALS ['mysqli'], $_SESSION ['db_smartkit'] ) or die ( 'Could not select database 24373577' . $_SESSION ['db_smartkit'] );

// Wird beim umstellen auf mysqli ausgeschaltet
// mysql_select_db ( $_SESSION['db_smartkit'] ) or die ( 'Could not select database ' . $_SESSION['db_smartkit'] );

// mysql_set_charset('utf8');

if (isset($_GET['user_name']) && isset($_GET['password'])) {
	// BEI manuellen einloggen über die Liste, nur bei Superadmin
	$_POST ['user'] = $_GET ['user_name'];
	$_POST ['password'] = $_GET ['password'];
	$_POST ['password_md5'] = MD5 ( $_POST ['password'] );
	// now validating the username and password
	$sql = "SELECT verify_key FROM ssi_company.user2company WHERE user_name='{$_POST['user']}' and
	( password='{$_POST['password_md5']}' or password = '{$_POST['password']}' )";

	$query = $GLOBALS ['mysqli']->query ( $sql );
	$fetch = mysqli_fetch_array ( $query );
	$_SESSION ['verify_key'] = $fetch ['verify_key'];
	setcookie ( "verify_key", $_SESSION ['verify_key'], time () + 60 * 60 * 24 * 365, '/', $_SERVER ['HTTP_HOST'] );
} elseif (isset($_GET ['verify_key'])) {
	// Setzt den User auf verifiziert
	$_SESSION ['verify_key'] = $_SESSION ['set_verify_key'] = $_GET ['verify_key'];
	setcookie ( "verify_key", $_SESSION ['verify_key'], time () + 60 * 60 * 24 * 365, '/', $_SERVER ['HTTP_HOST'] );
} elseif ($_COOKIE ["verify_key"] && ! $_SESSION ['verify_key']) {
	// Aktuelle Daten aus der Datenbank auslesen mit verify_key
	$_SESSION ['verify_key'] = $_COOKIE ["verify_key"];
}

$query = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_company.user2company WHERE verify_key = '{$_SESSION['verify_key']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
$array = mysqli_fetch_array ( $query );
$_SESSION ['user_id'] = $array ['user_id'];

$smart_version = $array ['smart_version'];
// Superuser kann nicht gesperrt werden, da dieser sonst kleinen Zugriff mehr auf die Config der Firma hat
if ($array_company ['superuser_id'] != $_SESSION ['user_id']) {
	$_SESSION ['service_offline'] = $array_company ['service_offline'];
	$_SESSION ['service_offline_reason'] = $array_company ['service_offline_reason'];
} else {
	$_SESSION ['service_offline'] = '';
}

// Prüft welche Module für welchen User sind
$_SESSION ['set_module'] = check_module4user ();

// Wenn der Wert als Session uebergeben wird wird dieser gesetzt
if (isset($_SESSION ['set_verify_key'])) {
	$verify_key = mysqli_real_escape_string ( $GLOBALS ['mysqli'], $_SESSION ['set_verify_key'] );
	$GLOBALS ['mysqli']->query ( "UPDATE  ssi_company.user2company SET user_checked = 1  WHERE verify_key = '$verify_key' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
}

$_SESSION ['user_verified'] = check_user_verification ();

// Count - Anzahl der Aufrufe
$GLOBALS ['mysqli']->query ( "UPDATE ssi_company.user2company SET login_count = login_count+1 WHERE user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

$user_id = $_SESSION ['user_id'];
$page_id = $_SESSION ['smart_page_id'];
$path_id_user = $_SESSION ['path_user'] . "user$user_id/"; // path_user siehe explorer
$path_page = "$path_id_user" . "page$page_id";

$path_page_relative = "smart_users/{$_SESSION['company']}/user$user_id/page$page_id";
$path_user_relative = "smart_users/{$_SESSION['company']}/user$user_id";
$path_id_explorer = "$path_id_user" . "explorer/";
$path_id_explorer_folder = $path_id_explorer . $page_id . '/';
$_SESSION ['HTTP_SERVER_FOLDER_DEFAULT'] = $_SERVER ['DOCUMENT_ROOT'] . $path_id_explorer_folder;
$_SESSION ['HTTP_SERVER_HOST_DEFAULT'] = $path_id_explorer_folder;
$_SESSION ['path_page_absolute'] = $_SERVER ['DOCUMENT_ROOT'] . $path_page_relative;
$_SESSION ['path_user_absolute'] = $_SERVER ['DOCUMENT_ROOT'] . $path_user_relative;

// Array - Zeitzone
// $timezone_identifiers = DateTimeZone::listIdentifiers();
$_SESSION ['set_module'] ['dashboard'] = true;

