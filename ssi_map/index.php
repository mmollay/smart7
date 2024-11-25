<?php
session_start();

//laden der Class fur die Ausgabe der Maske inkl. Content
include('../login/ssiPlattform.php');
include('config.inc.php');

$form = new ssiPlattform($module['ID'],$module['title']); //modulname, Überschrift

$form->setConfig("version",$module['version']);

//Aufruf nur wenn Login korrekt war
if ($form->login() == true) {
	include('menu.php');
	$add_js .= "<script>$(document).ready(function() { load_content_set_menu_semantic('{$module['ID']}','{$module['first_load']}'); });</script>";
	//$add_js .= "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
}

$form->setCss($add_css);
$form->setJs($add_js);
$form->setContent("text","<div class=load_content></div><div id=dialog_window></div>");
$form->setContent("menu",$setMenu);

echo  $form->getHTML();