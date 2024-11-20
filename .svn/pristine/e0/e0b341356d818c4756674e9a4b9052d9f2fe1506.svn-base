<?php
$count_trigger_tag = "(SELECT COUNT(*) FROM f_trigger2tag WHERE a.followup_id = f_trigger2tag.followup_id AND !no AND !new)";

$count_trigger_not_tag = "(SELECT COUNT(*) FROM f_trigger2tag WHERE a.followup_id = f_trigger2tag.followup_id AND no AND !new)";

$count_trigger_new_tag = "(SELECT COUNT(*) FROM f_trigger2tag WHERE a.followup_id = f_trigger2tag.followup_id AND !no AND new)";

$trigger_step = "CONCAT('Auslösen durch <div class=\"ui label\">',(SELECT matchcode FROM followup WHERE followup_id = step_id),'</div>')";

$trigger_listbuilding = "CONCAT('Auslösen durch Listbuilding <div class=\"ui label\">',(SELECT matchcode FROM formular WHERE form_id = listbuilding_id),'</div>')";
// $trigger_tag = "CONCAT('Auslösen über Tag <div class=\"ui label\">',(SELECT matchcode FROM followup WHERE followup_id = mail_id),'</div>')";

$count_action_tag = "(SELECT COUNT(*) FROM f_action2tag WHERE a.followup_id = f_action2tag.followup_id AND !no)";
$count_action_not_tag = "(SELECT COUNT(*) FROM f_action2tag WHERE a.followup_id = f_action2tag.followup_id AND no)";

$mysql_set_time = "IF (d.day,CONCAT(d.day,' t'),''), IF (d.hour,CONCAT(' ',d.hour,' h'),''), IF (d.min,CONCAT(' ',d.min,' m'),'')";

$pool_id = $_SESSION['filter']['followup_list']['pool_id'];
if ($pool_id == 'all' or ! $pool_id) {
	//$arr['content']['bottom'] = 'Bitte Pool auswählen';
	$list_hide = true;
	$search_fields = '';
}
else {
	$search_fields = 'a.matchcode';
}

//IF (start_followup_id,'<div class=\'ui basic green label tooltip\' title=\'Startsequenenz\'><i class=\'icon flag\'></i>Start</div>',''),

$arr['top']['button']['modal_form_step'] = array ( 'title' =>'Neuen Step anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );
$arr['mysql'] = array ( 'table' => "followup a
		LEFT JOIN f_mail2followup n ON a.followup_id = n.followup_id
		LEFT JOIN followup_mail m ON m.mail_id = n.mail_id  
		LEFT JOIN f_trigger2followup b ON a.followup_id = b.followup_id
		LEFT JOIN f_trigger2listbuilding c ON a.followup_id = c.followup_id
		LEFT JOIN f_trigger2time d ON a.followup_id = d.followup_id
		LEFT JOIN followup_pool e ON a.followup_id = e.start_followup_id
		LEFT JOIN session f ON (f.followup_id = b.followup_id AND status <= 3 AND remove_nl = 0)
		" , 
		'field' => "
		a.followup_id followup_id, a.matchcode matchcode, a.pool_id pool_id,sorted,trigger_modus, b.step_id step_id, m.title,
		COUNT(f.followup_id) user,
		CONCAT(
		(CASE
		WHEN trigger_modus = 'trigger_by_step' AND step_id then CONCAT('<div class=\'ui basic orange label tooltip\' data-html=\'',$trigger_step,'\'><i class=\'icon orange tag\'></i>ID ',step_id,'</div>')
		WHEN trigger_modus = 'trigger_by_listbuilding' AND listbuilding_id then CONCAT('<div class=\'ui basic orange label tooltip\' data-html=\'',$trigger_listbuilding,'\'><i class=\'icon orange list\'></i>Listbuilding</div>')
		WHEN trigger_modus = 'trigger_by_tag' AND $count_trigger_new_tag then CONCAT('<div class=\'ui basic orange label tooltip\' title=\'Auslösen über Tag\'><i class=\'icon orange tag\'></i>Tag</div>')
		ELSE ''
		END),
		
		IF($count_trigger_tag,CONCAT('<div class=\'ui basic label tooltip\' title=\'Auslöser bei Tags\'><i class=\'icon green tag\'></i>',$count_trigger_tag,'</div>'),''),
		IF($count_trigger_not_tag,CONCAT('<div class=\'ui basic label tooltip\' title=\'Auslöser bei Nicht-Tags\'><i class=\'icon red tag \' ></i>',$count_trigger_not_tag,'</div>'),''),
		
		IF($count_action_tag,CONCAT('<div class=\'ui basic tooltip label\' title=\'Tags hinzuf&uuml;gen\'><i class=\'icon grey tag\' ></i>+',$count_action_tag,'</div>'),''),
		IF($count_action_not_tag,CONCAT('<div class=\'ui basic label tooltip\' title=\'Tags entziehen\'><i class=\'icon grey tag\'></i>-',$count_action_not_tag,'</div>'),''),
		
		(CASE
		WHEN d.mode= 'periode' then CONCAT('<div class=\'ui basic icon blue label tooltip\' data-variation=\'wide\' data-html=\'Versendezeit nach Zeitraum\'><i class=\'icon clock\'></i>',$mysql_set_time,'</div>')
		WHEN d.mode= 'datetime' then CONCAT('<div class=\'ui basic icon blue label tooltip\' data-variation=\'wide\' data-html=\'Versendezeit nach Datum\'><i class=\'icon clock\'></i>',DATE_FORMAT(send_time,'%Y-%m-%d %H:%i'),'</div>')
		ELSE '<div class=\'ui basic icon blue label tooltip\' data-variation=\'wide\' data-html=\'Versendezeit sofort nach Auslösung\'><i class=\'icon clock\' ></i>Sofort</div>'
		END)

		) set_trigger,
		
		CONCAT(IF (!a.pool_id,'<i class=\'warning sign icon red tooltip\' data-variation=\'wide\'  title=\'Step ist keiner Followup zugewiesen\'></i>',''),
		IF (a.matchcode ='','<i class=\'warning sign icon red tooltip\' data-variation=\'wide\'  title=\'Keine Überschrift vorhanden\'></i>','')
		)
		error
	
		" , 
		'order' => 'sorted, followup_id' , 
		'limit' => 25 , 
		'group' => 'a.followup_id' , 
		// 'debug'=> true,
		'where' => "AND a.user_id = '{$_SESSION['user_id']}' " , 
		'like' => $search_fields );


$arr['list']['serial'] = false;
$arr['list'] = array ( 'id' => 'followup_list' , 'width' => '1000px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' , 'hide' => $list_hide ); // definition
$arr['filter']['pool_id'] = array ( 'type' => 'dropdown' , 'array' => call_array_followup_pool () , 'placeholder' => '-- Follow-Up wählen --' , 'table' => 'a' );


//$arr['th']['step_id'] = array ( 'title' =>"trigger" );
$arr['th']['sorted'] = array ( 'title' =>"<i class='sort numeric ascending icon'></i>" );
// $arr['th']['pool_id'] = array ( 'title' =>"PoolID" );
// $arr['th']['mail_id'] = array ( 'title' =>"Parent_ID", 'replace' => array ('0' => '', '1' =>"<i class='icon arrow right'></i> ") );
$arr['th']['matchcode'] = array ( 'title' =>"Beschreibung" );
$arr['th']['title'] = array ( 'title' =>"Betreff" );
$arr['th']['user'] = array ( 'title' =>"<i class='icon clock'></i> User",  'align' =>'center', 'tooltip'=>'Anzahl der User in dieser Sequenz' );
$arr['th']['followup_id'] = array ( 'title' =>"ID" );
$arr['th']['set_trigger'] = array ( 'title' =>"Auslöser/Aktion" );
//$arr['th']['error'] = array ( 'title' =>"Info" , 'align' => 'center' );
$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_step'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );
$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['modal']['modal_form_step'] = array ( 'title' =>'Step bearbeiten' , 'class' => 'large' , 'url' => 'form_followup.php' );
$arr['modal']['modal_delete'] = array ( 'title' =>'Step entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );
