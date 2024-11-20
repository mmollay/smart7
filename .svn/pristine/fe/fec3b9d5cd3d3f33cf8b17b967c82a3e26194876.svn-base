<?php
include (__DIR__.'/../config_learning.php');

$arr['mysql'] = array ( 
		'field' => "a.question_id, a.title title, b.title group_name, a.timestamp timestamp, COUNT(c.question_id) count,
		a.group_id group_id, a.block_nr block_nr",
		'table' => "ssi_learning.learn_question a 
			LEFT JOIN ssi_learning.learn_group b ON  b.group_id = a.group_id
			LEFT JOIN ssi_learning.learn_choice c ON a.question_id = c.question_id
",
		'limit' => 25,  
		'group' => 'a.question_id',
		'where' =>  "AND a.theme_id = '{$_SESSION['theme_id']}' ",
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'question_list' , 'width' => '1200px' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['filter']['group_id'] = array ('table'=>'a', 'type' => 'select', 'array' => $array_group, 'placeholder' => '--Gruppen--',   );
$arr['filter']['block_nr'] = array ('table'=>'a', 'type' => 'select', 'array' => $array_block_nr, 'placeholder' => '--Blöcke--',   );

//$arr['th']['question_id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"Titel" );
$arr['th']['group_name'] = array ( 'title' =>"Gruppe" );
$arr['th']['count'] = array ( 'title' =>"Anzahl der Fragen" , 'align' => 'center' );
$arr['th']['block_nr'] = array ( 'title' =>"Block",  'align' =>'center' );
$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Aktualisiert" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

$arr['modal']['modal_form'] = array ( 'title' =>'Frage bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Frage entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Neue Frage anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );