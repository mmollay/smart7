<?php
$arr['mysql'] = array ( 
		'table'=>'ssi_company.test',
		'field' => "id, title, text, timestamp",
		'order' => '' , 
		'limit' => 25,  
		'group' => 'id',
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'client_list' , 'width' => '800px' , 'size' => 'small' , 'class' => 'compact celled striped definition' );

$arr['th']['id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"Link" );
$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Aktualisiert" , 'align' => 'center' );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

$arr['modal']['modal_form'] = array ( 'title' =>'Bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );
