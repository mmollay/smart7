<?
// Superuser
if (! in_array ($_SESSION['user_id'], $array_superuser_id )) {
	$where = " AND map_user_id='$map_user_id'";
}

$arr['list'] = array ( 'id' => 'map_tree' , 'width' => '100%' , 'size' => 'small' , 'class' => 'compact celled striped definition unstackable' , 'loading_time' => true , 'serial' => false ); // definition


$arr['mysql'] = array ( 
    'field' => "
tree_id,
if (company_1 = '',CONCAT (firstname,' ',secondname),company_1) company_1, longtitude, latitude, fruit_type, 
tree_group_lang.title group_title, tree_template.group_id group_id, trash,
tree_places.name place, tree_panel,plant_date
					" ,
		'table' => "tree 
			LEFT JOIN client ON client_faktura_id = client.client_id
			LEFT JOIN tree_template ON plant_id = tree_template.temp_id
			LEFT JOIN tree_template_lang ON plant_id = tree_template_lang.temp_id
			LEFT JOIN tree_group ON tree_group.tree_group_id  = tree_template.group_id
			LEFT JOIN tree_group_lang ON tree_group_lang.group_id = tree_group.tree_group_id   
			LEFT JOIN tree_places ON place_id = district2	
			" ,
		'order' => 'tree_id' ,
		'group' => 'tree_id' ,
		//'group' => 'longtitude HAVING Count( longtitude ) = 1' ,
		'where' => $where ,
		'limit' => 30 ,
		//'debug' => true,
		'like' => 'company_1,firstname,secondname,tree_id,longtitude,latitude' );

$arr ['mysql']['export'] = 'firstname,secondname,tel,email';



$array_filter = array ( 
		'client_faktura_id = 0 AND trash = 0' => 'Nicht zugewiesene Bäume' , 
		'trash = 1' => 'Alle gelöschten Bäume anzeigen'
);

//'(COUNT("longtitude") > 1 AND COUNT("latitude") > 1)' => 'Doppeleinträge anzeigen' 

$arr['filter']['zip'] = array ( 'type' => 'dropdown' , 'table' => 'tree' , 'array' => $array_city2 , 'placeholder' => '--Alle Städte--' ); // 'label' => 'Stadt' ,

if ($_SESSION["filter"]['map_tree']['zip2'] != $_SESSION["filter"]['map_tree']['zip'])
	$_SESSION["filter"]['map_tree']['district2'] = '';

$zip = $_SESSION["filter"]['map_tree']['zip2'] = $_SESSION["filter"]['map_tree']['zip'];

if ($zip != 'all') {
	$query = $GLOBALS['mysqli']->query ( "SELECT name,place_id,
		(SELECT COUNT(*) from tree WHERE district2 = place_id AND tree.trash = '0') count
		FROM tree_places WHERE zip = '$zip' " ) or die ( mysqli_error () );
	while ( $fetch_place = mysqli_fetch_array ( $query ) ) {
		$key = $fetch_place['place_id'];
		$array_places[$key] = $fetch_place['name'] . "(" . $fetch_place['count'] . ")";
	}
	$arr['filter']['district2'] = array ( 'type' => 'dropdown' , 'table' => 'tree' , 'array' => $array_places , 'placeholder' => '--Alle Plätze--' );
}

$arr['filter']['group_id'] = array ( 'type' => 'dropdown' , 'table' => 'tree_template' , 'array' => $array_speciesgroup , 'placeholder' => '--Alle Gattungen--' );
$arr['filter']['select_id'] = array ( 'default_value' => 0 , 'type' => 'dropdown' , 'query' => "{value}" , 'array' => $array_filter , 'placeholder' => '--Kein Filter--' );

// $arr['filter']['taste_id'] = array ( 'type' => 'dropdown' , 'table'=>'tree_template', 'array' => $array_taste , 'placeholder' => '--Alle Geschmacksrichtungen--' );

$arr['order'] = array ( 'default' => 'tree_id desc' , 
'array' => array ( 
	'tree_id desc' => 'Baumnummer absteigend sortieren' , 
	'tree_id' => 'Baumnummer aufsteigend sortieren' ,  
	'plant_date' => 'Pflanzdatum absteigend sortieren' ,
	'plant_date desc' => 'Pflanzdatum aufsteigend sortieren' 
	) );

// $arr['th']['client_id'] = array ( 'title' =>"ID" );
$arr['th']['tree_id'] = array ( 'title' =>"Baumnr." );
$arr['th']['company_1'] = array ( 'title' =>"<i class='user icon'></i>Baumpate" );

//$arr['th']['longtitude'] = array ( 'title' =>"Längengrad" );
//$arr['th']['latitude'] = array ( 'title' =>"Breitengrad" );
$arr['th']['group_title'] = array ( 'title' =>"Gattung" );
$arr['th']['fruit_type'] = array ( 'title' =>"Planze" );
$arr['th']['place'] = array ( 'title' =>"Platz" );
$arr['th']['plant_date'] = array ( 'title' =>"Platz" );

//$arr['th']['tree_panel'] = array ( 'title' =>"Widmung" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_client'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'filter' => array ( [ 'field' => 'trash' , 'operator' => '==' , 'value' => '0' ] ) , 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Baum entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

//$arr['top']['button']['modal_form_client'] = array ( 'title' =>'Neue Baumpaten anlegen' , 'icon' => 'plus' , 'class' => 'blue' );

$arr['modal']['modal_form_client'] = array ( 'title' =>'Baumpaten bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
