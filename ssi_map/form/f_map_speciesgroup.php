<?php
if ($_POST['update_id']) {
	$arr['sql'] = array ( 
			'query' => "
		SELECT 
		tree_group_id, color,
		(SELECT title FROM tree_group_lang WHERE lang = 'de' and group_id = tree_group_id) title_de,
		(SELECT description FROM tree_group_lang b WHERE lang = 'de' and group_id = tree_group_id) description_de,
		(SELECT title FROM tree_group_lang WHERE lang = 'en' and group_id = tree_group_id) title_en,
		(SELECT description FROM tree_group_lang b WHERE lang = 'en' and group_id = tree_group_id) description_en,
		matchcode, family_id 
		from tree_group WHERE tree_group_id = '{$_POST['update_id']}'  " );
}

$arr['tab'] = array ( 'tabs' => [ "setting" => "Einstellungen" , "de" => "Deutsch" , "en" => "Englisch" ] , 'active' =>'setting' );

$arr['form'] = array ( 'action' => "ajax/form_edit2.php" , 'size' => 'small' , 'id' => 'form_sortgroup_id' );
$arr['field']['title_de'] = array ( 'tab' => 'setting' , 'label' => 'Bezeichnung' , 'type' => 'input' , 'focus' => true );

$arr ['field'] [] = array ( 'tab' => 'setting', 'type' => 'div','class' => 'fields equal width' );
$arr['field']['matchcode'] = array ( 'tab' => 'setting' , 'type' => 'dropdown' , 'array' => $group_array_title , 'label' => 'Baumgrafik', 'validate'=>true);
$arr['field']['color'] = array ( 'tab' => 'setting' , 'label' => 'Farbe' , 'type' => 'dropdown', 'array'=>'color');
//$arr['field']['color'] = array ( 'tab' => 'setting' , 'label' => 'Farbe' , 'type' => 'color' );
$arr['field'][] = array ('tab' => 'setting', 'type'=>'div_close');

$arr['field']['family_id'] = array ( 'tab' => 'setting' , 'type' => 'dropdown' , 'array' => $array_family , 'label' => 'Pflanzenfamilie', 'clear'=> true );


$arr['field']['description_de'] = array ( 'tab' => 'de' , 'label' => 'Beschreibung' , 'type' => 'textarea' );

$arr['field']['title_en'] = array ( 'tab' => 'en' , 'label' => 'Bezeichnung' , 'type' => 'input' );
$arr['field']['description_en'] = array ( 'tab' => 'en' , 'label' => 'Beschreibung' , 'type' => 'textarea' );

$arr['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );
$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('.ui.modal').modal('hide'); " );