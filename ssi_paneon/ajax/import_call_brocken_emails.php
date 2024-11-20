<?php
$setTEXT      = $_POST['liste'];
$setDelimiter = $_POST['setDelimiter'];

$line    = explode("\n",$setTEXT);

$count_user_first = count($line);
$line    = array_unique($line);
$line    = array_filter($line);

//Set Delimter "tab"
if ($setDelimiter == 'tab') {
	$setDelimiter = "\t";
}

//Emailchecker
foreach ($line as $email) {
	//Wenn nicht $setDelimiter gesetzt ist wird
	if (!preg_match("/$setDelimiter/",$email)) {
		$email = strtolower($email);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$line2[] = $email;
		} else { 
			$line_error[] = $email;
			$output .= $email;
		}
	}
	else {
		$array = explode($setDelimiter, $email);
		if(filter_var($array[0], FILTER_VALIDATE_EMAIL)) {
			$line2[] = $email;
		} else { 
		$line_error[] = $array[0];
		$output .= $email;
		}
	}
}

echo $output;
