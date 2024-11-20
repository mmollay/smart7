<?php
// UserID wird übergeben
require_once ('../mysql.inc');

foreach ( $_POST as $key => $value ) {
	$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
}


// Zugangsdaten fuer die Datenbank
require_once ('../../login/function_security.php');

switch ($_POST['list_id']) {
	
	// Formular für FollowupPool Speichern
	case 'followup_pool_list' :
		$GLOBALS['mysqli']->query ( "REPLACE INTO followup_pool SET
				pool_id = '$update_id',
				user_id = '$user_id',
				start_followup_id = '$start_followup_id',
				matchcode = '$matchcode',
				description = '$description'
				" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
			
		if (! $update_id) {
			$pool_id  = mysqli_insert_id($GLOBALS['mysqli']);
			
			$_SESSION['filter']['followup_list']['pool_id'] = $pool_id;
			 
			for($iii = 1; $iii <= $count_generate_steps; $iii ++) {

				$sorted = $iii * 10;
				$parent_id = $followup_id;
				$GLOBALS['mysqli']->query ( "INSERT INTO followup SET
				matchcode = 'Step $iii',
				pool_id = '$pool_id',
				user_id = '$user_id',
				sorted = '$sorted',
				trigger_modus = 'trigger_by_step'
				" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
				$followup_id = mysqli_insert_id($GLOBALS['mysqli']);
				
				$GLOBALS['mysqli']->query ( "INSERT INTO f_trigger2followup SET followup_id = '$followup_id', step_id = '$parent_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
				
			}
		}
		
		echo "ok";
		break;
	
	// Formular für Followup Speichern
	case 'followup_list' :
		// $pool_id = '';
		check_mysql_insert ( "SELECT pool_id FROM followup_pool WHERE pool_id='$pool_id' AND user_id = '{$_SESSION['user_id']}' ", "Keine Pool ID vorhanden oder ungültig" );
		
		// trigger_modus = '$trigger_modus' ist nur vorübergehend, da in weiterer Folge Mehrauswahl möglich sein wird
		// Allgemein speichern
		$GLOBALS['mysqli']->query ( "REPLACE INTO followup SET
		followup_id = '$update_id',
		matchcode = '$matchcode',
		description = '$description',
		pool_id = '$pool_id',
		user_id = '$user_id',
		sorted = '$sorted',
		trigger_modus = '$trigger_modus' 
		" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		
		/**
		 * **************************************************************
		 * TRIGGER
		 * **************************************************************
		 */
		$tag_array = explode ( ',', $trigger_tag );
		$tag_not_array = explode ( ',', $trigger_not_tag );
		$tag_new_array = explode ( ',', $trigger_new_tag );
		
		// Clean duplitase
		$tag_array_clean = array_diff_assoc ( $tag_array, $tag_not_array );
		$tag_not_array_clean = array_diff_assoc ( $tag_not_array, $tag_array );
		
		// LÖSCHT DIE TAGS ZUM NEUEN SETZEN
		$GLOBALS['mysqli']->query ( "DELETE FROM f_trigger2tag WHERE followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		
		foreach ( $tag_array_clean as $value ) {
			// echo $value;
			if ($value)
				$GLOBALS['mysqli']->query ( "INSERT INTO f_trigger2tag SET followup_id = '$update_id', tag_id = '$value', new=0" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		// SPEICHERT NOT-TAG
		foreach ( $tag_not_array_clean as $value ) {
			if ($value)
				$GLOBALS['mysqli']->query ( "INSERT INTO f_trigger2tag SET followup_id = '$update_id', tag_id = '$value', no=1, new=0 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		// SPEICHER
		foreach ( $tag_new_array as $value ) {
			// echo $value;
			if ($value)
				$GLOBALS['mysqli']->query ( "INSERT INTO f_trigger2tag SET followup_id = '$update_id', tag_id = '$value', new=1 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		// Speichert die Listbuilding_ID
		if ($trigger_listbuilding_id) {
			$GLOBALS['mysqli']->query ( "DELETE FROM f_trigger2listbuilding WHERE followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
			$GLOBALS['mysqli']->query ( "INSERT INTO f_trigger2listbuilding SET followup_id = '$update_id', listbuilding_id = '$trigger_listbuilding_id'  " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		// Speichert die Verknüfung step_id zu followup_id
		if ($trigger_step_id) {
			$GLOBALS['mysqli']->query ( "DELETE FROM f_trigger2followup WHERE followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
			$GLOBALS['mysqli']->query ( "INSERT INTO f_trigger2followup SET followup_id = '$update_id', step_id = '$trigger_step_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		/**
		 * **************************************************************
		 * MAIL
		 * **************************************************************
		 */
		$GLOBALS['mysqli']->query ( "REPLACE INTO followup_mail SET
		mail_id = '$mail_id',
		user_id = '$user_id',
		matchcode = '$mail_matchcode',
		from_id = '$from_id',
		title   = '$title',
		text    = '$text'
		" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		
		if ($trigger_mail_id) {
			$status_array = explode ( ',', $trigger_mail_status );
			foreach ( $status_array as $value ) {
				
				if ($value == 'open')
					$open = 1;
				if ($value == 'click')
					$click = 1;
			}
			
			$GLOBALS['mysqli']->query ( "DELETE FROM f_trigger2mail WHERE followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
			$GLOBALS['mysqli']->query ( "INSERT INTO f_trigger2mail SET followup_id = '$update_id', mail_id = '$trigger_mail_id',open ='$open',click ='$click'  " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		// Speichert Zeit
		if ($trigger_time) {
			$GLOBALS['mysqli']->query ( "DELETE FROM f_trigger2time WHERE followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
			$GLOBALS['mysqli']->query ( "
			INSERT INTO  f_trigger2time SET 
			mode = '$trigger_time',
			followup_id = '$update_id',
			send_time = '$time_date $time_time',
			day = '$time_day',
			hour = '$time_hour',
			min = '$time_min'
			" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		/**
		 * **************************************************************
		 * ACTION
		 * **************************************************************
		 */
		$tag_add_array = explode ( ',', $action_add_tag );
		$tag_remove_array = explode ( ',', $action_remove_tag );
		
		// Clean duplitase
		$tag_add_array_clean = array_diff_assoc ( $tag_add_array, $tag_remove_array );
		$tag_remove_array_clean = array_diff_assoc ( $tag_remove_array, $tag_add_array );
		
		// print_r($tag_add_array_clean);
		// print_r($tag_remove_array_clean);
		
		// LÖSCHT DIE TAGS ZUM NEUEN SETZEN
		$GLOBALS['mysqli']->query ( "DELETE FROM f_action2tag WHERE followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		
		foreach ( $tag_add_array_clean as $value ) {
			// echo $value;
			if ($value)
				$GLOBALS['mysqli']->query ( "INSERT INTO f_action2tag SET followup_id = '$update_id', tag_id = '$value'" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		// SPEICHERT NOT-TAG
		foreach ( $tag_remove_array_clean as $value ) {
			if ($value)
				$GLOBALS['mysqli']->query ( "INSERT INTO f_action2tag SET followup_id = '$update_id', tag_id = '$value', no=1 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		}
		
		// SPEICHERT AUSLÖSEMAILS BEI ACTION
		$GLOBALS['mysqli']->query ( "DELETE FROM f_action2followup WHERE followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		$action_array_mail_id = explode ( ',', $action_mail_id );
		foreach ( $action_array_mail_id as $value )
			if ($value)
				$GLOBALS['mysqli']->query ( "INSERT INTO f_action2followup SET followup_id = '$update_id', mail_id = '$value' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
		
		echo "ok";
		break;
}
?>