<?php
if ($_POST['id']) $_SESSION['logfile_session_id'] = $_POST['id']; 
$arr['mysql'] = array ( 
		'field' => "log_id, date, 
		(CASE 
		WHEN type = 'error' THEN CONCAT('<font color=red>',text,'</font>')
		WHEN type = 'success' THEN CONCAT('<font color=green>',text,'</font>')
		ELSE text
		END) text",
		'table'=> "session_logfile" , 
		'group_id' => 'log_id',
		'order' => 'log_id desc' , 
		'limit' => 20 , 
		'where' => "AND session_id  = '{$_SESSION['logfile_session_id']}'" ,
);
$arr['list'] = array ( 'id' => 'logfile_list' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition
$arr['th']['log_id'] = array ( 'title' =>"ID" );
$arr['th']['date'] = array ( 'title' =>"Datum" );
$arr['th']['text'] = array ( 'title' =>"Bericht" );

$arr['top']['button'][] = array ( 'title' =>'Fehlerhafte Mails nochmal senden' , 'icon' => 'refresh' , 'class' => 'blue', 'onclick'=>"reset_error_mails({$_SESSION['logfile_session_id']});",'filter'=>"SELECT * FROM logfile WHERE session_id='{$_SESSION['logfile_session_id']}' AND error=1 " );
