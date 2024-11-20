<?php
$label_day = "";

$arr ['mysql'] = array ('table' => 'ssi_paneon.`tag` LEFT JOIN  ssi_paneon.report2tag ON report2tag.tag_id = ssi_paneon.tag.tag_id',
'field' => "
tag.tag_id id, title , 
count(report2tag.tag_id) counter,
color


",'order' => 'tag.tag_id desc','limit' => 50,'group' => 'tag.tag_id','like' => 'title' );

$arr ['order'] = array ("array" => array ('counter desc' => 'Nach Anzahl der Einträge sortieren','title' => 'Nach Titel sortieren' ),'default' => 'title' );

$arr ['list'] = array ('id' => 'tag_list','width' => '1000px','size' => 'small','class' => 'compact celled striped definition' ); // definition

//if ($_SESSION ['develop_mode'])
//	$arr ['th'] ['id'] = array ('title' => "ID" );

//$arr['th']['id'] = array ( 'title' =>"ID" );
$arr ['th'] ['title'] = array ('title' => "Bezeichnung" );
$arr ['th'] ['counter'] = array ('title' => "Reports" );
$arr ['th'] ['color'] ['title'] = "Farbe";
$arr ['th'] ['color'] ['replace'] = array ('default' => '<div class=\'ui mini label {value}\'>{value}</div>' );

//$arr['th']['alert'] = array ( 'title' =>"Alert", 'replace' => array('default'=>'','1'=>"<i class='icon green bell'></i>",'0'=>"<i class='icon grey disabled bell'></i>"),  'align' =>'center','info'=>'Infomail bei Neueintrag');

$arr ['tr'] ['buttons'] ['left'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['left'] ['modal_form_tag'] = array ('title' => '','icon' => 'edit','class' => 'blue','popup' => 'Bearbeiten' );

$arr ['tr'] ['buttons'] ['right'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['right'] ['modal_form_delete'] = array ('title' => '','icon' => 'trash','popup' => 'Löschen','class' => '' );

$arr ['modal'] ['modal_form_tag'] = array ('title' => 'Tag bearbeiten','class' => '','url' => 'form_edit.php' );
$arr ['modal'] ['modal_form_delete'] = array ('title' => 'Tag entfernen','class' => 'small','url' => 'form_delete.php' );

$arr ['top'] ['button'] ['modal_form_tag'] = array ('title' => 'Neuen Tag anlegen','icon' => 'plus','class' => 'blue circular' );

$arr ['modal'] ['modal_form_tag'] ['button'] ['submit'] = array ('title' => 'Save','color' => 'green','form_id' => 'form_edit' ); //form_id = > ID formular
$arr ['modal'] ['modal_form_tag'] ['button'] ['cancel'] = array ('title' => 'Close','color' => 'grey','icon' => 'close' );
