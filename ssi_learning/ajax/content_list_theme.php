<?php
include("../../ssi_smart/smart_form/include_list.php");

$array = call_list ('../list/theme.php','../../login/config_main.inc.php');
echo $array['html'].$array['js'];
echo "<br>";
?>