<?php
include ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');
$id = $_POST['update_id'];
switch ($_POST['list_id']) {
	
	case formulardesign_list :

		$query = $GLOBALS['mysqli']->query("SELECT camp_key FROM formular_design WHERE formdesign_id = $id") or die (mysqli_error());
		$array = mysqli_fetch_array($query);
		$camp_key = $array['camp_key']; 
		$link = "//{$_SERVER['HTTP_HOST']}/ssi_newsletter/pages/formular.php?key=$camp_key";
		$iframe = "<iframe src='$link'  style='height:400px; width:100%; border:none;' scrolling='auto' allowtransparency='true' ></iframe>";
		$object = "<object style='width:100%;' data='$link' onload=\"this.style.height=this.contentDocument.body.scrollHeight +'px';\"></object>";
		$arr['form'] = array ( 'action' => "ajax/form_edit2.php" , 'id' => 'form_iframe' , 'inline' => 'list' );
		$arr['field']['iframe'] = array ( 'tab' => 'first' , 'type' => 'textarea' , 'rows' => '3' , 'label' => 'Iframe zum einbinden', 'value' =>$iframe );
		$arr['field']['object'] = array ( 'tab' => 'first' , 'type' => 'textarea' , 'rows' => '3' , 'label' => 'Objekt zum einbinden (automatische Höhe)', 'value' =>$object );
		break;
}

$output = call_form ( $arr );
echo $output['html'];
//echo $output['js'];