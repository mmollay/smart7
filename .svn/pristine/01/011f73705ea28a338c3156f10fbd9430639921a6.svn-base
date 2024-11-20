<?
/*
 * Auslesen der Gruppen mit Selectausgabe zum loeschen der Gruppe
 * martin@ssi.at am 25.10.2010
 *
 */

// Auslesen der Optionen aus der Datenbank
session_start ();
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

$mysql_query = $GLOBALS['mysqli']->query ( "
SELECT group.group_id tag_id, group.title, COUNT(contact2tag.contact_id) counter 
	FROM tag LEFT JOIN ( contact2group, contact)
	ON contact2tag.tag_id = tag.tag_id AND contact.contact_id = contact2tag.contact_id 
	WHERE tag.user_id = '{$_SESSION['user_id']}'
	GROUP BY tag.tag_id
	" );

while ( $mysql_fetch = mysqli_fetch_array ( $mysql_query ) ) {
	$tga_id = $mysql_fetch ['tag_id'];
	$tag_name = $mysql_fetch ['title'];
	$options .= "<option value ='$tga_id' >$tag_name</option>";
}
if (! $options)
	$output = 'Kein Tag vorhanden';
else
	$output = "<select id=del_group_select >$options</select> <input class=button_group type=button onclick='submit_delgroup()' value='Löschen'>";

echo "$output <input class=button_group type=button onclick='submit_delgroup_stop($tga_id)' value='Abbrechen'>";

?>