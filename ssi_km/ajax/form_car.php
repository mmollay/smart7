<?php
include_once ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

$km_array_fahrzeug = array ( 'car' => 'Auto' , 'motorbike' => 'Motorrad' , 'bike' => 'Fahrrad und zu Fuß' );

$arr['ajax'] = array (  'dataType' => "html" ,  'success' => "$('#modal_form').modal('hide'); table_reload();" );
$arr['form'] = array ( 'action' => "ajax/form_car2.php" , 'id' => 'form_km' , 'size' => 'small' );

if ($_POST['update_id']) {
	$arr['sql'] = array ( 'query' => "SELECT * from km_settings WHERE car_id = '{$_POST['update_id']}'" );
}

$arr['hidden']['car_id'] = $_POST['update_id'];

$arr['field'][] = array ( 'type' => 'div' , 'class' => 'two fields' );
$arr['field']['car_nr'] =  array ( 'type' => 'input' , 'label' => 'Kennzeichen' ,  'focus' => true , requird => true  ); 
$arr['field']['car_color'] =  array ( 'type' => 'color', 'label' => 'Farbe' );
$arr['field'][] = array ( 'type' => 'div_close' );

$arr['field']['home_address'] =  array ( 'type' => 'input' , 'label' => 'Heimadresse'  );
$arr['field']['vehicle_type'] =  array ( 'type' => 'dropdown' , 'label' => "Fahrzeug" , 'array' => array ( 'car' => 'Auto' , 'motorbike' => 'Motorrad' , 'bike' => 'Fahrrad und zu Fuß' ));

$arr['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'green' , 'icon' => 'save' );
$arr['button']['close'] = array ( 'value' => 'Abbrechen' ,  'js' => "$('#modal_form').modal('hide');" );
$output = call_form ( $arr );

echo $output['html'];
echo $output['js'];
echo "<script type=\"text/javascript\" src=\"js/form_car.js\"></script>";

