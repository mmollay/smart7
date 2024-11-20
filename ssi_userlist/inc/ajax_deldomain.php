<?
/*
 * mm@ssi.at 08.09.2020
 * - Remove Page
 * - Remove Folder
 * - Remove Data from DB
 * - Remove conf form apache
 */
if (in_array ( $_SESSION ['user_id'], $_SESSION ['array_superuser_id'] )) {
	$domain_id = mysqli_escape_string ( $GLOBALS ['mysqli'], $_POST ['delete_id'] );

	// Read UserID
	$query = $GLOBALS ['mysqli']->query ( "SELECT page_id,domain,page_id,user_id FROM ssi_company.domain WHERE domain_id = '$domain_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );
	$user_id = $array ['user_id'];
	$page_id = $array ['page_id'];
	$domain = $array ['domain'];

	//Remove Page if page_id is exist
	if ($page_id) {

		$_SESSION ['path_id_user'] = "../..{$_SESSION['path_user']}user$user_id/";
		include_once ('../../ssi_smart/admin/inc/function_del.inc.php');
		$abfrage = del_page ( $page_id );

		for($i = 0; $i < count ( $abfrage ); $i ++) {
			//echo $abfrage[$i]."<br>";
			$GLOBALS ['mysqli']->query ( $abfrage [$i] ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		}

		exec ( "rm -rf {$_SESSION['path_id_user']}/explorer/$page_id" );
		exec ( "rm -rf {$_SESSION['path_id_user']}/page$page_id" );
	}

	if ($domain_id && $domain) {
		// Löschen der Domain in der Domain Liste
		$GLOBALS ['mysqli']->query ( "DELETE FROM ssi_company.domain WHERE domain_id = '$domain_id' " ) or die ( mysqli_error () );
		rm_domain ( $domain );
	}
}
?>