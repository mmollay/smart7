<?php
include ('../../ssi_smart/smart_form/include_form.php');

if (! $_POST ['delete_id']) {
	if ($_POST ['list_id'] == 'code_list') {
		$table_reload = "table_reload('code_list'); table_reload('promotion_list');";
	} else {
		$table_reload = "table_reload('{$_POST['list_id']}');";
		if ($_POST ['list_id'] == 'followup_pool_list') {
			$table_reload .= "table_reload('followup_list');";
			$_SESSION ['filter'] ['followup_list'] ['pool_id'] = '';
		}
	}
	$count_delete = count ( explode ( ',', $_POST ['update_id'] ) );

	if ($count_delete == 1) {
		$text_before_delete = 'Sicher diesen Beitrag löschen?';
		$text_after_delete = 'Es wurd ein Eintrag enternt.';
	} else {
		$text_before_delete = "Sicher diese $count_delete gewählten Beiträge löschen?";
		$text_after_delete = "Es wurden $count_delete Einträge entfernt.";
	}

	$arr ['ajax'] = array ('success' => " $table_reload $('.modal.ui').modal('hide'); check_alert(); message({ title: 'Entfernen', text:'$text_after_delete'});",'dataType' => "html" );
	$arr ['hidden'] ['delete_id'] = $_POST ['update_id'];
	$arr ['hidden'] ['list_id'] = $_POST ['list_id'];
	$arr ['field'] ['txt'] = array ('tab' => 'first','type' => 'content','text' => "<div class='ui red message'>$text_before_delete</div>" );
	$arr ['button'] ['submit'] = array ('value' => 'Löschen','color' => 'red' );
	$arr ['button'] ['close'] = array ('value' => 'Abbrechen','color' => 'gray','js' => "$('.modal.ui').modal('hide');" );
	$output = call_form ( $arr );
	echo $output ['html'];
	echo $output ['js'];
	exit ();
}

require_once ('../config.inc.php');

$db_nl = $_SESSION ['mysql'] ['db_nl'];
$explode = explode ( ',', $_POST ['delete_id'] );
switch ($_POST ['list_id']) {

	case 'followup_list' :
		// Löscht gesamte Followupsequenz mit allen Mails und Verknüpfungen
		include ('../../ssi_userlist/function.php');
		$array_delstructure = array ('followup_id' => array ("followup","f_action2followup","f_action2tag","f_trigger2tag","f_trigger2time","f_trigger2listbuilding","f_trigger2mail",'f_trigger2followup',"f_mail2followup" => array ('mail_id' => array ("followup_mail" ) ) ) );
		call_structure ( $array_delstructure, $_POST ['delete_id'], $db_nl );
		break;
	case 'followup_pool_list' :
		// Löscht gesamte Followupsequenz mit allen Mails und Verknüpfungen
		include ('../../ssi_userlist/function.php');
		$query = $GLOBALS ['mysqli']->query ( "SELECT followup_id FROM followup WHERE pool_id = '{$_POST['delete_id']}' " );
		while ( $array = mysqli_fetch_array ( $query ) ) {
			$followup_id = $array ['followup_id'];
			$array_delstructure = array ('followup_id' => array ("followup","f_action2followup","f_action2tag","f_trigger2tag","f_trigger2time","f_trigger2listbuilding","f_trigger2mail",'f_trigger2followup',"f_mail2followup" => array ('mail_id' => array ("followup_mail" ) ) ) );
			call_structure ( $array_delstructure, $followup_id, $db_nl );
		}
		$array_delstructure = array ('pool_id' => array ("followup_pool","followup" ) );
		call_structure ( $array_delstructure, $_POST ['delete_id'], $db_nl );
		break;
	case 'promotion_list' :
		$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.promotion WHERE promotion_id = '{$_POST['delete_id']}' LIMIT 1" );
		$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.code WHERE promotion_id = '{$_POST['delete_id']}' LIMIT 1" );
		break;
	case 'code_list' :
		$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.code WHERE code_id = '{$_POST['delete_id']}' LIMIT 1" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		break;
	case 'formulardesign_list' :
		$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.formular_design WHERE formdesign_id = '{$_POST['delete_id']}' LIMIT 1" );
		break;
	case 'listbuilding_list' :
		$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.formular WHERE form_id = '{$_POST['delete_id']}' LIMIT 1" );
		break;
	case 'verification_list' :
		$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.verification WHERE verify_id = '{$_POST['delete_id']}' LIMIT 1" );
		break;
	case 'profile_list' :
		$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.sender WHERE id = '{$_POST['delete_id']}' LIMIT 1" );
		break;
	case 'contact_list' :
		foreach ( $explode as $_POST ['delete_id'] ) {
			$GLOBALS ['mysqli']->query ( "DELETE from $db_nl.contact WHERE contact_id = '{$_POST['delete_id']}' LIMIT 1" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.contact2tag where contact_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		}
		break;
	case 'black_list' :
		$GLOBALS ['mysqli']->query ( "DELETE from $db_nl.blacklist WHERE black_id = '{$_POST['delete_id']}' LIMIT 1" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		break;
	case 'link_list' :
		$GLOBALS ['mysqli']->query ( "DELETE from $db_nl.link WHERE link_id = '{$_POST['delete_id']}' LIMIT 1" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		break;
	case 'tag_list' :
		foreach ( $explode as $_POST ['delete_id'] ) {
			$GLOBALS ['mysqli']->query ( "DELETE from $db_nl.tag WHERE tag_id = '{$_POST['delete_id']}' LIMIT 1" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			$GLOBALS ['mysqli']->query ( "DELETE from $db_nl.contact2tag WHERE tag_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			$GLOBALS ['mysqli']->query ( "DELETE from $db_nl.tag2tag WHERE tag_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			$GLOBALS ['mysqli']->query ( "DELETE from $db_nl.link2tag WHERE tag_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			$GLOBALS ['mysqli']->query ( "DELETE from $db_nl.formular2tag WHERE tag_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		}
		break;
	case 'newsletter_list' :
		foreach ( $explode as $_POST ['delete_id'] ) {
			$GLOBALS ['mysqli']->query ( "UPDATE $db_nl.session SET remove_nl = 1 WHERE session_id = '{$_POST['delete_id']}'  LIMIT 1" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		}
		break;

	case 'newsletter_trash_list' :
		foreach ( $explode as $_POST ['delete_id'] ) {
			$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.session WHERE session_id = '{$_POST['delete_id']}' LIMIT 1" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.logfile WHERE session_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.session_logfile WHERE session_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			$query = $GLOBALS ['mysqli']->query ( "SELECT landingpage_id FROM $db_nl.landingpage WHERE session_id = '{$_POST['delete_id']}' " );
			while ( $array = mysqli_fetch_array ( $query ) ) {
				$landingpage_id = $array ['landingpage_id'];
				$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.contact_id2landingpage_id WHERE landingpage_id = '$landingpage_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			}
			$GLOBALS ['mysqli']->query ( "DELETE FROM $db_nl.landingpage WHERE session_id = '{$_POST['delete_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			// remove Dir
			exec ( "rm -rf $upload_dir/{$_POST['delete_id']}" );
		}
		break;
}