<?php
$arr['mysql'] = array ( 
		'field' => "learn_group.group_id id, learn_group.title title, 
		count(learn_question.group_id) counter, learn_group.timestamp timestamp",
		'table' => "ssi_learning.learn_group LEFT JOIN ssi_learning.learn_question ON learn_group.group_id = learn_question.group_id",
		'order' => 'learn_group.group_id desc' , 
		'limit' => 25, 
		'where' => "AND learn_group.theme_id = '{$_SESSION['theme_id']}' " , 
		'group' => 'learn_group.group_id',
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'group_list' , 'width' => '1000px' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

//$arr['th']['id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"Titel" );
$arr['th']['counter'] = array ( 'title' =>"<i class='tags icon'></i>Fragen",  'align' => 'center' );
$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Aktualisiert" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

$arr['modal']['modal_form'] = array ( 'title' =>'Gruppe bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Gruppe entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Neue Gruppe anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );