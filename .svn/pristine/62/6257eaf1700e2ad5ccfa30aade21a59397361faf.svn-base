<?php
//laden der Class fur die Ausgabe der Maske inkl. Content
include('../login/ssiPlattform.php');

$form = new ssiPlattform("service","Service"); //modulname, Überschrift

$form->setConfig("version", $_SESSION['smart_version']);

//Aufruf nur wenn Login korrekt war
if ($form->login() == true) {
	include('menu.php');	
	$add_js .= "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
	$setContent = "<div class=load_content></div>";
	//$form->setContent("logo","../images/logo_newsletter.png");
}

$form->setCss($add_css);
$form->setJs($add_js);
$form->setContent("text",$setContent);
$form->setContent("menu",$setMenu);

echo  $form->getHTML();
