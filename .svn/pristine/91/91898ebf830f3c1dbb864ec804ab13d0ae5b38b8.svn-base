<?


/**
 * **************
 * LAYER2PAGE
 * **************
 */

$query_layer_id = $GLOBALS['mysqli']->query ( "SELECT layer_id FROM id_layer2id_page where page_id = '$page_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
while ( $array_layer_id = mysqli_fetch_array ( $query_layer_id ) ) {
	$layer_id = $array_layer_id['layer_id'];
	/*
	 * LAYER_ID
	 */
	$abfrage[] = "DELETE FROM tbl_layer WHERE layer_id = '$layer_id' "; // Layer allgemein
	$abfrage[] = "DELETE FROM LangLayer WHERE fk_id = '$layer_id' ";
}

$abfrage[] = "DELETE FROM id_layer2id_page WHERE page_id = '$page_id' "; // Layer2Page verknuepfung
$abfrage[] = "DELETE FROM id_seite2id_page WHERE page_id = '$page_id' "; // Seite2Page verknuepfung

/**
 * **************
 * SEITE2PAGE
 * **************
 */
$query_site_id = $GLOBALS['mysqli']->query ( "SELECT seite_id FROM id_seite2id_page where page_id = '$page_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
while ( $array_site_id = mysqli_fetch_array ( $query_site_id ) ) {
	$seite_id = $array_site_id['seite_id'];
	
	/*
	 * SITE_ID
	 */
	$abfrage[] = "DELETE FROM tbl_seite WHERE seite_id = '$seite_id' "; // Seite allgemein
	$abfrage[] = "DELETE FROM LangSeite WHERE fk_id = '$seite_id' "; // Seite mit Sprachen
	$abfrage[] = "DELETE FROM id_layer2id_seite WHERE seite_id = '$seite_id' "; // Layer2Page verknuepfung
	
	/*
	 * LAYER_ID
	 */
	$query_layer_id = $GLOBALS['mysqli']->query ( "SELECT layer_id FROM id_layer2id_seite where seite_id = '$seite_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	while ( $array_layer_id = mysqli_fetch_array ( $query_layer_id ) ) {
		$layer_id = $array_layer_id['layer_id'];
		$abfrage[] = "DELETE FROM tbl_layer WHERE layer_id = '$layer_id' "; // Layer allgemein
		$abfrage[] = "DELETE FROM LangLayer WHERE fk_id = '$layer_id' ";
	}
}

/**
 * **************
 * MENU
 * **************
 */
$query_menu_id = $GLOBALS['mysqli']->query ( "SELECT menu_id FROM tbl_menu WHERE page_id = '$page_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
while ( $array_menu_id = mysqli_fetch_array ( $query_menu_id ) ) {
	$menu_id = $array_menu_id['menu_id'];
	
	$query_menu_fields = $GLOBALS['mysqli']->query ( "SELECT id FROM menu WHERE menu_id = '$menu_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	while ( $array_menu_fields = mysqli_fetch_array ( $query_menu_fields ) ) {
		$menu_field_id = $array_menu_fields['id'];
		$abfrage[] = "DELETE FROM menu WHERE id = '$menu_field_id' "; // Seite allgemein
		$abfrage[] = "DELETE FROM LangMenu WHERE fk_id = '$menu_field_id' "; // Seite mit Sprachen
	}
}
$abfrage[] = "DELETE FROM tbl_menu WHERE page_id = '$page_id' "; // Menü entfernen

/*
 * PAGE_ID
 */
$abfrage[] = "DELETE FROM tbl_domain WHERE page_id = '$page_id' "; // DOMAIN
$abfrage[] = "DELETE FROM tbl_page WHERE page_id = '$page_id' "; // DOMAIN

/**
 * *************
 * PROFIL
 * *************
 */
$query_profil_id = $GLOBALS['mysqli']->query ( "SELECT profil_id FROM tbl_profil WHERE page_id = '$page_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
while ( $array_profil_id = mysqli_fetch_array ( $query_profil_id ) ) {
	$profil_id = $array_profil_id['profil_id'];
	$abfrage[] = "DELETE FROM tbl_profil WHERE profil_id = '$profil_id' "; // PROFIL
	$abfrage[] = "DELETE FROM LangLayout WHERE fk_id = '$profil_id' ";
}

$abfrage[] = "DELETE FROM tbl_profil WHERE page_id = '$page_id' "; // PROFIL von der Menüleiste

/*
 * USER_ID
 */
// $abfrage[] = "DELETE FROM tbl_user WHERE user_id = '$user_id' "; //User
$abfrage[] = "DELETE FROM tbl_profil_menu WHERE page_id = '$page_id' "; // PROFIL MENU

for($i = 0; $i < count ( $abfrage ); $i ++) {
	// echo $abfrage[$i]."<br>";
	$GLOBALS['mysqli']->query ( $abfrage[$i] ) or die ( mysqli_error ($GLOBALS['mysqli']) );
}

?>