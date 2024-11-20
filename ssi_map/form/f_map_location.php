<?php
$arr['sql'] = array ( 'query' => "SELECT place_id,name,zip from tree_places WHERE place_id = '{$_POST['update_id']}' " );
$arr['field']['zip'] = array ( 'tab' => '1' , 'type' => 'dropdown' , 'array' => $array_city , 'label' => 'Stadt' );
$arr['field']['name'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Bezeichnung' );