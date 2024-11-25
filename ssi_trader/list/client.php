<?php

$arr['mysql'] = array(
    'table' => 'ssi_trader.clients left  join ssi_trader.server on clients.server_id = server.server_id', // Änderung der Tabelle auf 'server
    'field' => "client_id, CONCAT(first_name, ' ', last_name) AS name, email, created_at, clients.server_id, server.name as server_name, clients.server_id as server_id, url", // Aktualisierung der Felder   
    'limit' => 25,
    'group' => 'client_id',
    'like' => 'user'

);

// $arr['mysql']['debug'] = true;

$arr['list'] = array('id' => 'client', 'width' => '800px', 'size' => 'small', 'class' => 'compact celled striped definition');

$arr['th']['client_id'] = array('title' => "ID");
$arr['th']['name'] = array('title' => "Name");
$arr['th']['email'] = array('title' => "Email");
$arr['th']['created_at'] = array('title' => "<i class='clock icon'></i>Timestamp", 'align' => 'center');
$arr['th']['server_name'] = array('title' => "Server Name");
$arr['th']['url'] = array('title' => "Url");

$arr['top']['button']['modal_form'] = array('title' => 'Create', 'icon' => 'plus', 'class' => 'blue circular');

$arr['tr']['buttons']['left'] = array('class' => 'tiny');
$arr['tr']['button']['left']['modal_form'] = array('title' => '', 'icon' => 'edit', 'class' => 'blue', 'popup' => 'Edit');

$arr['tr']['buttons']['right'] = array('class' => 'tiny');
$arr['tr']['button']['right']['modal_form_delete'] = array('title' => '', 'icon' => 'trash', 'popup' => 'Delete', 'class' => '');

$arr['modal']['modal_form'] = array('title' => 'Edit', 'class' => '', 'url' => 'form_edit.php');
$arr['modal']['modal_form']['button']['submit'] = array('title' => 'Speichern', 'color' => 'green', 'form_id' => 'form_edit'); // form_id = > ID formular
$arr['modal']['modal_form']['button']['cancel'] = array('title' => 'Schließen', 'color' => 'grey', 'icon' => 'close');

$arr['modal']['modal_form_delete'] = array('title' => 'Remove', 'class' => 'small', 'url' => 'form_delete.php');