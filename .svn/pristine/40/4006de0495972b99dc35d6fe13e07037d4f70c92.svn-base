<?php
$arr['mysql'] = array ( 
		'table' => "followup_pool a LEFT JOIN followup b ON a.pool_id = b.pool_id",
		'field' => "a.pool_id pool_id, a.matchcode matchcode, COUNT(b.pool_id) count",
		'order' => 'a.pool_id' , 
		'limit' => 25 , 
		'group' => 'a.pool_id',
		'where' => "AND a.user_id = '{$_SESSION['user_id']}' " , 
		'like' => 'a.matchcode',
		//'debug' => true
);

$arr['list'] = array ( 'id' => 'followup_pool_list' , 'width' => '1000px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['pool_id'] = array ( 'title' =>"ID" );
$arr['th']['matchcode'] = array ( 'title' =>"Beschreibung" );
$arr['th']['count'] = array ( 'title' =>"Steps" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'setting' , 'class' => 'blue mini' , 'popup' => 'Einstellungen bearbeiten' );
$arr['tr']['button']['left']['modal_steps'] = array ( 'title' =>'' , 'icon' => 'ordered list' , 'class' => ' mini' , 'popup' => 'Steps', 'onclick'=>"$('#tab_followup .item').tab('change tab', 'step');  call_semantic_table('followup_list','filter','pool_id','{id}' ); " );
$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['modal']['modal_form'] = array ( 'title' =>'Follow-Up bearbeiten' , 'class' => '' , 'url' => 'form_followup.php' );
$arr['modal']['modal_delete'] = array ( 'title' =>'Follow-Up entfernen' , 'class' => 'small' , 'url' => 'form_delete.php', 'filter' =>array(['field' => 'count', 'operator' => '>' ,  'value' => 0]) );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Neue Follow-Up anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );