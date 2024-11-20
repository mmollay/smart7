<?php
// FREE ICONS
// http://www.flaticon.com/categories/business/
require_once ('mysql.inc');
include_once ('functions.inc');

$upload_folder = "$user_folder" . "paneon_upload/";

$default_page_id = '162';
// HACK im ssi_finder, wird unter Config die User_id gesetzt
// user_id ='67';
// $user_id = $_SESSION['user_id'];

// New Upload - Folder
$upload_dir = $document_root . "/smart_users/{$_SESSION['company']}/user$user_id/newsletter"; // Bei Upload muss der absolute Serverpfad verwendet werden
                                                                                              // $user_folder = "../../smart_users/inbs/user$user_id/";
$user_folder = "../../smart_users/ssi/user$user_id/";

// $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/smart_users/{$_SESSION['company']}/user{$_SESSION['user_id']}/newsletter"; // Bei Upload muss der absolute Serverpfad verwendet werden
$upload_url = "../smart_users/{$_SESSION['company']}/user$user_id/newsletter";

// include_once (__DIR__.'/../ssi_newsletter/functions.inc.php');
// $array_value_tag = call_array_tags ();

// Stellt die Verbindung zur Finder->Webseite her
$query2 = $GLOBALS['mysqli']->query("SELECT * from ssi_paneon.setting where user_id = '$user_id'");
$array = mysqli_fetch_array($query2);

// Notwendig, damit Supuser von Paneon Zugriff auf Finder hat!
if (! $array['default_page_id'])
    $array['default_page_id'] = $default_page_id;

$_COOKIE["smart_page_id"] = $_SESSION['smart_page_id'] = $array['default_page_id'];
setcookie("smart_page_id", $_COOKIE["smart_page_id"], time() + 60 * 60 * 24 * 365, '/', $_SERVER['HTTP_HOST']);

