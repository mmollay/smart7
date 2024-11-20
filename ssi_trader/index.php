<?php
session_start();

//laden der Class fur die Ausgabe der Maske inkl. Content
include ('../login/ssiPlattform.php');
include ('config.inc.php');

updateTokensIfNeeded($mysqli, $username, $password);

$form = new ssiPlattform($module['ID'], $module['title']); //modulname, Überschrift

$form->setConfig("version", $module['version']);

//Aufruf nur wenn Login korrekt war
if ($form->login() == true) {
	include ('menu.php');
	$add_js .= "<script>$(document).ready(function() { load_content_set_menu_semantic('{$module['ID']}','{$module['first_load']}'); });</script>";
	$add_js .= "<script type=\"text/javascript\" src=\"js/main.js\"></script>";
	$add_js .= "<script> loadScriptIfNotAlreadyLoaded('js/function_home.js');</script>";
	$add_js .= "\n<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
	$add_js .= "\n<script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels'></script>";
}

$form->setCss($add_css);
$form->setJs($add_js);
$form->setContent("text", "<div class=load_content></div><div id=dialog_window></div>");
$form->setContent("menu", $setMenu);

echo $form->getHTML();


