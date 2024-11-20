<?php
$arr['mysql'] = array (
		'table'=>'tree_taste_lang',
		'field' => "taste_id, title",
		'order' => '' ,
		'limit' => 25,
		'group' => 'taste_id',
		'where' => "AND lang='de'",
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'map_taste' , 'width' => '800px' , 'size' => 'small' , 'class' => 'compact celled striped definition unstackable' );

// $arr['th']['taste_id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"Geschmack" );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Geschmack anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

$arr['modal']['modal_form'] = array ( 'title' =>'Geschmack bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Geschmack entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );
