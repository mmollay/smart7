<?php
include_once ('../../login/config_main.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

if (! $_POST['delete_id']) {
	$arr['form'] = array ( 'id' => 'del_form');
	$arr['ajax'] = array (  'success' => "
			$('#modal_form_delete').modal('hide');
			if (data = 'exis' ) { 
				$('#message').message({  title: 'Thema kann nicht gelöscht werden, es sind Gruppen vorhanden!'  });
			} 
			else  
				{ table_reload();  }
			",  'dataType' => "html" );
	$arr['hidden']['delete_id'] = $_POST['update_id'];
	$arr['hidden']['list_id'] = $_POST['list_id'];
	// $arr['field'][] = array ( 'tab' => 'first' , 'id' => 'firstname' , 'label' => 'Vorname' , 'type' => 'input' , 'placeholder' => 'Vorname',  'validate' => true );
	$arr['button']['submit'] = array ( 'value' => 'Löschen' , 'color' => 'red' );
	$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('#modal_form_delete').modal('hide');" );
	
	$output = call_form ( $arr );
	echo $output['html'];
	echo $output['js'];
	exit ();
}

$del_id = $_POST['delete_id'];

switch ($_POST['list_id']) {
	case theme_list :
		
		$query = $GLOBALS['mysqli']->query ( "SELECT * FROM ssi_learning.learn_question WHERE theme_id = '$del_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$count = mysqli_num_rows ( $query );
		
		if ($count)
			echo "exist";
		else {
			$GLOBALS['mysqli']->query ( "DELETE FROM ssi_learning.learn_theme WHERE theme_id = '$del_id' AND !(SELECT count(*) FROM ssi_learning.learn_question WHERE theme_id = '$del_id')  LIMIT 1" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		break;
	
	case group_list :
		
		// Löscht alle Fragen + die Auswahl der Antworten
		$query = $GLOBALS['mysqli']->query ( "SELECT question_id FROM ssi_learning.learn_question WHERE group_id = '$del_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		while ( $array = mysqli_fetch_array ( $query ) ) {
			$question_id = $array['question_id'];
			$GLOBALS['mysqli']->query ( "DELETE FROM ssi_learning.learn_choice WHERE question_id = '$question_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		$GLOBALS['mysqli']->query ( "DELETE FROM ssi_learning.learn_question WHERE group_id = '$del_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$GLOBALS['mysqli']->query ( "DELETE FROM ssi_learning.learn_group WHERE group_id = '$del_id' LIMIT 1" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		break;
}