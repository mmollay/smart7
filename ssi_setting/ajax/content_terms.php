<?php
// Filter zurück setzen beim neuladen der der Tabelle
include_once ('../../login/config_main.inc.php');
include_once ('../include.php');
include_once ("../../ssi_smart/smart_form/include_form.php");


$array['form'] = array ( 'action' => 'ajax/content_terms2.php');
$array['field'][] = array ( 'type' => 'content' ,  'text' => "<div id='form_message'></div>" );
$array['field']['terms_and_conditions'] = array (  'label' => 'Allgemeine Geschäftsbedingungen' , 'type' => 'ckeditor' );
$array['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );

$output = call_form ( $array );
echo "<div style='width:800px' class='ui segment'>";
echo $output['html'] . $output['js'];
echo "</div>";

?>