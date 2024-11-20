<?php
if ($_POST ['ajax']) {
	include_once ('../config.inc.php');
}

$query = $GLOBALS['mysqli']->query ( "SELECT * FROM km_settings WHERE user_id = '{$_SESSION['user_id']}'" );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$car_color = $array ['car_color'];
	$car_id = $array ['car_id'];
	$car_nr = $array ['car_nr'];
	$home_address = $array ['home_address'];
	
	$count_car ++;
	$array_select_car [$car_id] ['nr'] = $array ['car_nr'];
	$array_select_car [$car_id] ['car_nr'] = $array ['car_nr'];
	$array_select_car [$car_id] ['car_color'] = $array ['car_color'];
	if ($car_id == $_SESSION ['car_id']) {
		$actual_car_color = $car_color;
		$actual_car_nr = $car_nr;
		$actual_home_address = $home_address;
	}
}

if (! $actual_car_nr) {
	$actual_car_nr = $car_nr;
	$_SESSION ['car_id'] = $car_id;
	$actual_car_color = $car_color;
	$home_address = $actual_home_address;
}

// $count_car = 1;
if ($count_car > 1) {
	$chooseCarSelect [$_SESSION ['car_id']] = 'selected';
	$select_car .= "<select class='ui fluid dropdown select_car_nr' id=change_car >";
	
	foreach ( $array_select_car as $car_id => $value ) {
		$car_nr = $value ['car_nr'];
		$car_color = $value ['car_color'];
		
		if (! $chooseCarSelect [$_SESSION ['car_id']] && ! $set_select_car) {
			$chooseCarSelect [$car_id] = 'selected';
			$set_select_car = true;
		}
		
		$select_car .= "<option id=color_$car_id value='$car_id' style='background-color:$car_color' {$chooseCarSelect[$car_id]} >$car_nr</option>";
	}
	$select_car .= "</select>";
} elseif ($count_car == 1) {
	$select_car .= "<div class=car_nr style='background-color:$actual_car_color'>$actual_car_nr</div>";
}

if ($_POST ['ajax']) {
	echo "<script>laod_change_select_car();</script>";
	echo $select_car;
}