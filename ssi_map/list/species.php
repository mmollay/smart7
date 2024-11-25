<?
$arr['mysql'] = array ( 
		'field' => 't1.temp_id temp_id,fruit_type, t1.timestamp timestamp, t3.title title, COUNT(tree_id) count, t5.title taste' ,
		'table' => 'tree_template t1 
			LEFT JOIN tree_template_lang t2 ON t1.temp_id = t2.temp_id 
			LEFT JOIN tree_group_lang t3 ON t1.group_id = t3.group_id
			LEFT JOIN tree t4 ON t1.temp_id = t4.plant_id 
		    LEFT JOIN tree_taste_lang t5 ON t1.taste_id = t5.taste_id ' ,
		'order' => 'count desc, fruit_type' ,
		'where' => "AND t2.lang = 'de'" ,
		'group' => 't1.temp_id' ,
		'like' => 'fruit_type, t3.title,' ,
		'limit' => '40' );

$arr['list'] = array ( 'id' => 'map_species' , 'width' => '100%' , 'size' => 'small' , 'class' => 'compact celled striped definition unstackable' ); // definition

$arr['filter']['group_id'] = array ( 'type' => 'dropdown' , 'table'=>'t1', 'array' => $array_speciesgroup , 'placeholder' => '--Alle Gattungen--' );
$arr['filter']['taste_id'] = array ( 'type' => 'dropdown' , 'table'=>'t1', 'array' => $array_taste , 'placeholder' => '--Alle Geschmacksrichtungen--' );

$arr['order'] = array ( 'default' => 'title desc' , 
	'array' => array ( 
		'title' => 'Titel aufsteigend sortieren' , 
		'title desc' => 'Titel absteigend sortieren' , 
		'timestamp desc' => 'nach Aktualisierung',
		'count desc' => 'Anzahl der Bäume absteigend sortieren' , 
		'count' => 'Anzahl der Bäume aufsteigend sortieren' 
		) );


$arr['th']['temp_id'] = array ( 'title' =>"ID" );
$arr['th']['fruit_type'] = array ( 'title' =>"<i class='icon lemon'></i>Sorte" );
$arr['th']['title'] = array ( 'title' =>"<i class='pagelines icon'></i>Gattung" );
$arr['th']['taste'] = array ( 'title' =>"Geschmack" );
$arr['th']['count'] = array ( 'title' =>"Anzahl" );
$arr['th']['timestamp'] = array ( 'title' =>"Aktualisierung" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_species'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_map_sort_delete'] = array ('filter' => array ( [ 'field' => 'count' , 'operator' => '==' , 'value' => '0' ]) ,  'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' , 'filter' => array ( [ 'field' => 'count' , 'value' => 0 , 'operator' => '==' ] ) );
$arr['modal']['modal_map_sort_delete'] = array ( 'title' =>'Sorte entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form_species'] = array ( 'title' =>'Neue Sorte anlegen' , 'icon' => 'plus' , 'class' => 'blue' );
$arr['modal']['modal_form_species'] = array ( 'title' =>'Sorte bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );