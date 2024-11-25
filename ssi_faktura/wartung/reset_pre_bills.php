<?php

//http://localhost/smart7/ssi_faktura/wartung/reset_pre_bills.php?passwd4w=gj245sdg234fdvs!

// Passwort-schutz
if ($_GET['passwd4w'] != 'gj245sdg234fdvs!') {
    echo "<div style='color:red'>unzulässige Eingabe!</div>";
    exit();
}


/**
 * ***********
 * Wartung: Zurücksetzen der Rechnunge für das automatische Erzeugen von Pre-Rechnungen
 * martin@ssi.at am 13.11.2019
 */
require ("../config.inc.php");

$pre_year = '2024';

$count = 0;

// Löschen der Rechnungen vom Pre-Year 2020
// Sowie entfernen der BIll-Details
$sql = $GLOBALS['mysqli']->query("SELECT bill_id, client_id from bills WHERE DATE_FORMAT(date_create,'%Y') = $pre_year AND company_id = '30' ") or die(mysqli_error($GLOBALS['mysqli']));
while ($array = mysqli_fetch_array($sql)) {
    $bill_id = $array['bill_id'];
    $client_id = $array['client_id'];

    // Delete Bill
    $GLOBALS['mysqli']->query("DELETE from bills WHERE bill_id = '$bill_id' ") or die(mysqli_error($GLOBALS['mysqli']));

    // Delete Datails
    $GLOBALS['mysqli']->query("DELETE from bill_details WHERE bill_id = '$bill_id' ") or die(mysqli_error($GLOBALS['mysqli']));

    $count ++;
}

// Zurücksetzen von send_date
$GLOBALS['mysqli']->query("UPDATE client SET send_date = '0000-00-00' WHERE DATE_FORMAT(send_date,'%Y') = $pre_year AND company_id = '30' ") or die(mysqli_error($GLOBALS['mysqli']));

echo "Es wurden $count Rechnungen aus dem Jahr $pre_year entfernt!";


