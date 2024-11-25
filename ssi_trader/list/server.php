<?php
$arr['mysql'] = array(
    'table' => 'ssi_trader.server', // Änderung der Tabelle auf 'server'
    'field' => "server_id, url, name, LEFT(description, 30) AS short_description, timestamp", // Aktualisierung der Felder
    'limit' => 25,
    'group' => 'server_id',
    'like' => 'name', // Suchfunktion auf 'name' anpassen
    //'where' => "AND server.user_id =" . $_SESSION['user_id']
);
// $arr['mysql']['debug'] = true;

$arr['list'] = array('id' => 'server', 'width' => '800px', 'size' => 'small', 'class' => 'compact celled striped definition');

//$arr['th']['server_id'] = array('title' => "Server ID");
$arr['th']['name'] = array('title' => "Server Name");
$arr['th']['url'] = array('title' => "URL");
//$arr['th']['domain'] = array('title' => "Domain");
$arr['th']['short_description'] = array('title' => "Description", 'align' => 'left'); // 'align' kann angepasst werden
$arr['th']['timestamp'] = array('title' => "<i class='clock icon'></i>Timestamp", 'align' => 'center');

$arr['top']['button']['modal_form'] = array('title' => 'Create', 'icon' => 'plus', 'class' => 'blue circular');

$arr['tr']['buttons']['left'] = array('class' => 'tiny');
$arr['tr']['button']['left']['modal_form'] = array('title' => '', 'icon' => 'edit', 'class' => 'blue', 'popup' => 'Edit');

$arr['tr']['buttons']['right'] = array('class' => 'tiny');
$arr['tr']['button']['right']['modal_form_delete'] = array('title' => '', 'icon' => 'trash', 'popup' => 'Delete', 'class' => '');

$arr['modal']['modal_form'] = array('title' => 'Edit', 'class' => '', 'url' => 'form_edit.php');
$arr['modal']['modal_form']['button']['submit'] = array('title' => 'Speichern', 'color' => 'green', 'form_id' => 'form_edit'); // form_id = > ID formular
$arr['modal']['modal_form']['button']['cancel'] = array('title' => 'Schließen', 'color' => 'grey', 'icon' => 'close');


$arr['modal']['modal_form_delete'] = array('title' => 'Remove', 'class' => 'small', 'url' => 'form_delete.php');