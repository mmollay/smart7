<?php
// Filter zurück setzen beim neuladen der der Tabelle
include_once ('../../login/config_main.inc.php');
include_once ('../include.php');
include_once ("../../ssi_smart/smart_form/include_form.php");

//$array['sql'] = array ( 'query' => "SELECT * from register WHERE user_id = '{$_SESSION['user_id']}'" , key => 'user_id' );
//Abrufen aller Parameter
$array['form'] = array ( 'action' => 'ajax/content_login2.php', 'size'=>'huge'  );
$array['field'][] = array ( 'type' => 'content' ,  'text' => "<div id='form_message'></div>" );
$array['field'][] = array ( 'type' => 'header' , 'text' => 'Loginberechtigungen' , 'size' => '3' , 'class' => 'green' );
$array['field'][] = array ( 'id' => 'register_allowed' , 'type' => 'toggle' , 'label' => 'Registierseite zulassen' );
$array['field'][] = array ( 'id' => 'facebook_login' , 'type' => 'toggle' , 'label' => 'Facebooklogin zulassen' );
$array['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );
$output = call_form ( $array );

echo "<div style='width:800px' class='ui segment'>";
echo $output['html'] . $output['js'];
echo "</div>";
?>