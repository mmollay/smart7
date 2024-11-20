<?php
session_start ();

require_once ('../config.inc.php');

$query = $GLOBALS['mysqli']->query ( "SELECT Count(email) count, email FROM contact WHERE user_id='{$_SESSION['user_id']}'  GROUP by email HAVING count>1 " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$ii = 0;
	$iii ++;
	//echo $array['email'] . "(" . $array['count'] . ")<br>";
	$query2 = $GLOBALS['mysqli']->query ( "SELECT contact_id,email,activate FROM contact WHERE email = '{$array['email']}' AND user_id='{$_SESSION['user_id']}' order by activate " ) or die (mysqli_error());
	while ( $array2 = mysqli_fetch_array ( $query2 ) ) {
		if ($ii) {
			// echo $array2['email'] . "-" . $array2['activate'] . "<br>";
			$GLOBALS['mysqli']->query ( "DELETE FROM contact WHERE contact_id = '{$array2['contact_id']}' LIMIT 1" );
		} else {
			// echo $array2['email'] . "-" . $array2['activate'] . "<br>";
		}
		$ii ++;
	}
}

if ($iii) {
	$message =  "Es wurden $iii Duplikate entfernt.";
} else {
	$message = "Keine Duplikate vorhanden.";
}

echo "<div style='max-width:800px;' class='ui icon success message'>
<i class='checkmark green icon'></i>
<div class='content'>
<div class='header'>Info</div>
$message
</div>
</div>";
?>
