<?php
session_start ();

if (! $_SESSION['develop_mode']) {
	echo "Funktion ist für diesen Account gesperrt";
	exit ();
}
?>

<h1>Tests Newsletterfunktionen</h1>

Followup-tests
<li><a href='followup_after_confirmation.php'>Erzeugt erste Followup &uuml;ber User (Tag wird verglichen und l&ouml;st aus)</a><br>
<li><a href='followup_tag2contact.php'>Zuweisung und Wegnahme von Tags f&uuml;r Contact_id</a><br>
<li><a href='followup_mail_generate.php'>Aus Followup_id eine Mail erzeugen</a><br>

<hr>
Weitere Tests
<li><a href='get_ams_emails.php'>Mails mit "ams.at" in "AMS"-Gruppe verschieben</a>

<hr>
<a href='clear_ns_system.php'>NL-System leeren</a><br><br>
<a href='../exec/SendNewsletter.inc.php'>Mailversandt manuell starten</a>