<?php
require_once ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

$arr['sql'] = array ( 'query' => "SELECT * from setting where user_id = '{$_SESSION['user_id']}'" );
$arr['header'] = array ( 'text' => "<b>Einstellungen</b><br><br>"  );
$arr['tab'] = array ('tabs' => [ "first" => "Allgemein" , "amazon" => "Amazon"]);
$arr['form'] = array ( 'width' => '800' , 'action' => 'ajax/content_setting2.php' , 'size' => '');

$arr['field']['default_from_id'] = array ( 'tab' => 'first' , 'type' => 'dropdown' , 'label' => 'Vorausgwählter Absender' , 'array' => $from_array ,  'validate' => 'Vorausgewählte Absendeadresse' , 'placeholder' => '--Absender wählen--','info'=>'Vorausgewählter Absender' );
$arr['field']['delivery_system'] = array ( 'tab' => 'first' , 'type' => 'dropdown' , 'label' => 'Absende-System' , 'array' => $delivery_system_array ,  'validate' => 'Vorausgewählte Absendeadresse' );

// $arr['field'][] = array ( 'tab' => 'amazon' , 'type' => 'div' , 'class' => 'two fields' );
// $arr['field']['seller_id'] = array ( 'tab' => 'amazon' , 'label' => 'SellerId', 'type' => 'input');
// $arr['field']['mws_access_key_id'] = array ( 'tab' => 'amazon' , 'label' => 'AWSAccessKeyId' , 'type' => 'input');
// $arr['field']['mws_auth_token'] = array ( 'tab' => 'amazon' , 'label' => 'MWSAuthToken' , 'type' => 'input');
// $arr['field']['secret_key'] = array ( 'tab' => 'amazon' , 'label' => 'Secret Key' , 'type' => 'input');
// $arr['field'][] = array ( 'tab' => 'amazon' , 'type' => 'div_close' );

$arr['field'][] = array ( 'tab' => 'amazon' , 'type' => 'div' , 'class' => 'two fields' );
$arr['field']['mws_merchant_id_eu'] = array ( 'tab' => 'amazon' , 'label' => 'MWS Verkäufer ID (Europa)','info'=>'AWSAccessKeyId' , 'type' => 'input');
//$arr['field']['mws_auth_token_eu'] = array ( 'tab' => 'amazon' , 'label' => 'MWS Entwicklerkontonummer (Europa)' , 'type' => 'input');
$arr['field'][] = array ( 'tab' => 'amazon' , 'type' => 'div_close' );
$arr['button']['submit'] = array ( 'value' => 'Einstellungen speichern' , 'color' => 'blue' );
$output = call_form ( $arr );
echo "<div style='max-width:800px' id='form_message'></div>";
echo "<div class='ui segment' style='max-width:800px'>";
echo $output['html'];
echo "</div>";
echo $output['js'];
?>