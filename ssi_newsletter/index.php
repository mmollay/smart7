<?php
// laden der Class fur die Ausgabe der Maske inkl. Content
include('../login/ssiPlattform.php');

$form = new ssiPlattform("newsletter", "Newsletter"); // modulname, Überschrift

$form->setConfig("version", "7.0.2");

// Aufruf nur wenn Login korrekt war
if ($form->login() == true) {
	include('menu.php');
	$add_js = "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
	$add_js .= "<script type=\"text/javascript\" src=\"js/countdown.js\"></script>";
	$add_js .= "<script type=\"text/javascript\" src=\"js/list_newsletter.js\"></script>";
	$add_css = "<link rel='stylesheet' type='text/css' href='css/main.css' />";

	$setContent .= "<div class=load_content></div>";
}

// $array_menu_top['content_campagne.php'] = array ( 'Aussendung anlegen' , 'write large' );
// $array_menu_top['content_finder.php'] = array ( '&nbsp;Bilder' , 'image large' , 'title' => 'Dateimanager öffnen' );
// $array_menu_top['content_start.php'] = array ( '' , 'home large' , 'title' => 'Zur Startseite' );
// $array_menu_top['content_setting.php'] = array ( '' , 'setting large' , 'title' => 'Newsletter Einstellungen' );

// $array_menu_structure_top = call_menu_structure ( $array_menu_top, 'horicontal' );
// $setMenu_top = $array_menu_structure_top['menu'];
// $setContent .= $array_menu_structure_top['content'];

$form->setCss($add_css);
$form->setJs($add_js);
$form->setContent("text", $setContent);
$form->setContent("menu", $setMenu);
$form->setContent("menu_top", "
		<a class='item tooltip' id=campagne ><i class='edit large icon' ></i> Aussendung anlegen</a>
		<a class='item tooltip' id=finder title='Dateimanager öffnen'><i class='image large icon' ></i>&nbsp; Bilder</a>
		<a class='item tooltip' id=start title='Zur Startseite'><i class='home large icon'></i></a>
		", 'left');

$form->setContent("menu_top", "<a class='item tooltip' title='Newsletter Einstellungen' id=setting><i class='setting large icon'></i></a>", 'right');

// $form->setContent ( "menu_top", "",'left' );

// $form->setContent("logo","../images/logo_newsletter.png");

echo $form->getHTML();
?>