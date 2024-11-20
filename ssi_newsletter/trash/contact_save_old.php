<?
// Zugangsdaten fuer die Datenbank
session_start ();
require_once ('../mysql.inc');

// Check ob Datenbanksatz bereits existiert
$exist_query_email = $GLOBALS['mysqli']->query ("SELECT COUNT(*) from contact WHERE user_id = '{$_SESSION['user_id']}' and email = '{$_POST['email']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) ); // and firstname = '{$_POST['firstname']}'
//$exist_query_email = $GLOBALS['mysqli']->query ( "SELECT * from contact WHERE user_id = '{$_SESSION['user_id']}' and email = '{$_POST['email']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$exist_array = mysqli_fetch_array ( $exist_query_email );
$check_contact_id = $exist_array['id'];

// wenn User in der Blacklist, wird diese nicht eingetragen
$blacklist_query_email = $GLOBALS['mysqli']->query ( "SELECT COUNT(*) from blacklist WHERE user_id = '{$_SESSION['user_id']}' and email = '{$_POST['email']}'" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$blacklist_array = mysqli_fetch_array ( $blacklist_query_email );
$check_black_id = $blacklist_array['black_id'];
if ($check_black_id) {
	$GLOBALS['mysqli']->query ( "DELETE from contact WHERE email = {$_POST['email']} " );
	$black_user ++;
	return;
}

if ($check_contact_id and $update)
	$_POST['contact_id'] = $check_contact_id;

if ($check_contact_id and ! $_POST['contact_id']) {
	$msg = "email_exists";
	$exist_user ++;
} else {
	
	if ($_POST['contact_id']) {
		
		if (! $update) {
			$add_mysql = "activate  = '{$_POST['activate']}',";
		} else
			$add_mysql = '';
			// Speichern der Daten in der Datenbank
			// email = '{
		
		$GLOBALS['mysqli']->query ( "UPDATE contact SET
		$add_mysql
		email     = '{$_POST['email']}',
		firstname = '{$_POST['firstname']}',
		secondname= '{$_POST['secondname']}',
		sex       = '{$_POST['sex']}',
		title     = '{$_POST['title']}',
		birth     = '{$_POST['birth']}',
		company_1  = '{$_POST['company_1']}',
		company_2  = '{$_POST['company_2']}',
		street    = '{$_POST['street']}',
		zip       = '{$_POST['zip']}',
		city      = '{$_POST['city']}',
		country   = '{$_POST['country']}'
		WHERE id = {$_POST['contact_id']}
		" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$contact_id = $_POST['contact_id'];
		$_POST['firstname'] = '';
		$_POST['secondname'] = '';
		$_POST['sex'] = '';
		$_POST['birth'] = '';
	} else {
		
		// Speichern der Daten in der Datenbank
		$GLOBALS['mysqli']->query ( "INSERT INTO contact SET
		user_id   = '{$_SESSION['user_id']}',
		email     = '{$_POST['email']}',
		firstname = '{$_POST['firstname']}',
		secondname= '{$_POST['secondname']}',
		sex       = '{$_POST['sex']}',
		title     = '{$_POST['title']}',
		birth     = '{$_POST['birth']}',
		activate  = '{$_POST['activate']}',
		company_1 = '{$_POST['company_1']}',
		company_2 = '{$_POST['company_2']}',
		street    = '{$_POST['street']}',
		zip       = '{$_POST['zip']}',
		city      = '{$_POST['city']}',
		country   = '{$_POST['country']}',
		reg_date  = NOW()
		" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$contact_id = mysqli_insert_id ($GLOBALS['mysqli']);
	}
	if (! $import_contact)
		// Grupppen verknuepfen
		$GLOBALS['mysqli']->query ( "DELETE FROM contact2group where contact_id = '$contact_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	
	if (is_array ( $_POST['groups'] )) {
		foreach ( $_POST['groups'] as $group_value ) {
			// Gruppen neu setzen
			$GLOBALS['mysqli']->query ( "REPLACE INTO contact2group (`group_id`, `contact_id`, `activate`) VALUES ('$group_value','$contact_id','1')" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
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