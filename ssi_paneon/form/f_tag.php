<?php

$arr ['ajax'] = array ('onLoad' => "call_add_tag('tag_id');", 'success' => "if (data == 'ok') { $('.ui.modal').modal('hide'); table_reload(); } else  { alert('Error: f_report.php'); }	",'dataType' => "html" );
//$arr ['tab'] = array ('tabs' => array (1 => 'Default',2 => 'More' ),'active' => '1' );

$arr ['sql'] = array ('query' => "SELECT * from ssi_paneon.tag WHERE tag_id = '{$_POST['update_id']}' " );

$arr ['field'] [] = array ('type'=>'div','class'=>'fields');
$arr ['field'] ['title'] = array ('class'=>'wide eleven','type' => 'input','label' => 'Bezeichnung','focus' => true );
$arr ['field'] ['color'] = array ('class'=>'wide five', 'type' => 'dropdown','label' => 'Farbe','array'=>'color','set_color'=>true );
$arr ['field'] [] = array ('type'=>'div_close');

$arr ['field'] ['description'] = array ('type' => 'ckeditor','label' => 'Beschreibung');
