<?php

// zurpück setzen
// $GLOBALS['mysqli']->query("UPDATE contact SET verify_key = '' ") or die (mysqli_error());

// Nicht vorhandene Tokens erzeugen
$query = $GLOBALS['mysqli']->query ( "SELECT contact_id, verify_key FROM contact WHERE verify_key = ''" ) or die ( mysqli_error () );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$token = md5 ( uniqid ( rand (), true ) );
	$token2 = md5 ( uniqid ( rand (), true ) );
	$id = $array['contact_id'];
	$GLOBALS['mysqli']->query ( "UPDATE contact SET verify_key='$token$token2' WHERE contact_id = $id  " );
}

$array_sex = array ( 'f' => 'Frau' , 'm' => 'Herr' , 'c' => 'Firma' , '' => 'Unbekannt' );

/**
 * ********************************************************************************************************************************************
 * Array : gender
 * *********************************************************************************************************************************************
 */
$sex = "(CASE 
WHEN `sex` = 'm' then '<i class=\"icon man\"></i>'
WHEN `sex` = 'f' then '<i class=\"icon woman\"></i>'
WHEN `sex` = 'c' then '<i class=\"icon building\"></i>'
ELSE ''
END)";

$title = "if (title = '', '',CONCAT (title,' '))";
$reg_date = "if (reg_date !='0000-00-00 00:00:00', DATE(reg_date), '')";
$arr['mysql'] = array ( 'table' => 'contact  LEFT JOIN contact2tag ON contact.contact_id = contact2tag.contact_id' ,
		'field' => "contact.contact_id id, TRIM(email) email,contact.verify_key verify_key,client_number, 
		if (zip,zip,'') zip, telefon,
		CONCAT ($sex,$title,firstname,' ',secondname) name ,
		(SELECT COUNT(*) FROM contact2tag WHERE contact_id = id) counter,
		(SELECT COUNT(*) FROM user_logfile WHERE user_logfile.contact_id = id) user_logfile,
		if (contact.activate = 1, '<i class=\"icon checkmark green\"></i>','<i class=\"icon radio red\"></i>') activate,
		if (timestamp !='0000-00-00 00:00:00', timestamp, '') timestamp" ,
		'order' => 'reg_date, contact.contact_id desc' ,
		'limit' => 50 ,
		'group' => 'contact.contact_id' ,
		'where' => "AND user_id = '{$_SESSION['user_id']}'" ,
		'like' => 'firstname,secondname,email,zip,client_number' ,
		'export' => 'email,firstname,secondname,sex,client_number' );

$arr['order'] = array ( "array" => array ( 'contact.contact_id desc' => 'Nach Anmeldung sortieren' , 'email' => 'Nach Email sortieren' , 'timestamp desc' => 'Nach Aktualisierung sortieren' , 'zip desc' => 'Nach PLZ sortieren' ) , 'default' => 'contact.contact_id desc' );

// if (timestamp !='0000-00-00 00:00:00', DATE(`timestamp`), '') timestamp",

$arr['list'] = array ( 'id' => 'contact_list' , 'align' => '' , 'size' => 'small' , 'width' => '1200px' , 'class' => 'compact celled striped definition' ); // definition

$arr['filter']['tag_id'] = array ( 'type' => 'dropdown' , 'array' => call_array_tags () , 'placeholder' => '--Tags--' , 'class' => '' );
$arr['filter']['activate'] = array ( 'type' => 'dropdown' , 'array' => array ( '1' => 'Aktiv' , '0' => 'Inaktiv' ) , 'placeholder' => '--Aktive und Inaktive--' , 'table' => 'contact' );
$arr['filter']['sex'] = array ( 'type' => 'dropdown' , 'array' => $array_sex , 'table' => 'contact' , 'placeholder' => '--Alle Anreden--' );

if ($_SESSION['develop_mode'])
	$arr['th']['id'] = array ( 'title' =>"ID" );

$arr['th']['name'] = array ( 'title' =>"<i class='user icon'></i>Name" );
$arr['th']['email'] = array ( 'title' =>"<i class='mail icon'></i>Email" );
$arr['th']['zip'] = array ( 'title' =>"PLZ" );
$arr['th']['telefon'] = array ( 'title' =>"Telefon" );
$arr['th']['client_number'] = array ( 'title' =>"Kundennummer" );
// $arr['th']['verify_key'] = array ( 'title' =>"<i class='mail icon'></i>Token" );
// $arr['th']['user_logfile'] = array ( 'title' =>"Logfile" );

$arr['th']['activate'] = array ( 'title' =>"<i class='checkmark icon'></i>Abonniert" , 'align' => 'center' );
// $arr['th']['log_date'] = array ( 'title' =>"Abgemeldet", 'align' => 'center');
$arr['th']['counter'] = array ( 'title' =>"<i class='tags icon'></i>Tags" , 'align' => 'center' );
$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Aktualisiert" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_contact'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );
$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_user_log'] = array ( 'title' =>'' , 'icon' => 'server' , 'class' => '' , 'popup' => 'Logfiles einsehen' , 'filter' => array ( [ 'field' => 'user_logfile' , 'value' => 1 , 'operator' => '>=' ] ) );

$arr['modal']['modal_form_contact'] = array ( 'title' =>'Kontakt bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr ['modal'] ['modal_form_contact'] ['button'] ['submit'] = array ('title' => 'Save','color' => 'blue','form_id' => 'form_edit' ); // form_id = > ID formular
$arr ['modal'] ['modal_form_contact'] ['button'] ['cancel'] = array ('title' => 'Close','color' => 'grey','icon' => 'close' );

$arr['modal']['modal_form_delete'] = array ( 'title' =>'Kontakt löschen' , 'class' => 'small' , 'url' => 'form_delete.php' );
$arr['modal']['modal_user_log'] = array ( 'title' =>'User-Logfiles' , 'class' => 'small' , 'url' => 'smartlist_user_logfiles.php' );


// $arr['top']['buttons'] = array('class'=>'tiny');
$arr['top']['button']['import'] = array ( 'title' =>'Import' , 'icon' => 'upload' , 'popup' => 'mehr als einen Kontakt anlegen', 'onclick'=>"$('.menu_structure .item').tab('change tab', 'import'); load_content_semantic('newsletter','import');" );
$arr['top']['button']['modal_form_contact'] = array ( 'title' =>'Neuer Kontakt' , 'icon' => 'plus' , 'class' => 'blue' , 'popup' => 'Neuen Kontakt anlegen' );

$arr ['checkbox'] = array ('align' => 'center' );
$arr ['checkbox'] ['buttons'] = array ('class' => 'tiny' );
$arr ['checkbox'] ['button'] ['modal_form_delete'] = array ('title' => 'Delete','icon' => 'delete','class' => 'red mini' );



