<?php
$arr['mysql'] = array ( 
		'table'=>'code a 
		LEFT JOIN promotion p ON a.promotion_id = p.promotion_id
		LEFT JOIN contact c ON c.contact_id = a.contact_id',
		'field' => "code_id, p.title title, code, a.timestamp timestamp, email",
		'order' => '' , 
		'limit' => 25,  
		//'debug'=> true,
		'group' => 'a.code_id',
		'where' => "AND p.user_id = '{$_SESSION['user_id']}' " ,
		'like' => 'code,email'
);

$arr['list'] = array ( 'id' => 'code_list' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['filter']['promotion_id'] = array ( 'type' => 'select', 'array' => call_array_promotion(), 'placeholder' => '--Promotion--', 'class'=>'',  'table'=>'a' );

//$arr['th']['code_id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"Promotion");
$arr['th']['code'] = array ( 'title' =>"Code" );
$arr['th']['email'] = array ( 'title' =>"<i class='user icon'></i>Userzuweisung");
$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Erzeugt" , 'align' => 'center' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
//$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['right']['modal_form_delete_code'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'', 'filter' => array(['field' => 'email', 'value' =>'', 'operator' => '=='  ]) );

$arr['modal']['modal_form_code'] = array ( 'title' =>'Code bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete_code'] = array ( 'title' =>'Code entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form_code'] = array ( 'title' =>'Neue Codes eintragen' , 'icon' => 'plus' , 'class' => 'blue circular' );