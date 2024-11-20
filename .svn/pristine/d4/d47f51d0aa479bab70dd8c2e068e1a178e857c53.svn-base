<?php
if ($_POST['update_id']) {
	$arr['sql'] = array ( 
			'query' => "
	SELECT a.taste_id,
	(SELECT title FROM tree_taste_lang b WHERE lang = 'de' and a.taste_id = b.taste_id) title_de,
	(SELECT description FROM tree_taste_lang b WHERE lang = 'de' and a.taste_id = b.taste_id) description_de,
	(SELECT title FROM tree_taste_lang b WHERE lang = 'en' and a.taste_id = b.taste_id) title_en,
	(SELECT description FROM tree_taste_lang b WHERE lang = 'en' and a.taste_id = b.taste_id) description_en
	FROM tree_taste a WHERE taste_id = '{$_POST['update_id']}' " );
}

$arr['tab'] = array ( 'tabs' => [ "de" => "Deutsch" , "en" => "Englisch" , "setting" => "Einstellungen" ] , 'active' =>'de' );

$arr['form'] = array ( 'action' => "ajax/form_edit2.php" , 'size' => 'small' , 'id' => 'form_taste_id' );
$arr['field']['title_de'] = array ( 'tab' => 'de' , 'label' => 'Bezeichnung' , 'type' => 'input' , 'focus' => true );
$arr['field']['description_de'] = array ( 'tab' => 'de' , 'label' => 'Beschreibung' , 'type' => 'textarea' );

$arr['field']['title_en'] = array ( 'tab' => 'en' , 'label' => 'Bezeichnung' , 'type' => 'input' );
$arr['field']['description_en'] = array ( 'tab' => 'en' , 'label' => 'Beschreibung' , 'type' => 'textarea' );

$arr['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );
$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('.ui.modal').modal('hide');" );