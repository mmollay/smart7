<?php
include_once ('../config.inc.php');

$year = $_SESSION['SetYear'];

$lenght_for_text = "IF(LENGTH(text) >= 30, CONCAT(substring(text, 1,30), CONCAT('<span class=\'km_info\' title=\'',text,'\'>[...]</span>')), text)";
$replace_start_point = "REPLACE(start_point,'$home_address','HOME')";
$replace_end_point = "REPLACE(end_point,'$home_address','HOME')";

$arr['mysql'] = array ( 
		'table' => "km_settings LEFT JOIN km_list ON km_list.car_id = km_settings.car_id" ,
		'field' => "km_id,km_from, km_to, km, return_point, country, session_open,
		if (commend != '', CONCAT('',$lenght_for_text,'</span><span  title=\'',commend,'\' class=\'km_alert ui-icon ui-icon-alert red\'/></span>'),$lenght_for_text) text,
		CONCAT ('<div class=color_label style=\'background-color:',car_color,'\'></div>',DATE_FORMAT(km_from, '%Y-%m-%d %H:%i')) km_from,
		if (`return_point` = 0, km, km*2) km,
		if (`return_point` = 0, CONCAT ($replace_start_point,' -> ',$replace_end_point),CONCAT ($replace_start_point,' -> ',$replace_end_point,' -> ',$replace_start_point ))  start_point,
		if (session_open,'<div class=\'text_timer_running\'><b>Aufzeichnung läuft...</b></div>',text) text,
		(CASE
		WHEN HOUR(TIMEDIFF(km_to,km_from)) >= 3 AND HOUR(TIMEDIFF(km_to,km_from)) < 12 then CONCAT('',HOUR(TIMEDIFF(km_to,km_from)),' Stunden')
		WHEN HOUR(TIMEDIFF(km_to,km_from)) >= 12 then CONCAT('',DATEDIFF(km_to,km_from)+1,' Tag, ', DATEDIFF(km_to,km_from),' Nacht')
		WHEN HOUR(TIMEDIFF(km_to,km_from)) < 3 then CONCAT('unter ',HOUR(TIMEDIFF(km_to,km_from)),' Stunden')
		END) as km_to",
		'where' => "AND km_list.user_id = '{$_SESSION['user_id']}' AND DATE_FORMAT(km_from,'%Y') = '$SetYear' AND km_list.car_id = '{$_SESSION['car_id']}' " ,
		'order' => 'km_from desc',
		'group' => 'km_id',
		'like' => 'start_point,text',
		'limit' => '100',
		'export' => 'km_from,km_to,km,start_point,end_point,return_point,text',
);

$arr['list'] = array ( 'id' => 'km_list' , 'width' => '1200px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['km_from'] = array ( 'title' =>"Datum", 'class'=>'two wide' );
$arr['th']['km_to'] = array ( 'title' =>"Zeit" );
$arr['th']['km'] = array ( 'title' =>"Km" );
$arr['th']['start_point'] = array ( 'title' =>"Strecke" );
$arr['th']['text'] = array ( 'title' =>"Beschreibung" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'small' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'delete' , 'popup' => 'Löschen' );

$arr['modal']['modal_form'] = array ( 'title' =>'Eintrag bearbeiten' , 'class' => 'small large' , 'url' => 'form_km.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Eintrag entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );


$arr['top']['button']['modal_form'] = array ( 'title' =>'Neue Fahrt anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );
$arr['top']['button'][] = array ( 'title' =>"<span id='timer'></span> <span class='start_stop_button_text'></span>" , 'icon' => 'clock' , 'class' => 'ui button start_stop_button orange circular' );

//echo "<button class='ui button start_stop_button' id = 'stopped' ><div id='timer'></div> <div class='start_stop_button_text'></div></button>";