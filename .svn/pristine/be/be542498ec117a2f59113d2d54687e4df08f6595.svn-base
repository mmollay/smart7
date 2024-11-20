<?php
error_reporting(E_ALL ^  E_NOTICE);
include (__DIR__ . '/../functions.inc.php');

// call_session_logfile(41);
// exit;
// require_once ('../mysql.inc');
include ('../config_newsletter.php');
/* Einstellungen */
$sql_host = $cfg_mysql ['host_nl'];
$sql_user = $cfg_mysql ['user_nl'];
$sql_pass = $cfg_mysql ['password_nl'];
$sql_db = $cfg_mysql ['db_nl'];

$GLOBALS ['mysqli'] = $cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
mysqli_select_db ( $cfg, $sql_db ) or die ( 'Could not select database ' . $gaSql ['db'] );

// reset_error ( 60, $cfg);
// Schaltet automatisch startende Mails frei
mysqli_query ( $cfg, "UPDATE session SET status = 3 WHERE send_date < NOW() AND status = 2 AND send_auto = 1" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

/**
 * ******************************************************************
 * Erzeugen der Userlist welche Emails empfangen werden
 * *******************************************************************
 */

// Ruft einzelne Session auf
// Wenn diese durch setzen des Markers vergeben wurde wird die nächste angestossen (max 3 pro Server - vielleicht auch mehr) - check jede Min

$sql = "SELECT * FROM session WHERE `release` = 1
	AND (send_auto = 0 OR send_date < NOW())
 	AND remove_nl = 0
	AND (SELECT count(checked) from verification WHERE email = from_email AND session.user_id = user_id AND checked=1 ) = 1
		ORDER BY datetime_start LIMIT 10 ";

$query_session = mysqli_query ( $cfg, $sql );

while ( $send_session = mysqli_fetch_array ( $query_session ) ) {
	$session_id = $send_session ['session_id'];
	$user_id = $send_session ['user_id'];

	// Bei Session release auf 2 setzen damit Mails nicht nochmal versendet werden können
	mysqli_query ( $cfg, "UPDATE session SET `release` = 2 WHERE session_id = '$session_id' " );

	// Eintragung in Logfile
	log_insert ( $session_id, "Versendung gestartet" );

	/**
	 * *********************************************************************
	 * Sendet Newsletter von gewünschter SESSION
	 * *********************************************************************
	 */

	// Abruf welches Mailsystem verwendet wird
	$query_system = mysqli_query ( $cfg, "SELECT * from setting WHERE user_id = '$user_id'" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array_system = mysqli_fetch_array ( $query_system );
	$delivery_system = $array_system ['delivery_system'];

	// Auslesen des Company - Matchcodes für Attachment -pfad
	$comp_matchcode = call_company_matchcode ( $user_id, $cfg );
	if (! $comp_matchcode) {
		echo "Der Matchcode von der Company ist nicht definiert";
		exit ();
	}

	// http-host auslesen
	// function call_center_domain($user_id) {
	// $query = mysql_query ( "
	// SELECT center_domain
	// FROM ssi_company.user2company a
	// INNER JOIN ssi_company.tbl_company b ON a.company_id = b.company_id WHERE user_id = '$user_id' " );
	// $array = mysql_fetch_array ( $query );
	// return $array['center_domain'];
	// }

	// FEHLER: Scheinbar funktioniert, die Weiterleitung nicht bei jeden, center.ssi.at
	// mm@ssi.at 17.02.2017
	// Wandelt Link um für Tracking LP
	// $send_session['text'] = save_data_landingpage($session_id, $send_session['text'],call_center_domain($user_id));

	$query_logfile = mysqli_query ( $cfg, "
		SELECT id logfile_id, client_id, birth, modul, email, without_footline, firstname, secondname, sex, title, company_1, company_2, street, city, zip, country, verify_key, no_unsubscribe, client_number, placeholder1, placeholder2, placeholder3
		FROM logfile
			WHERE session_id = '$session_id' 
			AND email > ''
			AND `sendet` = 0
			AND !(SELECT count(email) from blacklist WHERE logfile.email = blacklist.email AND blacklist.user_id = user_id)
		" ) or die ( mysqli_error ( $cfg ) );
	while ( $send_array = mysqli_fetch_array ( $query_logfile ) ) {

		// Parameter auslesen
		include ('SendNewsletter_values.php');
		// Versendung starten
		include ('SendNewsletter_temp.php');
		$email_counter ++;

		/**
		 * **********************************************************************
		 * Erweiterung für Followup -> 09.Mai 2018 mm
		 * Check ob danach der User auf irgendetwas gesetzt werden soll
		 * Bsp.: Tag-Zuweisung oder Tag-Entwendung oder weitere Mail erzeugen
		 * **********************************************************************
		 */
		action_after_send ( $send_array ['client_id'], $send_session ['followup_id'], $cfg );
	}

	// Status auf Finale setzen
	mysqli_query ( $cfg, "UPDATE session SET status = 4, datetime_end = NOW() WHERE session_id = '$session_id' " ) or die ( mysqli_error ( $cfg ) );

	/*
	 * if ($email_counter)
	 * log_insert ( $session_id, "$email_counter Emails versendet" );
	 * else
	 * log_insert ( $session_id, "Keine Emails versendet" );
	 */

	if ($error_counter) {
		log_insert ( $session_id, "$error_counter fehlerhafte Sendungen festgestellt", "error" );
	}

	// Prüft die Anzahl Fehlerhafter Mails
	$query = mysqli_query ( $cfg, "SELECT * FROM logfile WHERE session_id = '$session_id' AND `error` = 1" ) or die ( mysqli_error ( $cfg ) );
	$count_error = mysqli_num_rows ( $query );

	// Prüft die Anzahl der guten Mails
	$query = mysqli_query ( $cfg, "SELECT * FROM logfile WHERE session_id = '$session_id' AND `mail_info` = 'ok' " ) or die ( mysqli_error ( $cfg ) );
	$count_ok = mysqli_num_rows ( $query );

	// log_insert ( $session_id, "Aussendung abgeschlossen" );
	if ($count_error == 1)
		log_insert ( $session_id, "$count_error fehlerhafte Aussendung", "error" );
	elseif ($count_error)
		log_insert ( $session_id, "$count_error fehlerhafte Aussendungen", "error" );

	if ($count_ok == 1)
		log_insert ( $session_id, "$count_ok erfolgreich versendete Aussendung", "success" );
	elseif ($count_ok)
		log_insert ( $session_id, "$count_ok erfolgreich versendete Aussendungen", "success" );
	// }

	// ANZEIGEN des Sendeprotokolls
	call_session_logfile ( $session_id, $cfg );
}

if (! $session_id)
	echo "Keine Versendung vorhanden";

/**
 * *************************************************************************************
 * Logfile erzeugen
 * *************************************************************************************
 */
function log_insert($id, $text, $type = 'info') {
	global $cfg;
	mysqli_query ( $cfg, "INSERT INTO session_logfile SET session_id = '$id', text = '$text', type = '$type'  " ) or die ( mysqli_error ( $cfg ) );
}

/**
 * *************************************************************************************
 * Setzt den Status nicht gesendeter fehlerhaften Emails zurück
 * *************************************************************************************
 */
function reset_error($session_id, $cfg) {
	mysqli_query ( $cfg, "UPDATE session SET status = 3, `release` = 1 WHERE session_id = '$session_id' " ) or die ( mysqli_error ( $cfg ) );
	mysqli_query ( $cfg, "UPDATE logfile SET `error` = 0, error_counter = 0, sendet = 0 WHERE session_id = '$session_id' and `error`=1" ) or die ( mysqli_error ( $cfg ) );
	mysqli_query ( $cfg, "DELETE FROM session_logfile WHERE session_id = '$session_id' " ) or die ( mysqli_error ( $cfg ) );
	echo "$session_id - Reset -> Errormails<br><br>";
}

/**
 * *************************************************************************************
 * Lofile für Session ausgeben
 * *************************************************************************************
 */
function call_session_logfile($session_id, $cfg) {
	if ($session_id) {
		echo "Session $session_id<hr>";
		// Ausgabe der Logfile des jeweiligen Session
		$query = mysqli_query ( $cfg, "SELECT * FROM session_logfile WHERE session_id = '$session_id' order by log_id " );
		while ( $array = mysqli_fetch_array ( $query ) ) {
			if ($array ['type'] == 'error')
				echo "<font color='red'>" . $array ['text'] . "</font><br>";
			else
				echo $array ['text'] . "<br>";
		}
	}
}
