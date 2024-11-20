<?php
include ("../../ssi_smart/smart_form/include_list.php");

$array2 = call_list ( '../list/followup_pool.php', '../config.inc.php' );
$pool_list = $array2['html'] . $array2['js'];

$array1 = call_list ( '../list/followup_step.php', '../config.inc.php' );
$step_list = $array1['html'] . $array1['js'];

$array3 = call_list ( '../list/followup_send.php', '../config.inc.php' );
$send_list = $array3['html'] . $array3['js'];


$active_pool = '';
$active_step = 'active';

if (!call_array_followup_pool()) {
	$active_pool = 'active';
	$active_step = ''; 
}  

//$active_send = 'active';


echo "<script>$(document).ready(function() { $('#tab_followup .item') .tab(); }); </script>";
echo "<div style='max-width:1100px' id ='tab_followup' >";
echo "<div class='ui top pointing secondary red tabular menu '>";

echo "<a class='item $active_pool'  data-tab='pool'>Follow-Up</a>";
echo "<a class='item $active_step' data-tab='step'>Step</a>";
echo "<a class='item $active_send' data-tab='log'>Logs</a>";
echo "</div>";

echo "<div class='ui $active_pool tab' data-tab='pool'>$pool_list</div>";
echo "<div class='ui $active_step tab' data-tab='step'>$step_list</div>";
echo "<div class='ui $active_send tab' data-tab='log'>$send_list</div>";
echo "</div>";
?>
