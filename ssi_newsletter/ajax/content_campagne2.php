<?php
/**
 * SendNewsletter.inc - Speichern des Newsletters in der Datenbank
 *
 * @author Martin Mollay
 * @last-changed 2016-11-19 (MM) added SMTP-Server config
 *
 */
// Wenn Email von Followup automatisch erzeugt wird, wird config nicht benötigt
if (! isset ( $followup_id )) {
	require (__DIR__ . '/../config.inc.php');
}

foreach ( $_POST as $key => $value ) {
	// $GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
	$GLOBALS [$key] = $value;
}

if (! $user_id)
	$user_id = $_SESSION ['user_id'];

if ($update_id_first)
	$update_id = $update_id_first;
elseif ($session_id)
	$update_id = $session_id;

$upload_dir = "/var/www/ssi/smart_users/ssi/user$user_id/newsletter/";

/**
 * *****************************************************************
 * Content waerend und nach dem Versenden von Newslettern
 * *****************************************************************
 */

// Parameter werden aus der Datenbank ausgelesen
$query = $GLOBALS ['mysqli']->query ( "SELECT * from sender where user_id = '$user_id' AND id = '$from_id'" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
$aFormValues = mysqli_fetch_array ( $query );
$from_id = $aFormValues ['id'];
$setFromName = $aFormValues ['from_name'];
$setFromEmail = $aFormValues ['from_email'];
$setReplayName = $aFormValues ['replay_name'];
$setReplayEmail = $aFormValues ['replay_email'];
$setReturnPath = $aFormValues ['error_email'];
$setReportEmail = $aFormValues ['report_email'];
$smtp_server = $aFormValues ['smtp_server'];
$smtp_user = $aFormValues ['smtp_user'];
$smtp_password = $aFormValues ['smtp_password'];
$smtp_port = $aFormValues ['smtp_port'];
$smtp_secure = $aFormValues ['smtp_secure'];
$setTestEmail = $aFormValues ['test_email'];
$label_id = $aFormValues ['label_id'] ?? 0;

// if (! $text) {
// echo "Kein Text vorhanden";
// return;
// }

// löschen bestehender Einträge in den Logs // wird bei Update benötigt!
$GLOBALS ['mysqli']->query ( "DELETE from logfile WHERE session_id = '{$update_id}' " );

/**
 * ********************************************************
 * Auslesen der zugewiesenen Contacts aus den Tags aus der Datenbank
 * ********************************************************
 */
if ($tag_id) {
	// $array erzeugens
	$array_tag_id = explode ( ',', $tag_id );
	$array_tag_id_minus = explode ( ',', $tag_id_minus );

	// Fasst alle Gruppen zusammen
	foreach ( $array_tag_id as $tag_value ) {
		if ($and_tag)
			$and_tag .= "OR ";
		$and_tag .= "contact2tag.tag_id = '$tag_value' ";
	}

	// Schließt bestimmte Gruppen aus
	foreach ( $array_tag_id_minus as $tag_value2 ) {
		if ($tag_value2) {
			if ($nand_tag)
				$nand_tag .= "OR ";
			$nand_tag .= "contact2tag.tag_id = '$tag_value2' ";
		}
	}

	$sql = "SELECT contact.contact_id FROM `contact` LEFT JOIN contact2tag ON contact2tag.contact_id = contact.contact_id  WHERE ($and_tag ) 
			AND user_id = '{$_SESSION['user_id']}'
			AND contact.activate ='1'  ";

	if ($nand_tag)
		$sql .= "AND !(SELECT COUNT(*) FROM contact2tag WHERE contact2tag.contact_id = contact.contact_id AND ($nand_tag) )";

	$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $fetch_array = mysqli_fetch_array ( $query ) ) {
		$array_tag_user [] = $fetch_array ['contact_id'];
	}
}

/**
 * ***********************************************************************************
 * Einzelne User werden ausgelesen der ausgeschlossen
 * Wenn nur ein User ausgelesen werden soll - Followup-Mails (Bsp.: 24h oder 3 Tage)
 * ************************************************************************************
 */

// beide Werte werden zum speichern in der DB benötigt
$db_array_contact_id = $array_contact_id;
$db_array_contact_id_minus = $array_contact_id_minus;

if (! is_array ( $array_contact_id )) {
	$array_contact_id = array_filter ( explode ( ',', $array_contact_id ) );
}

if ($array_tag_user and $array_contact_id) {
	// Einzelkontakte mit Tag zusammenführen
	$array_contact_id = array_merge ( $array_tag_user, $array_contact_id );
} elseif ($array_tag_user) {
	$array_contact_id = $array_tag_user;
}

// Minus - Einzelkontakte auslesen
if ($array_contact_id_minus and $array_contact_id) {
	$array_contact_id_minus = explode ( ',', $array_contact_id_minus );

	// Diese werden daus der contactliste herausgelöscht
	$array_contact_id = array_diff ( $array_contact_id, $array_contact_id_minus );
}

if ($array_contact_id) {
	// Doppeleinträge entfernen
	$array_contact_id = array_unique ( $array_contact_id );
} else {
	echo "no_contacts";
	exit ();
}

// Anzahl der zu versendeten Emails
$email_count = count ( $array_contact_id );

if ($followup_id && is_dir ( "$upload_dir/$followup_url" )) {
	// followup_path
	$folder_size = dirSize ( "$upload_dir/$followup_url" );
} elseif ($upload_dir && $update_id && is_dir ( "$upload_dir/$update_id" )) {
	$folder_size = dirSize ( "$upload_dir/$update_id" );
}
else $folder_size = 0;

$followup_id = $followup_id ?? 0;

// Abruf welches Mailsystem verwendet wird
$query_system = $GLOBALS ['mysqli']->query ( "SELECT * from setting WHERE user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
$array_system = mysqli_fetch_array ( $query_system );
$delivery_system = $array_system ['delivery_system'];

$without_footline = $without_footline ?? 0;

$sql = "REPLACE INTO session SET
	session_id = '$update_id',
	user_id = '$user_id', 
	counter = '$email_count',
	title   = '$title',
	text    = '$text',
	modus   = 'html',
	from_name = '$setFromName',
	from_email = '$setFromEmail',
	replay_name = '$setReplayName',
	replay_email = '$setReplayEmail',
	error_email = '$setReturnPath',
	report_email = '$setReportEmail',
	size = '$folder_size',
	smtp_server  = '$smtp_server',
	smtp_user    = '$smtp_user',
	smtp_password= '$smtp_password',
	smtp_port    = '$smtp_port', 
	smtp_secure  = '$smtp_secure',
	sender_id    = '$from_id',
	label_id     = '$label_id',
	tag_id     = '$tag_id',
	tag_id_minus = '$tag_id_minus',
	from_id      = '$from_id',
	test_email   = '$setTestEmail',
	status       = '2',
	followup_id = '$followup_id',
	without_footline = '$without_footline',
	send_date = '$send_date $send_time',
	send_auto = '$send_auto',
	all_user = '$all_user',
	allow_email_duplicate = '$allow_email_duplicate',
	delivery_system = '$delivery_system',
	array_contact_id = '$db_array_contact_id',
	array_contact_id_minus = '$db_array_contact_id_minus',
	`release` = 0,
	remove_nl = 0 
";

// SESSION wird gestartet
$GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

$session_id = mysqli_insert_id ( $GLOBALS ['mysqli'] );

foreach ( $array_contact_id as $value ) {

	// auslesen der Wert Kontaktdaten
	$columns = call_data_user ( $value );

	// mm@ssi.at 31.12.2012 -> Es werden samthaft keine "Abbestellen angezeigt"
	if ($_POST ['without_footline'] or $_POST ['all_user'])
		$columns ['without_footline'] = 1;
	if ($columns ['email']) {
		// Logfile anlegen
		$GLOBALS ['mysqli']->query ( "INSERT INTO logfile SET
		session_id = '$session_id', 
		client_id = '$value',
		email = '{$columns['email']}',
		firstname = '{$columns['firstname']}',
		secondname = '{$columns['secondname']}',
		title = '{$columns['title']}',
		sex  = '{$columns['sex']}',
		company_1 = '{$columns['company_1']}',
		company_2 = '{$columns['company_2']}',
		street = '{$columns['street']}',
		city = '{$columns['city']}',
		zip = '{$columns['zip']}',
		country = '{$columns['country']}',
		birth   = '{$columns['birth']}',
		verify_key = '{$columns['verify_key']}',
		modul = '{$columns['modul']}',
		client_number = '{$columns['client_number']}',
		placeholder1 = '{$columns['placeholder1']}',
		placeholder2 = '{$columns['placeholder2']}',
		placeholder3 = '{$columns['placeholder3']}',
		no_unsubscribe = '{$columns['no_unsubscribe']}',
		without_footline = '{$columns['without_footline']}'
		" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	}
}

if ($generate_manuell)
	echo "ok";
