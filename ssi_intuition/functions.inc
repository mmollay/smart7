<?php
//setzt status für den User
function set_session_finish($session_id, $xr) {
	//if xr then user_session
	$GLOBALS ['mysqli']->query ( "UPDATE usrdb_intubspe.user2session SET
				success = 1 WHERE session_id = '$session_id' AND level=3 AND tip = '$xr' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

	if ($xr == 3)
		$xr_2 = 2;
	elseif ($xr == - 3)
		$xr_2 = - 2;
	else
		$xr_2 = $xr;

	$GLOBALS ['mysqli']->query ( "UPDATE usrdb_intubspe.user2session SET
				success = 1 WHERE session_id = '$session_id' AND level=2 AND tip = '$xr_2' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

	if ($xr >= 1)
		$xr_3 = 1;
	if ($xr <= - 1)
		$xr_3 = - 1;
	else
		$xr_3 = $xr;

	$GLOBALS ['mysqli']->query ( "UPDATE usrdb_intubspe.user2session SET
				success = 1 WHERE session_id = '$session_id' AND level=1 AND tip = '$xr_3' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

	//Set User Level after Successfull tip

	//Change after susseccfull tips
	//Level 1 to Level 2 -> 5
	//Level 2 to Level 3 -> 25
	$array_change_level = array ('2' => 5,'3' => 25 );

	//foreach ($array_change_level)

	
}
