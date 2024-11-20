<?php
$arr ['mysql'] = array (
		'field' => "id,DATE_FORMAT(modified,'%Y-%m-%d') modified, set_ssl, domain_alias,CONCAT(firstname,' ',secondname) name,
		if (page_locked, CONCAT('<i class=\'icon remove red\'></i>'),CONCAT('<i class=\'icon checkmark green\'></i>')) page_locked,
		title,t1.user_id,homedir,userid,passwd,count,domain ",'table' => "ftpdb.ftpuser t1 LEFT JOIN ssi_company.user2company t2 ON t1.user_id = t2.user_id ",'limit' => 20,'group' => 'id','like' => 'title, domain, domain_alias' );

$arr ['list'] = array ('id' => 'ftp_list','align' => '','size' => 'small','class' => 'compact celled striped definition' ); // definition
$arr ['list'] ['serial'] = false;

$arr ['order'] = array ('default' => 'id','array' => array ('id desc' => 'ID absteigend','id' => 'ID aufsteigend' ) );

//$arr ['th'] ['id'] = array ('title' => "ID" );
//$arr ['th'] ['user_id'] = array ('title' => "User_ID" );
$arr ['th'] ['title'] = array ('title' => "Beschreibung" );
$arr ['th'] ['name'] = array ('title' => "<i class='user icon'></i>Name" );
$arr ['th'] ['page_locked'] = array ('title' => "<i class='eye icon'></i>",'align' => 'center' );
$arr ['th'] ['set_ssl'] = array ('align' => 'center','title' => "<i class='expeditedssl icon'></i>SSL",'replace' => array ('default' => '','1' => "<i class='icon green large lock'></i>",'0' => "<i class='icon lock large disabled'></i>" ) );
$arr ['th'] ['homedir'] = array ('title' => "<i class='folder icon'></i>",'replace' => array ('default' => '<div class="tooltip" title="{value}"><i class="linkify icon"></i><div>' ) );
$arr ['th'] ['userid'] = array ('title' => "<i class='user icon'></i>Username" );
//$arr['th']['passwd'] = array ( 'title' =>"Password" );
$arr ['th'] ['domain'] = array ('title' => "<i class='world icon'></i>Domain",'replace' => array ('default' => '<a title="{value} öffnen" class="tooltip label ui small" target="new" href="http://{value}"><i class="icon world"></i>{value}</a>','' => "" ) );
$arr ['th'] ['domain_alias'] = array ('title' => "Alias",'replace' => array ('default' => '<div class="tooltip" title="{value}"><i class="ellipsis horizontal icon"></i>Mehr<div>','' => "" ) );
$arr ['th'] ['modified'] = array ('title' => "<i class='date icon'></i>Letztes Login" );
$arr ['th'] ['count'] = array ('title' => "Counter" );

$arr ['tr'] ['buttons'] ['left'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['left'] ['modal_form'] = array ('title' => '','icon' => 'edit','class' => 'blue mini','popup' => 'Bearbeiten' );

$arr ['tr'] ['buttons'] ['right'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['right'] ['modal_form_delete'] = array ('title' => '','icon' => 'trash','class' => 'mini','popup' => 'Löschen' );

$arr ['modal'] ['modal_form'] = array ('title' => 'Seite bearbeiten','class' => '','url' => 'form_edit.php' );
$arr ['modal'] ['modal_form_delete'] = array ('title' => 'Seite entfernen','class' => 'small','url' => 'form_delete.php' );

$arr ['top'] ['button'] ['modal_form'] = array ('title' => 'Neuen FTP-User anlegen','icon' => 'plus','class' => 'blue circular' );