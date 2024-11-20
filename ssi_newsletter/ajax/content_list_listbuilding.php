<?php
include ("../../ssi_smart/smart_form/include_list.php");

$array = call_list ( '../list/listbuilding.php', '../config.inc.php' );
$listpuilding_list = $array['html'] . $array['js'];

$array2 = call_list ( '../list/formular_design.php', '../config.inc.php' );
$design_list = $array2['html'] . $array2['js'];

// $array3 = call_list ( '../list/promotion.php', '../config.inc.php' );
// $promotion_list = $array3['html'] . $array3['js'];

// $array4 = call_list ( '../list/code.php', '../config.inc.php' );
// $code_list = $array4['html'] . $array4['js'];

echo "<script>$(document).ready(function() { $('#tab_listbuilding .item') .tab(); }); </script>";
echo "
<div style='max-width:1200px' id='tab_listbuilding' >
<div class='ui top attached tabular menu tab_listbuilding'>
<a class='active item' data-tab='list_first'><i class='file text outline icon'></i> Listbuilding</a>
<a class='item' data-tab='list_second'><i class='code icon'></i> Einbindung</a>";
// echo "<a class='item' data-tab='list_third'><i class='amazon icon'></i> Promotion</a>";
// echo "<a class='item' data-tab='list_fourth'>Code</a>";
echo "</div>
<div class='ui bottom attached active tab segment' data-tab='list_first'> $listpuilding_list</div>
<div class='ui bottom attached tab segment' data-tab='list_second'>$design_list</div>
</div>";
// echo"<div class='ui bottom attached tab segment' data-tab='list_third'>$promotion_list</div>";
// echo"<div class='ui bottom attached tab segment' data-tab='list_fourth'>$code_list</div>";

?>