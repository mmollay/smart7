<?php
/*
 * Löschen von mehreren Rechnungen mit dem gleichen Datum
 * mm@ssi.at 15.02.2012
 */
include ('../config.inc.php');

// $date = '2012-02-29';

$company_array = array (
		'31' 
);

foreach ( $company_array as $company_id ) {
	
	$sql = $GLOBALS['mysqli']->query ( "SELECT bill_id from bills where company_id = $company_id " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	while ( $array = mysqli_fetch_array ( $sql ) ) {
		$bill_id = $array [0];
		$GLOBALS['mysqli']->query ( "UPDATE bill_details SET belassen =1 WHERE bill_id = $bill_id" );
		// $GLOBALS['mysqli']->query("DELETE from bills WHERE bill_id = $bill_id LIMIT 1 ") or die (mysqli_error());
		// $GLOBALS['mysqli']->query("DELETE from bill_details WHERE bill_id = $bill_id LIMIT 1") or die (mysqli_error());
		$p ++;
	}
	
	// $GLOBALS['mysqli']->query("UPDATE client SET send_date = '' WHERE send_date = '$date' ") or die (mysqli_error());
	/*
	 * $GLOBALS['mysqli']->query("DELETE from accounts WHERE company_id = $company_id") or die(mysqli_error());
	 * $GLOBALS['mysqli']->query("DELETE from article_temp WHERE company_id = $company_id")or die(mysqli_error());
	 * $GLOBALS['mysqli']->query("DELETE from client WHERE company_id = $company_id") or die(mysqli_error());
	 * $GLOBALS['mysqli']->query("DELETE from company WHERE company_id = $company_id") or die(mysqli_error());
	 * $GLOBALS['mysqli']->query("DELETE from issues WHERE company_id = $company_id") or die(mysqli_error());
	 * $GLOBALS['mysqli']->query("DELETE from logfile WHERE company_id = $company_id") or die(mysqli_error());
	 * $GLOBALS['mysqli']->query("DELETE from accounts WHERE company_id = $company_id") or die(mysqli_error());
	 * $GLOBALS['mysqli']->query("DELETE from accounts WHERE company_id = $company_id") or die(mysqli_error());
	 */
	echo "Company $company_id wurde aus dem System entfernt<br>";
}

/*
 $bill_id = 465;
$GLOBALS['mysqli']->query("DELETE from bills WHERE bill_id = $bill_id LIMIT 1 ") or die (mysqli_error());
$GLOBALS['mysqli']->query("DELETE from bill_details WHERE bill_id = $bill_id LIMIT 1") or die (mysqli_error());

echo "Rechnung 465 von Georg entfernt<br>";

$GLOBALS['mysqli']->query("UPDATE bills SET company_id = 4 WHERE company_id = 0 ") or die (mysqli_error());

echo "Company mit id 0 wurden auf ID 4 gesetzt<br>";

$GLOBALS['mysqli']->query ("UPDATE `ssi_faktura`.`issues` SET `account` = '15' WHERE `issues`.`bill_id` =54") or die (mysqli_error());

$GLOBALS['mysqli']->query ("UPDATE `ssi_faktura`.`issues` SET `company_id` = '4' WHERE `issues`.`bill_id` =54") or die (mysqli_error());

echo "Account Update f�r Bueromaterial";
*/