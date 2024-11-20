<?php
// 03.05.2019 mm@ssi.at
// Wird eine Ebene tiefer verknüpft
// Stellt für User die voreingestellte Version ein

// Wenn die Hauptdomain verwendet wird, wird direkt zur Seitenbarbeitung geleitet, Bei "center.xxx. kommt man in Dashboard
include (__DIR__.'/config_main.inc.php');

if ($smart_version == 'stable')
	$folder = 'admin';
	elseif ($smart_version == 'beta')
	$folder = 'admin';
	
	header ( "location: $folder/" );
exit ();