<?
// FAKTURA
// Zugangsdaten fuer die Datenbank
// session_start ();
// require_once ('../mysql.inc');

// Check ob Datenbanksatz bereits existiert
$exist_query_email = $GLOBALS['mysqli']->query ( "SELECT * from client WHERE email = '{$_POST['email']}'  AND user_id = $user_id" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
$exist_array = mysqli_fetch_array ( $exist_query_email );
$check_contact_id = $exist_array['client_id'];



if ($check_contact_id and $update)
	$_POST['contact_id'] = $check_contact_id;

if ($check_contact_id and ! $_POST['contact_id']) {
	$msg = "email_exists";
	$exist_user ++;
} else {
	$add_mysql = '';
	
	if (! $_POST['client_number']) {
		// Clientnumber Generator
		$_POST['client_number'] = mysql_singleoutput ( "SELECT MAX(client_number) as client_number FROM client ", "client_number" ) + 1;
	}
	
	// erzeugen von mysql_add für die einzelnen Felder
	foreach ( array_keys ( $array_import ) as $key ) {
		if ($add_mysql)
			$add_mysql .= ',';
		$add_mysql .= " $key = '{$_POST[$key]}' ";
		$_POST[$key] = '';
	}
	
	// UPDATE
	if ($_POST['contact_id']) {
		
		$GLOBALS['mysqli']->query ( "UPDATE client SET $add_mysql WHERE client_id = '{$_POST['contact_id']}'
		" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
		$contact_id = $_POST['contact_id'];
	} else {
		
		// Speichern der Daten in der Datenbank
		$GLOBALS['mysqli']->query ( "INSERT INTO client SET reg_date  = NOW(), user_id = '$user_id', company_id = '{$_SESSION['company_id']}', map_user_id = '$user_id', $add_mysql" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
		$contact_id = mysqli_insert_id ( $GLOBALS['mysqli'] );
	}
	
	if ($_POST['contact_id']) {
		$msg = 'ok';
		$updated_user ++;
		$_POST['contact_id'] = '';
	} else {
		$msg = 'ok new';
		$new_user ++;
	}
}
// Anzeigen der Info wenn von Kontaktseite aus verändert wird
if (! $import_contact)
	echo $msg;
?>