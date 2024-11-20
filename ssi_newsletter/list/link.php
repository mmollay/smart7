<?php
$arr['mysql'] = array ( 
		'table'=>' link LEFT JOIN link2tag ON link.link_id = link2tag.link_id',
		'field' => "link.link_id link_id, link, link.timestamp timestamp, COUNT(link2tag.link_id) tags",
		'order' => '' , 
		'limit' => 25, 
		'where' => "AND user_id = '{$_SESSION['user_id']}' " , 
		'group' => 'link.link_id',
		'like' => 'title'
);

$arr['list'] = array ( 'id' => 'link_list' , 'width' => '800px' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['link_id'] = array ( 'title' =>"ID" );
$arr['th']['link'] = array ( 'title' =>"Link" );
$arr['th']['tags'] = array ( 'title' =>"Tags",  'align' =>'center' );
$arr['th']['timestamp'] = array ( 'title' =>"<i class='clock icon'></i>Aktualisiert" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
$arr['tr']['button']['left']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

$arr['modal']['modal_form'] = array ( 'title' =>'Link bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Link entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form'] = array ( 'title' =>'Neuen Link anlegen' , 'icon' => 'plus' , 'class' => 'blue circular' );