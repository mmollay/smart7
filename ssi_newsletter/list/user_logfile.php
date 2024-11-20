<?php
if ($_POST['update_id']) $_SESSION['logfile_user_id'] = $_POST['update_id']; 
$arr['mysql'] = array ( 
		'field' => "*",
		'table' => "user_logfile" ,
		'group' => 'log_id', 
		'order' => 'log_date desc' , 
		'limit' => 100 , 
		'where' => "AND contact_id  = '{$_SESSION['logfile_user_id']}'"
);

$arr['list'] = array ( 'id' => 'logfile_list' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition
//$arr['th']['log_id'] = array ( 'title' =>"ID" );
$arr['th']['log_date'] = array ( 'title' =>"Datum" );
$arr['th']['session_id'] = array ( 'title' =>"Session ID" );
$arr['th']['remote_ip'] = array ( 'title' =>"IP" );
$arr['th']['msg'] = array ( 'title' =>"Info" );
