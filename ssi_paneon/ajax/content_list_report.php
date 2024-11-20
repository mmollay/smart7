<?php
$list_id = 'report_list';
include("../../ssi_smart/smart_form/include_list.php");

$array = call_list ('../list/report.php','../config.inc.php');

echo $array['html'].$array['js'];