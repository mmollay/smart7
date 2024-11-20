<?php
include_once ('../config.inc.php');

$year = $_SESSION['SetYear'];

$lenght_for_text = "IF(LENGTH(text) >= 30, CONCAT(substring(text, 1,30), CONCAT('<span class=\'km_info\' title=\'',text,'\'>[...]</span>')), text)";
$replace_start_point = "REPLACE(start_point,'$home_address','HOME')";
$replace_end_point = "REPLACE(end_point,'$home_address','HOME')";


$arr['mysql'] = array ( 
		'table' => "km_settings LEFT JOIN km_list ON km_list.car_id = km_settings.car_id" ,
		'field' => "km_settings.car_id car_id, vehicle_type, home_address, COUNT(km_list.car_id) count,session_open, 
		CONCAT (car_nr,'<div class=color_label style=\'background-color:',car_color,'\'></div>') car_nr",
		'where' => "AND km_settings.user_id = '{$_SESSION['user_id']}'" ,
		'group' => 'km_settings.car_id'
);

$arr['list'] = array ( 'id' => 'car_list' , 'width' => '1200px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['car_id'] = array ( 'title' =>"ID" );
$arr['th']['car_nr'] = array ( 'title' =>"Kennzeichen" );
$arr['th']['vehicle_type'] = array ( 'title' =>"Eintr&auml;ge" );
$arr['th']['home_address'] = array ( 'title' =>"Adresse" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'small' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'delete' , 'popup' => 'Löschen' );

$arr['modal']['modal_form'] = array ( 'title' =>'Fahrzeug bearbeiten' , 'class' => 'small' , 'url' => 'form_car.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Fahrzeug entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Neues Fahrzeug anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );