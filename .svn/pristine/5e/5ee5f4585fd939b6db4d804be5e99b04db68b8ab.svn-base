<?php
$arr['mysql'] = array ( 
		'table' => "followup_send a
		LEFT JOIN contact b ON a.contact_id = b.contact_id	
		LEFT JOIN followup_mail c ON a.mail_id = c.mail_id 	",
		'field' => "a.send_id send_id, b.email email, c.matchcode email_matchcode",
		'order' => 'send_id desc' , 
		'limit' => 25 , 
		'group' => 'a.send_id',
		'where' => "AND a.user_id = '{$_SESSION['user_id']}' " , 
		'like' => 'c.matchcode',
);

$arr['list'] = array ( 'id' => 'pool_list' , 'width' => '1000px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['send_id'] = array ( 'title' =>"ID" );
$arr['th']['email'] = array ( 'title' =>"Empfänger" );
$arr['th']['email_matchcode'] = array ( 'title' =>"Email-Beschreibung" );

$arr['tr']['button']['right']['modal_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );
$arr['modal']['modal_delete'] = array ( 'title' =>'Pool entfernen' , 'class' => 'small' , 'url' => 'form_delete.php', 'filter' =>array(['field' => 'count', 'operator' => '>' ,  'value' => 0]) );
