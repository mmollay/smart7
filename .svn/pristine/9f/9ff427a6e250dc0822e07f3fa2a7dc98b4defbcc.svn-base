<?php
// Erzeugt erste Inputs für Module (Newsletter)
function generate_first_insert($user_id, $db) {
	// Aufrufen der Userdaten für den SSI_Newsletter
	$query = $GLOBALS['mysqli']->query ( "SELECT * FROM ssi_company.user2company WHERE user_id = '$user_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$array = mysqli_fetch_array ( $query );
	$firstname = $array['firstname'];
	$secondname = $array['secondname'];
	$sender_email = $array['user_name'];
	$gender = $array['sex'];
	
	// Prüfen ob bereits ein Input vorhanden ist legt gegebenfalls ersten Tag an
	$query = $GLOBALS['mysqli']->query ( "SELECT * FROM $db.tag WHERE user_id = '$user_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	if (! mysqli_num_rows ( $query )) {
		$GLOBALS['mysqli']->query ( "INSERT INTO $db.tag SET user_id = '$user_id', title = 'Alle' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$tag_id = mysqli_insert_id ($GLOBALS['mysqli']);
	} // Holt die letzt hinzugefügte Tag_ID
else {
		$query = $GLOBALS['mysqli']->query ( "SELECT tag_id FROM $db.tag WHERE user_id = '$user_id' order by tag_id desc Limit 1 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$array = mysqli_fetch_array ( $query );
		$tag_id = $array['tag_id'];
	}
	
	// Sender anlegen und Verifizierung eintragen
	$query = $GLOBALS['mysqli']->query ( "SELECT id FROM $db.sender WHERE user_id = '$user_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	if (! mysqli_num_rows ( $query )) {
		$GLOBALS['mysqli']->query ( "INSERT INTO $db.sender
		SET
		user_id = '$user_id',
		test_email = '$sender_email',
		from_email = '$sender_email',
		from_name = '$firstname $secondname'
		" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$sender_id = mysqli_insert_id ($GLOBALS['mysqli']);
		
		// Verifizierung
		$verify_key = md5 ( uniqid ( rand (), TRUE ) );
		$GLOBALS['mysqli']->query ( "INSERT INTO $db.verification SET
		user_id = '$user_id',
		email   = '$sender_email',
		verify_key = '$verify_key',
		checked = '1',
		ip      = '{$_SERVER['REMOTE_ADDR']}'
		" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	}
	
	// CHECK ob User bereits im System ist
	$query = $GLOBALS['mysqli']->query ( "SELECT contact_id FROM $db.contact WHERE user_id = '$user_id' AND email = '$sender_email' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	if (! mysqli_num_rows ( $query )) {
		// Ersten Kontakt anlegen
		$GLOBALS['mysqli']->query ( "INSERT INTO $db.contact SET
		user_id = '$user_id',
		activate  = '1',
		email     = '$sender_email',
		firstname = '$firstname',
		secondname= '$secondname',
		sex       = '$gender'
		" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$contact_id = mysqli_insert_id ($GLOBALS['mysqli']);
		$GLOBALS['mysqli']->query ( "REPLACE INTO $db.contact2tag (`tag_id`, `contact_id`, `activate`) VALUES ('$tag_id','$contact_id','1')" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	}
	
	// Setting setzen
	$GLOBALS['mysqli']->query ( "REPLACE INTO $db.setting SET
	user_id = '$user_id',
	default_from_id = '$sender_id',
	delivery_system = 'mailjet'
	" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	
	include (__DIR__ . '/../ssi_newsletter/lang/de.php');
	$fields = "
	matchcode = 'Webseiten-Formular',
	description = 'User die sich übrer die Webseite eingetragen haben.',
	emailtitle_reg = '$emailtitle_reg',
	emailtext_reg = '$emailtext_reg',
	emailtitle_reg_success = '$emailtitle_reg_success',
	emailtext_reg_success = '$emailtext_reg_success',
	from_id = '$sender_id',
	link_reg = '$link_reg',
	text_reg = '$text_reg',
	text_reg_success = '$text_reg_success',
	link_reg_success = '$link_reg_success',
	text_user_exists_inactive = '$text_user_exists_inactive',
	text_user_exists_active = '$text_user_exists_active',
	text_user_exists_set_inactive = '$text_user_exists_set_inactive',
	text_promotion_codes_used_up = '$text_promotion_codes_used_up'
	";
	
	$camp_key = md5 ( uniqid ( rand (), TRUE ) );
	$GLOBALS['mysqli']->query ( "INSERT INTO $db.formular SET camp_key = '$camp_key', user_id = '$user_id', $fields " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$form_id = mysqli_insert_id ($GLOBALS['mysqli']);
	$GLOBALS['mysqli']->query ( "REPLACE INTO $db.formular2tag SET form_id = '$form_id', tag_id = '$tag_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	
	$GLOBALS['mysqli']->query ( "INSERT INTO $db.followup_pool SET matchcode = 'Gratis Ebook Follow-Up', user_id = '$user_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
}