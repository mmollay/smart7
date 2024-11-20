<?php
/*
 * content für Screen-Info - wandelt Platzhalter in Namen, Email usw. um....
 */
include ('../login/config_main.inc.php');
$user_id = $_SESSION['user_id'];
$element = $GLOBALS['mysqli']->real_escape_string ( $_POST['element'] );

$query = $GLOBALS['mysqli']->query ( "SELECT * from ssi_company.user2company WHERE user_id = '$user_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$array = mysqli_fetch_array ( $query );
$array['email'] = $array['user_name'];
$array['firstname'] = $array['firstname'];
$array['secondname'] = $array['secondname'];

include_once ('../ssi_smart/php_functions/functions.php');

// Auslesen der Werte und in das Form übergeben;
$fetch = call_company_option ( $_SESSION['smart_company_id'], array ( $element . "_title" , $element . "_text" ) );

if (! $fetch[$element . "_title"])
	$fetch[$element . "_title"] = 'Willkommen {%firstname%}!';

//$array2[title] = preg_replace ( '!{%(.*?)%}!e', '$array[ \1 ]', $fetch[$element . "_title"] );
$array2[title] = preg_replace_callback('!{(.*?)}!', function($matches){ global $array; return $array[$matches[1]]; },$fetch[$element . "_title"]);

//$array2[text] = preg_replace ( '!{%(.*?)%}!e', '$array[ \1 ]', $fetch[$element . "_text"] );
$array2[text] = preg_replace_callback('!{(.*?)}!', function($matches){ global $array; return $array[$matches[1]]; },$fetch[$element . "_text"]);
echo json_encode ( $array2 );