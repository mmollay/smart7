<?php
include_once ('config.inc.php');

$new = "<div class='ui green mini empty circular label'></div>New";
$new = "<label class='ui label orange mini'>New</label>";
$demo = "<label class='ui label mini red orange'>Demo</label>";

$array_menu ['content_list_campagne.php'] = array ('Aussendungen','mail','active','id' => 'list_campagne' );
$array_menu [] = 'hr';
$array_menu ['content_list_contact.php'] = array ('Kontakte','users','id' => 'list_contact' );
$array_menu ['content_import.php'] = array ('Import','upload','id' => 'import' );
$array_menu ['content_list_tag.php'] = array ('Tags','tags','id' => 'list_tag' );
$array_menu [] = 'hr';
$array_menu ['content_list_listbuilding.php'] = array ('Listbuilding','file list layout','id' => 'list_listbuilding' );
//$array_menu['content_list_promotion.php'] = array ( 'Promotion/Code' , 'amazon' , 'id' =>'list_promotion' ); 
$array_menu ['content_list_followup.php'] = array ('Follow-Up','sitemap','id' => 'list_followup' );
$array_menu [] = 'hr';
$array_menu ['content_list_sender.php'] = array ('Absender','at','id' => 'list_sender' );
$array_menu ['content_list_black.php'] = array ('Blacklist','remove user','id' => 'list_black' );
$array_menu ['content_list_verification.php'] = array ('Verifizierung','warning sign','icon_id' => 'verify_alert','id' => 'list_verification' );
$array_menu ['content_duplicate.php'] = array ('Reinigung','fire extinguisher','id' => 'duplicate' );
$array_menu ['content_list_campagne_trash.php'] = array ('Mistkübel','trash','id' => 'list_campagne_trash' );

// NEUE VERSION IST ABER NOCH NICHT GANG EINSATZFÄHIG - Weil die Tabs sich nicht neu laden sollen sich aber bei
// Switch die Einstellungen merken sollen - also nicht auch Chash sondern einfach so...
$array_menu_structure = call_menu_structure ( $array_menu );
$setContent = $array_menu_structure ['content'];

$setMenu = $array_menu_structure ['menu'];

if ($user_id == '40') {
	$setMenu .= "<div id='modal_manuel_send' class='ui small modal'><div class='header'>Manueles Versenden</div><div class='content'></div></div>";
	$setMenu .= "<hr>";
	$setMenu .= "<a href=# class='ui button mini'  onclick = 'SendMailManuel()'>Manueles Versenden</a>";
	$setMenu .= "<hr>";
	$setMenu .= "<a href='addone/index.php'>FollowUp-TEST</a>";
	$setMenu .= "<hr><br>";
}

if (!isset ($upload_folder)) $upload_folder = '';

$setMenu .= "<div class='item' id=user_space class='message mini ui' >" . user_space ( $paket, $user_paket, $upload_folder ) . "</div>";
$setMenu .= "<div id=dialog></div>";