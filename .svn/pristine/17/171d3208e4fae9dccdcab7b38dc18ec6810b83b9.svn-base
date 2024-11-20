<?php

/**
 * \file fetch_amazon_order.php
 * \brief Import der Amazon Bestellungs-Informationen �ber MWS
 *
 * \author Bert Klauninger
 * \author Martin Mollay
 * \version 0.2.2
 * \cond changelog
 *    2017-02-15 - Erstellt
 *    2017-02-21 - Daten in DB spielen
 *    2017-02-28 - FULFILLED_SHIPMENTS_DATA eingebaut
 *    2017-03-06 - Paging (NextToken) bei Report-Listen implementiert
 * \endcond
 */

header('Content-Type: text/plain');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once('SimpleMwsClient.inc.php');	


/** Eintragen der Promotion-ID in die Datenbank */
function insert_order($db, $user_id, $array) {
	mysqli_query($db, "REPLACE INTO amazon_order SET order_id = '{$array['amazon-order-id']}'," .
				" user_id = '$user_id', amazon_promotion_id = '{$array['promotion-ids']}'")
				or die(mysqli_error ($db));
}

/** Erg�nzen aller Felder bei versandten Artikeln */
function insert_shipped($db, $user_id, $array) {
	/* Die Feldnamen werden aus den Namen der Report-Kopfzeilen generiert */
	$vals = '';
	foreach($array as $key => $value) {
		$field_name = str_replace('-', '_', $key);
		if ($field_name != 'amazon_order_id') {
			if ($vals != '') {
				$vals .= ', ';
			}
			$vals .= "$field_name = '$value'";
		}
	}
	
	/* Nur updaten, wenn die Order-ID schon in der DB existiert */
	$sql = "UPDATE amazon_order SET $vals WHERE order_id = '{$array['amazon-order-id']}' LIMIT 1";
	mysqli_query($db, $sql) or die(mysqli_error($db));
}


/*** MAIN ***/

$mwsClient = new SimpleMwsClient();
$mwsClient->init('mws.amazonservices.de' ,			// MWS Host
		'AKIAIAAUHCDIR34F4FDA',						// AWS Access Key Id
		'ZAzuYAuBOnLuN6USmfHberqSwREutLh47e1lkcOf');	// Secret Key

/* Datenbankverbindung aufbauen */
$SQL_HOST = 'localhost';
$SQL_USER = 'root';
$SQL_PASS = 'wkfddr';
$SQL_DB = 'ssi_newsletter';

$db = mysqli_connect($SQL_HOST, $SQL_USER, $SQL_PASS) or die("Could not connect to server $sql_host");
mysqli_select_db($db, $SQL_DB) or die("Could not select database $sql_db");

/* Mapping user_id --> Merchant ID holen */
$merchants = array();
$query = mysqli_query($db, "SELECT mws_merchant_id_eu, user_id FROM setting" .
		" WHERE mws_merchant_id_eu <> '' and user_id <> ''") or die(mysqli_error($db));
while ($row = mysqli_fetch_array($query)) {
	$merchants[$row['user_id']] = $row['mws_merchant_id_eu'];
}

/* Für alle Verkäufer */
foreach ($merchants as $user_id => $merchant_id) {
	echo("Processing merchant $merchant_id (user $user_id)\n");
	
	try {
		
		/* Report-Liste aller Bestellungen holen */
		$xml = $mwsClient->getOrderList($merchant_id);
		$exit_loop = false;
		
		do {
			if (isset($xml->GetReportListByNextTokenResult)) {
				$result = $xml->GetReportListByNextTokenResult;
			} else {
				$result = $xml->GetReportListResult;
			}
				
			foreach($result->ReportInfo as $report_info) {
				$report_id = (string)$report_info->ReportId;
				echo("Processing ORDERS report ID $report_id\n");
				
				$sql = "SELECT report_id FROM amazon_report WHERE report_id='$report_id'";
				$q1 = mysqli_query($db, $sql) or die(mysqli_error($db));
				if (! mysqli_fetch_array($q1)) {
					/* Report wurde noch nicht importiert */
					echo("New report\n");
					
					/* Report holen */
					$report = $mwsClient->getReport($merchant_id, $report_id);
					
					/* Jede Zeile in der Datenbank updaten */
					foreach ($report as $line) {
						echo ("order-id: {$line['amazon-order-id']}, promotion-id: {$line['promotion-ids']}\n");
						insert_order($db, $user_id, $line);
					}
					
					/* Report merken */
					$sql = "INSERT INTO amazon_report(report_id) VALUES('" . $report_id . "')";
					mysqli_query($db, $sql) or die(mysqli_error($db));
				} else {
					/*
					 * Wenn ein Report bereits importiert wurde, dann sind wir mit der 
					 * aktuellen Liste fertig
					 */
					echo("Report already imported\n");
					$exit_loop = true;
					break;
				}
			}
			
			if (! $exit_loop && isset($result->HasNext) && ($result->HasNext == "true")) {
				echo("Fetching next token\n");
				$xml = $mwsClient->getReportListByNextToken($merchant_id, 
						$result->NextToken);
			} else {
				$xml = false;
			}
		} while ($xml !== false);

		/* Report-Liste f�r ausgelieferte Bestellungen holen */
		$xml = $mwsClient->getShipmentList($merchant_id);
		do {
			if (isset($xml->GetReportListByNextTokenResult)) {
				$result = $xml->GetReportListByNextTokenResult;
			} else {
				$result = $xml->GetReportListResult;
			}
			
			foreach($result->ReportInfo as $report_info) {
				$report_id = (string)$report_info->ReportId;
				echo("Processing SHIPPED report ID $report_id\n");
				
				$sql = "SELECT report_id FROM amazon_report WHERE report_id='" . $report_id . "'";
				$q1 = mysqli_query($db, $sql) or die(mysqli_error($db));
				if (! mysqli_fetch_array($q1)) {
					/* Report wurde noch nicht importiert */
					echo("New report\n");
					
					/* Report holen */
					$report = $mwsClient->getReport($merchant_id, $report_id);
					
					/* Zeile in der Datenbank updaten, wenn die Order-ID bereits bekannt ist */
					foreach ($report as $line) {
						echo ("order-id: {$line['amazon-order-id']}\n");
						insert_shipped($db, $user_id, $line);
					}
					
					/* Report merken */
					$sql = "INSERT INTO amazon_report(report_id) VALUES('" . $report_id . "')";
					mysqli_query($db, $sql) or die(mysqli_error($db));
				} else {
					echo("Report already imported\n");
					$exit_loop = true;
					break;
				}
			}
			
			if (! $exit_loop && isset($result->HasNext) && ($result->HasNext == "true")) {
				echo("Fetching next token\n");
				$xml = $mwsClient->getReportListByNextToken($merchant_id, 
						$result->NextToken);
			} else {
				$xml = false;
			}
		} while ($xml !== false);
		
	} catch (Exception $e) {
		echo("ERROR: " . $e->getMessage() . "\n");
	}

}

echo("\nDONE.\n");

?>