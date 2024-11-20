<?php
session_start ();
require_once ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

//Get Domains
function call_smart_select() {
	// Ruft alle bestehenden Domains auf
	$query = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_company.domain a LEFT JOIN {$_SESSION['db_smartkit']}.smart_page b ON a.page_id = b.page_id  WHERE a.user_id = '{$_SESSION['user_id']}' ORDER BY update_date desc" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $domain_array = mysqli_fetch_array ( $query ) ) {
		$ii ++;
		$page_id = $domain_array ['page_id'];
		$domain = $domain_array ['domain'];
		$item [$page_id] = "$domain (ID:$page_id)";
	}
	return $item;
}


$arr ['sql'] = array ('query' => "SELECT * from ssi_paneon.setting where user_id = '{$_SESSION['user_id']}'" );

//$arr['tab'] = array ('tabs' => [ "first" => "Allgemein" , "amazon" => "Amazon"]);
$arr ['form'] = array ('width' => '800','action' => 'ajax/content_setting2.php','size' => '' );

$arr ['field'] ['default_page_id'] = array ('tab' => 'first','type' => 'dropdown','label' => 'Vorausgewählte Seite (für Verknüpfung der Bilder)','array' => call_smart_select (),'placeholder' => '--Webseite wählen--' );

$arr ['button'] ['submit'] = array ('value' => 'Einstellungen speichern','color' => 'blue' );
$output = call_form ( $arr );
echo "<div style='max-width:800px' id='form_message'></div>";
echo "<div class='ui segment' style='max-width:800px'>";
echo $output ['html'];
echo "</div>";
echo $output ['js'];
?>