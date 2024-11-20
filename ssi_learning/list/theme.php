<?php
$arr['mysql'] = array ( 
		'field' => "a.theme_id theme_id, a.title title, count(b.question_id) counter, a.timestamp timestamp",
		'table' => "ssi_learning.learn_theme a LEFT OUTER JOIN ssi_learning.learn_question b ON a.theme_id = b.theme_id", 
		'limit' => 25, 
		'group' => 'a.theme_id',
		'where' => "AND user_id = '{$_SESSION['user_id']}'" , 
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'theme_list' , 'width' => '800px' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

//$arr['th']['theme_id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"Titel" );
$arr['th']['counter'] = array ( 'title' =>"<i class='tags icon'></i>Fragen" );
$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Aktualisiert" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_theme'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

$arr['modal']['modal_form_theme'] = array ( 'title' =>'Thema bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Thema entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form_theme'] = array ( 'title' =>'Neue Thema anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );