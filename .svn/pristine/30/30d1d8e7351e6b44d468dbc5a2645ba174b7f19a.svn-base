<?php
session_start ();
include ("../function.inc.php");
$dir = $_POST['name'];
$old = $_POST['old'];

// $folder = $_SESSION['folder'];
$folder = $_SESSION['HTTP_SERVER_FOLDER'];
$dir = seo_permalink ( $dir ); // Umwandeln von Sonderzeichen

// bestehenden Ordner überschreiben
if (is_dir ( "$folder/$old" ) and ! is_dir ( "$folder/$dir" )) {
	rename ( "$folder/$old", "$folder/$dir" );
	echo "new PNotify({ title: 'Umbennenen', text: 'Der Folder \"$dir\" wurde umgeschrieben', type: 'success' });";
	echo "ajax_FolderPath(true);";
	// Vergleicht Ordner
} else if ($old == $new) {
    
	echo "new PNotify({ title: 'Umbennenen', text: 'Die Datei \"$dir\" ist bereits vergeben.'});";
	// Wenn kein Ordner vorhanden wird angelegt
} else if (! is_dir ( "$folder/$dir" )) {
	mkdir ( "$folder/$dir", 0755 );
	echo "new PNotify({ title: 'Anlegen', text: 'Die Datei \"$dir\" erfolgreich angelegt', type: 'success' });";
	echo "ajax_FolderPath(true)";
	//echo "ajax_FolderPath('true','$dir');";
	//echo "alert('$dir');";
	//Wenn Ordner bereits existiert
} else if (is_dir ( "$folder/$dir" )) {
	echo "new PNotify({ title: 'Anlegen', text: 'Die Datei \"$dir\" ist bereits vergeben.', type:'error' });";
} else{
	echo "new PNotify({ title: 'Error', text: 'Allgemeiner Fehler', type:'error' });";
}
	


?>