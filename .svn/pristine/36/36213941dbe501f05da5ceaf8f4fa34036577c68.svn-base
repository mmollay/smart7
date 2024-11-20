<?php
session_start ();

// require_once ('../mysql.inc');
require_once ('../config.inc.php');
require_once ('../functions.inc.php');

$_POST ['activate'] = 1;

$setTEXT = $_POST ['setTEXT'];
$setDelimiter = $_POST ['setDelimiter'];
$update = $_POST ['update'];

$import_contact = true;

// $setTemplate = "email,firstname,secondname,sex,title,company_1,company_2,client_number,city,zip,country,tel,web,birth";
// $setTemplate = explode ( ",", $setTemplate );

$setTemplate = array_keys ( $array_import );

// $setTemplate = $array_import;

$_POST ['groups'] = explode ( ',', $_POST ['tags'] );
$_POST ['groups_remove'] = explode ( ',', $_POST['tags_remove'] );

$_POST ['groups'] = array_diff ( $_POST ['groups'], $_POST ['groups_remove'] );


if (! $setTEXT) {
	echo "<br><br>Keine Daten zum Import vorhanden!";
	return;
}

/**
 * *********************************
 * Kontakte überprüfen und säubern
 * **********************************
 */
if ($_POST ['import_type'] == 'mail_format') {

	$setTemplate = array ('email','firstname' );
	$array_liste = preg_split ( "/;|,/", $setTEXT );

	foreach ( $array_liste as $email ) {
		$array_email = email_split ( $email );
		if (strtolower ( $array_email ['email'] ) == strtolower ( $array_email ['name'] ))
			$array_email ['name'] = '';
		$line [$array_email ['email']] = $array_email ['email'] . "\t" . $array_email ['name'];
	}
} else {
	$line = explode ( "\n", $setTEXT );
}

$count_user_first = count ( $line );
$line = array_unique ( $line );
$line = array_filter ( $line );

// Set Delimter "tab"
if ($setDelimiter == 'tab') {
	$setDelimiter = "\t";
}

// Emailchecker
/**
 * **********
 * wurde deaktiviert, weil die Reihenfolge der import-felder frei definiert werden kann
 * mm@ssi.at am 28.09.2020
 * *********
 */
// foreach ( $line as $email ) {
// 	// Wenn nur Email übertragen wird
// 	if (! preg_match ( "/$setDelimiter/", $email )) {
// 		$email = strtolower ( $email );
// 		if (filter_var ( trim ( $email ), FILTER_VALIDATE_EMAIL )) {
// 			$line2[] = $email;
// 		} else {
// 			$line_error[] = $email;
// 		}
// 		// Bei TRENN-Zeichen
// 	} else {
// 		$array = explode ( $setDelimiter, $email );
// 		if (filter_var ( trim ( $array[0] ), FILTER_VALIDATE_EMAIL )) {
// 			$line2[] = $email;
// 		} else {
// 			$line_error[] = $array[0];
// 		}
// 	}
// }

$line2 = $line;

/**
 * *********************************
 * Kontakte auflösen und zum importieren vorbereiten
 * **********************************
 */

// Auslesen der Feldnamen fuer die Benennung der Felder
if ($line2) {
	foreach ( $line2 as $value ) {
		$ii = 0;

		// Split for templates with "delimiter"
		$array_fields = explode ( $setDelimiter, $value );

		foreach ( $array_fields as $fields ) {
			$send_array [$array_fields [0]] [$setTemplate [$ii]] = $fields;
			$_POST [$setTemplate [$ii]] = trim ( $fields );
			$ii ++;
		}

		include ('../inc/contact_save.php');
	}
	$msg_output_title = "Import abgeschlossen";
	$error = 0;
} else {
	$msg_output_title = "Keine Kontakt vorhanden";
	$error = 1;
}

if ($line_error) {
	$ii = 0;
	foreach ( $line_error as $value ) {
		$wrong_email ++;
	}
}

if ($black_user == 1)
	$msg_outputi_info .= "<li>$black_user Kontakt befindet sich in der Blacklist</li>";
elseif ($black_user > 1)
	$msg_output_info .= "<li>$black_user Kontakte befinden sich in der Blacklist</li>";

if ($new_user == 1)
	$msg_output .= "<li>$new_user Kontakt wurde angelegt</li>";
elseif ($new_user > 1)
	$msg_output .= "<li>$new_user Kontakte wurden angelegt</li>";

if ($updated_user == 1)
	$msg_output .= "<li>$updated_user Kontakt wurde überschrieben</li>";
elseif ($updated_user > 1)
	$msg_output .= "<li>$updated_user Kontakte wurden überschrieben</li>";

if ($exist_user == 1)
	$msg_output_info .= "<li>$exist_user Kontakt besteht bereits</li>";
elseif ($exist_user > 1)
	$msg_output_info .= "<li>$exist_user Kontakte bestehen bereits</li>";

if ($wrong_email) {
	$msg_output .= "<script>
				$('#button_edit_brocken_emails').click( function(){
					//Lister der ungültigen Emails laden
					var list = $.ssi_ajax( {
					data : ({
						liste:$('#setTEXT').val(),
						setDelimiter:$('#setDelimiter').val()
					}),
					url :'inc/import_call_broken_emails.php'
				});
				$('#modal_msg').modal('hide');
				$('#setTEXT').val(list).focus();
				});
			</script>";

	$msg_output .= "</li><font color=red>$wrong_email nicht gültige Email(s) erkannt oder Delimiter falsch gesetzt</font></li>";
	$msg_output_error = "<br><button id=button_edit_brocken_emails class='button ui small' >Ungültige Emails bearbeiten</button>";
}

if ($error == 1) {
	$class_message = 'error';
	$icon_message = 'info';
} else {
	$class_message = 'success';
	$icon_message = 'check';
}

echo "
<div class='ui icon $class_message message'>
  <i class='$icon_message icon'></i>
	<div class='content'>
  		<div class='header'>$msg_output_title</div>
  		<ul class='list'>$msg_output</ul>
		$msg_output_error
	</div>
</div>";

if ($msg_output_info)
	echo "
	<div class='ui icon info message'>
	  <i class='info icon'></i>
		<div class='content'>
	  		<div class='header'>Information</div>
	  		<ul class='list'>$msg_output_info</ul>
		</div>
	</div>";



