<?php
include ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

$arr['form'] = array ( 'action' => "ajax/form_edit2.php" , 'id' => 'form_edit' , 'inline' => 'list' );
$arr['ajax'] = array (  'success' => "$('.modal.ui').modal('hide'); table_reload();" ,  'dataType' => "html" );

include ('../form/f_' . $_POST['list_id'] . '.php');

$arr['hidden']['list_id'] = $_POST['list_id'];
$arr['button']['submit'] = array ( 'value' => "<i class='save icon'></i>Speichern" , 'color' => 'blue' );
$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('.modal.ui').modal('hide'); " );
$output = call_form ( $arr );
echo $output['html'];
echo $output['js'];
echo $add_js;