<?php
if ($_POST['update_id'])
	$focus = true;


if ($_POST['update_id']) {
	$arr['sql'] = array ( 'query' => "SELECT t1.temp_id temp_id,group_id,worth_knowing,taste_id,ripe_for_picking,mature_pleasure,fruit_type,fruit_type2,latin,tree_group from tree_template t1 LEFT JOIN tree_template_lang t2 ON t1.temp_id = t2.temp_id WHERE t1.temp_id = '{$_POST['update_id']}' and lang = 'de' " );
}

$arr['form'] = array ( 'action' => "ajax/form_edit2.php" , 'size' => 'small' , 'id' => 'form_sort_id' );
$arr['field']['group_id'] = array ( 'label' => 'Gruppe' , 'type' => 'dropdown' , 'array' => $array_speciesgroup , 'class'=>'search' );
$arr['field'][] = array ( 'type' => 'div' , 'class' => 'three fields' ); // 'label'=>'test'
$arr['field']['fruit_type'] = array ( 'label' => 'Sorte' , 'type' => 'input' ,  'focus' => $focus );
$arr['field']['fruit_type2'] = array ( 'label' => 'Zusatz' , 'type' => 'input' );
$arr['field']['latin'] = array ( 'label' => 'Lateinischer Name' , 'type' => 'input' );
$arr['field'][] = array ( 'type' => 'div_close' ); // 'label'=>'test'
$arr['field']['worth_knowing'] = array ( 'label' => 'Beschreibung' , 'type' => 'textarea' );
$arr['field'][] = array ( 'type' => 'div' , 'class' => 'three fields' ); // 'label'=>'test'
$arr['field']['taste_id'] = array ( 'label' => 'Geschmack' , 'type' => 'dropdown' , 'array' => $array_taste );
$arr['field']['ripe_for_picking'] = array ( 'label' => 'Pflückreife' , 'type' => 'input' );
$arr['field']['mature_pleasure'] = array ( 'label' => 'Reifezeiten' , 'type' => 'input' );
$arr['field'][] = array ( 'type' => 'div_close' );
$arr['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );
$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('.ui.modal').modal('hide'); " );$arr['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );
