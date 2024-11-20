<?
include_once ('../../ssi_smart/admin/inc/function_del.inc.php');

// Nur Superuser darf loeschen
if (in_array ( $_SESSION ['user_id'], $_SESSION ['array_superuser_id'] )) {

	$user_id = $_POST ['delete_id'];

	if (! $_POST ['delete_id'])
		return;

	/*
	 * Delete SMART - PAGES
	 */
	$query = $GLOBALS ['mysqli']->query ( "SELECT page_id from smart_page WHERE user_id = '$user_id' AND user_id != '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$page_id = $array ['page_id'];
		$abfrage = del_page ( $page_id );

		for($i = 0; $i < count ( $abfrage ); $i ++) {
			// echo $abfrage[$i]."<br>";
			$GLOBALS ['mysqli']->query ( $abfrage [$i] ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		}
	}

	$array_del_user_tables = array ('smart_information','smart_explorer','email_setting','ssi_company.user2company','log_change_site','tbl_user','module2id_user','smart_feedback_traffic','smart_gadget_meditation' );

	foreach ( $array_del_user_tables as $table_value ) {
		$GLOBALS ['mysqli']->query ( "DELETE from $table_value WHERE user_id = '$user_id' AND user_id != '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	}

	//Nur Folder löschen wenn es sich um SSI - Kunden handelt
	if ($_SESSION ['company'] == 'ssi') {
		exec ( "rm -rf ../../../users/user$user_id" );
	}
	exec ( "rm -rf ../../../smart_users/{$_SESSION['company']}/user$user_id" );

	// REMOVE DATA from BAZAR AND 21 Day
	//mysql_select_db ( 'ssi_bazar', $gaSql['link'] ) or die ( 'Could not select database ' . $cfg_mysql['db'] );
	$GLOBALS ['mysqli']->query ( "DELETE from ssi_bazar.article WHERE user_id = '$user_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$GLOBALS ['mysqli']->query ( "DELETE from ssi_bazar.article_logfile WHERE user_id = '$user_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$GLOBALS ['mysqli']->query ( "DELETE from ssi_bazar.favorite WHERE user_id = '$user_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

	//Delete NEWSLETTER
}
?>