<?php
// Zugangsdaten fuer die Datenbank
session_start ();
require_once ('../mysql.inc');

$upload_folder = "../../users/user{$_SESSION['user_id']}/newsletter_files";

// Remove Logfiles after REMOVE the session
$id = $GLOBALS['mysqli']->real_escape_string ( $_POST ['id'] );

$GLOBALS['mysqli']->query ( "DELETE FROM logfile WHERE session_id = $id " ) or die ( mysqli_error ($GLOBALS['mysqli']) );

exec ( "rm -rf $upload_folder/$id" );