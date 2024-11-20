<?php
function smart_select_domain($user_id, $select_page_id = false, $allow_new_page = false, $class = 'button fluid small') {
	//$query = $GLOBALS['mysqli']->query ( "SELECT * FROM ssi_company.domain WHERE user_id = $user_id order by timestamp desc" );
	$query = $GLOBALS['mysqli']->query ( "SELECT * FROM ssi_company.domain a LEFT JOIN  {$_SESSION['db_smartkit']}.smart_page b ON a.page_id = b.page_id  WHERE a.user_id = '{$_SESSION['user_id']}' ORDER BY update_date desc" ) or die (mysqli_error( $GLOBALS['mysqli']) );
	
	
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$ii ++;
		$page_id = $array['page_id'];
		$domain = $array['domain'];
		if ($domain)
			$div_item .= "<a href='../ssi_smart/index.php?page_select=$page_id' class='item' id='$page_id' data-value='$page_id' value='$page_id'>$domain (ID:$page_id)</a>"; // <div class='label mini ui'>ID:$page_id</div>
	}
	
	if ($div_item and $ii > 1) {
		
		$output = "
		<div class='ui right dropdown item $class' >
		<input  value='$select_page_id' type='hidden' name='page_select'>
		<div class='text'>Seite wählen</div><i class='dropdown icon'></i>
		<div class='vertical menu'>$div_item</div>				
		</div>";
	} else if ($ii == 1) {
		$_SESSION['smart_page_id'] = $page_id;
		$output .= "<a class='item' href='../ssi_smart/'>$domain</a><br>";
	}
	
	return $output;
}
