<?php
include_once ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

if (! $_POST['delete_id']) {
	$arr['ajax'] = array (  'success' => "table_reload(); $('#modal_form_delete').modal('hide');" ,  'dataType' => "html" );
	$arr['hidden']['delete_id'] = $_POST['update_id'];
	$arr['hidden']['list_id'] = $_POST['list_id'];
	// $arr['field'][] = array ( 'id' => 'password' , 'label' => 'Passwort' , 'type' => 'password' , 'placeholder' => 'Passwort' ,  'validate' => true ,  'focus' => true );
	$arr['button']['submit'] = array ( 'value' => 'Löschen' , 'color' => 'red' );
	$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('#modal_form_delete').modal('hide'); " );
	$output = call_form ( $arr );
	echo $output['html'];
	echo $output['js'];
	exit ();
}

// Password muss stimmen damit die Daten geloescht werden können
// if ($_POST['password'] != $superuser_passwd) return;

switch ($_POST['list_id']) {
	case 'km_list' :
		$GLOBALS['mysqli']->query ( "DELETE FROM km_list  WHERE km_id = '{$_POST['delete_id']}' LIMIT 1 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		break;
	case 'car_list' :
		$GLOBALS['mysqli']->query ( "DELETE FROM km_settings  WHERE car_id = '{$_POST['delete_id']}' LIMIT 1 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$GLOBALS['mysqli']->query ( "DELETE FROM km_list  WHERE car_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		break;
}