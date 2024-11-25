<?php
session_start ();
//laden der Class fur die Ausgabe der Maske inkl. Content
include ('../login/ssiPlattform.php');

$form = new ssiPlattform ( "paneon", "Paneon" ); //modulname, Überschrift
$form->setConfig ( "version", "1.2" );

//Aufruf nur wenn Login korrekt war
if ($form->login () == true) {
	include ('menu.php');
	$add_js .= "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
	//$add_js .= "\n<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js'></script>";
	$add_js .= "\n<script type=\"text/javascript\" src=\"../ssi_smart/admin/js/functions_smart.js\"></script>";
	$add_css .= "<link rel='stylesheet' type='text/css' href='css/main.css' />";
}

$output .= "<div class=load_content></div><div id=dialog_window></div>";

// $output .= "
// <div id='show_explorer' class='fullscreen ui modal'>
// <i class='close icon'></i>
// <div class='header'>Dateiverwaltung</div>
// <div id=show_explorer_content></div>
// </div>";

$form->setContent ( "menu_top", "
<a class='item tooltip' id=start title='Zur Startseite'><i class='home large icon'></i></a>
<a class='item tooltip' id=finder title='Dateimanager öffnen'><i class='image large icon' ></i>&nbsp; Bilder</a>
<a class='item tooltip' title='Firmen Einstellungen' id=setting><i class='setting large icon'></i>Einstellungen</a>
", 'left' );

//$form->setContent ( "menu_top", "",'right' );

$form->setCss ( $add_css );
$form->setJs ( $add_js );
$form->setContent ( "text", $output );
$form->setContent ( "menu", $setMenu );
// $form->setContent("logo","../images/logo_newsletter.png");
echo $form->getHTML ();