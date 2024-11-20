<?php

/**
 * export_web.php - Datenbank-Export auf Excel
 *
 * @author Martin Mollay
 * @last-changed 2011-10-21
 *
 */
require ("../config.inc.php");

require_once ('dbio.inc.php');

// Zugangsdaten fuer Datenbank
$DB_HOST = 'localhost';
$DB_USER = $cfg_mysql['user'];
$DB_PASS = $cfg_mysql['password'];
$DB_NAME = $db_faktura;
// $DB_TABLE = $_GET['file'];

// Session wir in mysql_list.php erzeugt
// mm@ssi.at 04.06.2012
$DB_TABLE = $_SESSION ['export'] ['table'];
//$EXPORT_FILTER = $_SESSION ['export'] ['where'];
$EXPORT_FILTER = $_SESSION['export']['filter'];

// Felder in der Reihenfolge die uebertragen werden soll
// Client
if ($_GET ['file'] == 'client') {
	$DB_FIELDS = 'client.client_number#client.company_1#client.company_2#client.gender#client.title#client.firstname#client.secondname#client.street#client.zip#client.city#client.country#client.tel#client.mobil#client.fax#client.email#client.web#client.birth#delivery_company1#delivery_company2#delivery_title#delivery_gender#delivery_firstname#delivery_secondname#delivery_street#delivery_city#delivery_zip#delivery_country#client.newsletter#client.post#client.activ'; // #SUM(booking_total) booking_total#SUM(brutto) brutto#SUM(brutto)-SUM(booking_total) netto';
} elseif ($_GET ['file'] == 'bills') {
	$DB_FIELDS = 'bill_id#bill_number#company_1#company_2#gender#title#firstname#secondname#street#zip#city#country#tel#email#date_create#netto#brutto';
} elseif ($_GET ['file'] == 'issues') {
	$DB_FIELDS = 'bill_id#bill_number#description#company_1#company_2#accounts.title#firstname#secondname#street#zip#city#country#date_create#netto#brutto#tax';
}

/**
 * * MAIN **
 */
$my_dbio = new DBIO ( $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME );

// Header fuer Excel schreiben
$filename = "export_{$_GET ['file']}_" . date ( 'Ymd' );
// header("Content-Disposition: attachment; filename=\"$filename.txt\"");
// header("Content-Type: application/vnd.ms-excel");

// Header fuer Textdatei
header ( "Content-Disposition: attachment; filename=\"$filename.csv\"" );
header ( "Content-Type: text/plain" );

// Daten in temp. File schreiben
$rows = $my_dbio->export ( "-", $DB_TABLE, explode ( '#', $DB_FIELDS ), "\t", $EXPORT_FILTER );

// Nach der folgenden Zeile soll nichts mehr stehen; auch keine Leerzeilen
?>