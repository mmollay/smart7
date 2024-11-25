<?php
if ($_POST['update_id']) {
	$set_focus = 'true';
	$arr['sql'] = array ( 'query' => "SELECT * from tree WHERE tree_id = '{$_POST['update_id']}' " );
	
	$query = $GLOBALS['mysqli']->query ( "SELECT zip,district2 from tree WHERE tree_id = '{$_POST['update_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
	$array_zip = mysqli_fetch_array ( $query );
	$zip = $array_zip['zip'];
	$district2 = $array_zip['district2'];
}

if (! $zip)
	$zip = $_SESSION["map_filter"]['map_zip'];

if (! $district2) {
	$district2 = $_SESSION["map_filter"]['map_places'];
}

if (! $date) {
	$date = date ( 'Y-m-d' );
}

// Tree
$sql_query = $GLOBALS['mysqli']->query ( "
SELECT 
tree_template.temp_id temp_id,fruit_type,tree_group,tree_group_lang.title title, 
(SELECT count(*) FROM tree WHERE plant_id = tree_template.temp_id) count 
FROM tree_template 
		LEFT JOIN tree_template_lang ON tree_template.temp_id = tree_template_lang.temp_id
		LEFT JOIN tree_group_lang ON (tree_template.group_id = tree_group_lang.group_id AND tree_group_lang.lang = 'de')
			WHERE tree_group_lang.group_id > 0 
			ORDER BY tree_group_lang.title,fruit_type " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
while ( $sql_array = mysqli_fetch_array ( $sql_query ) ) {
	$tree_array[$sql_array['temp_id']] = $sql_array['fruit_type'] . " => " . $sql_array['title'] . " (".$sql_array['count'] . ")";
}


// Superuser
if (! in_array ($_SESSION['user_id'], $array_superuser_id )) {
	$where = " AND map_user_id='$map_user_id'";
}

// Client
$sql_query = $GLOBALS['mysqli']->query ( "SELECT client_id, (CASE
				WHEN (firstname != '' OR secondname != '') AND company_1 !='' then CONCAT (company_1,' (',firstname,' ',secondname,')')
				WHEN (firstname != '' OR secondname != '') AND company_1 ='' then CONCAT (firstname,' ',secondname)
				ELSE company_1 END) as name
				FROM client WHERE 1 $where ORDER BY name " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );

while ( $sql_array = mysqli_fetch_array ( $sql_query ) ) {
	$client_faktura_array[$sql_array['client_id']] = $sql_array['name'];
}

$query = $GLOBALS['mysqli']->query ( "SELECT name,place_id FROM tree_places WHERE zip = '$zip' " ) or die ( mysqli_error () );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$key = $array['place_id'];
	$value = utf8_encode ( $array['name'] );
	$array_places[$key] = $value;
}

// $form1->setField ( 'search_sponsor', array ( after => 'client_faktura_id' , 'type' => 'checkbox' , 'title' =>'Sponsor gesucht' ) );
$arr['form'] = array ( 'action' => "ajax/form_edit2.php" , 'size' => 'small' , 'id' => 'form_tree_id' );
$arr['field']['search_sponsor'] = array ( 'label' => 'Baumpate gesucht' , 'type' => 'checkbox' );

$arr['field'][] = array ( 'type' => 'div' , 'class' => 'fields two' ); // 'label'=>'test'
$arr['field']['client_faktura_id'] = array ( 'label' => "Baumpaten wählen" , 'class' => 'search' , 'type' => 'dropdown' , 'placeholder' => '--Bitte wählen--' , 'array' => $client_faktura_array , 'class' => 'search' ,  'focus' => true , 'clear' => true );
$arr['field']['plant_id'] = array ( 'label' => "Baum wählen" , 'type' => 'dropdown' , 'array' => $tree_array , 'class' => 'search' , 'clear' => true );
$arr['field'][] = array ( 'type' => 'div_close' );

$arr['field']['tree_panel'] = array ( 'label' => 'Widmung' , 'type' => 'input' , 'class' => '' , 'placeholder' => 'Schreibe deine persönlichen Text' );

$arr['field'][] = array ( 'type' => 'div' , 'class' => 'fields two' ); // 'label'=>'test'
$arr['field']['zip'] = array ( 'label' => 'Ort' , 'type' => 'dropdown' , 'array' => $array_city , 'value' => $zip ,  'validate' => true );
$arr['field']['district2'] = array ( 'label' => "Park wählen" , 'type' => 'dropdown' , 'array' => $array_places , 'class' => 'search' , 'value' => $district2 ,  'validate' => true );
$arr['field'][] = array ( 'type' => 'div_close' );

$arr['field'][] = array ( 'type' => 'div' , 'class' => 'fields two' ); // 'label'=>'test'
$arr['field']['plant_date'] = array ( 'label' => 'Pflanzdatum' , 'type' => 'date' ,  'validate' => true );
$arr['field'][] = array ( 'type' => 'div_close' );

$arr['field'][] = array ( 'type' => 'div' , 'class' => 'fields two' ); // 'label'=>'test'
$arr['field']['latitude'] = array ( 'label' => 'Latitude (Breitengrad)' , 'type' => 'input' );
$arr['field']['longtitude'] = array ( 'label' => 'Longtitude (Längengrad)' , 'type' => 'input' );
$arr['field'][] = array ( 'type' => 'div_close' );
$arr['field']['remark'] = array ( 'label' => 'Bemerkung' , 'type' => 'textarea' , 'rows' => 3 );

$arr['field'][] = array ( 'type' => 'div' , 'class' => 'fields two ui message' ); // 'label'=>'test'
$arr['field']['tree_rm_reason'] = array ( 'label' => 'Baum entfernt (Grund)' , 'type' => 'input' );
$arr['field']['tree_rm_date'] = array ( 'label' => 'Wann wurde Baum entfernt' , 'type' => 'date' );
$arr['field'][] = array ( 'type' => 'div_close' );

$arr['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );
$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('.ui.modal').modal('hide'); " );

$add_js = "<script type='text/javascript' src='js/form_tree.js'></script>";



