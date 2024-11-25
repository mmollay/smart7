<?php

require_once ('../mysql.inc');
ini_set('display_errors', 0);

error_reporting(E_ALL ^ E_NOTICE);
// Zugangsdaten fuer die Datenbank
foreach ($_POST as $key => $value) {
	$GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string($value);
}


switch ($_POST['list_id']) {

	case 'promotion_list':

		// Prüft ob Wert bereits in DB eingetragen wurde //gibt exists zurück
		check_exists("SELECT title FROM promotion WHERE title='$title' AND user_id = '{$_SESSION['user_id']}' AND promotion_id != '$update_id'");

		$basic_offer = preg_replace("/,/", ".", $basic_offer);
		$special_offer = preg_replace("/,/", ".", $special_offer);

		$sql = "REPLACE INTO promotion SET
		promotion_id = '$update_id',
		amazon_promotion_id = '$amazon_promotion_id',
		amazon_matchcode = '$amazon_matchcode',
		type = '$type',
		user_id = '{$_SESSION['user_id']}',
		title = '$title',
		date_start = '$date_start',
		date_end = '$date_end',
		basic_offer = '$basic_offer',
		special_offer = '$special_offer',
		discount_amount = '$discount_amount',
		code_formular_threshold = '$code_formular_threshold',
		amazon_asin = '$amazon_asin',
		amazon_product_url = '$amazon_product_url',
		code_start_time = '$code_start_time',
		alert_empty_code = '$alert_empty_code',
		max_codes_per_day = '$max_codes_per_day',
		codes_distribution_start_time = '$codes_distribution_start_time',
		`desc` = '$desc'";

		$GLOBALS['mysqli']->query($sql) or die (mysqli_error($GLOBALS['mysqli']));
		echo "ok";
		break;

	case 'code_list':

		// Prüfen ob form_id existiert
		if ($promotion_id) {
			$check_query = $GLOBALS['mysqli']->query("SELECT promotion_id from promotion WHERE promotion_id = '$promotion_id' AND user_id = '{$_SESSION['user_id']}' ") or die (mysqli_error($GLOBALS['mysqli']));
			$correct_input = mysqli_num_rows($check_query);
		}

		if ($correct_input) {

			$array_code = explode("\n", $_POST[codes]);

			foreach ($array_code as $code) {

				$code = trim($code);
				if ($code) {
					$code = $GLOBALS['mysqli']->real_escape_string($code);
					$GLOBALS['mysqli']->query("INSERT INTO code SET promotion_id = '$promotion_id', code='$code' "); // or die ( mysqli_error ($GLOBALS['mysqli']) );
				}
			}
			echo "ok";
		}
		break;

	case 'formulardesign_list':
		// Initialisiere ein Array mit den Feldnamen
		$fields = [
			'show_label',
			'label_text',
			'label_span',
			'label_color',
			'label_class',
			'labelIcon',
			'label_link',
			'label_size',
			'icon',
			'show_intro',
			'show_firstname',
			'format',
			'show_secondname',
			'show_title',
			'link_reg_success',
			'link_reg',
			'button_inline',
			'button_color',
			'button_text',
			'infotext',
			'segment',
			'segment_color',
			'segment_inverted',
			'segment_disabled',
			'segment_grade',
			'segment_or_message',
			'segment_size',
			'segment_width',
			'segment_type',
			'segment_compact'
		];

		$setting_array = [];

		// Durchlaufe das Array und überprüfe die POST-Daten
		foreach ($fields as $key) {
			if (isset ($_POST[$key]) && !empty ($_POST[$key])) {
				$value = $GLOBALS['mysqli']->real_escape_string($_POST[$key]);
				$setting_array[] = $key . "=" . $value;
			}
		}

		// Konvertiere das Array zu einem String
		$setting_string = implode("|", $setting_array);

		// Verwende ein Prepared Statement zum Einfügen/Ersetzen der Daten
		$stmt = $GLOBALS['mysqli']->prepare("REPLACE INTO formular_design (formdesign_id, user_id, comp_id, camp_key, matchcode, setting_array) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssss', $update_id, $_SESSION['user_id'], $_SESSION['comp_id'], $camp_key, $matchcode, $setting_string);
		$stmt->execute() or die (mysqli_error($GLOBALS['mysqli']));

		echo "ok";
		break;


	case 'listbuilding_list':

		$fields = "
		matchcode = '$matchcode',
		description = '$description',
		emailtitle_reg = '$emailtitle_reg',
		emailtext_reg = '$emailtext_reg',
		emailtitle_reg_success = '$emailtitle_reg_success',
		emailtext_reg_success = '$emailtext_reg_success',
		promotion_id = '$promotion_id',
		from_id = '$from_id',
		link_reg = '$link_reg',
		text_reg = '$text_reg',
		text_reg_success = '$text_reg_success',
		link_reg_success = '$link_reg_success',
		followup_mail_id = '$followup_mail_id',
		text_user_exists_inactive = '$text_user_exists_inactive',
		text_user_exists_active = '$text_user_exists_active',
		text_user_exists_set_inactive = '$text_user_exists_set_inactive',
		text_promotion_codes_used_up = '$text_promotion_codes_used_up',
		alert = '$alert',
		alert_email = '$alert_email',
		add_contact_faktura = '$add_contact_faktura'
		";

		// löscht campagen ohne user_id
		$GLOBALS['mysqli']->query("DELETE FROM formular WHERE !user_id ");

		if ($update_id) {
			$GLOBALS['mysqli']->query("UPDATE formular SET $fields WHERE form_id = '$update_id'") or die (mysqli_error($GLOBALS['mysqli']));
			$form_id = $update_id;
		} else {
			$camp_key = md5(uniqid(rand(), TRUE));
			$GLOBALS['mysqli']->query("INSERT INTO formular SET camp_key = '$camp_key', user_id = '{$_SESSION['user_id']}', $fields ") or die (mysqli_error($GLOBALS['mysqli']));
			$form_id = mysqli_insert_id($GLOBALS['mysqli']);
		}

		if ($tags) {
			$GLOBALS['mysqli']->query("DELETE from formular2tag WHERE form_id = '$form_id' ") or die (mysqli_error($GLOBALS['mysqli']));
			$tag_array = explode(',', $tags);
			foreach ($tag_array as $value) {
				$GLOBALS['mysqli']->query("REPLACE INTO formular2tag SET form_id = '$form_id', tag_id = '$value' ") or die (mysqli_error($GLOBALS['mysqli']));
			}
		}
		echo "ok";
		break;

	case 'verification_list':

		if (!$update_id && !$code) {
			// Prüfen ob Email bereits eingetragen wurde
			$check = $GLOBALS['mysqli']->query("SELECT * FROM verification WHERE email = '$email' AND user_id = '{$_SESSION['user_id']}' ") or die (mysqli_error($GLOBALS['mysqli']));
			if (!mysqli_num_rows($check)) {
				// Anlegen einer neuen Email
				$verify_key = md5(uniqid(rand(), TRUE));
				$GLOBALS['mysqli']->query("INSERT INTO verification SET email = '$email', verify_key ='$verify_key', user_id = '{$_SESSION['user_id']}' ") or die (mysqli_error($GLOBALS['mysqli']));
				$_POST['id'] = mysqli_insert_id($GLOBALS['mysqli']);

				// Bestätigungsmail schicken
				include ('../exec/send_verification.php');
			} else {
				echo "exists";
			}
		} else {
			// Email verifizieren
			if ($_POST['code']) {
				$code = $GLOBALS['mysqli']->real_escape_string($_POST['code']);
				echo $code;
				$query = $GLOBALS['mysqli']->query("Select * from verification where verify_key = '$code' ") or die (mysqli_error($GLOBALS['mysqli']));
				$result = mysqli_num_rows($query);
			}
			if ($result == true) {
				$GLOBALS['mysqli']->query("UPDATE verification SET checked = 1, check_date = now() WHERE verify_key = '$code' ") or die (mysqli_error($GLOBALS['mysqli']));
				echo "ok";
			} else {
				echo "error";
			}
		}

		break;

	case 'profile_list':
		$id = $GLOBALS['mysqli']->real_escape_string($_POST['update_id']);

		if (!$id)
			$id = 0;

		$smtp_port = $smtp_port ?? 0;

		$sql = "REPLACE INTO sender SET
		id           = $id,
		user_id      = '{$_SESSION['user_id']}',
		from_name    = '$from_name',
		from_email   = '$from_email',
		replay_email = '$replay_email',
		replay_name = '$replay_name',
		test_email   = '$test_email',
		smtp_server  = '$smtp_server',
		smtp_user    = '$smtp_user',
		smtp_password= '$smtp_password',
		smtp_port    = $smtp_port,
		smtp_secure  = '$smtp_secure'
		";

		// Speichern der Daten in der Datenbank
		$GLOBALS['mysqli']->query($sql) or die (mysqli_error($GLOBALS['mysqli']));
		echo "ok";
		break;

	case 'link_list':

		// Check link exists
		$query = $GLOBALS['mysqli']->query("SELECT * from link WHERE link = '$link' AND link_id != '$update_id' AND user_id = '{$_SESSION['user_id']}'  ") or die (mysqli_error($GLOBALS['mysqli']));
		if (mysqli_num_rows($query)) {
			echo "exist";
			break;
		}

		if (!$update_id) {
			$token = md5(uniqid(rand(), TRUE));
			$GLOBALS['mysqli']->query("INSERT INTO link SET
				user_id      = '{$_SESSION['user_id']}',
				link = '$link',
				token = '$token'
				") or die (mysqli_error($GLOBALS['mysqli']));
			$link_id = mysqli_insert_id($GLOBALS['mysqli']);
		} else {
			$GLOBALS['mysqli']->query("UPDATE link SET link = '$link' WHERE link_id = '$update_id' ") or die (mysqli_error($GLOBALS['mysqli']));
			$link_id = $update_id;
		}

		if ($tags) {
			$GLOBALS['mysqli']->query("DELETE from link2tag WHERE link_id = '$link_id' ") or die (mysqli_error($GLOBALS['mysqli']));
			$tag_array = explode(',', $tags);
			foreach ($tag_array as $tag_id) {
				if ($link) {
					$GLOBALS['mysqli']->query("INSERT INTO link2tag SET tag_id ='$tag_id',`link_id` ='$link_id' ") or die (mysqli_error($GLOBALS['mysqli']));
				}
			}
		}

		echo "ok";
		break;

	/**
	 * *******************************************************************************
	 * GROUP - FORM 2
	 * *******************************************************************************
	 */
	case 'tag_list':
		// $title = $GLOBALS['mysqli']->real_escape_string ( $_POST['title'] );
		// $label_id = $GLOBALS['mysqli']->real_escape_string ( $_POST['label_id'] );

		// Check link exists
		$query = $GLOBALS['mysqli']->query("SELECT * from tag WHERE title = '$title' AND tag_id != '$update_id' AND user_id = '{$_SESSION['user_id']}'  ") or die (mysqli_error($GLOBALS['mysqli']));
		if (mysqli_num_rows($query)) {
			echo "exist";
			break;
		}

		$alert = $alert ?? 0;
		$alert_email = $alert_email ?? 0;
		if ($_POST['update_id']) {

			$GLOBALS['mysqli']->query("UPDATE tag SET 
			title = '$title', 
			description = '$description',
			alert = $alert,
			alert_email = $alert_email   
				WHERE tag_id = '{$_POST['update_id']}' and user_id = '{$_SESSION['user_id']}' ") or die (mysqli_error($GLOBALS['mysqli']));
			echo "ok";
			$tag_id = $_POST['update_id'];
		} else {
			// Check ob Name bereits vorhanden sind
			$query = $GLOBALS['mysqli']->query("SELECT * FROM tag WHERE title = '$title' AND user_id = '{$_SESSION['user_id']}' ");
			$check = mysqli_num_rows($query);
			if ($check) {
				echo "exist";
				break;
			} else {

				$sql = "INSERT INTO tag SET 
					title = '$title', 
					description = '$description',  
					user_id = {$_SESSION['user_id']},
					alert = $alert,
					alert_email = $alert_email,
					session_id = 0,
					event = 0
				";

				$GLOBALS['mysqli']->query($sql) or die (mysqli_error($GLOBALS['mysqli']));
				echo "ok";
				$tag_id = mysqli_insert_id($GLOBALS['mysqli']);
			}
		}

		// Eintragung der Tags zu "add" and "remove" zu anderene Tags
		if ($tag_id) {
			$GLOBALS['mysqli']->query("DELETE from tag2tag WHERE tag_id = '$tag_id' ") or die (mysqli_error($GLOBALS['mysqli']));

			$tag_add_array = explode(',', $tag_add);
			$tag_remove_array = explode(',', $tag_remove);

			foreach ($tag_add_array as $value_add) {
				$GLOBALS['mysqli']->query("REPLACE INTO tag2tag SET tag_id = '$tag_id', mode='add', to_tag_id = '$value_add' ") or die (mysqli_error($GLOBALS['mysqli']));
			}
			foreach ($tag_remove_array as $value_rem) {
				$GLOBALS['mysqli']->query("REPLACE INTO tag2tag SET tag_id = '$tag_id', mode='remove', to_tag_id = '$value_rem' ") or die (mysqli_error($GLOBALS['mysqli']));
			}
		}

		break;

	/**
	 * *******************************************************************************
	 * BLACKLIST - FORM 2
	 * *******************************************************************************
	 */
	case 'black_list':
		// Check ob Datenbanksatz bereits existiert
		$exist_query_email = $GLOBALS['mysqli']->query("SELECT * from blacklist WHERE user_id = '{$_SESSION['user_id']}' and email = '{$_POST['email']}'") or die (mysqli_error($GLOBALS['mysqli']));
		$exist_array = mysqli_fetch_array($exist_query_email);
		$check_contact_id = $exist_array['black_id'];

		if ($check_contact_id and !$_POST['update_id']) {
			echo "email_exists";
		} else {
			// bestehenden User aus der Datenbank 'contact' entfernen sowie alle Verknüpfungen zu den Gruppen
			// Löscht den bestehenden User(Email) aus der Datenbank
			$query = $GLOBALS['mysqli']->query("SELECT contact_id from contact where email = '{$_POST['email']}' AND user_id = '{$_SESSION['user_id']}' ");
			while ($array = mysqli_fetch_array($query)) {
				$contact_id = $array[0];
				$GLOBALS['mysqli']->query("DELETE FROM contact2tag WHERE contact_id = $contact_id  ") or die (mysqli_error($GLOBALS['mysqli']));
				$GLOBALS['mysqli']->query("DELETE FROM contact WHERE contact_id = $contact_id") or die (mysqli_error($GLOBALS['mysqli']));
			}

			if ($_POST['update_id']) {
				$GLOBALS['mysqli']->query("UPDATE blacklist SET
				email     = '{$_POST['email']}',
				comment = '{$_POST['comment']}'
				WHERE black_id = '{$_POST['update_id']}'
				") or die (mysqli_error($GLOBALS['mysqli']));
			} else {
				// Speichern der Daten in der Datenbank
				$GLOBALS['mysqli']->query("INSERT INTO blacklist SET
				user_id   = '{$_SESSION['user_id']}',
				email     = '{$_POST['email']}',
				comment = '{$_POST['comment']}'
				") or die (mysqli_error($GLOBALS['mysqli']));
			}
		}
		break;

	/**
	 * *******************************************************************************
	 * CONTACT - FORM 2
	 * *******************************************************************************
	 */
	case 'contact_list':

		if (empty ($_POST['email'])) {
			// Geeignete Rückmeldung geben oder Logik für leere E-Mail-Adresse
			return;
		}

		$_POST['contact_id'] = $_POST['update_id'];

		// Datenbankverbindung vorbereiten (angenommen, $mysqli ist die Datenbankverbindung)
		$mysqli = $GLOBALS['mysqli'];

		// Prüfung, ob der Kontakt bereits existiert
		$stmt = $mysqli->prepare("SELECT COUNT(*) FROM contact WHERE user_id = ? AND email = ?");
		$stmt->bind_param('is', $_SESSION['user_id'], $_POST['email']);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();

		if ($count > 0) {
			// Logik, falls der Kontakt existiert
			// Zum Beispiel eine Nachricht ausgeben oder die Ausführung unter bestimmten Bedingungen stoppen
		}

		// Prüfung, ob die E-Mail in der Blacklist ist
		$stmt = $mysqli->prepare("SELECT COUNT(*) FROM blacklist WHERE user_id = ? AND email = ?");
		$stmt->bind_param('is', $_SESSION['user_id'], $_POST['email']);
		$stmt->execute();
		$stmt->bind_result($blacklistCount);
		$stmt->fetch();
		$stmt->close();

		if ($blacklistCount > 0) {
			echo "blacklist";
			return;
		}

		if ($check_contact_id and $update)
			$_POST['contact_id'] = $check_contact_id;

		if ($check_contact_id and !$_POST['contact_id']) {
			$msg = "email_exists";
			$exist_user++;
		} else {

			// Vorbereitung der $_POST-Werte

			$_POST['birth'] = '0000-00-00';
			$_POST['zip'] = $_POST['zip'] ?? 0;
			$_POST['client_number'] = $_POST['client_number'] ?? 0;
			$_POST['city'] = $_POST['city'] ?? '';
			$_POST['web'] = $_POST['web'] ?? '';

			if (isset ($_POST['contact_id']) && $_POST['contact_id'] > 0) {

				// Update
				$stmt = $GLOBALS['mysqli']->prepare("REPLACE INTO contact (contact_id, user_id, email, firstname, secondname, sex, title, birth, activate, company_1, company_2, street, zip, city, country, telefon, commend, commend2, placeholder1, placeholder2, placeholder3, client_number, reg_date, return_error, reg_ip, reg_domain, web) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 0, '', '', ?)");

				// Bind parameters
				$stmt->bind_param('iissssssssssissssssssis', $_POST['contact_id'], $_SESSION['user_id'], $_POST['email'], $_POST['firstname'], $_POST['secondname'], $_POST['sex'], $_POST['title'], $_POST['birth'], $_POST['activate'], $_POST['company_1'], $_POST['company_2'], $_POST['street'], $_POST['zip'], $_POST['city'], $_POST['country'], $_POST['telefon'], $_POST['commend'], $_POST['commend2'], $_POST['placeholder1'], $_POST['placeholder2'], $_POST['placeholder3'], $_POST['client_number'], $_POST['web']);

				$stmt->execute();
				$contact_id = $_POST['contact_id'];
				$stmt->close();
			} else {
				// Insert
				$stmt = $GLOBALS['mysqli']->prepare("INSERT INTO contact (user_id, email, firstname, secondname, sex, title, birth, activate, company_1, company_2, street, zip, city, country, telefon, commend, commend2, placeholder1, placeholder2, placeholder3, client_number, reg_date, return_error, reg_ip, reg_domain, web) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 0, '', '', ?)");

				// Bind parameters
				$stmt->bind_param('issssssssssissssssssis', $_SESSION['user_id'], $_POST['email'], $_POST['firstname'], $_POST['secondname'], $_POST['sex'], $_POST['title'], $_POST['birth'], $_POST['activate'], $_POST['company_1'], $_POST['company_2'], $_POST['street'], $_POST['zip'], $_POST['city'], $_POST['country'], $_POST['telefon'], $_POST['commend'], $_POST['commend2'], $_POST['placeholder1'], $_POST['placeholder2'], $_POST['placeholder3'], $_POST['client_number'], $_POST['web']);

				$stmt->execute();

				$contact_id = $mysqli->insert_id;

				$stmt->close();
			}

			if (!$import_contact)
				// Grupppen verknuepfen
				$GLOBALS['mysqli']->query("DELETE FROM contact2tag where contact_id = '$contact_id' ") or die (mysqli_error($GLOBALS['mysqli']));

			$array_tags = explode(',', $_POST['tags']);

			if (is_array($array_tags)) {
				foreach ($array_tags as $tag_value) {

					// Gruppen neu setzen
					if ($tag_value and $contact_id) {
						$sql = "REPLACE INTO contact2tag (`tag_id`, `contact_id`, `activate`, `verify_key`,`set_listbuilding`) VALUES ('$tag_value','$contact_id','1','','0')";

						$GLOBALS['mysqli']->query($sql) or die (mysqli_error($GLOBALS['mysqli']));
					}
				}
			}

			// Groupsetting - Activate or deactite next generation
			$query = $GLOBALS['mysqli']->query("SELECT * FROM tag LEFT JOIN contact2tag ON tag.tag_id = contact2tag.tag_id WHERE contact2tag.contact_id = '{$_POST['update_id']}' ") or die (mysqli_error($GLOBALS['mysqli']));
			while ($array = mysqli_fetch_array($query)) {
				$tag_id = $array['tag_id'];
				$GLOBALS['mysqli']->query("UPDATE contact2tag SET `activate`='{$_POST["tag$tag_id"]}' WHERE tag_id = $tag_id ") or die (mysqli_error($GLOBALS['mysqli']));
				// Wenn Tag inaktiv gesetzt wird, wird newsletter in der Pipline, das noch nicht versendet wurde, entfernt
				if (!$_POST["tag$tag_id"])
					$GLOBALS['mysqli']->query("DELETE FROM logfile WHERE client_id = '{$_POST['update_id']}' AND sendet=0 ");
			}

			// Zuweisung der User zu der jeweilign Followup-Mail falls vorhanden
			generate_new_session($_POST['update_id'], $cfg);

			if ($_POST['contact_id']) {
				$msg = 'ok';
				$updated_user++;
			} else {
				$msg = 'ok new';
				$new_user++;
			}
		}
		// Anzeigen der Info wenn von Kontaktseite aus verändert wird
		if (!$import_contact)
			echo $msg;
		break;
}
