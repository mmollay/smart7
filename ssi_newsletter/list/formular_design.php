<?php
$arr['mysql'] = array ( 
		'table' => "formular_design a INNER JOIN formular b ON a.camp_key = b.camp_key ",  
		'field' => "formdesign_id, b.matchcode fomular, a.matchcode, a.timestamp",
		'order' => 'formdesign_id desc' , 
		'limit' => 25 , 
		'where' => "AND a.user_id = '{$_SESSION['user_id']}'" , 
);

$arr['list'] = array ( 'id' => 'formulardesign_list' , 'width' => '' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

//$arr['th']['formdesign_id'] = array ( 'title' =>"ID" );
$arr['th']['matchcode'] = array ( 'title' =>"Bezeichnung" );
$arr['th']['fomular'] = array ( 'title' =>"Formular" );
$arr['th']['timestamp'] = array ( 'title' =>"Eingetragen" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'small' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue small' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_iframe'] = array ( 'title' =>' Einbinden' , 'icon' => 'code' , 'class' => 'green small' , 'popup' => 'Code Einbinden' );
$arr['tr']['buttons']['right'] = array ( 'class' => 'small' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'small' , 'popup' => 'Löschen' );

$arr['modal']['modal_iframe'] = array ( 'title' =>'Iframe ausgeben' , 'class' => '' , 'url' => 'form_iframe.php' );
$arr['modal']['modal_form'] = array ( 'title' =>'Einbindung bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Einbindung entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Neue Einbindung anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );