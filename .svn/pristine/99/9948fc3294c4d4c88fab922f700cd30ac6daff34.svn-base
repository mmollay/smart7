<?php
// Filter zurück setzen beim neuladen der der Tabelle
include_once ('../../login/config_main.inc.php');
include_once ('../include.php');
include_once ("../../ssi_smart/smart_form/include_form.php");

$array['form'] = array ( 'width' => '800' , 'action' => 'ajax/content_smtp2.php' , 'size' => '' , 'class' => '' );

$array['field'][] = array ( 'type' => 'content' ,  'text' => "<div id='form_message'></div>" );
$array['field'][] = array( 'type' => 'header', 'text'=>'Email', 'class'=>'red dividing');
$array['field'][] = array('type'=>'div', 'class'=>'two fields');
$array['field'][] = array ( 'id' => 'smtp_email' , 'label' => 'Von (Email)' , 'type' => 'input' ,  'focus' => true , 'placeholder' => '@email', 'validate'=>'email' );
$array['field'][] = array ( 'id' => 'smtp_title' , 'label' => 'Von (Name)' , 'type' => 'input' , 'placeholder' => 'Firma oder Name', 'validate'=>true );
$array['field'][] = array ( 'type'=>'div_close');

$array['field'][] = array( 'type' => 'header', 'text'=>'SMTP-Server (optional)', 'class'=>'red dividing');
$array['field'][] = array('type'=>'div', 'class'=>'three fields');
$array['field'][] = array ( 'id' => 'smtp_host' , 'label' => 'Server' , 'type' => 'input' , 'placeholder' => '' );
$array['field'][] = array ( 'id' => 'smtp_port' , 'label' => 'Port' , 'type' => 'dropdown' , 'array'=>array ( 587 => 587 , 465 => 465 , 25 => 25 ) , 'value' => 25 );
$array['field'][] = array ( 'id' => 'smtp_secure' , 'label' => 'Secure' , 'type' => 'dropdown' , 'array'=>array ( '' => 'keine' , 'tls' => 'tls' , 'ssl' => 'ssl' ) , 'value' => '' );
$array['field'][] = array ( 'type'=>'div_close');

$array['field'][] = array('type'=>'div', 'class'=>'two fields');
$array['field'][] = array ( 'id' => 'smtp_user' , 'label' => 'User' , 'type' => 'input' );
$array['field'][] = array ( 'id' => 'smtp_password' , 'label' => 'Passwort' , 'type' => 'password'  );
$array['field'][] = array ( 'type'=>'div_close');

$array['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );

$output = call_form ( $array );

echo "<div style='width:800px' class='ui segment'>";
echo $output['html'];
echo $output['js'];
echo "</div>";