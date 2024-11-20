<?php
include ('../config.inc.php');

// Zugangsdaten fuer die Datenbank
foreach ( $_POST as $key => $value ) {
	$GLOBALS [$key] = $GLOBALS ['mysqli']->real_escape_string ( $value );
}

switch ($_POST ['list_id']) {

	case 'session' :

		//Check if session locked
		$sql = "SELECT lock_session from session WHERE session_id = '$update_id'  ";
		$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		$array = mysqli_fetch_array ( $query );

		// 		if ($array ['lock_session']) {
		// 			echo "locked";
		// 			break;
		// 		}

		for($i = 1; $i <= 13; $i ++) {
			$add_mysql .= "x$i = '{$GLOBALS['x'.$i]}',";
		}

		if ($update_id) {
			set_session_finish ( $update_id, $xr );
		}

		$GLOBALS ['mysqli']->query ( "REPLACE INTO usrdb_intubspe.session SET
		session_id = '$update_id',
		$add_mysql
		xr = '$xr',
		xr1 = '$xr1',
		xr2 = '$xr2',
		xr3 = '$xr3',
		title = '$title',
		comment = '$comment',
		lock_session = '$lock_session'
		" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		echo "ok";
		break;

	case 'user' :

		if (! $update_id) {
			$password = md5 ( $password );
			$GLOBALS ['mysqli']->query ( "INSERT INTO usrdb_intubspe.user SET
			nickname = '$nickname',
			email = '$email',
			level = '$level',
			password = '$password'
			" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		} else {
			if ($new_password) {
				$password = md5 ( $password );
				$add_mysql_password = "password = '$password',";
			}

			$GLOBALS ['mysqli']->query ( "UPDATE usrdb_intubspe.user SET
			nickname = '$nickname',
			email = '$email',
			$add_mysql_password	
			level = '$level'
				WHERE user_id = '$update_id'
			" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		}

		echo "ok";
		break;
}
