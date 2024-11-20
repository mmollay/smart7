<?php
session_start ();

// if ($_POST['folder_path']) $_SESSION['HTTP_SERVER_FOLDER'] = $_POST['folder_path'];
// if ($_POST['folder_path']) $_SESSION['HTTP_SERVER_FOLDER'] = $_POST['folder_path'];
include_once ('../config.inc.php');
include_once ('../function.inc.php');

$output_folder .= "<div data-tooltip='Neuer Ordner, hier klicken' data-position='bottom center' style='cursor:pointer' href=# onclick='ajax_EditDir()' class='card explorer_folder_new' id='AddDirId'><div class='content'><i class='icon grey inverted large folder'></i> Neuen Ordner</div></div>";
// $output_folder .= "<div class=explorer_folder_new id='AddDirId2'><a href=# onclick=\"ajax_AddDir1()\">Neuen Ordner</a></div>";


//Anlegen von Thumbnail
if (! is_dir ( "{$_SESSION['HTTP_SERVER_FOLDER']}/thumbnail" )) {
	exec ( "mkdir {$_SESSION['HTTP_SERVER_FOLDER']}/thumbnail" );
}

$array = get_subdirs ( $_SESSION['HTTP_SERVER_FOLDER'] );

// $page_id = $_SESSION ['smart_page_id'];

if ($array) {
	
	foreach ( $array as $value2 ) {
		
		if (is_dir ( $_SESSION['HTTP_SERVER_FOLDER_DEFAULT'] . $value2 . "/thumb" )) {
			
			if (! is_dir ( $_SESSION['HTTP_SERVER_FOLDER_DEFAULT'] . $value2 . "/thumbnail" )) {
				exec ( "mv {$_SESSION ['HTTP_SERVER_FOLDER_DEFAULT']}{$value2}/thumb  {$_SESSION ['HTTP_SERVER_FOLDER_DEFAULT']}{$value2}/thumbnail" );
			}
		}
		
		
		
		// generiert den relativen Pfad zum aufrufen des SUbfolders
		$pattern = "[" . $_SESSION['HTTP_SERVER_FOLDER_DEFAULT'] . "]";
		
		$value1 = preg_replace ( $pattern, "", $_SESSION['HTTP_SERVER_FOLDER'] );
		
		if (strlen ( $value2 ) > 20) {
			$value2_text = substr ( $value2, 0, 12 ) . "..." . substr ( $value2, - 5 );
		} else
			$value2_text = $value2;
		
		$output_folder .= "<a style='cursor:pointer' data-position='bottom center' data-tooltip='Einstellungen - rechte Maus klicken' class='card explorer_folder' id='$value2' onclick=\"ajax_FolderPath(true,'$value1$value2/')\" > <div class='content'>$value2_text <span class='ui circular label'>" . countfiles ( $_SESSION['HTTP_SERVER_FOLDER'] . $value2 ) . "</span></div></a>";
	}
}

echo "<div class='ui finder accordion'>";
echo "<div class='active title'><i class='dropdown icon'></i>";
echo NavigationBar ( $_SESSION['HTTP_SERVER_FOLDER'] );
echo "</div>";
echo "<div class='active content'>";

echo "<div class='ui five doubling cards'>$output_folder</div>";
echo "</div>";
echo "</div>";
?>