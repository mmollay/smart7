<?php
include("../../ssi_smart/smart_form/include_list.php");
$array = call_list ('../list/black.php','../config.inc.php');
echo $array['html'].$array['js'];
?>