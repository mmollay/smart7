<?php

//Gel all companys
$query = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_company.tbl_company" ) or die ( mysqli_error () );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$company_array[$array['company_id']] = $array['title'];
}

$arr ['mysql'] = array (
		'field' => "domain_id set_domain_id, company.company_id, company.title, domain.page_id, domain.set_ssl, 
		if (set_public = 1,CONCAT('<button class=button_set_public id=',t3.page_id,'>Seite freigeben</button>'),'') set_public,
		if (smart_version='beta','<div class=\'label ui orange mini\'>Beta</div>',CONCAT('<div class=\'label ui mini\'>',if(smart_version='','stable',smart_version),'</div>')) smart_version,
		smart_version version,	
		verify_key,
		(SELECT option_value FROM smart_options WHERE page_id = domain.page_id AND option_name = 'TrackingCode' ) TrackingCode,
		(SELECT title FROM smart_user_right t2 WHERE t2.right_id = t3.right_id) right_text,
		(SELECT COUNT(parent_id) FROM ssi_company.domain WHERE parent_id = set_domain_id) alias_count, 
		t2.user_id user_id, t2.user_name user_name, DATE_FORMAT(t2.reg_date,'%Y-%m-%d'), t2.reg_date reg_date, CONCAT(firstname,' ',secondname) name,
		smart_domain_alias, password,
		if (domain.locked, CONCAT('<div style=\'color:red\'>gesperrt</div>'),CONCAT('<div style=\'color:green\'>aktiv</div>')) locked,
		if (smart_page_locked, CONCAT('<i class=\'icon remove red\'></i>'),CONCAT('<i class=\'icon checkmark green\'></i>')) page_locked,
		DATE_FORMAT(update_date,'%Y-%m-%d') update_date, domain",
		//		'table' => "ssi_company.domain domain,tbl_user,smart_page,ssi_company.tbl_company company", 
		'table' => "ssi_company.domain domain
			LEFT JOIN smart_page t3 ON t3.user_id = domain.user_id
			LEFT JOIN ssi_company.user2company t2 ON domain.user_id = t2.user_id
			LEFT JOIN ssi_company.tbl_company company ON company.company_id = domain.company_id
		",'limit' => 120,'group' => 'domain_id','where' => "AND domain.parent_id = 0 ",
		'like' => 'firstname,secondname,domain,t2.user_id,TrackingCode,t3.page_id' );

$arr ['checkbox'] ['button'] ['modal_form_delete'] = array ('title' => 'Löschen','class' => 'red' );

$arr ['list'] = array ('id' => 'domain_list','width' => '1200px','align' => '','size' => 'small','class' => 'compact celled striped definition' ); // definition
$arr ['list'] ['serial'] = false;
$arr ['order'] = array ('default' => 'page_id desc',
		'array' => array ('smart_page.user_id desc' => '<i class="icon arrow down"></i>User absteigend','smart_page.user_id' => '<i class="arrow up icon"></i>User aufsteigend','page_id desc' => '<i class="icon arrow down"></i>Seiten absteigend',
				'page_id' => '<i class="icon arrow up"></i>Seite aufsteigend','update_date desc' => 'Nach Aktualisierung','set_ssl desc' => 'Nach SSL','set_ssl' => 'Nach SSL' ) );


$arr['filter']['company_id'] = array ('table' => 'company', 'type' => 'dropdown' , 'array' =>$company_array  , 'placeholder' => '--Alle anzeigen--' );

$arr ['th'] ['set_domain_id'] = array ('title' => "ID" );
//$arr ['th'] ['company_id'] = array ('title' => "Firmen-ID" );


//$arr['th']['title'] = array ( 'title' =>"Company" );
$arr ['th'] ['locked'] = array ('title' => "<i class='eye icon'></i>",'align' => 'center' );
$arr ['th'] ['domain'] = array ('title' => "<i class='world icon'></i>Domain",'replace' => array ('true' => '<a title="{value} öffnen" class="tooltip label ui small" target="new" href="https://{value}"><i class="icon world"></i> {value}</a>','' => "" ) );
$arr ['th'] ['name'] = array ('title' => "<i class='user icon'></i>Name" );
$arr ['th'] ['TrackingCode'] = array ('title' => "<i class='user icon'></i>Tracking Code" );
$arr ['th'] ['user_id'] = array ('title' => "User-ID" );
$arr ['th'] ['page_id'] = array ('title' => "Page-ID" );
$arr ['th'] ['right_text'] = array ('title' => "<i class='protect icon'></i>Rechte" );
$arr ['th'] ['smart_version'] = array ('title' => "Version",'align' => 'center' );
//$arr['th']['verify_key'] = array ( 'title' =>"Version", 'align' => 'center');
//$arr['th']['domain'] = array ( 'title' =>"<i class='world icon'></i>Domain" );
$arr ['th'] ['set_ssl'] = array ('align' => 'center','title' => "<i class='expeditedssl icon'></i>SSL",'replace' => array ('default' => '','1' => "<i class='icon green large lock'></i>",'0' => "<i class='icon lock large disabled'></i>" ) );

$arr ['th'] ['alias_count'] = array ('title' => "Alias",'replace' => array ('default' => '<div class="tooltip" title="{value} Subdomains"><i class="ellipsis horizontal icon"></i><div>','0' => "" ) );

//$arr['th']['reg_date'] = array ( 'title' =>"<i class='time icon'></i>Registriert" );
$arr ['th'] ['update_date'] = array ('title' => "<i class='time icon'></i>Update" );

$arr ['tr'] ['buttons'] ['left'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['left'] ['modal_form'] = array ('title' => '','icon' => 'edit','class' => 'blue mini','popup' => 'Bearbeiten' );
$arr ['tr'] ['button'] ['left'] ['modal_form2'] = array ('filter' => array ([ 'field' => 'set_ssl','operator' => '==','value' => 1 ] ),'title' => '','icon' => 'show sign in','class' => 'mini','popup' => 'Einloggen',
		'onclick' => "window.open('http://{domain}/admin/index.php?verify_key={verify_key}','_blank')" );
$arr ['tr'] ['button'] ['left'] ['modal_form3'] = array ('filter' => array ([ 'field' => 'set_ssl','operator' => '==','value' => 0 ] ),'title' => '','icon' => 'show sign in','class' => 'mini','popup' => 'Einloggen','onclick' => "window.open('../index.php?verify_key={verify_key}','_blank')" );

//$arr['tr']['button']['left']['modal_form2'] = array ( 'title' =>'' , 'icon' => 'show sign in' , 'class' => 'mini' , 'popup' => 'Einloggen', 'onclick'=>"location.href='../ssi_smart/index.php?page_select={id}';" );

$arr ['tr'] ['buttons'] ['right'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['right'] ['modal_form_delete'] = array ('title' => '','icon' => 'trash','class' => 'mini','popup' => 'Löschen' );

$arr ['modal'] ['modal_form'] = array ('title' => 'Seite bearbeiten','class' => '','url' => 'form_edit.php' );
$arr ['modal'] ['modal_form_delete'] = array ('title' => 'Seite entfernen','class' => 'small','url' => 'form_delete.php' );

//$arr['top']['button']['modal_form'] = array ( 'title' =>'Neuer Black-Kontakt' , 'icon' => 'plus' , 'class' => 'blue circular' , 'popup' => 'Neuen Black-Kontakt anlegen' );