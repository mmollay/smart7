<?php
// mm@ssi.at 04.03.2017
// Speichert einzelne Wert aus einem Formular (form_followup.php)

include ("../mysql.inc");

$id = $GLOBALS['mysqli']->real_escape_string ( $_POST['id'] );
$key = $GLOBALS['mysqli']->real_escape_string ( $_POST['key'] );
$value = $GLOBALS['mysqli']->real_escape_string ( $_POST['value'] );

// Autosave vor Followup -Mails
//echo "UPDATE followup_mail SET $key = '$value' WHERE mail_id = '$id' AND user_id = '{$_SESSION['user_id']}'  ";
$GLOBALS['mysqli']->query ( "UPDATE followup_mail SET $key = '$value' WHERE mail_id = '$id' AND user_id = '{$_SESSION['user_id']}'  " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
echo "ok";
return;