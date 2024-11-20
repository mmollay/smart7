<?
//Nur Superuser darf loeschen
if (in_array ( $_SESSION['user_id'], $_SESSION['array_superuser_id'] )) {
	
	$page_id = $_POST['delete_id'];
	
	// USER_ID auslesen
	$query_user_id = $GLOBALS['mysqli']->query ( "SELECT user_id FROM tbl_page WHERE page_id = '$page_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$array_user_id = mysqli_fetch_array ( $query_user_id );
	$user_id = $array_user_id['user_id'];
	// Loeschen des Ordners
	exec ( "rm -rf ../../../users/user$user_id/explorer/$page_id" );
	exec ( "rm -rf ../../../users/user$user_id/page$page_id" );
	if (! $user_id and ! $page_id)
		return;
	
	include ('include_delPage.php');
}
?>