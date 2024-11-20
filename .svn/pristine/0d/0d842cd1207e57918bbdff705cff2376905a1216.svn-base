<?php
include_once ('../../login/config_main.inc.php');
include_once ('../config.inc.php');

$_POST['groups']   = $_POST['groups_id'];
$_POST['activate'] = 1;

$group_id         = $_POST['group_id'];
$setTEXT          = $_POST['setTEXT'];
$setDelimiter     = $_POST['setDelimiter'];
$setTemplate      = $_POST['setTemplate'];
$update           = $_POST['update'];
$import_file      = $_POST['import_file'];
$import_contact   = true;

if ($import_file) $file = "$upload_folder$import_file";

if (is_file($file)) {
	
	//Uplaod file
	$line = file2array($file);
	$setDelimiter = ";";
}
elseif (!$setTEXT) {
	echo "<div align=center><br><br>Keine Daten zum Import vorhanden!</div>"; return;
}
else {
	/***********************************
	 *  Kontakte überprüfen und säubern
	***********************************/
	$line    = explode("\n",$setTEXT);
	$line    = array_unique($line);
	$line    = array_filter($line);
}
$count_user_first = count($line);

//Set Delimter "tab"
if ($setDelimiter == 'tab') {
	$setDelimiter = "\t";
}

/***********************************
 * Kontakte auflösen und zum importieren vorbereiten
***********************************/
$line2 = $line;

//Auslesen der Feldnamen fuer die Benennung der Felder
$columns = explode(",",$setTemplate);

$ii =  0;
if ($line2) {
	foreach ($line2 as $value) {
		//Split for templates with "delimiter"
		$array_fields = explode($setDelimiter, $value);
		foreach($array_fields as $fields) {
			$fields = preg_replace("/\"/","",$fields);
			$send_array[$array_fields[0]][$columns[$ii]]  = $fields;
			if ($fields == '<null>')
				$_POST[$columns[$ii]] = '';
			else
				$_POST[$columns[$ii]] = $GLOBALS['mysqli']->real_escape_string($fields);
	

			//$_POST[$columns[$ii]] = $fields;
			//echo "\n$columns[$ii] = ".$_POST[$columns[$ii]];
			$ii++;
		}
		//echo $_POST['IkPunkte'];

		include('contact_save.php');
		$ii =  0;
	}
	echo "<b>Import abgeschlossen:</b><br><br>";
}
else {
	echo "<br><br>";
}

if ($line_error) {
	$ii =  0;
	foreach ($line_error as $value) {
		$wrong_email++;
	}
}
if ($black_user ==1 )   echo "$black_user Kontakt befindet sich in der Blacklist<br>";
elseif ($black_user > 1 )   echo "$black_user Kontakte befinden sich in der Blacklist<br>";

if ($new_user == 1)     echo "$new_user User wurde angelegt <br>";
elseif ($new_user > 1)     echo "$new_user User wurden angelegt <br>";

if ($updated_user ==1 ) echo "$updated_user User wurde überschrieben<br>";
elseif ($updated_user > 1) echo "$updated_user User wurden überschrieben<br>";

if ($exist_user == 1)   echo "$exist_user User besteht bereits<br>";
elseif ($exist_user > 1)   echo "$exist_user User bestehen bereits<br>";

if ($wrong_email)  {
	echo "<script>
			$(document).ready(function() {
			$('#button_edit_brocken_emails').button().click( function(){
			//Lister der ungültigen Emails laden
			var list = $.ssi_ajax( {
			data : ({
			liste:$('#setTEXT').val(),
			setDelimiter:$('#setDelimiter').val()
}),
			url :'ajax/import_call_brocken_emails.php'
});
			$('#dialog_msg').dialog('close');
			$('#setTEXT').val(list).focus();

});
});
			</script>";
	echo "<font color =red>$wrong_email nicht gültige Email(s) erkannt!</font><br><br><button id=button_edit_brocken_emails >Ungültige Emails bearbeiten</button> ";
}