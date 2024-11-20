<?php
/**
 * 2021-02-17 mm@ssi.at
 * Funktion für Newsletterversandsystem
 *
 * save_data_landingpage($newsletter_id, $text, $http_host) ...Speichert die Links in die Datenbank und überschreibt den Link
 *
 * email_split($str)....................................löst Emailliste auf "Martin Mollay <martin@ssi.at>;...."
 * call_menu_structure($array_menu).....................Ruft die Menüstruktur auf und gibt diese als Array wieder -> setMenu und setContent
 *
 * set_new_tag_from_session($session_id, $event).......Erzeugt neuen Tag und weißt contact dem tag zu
 *
 * call_array_start_followup_pool() ...................Ausgabe aller Start-sequenzen von allen Pools [followup_id][matchcode]
 * call_array_followup_pool() .........................Ausgabe aller POOLS [pool_id][matchcode]
 * call_array_followup($pool_id, $update_id = false) ..Ausgabe Steps eines bestimmten Pools [followup_id][mathcode]
 * call_array_followup_mail($pool_id, $update_id = false)..Ausgabe aller Mails aus einem Pool bei (update_id werden Mails aus followup ausgeschlossen -> verhindert ein sich selbst aufrufen
 * call_array_followup_step ($pool_id, $update_id )....Ausgabe aller Steps
 * call_array_listbuilding()...........................Ausgabe aller Listbuildings
 * call_array_tags()...................................Ausgabe aller Tags[tag_id][matchcode]
 * call_array_event()..................................Ausgabe aller Events [event_id][matchcode]
 * call_array_sender().................................Ausgabe aller Absender [sender_id][matchcode]
 * call_array_promotion()..............................Ausgabe aller Promotion-Gruppen [promotion_id][matchode]
 *
 * call_data_user($contact_id).........................Auslesen der Werte aus DB des jeweiligen Kontaktes
 *
 * call_placeholder($show_promotioncode, $textfield_id).. Buttonleiste, Platzhalter für Formulare
 * check_email($email) .................................. Validitätsprüfung von Emails
 * dirsize($dir) ........................................ Speicherverbrauch in Ordner
 * convert($size) ....................................... Konvertiert byte in Einheiten kb,Mb,
 * user_space($paket, $user_paket, $upload_folder)....... Zeigt Speicherv Verbrauch von User an (je nach Paket)
 */
include_once(__DIR__ . "/lang/de.php");
include_once(__DIR__ . "/functions_followup.php");

// Speichert die Links in die Datenbank und überschreibt den Link
function save_data_landingpage($newsletter_id, $text, $http_host)
{

	// Wenn Script von der Shell ausgeführt wird, verwendet er standartmässig den Hauptserver
	if ($http_host)
		$_SERVER['HTTP_HOST'] = $http_host;
	else
		$_SERVER['HTTP_HOST'] = "center.ssi.at";

	preg_match_all('/<a href="(.*?)"/s', $text, $matches);
	// print_r($matches[1]);
	$GLOBALS['mysqli']->query("DELETE FROM landingpage WHERE session_id = '$newsletter_id' ") or die(mysqli_error($GLOBALS['mysqli']));
	foreach ($matches[1] as $link) {
		// Schlüssel erzeugen
		$key = md5(uniqid(rand(), TRUE));
		// Eintragen in die Datenbank - Doppeleinträge werden nicht zugelassen
		$GLOBALS['mysqli']->query("
		INSERT INTO landingpage (session_id,link,`key`) SELECT '$newsletter_id','$link','$key'
		FROM DUAL WHERE NOT EXISTS (SELECT * FROM landingpage WHERE link = '$link' AND session_id = '$newsletter_id') ") or die(mysqli_error($GLOBALS['mysqli']));
	}
	// Umwandlen der Links für Lnadingpage
	$query = $GLOBALS['mysqli']->query("SELECT * FROM landingpage WHERE session_id = '$newsletter_id' ");
	while ($array = mysqli_fetch_array($query)) {
		$link = $array['link'];
		$key = $array['key'];
		$text = preg_replace("[href=\"$link\"]", "href=\"http://" . $_SERVER["HTTP_HOST"] . "/pages/lp.php?key=" . $key . "&c={%verify_key%}\"", $text); // contact_key -> platzhalter
	}
	return $text;
}

// Auslesen des Matchcodes der Company für den Pfad attachment -> nl
function call_company_matchcode($user_id, $cfg)
{
	$query = mysqli_query($cfg, "SELECT matchcode FROM ssi_company.tbl_company a LEFT JOIN ssi_company.user2company b ON a.company_id = b.company_id WHERE b.user_id = '$user_id' ") or die(mysqli_error($GLOBALS['mysqli']));
	$fetch = mysqli_fetch_array($query);
	return $fetch['matchcode'];
}

// löst Emailliste auf "Martin Mollay <martin@ssi.at>;...."
function email_split($str)
{
	$parts = explode(' ', trim($str));
	$email = trim(array_pop($parts), "<> \t\n\r\0\x0B");
	$name = ucwords(strtolower(trim(implode(' ', $parts), "\"\' \t\n\r\0\x0B")));
	$name = preg_replace("/,/", "", $name);
	if ($name == "" && strpos($email, "@") === false) { // only single string - did not contain '@'
		$name = $email;
		$email = "";
	}
	return array('name' => $name, 'email' => $email);
}

// Neuen Tag erstellen und die Session_ID + Event dem contact2tag zuweisen
function set_new_tag_from_session($session_id, $event)
{


	// Session-title abrufen
	$query = $GLOBALS['mysqli']->query("SELECT title FROM session WHERE session_id = '$session_id' ");
	$array = mysqli_fetch_array($query);
	$title = $array['title'];
	// Erzeugen eines neuen Tags und Userzuweisen

	// Prüfen ob tag bereits existiert
	$query = $GLOBALS['mysqli']->query("SELECT * FROM tag WHERE session_id = '$session_id' AND event = '$event'  ");
	$array = mysqli_fetch_array($query);
	$tag_id = $array['tag_id'];
	$GLOBALS['mysqli']->query("DELETE FROM contact2tag WHERE tag_id = '$tag_id' ");
	// Wenn Tag nicht exisitiert dann neuen Tag anlegen
	if (!$tag_id) {
		// Tag anlegen
		$GLOBALS['mysqli']->query("INSERT INTO tag SET title = '$title', description = '',  user_id = '{$_SESSION['user_id']}', session_id = '$session_id' , event = '$event', alert=0, alert_email=0 ") or die(mysqli_error($GLOBALS['mysqli']));
		$tag_id = mysqli_insert_id($GLOBALS['mysqli']);
	}

	// Contact den Tag zuweisen
	$query = $GLOBALS['mysqli']->query("SELECT * FROM logfile WHERE session_id = '$session_id' and status = '$event' ");
	while ($array = mysqli_fetch_array($query)) {
		$contact_id = $array['client_id'];

		$GLOBALS['mysqli']->query("REPLACE INTO contact2tag SET tag_id = '$tag_id', contact_id = '$contact_id', activate = 1, verify_key='', set_listbuilding = 0 ") or die(msysql_error());
	}
	echo $tag_id;
	return $tag_id;
}

// Einstiegsseiten von den Pools ausgeben
function call_array_start_followup_pool()
{

	// Pool für filter in array ausgeben
	$query = $GLOBALS['mysqli']->query("SELECT 
			b.followup_id followup_id, b.matchcode matchcode, a.matchcode pool_matchcode 
			FROM followup_pool a LEFT JOIN followup b ON a.start_followup_id = b.followup_id 
			WHERE a.user_id = '{$_SESSION['user_id']}' ") or die(mysqli_error($GLOBALS['mysqli']));
	while ($array = mysqli_fetch_array($query)) {
		$count = $array['count'];
		$pool_matchcode = $array['pool_matchcode'];
		$matchcode = $array['matchcode'];
		$array_pool[$array['followup_id']] = "$pool_matchcode <i class='icon arrow right'></i>$matchcode";
	}
	return $array_pool;
}

// Pools ausgeben
function call_array_followup_pool()
{

	// Pool für filter in array ausgeben
	$query = $GLOBALS['mysqli']->query("
			SELECT a.pool_id pool_id, a.matchcode matchcode, COUNT(b.pool_id) count 
			FROM followup_pool a LEFT JOIN followup b ON a.pool_id = b.pool_id 
			WHERE a.user_id = '{$_SESSION['user_id']}'
			GROUP by pool_id
	") or die(mysqli_error($GLOBALS['mysqli']));
	while ($array = mysqli_fetch_array($query)) {
		if ($array['pool_id']) {
			$count = $array['count'];
			$array_pool[$array['pool_id']] = $array['matchcode'] . " (Steps: $count)";
		}
	}
	return $array_pool;
}

// Auslesen der Followup_Sequenz
function call_array_followup($pool_id, $update_id = false)
{

	// Optionen für Select abrufen
	$query = $GLOBALS['mysqli']->query("SELECT * from followup where user_id = '{$_SESSION['user_id']}' and followup_id != '$update_id' AND pool_id = '$pool_id' ") or die(mysqli_error($GLOBALS['mysqli']));
	while ($fetch = mysqli_fetch_array($query)) {
		$matchcode = $fetch['matchcode'];
		$mail_id = $fetch['followup_id'];
		$array[$mail_id] = "$matchcode";
	}
	return $array;
}

// Auslesen der Followup_Mail
function call_array_followup_mail($pool_id, $update_id = false)
{

	// Optionen für Select abrufen
	$query = $GLOBALS['mysqli']->query("SELECT a.mail_id mail_id, a.matchcode matchcode from followup_mail a   
			INNER JOIN f_mail2followup b ON a.mail_id = b.mail_id
			INNER JOIN followup c ON c.followup_id = b.followup_id
			where c.user_id = '{$_SESSION['user_id']}' AND pool_id = '$pool_id' AND from_id ") or die(mysqli_error($GLOBALS['mysqli']));
	while ($fetch = mysqli_fetch_array($query)) {
		$matchcode = $fetch['matchcode'];
		$mail_id = $fetch['mail_id'];
		$array[$mail_id] = "$matchcode";
	}
	return $array;
}

// Auslesen der Followup_Steps
function call_array_followup_step($pool_id, $update_id = false)
{

	// Optionen für Select abrufen
	$query = $GLOBALS['mysqli']->query("SELECT  followup_id, matchcode matchcode from followup 
			where user_id = '{$_SESSION['user_id']}' AND pool_id = '$pool_id' AND followup_id != '$update_id' ") or die(mysqli_error($GLOBALS['mysqli']));
	while ($fetch = mysqli_fetch_array($query)) {
		$matchcode = $fetch['matchcode'];
		$followup_id = $fetch['followup_id'];
		$array[$followup_id] = "$matchcode";
	}
	return $array;
}

// Auslesen der Followup_Sequenz
function call_array_listbuilding()
{

	// Listbuildings abrufen
	$query = $GLOBALS['mysqli']->query("SELECT * from formular where user_id = '{$_SESSION['user_id']}' ") or die(mysqli_error($GLOBALS['mysqli']));
	while ($fetch = mysqli_fetch_array($query)) {
		$matchcode = $fetch['matchcode'];
		$mail_id = $fetch['form_id'];
		$array[$mail_id] = "$matchcode";
	}
	return $array;
}

// Ruft alle User von DB einer bestimmten Session ab und übergibt sie einem ARRAY
function call_array_contact($session_id = false)
{
	$user_id = $_SESSION['user_id'];

	if ($session_id)
		$sql = "SELECT * FROM contact a LEFT JOIN logfile b ON a.contact_id = b.client_id WHERE session_id = '$session_id' ";
	else
		$sql = "SELECT * FROM contact WHERE user_id = '$user_id' ";

	$query = $GLOBALS['mysqli']->query($sql);
	while ($array1 = mysqli_fetch_array($query)) {
		$array_select[] = $array1['contact_id'];
		if ($array1['firstname'] && $array1['secondname'])
			$array[$array1['contact_id']] = $array1['firstname'] . " " . $array1['contact_id'] . $array1['secondname'] . " (" . $array1['email'] . ")";
		elseif ($array1['email'])
			$array[$array1['contact_id']] = $array1['email'];
	}

	if ($session_id) {
		return $array_select;
	} else {
		return $array;
	}
}

// Aufruf aller TAGS
function call_array_tags($show_active = FALSE, $with_session_id_tags = FALSE)
{
	global $str_text;

	$tag_array = array();

	if (!$with_session_id_tags)
		$add_mysql = "AND session_id = 0";
	$mysql_query = $GLOBALS['mysqli']->query("
			SELECT tag.tag_id tag_id, session_id, tag.title, tag.event event, COUNT(IF(contact.activate = 1,1,null)) counter, COUNT(IF(contact.activate = 0,1,null)) counter_inactive
			FROM ssi_newsletter2.tag
			LEFT JOIN (ssi_newsletter2.contact2tag, ssi_newsletter2.contact) ON (contact.contact_id = contact2tag.contact_id AND contact2tag.tag_id = tag.tag_id)
			WHERE tag.user_id = '{$_SESSION['user_id']}' $add_mysql
			GROUP BY tag.tag_id
			ORDER BY session_id, tag.title") or die(mysqli_error($GLOBALS['mysqli']));

	while ($mysql_fetch = mysqli_fetch_array($mysql_query)) {
		$event = $mysql_fetch['event'];
		$tag_id = $mysql_fetch['tag_id'];
		$tag_name = $mysql_fetch['title'];

		if ($mysql_fetch['session_id'] and !$set_session_tagtitle) {
			$tag_array['title_sessiontag'] = "Tags von Versendungen";
			$set_session_tagtitle = true;
		}

		if ($event)
			$tag_name .= "&nbsp; <i class='icon angle double right'></i>" . $str_text['nl']['event'][$event];
		$tag_counter_user = $mysql_fetch['counter'];
		$tag_counter_user_inactive = $mysql_fetch['counter_inactive'];
		if ($tag_counter_user or $show_active == false) {
			$tag_array[$tag_id] = "$tag_name (User: $tag_counter_user)";
		}
	}

	return $tag_array;
}

// Aufruf aller Events
function call_array_event()
{
	$mysql_query = $GLOBALS['mysqli']->query("
			SELECT event_id, title
			FROM event
			WHERE user_id = '{$_SESSION['user_id']}'
			ORDER BY title") or die(mysqli_error($GLOBALS['mysqli']));

	while ($mysql_fetch = mysqli_fetch_array($mysql_query)) {
		$event_id = $mysql_fetch['event_id'];
		$name = $mysql_fetch['title'];
		$array[$event_id] = "$name";
	}
	return $array;
}

// Auslesen aller Absender
function call_array_sender()
{

	// Optionen für Select abrufe
	$query = $GLOBALS['mysqli']->query("SELECT * from sender where user_id = '{$_SESSION['user_id']}' ") or die(mysqli_error($GLOBALS['mysqli']));
	while ($aFormValues = mysqli_fetch_array($query)) {
		$from_id = $aFormValues['id'];
		$smtp_server = $aFormValues['smtp_server'];
		$from_name = $aFormValues['from_name'];
		$from_email = $aFormValues['from_email'];
		if ($smtp_server)
			$smtp_server = "=> $smtp_server";
		$from_array[$from_id] = "$from_name ($from_email) $smtp_server";
	}
	return $from_array;
}

// Auslesen der Promotions-Gruppen
function call_array_promotion()
{
	$mysql_query = $GLOBALS['mysqli']->query("SELECT promotion.promotion_id promotion_id, title, COUNT(code.promotion_id) count FROM promotion LEFT JOIN code ON code.promotion_id = promotion.promotion_id  WHERE user_id = '{$_SESSION['user_id']}' GROUP by promotion.promotion_id ORDER BY title") or die(mysqli_error($GLOBALS['mysqli']));
	while ($mysql_fetch = mysqli_fetch_array($mysql_query)) {
		$promotion_id = $mysql_fetch['promotion_id'];
		$count = $mysql_fetch['count'];
		$title = $mysql_fetch['title'];
		$array_promotion[$promotion_id] = "$title ($count)";
	}
	return $array_promotion;
}
function call_array_promotion2()
{
	$mysql_query = $GLOBALS['mysqli']->query("SELECT promotion.amazon_promotion_id amazon_promotion_id, title, COUNT(code.promotion_id) count FROM promotion LEFT JOIN code ON code.promotion_id = promotion.promotion_id  WHERE user_id = '{$_SESSION['user_id']}' GROUP by promotion.promotion_id ORDER BY title") or die(mysqli_error($GLOBALS['mysqli']));
	while ($mysql_fetch = mysqli_fetch_array($mysql_query)) {
		$promotion_id = $mysql_fetch['amazon_promotion_id'];
		$count = $mysql_fetch['count'];
		$title = $mysql_fetch['title'];
		$array_promotion[$promotion_id] = "$title ($count)";
	}
	return $array_promotion;
}

// Buttonleiste, Platzhalter für Formulare
function call_placeholder($show_promotioncode, $textfield_id)
{
	$buttons_placeholder .= '<span style="float:right; position:relative; left:3px; padding-bottom:5px;">';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'intro_personal\') title="Bsp.: Lieber / Liebe / Liebe Firma">Anrede (Du)</a>';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'intro_formal\') title="Bsp.: Sehr geehrte Frau / Sehr geehrter Herr / Sehr geehrte Firma">Anrede (Sie)</a>';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'firstname\') >Vorname</a>';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'secondname\') >Nachname</a>';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'title\') >Titel</a>';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'client_number\') >Kundennummer</a>';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'placeholder1\') >Platzhalte 1</a>';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'placeholder2\') >Platzhalte 2</a>';
	$buttons_placeholder .= '<a class="button compact ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'placeholder3\') >Platzhalte 3</a>';
	// $buttons_placeholder .= '<a class="button ui mini tooltip" onclick=set_placeholder(\''.$textfield_id.'\',\'birth\') >Geb. Datum</a>';
	if ($show_promotioncode)
		$buttons_placeholder .= '<a class="button ui mini tooltip" onclick=set_placeholder(\'' . $textfield_id . '\',\'promotion_code\') >Promo-Code</a>';
	$buttons_placeholder .= '</span>';
	$buttons_placeholder .= "<div style='clear:both'></div>";
	return $buttons_placeholder;
}

// Mail auf valitiät prüfen
function check_email($email)
{
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return false; // invalid emailaddress
	} else
		return true; // right adress
}

// Ausgabe Speicherverbrauch im Ordner
function dirsize($dir)
{
	if (!is_dir($dir))
		return FALSE;
	$size = 0;
	$dh = opendir($dir);
	while (($entry = readdir($dh)) !== false) {
		if ($entry == "." || $entry == "..")
			continue;
		if (is_dir($dir . "/" . $entry))
			$size += dirsize($dir . "/" . $entry);
		else
			$size += filesize($dir . "/" . $entry);
	}
	closedir($dh);
	return $size;
}

// Read and Convert Space
function convert($size)
{
	$units = array('B', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
	$i = 0;

	// Stelle sicher, dass $size immer einen Wert hat
	if ($size === null) {
		return '0 ' . $units[0];
	}

	while ($size >= 1024) {
		$size /= 1024;
		$i++;
	}
	return round($size, 2) . ' ' . $units[$i];
}

// Zeigt Speicherberbrauch von User an
function user_space($paket, $user_paket, $upload_folder)
{

	// Read Emails per month
	$query = $GLOBALS['mysqli']->query("
 	SELECT SUM(traffic) traffic, COUNT(id) count from session INNER JOIN logfile 
 		ON session.session_id = logfile.session_id 
 		WHERE user_id = '{$_SESSION['user_id']}' 
 		AND sendet = 1
 		AND MONTH(timestamp)  = month(now()) 
 		AND YEAR(timestamp)   = year(now())
 		") or die(mysqli_error($GLOBALS['mysqli']));

	$array = mysqli_fetch_array($query);
	// Traffic per Month
	$str_used_traffic = convert($array['traffic']);

	// Freier Traffic pro Monat
	$str_free_traffic = convert($paket[$user_paket]['traffic']);

	// verbrauchte Emails pro Monat
	$str_used_emails = $array['count'];

	// Verfügbare Email pro Monat
	// $str_free_email = number_format($paket[$user_paket]['email'],'','','.');
	$str_free_email = $paket[$user_paket]['email'];

	// $str_used_emails = 20000;
	if ($str_used_emails >= $str_free_email)
		$str_free_email = $str_used_emails;

	// Verbrauchter Webspace
	$str_used_space = convert(dirSize($upload_folder));

	// Gesamtverfügbarer Webspace
	$str_space = convert($paket[$user_paket]['space']);

	$mail_percent = round((100 / $str_free_email) * $str_used_emails);

	if ($mail_percent <= 40)
		$set_color = 'green';
	elseif ($mail_percent <= 60)
		$set_color = 'yellow';
	elseif ($mail_percent < 100)
		$set_color = 'orange';
	elseif ($mail_percent == 100) {
		$set_color = 'error';
		$text = "Limit von $str_used_emails erreicht";
	}

	$text = "$str_used_emails von " . number_format_short($str_free_email) . "<i class='icon mail outline'></i></i>";

	$output = "<div class='ui fluid label basic tooltip' title='$str_used_emails von $str_free_email Mails verbraucht'>
					<div class='ui tiny indicating progress $set_color' id='progress_space' data-value='$str_used_emails' data-total='$str_free_email'>
						<div class='bar'></div>
						<div class='label' style='font-size:10px;'>$text</div>
					</div>
				</div>";
	return $output;
}

// Converts a number into a short version, eg: 1000 -> 1k
// Based on: http://stackoverflow.com/a/4371114
function number_format_short($n, $precision = 1)
{
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}
	// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
	// Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ($precision > 0) {
		$dotzero = '.' . str_repeat('0', $precision);
		$n_format = str_replace($dotzero, '', $n_format);
	}
	return $n_format . $suffix;
}

// Auslesen der Werte aus der Datenbank des jeweiligen Kontaktes
function call_data_user($contact_id)
{
	// Initialisiere das Array, das die Daten speichern wird
	$send_array = array();

	// Verwende Prepared Statements, um SQL-Injection zu verhindern
	$stmt = $GLOBALS['mysqli']->prepare("SELECT * FROM contact WHERE contact_id = ? LIMIT 1");
	if (!$stmt) {
		die('Prepare failed: ' . mysqli_error($GLOBALS['mysqli']));
	}

	// Bindet die Parameter an das Prepared Statement
	$stmt->bind_param('i', $contact_id);

	// Führe die Abfrage aus
	if (!$stmt->execute()) {
		die('Execute failed: ' . mysqli_error($GLOBALS['mysqli']));
	}

	// Hole das Ergebnis der Abfrage
	$result = $stmt->get_result();
	if ($array = $result->fetch_assoc()) {
		// Fülle das send_array mit den Daten aus der Datenbank
		$send_array = array(
			'email' => $array['email'],
			'firstname' => $array['firstname'],
			'secondname' => $array['secondname'],
			'title' => $array['title'],
			'verify_key' => $array['verify_key'],
			'sex' => $array['sex'],
			'company_1' => $array['company_1'],
			'company_2' => $array['company_2'],
			'street' => $array['street'],
			'city' => $array['city'],
			'zip' => $array['zip'],
			'country' => $array['country'],
			'birth' => $array['birth'],
			'client_number' => $array['client_number'],
			'placeholder1' => $array['placeholder1'],
			'placeholder2' => $array['placeholder2'],
			'placeholder3' => $array['placeholder3'],
			'without_footline' => $array['without_footline']
		);
	}

	// Schließe das Prepared Statement
	$stmt->close();

	// Gebe das gefüllte Array zurück, oder ein leeres Array, falls keine Daten gefunden wurden
	return $send_array;
}
