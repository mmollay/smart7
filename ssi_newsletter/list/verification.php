<?php
$arr['mysql'] = array ( 
		'field' => "verify_id, email, timestamp, if (checked = 1, '<font color=green>Email verifziert</font>', '<font color=red>Email noch nicht verifiziert</font>') checked, checked set_check",
		'table' => "verification" ,
		'group' => "verify_id", 
		'order' => 'verify_id desc' , 
		'limit' => 10 , 
		'where' => "AND user_id = '{$_SESSION['user_id']}'" 
);

$arr['list'] = array ( 'id' => 'verification_list' , 'width' => '800px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['verify_id'] = array ( 'title' =>"ID" );
$arr['th']['email'] = array ( 'title' =>"<i class='user icon'></i>Name" );
$arr['th']['checked'] = array ( 'title' =>"<i class='mail icon'></i>Absende-Email" );
$arr['th']['timestamp'] = array ( 'title' =>"Datum" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_verification'] = array ( 'title' =>' Bestätigen' , 'icon' => 'undo' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten', 'filter' => array ( [ 'field' => 'set_check' , 'value' => '1' , 'operator' => '!=' ] ) );
$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['modal']['modal_form_verification'] = array ( 'title' =>'Verifzierung bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Email entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form_verification'] = array ( 'title' =>'Neue Emailadresse anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' , 'popup' => 'Neue Email für Verifizierung anlegen' );