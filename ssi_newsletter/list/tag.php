<?php
$count_today = "SUM(DATE(contact2tag.reg_date) = CURDATE() )";
$count_yesterday = "SUM(DATE(contact2tag.reg_date) = CURDATE()-interval 1 day )";
//$count_rest = "SUM(contact2tag.reg_date = (SELECT max(reg_date) FROM contact2tag WHERE tag_id = tag.tag_id))";
$count_rest = "SUM(contact2tag.reg_date AND contact2tag.tag_id = tag.tag_id)";

$label_day = "";


$arr ['mysql'] = array ('table' => '`tag` 
			LEFT JOIN contact2tag ON contact2tag.tag_id = tag.tag_iD
			LEFT JOIN contact ON contact2tag.contact_id = contact.contact_id ',
		'field' => "tag.tag_id id, tag.title, 
		alert,
		count(contact2tag.tag_id) counter,
		if (tag.reg_date !='0000-00-00 00:00:00', DATE(tag.reg_date), '') timestamp,

		(CASE
		WHEN DATE(max(contact2tag.reg_date)) = CURDATE() then CONCAT('<span style=\'color:green\'>Heute</span> ','<div class=\'ui mini label tooltip\' title=\'Neue Einträge: ',$count_today,'\'>',$count_today,'</div>')
		WHEN DATE(max(contact2tag.reg_date)) = CURDATE()-interval 1 day then CONCAT('<span style=\'color:orange\'>Gestern</span> ','<div class=\'ui mini label tooltip\' title=\'Neue Einträge: ',$count_yesterday,'\'>',$count_yesterday,'</div>')
		ELSE CONCAT('vor ',datediff(NOW(), DATE(max(contact2tag.reg_date))),' Tagen ','<div class=\'ui mini label tooltip\' title=\'Neue Einträge: ',$count_rest,'\'>',$count_rest,'</div>')
		END) last_insert_info,

		SUM(DATE(contact2tag.reg_date) > CURDATE()-interval 7 day) last_insert_info_7 ,
		SUM(DATE(contact2tag.reg_date) > CURDATE()-interval 30 day) last_insert_info_30 ,
		SUM(contact.activate = 0 AND contact2tag.tag_id = tag.tag_id) counter2,
		max(contact2tag.reg_date) last_insert
		",
		'order' => 'tag.tag_id desc',
		'limit' => 50,
		'where' => "AND tag.user_id = '{$_SESSION['user_id']}' AND session_id = 0 ",
		'group' => 'tag.tag_id','like' => 'tag.title' );

$arr ['order'] = array ("array" => array ('counter desc' => 'Nach Anzahl der Einträge sortieren','last_insert desc' => 'Nach letzten Einträgen sortieren','tag.title' => 'Nach Titel sortieren' ),'default' => 'last_insert desc' );

$arr ['list'] = array ('id' => 'tag_list','width' => '1200px','size' => 'small','class' => 'compact celled striped definition' ); // definition

if ($_SESSION ['develop_mode'])
	$arr ['th'] ['id'] = array ('title' => "ID" );

$arr ['th'] ['id'] = array ('title' => "ID" );
$arr ['th'] ['title'] = array ('title' => "Bezeichnung" );
$arr ['th'] ['counter'] = array ('title' => "<i class='users icon'></i>User" );
$arr ['th'] ['counter2'] = array ('title' => "<i class='radio icon'></i>Inaktiv" );

$arr ['th'] ['last_insert_info'] = array ('title' => "<i class='clock icon'></i>Letzter Eintrag",'align' => 'right' );
$arr ['th'] ['last_insert_info_7'] = array ('title' => "< 7 Tage",'align' => 'center','info' => 'Einträge in den letzten 7 Tagen' );
$arr ['th'] ['last_insert_info_30'] = array ('title' => "< 30 Tage",'align' => 'center','info' => 'Einträge in den letzten 30 Tagen' );

//$arr['th']['alert'] = array ( 'title' =>"Alert", 'replace' => array('default'=>'','1'=>"<i class='icon green bell'></i>",'0'=>"<i class='icon grey disabled bell'></i>"),  'align' =>'center','info'=>'Infomail bei Neueintrag');
//$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Aktualisiert" , 'align' => 'center' );

$arr ['tr'] ['buttons'] ['left'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['left'] ['modal_form_tag'] = array ('title' => '','icon' => 'edit','class' => 'blue','popup' => 'Bearbeiten' );

$arr ['tr'] ['buttons'] ['right'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['right'] ['modal_form_delete'] = array ('title' => '','icon' => 'trash','popup' => 'Löschen','class' => '' );

$arr ['modal'] ['modal_form_tag'] = array ('title' => 'Tag bearbeiten','class' => '','url' => 'form_edit.php' );
$arr ['modal'] ['modal_form_delete'] = array ('title' => 'Tag entfernen','class' => 'small','url' => 'form_delete.php' );

$arr ['top'] ['button'] ['modal_form_tag'] = array ('title' => 'Neuen Tag anlegen','icon' => 'plus','class' => 'blue circular' );

$arr ['checkbox'] = array ('align' => 'center' );
$arr ['checkbox'] ['buttons'] = array ('class' => 'tiny' );
$arr ['checkbox'] ['button'] ['modal_form_delete'] = array ('title' => 'Delete','icon' => 'delete','class' => 'red mini' );

$count_today = "SUM( DATE(reg_date) = CURDATE() )";
$count_yesterday = "SUM( DATE(reg_date) = CURDATE()-interval 1 day )";
$count_rest = "SUM(tag_id = tag.tag_id AND reg_date = (SELECT max(reg_date) FROM contact2tag WHERE tag_id = tag.tag_id))";

$label_day = "";

// $field_date = "
// (CASE
// WHEN DATE(max(tag.reg_date)) = CURDATE() then CONCAT('<span style=\'color:green\'>Heute</span> ','<div class=\'ui mini label tooltip\' title=\'Neue Einträge: ',$count_today,'\'>',$count_today,'</div>')
// WHEN DATE(max(tag.reg_date)) = CURDATE()-interval 1 day then CONCAT('<span style=\'color:orange\'>Gestern</span> ','<div class=\'ui mini label tooltip\' title=\'Neue Einträge: ',$count_yesterday,'\'>',$count_yesterday,'</div>')
// ELSE CONCAT('vor ',datediff(NOW(), DATE(max(tag.reg_date))),' Tagen ','<div class=\'ui mini label tooltip\' title=\'Neue Einträge: ',$count_rest,'\'>',$count_rest,'</div>')
// END)
// ";

// $arr ['mysql'] = array (
// 		'table' => '`tag` LEFT JOIN contact2tag ON contact2tag.tag_id = tag.tag_id',
// 		'field' => "tag.tag_id id, title,
// 		alert,
// 		count(contact2tag.tag_id) counter,
		
// 		SUM( DATE(tag.reg_date) > CURDATE()-interval 7 day) last_insert_info_7,
// 		SUM( DATE(tag.reg_date) > CURDATE()-interval 30 day) last_insert_info_30,
		
// 		if (tag.reg_date !='0000-00-00 00:00:00', DATE(tag.reg_date), '') timestamp,
// 		(SELECT $field_date FROM contact2tag WHERE tag_id = tag.tag_id) last_insert_info ,
// 		(SELECT max(reg_date) FROM contact2tag WHERE tag_id = tag.tag_id) last_insert,
// 		(SELECT count(*) FROM contact LEFT JOIN contact2tag ON contact2tag.contact_id = contact.contact_id WHERE contact.activate = 0 AND contact2tag.tag_id = tag.tag_id) counter2
// 		",
// 		'order' => 'tag.tag_id desc',
// 		'limit' => 25,
// 		'where' => "AND tag.user_id = '{$_SESSION['user_id']}' AND session_id = 0 ",
// 		'group' => 'tag.tag_id',
// 		'like' => 'title' );
