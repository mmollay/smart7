<?php
$arr['mysql'] = array ( 
		'table'=>'tree_family a LEFT JOIN tree_family_lang b ON family_id = family_lang_id ',
		'field' => "family_id, name",
		'order' => '' , 
		'limit' => 25,  
		'group' => 'family_id',
		'where' => "AND lang='de'",
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'map_family' , 'width' => '800px' , 'size' => 'small' , 'class' => 'compact celled striped definition unstackable' );

//$arr['th']['family_id'] = array ( 'title' =>"ID" );
$arr['th']['name'] = array ( 'title' =>"Ort" );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Familie anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Familie Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

$arr['modal']['modal_form'] = array ( 'title' =>'Bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );
