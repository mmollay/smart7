<?php
// Zugangsdaten fuer die Datenbank
include_once (__DIR__."/../../login/config_main.inc.php");
include_once (__DIR__ . "/../config_learning.php");

foreach ( $_POST as $key => $value ) {
	if ($value) {
		$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
	}
}

switch ($_POST['list_id']) {
	
	/**
	 * *******************************************************************************
	 * GROUP - FORM 2
	 * *******************************************************************************
	 */
	case question_list :
		if ($_SESSION['theme_id']) {
			// Speichert die letzte Gruppen_id, beschleunigt das eintragen bei der nächsten Frage
			$_SESSION['edit_last_group_id'] = $group_id;
			$_SESSION['edit_last_block_nr'] = $block_nr;
			if ($_POST['update_id']) {
				$GLOBALS['mysqli']->query ( "UPDATE ssi_learning.learn_question SET text = '$text' , title = '$title' , group_id = '$group_id', block_nr = '$block_nr' WHERE question_id = '{$_POST['update_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
				$question_id = $_POST['update_id'];
				$GLOBALS['mysqli']->query ( "DELETE FROM ssi_learning.learn_choice WHERE question_id = '$question_id' " );
			} else {
				$GLOBALS['mysqli']->query ( "INSERT INTO ssi_learning.learn_question SET text = '$text' , title = '$title', group_id= '$group_id', block_nr = '$block_nr', theme_id = '{$_SESSION['theme_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
				$question_id = mysqli_insert_id ( $GLOBALS['mysqli'] );
			}
			
			for($i = 1; $i <= $max_choices; $i ++) {
				if ($GLOBALS["choice_title$i"]) {
					$GLOBALS['mysqli']->query ( "INSERT INTO ssi_learning.learn_choice SET title = '{$GLOBALS["choice_title$i"]}', ranking = $i, correctness = '{$GLOBALS["correctness$i"]}', question_id = '$question_id' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
				}
			}
			
			echo "ok";
		} else
			echo "no_question";
		break;
	
	case group_list :
		if ($_SESSION['theme_id']) {
			if ($_POST['update_id']) {
				$GLOBALS['mysqli']->query ( "UPDATE ssi_learning.learn_group SET title = '$title' WHERE group_id = '{$_POST['update_id']}' and theme_id = '{$_SESSION['theme_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
			} else {
				$GLOBALS['mysqli']->query ( "INSERT INTO ssi_learning.learn_group SET title = '$title', theme_id = '{$_SESSION['theme_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
			}
			echo "ok";
		} else
			echo "no_theme";
		break;
	
	case theme_list :
		
		// Prüfen ob Name nicht existiert
		$query = $GLOBALS['mysqli']->query ( "SELECT theme_id FROM ssi_learning.learn_theme WHERE title = '$title' AND user_id = '{$_SESSION['user_id']}' " );
		$fetch_exist = mysqli_fetch_array ( $query );
		$theme_exist_id = $fetch_exist['theme_id'];
		
		// $label_id = $GLOBALS['mysqli']->real_escape_string ( $_POST['label_id'] );
		if ($_POST['update_id']) {
			if ($theme_exist_id == $_POST['update_id'] OR !$theme_exist_id)
				$GLOBALS['mysqli']->query ( "UPDATE ssi_learning.learn_theme SET title = '$title' , text = '$text' WHERE theme_id = '{$_POST['update_id']}' and user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
			else {
				$title_exists = true;
			}
		} else {
			if (! $theme_exist_id)
				$GLOBALS['mysqli']->query ( "INSERT INTO ssi_learning.learn_theme SET title = '$title', text = '$text' , user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
			else {
				$title_exists = true;
			}
		}
		
		if ($title_exists) {	
			echo "$('#message').message({ status:'red', title: 'Der Titel \"$title\"   wird bereits verwendet! Bitte einen anderen wählen.'  });";
			echo "$('#title').focus();";
			break;
		}
		
		$theme_id = mysqli_insert_id ( $GLOBALS['mysqli'] );
		
		echo "$('#dropdown_theme_id').find('.menu').append('<div class=\'item\' data-value=\'$theme_id\'>$title</div>');";
		echo "$('#dropdown_theme_id').dropdown('refresh');";
		echo "$('#dropdown_theme_id').dropdown('set selected', '$theme_id' );";
		echo "$('#modal_form_theme').modal('hide');";
		echo "table_reload();";
		// echo "ok";
		break;
}
?>