<?php
// laden der Class fur die Ausgabe der Maske inkl. Content
include (__DIR__ . '/../login/ssiPlattform.php');

$form = new ssiPlattform ( "tab", "Tabboard" ); // modulname, Überschrift

$form->setConfig ( "version", $_SESSION[smart_version] );

// Aufruf nur wenn Login korrekt war
if ($form->login () == true) {
	// $setContent = "<div class=load_content></div>";
		$setContent = "
	<div id='infotabs'>
  <div class='ui top attached tabular menu'>
    <a class='active item' data-tab='newsletter.php'>Newsletter</a>
    <a class='item' data-tab='faktura.php'>Faktura</a>
    <a class='item' data-tab='smart.php'>Smart</a>
  </div>
  <div class='ui active bottom attached tab segment' data-tab='newsletter.php'>
    1
  </div>
  <div class='ui bottom attached tab segment' data-tab='faktura.php'>
    2
  </div>
  <div class='ui bottom attached tab segment' data-tab='smart.php'>
    3
  </div>
</div>";
	$add_js .= "
	<script>
		$(document).ready(function() { 
			$('#infotabs .menu .item').tab({ auto: true, path: '.' });
	  		$('#infotabs .menu .item').tab('change tab','smart.php');
		});
	</script>";
}

$form->setCss ( $add_css );
$form->setJs ( $add_js );
$form->setContent ( "text", $setContent );
$form->setContent ( "menu", $setMenu );

echo $form->getHTML ();
