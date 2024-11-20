<?php
include_once ('../../login/config_main.inc.php');

$GLOBALS['mysqli']->query ( "DELETE FROM ssi_learning.learn_log WHERE user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );

echo "ok";