<?php
session_start ();
// laden der Class fur die Ausgabe der Maske inkl. Content
include ('../login/ssiPlattform.php');
include ('functions.inc');

$form = new ssiPlattform ( 'learning', 'Learning' ); // modulname, Überschrift
$form->setConfig ( "version", '0.3' );

// Aufruf nur wenn Login korrekt war
if ($form->login () == true) {
	include ('menu.php');
	$add_js .= "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
}

$form->setContent ( "menu_top", "
<a class='item tooltip' id=home title='Zur Startseite'><i class='home large icon'></i></a>
<a class='item tooltip' title='Themen Einstellungen' id=list_theme><i class='tags large icon'></i>Themen</a>
",'left' );
//$form->setContent ( "menu_top", "<a class='item tooltip' title='Themen Einstellungen' id=list_theme><i class='tags large icon'></i>Themen</a>",'right' );

$form->setCss ( $add_css );
$form->setJs ( $add_js );
$form->setContent ( "text", "<div class=load_content></div><div id=dialog_window></div>" );
$form->setContent ( "menu", $setMenu );

echo $form->getHTML ();
?>