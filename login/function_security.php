<?php

// check_mysql_insert($sql, $info = false) .....................Prüft Einträge oder Aufrufe auf Gültigkeit
// check_module4user() ...........................................Prüft Ob User Nutzungrechte für Module hat

/**
 * **********
 * MUSS bei ALLEN INSERTS UND UPDATES DURCHGEFÜHRT WERDEN!!!!!!!
 * Prüft Eintragung und UPDATES in die Datenbank und legt gegebenfalls ein Error-Log ab
 * In weiterer Folge wird ein Mail vom System an den Admin gesendet
 */

// Beispiel - Prüft ob user_id Superuser ist
// check_mysql_insert("SELECT COUNT(*) FROM ssi_company.comp_options WHERE option_name='superuser_id' AND option_value = '{$_SESSION['user_id']}' AND company_id = '{$_SESSION['smart_company_id']}'", "Update der ssi_company.user2company Datenbank" );
function check_mysql_insert($sql, $info = false) {

	// date_default_timezone_set ( 'Europe/Berlin' );
	$array = debug_backtrace ();
	// var_dump(debug_backtrace());
	$file = $array ['0'] ['file'];

	$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );

	$sql = $GLOBALS ['mysqli']->real_escape_string ( $sql );
	// Wenn Sql keinen Wert zurück gibt wird ein Eintrag in das logfile gemacht und ein Email gesendet
	if (! $array [0]) {
		include ('config_mail.php');
		$MailConfig ['from_email'] = 'wartung@ssi.at';
		$MailConfig ['from_name'] = 'SSI-Wartung';
		$MailConfig ['to_email'] = 'martin@ssi.at';
		$MailConfig ['to_name'] = 'Martin Mollay';
		$MailConfig ['subject'] = 'Unzlässige Speicherung';

		if ($info)
			$MailConfig ['text'] = "Info: $info<br>";
		$MailConfig ['text'] = "
		Datum: " . date ( 'F j, Y, g:i a' ) . "<br>
		User_ID: {$_SESSION['user_id']}<br>
		Prüf-sql: $sql<br>
		RemoteIP: {$_SERVER['REMOTE_ADDR']}<br>
		File: $file<br> ";
		// $path = $_SERVER['DOCUMENT_ROOT'];

		// Mailversandt
		include (__DIR__ . "/../ssi_smart/php_functions/function_sendmail.php");
		smart_sendmail ( $MailConfig );

		$GLOBALS ['mysqli']->query ( "INSERT INTO ssi_company.log_no_correct_insert SET
		remote_ip = '{$_SERVER['REMOTE_ADDR']}',
		user_id = '{$_SESSION['user_id']}',
		`query` = '$sql',
		`file` = '$file',
		`info` = '$info'
		" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		// Weiterleiten zu einer Errorseite
		// header ( 'Location: /pages/error.php' );
		echo "Unzulässige Eintragung";
		exit ();
	}
}

/**
 * Module abrufen welche für die Company verfügbar sind
 * Erste Instanz ist Company
 * Zweite Instanz ist SSI_Smart
 */
function check_module4user($company_id = false, $user_id = false) {
	if (! $company_id)
		$company_id = $_SESSION ['smart_company_id'];
	if (! $user_id)
		$user_id = $_SESSION ['user_id'];

	$query_comp = $GLOBALS ['mysqli']->query ( "SELECT * from ssi_company.module2company WHERE company_id = '$company_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array_comp = mysqli_fetch_array ( $query_comp ) ) {
		$company_modules [$array_comp ['module']] = true;
	}

	$sql = $GLOBALS ['mysqli']->query ( "SELECT module from {$_SESSION['db_smartkit']}.module2id_user WHERE user_id = '$user_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array = mysqli_fetch_array ( $sql ) ) {

		// Prüft zurerst ob Company Rechte auf gewünschte Module hat
		if (isset($company_modules [$array ['module']])) {
			$set_module [$array ['module']] = true;
		}
	}
	return $set_module;
}

/**
 * *****************************************************************
 * Prüft ob User verifiziert wurde
 * *****************************************************************
 */
function check_user_verification() {
	$query = $GLOBALS ['mysqli']->query ( "
			SELECT user_name,fbid,user_checked,verified,user_id user_id
			FROM ssi_company.user2company 
			WHERE user_id = '{$_SESSION['user_id']}'
			" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );

	// Email-Adress
	$_SESSION ['user_name'] = $array ['user_name'];
	// Verification ssi_smartx (alte Version
	$user_checked = $array ['user_checked'];
	// Verification ssi_company (neue Version - Zentralverwaltung + leichterer Zugriff)
	$verified = $array ['verified'];
	// Facebook FBID
	$fbid = $array ['fbid'];

	// Falls user_id nicht vorhanden wird session gelöscht
	if (! $array ['user_id']) {
		$_SESSION ['user_id'] = '';
		$_COOKIE ["user_id"] = '';
	}

	/**
	 * Freigabe des Users wenn dieser über
	 * - Facebook angemeldet ist
	 * - Alte Variante ssi_smart(x) (alte Variante)
	 * - Neue Variant ssi_company (Zentralverwaltung)
	 */
	if ($user_checked or $fbid or $verified) {
		return true;
	} else {
		return false;
	}
}
