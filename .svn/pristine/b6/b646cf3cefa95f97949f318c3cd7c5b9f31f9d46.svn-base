<?php
include ("../mysql.inc");

$id = $GLOBALS['mysqli']->real_escape_string ( $_POST['id'] );
$key = $GLOBALS['mysqli']->real_escape_string ( $_POST['key'] );
$value = $GLOBALS['mysqli']->real_escape_string ( $_POST['value'] );

// SESSION
$GLOBALS['mysqli']->query ( "UPDATE session SET $key = '$value' WHERE session_id = '$id' AND user_id = '{$_SESSION['user_id']}'  " ) or die ( mysqli_error ($GLOBALS['mysqli']) );

if ($key == 'from_id') {
	// Parameter werden aus der Datenbank ausgelesen
	$query = $GLOBALS['mysqli']->query ( "SELECT * from sender where user_id = '{$_SESSION['user_id']}' AND id = '$value'" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$aFormValues = mysqli_fetch_array ( $query );
	$from_id = $aFormValues['id'];
	$setFromName = $aFormValues['from_name'];
	$setFromEmail = $aFormValues['from_email'];
	$setReturnPath = $aFormValues['error_email'];
	$setReportEmail = $aFormValues['report_email'];
	$smtp_server = $aFormValues['smtp_server'];
	$smtp_user = $aFormValues['smtp_user'];
	$smtp_password = $aFormValues['smtp_password'];
	$smtp_port = $aFormValues['smtp_port'];
	$smtp_secure = $aFormValues['smtp_secure'];
	$setTestEmail = $aFormValues['test_email'];
	
	$GLOBALS['mysqli']->query ( "UPDATE session SET
	from_name = '$setFromName',
	from_email = '$setFromEmail',
	error_email = '$setReturnPath',
	report_email = '$setReportEmail',
	smtp_server  = '$smtp_server',
	smtp_user    = '$smtp_user',
	smtp_password= '$smtp_password',
	smtp_port    = '$smtp_port',
	smtp_secure  = '$smtp_secure',
	sender_id    = '$from_id',
	test_email   = '$setTestEmail'
	WHERE session_id = '$id' AND user_id = '{$_SESSION['user_id']}'
	" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
}

echo "ok";
exit ();