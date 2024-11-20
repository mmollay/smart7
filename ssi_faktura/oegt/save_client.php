<?php

// Alle Daten entfernen und neu einspielen
$GLOBALS['mysqli']->query ( "DELETE FROM sections WHERE client_id = $client_id " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$GLOBALS['mysqli']->query ( "DELETE FROM membership WHERE client_id = $client_id " ) or die ( mysqli_error ($GLOBALS['mysqli']) );

// Bereite das Statement für membership vor
$stmtMembership = $GLOBALS['mysqli']->prepare("INSERT INTO membership (membership_id, client_id, date_membership_start, date_membership_stop) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE date_membership_start = VALUES(date_membership_start), date_membership_stop = VALUES(date_membership_stop)");

// Schleife für membership
for ($iii = 1; $iii <= $_POST['set_membership_count']; $iii++) {
	if (!empty($_POST["membership$iii"])) {
		// Überprüfe, ob die Daten leer sind und setze sie ggf. auf NULL
		$date_membership_start = !empty($_POST["date_membership_start$iii"]) ? $_POST["date_membership_start$iii"] : '0000-00-00';
		$date_membership_stop = !empty($_POST["date_membership_stop$iii"]) ? $_POST["date_membership_stop$iii"] : '0000-00-00';
		
		// Binden der Parameter und Ausführung des Statements
		$stmtMembership->bind_param('ssss', $_POST["membership$iii"], $client_id, $date_membership_start, $date_membership_stop);
		$stmtMembership->execute() or die(mysqli_error($GLOBALS['mysqli']));
	}
}

// Bereite das Statement für sections vor
$stmtSections = $GLOBALS['mysqli']->prepare("INSERT INTO sections (section_id, client_id, date_sections_start, date_sections_stop) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE date_sections_start = VALUES(date_sections_start), date_sections_stop = VALUES(date_sections_stop)");

// Schleife für sections
for ($ii = 1; $ii <= $_POST['set_section_count']; $ii++) {
	if (!empty($_POST["section$ii"])) {
		// Überprüfe, ob die Daten leer sind und setze sie ggf. auf NULL
		$date_sections_start = !empty($_POST["date_sections_start$ii"]) ? $_POST["date_sections_start$ii"] : '0000-00-00';
		$date_sections_stop = !empty($_POST["date_sections_stop$ii"]) ? $_POST["date_sections_stop$ii"] : '0000-00-00';
		
		// Binden der Parameter und Ausführung des Statements
		$stmtSections->bind_param('ssss', $_POST["section$ii"], $client_id, $date_sections_start, $date_sections_stop);
		$stmtSections->execute() or die(mysqli_error($GLOBALS['mysqli']));
	}
}


// Zusammensetzen der sections fuer OEGT
if ($_POST ['sections']) {
	foreach ( $_POST ['sections'] as $wert ) {
		$set_sections .= $wert . ",";
	}
}
?>