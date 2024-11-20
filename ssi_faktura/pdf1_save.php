<?php
define('EURO', ' ' . chr(128));

// $rechnung['betreff'] = htmlspecialchars ( $rechnung['betreff'] );
// $rechnung['betreff'] = utf8_decode ( $rechnung['betreff'] );
// $rechnung['betreff'] = htmlspecialchars ( $rechnung['betreff'] );

// $rechnung['betreff'] = stripslashes($rechnung['betreff']);
$rechnung['betreff'] = iconv('UTF-8', 'windows-1252', $rechnung['betreff']);

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('Arial', '', 10);

// $table=new easyTable($pdf, '%{30,30, 20, 20}', 'width:70; border:0; font-size:8; line-height:1.2; paddingX:0');
// $table->easyCell('Nutrition Facts', 'colspan:4;font-style:B; font-size:20;line-height:0.6;');
// $table->printRow();

$zellenhoehe = 5;
$zellenhoehe_title = 6; // Zellenhoehe bei den Listenueberschriften

/**
 * ******************************
 * Anschrift erstellen
 * *******************************
 */
$AnschriftX = 18;

$pdf->SetY(47);
$pdf->SetX($AnschriftX);
$pdf->SetFont('', 'U', 7);
$pdf->Cell(0, $zellenhoehe, utf8_decode($absenderadresse), 0, 1);
$pdf->Ln(2);
$pdf->SetFont('', '', 10);

// $pdf->Cell(0, $zellenhoehe, "An:", 0, 1);
// if ($kunde['anrede']) $pdf->Cell(0, $zellenhoehe, $kunde['anrede'], 0, 1);
if ($kunde['firma']) {
    // $pdf->SetFont('Arial', 'B');
    $pdf->SetX($AnschriftX);
    $pdf->Cell(0, $zellenhoehe, utf8_decode($kunde['firma']), 0, 1);

    // $pdf->SetFont('Arial', '');
}
if ($kunde['zusatz'] and $kunde['firma']) {
    $pdf->SetX($AnschriftX);
    $pdf->Cell(0, $zellenhoehe, utf8_decode($kunde['zusatz']), 0, 1);
}
// if ($kunde['anrede'] && $kunde['secondname']) $pdf->Cell(0, $zellenhoehe, $kunde['anrede'], 0, 1);
if ($kunde['name'] != $kunde['firma']) {
    $pdf->SetX($AnschriftX);
    $pdf->Cell(0, $zellenhoehe, utf8_decode($kunde['name']), 0, 1);
}

$pdf->SetX($AnschriftX);
$pdf->Cell(0, $zellenhoehe, utf8_decode($kunde['strasse']), 0, 1);
$pdf->Ln(5);
$pdf->SetX($AnschriftX);
$pdf->Cell(0, $zellenhoehe, $kunde['plz'] . " " . utf8_decode($kunde['ort']), 0, 1);
$pdf->SetX($AnschriftX);
$pdf->Cell(0, $zellenhoehe, utf8_decode($kunde['land']), 0, 1);

if ($client_id) {
    // Kundennummer
    $pdf->Cell(120, $zellenhoehe, '', 0, 0, 'R');
    $pdf->Cell(40, $zellenhoehe, $default_text['kundennr'], 0, 0, '');
    $pdf->Cell(30, $zellenhoehe, $kunde['nummer'], 0, 1, 'R');
}

// UID - des Kunden
if ($kunde['eg_ust']) {
    $pdf->Cell(120, $zellenhoehe, '', 0, 0, 'R');
    $pdf->Cell(40, $zellenhoehe, $default_text['ge_ust'], 0, 0, '');
    $pdf->Cell(30, $zellenhoehe, $kunde['eg_ust'], 0, 1, 'R');
}

// Rechnungsnummer
$pdf->Cell(120, $zellenhoehe, '', 0, 0, 'R');
$pdf->Cell(40, $zellenhoehe, $default_text['rechnung-title'], 0, 0, '');
$pdf->Cell(30, $zellenhoehe, $rechnung['nummer'], 0, 1, 'R');

// Rechnungsdatum
$pdf->Cell(120, $zellenhoehe, '', 0, 0, 'R');
$pdf->Cell(40, $zellenhoehe, $default_text['datum'], 0, 0, '');
$pdf->Cell(30, $zellenhoehe, $rechnung['datum'], 0, 1, 'R');

// F�lligkeit:
// $pdf->Cell(130, $zellenhoehe, '',0, 0,'R');
// $pdf->Cell(30, $zellenhoehe, $default_text['maturity'], 0, 0, '');
// $pdf->Cell(30, $zellenhoehe, $rechnung['maturity'], 0, 1, 'R');

/*
 * if ($rechnung['lieferdatum'] != "00.00.0000") {
 * $pdf->Cell(130, $zellenhoehe, '',0, 0,'R');
 * $pdf->Cell(30, $zellenhoehe, $default_text['lieferdatum'], 0, 0, '');
 * $pdf->Cell(30, $zellenhoehe, $rechnung['lieferdatum'], 0, 1, 'R');
 * }
 */

if ($rechnung['lieferscheinnr']) {
    $pdf->Cell(120, $zellenhoehe, '', 0, 0, 'R');
    $pdf->Cell(40, $zellenhoehe, $default_text['lieferscheinnr'], 0, 0, '');
    $pdf->Cell(30, $zellenhoehe, $rechnung['lieferscheinnr'], 0, 1, 'R');
}

if ($rechnung['versand_vorgabe']) {
    $pdf->Cell(120, $zellenhoehe, '', 0, 0, 'R');
    $pdf->Cell(40, $zellenhoehe, $default_text['versand_vorgabe'], 0, 0, '');
    $pdf->Cell(30, $zellenhoehe, $rechnung['versand_vorgabe'], 0, 1, 'R');
}

/**
 * ******************************
 * Rechnungs-titel
 * *******************************
 */
// $pdf->Cell(0, $zellenhoehe, utf8_decode($default_text['rechnung-title']).' '.$rechnung['nummer'], 0, 1);

// Text bei kopfzeile (Default = Rechnung)
if ($headline) {
    $pdf->SetY(100);
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, $zellenhoehe, utf8_decode($headline), 0, 1);
} else {
    $pdf->SetY(90);
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, $zellenhoehe, utf8_decode($default_text['rechnung']), 0, 1);
}

if ($rechnung['betreff']) {
    // Betreff
    $pdf->SetFont('Arial', '', 9);
    $pdf->Ln(5);
    $pdf->MultiCell(0, $zellenhoehe, $rechnung['betreff'], 0, 1);
}

if ($auftragsart != 2 && $rechnung['lieferanschrift']) {
    // Ausgabe Lieferanschrift
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'U', 12);
    $pdf->Cell(0, $zellenhoehe, $rechnung['lieferanschrift'], 0, 1);
}

$pdf->Ln(5);
if ($auftragsart == 2)
    $columns = 4; // spaltenanzahl fuer die Tabellen
else
    $columns = 7;

// we initialize the table class
$pdf->Table_Init($columns, true, true);
$pdf->Set_Table_Type($table_default_table_type);

/**
 * ******************************
 * TABLE Kopf fuer die Artikelliste
 * *******************************
 */
for ($i = 0; $i < $columns; $i ++)
    $header_type[$i] = $table_default_header_type;
$header_type[0]['WIDTH'] = 10;
$header_type[1]['WIDTH'] = 10;
$header_type[2]['WIDTH'] = 18;

$header_type[0]['TEXT'] = $default_text['pos'];
$header_type[1]['TEXT'] = $default_text['menge'];
$header_type[2]['TEXT'] = '';
$header_type[3]['TEXT'] = $default_text['text'];
$header_type[1]['COLSPAN'] = "2";
$header_type[3]['WIDTH'] = 151;
if ($auftragsart != 2) {
    $header_type[3]['WIDTH'] = 92;
    $header_type[4]['WIDTH'] = 22;
    $header_type[5]['WIDTH'] = 14;
    $header_type[6]['WIDTH'] = 22;
    $header_type[4]['TEXT'] = $default_text['einzelpreis'];
    
    $header_type[5]['TEXT'] = 'Mwst.';
    //if ($set_rapatt_header == 1)
    //    $header_type[5]['TEXT'] = $default_text['rabatt'];
    
    $header_type[6]['TEXT'] = $default_text['gesamtpreis'];
}

// set the header type
$pdf->Set_Header_Type($header_type);
$pdf->Draw_Header();

/**
 * ******************************
 * TABLE Artikelauflistung
 * *******************************
 */
$data_subtype = $table_default_data_type;
$data_type = Array(); // reset the array

for ($i = 0; $i < $columns; $i ++)
    $data_type[$i] = $data_subtype;

$pdf->Set_Data_Type($data_type);

if ($artikel) {
    foreach ($artikel as $value) :
        $data = Array();
        if (! $value['gesamtpreis'])
            $value['gesamtpreis'] = '0,00';

        $data[0]['TEXT'] = $value['pos'];
        $data[1]['TEXT'] = $value['menge'];
        $data[1]['T_ALIGN'] = 'R';

        $data[2]['TEXT'] = utf8_decode($value['einheit']);
        // $data[3]['TEXT'] = utf8_decode ( $value['text1'] );
        $data[3]['TEXT'] = iconv('UTF-8', 'windows-1252', $value['text1']);
        if ($auftragsart != 2) {
            $data[4]['T_ALIGN'] = 'R';
            $data[5]['T_ALIGN'] = 'R';
            $data[6]['T_ALIGN'] = 'R';
            $data[4]['TEXT'] = $value['einzelpreis'] . EURO;
            // if ($set_rapatt_header == 1)
            //$data[5]['TEXT'] = $value['rabatt'];
            
            if ($gesamtrabatt > 0) $data[5]['TEXT'] = $value['tax'];
            //else $data[5]['TEXT'] = '0%';
            
            
            $data[6]['TEXT'] = $value['gesamtpreis'] . EURO;
        }
        $pdf->Draw_Data($data);
    endforeach
    ;
}

// $header_subtype = $table_default_header_type;
for ($i = 0; $i < $columns; $i ++)
    $foot[$i] = $table_default_foot_type;

/**
 * ******************************
 * Ausgabe der Summenbildung
 * *******************************
 */
if ($auftragsart != 2) {
    
    
    if ($rechnung['gesamtrabatt'] > 0) :
    
        if (! $rechnung['format_gesamtrabatt'])
            $rechnung['format_gesamtrabatt'] = '0,00';

        $foot[0]['TEXT'] = $default_text['gesamtrabatt'];
        $foot[1]['TEXT'] = '';
        $foot[2]['TEXT'] = '';
        $foot[3]['TEXT'] = '';
        $foot[4]['TEXT'] = '';
        $foot[5]['TEXT'] = '';
        $foot[6]['TEXT'] = $rechnung['format_gesamtrabatt'] . EURO;
        ;
        $foot[6]['T_ALIGN'] = 'R';
        $foot[0]['COLSPAN'] = 6;
        $foot[0]['T_ALIGN'] = 'L';
        $pdf->Draw_Data($foot);
	

	endif;

    if (! $no_endsummery) {
        if ($rechnung['ara_preis_summe']) {
            // ARA-Wert
            $foot[0]['TEXT'] = $default_text['ara_gesamt'];
            $foot[1]['TEXT'] = '';
            $foot[2]['TEXT'] = '';
            $foot[3]['TEXT'] = '';
            $foot[4]['TEXT'] = '';
            $foot[5]['TEXT'] = '';
            $foot[6]['TEXT'] = $rechnung['ara_gesamt'] . EURO;
            ;
            $foot[0]['COLSPAN'] = 6;
            $foot[0]['T_ALIGN'] = 'L';
            $foot[6]['T_ALIGN'] = 'R';
            $pdf->Draw_Data($foot);
        }

        $foot[0]['TEXT'] = $default_text['gesamt_netto'];
        $foot[1]['TEXT'] = '';
        $foot[2]['TEXT'] = '';
        $foot[3]['TEXT'] = '';
        $foot[4]['TEXT'] = '';
        $foot[5]['TEXT'] = '';
        $foot[6]['TEXT'] = $rechnung['gesamt_netto'] . EURO;
        ;
        $foot[0]['COLSPAN'] = 6;
        $foot[0]['T_ALIGN'] = 'L';
        $foot[6]['T_ALIGN'] = 'R';
        $pdf->Draw_Data($foot);

        // Ausgabe der Mwst
        foreach (array(
            10,
            12,
            20
        ) as $value) {
            if ($default_text['eg_ust_' . $value] and $rechnung['zzgl_' . $value]) {
                $set_ust = true;
                $foot[0]['TEXT'] = $default_text['eg_ust_' . $value];
                $foot[1]['TEXT'] = '';
                $foot[2]['TEXT'] = '';
                $foot[3]['TEXT'] = '';
                $foot[4]['TEXT'] = '';
                $foot[5]['TEXT'] = '';
                $foot[6]['TEXT'] = $rechnung['zzgl_' . $value] . EURO;
                $foot[6]['T_ALIGN'] = 'R';
                $foot[0]['COLSPAN'] = 6;
                $foot[0]['T_ALIGN'] = 'L';
                $pdf->Draw_Data($foot);
            }
        }

        // Setzt 0% Ust wenn keine weiteren Ust angegeben sind
        if (! $set_ust) {
            $foot[0]['TEXT'] = $default_text['zzgl_0'];
            $foot[1]['TEXT'] = '';
            $foot[2]['TEXT'] = '';
            $foot[3]['TEXT'] = '';
            $foot[4]['TEXT'] = '';
            $foot[5]['TEXT'] = '';
            $foot[6]['TEXT'] = '0,00' . EURO;
            ;
            $foot[6]['T_ALIGN'] = 'R';
            $foot[0]['COLSPAN'] = 6;
            $foot[0]['T_ALIGN'] = 'L';
            $pdf->Draw_Data($foot);
        }

        $foot[0]['TEXT'] = "\n" . $default_text['gesamtbetrag'];
        $foot[1]['TEXT'] = '';
        $foot[2]['TEXT'] = '';
        $foot[3]['TEXT'] = '';
        $foot[4]['TEXT'] = '';
        $foot[5]['TEXT'] = '';
        $foot[6]['T_TYPE'] = 'BU';
        $foot[6]['T_SIZE'] = '10';
        $foot[6]['TEXT'] = "\n" . $rechnung['gesamt_brutto'] . EURO;
        $foot[6]['T_ALIGN'] = 'R';
        $foot[5]['V_ALIGN'] = 'T';
        $foot[0]['COLSPAN'] = 6;
        $foot[0]['T_ALIGN'] = 'R';
        $foot[0]['V_ALIGN'] = 'T';
        $pdf->Draw_Data($foot);
    }
}

// Ausgabe des PDF
$pdf->Draw_Table_Border();
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 4, utf8_decode($anhang['text']), '', '', 0);

// $pdf_output['modus'] = 'F';
// $pdf_output['path'] = "$absolute_path/temp/";

?>