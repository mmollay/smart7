<?php
include_once (__DIR__ . '/../../login/config_main.inc.php');
include (__DIR__ . '/../../ssi_smart/admin/function_generate_element_template.php');

// Variablen auslesen
foreach ( $_POST as $key => $value ) {
	if ($value) {
		$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string ( $value );
	}
}

// funnel-page wird erzeugt
exec ( "mkdir ../{$_SESSION['path_page_absolute']}/funnel" );

// $listbuilding_number = sprintf ( "%'.03d", 2 ); // '001'; //w

$array_funnel['lp']['url'] = "$funnel_lp";
$array_funnel['ff']['url'] = "$funnel_ff";
$array_funnel['gr']['url'] = "$funnel_gr";

$array_funnel['lp']['title'] = "$funnel_lp";
$array_funnel['ff']['title'] = "$funnel_ff";
$array_funnel['gr']['title'] = "$funnel_gr";

/**
 * ********
 * Step 1
 * Funnel/site anlegen für die Struktur anlegen falls noch nocht vorhanden
 * *******
 */
$funnel_site_id = mysql_singleoutput ( "SELECT site_id FROM smart_langSite INNER JOIN smart_id_site2id_page ON fk_id = site_id WHERE site_url = 'funnel' AND page_id   = '$page_id' LIMIT 1 " );
if (! $funnel_site_id) {
	$array['site_title'] = 'Funnel';
	$array['site_url'] = 'funnel';
	$array['page_id'] = $page_id;
	$array['funnel_id'] = $update_id;
	$array['funnel_short'] = 1;
	$funnel_site_id = generate_site4funnel ( $array );
}

/**
 * ********
 * Step 2
 * Funnel-Short anlegen (funnel/kopfkissen/
 * ********
 */
$url_name = strtolower ( seo_permalink ( $funnel_short ) );
$funnelshort_site_id = mysql_singleoutput ( "SELECT * from smart_langSite t1 LEFT JOIN smart_id_site2id_page t2 ON t2.site_id = t1.fk_id  WHERE site_url = '$url_name' AND page_id = '$page_id' LIMIT 1 " );

if (! $funnelshort_site_id) {
	$array['site_title'] = $funnel_short;
	$array['site_url'] = $url_name;
	$array['page_id'] = $page_id;
	$array['parent_id'] = $funnel_site_id;
	$array['funnel_id'] = $update_id;
	$array['funnel_short'] = 1;
	$funnelshort_site_id = generate_site4funnel ( $array );
}
/**
 * ********
 * Step 3
 * Landingpage und CO anlegen (funnel/kopfkissen/lp001)
 * ********
 */
foreach ( $array_funnel as $key => $value ) {
	// Case-Auswahl für das speichern der neuen SEITEN
	$array['site_title'] = $value['title'];
	$array['site_url'] = $value['url'];
	$array['parent_id'] = $funnelshort_site_id;
	$array['page_id'] = $page_id;
	$array['funnel_id'] = $update_id;
	$array['funnel_short'] = 0;
	$site_id = generate_site4funnel ( $array );
	$generate_array = '';
	
	if ($key == 'lp') {
		
		// Promotionparameter abrufen
		$query_promotion = $GLOBALS['mysqli']->query ( "SELECT * FROM {$cfg_mysql['db_nl']}.promotion a LEFT JOIN {$cfg_mysql['db_nl']}.formular b ON a.promotion_id = b.promotion_id WHERE b.form_id = '$update_id' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
		$array_promotion = mysqli_fetch_array ( $query_promotion );
		
		// Parameter für die Kampagne
		$camp_key = $array_promotion[camp_key];
		
		setlocale ( LC_MONETARY, 'de_DE' );
		
		$basic_offer = $array_promotion[basic_offer];
		$discount_amount = $array_promotion[discount_amount];
		$special_offer = $basic_offer - $discount_amount;
		
		$basic_offer = number_format ( $basic_offer, 2, ",", "." );
		$special_offer = number_format ( $special_offer, 2, ",", "." );
		$amazon_asin = $array_promotion[amazon_asin];
		
		$statt_heute_nur = "
		<h2><span style='color:#ff0000'>Statt </span><del>$basic_offer  €</del>
		<span style='color:#008000'> heute nur $special_offer € </span></h2>
		<p><strong>Warum geben wir einen so&nbsp;gro&szlig;en Rabatt?</strong><br>
		Ganz einfach:&nbsp;Wir suchen Tester, welche uns Feedback&nbsp;zu unserem Produkt geben.</p>";
		
		$gutschein_sichern_text = "<h2>Jetzt Gutschein sichern!</h2>
		<p style='text-align:center'>Gib hier deinen Vornamen und deine Emailadresse an und wir senden dir deinen<strong> pers&ouml;nlichen 10&euro; Amazon Rabattgutschein</strong>.<br />
		<br />
		<span style='color:#c0392b'><strong>Es sind nur noch&nbsp; {%codes_available%} von {%codes_per_day%}&nbsp; verf&uuml;gbar</strong></span></p>";
		
		$daten_schutz = "Wir werden deine Daten sicher an niemanden weitergeben!";
		
		// Landingpage
		$generate_array['amazon'] = array ( 'position' => 'left' , 'gadget' => 'amazon' , 'gadget_array' => "amazon_asin=$amazon_asin" );
		
		$generate_array['splitter1'] = array ( 'gadget' => 'splitter' , 'gadget_array' => 'column_relation=8' , 'position' => 'left' );
		
		// Text vor dem Newsletter
		$generate_array['statt_heute_nur'] = array ( 'splitter_layer_id' => 'splitter1' , 'position' => 'right' , 'gadget' => 'textfield' );
		
		// Eingeabefeld für NEWSLETTER
		$generate_array['splitter_newsletter'] = array ( 'splitter_layer_id' => 'splitter1' , 'gadget' => 'splitter' , 'gadget_array' => 'column_relation=1|cell_design=empty|segment=1|segment_grade=secondary|' , 'position' => 'right' );
		$generate_array['gutschein_sichern_text'] = array ( 'splitter_layer_id' => 'splitter_newsletter' , 'position' => 'left' , 'gadget' => 'textfield' );
		$generate_array["newsletter_formular"] = array ( 'splitter_layer_id' => 'splitter_newsletter' , 'position' => 'left' , 'gadget' => 'newsletter' , 'gadget_array' => "camp_key=$camp_key|show_firstname=1|button_text=RABATTCODE EINLÖSEN|button_color=orange|" );
		$generate_array['daten_schutz'] = array ( 'splitter_layer_id' => 'splitter_newsletter' , 'position' => 'left' , 'gadget' => 'textfield' );
	} elseif ($key == 'ff') {
		// Fast Fertig Page
		$generate_array['text_title'] = array ( 'position' => 'left' , 'gadget' => 'textfield' , 'text' => '<h1 style="text-align:center">Danke f&uuml;r deine Anmeldung!</h1><h3 style="text-align:center">Es sind noch folgende Schritte n&ouml;tig, um deinen Gutschein-Code zu bekommen...</h3>' );
		
		$generate_array['splitter2'] = array ( 'position' => 'left' , 'gadget' => 'splitter' , 'gadget_array' => 'column_relation=333|cell_design=empty|relaxed_off=1|' );
		
		$text_col1 = '<h2 style="text-align:center"><strong>Schritt 1</strong><br />Logge dich bei deinen Emails ein</h2>
		<p style="text-align:center">Gehe bitte zum <strong>Posteingang</strong> deiner Emailadresse, die du soeben angegeben hast</p>';
		
		$text_col2 = '<h2 style="text-align:center"><strong>Schritt 2</strong><br />Finde die Email von uns im Posteingang</h2>
		<p style="text-align:center">&Ouml;ffne die Email mit dem Betreff &ldquo;<strong>Fast Fertig</strong>! Anmeldebest&auml;tigung&hellip;&rdquo;&nbsp;von mir&nbsp;<strong>Wolfgang Fuchs (Lotuscrafts)</strong></p>';
		
		$text_col3 = '<h2 style="text-align:center"><strong>Schritt 3</strong><br />Klicke den Best&auml;tigungslink</h2>
		<div style="text-align:center">Klicke auf den Best&auml;tigungslink innerhalb der Email &nbsp;&ldquo;<strong>Emailadresse best&auml;tigen</strong>&rdquo;</div>';
		
		$generate_array['col1_awesome'] = array ( 'position' => 'left' , 'gadget' => 'awesome' , 'splitter_layer_id' => 'splitter2' , 'gadget_array' => 'icon=mail outline|color=orange|size=huge|' );
		$generate_array['col1_text'] = array ( 'position' => 'left' , 'gadget' => 'textfield' , 'splitter_layer_id' => 'splitter2' , 'text' => $text_col1 );
		
		$generate_array['col2_awesome'] = array ( 'position' => 'middle' , 'gadget' => 'awesome' , 'splitter_layer_id' => 'splitter2' , 'gadget_array' => 'icon=search|color=green|size=huge|' );
		$generate_array['col2_text'] = array ( 'position' => 'middle' , 'gadget' => 'textfield' , 'splitter_layer_id' => 'splitter2' , 'text' => $text_col2 );
		
		$generate_array['col3_awesome'] = array ( 'position' => 'right' , 'gadget' => 'awesome' , 'splitter_layer_id' => 'splitter2' , 'gadget_array' => 'icon=hand pointer|color=blue|size=huge|' );
		$generate_array['col3_text'] = array ( 'position' => 'right' , 'gadget' => 'textfield' , 'splitter_layer_id' => 'splitter2' , 'text' => $text_col3 );
		
		$generate_array['text_footer'] = array ( 'position' => 'left' , 'gadget' => 'textfield' , 'text' => '<h2 style="text-align:center">Best&auml;tige deine Emailadresse jetzt damit wir dir deinen Gutschein-Code umgehend senden k&ouml;nnen!</h2>' );
	} elseif ($key == 'gr') {
		
		// Geschafft Seite
		$gr_text = '<h1 style="text-align:center"><br />
		<span style="color:#ffffff"><strong>DEIN PERS&Ouml;NLICHER GUTSCHEIN</strong></span></h1>
		<h1 style="text-align:center"><strong>Statt <s>29,95&euro;</s> heute nur <span style="color:#27ae60">19,95&euro;</span> </strong></h1>
		<div style="text-align:center">&nbsp;</div>
		<h3 style="text-align:center">Dein pers&ouml;nlicher Gutscheincode lautet:</h3>
		<h2 style="text-align:center"><span style="color:#000000"><strong><span style="background-color:#ffffff">&nbsp;TPLV-WG7VRH-U97SB5&nbsp; </span></strong></span></h2>
		';
		
		$generate_array['splitter3'] = array ( 'position' => 'left' , 'gadget' => 'splitter' , 'gadget_array' => 'column_relation=1|parallax_show=1|parallax_filter=1|relaxed_off=1|cell_design=internally celled|segment_or_message=segment|parallax_color=#fafafa|parallax_mode=1|' );
		$generate_array['gr_text'] = array ( 'position' => 'left' , 'gadget' => 'textfield' , 'splitter_layer_id' => 'splitter3' , 'text' => $gr_text );
		$generate_array['gr_button'] = array ( 'position' => 'left' , 'gadget' => 'button' , 'splitter_layer_id' => 'splitter3' , 'title' => 'Jetzt auf Amazon einlösen' , 'color' => 'orange' , 'gadget_array' => 'no_fluid=1|button_size=massive|' );
		
		// 4 Col - Ablauf
		$generate_array['splitter4'] = array ( 'position' => 'left' , 'gadget' => 'splitter' , 'gadget_array' => 'column_relation=444|cell_design=empty|relaxed_off=1|' );
		
		$splitter_text_col1 = '<h2>Schritt 1<br />Gutschein-Code kopieren</h2><p>Markiere den Gutscheincode und klicke dann mit der rechten Maustaste und dann &ldquo;kopieren&rdquo; (Alternativ: Strg-C).</p>';
		$splitter_text_col2 = '<h2><strong>Schritt 2</strong><br />Auf den Amazon-Button klicken</h2><p>Klicke auf den Button <em>&ldquo;Jetzt auf Amazon.de einl&ouml;sen!&rdquo;</em> um auf die Website von Amazon.de zu gelangen</p>';
		$splitter_text_col3 = '<h2><strong>Schritt 3</strong><br />Zum Warenkorb hinzuf&uuml;gen und zur Kasse gehen</h2><p>Auf der Amazon Produktseite angelangt klicke rechts auf den Button <em>&ldquo;In den Einkaufswagen&rdquo;</em> um den Artikel zum Einkaufswagen hinzuzuf&uuml;gen. Danach klicke auf <em>&ldquo;Zur Kasse gehen&rdquo;</em>.</p>';
		$splitter_text_col4 = '<h2><strong>Schritt 4</strong><br />Gutscheincode bei der Kasse eingeben</h2><p>Im Schritt 2 &ldquo;W&auml;hlen Sie eine Zahlungsart aus&rdquo; und <em>&ldquo;Geschenkkarten-, Gutschein- oder Aktionscode eingeben&rdquo;</em>&nbsp;anklicken. Dort f&uuml;ge bitte den Gutschein-Code mit <em>Rechter Maustaste &gt; &ldquo;einf&uuml;gen&rdquo;</em> <em> (Alternativ: Strg-V).</em>ein. Klicke danach auf den Button <em>&ldquo;Einl&ouml;sen&rdquo;</em> und fahre mit dem Kauf fort.</p>';
		
		$generate_array['splitter_4_col1_awesome'] = array ( 'position' => 'left' , 'gadget' => 'awesome' , 'splitter_layer_id' => 'splitter4' , 'gadget_array' => 'icon=copy' );
		$generate_array['splitter_4_col1_text'] = array ( 'position' => 'left' , 'gadget' => 'textfield' , 'splitter_layer_id' => 'splitter4' , 'text' => $splitter_text_col1 );
		
		$generate_array['splitter_4_col2_awesome'] = array ( 'position' => 'middle' , 'gadget' => 'awesome' , 'splitter_layer_id' => 'splitter4' , 'gadget_array' => 'icon=copy' );
		$generate_array['splitter_4_col2_text'] = array ( 'position' => 'middle' , 'gadget' => 'textfield' , 'splitter_layer_id' => 'splitter4' , 'text' => $splitter_text_col2 );
		
		$generate_array['splitter_4_col3_awesome'] = array ( 'position' => 'right' , 'gadget' => 'awesome' , 'splitter_layer_id' => 'splitter4' , 'gadget_array' => 'icon=copy' );
		$generate_array['splitter_4_col3_text'] = array ( 'position' => 'right' , 'gadget' => 'textfield' , 'splitter_layer_id' => 'splitter4' , 'text' => $splitter_text_col3 );
		
		$generate_array['splitter_4_col4_awesome'] = array ( 'position' => 'four' , 'gadget' => 'awesome' , 'splitter_layer_id' => 'splitter4' , 'gadget_array' => 'icon=copy' );
		$generate_array['splitter_4_col4_text'] = array ( 'position' => 'four' , 'gadget' => 'textfield' , 'splitter_layer_id' => 'splitter4' , 'text' => $splitter_text_col4 );
	}
	generate_element_template ( $site_id, $generate_array );
}

echo "ok";
