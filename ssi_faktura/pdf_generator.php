<?
header('Content-Type: text/html; Charset-utf-8');
/*
 * mm@ssi.at am 05.03.2012
 * UPDATE: Firmenkopf angepasst auf neuen Standard
 */
include_once ('config.inc.php');

/**
 * ***********************************************************
 * //Standardtexte
 * /************************************************************
 */
$default_text['kundennr'] = 'Kundennummer:';
$default_text['datum'] = 'Datum:';
$default_text['maturity'] = 'Zu zahlen bis';

$default_text['lieferdatum'] = 'Lieferdatum:';
$default_text['versand_vorgabe'] = 'Lieferart:';
$default_text['ge_ust'] = 'KD.Ust-ID:';

$default_text['rechnung'] = 'Rechnung';
$default_text['angebot'] = 'Angebot';
// Standardtext bei der Rechungsaufschluesselung
$default_text['pos'] = 'Pos';
$default_text['menge'] = 'Menge';
$default_text['text'] = 'Text';
$default_text['einzelpreis'] = 'Einzelpreis';
$default_text['gesamtpreis'] = 'Gesamtpreis';
$default_text['rabatt'] = 'Rabatt';
$default_text['gesamtbetrag'] = 'Gesamtbetrag';
$default_text['zwischensumme'] = 'Zwischensumme';
$default_text['gesamtrabatt'] = "abzgl. {gesamtrabatt} % Gesamtrabatt";
// $default_text['gesamt_netto'] = 'Gesamt Netto';
$default_text['gesamt_netto'] = 'Summe';
$default_text['zzgl_0'] = 'zzgl. 0,00 % Ust.';
$default_text['zzgl_10'] = 'zzgl. 10,00 % Ust.';
$default_text['zzgl_12'] = 'zzgl. 12,00 % Ust.';
$default_text['zzgl_20'] = 'zzgl. 20,00 % Ust.';
$default_text['steuerfrei'] = 'innergemeinschafltiche steuerfreie Lieferung gem. Art.6 Abs.1iVm Art.7 UstG';
$default_text['steuerfrei2'] = 'steuerfrei';
$default_text['ara_gesamt'] = 'ARA Gesamt';
$default_text['frachtkosten'] = 'Frachtkosten';
// Textausgabe nach der Rechnungsaufstellung
$default_text['lieferanschrift'] = 'Lieferanschrift';
$default_text['lieferscheinnr'] = 'Lieferscheinnr.';

if ($_POST['bill'])
    $bill_id = $_POST['bill'];

if ($_GET['bill'])
    $bill_id = $_GET['bill'];

if (! $bill_id) {
    echo "Rechnungsnummer ist nicht definiert.";
    exit();
}

$bill_array = array();


/**
 * ***********************************************************
 * Auslesen der eignen Firmendaten fuer den Firmenkopf
 * ************************************************************
 */
// db_ausgeben($id_firma,bills5);

// Multi print
// SELECT * FROM bills where company_id = '{$_SESSION['faktura_company_id']}' $mysql_list_filter (old version with Filterfunction)
if ($bill_id == 'all') {
    $sql_bill = $GLOBALS['mysqli']->query("
			SELECT * FROM bills
			WHERE remind_level = 0
			AND company_id = '{$_SESSION['faktura_company_id']}'
			AND date_booking = '0000-00-00'
			AND date_storno = '0000-00-00'
			AND (email = '' OR post = 1)
			") or die(mysqli_error($GLOBALS['mysqli']));
    while ($array = mysqli_fetch_array($sql_bill)) {
        $bill_array[] = $array['bill_id'];
    }
} else {
    $bill_array[] = $_GET['bill'];
}

// PDF HEAD - AND FOOT
require_once (__DIR__ . "/../ssi_smart/php_functions/fpdf/class.fpdf_table.php");
require_once (__DIR__ . "/../ssi_smart/php_functions/fpdf/table_def.inc");
//include (__DIR__ . "/../ssi_smart/php_functions/fpdf/fpdf.php");
include_once (__DIR__ . "/../ssi_smart/php_functions/fpdf/exfpdf.php");
include_once (__DIR__ . "/../ssi_smart/php_functions/fpdf/easyTable.php");

// $pdf=new FPDF_TABLE();
$pdf = new FPDF_MARTIN('P', 'mm', 'A4');

foreach ($bill_array as $bill_id) {

    $rechnung = array();
    $artikel = array();

    // (SELECT SUM(netto*count*((tax+100)/100))-(SUM(netto*count)/100*discount) FROM `bill_details` WHERE bill_id = $bill_id) brutto_total,
    // (SELECT SUM(netto*count)-(SUM(netto*count)/100*discount) FROM `bill_details` WHERE bill_id = $bill_id) netto_total,
    // (SELECT SUM(netto*count*tax/100)-(SUM(netto*count*tax/100)/100*discount) FROM `bill_details` WHERE bill_id = $bill_id) mwst_total,

    // (brutto-netto) mwst_total,
    if (! $bill_id) {
        echo "Keine Rechnungs ID vorhanden";
        exit();
    }
    // Rechnungsdaten auslesen
    $sql1 = $GLOBALS['mysqli']->query("SELECT
			netto  netto_total, no_endsummery,
			brutto brutto_total,document,
			(SELECT SUM(netto*count*tax/100)-(SUM(netto*count*tax/100)/100*discount) FROM `bill_details` WHERE bill_id = $bill_id AND tax = 10) mwst_10_total,
			(SELECT SUM(netto*count*tax/100)-(SUM(netto*count*tax/100)/100*discount) FROM `bill_details` WHERE bill_id = $bill_id AND tax = 12) mwst_12_total,
			(SELECT SUM(netto*count*tax/100)-(SUM(netto*count*tax/100)/100*discount) FROM `bill_details` WHERE bill_id = $bill_id AND tax = 20) mwst_20_total,
			gender,client_id,company_id,company_1,company_2,title,firstname,secondname,street,zip,city,client_number,uid,country,discount,text_after,date_create,bill_number,description,no_mwst
			FROM bills WHERE bill_id = '$bill_id' ") or die(mysqli_error($GLOBALS['mysqli']));
    $array1 = mysqli_fetch_array($sql1);

    $document = $array1['document'];
    $no_endsummery = $array1['no_endsummery'];
    $gender = $array1['gender'];
    $client_id = $array1['client_id'];
    $company_id = $array1['company_id'];
    if (! $company_id) {
        echo "Company_ID ist nicht definiert";
        exit();
    }
    $sql2 = $GLOBALS['mysqli']->query("SELECT * FROM company WHERE company_id = '$company_id' ") or die(mysqli_error($GLOBALS['mysqli']));
    $array2 = mysqli_fetch_array($sql2);

    $content_footer = $array2['content_footer'];

    $fa_name1 = $array2['company_1'];
    $fa_name2 = $array2['company_2'];
    $fa_strasse = $array2['street'];
    $fa_plz = $array2['zip'];
    $fa_ort = $array2['city'];
    $fa_atu = $array2['uid'];
    $fa_fax = $array2['fax'];
    $fa_tel = $array2['tel'];
    $fa_email = $array2['email'];
    $fa_internet = $array2['web'];
    $fa_fbnr = $array2['company_number'];
    $fa_bankname1 = $array2['bank_name'];
    $fa_blz1 = $array2['blz'];
    $fa_kto1 = $array2['kdo'];
    $fa_iban1 = $array2['iban'];
    $fa_bic1 = $array2['bic'];
    $fa_zvr1 = $array2['zvr'];
    $grafic_head = $array2['grafic_head'];
    $fa_gericht = $array2['of_jurisdiction'];

    if ($document == 'ang') {
        // Angebot
        $headline = $array2['ag_headline'];
        $conditions = $array2['ag_conditions'];
        if (! $headline)
            $headline = 'Angebot';
        $default_text['rechnung-title'] = 'Angebotsnummer:';
    } elseif ($document == 'ls') {
        // Lieferschein
        $headline = $array2['ls_headline'];
        $conditions = $array2['ls_conditions'];
        if (! $headline)
            $headline = 'Lieferschein';
        $default_text['rechnung-title'] = 'Lieferscheinnummer:';
    } else {
        // Rechnungen
        $headline = $array2['headline'];
        $conditions = $array2['conditions'];
        if (! $headline)
            $headline = 'Rechnung';
        $default_text['rechnung-title'] = 'Rechnungsnummer:';
    }

    // Set LOGO - HEADER for PDF-Bill
    $_SESSION ['faktura_header'] = "../..".$_SESSION['path_user']."user{$_SESSION['user_id']}/faktura/$company_id/" . $grafic_head;
    //$_SESSION['faktura_header'] = "../../smart_users/user{$_SESSION['user_id']}/faktura/" . $grafic_head;

    // Templatewerte
    $absenderadresse = "$fa_name1 $fa_name2 $fa_strasse, $fa_plz $fa_ort  ";

    // $kopfzeile['text1'] = "<img src=vorlage/img/logo1.gif>";
    // $kopfzeile['text2'] = "<img src=vorlage/img/logo2.gif>";

    $fusszeile['text1'] = utf8_decode($absenderadresse);

    $fusszeile['text2'] = '';
    if ($fa_tel)
        $fusszeile['text2'] .= "Tel.: $fa_tel   ";
    if ($fa_fax)
        $fusszeile['text2'] .= "Fax: $fa_fax   ";
    if ($fa_email)
        $fusszeile['text2'] .= "Email: $fa_email    ";
    if ($fa_interet)
        $fusszeile['text2'] .= "Internet: $fa_internet   ";

    $fusszeile['text3'] = '';
    if ($fa_atu)
        $fusszeile['text3'] .= "UID: $fa_atu   ";
    if ($ara_nummer)
        $fusszeile['text3'] .= "ARA: $ara_nummer   ";
    if ($fa_fbnr)
        $fusszeile['text3'] .= "Firmenbuchnummer: $fa_fbnr ";
    if ($fa_zvr1)
        $fusszeile['text3'] .= "ZVR Zahl: $fa_zvr1 ";
    if ($fa_gericht)
        $fusszeile['text3'] .= "Gerichtsstand: $fa_gericht ";

    $fusszeile['text4'] = '';
    if ($fa_bankname1)
        $fusszeile['text4'] .= "Bankname: $fa_bankname1   ";
    if ($fa_blz1)
        $fusszeile['text4'] .= "BLZ: $fa_blz1  ";
    if ($fa_kto1)
        $fusszeile['text4'] .= "Kto-Nr: $fa_kto1  ";
    if ($fa_iban1)
        $fusszeile['text4'] .= "IBAN: $fa_iban1  ";
    if ($fa_bic1)
        $fusszeile['text4'] .= "BIC: $fa_bic1 ";

    /**
     * ***********************************************************
     * Kundendaten auslesen
     * /************************************************************
     */
    // db_ausgeben($id,bills1);

    // Adresse Kunde
    $kunde['firma'] = trim($array1['company_1']);
    $kunde['zusatz'] = trim($array1['company_2']);

    $kunde['name'] = '';
    /*
     * Anrede (ist aber in pdf1.php derzeit deaktiviert 05.03.12)
     */
    if ($kunde['firma'] or $kunde['zusatz'])
        $kunde['anrede'] = 'Firma';
    else {
        if ($gender == 'm')
            $kunde['anrede'] = 'Herrn';
        elseif ($gender == 'f')
            $kunde['anrede'] = 'Frau';
    }

    // if ($array1['title']) $kunde['name'] .= $array1['title']." ";
    if ($array1['firstname'])
        $kunde['name'] .= $array1['firstname'] . " ";
    if ($array1['secondname'])
        $kunde['name'] .= $array1['secondname'] . " ";

    $kunde['name'] = trim($kunde['name']);

    // $kunde['land'] = $array_country[$array1['country']];
    include_once (__DIR__ . '/../ssi_smart/smart_form/fu_filelist.php');

    $array_country = call_array('country');
    $array1['country'] = strtolower($array1['country']);
    $kunde['land'] = $array_country[$array1['country']];

    $kunde['strasse'] = $array1['street'];
    $kunde['plz'] = $array1['zip'];
    $kunde['ort'] = $array1['city'];
    $kunde['nummer'] = $array1['client_number'];
    $kunde['eg_ust'] = $array1['uid']; // UIDNUMMER des Kunden
    $gesamtrabatt = nr_format($array1['discount']);

    $default_text['gesamtrabatt'] = preg_replace("[{gesamtrabatt}]", $gesamtrabatt, $default_text['gesamtrabatt']);

    $text_after = $array1['text_after'];

    // Faelligkeit ausrechnen fuer Bill

    $rechnung['maturity'] = strtotime('+12 day', strtotime($array1['date_create']));
    $rechnung['maturity'] = date_mysql2german(date('Y-m-d', $rechnung['maturity']));

    $rechnung['datum'] = date_mysql2german($array1['date_create']);
    // $rechnung['maturity'] = $array1['date_create'];

    // $rechnung['lieferdatum'] = date_mysql2german($lieferdatum);
    // $rechnung['versand_vorgabe'] = $versand_vorgabe;

    if ($_SESSION['company_id'] == '31')
        $number_add = 'WTM-';
    else if ($_SESSION['company_id'] == '30')
        $number_add = 'ÖGT-';
    else
        $number_add = '';

    $rechnung['nummer'] = utf8_decode($number_add . $array1['bill_number']);
    
    $rechnung['nummer_pdf'] = utf8_decode($array1['bill_number']);

    $rechnung['betreff'] = $array1['description'];

    $rechnung['zahlungsbedingung'] = $conditions;
    // $rechnung['frachtkosten'] = $frachtkosten;
    $rechnung['mwst_frei'] = $array1['no_mwst'];

    // Auslesen der Lieferscheinnummer bei Rechungsausgabe
    if ($auftragsart == 3) {
        // $rechnung['lieferscheinnr']= db_wert_auslesen2('fa_auftrag','belegnummer',"where id_vorgang='$id_vorgang' and auftragsart='2'");
    }

    $anhang['text'] = '';

    if ($text_after)
        $anhang['text'] .= "$text_after\n\n";

    if ($rechnung['zahlungsbedingung']) {
        $anhang['text'] .= $rechnung['zahlungsbedingung'];
    }

    /**
     * ***********************************************************
     * Ausgabe der einzelnen Positionen
     * /************************************************************
     */

    $array_liste = $GLOBALS['mysqli']->query(" SELECT * from bill_details where bill_id='$bill_id' ");
    while ($ausgabe_liste = mysqli_fetch_array($array_liste)) {
        $i ++;
        $artikel[$i]['pos'] = $i;
        $artikel[$i]['menge'] = nr_format($ausgabe_liste['count']);
        $artikel[$i]['einheit'] = $ausgabe_liste['format'];
        $artikel[$i]['text1'] = $ausgabe_liste['art_title'];
        $artikel[$i]['tax'] = $ausgabe_liste['tax']. "%";
        // if ($id_vorlage == 2)
        $artikel[$i]['text1'] .= "\n" . $ausgabe_liste['art_text'];
        $ausgabe_liste['art_text'];
        // Ausgabe von Rabatt
        // $ausgabe_liste['rabatt'] = "10";

        // Berechnung des Rabattpreises
        $artikel[$i]['rabatt_preis'] = $ausgabe_liste['netto'] / 100 * $ausgabe_liste['rabatt'];
        // Berechung der einzelnen Artikel inkl. Abzug von Rabatt
        $artikel[$i]['einzelgesamtpreis'] = ($ausgabe_liste['netto'] - $artikel[$i]['rabatt_preis']) * $ausgabe_liste['count'];
        // Formatierung fuer die Ausage
        $artikel[$i]['einzelpreis'] = nr_format($ausgabe_liste['netto']);
        $artikel[$i]['gesamtpreis'] = nr_format($artikel[$i]['einzelgesamtpreis']);
        // Summenbildung
        $rechnung['gesamt_netto'] += $artikel[$i]['einzelgesamtpreis'];
        $rechnung['ara_preis_summe'] += $ausgabe_liste['ara_preis'] * $ausgabe_liste['menge'];
        $artikel[$i]['menge'] = nr_format($ausgabe_liste['count']);
        $artikel[$i]['rabatt'] = nr_format($ausgabe_liste['rabatt']) . "%";
        if ($ausgabe_liste['rabatt'] > 0)
            $set_rapatt_header = 1;
    }

    $rechnung['ara_gesamt'] = nr_format($rechnung['ara_preis_summe']);

    /**
     * *********************************************************************
     * Zusatzberrechung Abzug GesamtRabatt
     * *********************************************************************
     */
    if ($gesamtrabatt and $rechnung['gesamt_netto']) {
        $rechnung['zwischensumme'] = nr_format($rechnung['gesamt_netto']);
        $rechnung['gesamtrabatt'] = $rechnung['gesamt_netto'] / 100 * $gesamtrabatt;
        $rechnung['gesamt_netto'] -= $rechnung['gesamtrabatt'];
        $rechnung['format_gesamtrabatt'] = "-" . nr_format($rechnung['gesamtrabatt']);
    }

    /**
     * ********************************************************************
     * //Berechnung der Summe und der Mwst.
     * und Formatierung der Ausgabewerte
     * /*********************************************************************
     */

    // Summenbildung fuer Zusaetze (ARA,Frachtkosten)
    // $zusatz_summe = $rechnung['frachtkosten']+$rechnung['ara_preis_summe'];
    // if ($rechnung['frachtkosten']) $rechnung['frachtkosten'] = nr_format($rechnung['frachtkosten']);

    // Steuer wird dazugerechnet
    if (! $rechnung['mwst_frei']) {
        $default_text['eg_ust_10'] = $default_text['zzgl_10'];
        $default_text['eg_ust_12'] = $default_text['zzgl_12'];
        $default_text['eg_ust_20'] = $default_text['zzgl_20'];
        // $rechnung['zzgl_20'] = ($rechnung['gesamt_netto']+$zusatz_summe)/100*20;
        // $zusatz_summe_brutto = $zusatz_summe;
    }
    /*
     * elseif ($rechnung['mwst_frei']){
     * $rechnung['zzgl_20'] = '';
     * //$zusatz_summe_brutto = $zusatz_summe;
     * }
     * else {
     * /*
     * if ($id_vorlage==2)
     * $default_text['eg_ust'] = $default_text['steuerfrei2'];
     * else
     * $default_text['eg_ust'] = $default_text['steuerfrei'];
     */
    // $rechnung['zzgl_20'] = '';
    // }

    // $rechnung['gesamt_brutto'] = nr_format($rechnung['gesamt_netto']+$rechnung['zzgl_20']+$zusatz_summe_brutto);
    // $rechnung['gesamt_netto'] = nr_format($rechnung['gesamt_netto']+$zusatz_summe);
    // $rechnung['zzgl_20'] = nr_format($rechnung['zzgl_20']);

    $rechnung['zzgl_10'] = nr_format($array1['mwst_10_total']);
    $rechnung['zzgl_12'] = nr_format($array1['mwst_12_total']);
    $rechnung['zzgl_20'] = nr_format($array1['mwst_20_total']);
    $rechnung['gesamt_netto'] = nr_format($array1['netto_total']);
    $rechnung['gesamt_brutto'] = nr_format($array1['brutto_total']);
    // $rechnung['gesamt_brutto'] = nr_format($array1['brutto_total']);

    $re_kuerzel = strtoupper($document);
    
    $pdf_dateiname = $kunde['nummer'] . "-" . $re_kuerzel . "-" . $rechnung['nummer_pdf'] . '.pdf';

    // Werte in das Templates uebertragen
    include ("pdf1.php");
}

if (! $pdf_output['modus'])
    $pdf_output['modus'] = 'I';

$pdf->Output($pdf_output['path'] . $pdf_dateiname, $pdf_output['modus']);

?>