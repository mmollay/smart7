<?php
$arr['mysql'] = array ( 
		'table' => "blacklist", 
		'field' => '*',
		'order' => 'black_id desc' , 
		'limit' => 25 , 
		'group' => 'black_id',
		'where' => "AND user_id = '{$_SESSION['user_id']}'" , 
		'like' => 'email',
		'export' => 'email,comment,timestamp'
);

$arr['list'] = array ( 'id' => 'black_list' , 'width' => '800px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['black_id'] = array ( 'title' =>"ID" );
$arr['th']['email'] = array ( 'title' =>"<i class='mail icon'></i>Email" );
$arr['th']['comment'] = array ( 'title' =>"<i class='comment icon'></i>Kommentar" );
$arr['th']['timestamp'] = array ( 'title' =>"Eingetragen" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_black'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );
$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['modal']['modal_form_black'] = array ( 'title' =>'Black-User bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Black-User entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form_black'] = array ( 'title' =>'Neuer Black-Kontakt' , 'icon' => 'plus' , 'class' => 'blue circular' , 'popup' => 'Neuen Black-Kontakt anlegen' );