<?php
$arr['mysql'] = array ( 'table' => "sender" , 
		'field' => "id, if (smtp_server != '', smtp_server, 'localhost') smtp_server,from_name,from_email,test_email" , 
		'order' => 'id desc' , 
		'limit' => 25 , 
		'group' => 'id' , 
		'where' => "AND sender.user_id = '{$_SESSION['user_id']}'" , 
		'like' => 'from_name, from_email, smtp_server' );

$arr['list'] = array ( 'id' => 'profile_list' , 'width' => '800px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

//$arr['th']['id'] = array ( 'title' =>"ID" );
$arr['th']['from_name'] = array ( 'title' =>"<i class='user icon'></i>Name" );
$arr['th']['from_email'] = array ( 'title' =>"<i class='mail icon'></i>Absende-Email" );
$arr['th']['test_email'] = array ( 'title' =>"Testmail" );
//$arr['th']['smtp_server'] = array ( 'title' =>"Server" );

// $arr['filter']['smtp_server'] = array ("type"=>"select", 'array' => array ('smtp.gmail.com'=>'SMTP','test.ssi.at'=>'SSI'));

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_profile'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );
$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['modal']['modal_form_profile'] = array ( 'title' =>'Absender bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Absender entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form_profile'] = array ( 'title' =>'Neuen Absender anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' , 'popup' => 'Neuen Absender anlegen' );