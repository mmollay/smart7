<?php
include_once ('../../login/config_main.inc.php');
include_once ('../include.php');
include_once ("../../ssi_smart/smart_form/include_form.php");

function content_form($element, $array) {
	$array['value'] = $array;
	//$array['sql'] = array ( 'query' => "SELECT * from smart_information WHERE user_id = '{$_SESSION['user_id']}' and element = '$element' " , key => 'verification_id' );
	$array['form'] = array (  'action' => 'ajax/content_infotext2.php' );
	$array['hidden']['element'] = $element; 
	$array['field'][] = array ( 'type' => 'content' ,  'text' => "<div id='form_message_$element'></div>" );
	$array['field'][] = array ( 'id' => $element.'_title' , 'label' => 'Titel' , 'type' => 'input' ,  'focus' => true , 'placeholder' => 'Titel' );
	$array['field'][] = array ( 'id' => $element.'_text' , 'label' => '' , 'type' => 'ckeditor' , 'placeholder' => 'Text' , 'footer' => 'Platzhalter: {%verify_key%},{%email%},{%firstname%},{%secondname%}' );
	$array['button']['submit'] = array ( 'value' => 'Speichern' , 'color' => 'blue' );
	$output = call_form ( $array );
	return $output['html']. $output['js'];
}

$accordion[1]['title'] = "<i class='icon mail'></i>Verifizierungs-Mail nach Anmeldung";
$accordion[1]['content'] = content_form('verification',$array['value']);

// $accordion[2]['title'] = 'Erstanmeldung mit FB';
// $accordion[2]['content'] = call_form ( $array3 );
//<a class='item' data-tab='second'>{$accordion[2]['title']}</a>
//

//$accordion[3]['title'] = 'Verifizierungstext bei Anmeldung';
//$accordion[3]['content'] = content_form('first_reg_success',$array['value']);

$accordion[4]['title'] = 'Begrüßungstext auf Webseite';
$accordion[4]['content'] = content_form ( 'welcome_info',$array['value']);

echo "<script>$('.menu .item').tab(); </script>";
echo "<div style='width:800px'>";
echo "<div id='form_message'></div>";
echo "<div class='ui top attached tabular menu'>";
echo "<a class='active item' data-tab='first'>{$accordion[1]['title']}</a>";
//echo "<a class='item' data-tab='third'>{$accordion[3]['title']}</a>";
echo "<a class='item' data-tab='four'>{$accordion[4]['title']}</a>";
echo "</div>";
echo "<div class='ui bottom attached active tab segment' data-tab='first'>{$accordion[1]['content']}</div>";
//echo "<div class='ui bottom attached tab segment' data-tab='third'>{$accordion[3]['content']}</div>";
echo "<div class='ui bottom attached tab segment' data-tab='four'>{$accordion[4]['content']}</div>";
echo "</div>";
?>