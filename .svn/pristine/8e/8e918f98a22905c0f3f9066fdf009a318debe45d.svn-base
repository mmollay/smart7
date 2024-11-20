<?php
$count = "(SELECT COUNT(*) FROM code WHERE promotion.promotion_id = code.promotion_id) ";
$count_sent = "(SELECT COUNT(*) FROM code WHERE promotion.promotion_id = code.promotion_id and contact_id) ";
$count_used = "(SELECT COUNT(*) FROM amazon_order WHERE amazon_order.amazon_promotion_id = promotion.amazon_promotion_id) ";

$arr['mysql'] = array ( 
		'table'=>'promotion',
		'field' => "promotion_id, title, timestamp, type,amazon_promotion_id, alert_empty_code,$count count,
		CONCAT ('<div class=\'ui small grey header\'>',$count_sent,'</div>', ROUND((100/$count)*$count_sent,1),'%') count_sent,
		CONCAT ('<div class=\'ui small green header\'>',$count_used,'</div>', ROUND((100/$count)*$count_used,1),'%') count_used,
		CONCAT ('<div class=\'ui small grey header\'>',$count-$count_sent,'</div>', ROUND((100/$count)*$count-$count_sent,1),'%') count_free,
		 DATE_FORMAT(date_start,'%Y-%m-%d') date_start, DATE_FORMAT(timestamp,'%Y-%m-%d') timestamp",
		'order' => '' , 
		'limit' => 25,  
		//'debug'=> true,
		'group' => 'promotion_id',
		'where' => "AND user_id = '{$_SESSION['user_id']}' " ,
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'promotion_list' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

//$arr['filter']['form_id'] = array ( 'type' => 'select', 'array' => $array_form, 'placeholder' => '--Formulare--', 'class'=>'',  'table'=>'a' );

//$arr['th']['promotion_id'] = array ( 'title' =>"ID");
$arr['th']['title'] = array ( 'title' =>"Titel");
$arr['th']['type'] = array ( 'title' =>"Type", 'align' => 'center', 'replace' =>array('basic'=>'','amazon'=>"<i class='icon amazon'></i>"));
$arr['th']['amazon_promotion_id'] = array ( 'title' =>"Nachverfolgungsnummer");
$arr['th']['count'] = array ( 'title' =>"Gesamt",  'align' => "center" );
$arr['th']['count_free'] = array ( 'title' =>"Verfügbar",  'align' => "center" );
$arr['th']['count_sent'] = array ( 'title' =>"Versendet",  'align' => "center" );
$arr['th']['count_used'] = array ( 'title' =>"Eingelöst",  'align' => "center" );
$arr['th']['alert_empty_code'] = array ( 'title' =>"Alert",  'align' => "center", 'replace' =>array('default'=>'<{value}', '0' => '-') );
$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Erzeugt" , 'align' => 'center' );


$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'', 'filter' => array(['field' => 'count', 'value' =>1, 'operator' => '<'  ]) );

$arr['modal']['modal_form'] = array ( 'title' =>'Promotion bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Promotion entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Neue Promotion anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );