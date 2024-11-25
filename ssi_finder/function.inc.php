<?php
/**
 * function.inc.php - SSI Explorer: Funktionen zur Darstellung
 *
 * @author Martin Mollay
 * @last-changed 2010-08-07 MM
 * - einfuegt - ausgabe_uploadform($modus)
 *
 */
function get_subdirs($dir) {
	/**
	 * get_subdirs() - gibt sortierte Liste von Unterverzeichnissen zur�ck
	 *
	 * @param $dir Verzeichnis
	 * @return Array der Unterverzeichnisse oder false, wenn keine gefunden wurden
	 *        
	 */
	if (! is_dir ( $dir ))
		return false;

	$d = dir ( $dir );
	$dirs = array ();
	while ( ($entry = $d->read ()) !== false ) {
		if (! in_array ( $entry, $_SESSION ['IgnoreFileList'] ) && is_dir ( $dir . "/" . $entry )) {
			array_push ( $dirs, $entry );
		}
	}
	$d->close ();
	sort ( $dirs );

	if (count ( $dirs ) > 0) {
		return $dirs;
	} else {
		return false;
	}
}
function NavigationBar($folder_path) {
	$dir_link = '';
	/**
	 * NavigationBar() - Brotkruemmelleiste fuer die Navigation
	 *
	 * @return String anklickbare Pfadstruktur
	 */
	// echo $_SESSION['folder'];
	// echo $_SESSION['folder'];

	// Umwandeln des "/" auf "->" des Defaultpfades
	$default_folder = preg_replace ( "/\//", "->", $_SESSION ['HTTP_SERVER_FOLDER_DEFAULT'] );
	// Umwandeln des "/" auf "->" des aktuellen Pfades
	$set_folder = preg_replace ( "/\//", "->", $folder_path );

	// Entfernen der Defauldpfades aus der Pfadleiste
	$relative_folder = preg_replace ( "/$default_folder/", "", $set_folder );

	// HOME - Button
	// $output .= "<a href=# onclick=\"ajax_FolderPath('{$_SESSION['folder_default']}')\">Home</a>";
	$output = "<a class='section' href=# onclick=\"ajax_FolderPath(true,'/')\">Dateiverwaltung</a>";

	$split_dir = preg_split ( "/->/", $relative_folder );
	foreach ( $split_dir as $dir ) {
		$dir_link .= "$dir/";
		if ($dir) {
			// $output .= "<a href=# onclick=\"ajax_FolderPath('{$_SESSION['folder_default']}$dir_link')\">&raquo; $dir</a>";
			$output .= "<i class='right chevron icon divider'></i><a class='section' href=# onclick=\"ajax_FolderPath(true,'$dir_link')\">$dir</a>";
		}
	}

	// $output .="<br style='clear:both'>";
	return "<div class='ui huge breadcrumb'>" . $output . "</div><br>";
}
function seo_permalink($value) {
	/**
	 * seo_permalink() - Brotkr�mmelleiste f�r die Navigation
	 *
	 * @param $value String
	 * @return String mit umgewandelten Sonderzeichen
	 */
	$turkce = array ("-"," ","ü","Ü","ö","Ö","Ä","ä","ß" );
	$duzgun = array ("","_","ue","Ue","oe","Oe","Ae","ae","sz" );
	$value = str_replace ( $turkce, $duzgun, $value );
	$value = preg_replace ( "@[^A-Za-z0-9\-_.]+@i", "", $value );
	return $value;
}

// Umwandeln von Variablen welche �ber die Uebersetzungslisten beinhalten {}
function ChangeTemplateCallback($matches) {
	return $GLOBALS [$matches ['1']];
}
function ChangeTemplate($text) {
	return preg_replace_callback ( "/{(.*)}/", ChangeTemplateCallback, $text );
}
function countfiles($path) {
	$filecount = '';
	$handle = opendir ( $path );
	while ( $res = readdir ( $handle ) ) {
		if (! in_array ( $res, $_SESSION ['IgnoreFileList'] )) {
			if (is_dir ( $res )) {
			} else {
				$filecount ++;
			}
		}
	}
	if ($filecount <= 0)
		return 0;
	else
		return $filecount;
}
function wordwrap2($str, $width, $break) {
	$return = '';
	$br_width = mb_strlen ( $break, 'UTF-8' );
	for($i = 0, $count = 0; $i < mb_strlen ( $str, 'UTF-8' ); $i ++, $count ++) {
		if (mb_substr ( $str, $i, $br_width, 'UTF-8' ) == $break) {
			$count = 0;
			$return .= mb_substr ( $str, $i, $br_width, 'UTF-8' );
			$i += $br_width - 1;
		}

		if ($count > $width) {
			$return .= $break;
			$count = 0;
		}

		$return .= mb_substr ( $str, $i, 1, 'UTF-8' );
	}

	return $return;
}
?>