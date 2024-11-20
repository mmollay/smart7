<?php
$arr['mysql'] = array ( 
		'field' => "tbl_page.page_id page_id, a.user_id user_id, kit_version, user_name, DATE_FORMAT(reg_date,'%Y-%m-%d') reg_date, alias,CONCAT(firstname,' ',secondname) name,
		if (`locked`, CONCAT('<i class=\'icon remove red\'></i>'),CONCAT('<i class=\'icon checkmark green\'></i>')) locked,
		if (`page_locked`, CONCAT('<i class=\'icon remove red\'></i>'),CONCAT('<i class=\'icon checkmark green\'></i>')) page_locked,
		DATE_FORMAT(update_date,'%Y-%m-%d') update_date,
		CONCAT ('<a href=','http://www.',domain,' target=new >',domain,'</a>') domain",	
		'table' => "ssi_company.user2company a ,tbl_page,tbl_domain", 
		'limit' => 25 , 
		'group' => 'tbl_page.page_id',
		'where' => "AND a.user_id = tbl_page.user_id AND tbl_page.page_id = tbl_domain.page_id and alias = 0 and (tbl_domain.kit_version = 'ssi4' or tbl_domain.kit_version = '') " , 
		'like' => 'firstname, secondname, user_name, domain, tbl_user.user_id'
);

$arr['order'] = array('default'=>'tbl_page.page_id desc', 'array' => array ('a.user_id desc'=>'User absteigend','a.user_id'=>'User aufsteigend','tbl_page.page_id'=>'Seite aufsteigend','tbl_page.page_id desc'=>'Seiten absteigend','update_date desc'=>'Aktualisierung'));

$arr['list'] = array ( 'id' => 'constructor_list' , 'width' => '1000px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['page_id'] = array ( 'title' =>"Page-ID" );
$arr['th']['user_id'] = array ( 'title' =>"User-ID" );
$arr['th']['page_locked'] = array ( 'title' =>"<i class='lock icon'></i>", 'align' => 'center' );
$arr['th']['name'] = array ( 'title' =>"<i class='user icon'></i>Name" );
$arr['th']['domain'] = array ( 'title' =>"<i class='world icon'></i>Domain" );
$arr['th']['reg_date'] = array ( 'title' =>"<i class='time icon'></i>Registriert" );
$arr['th']['update_date'] = array ( 'title' =>"<i class='time icon'></i>Update" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny');
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny');
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['modal']['modal_form'] = array ( 'title' =>'Seite bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Seite entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

//$arr['top']['button']['modal_form'] = array ( 'title' =>'Neuer Black-Kontakt' , 'icon' => 'plus' , 'class' => 'blue circular' , 'popup' => 'Neuen Black-Kontakt anlegen' );