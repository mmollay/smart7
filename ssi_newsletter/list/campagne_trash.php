<?php
$arr['mysql'] = array ( 'table' => 'session LEFT JOIN tag ON tag.tag_id = session.tag_id' , 
		'field' => 'session.session_id as session_id,from_email,session.title' , 
		'order' => 'session.session_id desc' , 
		'limit' => 50 , 
		'where' => "AND session.user_id  = '{$_SESSION['user_id']}' AND remove_nl = 1 " , 
		'group' => 'session.session_id' , 
		'like' => 'session.title' );

$arr['list'] = array ('id' => 'newsletter_trash_list' , 'width' => '1300px' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition
$arr['th']['from_email'] = array ( 'title' =>"Absender" );
$arr['th']['title'] = array ( 'title' =>"Bezeichnung" );
$arr['tr']['buttons']['left'] = array ( 'class' => 'compact' );
$arr['tr']['button']['left']['modal_form_newsletter'] = array ( 'title' =>' Zurücksetzen' , 'icon' => 'refresh' , 'class' => 'blue', 'onclick' => "nl_trashback({id});" );

$arr['tr']['buttons']['right'] = array ( 'class' => 'compact basic' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'remove' , 'class' => 'red' , 'popup' => 'Löschen' ); // , 'filter' => array ( [ 'field' => 'status' , 'value' => '3' , 'operator' => '<' ])

$arr['modal']['modal_form_delete'] = array ( 'title' =>'Aussendung löschen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr ['checkbox'] ['button'] ['modal_form_delete'] = array ('title' => 'Delete','icon' => 'delete','class' => 'red mini' );