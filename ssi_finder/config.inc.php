<?php
error_reporting(E_ALL ^ E_NOTICE);
// session_start ();

$version['explorer'] = '3.0';

$document_root = '/var/www/ssi';

if ($_POST['folder_path']) {
    setcookie("folder_path", $_POST['folder_path'], time() + 60 * 60 * 24 * 365, '', $_SERVER['HTTP_HOST']);
    $_COOKIE['folder_path'] = $_POST['folder_path'];
}

if ($_POST['folder_path'])
    $_COOKIE['folder_path'] = $_POST['folder_path'];
if (isset($_POST['page_select']))
    $_SESSION['smart_page_id'] = $_POST['page_select'];
if (isset($_GET['site_select']))
    $_SESSION['site_id'] = $_GET['site_select'];

// wird für alte Version ssi_constructor benötigt;
if (isset($_SESSION['DOCUMENT_ROOT']))
    $document_root = $_SESSION['DOCUMENT_ROOT'];
if (isset($_SESSION['path_user_constuctor']))
    $_SESSION['path_user'] = $_SESSION['path_user_constuctor']; // wird in ckeditor_link.php definiert

// HACK mm@ssi.at 18.Okt.2022 ... ruft die User_ID für Paneon auf wenn Page_id = $default_page_id //Wert in config bie ssi_paneon
if ($_SESSION['smart_page_id'] == 162) {
    $_SESSION['user_id'] = '67';
}

$user_id = $_SESSION['user_id'];
$page_id = $_SESSION['smart_page_id'];
$path_id_user = $_SESSION['path_user'] . "user$user_id/"; // path_user siehe explorer
$path_id_path = "$path_id_user" . "page$page_id/";
$path_id_explorer = "$path_id_user" . "explorer/";
$path_id_explorer_folder = $path_id_explorer . $page_id . '/';
$_SESSION['HTTP_SERVER_FOLDER_DEFAULT'] = $document_root . $path_id_explorer_folder;
$_SESSION['HTTP_SERVER_HOST_DEFAULT'] = $path_id_explorer_folder;

// $_COOKIE['folder_path'] = '/logo';
if ($_SESSION['openDir']) {
    $_SESSION['HTTP_SERVER_FOLDER'] = $document_root . $path_id_explorer_folder . $_SESSION['openDir'] . "/";
    $_SESSION['HTTP_HOST_FOLDER'] = $path_id_explorer_folder . $_SESSION['openDir'] . "/";
    $_SESSION['FOLDER_PATH_RELATIVE'] = $_SESSION['openDir'] . "/";
} else if ($_COOKIE['folder_path']) {
    $_SESSION['HTTP_SERVER_FOLDER'] = $document_root . $path_id_explorer_folder . $_COOKIE['folder_path'];
    $_SESSION['HTTP_HOST_FOLDER'] = $path_id_explorer_folder . $_COOKIE['folder_path'];
    $_SESSION['FOLDER_PATH_RELATIVE'] = $_COOKIE['folder_path'];
} else {
    $_SESSION['HTTP_SERVER_FOLDER'] = $document_root . $path_id_explorer_folder;
    $_SESSION['HTTP_HOST_FOLDER'] = $path_id_explorer_folder;
    $_SESSION['FOLDER_PATH_RELATIVE'] = '';
}

$_SESSION['HTTP_HOST_FOLDER'] = preg_replace('#/+#', '/', $_SESSION['HTTP_HOST_FOLDER']);

// /Applications/XAMPP/xamppfiles/htdocs/center/smart_users/ssi/user40/explorer/13/logo
// /smart_users/ssi/user40/explorer/13/logo

// /Applications/XAMPP/xamppfiles/htdocs/center/smart_users/ssi/user40/explorer/13/
// /smart_users/ssi/user40/explorer/13/

// Wenn der Ordner nicht verfügbar ist
if (! is_dir($_SESSION['HTTP_SERVER_FOLDER'])) {
    $_SESSION['HTTP_SERVER_FOLDER'] = $_SESSION['HTTP_SERVER_FOLDER_DEFAULT'];
    $_SESSION['HTTP_HOST_FOLDER'] = $path_id_explorer_folder;
}

exec("mkdir {$document_root}{$_SESSION['path_user']}");
exec("mkdir {$document_root}$path_id_user "); // Generater new userID
exec("mkdir {$document_root}$path_id_path "); // Generate a new pageID
exec("mkdir {$document_root}$path_id_explorer "); // Generate a new pageID
exec("mkdir {$document_root}$path_id_explorer_folder "); // Generate a new pageID
exec("mkdir {$document_root}$path_id_explorer_folder/thumbnail ");

// Dateien und Files die nicht aufgelistet werden sollen
$_SESSION['IgnoreFileList'] = array("..",".","thumb","thumb_gallery","thumbnails","thumbnail",".DS_Store",".svn",'pikachoose_gallery','autoresize'); //

?>