<?php
$arr ['mysql'] = array ('table' => ' usrdb_intubspe.user a LEFT JOIN usrdb_intubspe.user2session b ON a.user_id = b.user_id','field' => "*,a.level level, SUM(if(b.success, 1, 0)) AS success, SUM(if(b.user_id, 1, 0)) AS giventips",'order' => '','limit' => 25,'group' => 'a.user_id',
		'like' => 'nickname,email' );

$arr ['list'] = array ('id' => 'user','width' => '800px','size' => 'small','class' => 'compact celled striped definition' );

$arr ['th'] ['user_id'] = array ('title' => "ID" );
$arr ['th'] ['nickname'] = array ('title' => "Link" );
$arr ['th'] ['email'] = array ('title' => "Email" );
$arr ['th'] ['level'] = array ('title' => "Level" );
$arr ['th'] ['giventips'] = array ('title' => "Gegebene Tipps" );
$arr ['th'] ['success'] = array ('title' => "Erfolgreich" );
$arr ['th'] ['timestamp'] = array ('title' => "<i class='clock icon'></i>Aktualisiert",'align' => 'center' );

$arr ['top'] ['button'] ['modal_form'] = array ('title' => 'Anlegen','icon' => 'plus','class' => 'blue circular' );

$arr ['tr'] ['buttons'] ['left'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['left'] ['modal_form'] = array ('title' => '','icon' => 'edit','class' => 'blue','popup' => 'Bearbeiten' );
$arr ['tr'] ['button'] ['left'] ['modal_form_delete'] = array ('title' => '','icon' => 'trash','popup' => 'Löschen','class' => '' );

// $arr ['tr'] ['buttons'] ['right'] = array ('class' => 'tiny' );
// $arr ['tr'] ['button'] ['right'] ['set_user'] = array ('title' => '','icon' => 'user','class' => '' );

$arr ['modal'] ['modal_form'] = array ('title' => 'Bearbeiten','class' => '','url' => 'form_edit.php' );
$arr ['modal'] ['modal_form_delete'] = array ('title' => 'Entfernen','class' => 'small','url' => 'form_delete.php' );
