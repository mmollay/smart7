<?php
session_start ();
include ("../../ssi_smart/smart_form/include_list.php");
$array = call_list ( '../list/user_logfile.php', '../config.inc.php' );
echo $array['html'] . $array['js'];