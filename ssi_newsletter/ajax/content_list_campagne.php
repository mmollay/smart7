<?php
include (__DIR__ . "/../../ssi_smart/smart_form/include_list.php");

$array = call_list('../list/campagne.php', '../config.inc.php');
echo $array['html'] . $array['js'];
echo "<script>appendScript('js/form_newsletter.js');</script>";
echo "<br>";

$close_button = "<div style='float:right'><a href=# onclick=\"$('#modal_testmail').modal('hide')\"><i class='close icon'></i></a></div><div style='clear:both'></div>";
echo "<div id='modal_testmail' class='ui small modal'><div class='header'>Testmail$close_button</div><div class='content'></div></div>";
