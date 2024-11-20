<?php
// laden der Class fur die Ausgabe der Maske inkl. Content
include ('../login/ssiPlattform.php');

$form = new ssiPlattform ( "userlist", "Userlist" ); // modulname, Überschrift

$form->setConfig ( "version",  $_SESSION['smart_version'] );

// Aufruf nur wenn Login korrekt war
if ($form->login () == true) {
	include ('menu.php');
	$add_js .= "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
	$add_js .= "<script src='https://balkangraph.com/js/latest/OrgChart.js'></script>";
	$setContent = "<div class=load_content></div>";
	// $form->setContent("logo","../images/logo_newsletter.png");
}

$form->setCss ( $add_css );
$form->setJs ( $add_js );
$form->setContent ( "text", $setContent );
$form->setContent ( "menu", $setMenu );
echo $form->getHTML ();

// include ('function.php');
// $db = 'ssi_newsletter';
// $array_delstructure = array (
// 		'user_id' => array ( "$db.amazon_order" ,
// 				"$db.blacklist" ,
// 				"$db.formular_design" ,
// 				"$db.sender" ,
// 				"$db.setting" ,
// 				"$db.templates" ,
// 				"$db.verification" ,
// 				"$db.link" ,
// 				"$db.promotion" => array ( 'promotion_id' => array ( "$db.code" ) ) ,
// 				"$db.contact" => array ( 'contact_id' => array ( "$db.client_logfile" , "$db.contact2tag" ) ) ,
// 				"$db.formular" => array ( 'form_id' => array ( "$db.formular2tag" ) ) ,
// 				"$db.tag" => array ( 'tag_id' => array ( "$db.link2tag" , "$db.tag2tag" , "$db.contact2tag" ) ) ,
// 				"$db.session" => array ( 'session_id' => array ( "$db.logfile" , "$db.session_logfile" , "$db.user_logfile" , "$db.landingpage" => array ( "landingpage_id" => array ( "$db.contact_id2landingpage_id" ) ) ) ) ) );
// call_structure ( $array_delstructure, '1227' );



