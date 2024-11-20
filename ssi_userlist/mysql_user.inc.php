<?php 
//Connect to db
// require_once ('../../../login/config_main.inc.php');

// //Alle User mit einem Verifed Key versehen 
// $query = $GLOBALS['mysqli']->query("SELECT user_id from tbl_user WHERE verify_key = '' ");
// while ($array = mysqli_fetch_array($query)) {
// 	$verify_key = md5 ( uniqid ( rand (), TRUE ) );
// 	$GLOBALS['mysqli']->query ("UPDATE tbl_user SET verify_key = '$verify_key' WHERE user_id = '{$array['user_id']}' ");
// }