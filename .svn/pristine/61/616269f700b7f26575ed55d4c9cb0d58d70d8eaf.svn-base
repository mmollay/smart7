<?php
if ($_POST['id']) $id = $_POST['id']; 

$arr['mysql'] = array ( 
		'table'=>'user_logfile LEFT JOIN contact ON user_logfile.contact_id = contact.contact_id ',
		'field' => 'log_id,log_date,email,system',
		'order' => 'log_date desc' , 
		'group' => 'contact.contact_id',
		'limit' => 20 , 
		'where' => "AND session_id = $id AND status_id = 3 AND contact_id",
		'like' => 'email'
);

$arr['list'] = array ( 'id' => 'unsubrscribe_list' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition
$arr['th']['log_id'] = array ( 'title' =>"ID" );
$arr['th']['log_date'] = array ( 'title' =>"Datum" );
$arr['th']['email'] = array ( 'title' =>"Email" );
$arr['th']['system'] = array ( 'title' =>"Abgemeldet über", 'replace'=>array('mailjet'=>'Mailjet',''=>'Eigenes System') );
