<?php
//$count_tag = "(SELECT COUNT(*) FROM formular2tag WHERE form_id = a.form_id)";

$arr['mysql'] = array ( 
		'table'=>'
		formular a
		LEFT JOIN formular2tag ON a.form_id = formular2tag.form_id 
		LEFT JOIN sender ON from_id = id
		LEFT JOIN promotion p ON p.promotion_id = a.promotion_id
		LEFT JOIN code c ON c.promotion_id = p.promotion_id
		LEFT JOIN followup e ON a.followup_mail_id = e.followup_id
		',
		'field' => "
		a.form_id form_id,			
		amazon_promotion_id promotion_title,
		amazon_asin,
		CONCAT(
		IF(p.title != '',CONCAT('<div class=\'ui icon basic orange tooltip label compact\' title=\'Promotion: ',p.title,' \'><i class=\'icon amazon\'></i></div>'),''),
		IF (e.matchcode != '', CONCAT('<div class=\'ui basic blue label tooltip\' data-html=\'Startet Followupsequenz:<br>',e.matchcode,'\'><i class=\'icon mail forward\'></i>',e.matchcode,'</div>')     ,''),
		IF(COUNT(*),CONCAT('<div class=\'ui basic tooltip label\' title=\'',COUNT(*),' Tag(s) zugewiesen\'><i class=\'icon grey tag\' ></i>',COUNT(*),'</div>'),'')
		) elements, alert,
		 a.matchcode matchcode, a.timestamp, from_email",
		'order' => 'form_id desc' , 
		'limit' => 20, 
		'where' => "AND a.user_id = '{$_SESSION['user_id']}' " , 
		'group' => 'a.form_id',
		'like' => 'matchcode'
);

$arr['list'] = array ( 'id' => 'listbuilding_list'  , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

//	$arr['th']['form_id'] = array ( 'title' =>"ID" );
$arr['th']['matchcode'] = array ( 'title' =>"Bezeichnung" );
$arr['th']['alert'] = array ( 'title' =>"Alert", 'replace' => array('default'=>'','1'=>"<i class='icon green bell'></i>",'0'=>"<i class='icon grey disabled bell'></i>"),  'align' =>'center','info'=>'Infomail bei Neueintrag');
$arr['th']['from_email'] = array ( 'title' =>"<i class='send mail icon'></i>Absendeadresse" );
$arr['th']['elements'] = array ( 'title' =>"<i class='tags icon'></i>Tags/Promos" );
$arr['th']['promotion_title'] = array ( 'title' =>"<i class='amazon icon'></i>Promotion" );
//$arr['th']['amazon_asin'] = array ( 'title' =>"<i class='amazon icon'></i>Asin" );

//$arr['th']['followup_matchcode'] = array ( 'title' =>"<i class='mail forward icon'></i>Followup",  'align' =>'center' );
//$arr['th']['tag'] = array ( 'title' =>"<i class='tag icon'></i>Tags",  'align' =>'center' );
//$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Aktualisiert" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_listbuilding'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_funnel_generator'] = array ( 'title' =>'' , 'icon' => 'amazon' , 'class' => 'orange' , 'popup' => 'Funnel generieren', 'filter' => array(['field' => 'amazon_asin', 'value' =>'', 'operator' => '>'  ]) );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

$arr['modal']['modal_form_listbuilding'] = array ( 'title' =>'Listbuilding bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_funnel_generator'] = array ( 'title' =>'Funnel erzeugen' , 'class' => '' , 'url' => 'form_funnelgenerator.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Listbuilding entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );
$arr['top']['button']['modal_form_listbuilding'] = array ( 'title' =>'Neues Listbuilding anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );

