<?php
// Zugangsdaten fuer die Datenbank
include_once (__DIR__ . "/../config_learning.php");
include_once ('../../ssi_smart/smart_form/include_form.php');

switch ($_POST['list_id']) {
	case 'theme_list' :
		if ($_POST['update_id']) {
			$arr['sql'] = array ( 'query' => "SELECT * from ssi_learning.learn_theme where theme_id = '{$_POST['update_id']}'" );
		}
		$arr['field']['title'] = array ( 'type' => 'input' , 'label' => 'Titel' ,  'validate' => true ,  'focus' => true );
		$arr['field']['text'] = array ( 'type' => 'ckeditor' , 'label' => 'Beschreibung' );
		$arr['ajax'] = array (  'dataType' => "script" );
		
		break;
	
	case 'group_list' :
		if ($_POST['update_id']) {
			$arr['sql'] = array ( 'query' => "SELECT * from ssi_learning.learn_group where group_id = '{$_POST['update_id']}'" );
		}
		$arr['ajax'] = array (  'success' => "if (data=='no_theme') alert('kein Thema gewählt'); $('#modal_form').modal('hide'); table_reload();" ,  'dataType' => "html" );
		$arr['field']['title'] = array ( 'type' => 'input' , 'label' => 'Gruppenname' ,  'validate' => true ,  'focus' => true );
		break;
	
	case 'question_list' :
		
		if ($_POST['update_id']) {
			$arr['sql'] = array ( 'query' => "SELECT * from ssi_learning.learn_question where question_id = '{$_POST['update_id']}'" );
		} else {
			$block_nr = $_SESSION['edit_last_block_nr'];
			$group_id = $_SESSION['edit_last_group_id'];
		}
		
		$arr['tab'] = array ( 'tabs' => array ( 1 => 'Allgemein' , 2 => 'Details' ) , 'active' =>'1' );
		

		$arr['field']['title'] = array ( 'tab' => 1 , 'type' => 'textarea' , 'style' => 'height:80px;' , 'label' => 'Frage' ,  'validate' => true ,  'focus' => true );
		$arr['field'][] = array ( 'tab' => 1 , 'type' => 'div' , 'class' => 'two fields' );
		$arr['field']['group_id'] = array ( 'tab' => 1 , 'type' => 'dropdown' , 'label' => 'Gruppe' ,  'validate' => true , 'array' => $array_group );
		$arr['field']['block_nr'] = array ( 'tab' => 1 , 'type' => 'dropdown' , 'label' => 'Block' ,  'validate' => true , 'array' => $array_block_nr );
		$arr['field'][] = array ( 'tab' => 1 , 'type' => 'div_close');
		
		$query = $GLOBALS['mysqli']->query ( "SELECT * FROM ssi_learning.learn_choice WHERE question_id = '{$_POST['update_id']}' order by ranking " ) or die ( mysqli_error () );
		while ( $array = mysqli_fetch_array ( $query ) ) {
			$i ++;
			$choice_title[$i] = $array['title'];
			$choice_correctness[$i] = $array['correctness'];
		}
		
		$arr['field'][] = array ( 'tab' => 1 , 'type' => 'content' , 'text' => '<b>Möglichen Antworten</b>' );
		for($i = 1; $i <= $max_choices; $i ++) {
			$arr['field'][] = array ( 'tab' => 1 , 'type' => 'div' , 'class' => 'inline fields' );
			$arr['field']["choice_title$i"] = array ( 'tab' => 1 , 'type' => 'input' , 'class' => 'sixteen wide' , 'label_left' => "$i" , 'value' => $choice_title[$i] );
			$arr['field']["correctness$i"] = array ( 'tab' => 1 , 'type' => 'checkbox' , 'class' => 'two wide' , 'label' => "richtig" , 'value' => $choice_correctness[$i] );
			$arr['field'][] = array ( 'tab' => 1 , 'type' => 'div_close');
		}
		
		$arr['field']['text'] = array ( 'tab' => 2 , 'type' => 'ckeditor' );
		$arr['ajax'] = array (  'success' => "$('#modal_form').modal('hide'); table_reload();" ,  'dataType' => "html" );
		break;
}

$arr['form'] = array ( 'action' => "ajax/form_edit2.php" , 'id' => 'form_edit' , 'class' => 'tiny' );
$arr['hidden']['update_id'] = $_POST['update_id'];
$arr['hidden']['list_id'] = $_POST['list_id'];

if (! $hide_submit_button)
	$arr['button']['submit'] = array ( 'value' => "<i class='save icon'></i>Speichern" , 'color' => 'blue' );
$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('#modal_form,#modal_form_theme').modal('hide'); " );
$output = call_form ( $arr );
echo $output['html'];
echo $output['js'];
echo $add_js;