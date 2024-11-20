<?php
require ("../config.inc.php");

// $GLOBALS['mysqli']->query ( "SET NAMES 'utf8'" );
// $GLOBALS['mysqli']->query ( "SET CHARACTER SET 'utf8'" );

$client_id = $GLOBALS['mysqli']->real_escape_string($_POST['id']);

// Wert fuer "PRE" - Erzeugung der Rechnungebn
$setting = $_POST['setting'];

/*
 * Erzeugt Pre-Rechnungen fuer das kommende Jahr
 * TODO:
 * - Rechnungsdatum beachten
 * - Rechungsnummer beachten 20150001 ...
 * - Wenn neue Rechnung erstellt wird im alten Jahr (alten Rechnungslauf verwenden)
 * - Flag setzen, damit Rechnungen vom aktuellem Jahr korrekt eingegliedert werden
 *
 * // Todo: Wenn die Mitgliedschaft vor Ende des Jahres ausläuft wird keine Rechnung mehr erstellt
 * // -> Ist die Mitgliedschaft beendet, gibt es auch keine Sektionen mehr
 * // -> Mitglied läuft weiter aber Sektion läuft aus (bis Ende des Jahres)
 * // -> Anfang und Ende der Sektionen überpruefen
 *
 *
 * // Selectbox -> Einnahmen Anzeigen der Seiten die zu drucken und per Email versendet werden sollen
 * // Formular nach rechts rücken für Fensterkuver
 * // Samthaftes Mahnen mit Button ...Kosten
 * // Mitgliedstatus Checkbox ist nutzlos, da sich die Mitgliedschaft auf dem Datumsbereich ergibt (Filter zu beachten - select bei Liste)
 *
 *
 */
if ($client_id == 'all' or $setting == 'pre') {

    // Wenn Pre erzeugt werden soll wird eine Jahr mehr genommen
    if ($setting == 'pre')
        $year = date("Y", strtotime('+1 year'));
    // Erzeugen der im aktuell befindlichen Mitglieder

    else
        $year = date("Y");

        $sql = 
        "SELECT client.client_id client_id FROM client LEFT JOIN membership
		ON client.client_id = membership.client_id
		WHERE DATE_FORMAT(date_membership_start,'%Y') <= '$year'
		AND (DATE_FORMAT(date_membership_stop,'%Y') = '0000' OR DATE_FORMAT(date_membership_stop,'%Y') >= '$year')
		AND company_id='{$_SESSION['company_id']}'
		AND DATE_FORMAT(send_date,'%Y') != $year";
    $query = $GLOBALS['mysqli']->query($sql) or die(mysqli_error($GLOBALS['mysqli']));
    while ($array_client = mysqli_fetch_array($query)) {
        $array_generate[$array_client['client_id']] = $array_client['client_id'];
    }
} // Generate single Bill
elseif ($client_id) {
    $array_generate[$client_id] = $client_id;
}

if (! $array_generate)
    $array_generate = array();

if ($setting == 'pre') {
    $year = date("Y", strtotime('+1 year'));
    $bill_date = "'$year" . "-01-01'";
    $set_bill_number = $year . "0001"; // erste Nummer im Vorlauf - beginnt mit "kommendesJahr"0101
} else {
    $year = date("Y");
    $bill_date = 'NOW()';
}

$counter = 0;
foreach ($array_generate as $client_id) {
    // Bei Pre-Faktura Lauf wird die erste Rechnungsnummer mit "kommenden Jahr gesetzt" - Danach setzt diese auf den letzt gültigen auf
    if ($set_bill_number) {
        $bill_number = $set_bill_number;
        $set_bill_number = '';
    } else {
        // Auslesen der letzten ReNr. falls Default hoeher diesen verwenden
        $bill_number = mysql_singleoutput("SELECT MAX(bill_number) as bill_number FROM bills WHERE company_id = '{$_SESSION['faktura_company_id']}' ", "bill_number") + 1;
        $bill_number_default = mysql_singleoutput("SELECT default_bill_number FROM company WHERE company_id = '{$_SESSION['faktura_company_id']}' ", "default_bill_number");
    }

    if ($bill_number_default > $bill_number)
        $bill_number = $bill_number_default;

    // $query1 = $GLOBALS['mysqli']->query ( "SELECT max(bill_number) FROM bills where company_id='{$_SESSION['faktura_company_id']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
    // $array_bill_number = mysqli_fetch_array ( $query1 );
    // Erzeugen
    // $bill_number = $array_bill_number [0] + 1;

    // Read Userdata
    $query = $GLOBALS['mysqli']->query("SELECT * FROM client where client_id='$client_id'") or die(mysqli_error($GLOBALS['mysqli']));
    $array_client = mysqli_fetch_array($query);

    // $one_year_later = mktime(0, 0, 0, date("m"), date("d"), date("Y")+1);
    $save_date = mktime($array_client['send_date']);

    // if ($array_client['send_date'] != '0000-00-00' ) {
    // $exits_counter++;
    // }
    // else {

    $company_1 = $GLOBALS['mysqli']->real_escape_string($array_client['company_1']);
    $company_2 = $GLOBALS['mysqli']->real_escape_string($array_client['company_2']);
    $firstname = $GLOBALS['mysqli']->real_escape_string($array_client['firstname']);
    $secondname = $GLOBALS['mysqli']->real_escape_string($array_client['secondname']);
    $street = $GLOBALS['mysqli']->real_escape_string($array_client['street']);
    $city = $GLOBALS['mysqli']->real_escape_string($array_client['city']);
    $title = $GLOBALS['mysqli']->real_escape_string($array_client['title']);

    // Erzeugt automatisch den Betreff: Mitgliedsbeitrag
    // mm@ssi.at am 25.03.2019
    $array_client['description'] = utf8_decode("Mitgliedsbeitrag $year");

    $GLOBALS['mysqli']->query("INSERT INTO bills SET
	bill_number = '$bill_number',
	date_create = $bill_date,
	company_id  = '{$_SESSION['faktura_company_id']}',
	client_id   = '$client_id',
	client_number= '{$array_client['client_number']}',
	company_1   = '$company_1',
	company_2   = '$company_2',
	title       = '$title',
	gender      = '{$array_client['gender']}',
	firstname   = '$firstname',
	secondname  = '$secondname',
	street      = '$street',
	zip         = '{$array_client['zip']}',
	city        = '$city',
	country     = '{$array_client['country']}',
	tel         = '{$array_client['tel']}',
	email       = '{$array_client['email']}',
	web         = '{$array_client['web']}',
	uid         = '{$array_client['uid']}',
	description = '{$array_client['description']}',
	text_after  = '{$array_client['text_after']}',
	discount    = '{$array_client['discount']}',
	no_mwst     = '{$array_client['no_mwst']}',
	post        = '{$array_client['post']}'
	") or die(mysqli_error($GLOBALS['mysqli']));
    $bill_id = mysqli_insert_id($GLOBALS['mysqli']);

    $netto_sum = '';
    $brutto_sum = '';

    // Mitgliedschaften
    $query_section = $GLOBALS['mysqli']->query("SELECT * from article_temp,accounts,membership 
			WHERE account = account_id 
			AND temp_id = membership_id 
			AND client_id = '$client_id' 
			AND DATE_FORMAT(date_membership_start,'%Y') <= $year AND (DATE_FORMAT(date_membership_stop,'%Y') >= $year OR date_membership_stop = 0000-00-00)
			");
    // $query_section = $GLOBALS['mysqli']->query ("SELECT * from membership INNER JOIN article_temp ON temp_id = membership_id WHERE client_id = '$client_id' ");
    while ($array = mysqli_fetch_array($query_section)) {
        $nr = $array['temp_id'];
        $title = $array['art_title'];
        $text = $array['art_text'];
        $count = $array['count'];
        $account = $array['account'];
        $netto = $array['netto'];
        $format = $array['format'];
        $tax = $array['tax'];
        $brutto = $netto / 100 * $tax + $netto;
        $netto_sum += $netto * $count;
        $brutto_sum += $brutto * $count;

        // Eintrage der Detail-Infos in die Datenbank
        $GLOBALS['mysqli']->query("REPLACE INTO bill_details SET
		bill_id   = '$bill_id',
		art_nr    = '$nr',
		art_title = '$title',
		art_text  = '$text',
		count     = '$count',
		account   = '$account',
		netto     = '$netto',
		format    = '$format' ") or die(mysqli_error($GLOBALS['mysqli']));
    }

    // Sektionen
    $query_section = $GLOBALS['mysqli']->query("SELECT * from article_temp,accounts,sections 
			WHERE account = account_id 
			AND temp_id = section_id 
			AND client_id = '$client_id' 
			AND DATE_FORMAT(date_sections_start,'%Y') <= $year AND (DATE_FORMAT(date_sections_stop,'%Y') >= $year OR date_sections_stop = 0000-00-00)
			");
    // $query_section = $GLOBALS['mysqli']->query ("SELECT * from sections INNER JOIN article_temp ON temp_id = section_id WHERE client_id = '$client_id' ");
    while ($array = mysqli_fetch_array($query_section)) {
        $nr = $array['temp_id'];
        $title = $array['art_title'];
        $text = $array['art_text'];
        $count = $array['count'];
        $account = $array['account'];
        $netto = $array['netto'];
        $format = $array['format'];
        $tax = $array['tax'];
        $brutto = $netto / 100 * $tax + $netto;
        $netto_sum += $netto * $count;
        $brutto_sum += $brutto * $count;

        // Eintrage der Detail-Infos in die Datenbank
        $GLOBALS['mysqli']->query("REPLACE INTO bill_details SET
		bill_id   = '$bill_id',
		art_nr    = '$nr',
		art_title = '$title',
		art_text  = '$text',
		count     = '$count',
		account   = '$account',
		netto     = '$netto',
		format    = '$format' ") or die(mysqli_error($GLOBALS['mysqli']));
    }

    // UPDATE brutto and netto
    $GLOBALS['mysqli']->query("UPDATE bills SET brutto = '$brutto_sum', netto = '$netto_sum' WHERE bill_number = '$bill_number' LIMIT 1 ") or die(mysqli_error($GLOBALS['mysqli']));

    // Save Senddatum
    $GLOBALS['mysqli']->query("UPDATE client SET send_date = $bill_date where client_id = '$client_id' LIMIT 1") or die(mysqli_error($GLOBALS['mysqli']));

    $counter ++;
    // }
}

if ($exits_counter == 1)
    echo "1 Rechnung wurde bereits erstellt!<br>";
elseif ($exits_counter > 1)
    echo "$exits_counter  Rechungen wurden bereits erstellt<br>";

if ($counter == 1)
    echo "Es wurde $counter Rechnung erzeugt";
elseif ($counter > 1)
    echo "Es wurden $counter Rechnungen erzeugt<br>";
elseif (! $exits_counter or ! $counter)
    echo "Keine Erzeugung von Rechungen vorhanden!";
