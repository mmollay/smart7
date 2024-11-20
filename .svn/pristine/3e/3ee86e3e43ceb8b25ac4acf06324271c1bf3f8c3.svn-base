<?php
$arr['mysql'] = array ( 
		'field' => "template_id, a.timestamp, title, CONCAT (firstname,' ', secondname) user, CONCAT ('<a href=','','>Link</a>') link, IF (set_public = 1,'<font color=green><b>Öffentlich</b></font>','Privat') as set_public",
		'table' => "smart_templates a INNER JOIN ssi_company.user2company b ON a.user_id = b.user_id" , 
		'order' => 'template_id desc ' , 
		'group' => 'template_id',
		'limit' => 25 , 
		'where' => "" , 
		'like' => ''
);

$arr['list'] = array ( 'id' => 'template_list' , 'width' => '1000px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['template_id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"<i class='user icon'></i>Titel" );
$arr['th']['user'] = array ( 'title' =>"<i class='user icon'></i>Name" );
$arr['th']['link'] = array ( 'title' =>"<i class='user icon'></i>Link" );
$arr['th']['set_public'] = array ( 'title' =>"Status" );
$arr['th']['timestamp'] = array ( 'title' =>"Datum" );


$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny');
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny');
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['modal']['modal_form'] = array ( 'title' =>'User bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'User entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

//$arr['top']['button']['modal_form'] = array ( 'title' =>'Neuer Black-Kontakt' , 'icon' => 'plus' , 'class' => 'blue circular' , 'popup' => 'Neuen Black-Kontakt anlegen' );