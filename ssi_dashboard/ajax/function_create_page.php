<?php
// Prüft Gültigkeit der Domain
function is_valid_domain_name($domain_name) {
	return (preg_match ( "/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name ) && // valid chars check
preg_match ( "/^.{1,253}$/", $domain_name ) && // overall length check
preg_match ( "/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name )); // length of each label
}

//Neue Webseite erzeugen
function generate_newpage($user_id, $domain, $template_id) {
    
	// Auslesen ob privat oder pubic ist
	$public_query = $GLOBALS['mysqli']->query ( "SELECT set_public FROM smart_templates WHERE template_id ='$template_id'" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
	$public_fetch = mysqli_fetch_array ( $public_query );
	$set_public = $public_fetch['set_public'];
	
	if ($set_public)
		$template_path = $_SESSION['path_template'] . "/public/$template_id";
	else
		$template_path = $_SESSION['path_template'] . "/private/$template_id";
	
	if ($template_id) {
		// Vorlage umwandeln zu einer neuen Seite
		include ('create_page.php');
		
		// Domain mit Page verknuepfen
		$GLOBALS['mysqli']->query ( "UPDATE smart_page SET smart_domain  = '$domain' WHERE page_id = '$page_id' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
	
		$stmt = $GLOBALS['mysqli']->prepare("INSERT INTO ssi_company.domain (company_id, user_id, page_id, domain) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("iiis", $_SESSION['company_id'], $user_id, $page_id, $domain);
		$stmt->execute() or die(mysqli_error($GLOBALS['mysqli']));
		
		
		//Page ID festlegen und und als Session so wie Cookie speichern
		$_SESSION['page_id'] = $_SESSION['smart_page_id'] = $_SESSION['new_page_id'] = $page_id;
		setcookie ( "smart_page_id", $_SESSION['smart_page_id'], time () + 60 * 60 * 24 * 365, '/', $_SERVER['HTTP_HOST'] );
		
		$path = "../../" . $_SESSION['path_user'] . "/user$user_id";
		// Folder anlegen
		exec ( "mkdir ../../" . $_SESSION['path_user'] );
		exec ( "mkdir $path" );
		exec ( "mkdir $path/explorer" );
		exec ( "mkdir $path/gallery" );
		exec ( "mkdir $path/explorer/$page_id" );
		exec ( "cp -rf $template_path/explorer/* $path/explorer/$page_id/" ); // Page_id wird aus dem "create_page.php" ausgelesen
		/*
		echo "cp -rf $template_path/explorer/* ../../users/user$user_id/explorer/$page_id/";
		nur smart - version erzeugen
		*/
		
		fu_virtualhost_generator ( $_SESSION['company_id'] );
		return 'ok';
	}
}

/*
 * Wert auslesen und umwandeln fuer das speichern der Daten in der db
 */
function callback($matches) {
	global $output;
	
	$arr = preg_split ( '/>/', $matches[2] );
	$name = $arr[0];
	
	if (preg_match ( '/new/', $name )) {
		$new = 1;
		$name = preg_replace ( "/new_/", "", $name );
	}
	$id = $arr[1];
	
	// Page_id speichern zur weotern Verarbeitung
	if ($name == 'page_id')
		$GLOBALS['page_id'] = $id;
	
	if ($new) {
		$GLOBALS['insert_id_name'] = $name . "_" . $id;
		return "'";
	} // Wenn keine ID vorhanden ist, wird der Wert 0 gesetzt
elseif (! $id) {
		return "'";
	} elseif ($name == 'user_id')
		return "set_user_id'";
	else
		return $name . "_" . $id . "'";
}

/*
 * Ruft die Verknüpfungen vom Wizard auf
 * Vorname, Nachname, Texte
 * Ersetzt worden durch $output = preg_replace ( '!{%(.*?)%}!e', '$array_user[ \1 ]', $output );
 */
// function callback_wizard($matches) {
// $query = $GLOBALS['mysqli']->query ( "SELECT * from ssi_company.user2company WHERE user_id = '{$_SESSION['user_id']}' " );
// $array = mysqli_fetch_array ( $query );
// if ($matches[1] == 'name')
// return $array['firstname'] . " " . $array['secondname'];
// if ($matches[1] == 'firstname')
// return $array['firstname'];
// if ($matches[1] == 'secondname')
// return $array['secondname'];
// if ($matches[1] == 'email')
// return $array['user_name'];
// if ($matches[1] == 'verify_key')
// return $array['verify_key'];
// }