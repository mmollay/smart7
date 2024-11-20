<?php
include('../login/ssiPlattform.php');
$form = new ssiPlattform("center","Center"); //modulname, Überschrift
$center_version = $_SESSION['smart_version']; 

$form->setConfig("version",$center_version);

//$form->setUser($_SESSION['user'],$_SESSION['password']);
//Aufruf nur wenn Login korrekt war
if ($form->login() == true) {
	
	include('include.php');
	
	$form->setCss($add_css);
	$form->setJs($add_js);
	$form->setContent("text",$content);
	$form->setContent("menu","");
	//$form->setContent("logo","../images/logo_newsletter.png");
}
else {
 //include ('../login/logout.php');    
}

echo  $form->getHTML();

