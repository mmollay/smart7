<?php
//call Promotion-Code from Amazon
//include ('../exec/simplemws.php');

include ("../../ssi_smart/smart_form/include_list.php");

$array = call_list ( '../list/promotion.php', '../config.inc.php' );
$promotion_list =  $array['html'] . $array['js'];

$array2 = call_list ( '../list/code.php', '../config.inc.php' );
$code_list =  $array2['html'] . $array2['js'];

$array2 = call_list ( '../list/amazon_order.php', '../config.inc.php' );
$amazon_order_list =  $array2['html'] . $array2['js'];


echo "<script>$(document).ready(function() { $('#tab_promotion_code .item') .tab(); }); </script>";
echo "
<div style='max-width:1100px' id ='tab_promotion_code' >
<div class='ui top pointing secondary red tabular menu '>
<a class='active item' data-tab='first'>Promotion</a>
<a class='item' data-tab='second'>Code</a>
<a class='item' data-tab='third'>Amazon Order</a>
</div>
<div class='ui   active tab ' data-tab='first'>$promotion_list</div>
<div class='ui   tab ' data-tab='second'>$code_list</div>
<div class='ui   tab ' data-tab='third'>$amazon_order_list</div>
</div>";
?>