<?php

//
// $arr['tab'] = array ( 'tabs' => array ( 1 => 'Default' , 2 => 'More' ) , 'active' =>'1' );
$arr['sql'] = array ( 'query' => "SELECT * from client WHERE client_id = '{$_POST['update_id']}' " );

if ($_POST['update_id']) {
	$arr['field']['client_number'] = array ( 'tab' => '1' , 'type' => 'input' , 'class'=>'disabled', 'label' => 'Kundennummer' , 'value' => $client_number );
}

$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div' , 'class' => 'two fields' );
$arr['field']['company_1'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Firma' ,  'focus' => true );
$arr['field']['company_2'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Firma(Zusatz)' );
$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div_close' );

$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div' , 'class' => 'four fields' );
$arr['field']['gender'] = array ( 'class' => 'four wide' , 'tab' => '1' , 'type' => 'dropdown' , 'label' => 'Titel' , 'array' => array ( 'f' => 'Frau' , 'm' => 'Herr' ) );
$arr['field']['title'] = array ( 'class' => 'three wide' , 'tab' => '1' , 'type' => 'input' , 'label' => 'Titel' );
$arr['field']['firstname'] = array ( 'class' => 'four wide' , 'tab' => '1' , 'type' => 'input' , 'label' => 'Vorname' );
$arr['field']['secondname'] = array ( 'class' => 'five wide' , 'tab' => '1' , 'type' => 'input' , 'label' => 'Nachname' );
$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div_close' );

$arr['field']['street'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Strasse' );
$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div' , 'class' => 'three fields' );
$arr['field']['zip'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'PLZ' );
$arr['field']['city'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Stadt' );
$arr['field']['country'] = array ( 'tab' => '1' , 'type' => 'dropdown' , 'array' =>'country' , 'label' => 'Land' );
$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div_close' );

$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div' , 'class' => 'three fields' );
$arr['field']['tel'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Tel' );
$arr['field']['email'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Email' );
$arr['field']['web'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Internet' );
$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div_close' );
$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div' , 'class' => 'two fields' );
$arr['field']['commend'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Kommentar' );
$arr['field'][] = array ( 'tab' => '1' , 'type' => 'div_close' );
$arr['field']['newsletter'] = array ( 'tab' => '1' , 'type' => 'checkbox' , 'label' => 'Newsletter' );
//$arr['field']['password'] = array ( 'tab' => '1' , 'type' => 'input' , 'label' => 'Passwort' ,  'label_right' => '<div id=button_generate_password>Passwort erzeugen</div>' ,  'label_right_class' => 'button' );