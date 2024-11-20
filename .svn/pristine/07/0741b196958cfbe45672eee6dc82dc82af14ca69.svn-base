	<?php

/*
 * Update: 04.05.2011 - Prüft "layer_id_"
* 05.12.2010 mm@ssi.at
* Erzeugt aus einem Template eine neue Webseite
* Diese wird in der Datenbank neu angelegt
*/

//if (!$template_id) return;

//Umwandeln der user_id fuer die db zur richtigen Zuweisung
$array_change_val['set_user_id'] = $user_id;

//Zuweisung der gewaehlten Vorlage
//$template_id =  '';

//Werte aus der txt auslesen
$path_sql  = realpath("$template_path/mysql.txt");
$file      = fopen($path_sql, 'rb');
$sql_query = fread($file, filesize($path_sql));
fclose($file);


//Erzeugen einzelner Datenbanksaetze
$sql_query= preg_split("/\n/",$sql_query);

//Auslesen von Userdaten für das Einfügen in die Webseite
$query = $GLOBALS['mysqli']->query ( "SELECT * from ssi_company.user2company WHERE user_id = '$user_id' " );
$array_user = mysqli_fetch_array ( $query );
$array_user['firstname'] = $array_user['firstname'];
$array_user['secondname'] = $array_user['secondname'];

//Umwandeln der Variablen fuer das speichern in der Datenbank
foreach ($sql_query as $output)
{
	if(!empty($output)) {
		$output = preg_replace_callback("/(%%)(.+?)\'/","callback",$output);
		
		$GLOBALS['array_user'] = $array_user;
		//wizard (siehe function_create_page.php
		//$output = preg_replace_callback("/\{%(.*?)%\}/","callback_wizard",$output);
		
		//$output = preg_replace ( '!{%(.*?)%}!e', '$array_user[ \1 ]', $output );
		
		$output = preg_replace_callback ( '!{%(.*?)%}!', function ($matches) {
			$array = $GLOBALS['array_user'];
			return $array[$matches[1]];
		}, $output );
		
		
		//print_r($array_change_val);
		//Hier werden Einträge aus dem Array umgewandelt
		if ($array_change_val) {
			foreach ($array_change_val as $key => $value) {
				$output = preg_replace("/".$key."/",$value,$output);
			}
		}

		//Umwandeln des Userpathes
		if ($array_change_val['page_id_'.$GLOBALS['page_id']]) {
			$set_page_id = $array_change_val['page_id_'.$GLOBALS['page_id']];
			$output = preg_replace("/\[\%page_path\%\]/","user$user_id/explorer/$set_page_id",$output);
		}

		//Nur eintragen wenn "layer_id_" nicht vorhanden ist
		if (!preg_match("/layer_id_/",$output)) {
			//Eintrag in Datenbank machen
			$GLOBALS['mysqli']->query($output); // or die (mysqli_error());
			//mysql_query($output) or die (mysqli_error());
		}

		//New Insert ID auslesen und Werte in der Val erzetzen
		$new_id = mysqli_insert_id($GLOBALS['mysqli']);

		if (!$array_change_val[$GLOBALS['insert_id_name']])
			$array_change_val[$GLOBALS['insert_id_name']] = $new_id;

		//echo $output."<br><br>";
	}
}

$page_id = $array_change_val['page_id_'.$GLOBALS['page_id']];

?>