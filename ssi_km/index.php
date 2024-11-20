<?php
// laden der Class fur die Ausgabe der Maske inkl. Content
include ('../login/ssiPlattform.php');

$form = new ssiPlattform ( "kmlist", "Kilometer" ); // modulname, Überschrift

$form->setConfig ( "version", "2.4" );

// Aufruf nur wenn Login korrekt war
if ($form->login () == true) {
	
	
		// Fuer Google Map app
		$add_js .= "<meta name='viewport' content='initial-scale=1.0, user-scalable=no'/>";
		$add_js .= "<script type='text/javascript' src='https://maps.google.com/maps/api/js?key=AIzaSyAgoO9CQxiF6tddu1WIKqB5vrONEHsoLTM&sensor=false'></script>";
		//$add_js .= "<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyAgoO9CQxiF6tddu1WIKqB5vrONEHsoLTM'></script>";
		$add_js .= "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
		$add_css .= "<link rel='stylesheet' type='text/css' href='css/km.css' />";
		$setContent = "<div class=load_content></div>";

	
	include ('menu.php');
	$form->setCss ( $add_css );
	$form->setJs ( $add_js );
	$form->setContent ( "text", "$setContent" );
	$form->setContent ( "menu", $setMenu );
	// $form->setContent("logo","../images/logo_newsletter.png");
}

echo $form->getHTML ();
