<?php
$arr ['mysql'] ['field'] = "*,a.timestamp timestamp, 
(CASE
WHEN (lock_session AND success) then '1'
WHEN (lock_session AND !success) then '2'
WHEN (!lock_session AND success) then '3'
WHEN (!lock_session AND !success) then '4'
END) as success
 ";


//$arr ['mysql'] ['debug'] = true;
$arr ['mysql'] ['table'] = 'user2session a
	LEFT JOIN user b ON a.user_id = b.user_id
	LEFT JOIN session c ON a.session_id = c.session_id 
';
$arr ['mysql'] ['order'] = 'a.timestamp desc';
$arr ['mysql'] ['limit'] = 25;
//$arr ['mysql'] ['group'] = 'a.session_id';
$arr ['mysql'] ['like'] = '';
$arr ['mysql'] ['where'] =  'AND c.session_id >0';

$arr['order']['array'] = array ('a.timestamp desc'=>'Datum absteigend','session'=>'Session absteigend');

$arr ['list'] = array ('id' => 'session','width' => '1100px','size' => 'small','class' => 'compact celled striped definition','serial' => false );

//$arr ['th'] ['user_id'] = array ('title' => "ID" );
$arr ['th'] ['session_id'] = array ('title' => "Session" );
$arr ['th'] ['lock_session'] = array ( 'replace' => array('default'=>'Lock','1'=>"<i class='icon lock'></i>",'0'=>"<i class='icon grey unlock'></i>" ) , 'align'=> 'center');
$arr ['th'] ['nickname'] = array ('title' => "User" );
//$arr ['th'] ['email'] = array ('title' => "Email" );
$arr ['th'] ['xr'] = array ('title' => "Xr",'class' => 'blue', 'align'=> 'center' );
$arr ['th'] ['tip'] = array ('title' => "Tip",'class' => 'blue', 'align'=> 'center' );
$arr ['th'] ['level'] = array ('title' => "Level"  , 'align'=> 'center');
$arr ['th'] ['success'] = array ('title' => "Success", 'replace' => array(
		'1'=>"<i class='icon  green check'></i>",
		'2'=>"<i class='icon red times'></i>",
		'3'=>"<i class='icon disabled green check'></i>",
		'4'=>"<i class='icon disabled red times'></i>",
		 
), 'align'=> 'center');
$arr ['th'] ['timestamp'] = array ('title' => "Zeitstempel");
