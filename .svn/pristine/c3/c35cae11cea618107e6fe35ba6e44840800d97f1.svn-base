<?php

//<iframe src='$link'  style='height:400px; width:100%; border:none;' scrolling='auto' allowtransparency='true'></iframe>
// <object style='width:100%;' height="400" data="$link"></object> 

$camp_key = $_GET['key'];
$call_iframe = true;
$layer_id = '123';
// Call Function
include_once ("../mysql.inc");
include_once ("../../ssi_smart/smart_form/include_form.php");
include_once ("../../ssi_smart/library/functions.php");

$sql = $GLOBALS['mysqli']->query ( "SELECT setting_array from formular_design WHERE camp_key = '$camp_key'" );
$array = mysqli_fetch_array ( $sql );
$gadget_array = $array['setting_array'];
$gadget_array_n = explode ( "|", $gadget_array );
if ($gadget_array_n) {
	foreach ( $gadget_array_n as $array ) {
		$array2 = preg_split ( "[=]", $array, 2 );
		$GLOBALS[$array2[0]] = $array2[1];
	}
}


include_once ("../../ssi_smart/gadgets/newsletter/include.inc.php");

$output = preg_replace ( "/\[\[(.*?)\]\]/", $output, $format );
$output = call_design ( $gadget_array, $output );


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>SSI-Newsletter Formular</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
<meta http-equiv='expires' content='0'>
<meta name='generator' content='SmartKit v<?=$_SESSION ['version_smart']?>'>
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'>
<link rel="stylesheet" href="../../ssi_smart/smart_form/semantic/dist/semantic.min.css">
</head>
<body style="background:none transparent">
	<script src="../../ssi_smart/smart_form/jquery.min.js"></script>
	<script src="../../ssi_smart/smart_form/smart_form.js"></script>
	<script src="../../ssi_smart/smart_form/semantic/dist/semantic.min.js"></script>
	<?
	echo $output_form['js'];
	if (($label_class =='left ribbon' or $label_class =='right ribbon')  && $show_label) echo "<div class='ui container'>";
	echo"<div id='layer$layer_id'>$output</div>";
	if (($label_class =='left ribbon' or $label_class =='right ribbon')  && $show_label) echo "</div>";
	?>
</body>
</html>