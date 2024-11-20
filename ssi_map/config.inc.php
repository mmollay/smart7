<?php
include_once (__DIR__ . "/../login/config_main.inc.php");
$GLOBALS['mysqli']->select_db ( 'ssi_faktura' ) or die ( 'Could not select database ' . 'ssi_fruitmap' );
include_once ('functions.inc');

$module['ID'] = 'fruitmap';
$module['version'] = '1.4.2';
$module['title'] = 'Fruitmap';
$module['first_load'] = 'home';

$map_user_id = $_SESSION['user_id'];

//SuperUser wo alle Bäume und User aufgelistet sind
$array_superuser_id = array ( '1076' , '40' );


//Bei Obststadt - Page wird user_id 40 genommen
if ($_SESSION['user_id'] == '1076')
	$map_user_id = '40';

$map_lang = 'de';

include (__DIR__ . '/../ssi_smart/gadgets/map/config_map.php');

// Import - Parameter
$array_import = array ( "email" => "Email" ,
		"firstname" => "Vorname" ,
		"secondname" => "Nachnname" ,
		"gender" => "Gender{f=Frau,m=Herr,c=Firma}" ,
		"title" => "Title" ,
		"company_1" => "Firma 1" ,
		"company_2" => "Firma 2" ,
		"client_number" => "Kundennummer" ,
		"street" => "Straße" ,
		"zip" => "PLZ" ,
		"city" => "Stadt" ,
		"country" => "Land" ,
		"tel" => "Telefon" ,
		"web" => "Internet" ,
		"birth" => "Beboren" );


$array_family = call_sql_array ( "SELECT family_id,name FROM tree_family LEFT JOIN tree_family_lang ON family_id = family_lang_id WHERE lang = '$map_lang' " );
$array_speciesgroup = call_sql_array ( "SELECT group_id,title FROM tree_group_lang WHERE lang = '$map_lang' " );
$array_taste = call_sql_array ( "SELECT a.taste_id,title FROM tree_taste a LEFT JOIN tree_taste_lang b ON a.taste_id = b.taste_id  WHERE lang = '$map_lang' " );
//$array_tree = call_sql_array ( "SELECT tree_template.temp_id temp_id,fruit_type,tree_group from tree_template INNER JOIN tree_template_lang ON tree_template.temp_id = tree_template_lang.temp_id WHERE lang = '$map_lang' order by tree_group,fruit_type" );


// Anzahl der Bäume angeben
foreach ( $array_city as $key => $value ) {
	if ($key != 'all') {
		$sql_add = "AND zip = '$key' ";
	} else
		$sql_add = '';
		
		$query = $GLOBALS['mysqli']->query ( "SELECT COUNT(*) from tree WHERE 1 $sql_add AND tree.trash = '0' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
		$array_count_country = mysqli_fetch_array ( $query );
		$array_city2[$key] = $array_city[$key] ;
		//$array_city2[$key] = $array_city[$key] . " (" . $array_count_country[0] . ")";
}