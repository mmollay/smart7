<?php
session_start ();
require_once ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

foreach ( $array_import as $key => $text ) {
	$label_list .= "<div class='label basic ui'>$text</div>";
}

$arr['header'] = array ( 'text' => "<div class='content ui header small orange'><i class='icons'><i class='icon database'></i><i class='corner add icon'></i></i> Kontakte importieren</div>" , 'segment_class' => 'message attached' );

$arr['ajax'] = array (  'onLoad' => $onload ,  'success' => "$('#dialog_msg').dialog({'title':'Info','modal':true}).html( data ); " ,  'dataType' => "html" );

$arr['field'][] = array ( 'id' => 'setDelimiter' , 'type' => 'input' , 'label' => 'Trennzeichen' ,  'label_right' => '(Bsp.: tab=Tablulator, #, ...)' , 'class' => 'six wide' , 'value' => 'tab' );

$arr['field'][] = array ( 'id' => 'setTEXT' , 'type' => 'textarea' , 'label' => 'Templates' , 'rows' => '15' ,  'validate' => true , 'value' => $liste );
$arr['field']['info_list'] = array ( 'type' => 'content' , 'class' => 'message ui info' , 'text' => "In dieser Reihenfolge in der Liste angeben angeben:<br>$label_list" );

$arr['field'][] = array ( 'id' => 'update' , 'type' => 'checkbox' , 'label' => "bestehende Kontakte überschreiben" );

$arr['form'] = array ( 'action' => "ajax/content_import2.php" , 'id' => 'form_edit' , 'width' => '800' , 'class' => 'segment attached' , 'size' => 'small' );
$arr['button']['submit'] = array ( 'value' => 'Kontakte importieren' , 'icon' => 'send' , 'color' => 'blue' );
$arr_output = call_form ( $arr );

$content = $arr_output['html'];
$content .= "<div id=dialog_msg></div>";
$content .= $arr_output['js'];

echo $content;

?>