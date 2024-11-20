<?php
/***
 * Löscht eine Sql-Struktur
 * mm@ssi.at am 27.02.2017
 */
// Bsp
// $db = 'ssi_newsletter';
// $array_delstructure = array (
// 'user_id' => array ( "$db.amazon_order" ,
// "$db.blacklist" ,
// "$db.formular_design" ,
// "$db.sender" ,
// "$db.templates" ,
// "$db.verification" ,
// "$db.link" ,
// "$db.contact" => array ( 'contact_id' => array ( "$db.client_logfile" , "$db.contact2tag" ) ) ,
// "$db.formular" => array ( 'form_id' => array ( "$db.formular2tag" ) ) ,
// "$db.tag" => array ( 'tag_id' => array ( "$db.link2tag" , "$db.tag2tag" ) ) ,
// "$db.session" => array ( 'session_id' => array ( "$db.logfile" , "$db.session_logfile" , "$db.user_logfile" , "$db.landingpage" => array ( "$db.landingpage_id" => array ( "$dbcontact_id2landingpage_id" ) ) ) ) ) );

// call_structure ( $array_delstructure, '1244' );
function call_structure($array, $value, $db) {
	$set_db = "$db.";
	foreach ( $array as $id => $array2 ) {
		foreach ( $array2 as $table => $table2 ) {
			if (is_array ( $table2 )) {
				if ($value) {
					$query = $GLOBALS['mysqli']->query ( "SELECT * FROM $set_db$table WHERE $id = '$value' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
					$fetch = mysqli_fetch_array ( $query );
					$value2 = $fetch['0'];
					//echo "$id ($value) -> $set_db$table<br>";
					// echo "DELETE FROM $table WHERE $id = '$value' <br>";
					$GLOBALS['mysqli']->query ( "DELETE FROM $set_db$table WHERE $id = '$value' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
				}
				
				call_structure ( $table2, $value2, $db );
			} else {
				if ($value) {
					//echo "$id ($value) -> $table2 <br>";
					// echo "DELETE FROM $table2 WHERE $id = '$value' <br>";
					$GLOBALS['mysqli']->query ( "DELETE FROM $set_db$table2 WHERE $id = '$value' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
				}
			}
		}
	}
}
