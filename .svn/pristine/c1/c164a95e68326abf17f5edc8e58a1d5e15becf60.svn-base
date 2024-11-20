<?php
$GLOBALS ['db_faktura'] = new PDO ( 'mysql:host=localhost;dbname=ssi_faktura', 'root', '' );
$GLOBALS ['db_smart'] = new PDO ( 'mysql:host=localhost;dbname=ssi_smart1', 'root', '' );

call();
function call() {
	$statement = $GLOBALS ['db_faktura']->prepare ( "SELECT * FROM client" );
	$statement->execute ();
	while ( $kommentar = $statement->fetch () ) {
		echo $kommentar ['firstname'] . " " . $kommentar ['secondname'] . "<br />";
	}
}
