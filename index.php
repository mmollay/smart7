<?php
// if ($_SERVER['HTTP_HOST'] == 'localhost')
//      $show_tabboard = true;
include ('login/config_main.inc.php');
$_SESSION['smart_page_id'] = call_page_id ( $HTTP_HOST );
if ($_SESSION['smart_page_id']) {
        header ( "location: ssi_smart/index.php" );
} else {
        header ( "location: ssi_dashboard/index.php" );
}
