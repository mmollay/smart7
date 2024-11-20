<?
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

// Check ob Datenbanksatz bereits existiert
$exist_query_email = $GLOBALS ['mysqli']->query ( "SELECT * from contact WHERE user_id = '{$_SESSION['user_id']}' and email = '{$_POST['email']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) ); // and firstname = '{$_POST['firstname']}'
// $exist_query_email = $GLOBALS['mysqli']->query ( "SELECT * from contact WHERE user_id = '{$_SESSION['user_id']}' and email = '{$_POST['email']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$exist_array = mysqli_fetch_array ( $exist_query_email );
$check_contact_id = $exist_array ['contact_id'];

// wenn User in der Blacklist, wird diese nicht eingetragen
$blacklist_query_email = $GLOBALS ['mysqli']->query ( "SELECT * from blacklist WHERE user_id = '{$_SESSION['user_id']}' and email = '{$_POST['email']}'" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
$blacklist_array = mysqli_fetch_array ( $blacklist_query_email );
$check_black_id = $blacklist_array ['black_id'];
if ($check_black_id) {
	$GLOBALS ['mysqli']->query ( "DELETE from contact WHERE email = {$_POST['email']} " );
	$black_user ++;
	return;
}

if ($check_contact_id and $update)
	$_POST ['contact_id'] = $check_contact_id;

if ($check_contact_id and ! $_POST ['contact_id']) {
	$msg = "email_exists";
	$exist_user ++;
} else {

	$add_mysql = '';

	// erzeugen von mysql_add für die einzelnen Felder
	foreach ( $array_import as $key => $value ) {
		if ($add_mysql)
			$add_mysql .= ',';
		$add_mysql .= " $key = '{$_POST[$key]}' ";
		$_POST [$key] = '';
	}

	if ($_POST ['contact_id']) {

		if (! $update) {
			$add_mysql1 = "activate  = '{$_POST['activate']}',";
		} else
			$add_mysql1 = '';

		// UPDATE der Daten in der Datenbank
		$GLOBALS ['mysqli']->query ( "UPDATE contact SET $add_mysql1$add_mysql WHERE contact_id = '{$_POST['contact_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		$contact_id = $_POST ['contact_id'];
	} else {

		// Speichern der Daten in der Datenbank
		$GLOBALS ['mysqli']->query ( "INSERT INTO contact SET $add_mysql,user_id = '{$_SESSION['user_id']}', reg_date = NOW() " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		$contact_id = mysqli_insert_id ( $GLOBALS ['mysqli'] );
	}

	//remove all tags from user, after save contact or after import contacts if remove all tags ist checked
	if (! $import_contact or $_POST ['remove_all_tags'])
		// Grupppen verknuepfen
		$GLOBALS ['mysqli']->query ( "DELETE FROM contact2tag where contact_id = '$contact_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

	if (is_array ( $_POST ['groups'] )) {
		foreach ( $_POST ['groups'] as $group_value ) {
			// Gruppen neu setzen
			$GLOBALS ['mysqli']->query ( "REPLACE INTO contact2tag (`tag_id`, `contact_id`, `activate`) VALUES ('$group_value','$contact_id','1')" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		}
	}

	//Zuweisung der User zu der jeweilign Followup-Mail falls vorhanden
	generate_new_session ( $contact_id, $cfg );

	if ($_POST ['contact_id']) {
		$msg = 'ok';
		$updated_user ++;
		$_POST ['contact_id'] = '';
	} else {
		$msg = 'ok new';
		$new_user ++;
	}
}

// Anzeigen der Info wenn von Kontaktseite aus verändert wird
if (! $import_contact)
	echo $msg;
?>