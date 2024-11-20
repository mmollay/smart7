<?php
include ('../config.inc.php');

$id = mysqli_real_escape_string($GLOBALS['mysqli'], $_POST['id']);

$GLOBALS['mysqli']->query ( "UPDATE $db_nl.session SET remove_nl = 0 WHERE session_id = '$id'  LIMIT 1" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );