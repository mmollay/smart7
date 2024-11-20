<?php
session_start();
// $page_id = $_SESSION['smart_page_id'];
$user_id = $_SESSION['user_id'];

$_SESSION['openDir'] = '/smart_users/ssi/user' . $user_id . '/newsletter/folder/';

// Gibt Instruktion an den Explorer, dass er den Link des Images weitergeben soll an den CKEditor
$_SESSION['CKEditorKey'] = 'content_edit';

// Datenbankverbindung herstellen
include_once ('mysql.inc');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Dateiverwaltung</title>
</head>
<body>

<?
$style = 'position: absolute;top: 0;left: 0; width: 100%; height: 100%;';
?>
	
<iframe src="../ssi_finder/index.php?CKEditor=<?=$_GET['CKEditor']?>&type=Images&CKEditorFuncNum=<?=$_GET['CKEditorFuncNum']?>&langCode=de"  style='<?=$style?>' name="Xplorer" frameborder=0></iframe>
</body>
</html>