<?php
$arr['mysql'] = array ( 
		'table'=>'tree_places LEFT JOIN tree ON district2 = place_id',
		'field' => "place_id, name, tree_places.zip zip, count(district2) count",
		'order' => 'count desc' , 
		'limit' => 25,  
		'group' => 'place_id',
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'map_location' , 'width' => '800px' , 'size' => 'small' , 'class' => 'compact celled striped definition unstackable' );

$arr['filter']['zip'] = array ('table'=>'tree_places', 'type' => 'dropdown' , 'array' => $array_city , 'placeholder' => '--Alle Städte--' );

$arr['th']['place_id'] = array ( 'title' =>"ID" );
$arr['th']['name'] = array ( 'title' =>"Ort" );
$arr['th']['zip'] = array ( 'title' =>"Plz" );
$arr['th']['count'] = array ( 'title' =>"Anzahl" );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ('filter' => array ( [ 'field' => 'count' , 'operator' => '==' , 'value' => '0' ]) ,  'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' , 'filter' => array ( [ 'field' => 'count' , 'value' => 0 , 'operator' => '==' ] ) );

$arr['modal']['modal_form'] = array ( 'title' =>'Bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );
