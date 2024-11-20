<?php
include_once (__DIR__ . '/../../ssi_smart/admin/function.inc.php');
include_once (__DIR__ . '/../../login/config_main.inc.php');

$url = $_POST['url'];
$name = $_POST['name'];
if ($_POST['page_id'])
	$page_id = $_POST['page_id'];
else
	$page_id = $_SESSION['smart_page_id'];

$url = strtolower ( seo_permalink ( $url ) );

if ($url and $page_id) {
	// Nachprüfen ob es den Namen schon gibt
	$query = $GLOBALS['mysqli']->query ( "SELECT * from smart_langSite t1 LEFT JOIN smart_id_site2id_page t2 ON t2.site_id = t1.fk_id  WHERE site_url = '$url' AND page_id = '$page_id' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
	if (mysqli_num_rows ( $query )) {
		echo "$('#label_$name>.check_message').html('<div class=\'ui red basic label show_label_exists\'>Name existiert bereits</div>');";
	} else {
		echo "$('#label_$name>.check_message').html('');";
		
		if ($name == 'funnel_short') {
			echo "$('.$name').html('$url');";
		}
		echo "$('#$name').val('$url');";
	}
	
	echo "if ($('.show_label_exists').length) { $('.generate_funnel.submit').addClass('disabled'); } else { $('.generate_funnel.submit').removeClass('disabled'); } ";
} else {
	echo "alert('keine PageID vorhanden');";
	exit ();
}
