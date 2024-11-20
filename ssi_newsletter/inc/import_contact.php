<?php
require_once ('../mysql.inc');
require_once ('../functions.inc.php');

$_POST ['groups'] = $_POST ['groups_id'];
$_POST ['activate'] = 1;

$group_id = $_POST ['group_id'];
$setTEXT = $_POST ['setTEXT'];
$setDelimiter = $_POST ['setDelimiter'];
$setTemplate = $_POST ['setTemplate'];
$update = $_POST ['update'];
$import_contact = true;

if (! $setTEXT) {
	echo "<br><br>Keine Daten zum Import vorhanden!";
	return;
}

/**
 * *********************************
 * Kontakte überprüfen und säubern
 * **********************************
 */
$line = explode ( "\n", $setTEXT );

$count_user_first = count ( $line );
$line = array_unique ( $line );
$line = array_filter ( $line );

// Set Delimter "tab"
if ($setDelimiter == 'tab') {
	$setDelimiter = "\t";
}

// Emailchecker
foreach ( $line as $email ) {
	// Wenn nicht $setDelimiter gesetzt ist wird
	if (! preg_match ( "/$setDelimiter/", $email )) {
		$email = strtolower ( $email );
		if (filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
			$line2 [] = $email;
		} else {
			$line_error [] = $email;
		}
	} else {
		$array = explode ( $setDelimiter, $email );
		if (filter_var ( $array [0], FILTER_VALIDATE_EMAIL )) {
			$line2 [] = $email;
		} else {
			$line_error [] = $array [0];
		}
	}
}

/**
 * *********************************
 * Kontakte auflösen und zum importieren vorbereiten
 * **********************************
 */

// Auslesen der Feldnamen fuer die Benennung der Felder
$columns = explode ( ",", $setTemplate );

$ii = 0;
if ($line2) {
	foreach ( $line2 as $value ) {
		// Split for templates with "delimiter"
		$array_fields = explode ( $setDelimiter, $value );
		foreach ( $array_fields as $fields ) {
			$send_array [$array_fields [0]] [$columns [$ii]] = $fields;
			$_POST [$columns [$ii]] = $fields;
			// echo "\n$columns[$ii]".$_POST[$columns[$ii]];
			$ii ++;
		}
		include ('contact_save.php');
		$ii = 0;
	}
	echo "<b>Import abgeschlossen:</b><br><br>";
} else {
	echo "<br><br>";
}

if ($line_error) {
	$ii = 0;
	foreach ( $line_error as $value ) {
		$wrong_email ++;
	}
}
if ($black_user == 1)
	echo "$black_user Kontakt befindet sich in der Blacklist<br>";
elseif ($black_user > 1)
	echo "$black_user Kontakte befinden sich in der Blacklist<br>";

if ($new_user == 1)
	echo "$new_user Kontakt wurde angelegt <br>";
elseif ($new_user > 1)
	echo "$new_user Kontakte wurden angelegt <br>";

if ($updated_user == 1)
	echo "$updated_user Kontakt wurde überschrieben<br>";
elseif ($updated_user > 1)
	echo "$updated_user Kontakte wurden überschrieben<br>";

if ($exist_user == 1)
	echo "$exist_user Kontakt besteht bereits<br>";
elseif ($exist_user > 1)
	echo "$exist_user Kontakte bestehen bereits<br>";

if ($wrong_email) {
	echo "<script>
			$(document).ready(function() {
				$('#button_edit_brocken_emails').button().click( function(){
					//Lister der ungültigen Emails laden
					var list = $.ssi_ajax( {
					data : ({
						liste:$('#setTEXT').val(),
						setDelimiter:$('#setDelimiter').val()
					}),
					url :'inc/import_call_broken_emails.php'
				});
				$('#dialog_msg').dialog('close');
				$('#setTEXT').val(list).focus();
				
				});
			});
			</script>";
	echo "<font color =red>$wrong_email nicht gültige Email(s) erkannt! oder Delimiter falsch gesetzt</font><br><br><button id=button_edit_brocken_emails >Ungültige Emails bearbeiten</button> ";
}