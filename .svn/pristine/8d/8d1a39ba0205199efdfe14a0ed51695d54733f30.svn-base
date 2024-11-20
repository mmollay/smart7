<?php

// generate_new_session($contact_id, $develop = false)........Erzeugt Tagsetzung die Email aus Followup, wenn schon erzeugt wird es verhindert
// action_after_send($contact_id, $followup_id, $cfg)................Check on nach versenden eine weitere Handlung gesetzt werden soll
//generate_followup_mail($followup_id, $array_contact_id,$cfg).....Mail-Generator mit Zeitstempel (Followup Sequenz)
/**
 * ************************************************************************************************************************
 * mm@ssi.at am 10.05.2018
 * - Prüft nach ob bei User, der sich am Newsletter angemeldet (nach Bestätigung), weitere Handlungen gesetzt werden sollen
 * - Erzeugt gegebenenfalls eine Session mit einen Zeitstempel hinterlegt
 * 1. Prüfung bei zugewiesenen Tags
 * 2. Prüfung, auslösen über Steps
 * ************************************************************************************************************************
 */
function generate_new_session($contact_id, $cfg, $develop = false) {

	// An welche Kontakte gesendet werden sollen
	$array_contact_id [] = $contact_id;

	$info_array [] = "contact_id: $contact_id";

	// Abrufen aller Tags vom User - diese werden mit den Followup Sequenzen verglichen
	$mysql_tag_query = mysqli_query ( $cfg, "SELECT * FROM contact2tag where contact_id = '$contact_id' and (tag_id != '' and contact_id != ''	) " ); // and activate='1'
	while ( $mysql_tag_fetch = mysqli_fetch_array ( $mysql_tag_query ) ) {
		// $tag_id = $mysql_tag_fetch['tag_id'];
		$tag_name = $mysql_tag_fetch ['title'];
		$tag_selected_array [] = $mysql_tag_fetch ['tag_id'];
	}

	if (! is_array ( $tag_selected_array )) {
		$info_array [] = "<hr>Erzeugen einer Session";
	} else {

		// Follow-Up - Table durchforsten
		$info_array [] = "tag_id: " . json_encode ( $tag_selected_array );

		// Follow-Up von Tagzuweisungen
		foreach ( $tag_selected_array as $followup_tag_id ) {

			$query = mysqli_query ( $cfg, "SELECT followup_id FROM `f_trigger2tag` where tag_id = '$followup_tag_id' " );
			$trigger_array = $query->fetch_array ();

			// Erzeugt für übergebenee Contact_id's eine Campagne
			generate_followup_mail ( $trigger_array ['followup_id'], $array_contact_id, $cfg );
			$info_array [] = "<hr>Erzeugen einer Session";
		}
	}

	if ($devlop)
		return $info_array;
}

/**
 * **************************************************************************
 * Mail-Generator mit Zeitstempel -> 10.Mai 2018 mm
 * Erzeugt der followup_id entsprechend eine Mail mit oder ohne Zeitstempel
 * **************************************************************************
 */
function generate_followup_mail($followup_id, $array_contact_id, $cfg) {
	if (! $followup_id)
		return;

	$query = mysqli_query ( $cfg, "
		SELECT user_id, mode, send_time, day, hour, min, title, text, from_id
			FROM f_mail2followup a
				LEFT JOIN  `f_trigger2time` b ON b.followup_id = a.followup_id
				LEFT JOIN  `followup_mail` d ON d.mail_id = a.mail_id
				WHERE a.followup_id = '$followup_id' " );

	$trigger_array = $query->fetch_array ();
	// $info_array[] = "followup_id: $followup_id";

	$user_id = $trigger_array ['user_id'];
	$send_auto = 1;
	$title = $trigger_array ['title'];
	$text = $trigger_array ['text'];
	$from_id = $trigger_array ['from_id'];
	$mode = $trigger_array ['mode'];

	$trigger_time = $trigger_time ['trigger_time'];
	$hour = $trigger_array ['hour'];
	$min = $trigger_array ['min'];
	$day = $trigger_array ['day'];
	$send_time = $trigger_array ['send_time'];
	$followup_url = "followup/$followup_id"; //wird für die Zuweisung der Files benötigt

	// Erzeugt einen Zeitstempel wann die Email versendet werden soll
	if ($mode == 'periode') {
		$send_date = date ( 'Y-m-d H:i:s', strtotime ( "$day day $hour hour $min minute" ) );
	} elseif ($mode == 'datetime') {
		$send_date = date ( $send_time );
	} else {
		$send_date = date ( 'Y-m-d H:i:s' );
	}

	//16.02.2021
	//Prüfen ob Mail für User in aus Followup eh noch nicht erzeugt worden ist, wenn ja wird diese nicht noch einmal erzeugt,
	//somit wird der Wert einfach enternt
	//Falls ein Kontakt 2 mal bearbeitet wird oder in der Importliste der User neu hochgeladen wurde
	foreach ( $array_contact_id as $check_contact_id ) {

		$result = mysqli_query ( $cfg, "SELECT * FROM session a LEFT JOIN logfile b ON a.session_id = b.session_id WHERE  a.followup_id = '$followup_id' AND client_id = '$check_contact_id' AND remove_nl = 0 " );
		if (! $result->num_rows) {
			$array_contact_id2 [++ $ii] = $check_contact_id;
		}
	}

	//Nur erzeugen wenn nicht schon vorhanden ist
	if (! is_array ( $array_contact_id2 ))
		return;

	$array_contact_id = implode ( ',', $array_contact_id2 );

	// Erzeugen der Session
	include (__DIR__ . '/ajax/content_campagne2.php');
	// $test_output .= ($output);

	// Ausgabe zum testen
	return "trigger_array:" . json_encode ( $trigger_array ) . "";
}

/**
 * *************************************************************************************
 * Erweiterung für Followup -> 09.Mai 2018 mm
 * Check ob danach der User auf irgendetwas gesetzt werden soll
 * Bsp.: Tag-Zuweisung oder Tag-Entwendung
 * *************************************************************************************
 */
function action_after_send($contact_id, $followup_id, $cfg) {
	if (! $contact_id or ! $followup_id)
		return 'contact_id oder followup_id nicht zugewiesen';

	$array_contact_id [] = $contact_id;

	// Auslesen der Tags die zugewiesen oder entfernt werden sollen
	$query = mysqli_query ( $cfg, "SELECT * FROM f_action2tag WHERE followup_id='$followup_id' " );
	while ( $array = $query->fetch_array () ) {
		$tag_id = $array ['tag_id'];
		$no = $array ['no'];
		// echo $tag_id;
		if ($no) {
			// Tag wird 'contact' entzogen
			mysqli_query ( $cfg, "DELETE FROM contact2tag WHERE contact_id  = '$contact_id' AND tag_id = '$tag_id' LIMIT 1 " ) or die ( mysqli_error ( $cfg ) );
			// Tag wird 'contact' zu gewiesen
			mysqli_query ( $cfg, "REPLACE INTO contact2tag SET tag_id = '$tag_id', contact_id  = '$contact_id'  " ) or die ( mysqli_error ( $cfg ) );
		}
	}

	// Prüft ob ein neuer Step über einen anderen Step gestartet werden soll
	$query = mysqli_query ( $cfg, "SELECT * FROM f_trigger2followup WHERE step_id='$followup_id' " );
	while ( $array2 = $query->fetch_array () ) {
		// $contact_id = ''; <- wird übergeben
		// Neue Email wird erzeugt
		generate_followup_mail ( $array2 ['followup_id'], $array_contact_id, $cfg );
	}

	return "ok";
}

