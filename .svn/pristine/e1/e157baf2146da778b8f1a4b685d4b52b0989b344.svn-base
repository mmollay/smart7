<?php
$text ='
10 => test10
20 => test20
';

$gadget_array_n = explode ( "\n", $text );
foreach ( $gadget_array_n as $set_array ) {
	if ($set_array) {
		$array3 = preg_split ( "[=>]", $set_array, 2 );
		if ($array3 [1])
			$array4 [$array3 [0]] = $array3 [1];
	}
}

$json =  json_encode($array4, true);
$array_value = json_decode ( $json, true );
//echo "<pre>";
print_r ( $array_value );
//echo "</pre>";
?>