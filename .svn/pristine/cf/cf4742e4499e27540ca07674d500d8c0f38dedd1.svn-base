<?
/*
 * Löschen der Gruppe aud der Datenbank
 * martin@ssi.at am 26.02.2017
 *
 */

// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');

$tag_id = $_POST ['tag_id'];
// Gruppe entfernen
$GLOBALS['mysqli']->query ( "DELETE FROM tag WHERE tag_id = '$tag_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );

// Verknuepfung zu den Kontakten entfernen
$GLOBALS['mysqli']->query ( "DELETE FROM contact2tag WHERE tag_id = '$tag_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );

// Neuen Daten aulesen
$mysql_group_query = $GLOBALS['mysqli']->query ( "
SELECT group.tag_id tag_id, group.title, COUNT(contact2tag.contact_id) counter 
	FROM tag LEFT JOIN ( contact2tag, contact)
	ON contact2tag.tag_id = tag.tag_id AND contact.contact_id = contact2tag.contact_id 
	WHERE group.user_id = '{$_SESSION['user_id']}'
	GROUP BY tag.tag_id
	" );

while ( $mysql_group_fetch = mysqli_fetch_array ( $mysql_group_query ) ) {
	$tag_id = $mysql_group_fetch ['tag_id'];
	$tag_name = $mysql_group_fetch ['title'];
	$options .= "<option value ='$tag_id' >$tag_name</option>";
	$group_array [$tag_id] = $tag_name;
}
if ($group_array)
	echo json_encode ( $group_array );
else
	echo "";
	
	// echo 'ok';
?>