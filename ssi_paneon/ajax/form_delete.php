<?php
include ('../../ssi_smart/smart_form/include_form.php');

if (! $_POST['delete_id']) {
	
	$arr['ajax'] = array (  'success' => "$table_reload $('.modal.ui').modal('hide'); table_reload(); message({ title: 'Entfernen', text:'Ein Eintrag wurde entfernt'});" ,  'dataType' => "html" );
	$arr['hidden']['delete_id'] = $_POST['update_id'];
	$arr['hidden']['list_id'] = $_POST['list_id'];
	$arr['button']['submit'] = array ( 'value' => 'Löschen' , 'color' => 'red' );
	$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('.modal.ui').modal('hide');" );
	$output = call_form ( $arr );
	echo $output['html'];
	echo $output['js'];
	exit ();
}

require_once ('../config.inc.php');

switch ($_POST['list_id']) {
	case 'report_list' :
		$GLOBALS['mysqli']->query ( "DELETE FROM ssi_paneon.report WHERE report_id = '{$_POST['delete_id']}' LIMIT 1" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
		$GLOBALS['mysqli']->query ( "DELETE FROM ssi_paneon.report2tag WHERE report_id = '{$_POST['delete_id']}'" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
		break;
	case 'tag_list' :
		$GLOBALS['mysqli']->query ( "DELETE FROM ssi_paneon.tag WHERE tag_id = '{$_POST['delete_id']}' LIMIT 1" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
		$GLOBALS['mysqli']->query ( "DELETE FROM ssi_paneon.report2tag WHERE tag_id = '{$_POST['delete_id']}'" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
		break;
}