<?php
// Verbindung zu Datenbank herstellen
include ('../../login/config_main.inc.php');
include ('../../ssi_userlist/fu_virtualhost_generator.php');
include ('function_create_page.php');

// Domain zusamen setzen
$domain = trim ( $_POST['subdomain'] . "." . $_POST['domain'] );

if (! is_valid_domain_name ( $domain )) {
	//echo "Die Domain <b>$domain</b> scheint ungültig zu sein.<br>Bitte keine Sonder & Leerzeichen verwenden.";
	echo "$('#ProzessBarBox').message({ type:'error',title:'Fehler', text: 'Die Domain <b>$domain</b> scheint ungültig zu sein.<br>Bitte keine Sonder & Leerzeichen verwenden.' });";
	return;
	exit ();
}

// Domain pruefen ob bereits in Datenbank vorhanden ist
$domain_check_query = $GLOBALS['mysqli']->query ( "SELECT domain FROM ssi_company.domain WHERE domain ='$domain'" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
// $domain_check_query = $GLOBALS['mysqli']->query ( "SELECT smart_domain FROM smart_page WHERE smart_domain ='$domain'" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$domain_check = mysqli_num_rows ( $domain_check_query );

// Meldung, dass Domain bereits vorhanden ist
if ($domain_check) {
	$error = 1;
	$output = "Domain bereits vergeben";
	
	// Wenn keine Vorlage existiert
} else if (! $_POST['template']) {
	$output = "Keine Vorlage verfügbar!";
} else {
	// Seite wird erzeugt
	ob_start(); //für das Speicher von Cookies notwendig, da es sonst einen Error gibt
    $output = generate_newpage ( $_SESSION['login_user_id'], $domain, $_POST['template'] );
	ob_end_flush();
}

if ($output == 'ok') {
	echo "$('.ui.modal.new_page').modal('hide');";
	echo "$('#ProzessBarBox').message({ type:'success',title:'Info', text: '<div align=\'center\'>Neue Seite wurde erzeugt!<br><br><div class=\'ui active centered inline loader\'></div><br>Weiterleitung erfolgt...</div>' });";
	echo "$(location).attr('href','../ssi_smart/index.php');";
} else {
	echo "$('#ProzessBarBox').message({ type:'error',title:'Fehler', text: '$output' });";
}