<?php
//Gel all companys
$query = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_company.tbl_company" ) or die ( mysqli_error () );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$company_array [$array ['company_id']] = $array ['title'];
}

// $arr['mysql'] = array (
// 		'field' => "t1.user_id user_id,
// 		if (user_checked || fbid || verified, CONCAT('<i class=\'icon green large check square\'></i>'),CONCAT('<i class=\'icon disabled large check square\'></i>')) user_checked,
// 		if (locked, CONCAT('<i class=\'icon red large remove\'></i>'),CONCAT('')) locked,
// 		if (fbid, CONCAT ('<a target=facebook href=\'',link,'\' style=\'padding:2px;\' class=\'button icon ui facebook\'><i class=\'icon facebook f\'></i></a>'),'') facebook,
// 		right_id,
// 		(SELECT title FROM smart_user_right WHERE smart_user_right.right_id = t1.right_id ) right_text,
// 		if (!number_of_smartpage,1,number_of_smartpage) number_of_smartpage,
// 		if (parent_id=0,'',parent_id) parent_id,
// 		(SELECT if(Count(*)>0,Count(*),'') from tbl_user  WHERE parent_id = t1.user_id) counter_recom,
// 		DATE_FORMAT(t1.reg_date,'%Y-%m-%d') reg_date, CONCAT(firstname,' ',secondname) name,
// 		t1.user_name user_name, password,
// 		if (`locked`, CONCAT('<i class=\'icon large lock red popup\' title=\'Offen\' ></i>'),CONCAT('<i class=\'icon unlock large green popup\' title=\'Offen\' ></i>')) status,
// 		if (parent_id, (SELECT CONCAT(firstname,' ',secondname) FROM tbl_user WHERE user_id = t1.parent_id),'') parent_id,
// 		(SELECT if(Count(*)>0,Count(*),'') FROM smart_page WHERE user_id = t1.user_id) counter_smart_page,
// 		(SELECT MAX(DATE_FORMAT(update_date,'%Y-%m-%d')) FROM smart_page WHERE user_id = t1.user_id) update_date,
// 		(SELECT if(Count(*)>0,Count(*),'') FROM module2id_user WHERE user_id = t1.user_id AND module = 'newsletter') counter_newsletter",
// 		'table' => "tbl_user t1 LEFT JOIN ssi_company.user2company t2 ON t1.user_id = t2.user_id",
// 		'order' => 'user_id desc ' ,
// 		'group'=> 't1.user_id',
// 		'limit' => 20 ,
// 		'where' => "" ,
// 		'like' => 't1.user_name, firstname, secondname, t1.user_id'
// );

$arr ['mysql'] = array (
		//'debug'=>true,
		'field' => "t2.user_id user_id, company.company_id, 
		if (smart_version='beta','<div class=\'label ui orange mini\'>Beta</div>',CONCAT('<div class=\'label ui mini\'>',if(smart_version='','stable',smart_version),'</div>')) smart_version,
		if (user_checked || fbid || verified, CONCAT('<i class=\'icon green large check square\'></i>'),CONCAT('<i class=\'icon disabled large check square\'></i>')) user_checked,
		if (locked, CONCAT('<i class=\'icon red large remove\'></i>'),CONCAT('')) locked,
		if (fbid, CONCAT ('<a target=facebook href=\'',link,'\' style=\'padding:2px;\' class=\'button icon ui facebook\'><i class=\'icon facebook f\'></i></a>'),'') facebook,
		t3.right_id,
		COUNT(t3.user_id) counter_smart,
		(SELECT title FROM smart_user_right WHERE smart_user_right.right_id = t2.right_id ) right_text,
		if (!number_of_smartpage,1,number_of_smartpage) number_of_smartpage,
		if (parent_id=0,'',parent_id) parent_id,
		(SELECT if(Count(*)>0,Count(*),'') from ssi_company.user2company  WHERE parent_id = t2.user_id) counter_recom,
		DATE_FORMAT(t2.reg_date,'%Y-%m-%d') reg_date, CONCAT(firstname,' ',secondname) name,
		t2.user_name user_name, password,
		if (`locked`, CONCAT('<i class=\'icon large lock red popup\' title=\'Offen\' ></i>'),CONCAT('<i class=\'icon unlock large green popup\' title=\'Offen\' ></i>')) status,
		if (parent_id, (SELECT CONCAT(firstname,' ',secondname) FROM ssi_company.user2company WHERE user_id = t2.parent_id),'') parent_id,
		(SELECT MAX(DATE_FORMAT(update_date,'%Y-%m-%d')) FROM smart_page WHERE user_id = t2.user_id) update_date,
		(SELECT if(Count(*)>0,Count(*),'') FROM module2id_user WHERE user_id = t2.user_id AND module = 'newsletter') counter_newsletter",

		'table' => "ssi_company.user2company t2  
			LEFT JOIN smart_page t3 ON t3.user_id = t2.user_id
			LEFT JOIN ssi_company.tbl_company company ON company.company_id = t2.company_id
			",'order' => 't2.user_id desc ','group' => 't2.user_id','limit' => 100,
		//'debug'=> true,
		//'where' => 'AND t3.user_id  != "" ',
		'like' => 't2.user_name, firstname, secondname, t2.user_id' );

$arr ['order'] = array ('default' => 'user_id desc','array' => array ('user_id desc' => 'User absteigend','update_date desc' => 'Aktualisierung','counter_smart desc' => 'Anzahl der Seiten (absteigend)','counter_smart ' => 'Anzahl der Seiten (aufsteigend)' ) );

$array_counter_smart_page = array ("user_checked > 0" => 'Verifiziert',"user_checked = 0" => 'Nicht verifiziert',"smart_version=\"\" " => 'Stable',"smart_version=\"beta\" " => 'Beta',"t3.user_id " => 'User MIT Webseiten' );

$arr ['checkbox'] ['button'] ['modal_form_delete'] = array ('title' => 'Löschen','class' => 'red' );

$arr ['filter'] ['company_id'] = array ('table' => 'company','type' => 'dropdown','array' => $company_array,'placeholder' => '--Company--' );

$arr ['filter'] ['user_checked'] = array ('type' => 'dropdown','query' => "{value}",'array' => $array_counter_smart_page,'placeholder' => '--Alle anzeigen--' );
// $arr['filter']['select_month'] = array ( 'type' => 'dropdown' , 'query' => "{value}" , 'array' => $array_filter_month , 'placeholder' => '--Alle Monate--' );
// $arr['filter']['select_id'] = array ( 'type' => 'dropdown' , 'query' => "{value}" , 'array' => $array_filter , 'placeholder' => '--Kein Filter--' );
// $arr['filter']['account'] = array ( 'type' => 'dropdown' , 'array' => $account_array , 'placeholder' => '--Alle Konten--' );

$arr ['list'] = array ('id' => 'user_list','width' => '1200px','align' => '','size' => 'small','class' => 'compact celled striped definition' ); // definition
$arr ['list'] ['serial'] = false;

//$arr['list']['auto_reload'] = array ( 'label'=>'Automatisches aktualisieren', 'checked'=>TRUE, 'loader'=>FALSE);
$arr ['th'] ['user_id'] = array ('title' => "ID" );
//$arr ['th'] ['company_id'] = array ('title' => "Firmen-ID" );
$arr ['th'] ['user_checked'] = array ('title' => '<i class="icon check square popup" title="Verifizierte User" ></i>','align' => 'center' );
$arr ['th'] ['locked'] = array ('title' => '<i class="icon remove popup" title="Gesperrte User" ></i>','align' => 'center' );
$arr ['th'] ['facebook'] = array ('title' => "<i class='facebook icon'></i>",'align' => 'center' );
$arr ['th'] ['user_name'] = array ('title' => "<i class='mail icon'></i>Username" );
$arr ['th'] ['name'] = array ('title' => "<i class='user icon'></i>Name" );
//$arr['th']['parent_id'] = array ( 'title' =>"Quelle" );
$arr ['th'] ['counter_smart'] = array ('title' => "Smart",'align' => 'center' );

$arr ['th'] ['right_text'] = array ('title' => "<i class='protect icon'></i>Rechte" );
$arr ['th'] ['smart_version'] = array ('title' => "Version",'align' => 'center' );
$arr ['th'] ['reg_date'] = array ('title' => "Eingetragen",'align' => 'center' );
$arr ['th'] ['update_date'] = array ('title' => "Update",'align' => 'center' );

// $arr['tr']['buttons']['left'] = array ( 'class' => 'tiny');
// $arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );
// $arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr ['tr'] ['buttons'] ['left'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['left'] ['modal_form'] = array ('title' => '','icon' => 'edit','class' => 'blue mini','popup' => 'Bearbeiten' );
$arr ['tr'] ['button'] ['left'] ['modal_form2'] = array ('title' => '','icon' => 'show sign in','class' => 'mini','popup' => 'Einloggen','onclick' => "location.href='../ssi_dashboard/index.php?user_name={user_name}&password={password}';" );

$arr ['tr'] ['buttons'] ['right'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['right'] ['modal_form_delete'] = array ('title' => '','icon' => 'trash','class' => 'mini','popup' => 'Löschen' );

$arr ['modal'] ['modal_form'] = array ('title' => 'User bearbeiten','class' => '','url' => 'form_edit.php' );
$arr ['modal'] ['modal_form_delete'] = array ('title' => 'User entfernen','class' => 'small','url' => 'form_delete.php' );

$arr ['top'] ['button'] ['modal_form'] = array ('title' => 'Neuen User anlegen','icon' => 'plus','class' => 'blue circular' );