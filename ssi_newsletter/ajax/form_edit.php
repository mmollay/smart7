<?php
include ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_edit','inline' => 'list' );

$arr ['ajax'] = array ('success' => "if ( data != 'ok') { alert( 'Fehler: ' + data ) } else { $('#modal_form, #modal_form_edit, #modal_form_clone, #modal_form_new').modal('hide'); $('.ui.modal>.content').empty(); }",'dataType' => "html" );

switch ($_POST ['list_id']) {

	case 'promotion_list' :

		$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_promotion','inline' => 'list' );

		$onLoad = "
		fu_type($('#type').val());		
		$('#type').bind('keyup change focus',function() {  fu_type($('#type').val()) });
		
		function fu_type(id){
			if (id =='basic')      { $('.amazon').hide(); }
			else if (id =='amazon') { $('.amazon').show(); }
		}	
		
		$('#discount_amount,#basic_offer').keyup ( function () { 
			$('#special_offer').val(parseInt($('#basic_offer').val()) - parseInt($('#discount_amount').val()));
		});
 
		";

		$array_promotype = array ("basic" => "Einfache Couponausgabe","amazon" => "Amazon Promotion" );

		if ($_POST ['update_id']) {
			$arr ['sql'] = array ('query' => "SELECT promotion_id, amazon_product_url, discount_amount,code_formular_threshold,code_start_time, amazon_asin, alert_empty_code,max_codes_per_day, amazon_promotion_id, amazon_matchcode, DATE_FORMAT(date_start,'%Y-%m-%d') date_start, DATE_FORMAT(date_end,'%Y-%m-%d') date_end,
					type, basic_offer,special_offer,`desc`,title
				  FROM promotion where promotion_id = '{$_POST['update_id']}' " );
		} else {
			$set_type = 'basic';
			$alert_empty_code = '0';
		}
		$arr ['field'] ['title'] = array ('tab' => 'text',"label" => "Titel","type" => "input",'focus' => true,'validate' => true );
		$arr ['field'] ['type'] = array ('tab' => 'text',"label" => "Promotiontyp",'value' => $set_type,"type" => "select",'array' => $array_promotype,'validate' => true );
		$arr ['field'] ['amazon_promotion_id'] = array ('tab' => 'text','class' => 'amazon',"label" => "Nachverfolgungsnummer","type" => "input" );
		// $arr['field']['amazon_matchcode'] = array ( 'tab' => 'first' , 'class' => 'amazon', 'type' => 'input' , 'label' => "Nachverfolgungsnummer");
		$arr ['field'] [] = array ("type" => 'div','class' => 'two fields amazon' );
		$arr ['field'] ['date_start'] = array ('tab' => 'first','label' => "Datum (Start)",'type' => 'date','icon' => 'calendar','option' => "data-lock='from'" );
		$arr ['field'] ['date_end'] = array ('tab' => 'first','label' => "Datum (Ende)",'type' => 'date','icon' => 'calendar','option' => "data-lock='from'" );
		$arr ['field'] [] = array ("type" => 'div_close' );

		$arr ['field'] [] = array ("type" => 'div','class' => 'two fields' );
		$arr ['field'] ['amazon_asin'] = array ('label' => "Amazon-ASIN",'type' => 'input','class' => 'amazon','placeholder' => 'B00KKMT3SI' );
		$arr ['field'] ['amazon_product_url'] = array ('label' => "Spezieller Amazon Produktlink",'info' => 'Wenn Du dieses Feld ausfüllst, verwenden wir Deinen individuellen Link (zB. Dein Affiliate Link)im Button auf der Gratulationspage. Von diesem Button kommt der User dann auf das Amazon being. Lasst du das Feld leer so kommt der User einfach auf die Produktseite','type' => 'input','placeholder' => 'https://www.amazon.de/dp/B00KKMT3SI/' );
		$arr ['field'] [] = array ("type" => 'div_close' );

		$arr ['field'] [] = array ("type" => 'div','class' => 'three fields' );
		$arr ['field'] ['basic_offer'] = array ('tab' => 'first','label' => "Stattpreis",'type' => 'input','icon' => 'euro','format' => 'euro' );
		$arr ['field'] ['discount_amount'] = array ('tab' => 'first','label' => "Rabattbetrag",'type' => 'input','icon' => 'euro','format' => 'euro' );
		$arr ['field'] ['special_offer'] = array ('tab' => 'first','label' => "Angebotspreis",'type' => 'input','icon' => 'euro','format' => 'euro','class' => 'disabled' );
		$arr ['field'] [] = array ("type" => 'div_close' );

		$arr ['field'] [] = array ("type" => 'div','class' => 'message ui' );
		$arr ['field'] [] = array ("type" => 'div','class' => 'two fields' );
		$arr ['field'] ['alert_empty_code'] = array ('tab' => 'first','label' => 'Empty-Promo-Code Alert','info' => 'Wenn eine Anzahl der freien Promo-codes unterschritten wird, wird eine Email an den User gesendet. Bei "0" wird kein Alarm ausgelöst','type' => 'input','value' => $alert_empty_code,'validate' => 'number' );
		$arr ['field'] ['max_codes_per_day'] = array ('label' => 'Max Anzahl der Codes pro Tag','type' => 'input','value' => $max_codes_per_day,'validate' => 'number' );
		$arr ['field'] [] = array ("type" => 'div_close' );
		$arr ['field'] [] = array ("type" => 'div','class' => 'two fields' );
		$arr ['field'] ['code_start_time'] = array ('label' => 'Codeausgabe Start-Uhrzeit pro Tag','type' => 'time','placeholder' => '21:00' );
		$arr ['field'] ['code_formular_threshold'] = array ('label' => 'Ausgabe der Info im Formalar verfügbarer Promocodes','type' => 'input','value' => '50','label_right' => '%' );
		$arr ['field'] [] = array ("type" => 'div_close' );

		$arr ['field'] [] = array ("type" => 'div_close' );

		// $arr['field']['codes_distribution_start_time'] = array ( 'tab' => 'first' , 'class' => 'five wide' , 'label' => 'Versendung ab xxx' , 'type' => 'clock' , 'value' => $alert_empty_code , 'validate' => 'number' );

		$arr ['field'] ['desc'] = array ('tab' => 'text',"label" => "Beschreibung","type" => "textarea" );
		$arr ['ajax'] = array ('success' => "
				if (data == 'ok') { $('.modal.ui').modal('hide'); table_reload('promotion_list'); } 
				else if (data == 'exists') { message({'title':'Link', text: 'Dieser Titel Existiert bereits!<br>Bitte anderen Namen wählen', type:'info'}); $('#title').focus(); }
				else  { alert('Fehler'); }	",'dataType' => "html",'onLoad' => $onLoad );

		break;

	case 'code_list' :

		$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_list','inline' => 'list' );

		$onload = "	
		$('#new_promotion').enterKey(function () {
			$('#label_left_new_promotion').click();
		})
		
		$('#label_left_new_promotion').click( function() {
			var value =  $('#new_promotion').val();
			if (value) { $.ajax({ url : 'inc/add_promotion.php', data : ({ value: value }), global: false, type : 'POST', dataType : 'script' }) }
		})
		";

		$array_promotion = call_array_promotion ();

		$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'fields' );
		$arr ['field'] ['promotion_id'] = array ('tab' => 'first','type' => 'dropdown','class' => 'wide eleven search','label' => "Promotion",'array' => $array_promotion,'validate' => true );
		$arr ['field'] ['new_promotion'] = array ('tab' => 'first','type' => 'input','class' => 'wide five','label' => 'Neuen Promotion','label_left' => "<i class='icon arrow left'></i> Anlegen",label_right_click => '' );
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

		// $arr['field']['promotion_id'] = array ( 'tab' => 'first' , 'label' => 'Promotion' , 'type' => 'dropdown' , 'class' => 'search' , 'validate' => true , 'array' => $array_promotion ,'placeholder' => '--Formulare--', 'focus' => true );
		$arr ['field'] ['codes'] = array ('tab' => 'first','type' => 'textarea','rows' => '10','label' => 'Neue Codes eingeben','info' => 'Bitte die einzelnen Codes durch Zeilenumbruch trennen','validate' => true );
		$arr ['ajax'] = array ('onLoad' => $onload,'success' => "if (data == 'ok') { $('.modal.ui').modal('hide'); table_reload('code_list'); table_reload('promotion_list'); } else  { alert('Fehler'); }	",'dataType' => "html" );

		break;

	case 'formulardesign_list' :

		$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'formulardesign','inline' => 'list' );

		// Abrufen der Darstellungsparameter
		if ($_POST ['update_id']) {
			$sql = $GLOBALS ['mysqli']->query ( "SELECT setting_array from formular_design WHERE formdesign_id = '{$_POST['update_id']}'" );
			$array = mysqli_fetch_array ( $sql );
			$gadget_array = $array ['setting_array'];
			$gadget_array_n = explode ( "|", $gadget_array );
			if ($array ['setting_array']) {
				foreach ( $gadget_array_n as $array ) {
					$array2 = preg_split ( "[=]", $array, 2 );
					$GLOBALS [$array2 [0]] = $array2 [1];
				}
			}
		}

		// Formular vom Smartkit wird geladen
		include ('../../ssi_smart/admin/function.inc.php');
		$arr ['sql'] = array ('query' => "SELECT * from formular_design where formdesign_id = '{$_POST['update_id']}'" );
		$arr ['field'] ['matchcode'] = array ('tab' => 'first','type' => 'input','label' => 'Bezeichnung','validate' => true,'focus' => true );
		// holt sich vom ssi_smart die array_parameter zum gestalten der Eingabefelder
		include_once ('../../ssi_smart/admin/ajax/form_gadget.php');
		$arr ['ajax'] = array ('success' => "if (data == 'ok') { $('.ui.modal').modal('hide'); table_reload('formulardesign_list'); } else  { alert('Fehler'); }	",'dataType' => "html",'onLoad' => $onLoad );

		break;

	case 'listbuilding_list' :
		include ('../form/f_listbuilding.php');
		break;

	case 'contact_list' :
		$hide_all_buttons = 1;
		include ('../form/f_contact.php');
		break;

	case 'newsletter_list' :
		$hide_all_buttons = 1;
		include ('../form/f_newsletter.php');
		break;

	case 'verification_list' :
		if (! $_POST ['update_id']) {
			$arr ['field'] ['email'] = array ('label_left' => 'Email zum verifizieren anlegen',"type" => "input",'validate' => true,'focus' => true );
			$arr ['ajax'] = array ('success' => "
				if (data == 'ok') { 
					$('.modal.ui').modal('hide'); 
					table_reload('verification_list'); 
				}
				else if (data == 'exists') { message({'title':'Link', text: 'Diese Email existiert Bereits!', type:'info'}); $('#email').focus(); }
				else  { alert('Fehler'); }	",'dataType' => "html",'onLoad' => $onLoad );
			break;
		} else {
			$query = $GLOBALS ['mysqli']->query ( "SELECT * from verification WHERE verify_id = '{$_POST['update_id']}' " );
			$array = mysqli_fetch_array ( $query );
			$arr ['field'] [] = array ('type' => 'div','class' => 'two fields' );
			$arr ['field'] ['send_code'] = array ('type' => 'content','text' => "<div data-tooltip='Verifizierungscode erneut zusenden' class='button_send_code icon ui button' id='{$_POST['update_id']}'>Code an<i class='icon arrow right'></i>" . $array ['email'] . "</div>" );
			$arr ['field'] ['send_progress'] = array ('type' => 'text' );
			$arr ['field'] [] = array ('type' => 'div_close' );
			$arr ['field'] ['code'] = array ('type' => 'input','label' => 'Verifizierungscode','validate' => 'Verifizierungcode eintragen','focus' => true );
			$arr ['button'] ['submit'] = array ('value' => "<i class='refresh icon'></i>Prüfen",'color' => 'blue' );
			$arr ['ajax'] = array ('success' => "verify_success(data)",'dataType' => "html" );
			$hide_submit_button = true;
			$add_js .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/form_verification.js\"></script>";
			break;
		}
	case 'profile_list' :

		if ($_POST ['update_id']) {
			$arr ['sql'] = array ('query' => "SELECT * from sender where id = '{$_POST['update_id']}'" );
		}
		// $arr['tab'] = array ( 'tabs' => [ "first" => "Allgemein" , "sec" => "SMTP-Server" ] );
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' );
		$arr ['field'] ['from_email'] = array ('tab' => 'first','label' => 'Absender','type' => 'input','info' => 'Email des Absenders','placeholder' => 'info@example.com','validate' => 'email','focus' => true );
		$arr ['field'] ['from_name'] = array ('tab' => 'first','label' => 'Bezeichnung','type' => 'input','info' => 'Bsp.: Max Muster','validate' => true );
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

		$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' );
		$arr ['field'] ['replay_email'] = array ('tab' => 'first','label' => 'Antwort an','type' => 'input','info' => 'Rückantwort','placeholder' => 'info@example.com' );
		$arr ['field'] ['replay_name'] = array ('tab' => 'first','label' => 'Bezeichnung','type' => 'input','info' => 'Bsp.: Max Muster' );
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

		$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' );
		// $arr['field']['error_email'] = array ( 'tab' => 'first' , 'label' => 'Return-Email' , 'type' => 'input' , 'info' => 'Mails welche nicht zugestellt werden können' );
		$arr ['field'] ['test_email'] = array ('tab' => 'first','label' => 'Test-Email','type' => 'input','info' => 'Bevor ein Newsletter versendet wird kann dieser an eine Testmail gesendet werden' );
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

		// $arr['field'][smtp_title] = array ( 'tab' => 'sec' , 'type' => 'header' , 'text' => 'SMTP-Server (Optional)' , 'class' => 'small dividing' , 'info' => 'Wenn Sie über einen eigenen SMTP - Server verfügen, können Sie diesen hier eintragen.' );
		// $arr['field'][] = array ( 'tab' => 'sec' , 'type' => 'div' , 'class' => 'fields' );
		// $arr['field'][smtp_port] = array ( 'tab' => 'sec' , 'label' => 'Port' , 'class' => 'wide four' , 'type' => 'dropdown' , 'array' => array ( 587 => 587 , 465 => 465 , 25 => 25 ) , 'placeholder' => 'Port' );
		// $arr['field'][smtp_server] = array ( 'tab' => 'sec' , 'label' => 'Server' , 'type' => 'input' , 'class' => 'wide twelve' );

		// $arr['field'][] = array ( 'tab' => 'sec' , 'type' => 'div_close' );
		// $arr['field'][] = array ( 'tab' => 'sec' , 'type' => 'div' , 'class' => 'fields' );
		// $arr['field'][smtp_user] = array ( 'tab' => 'sec' , 'class' => 'wide six' , 'label' => 'User' , 'type' => 'input' );
		// $arr['field'][smtp_password] = array ( 'tab' => 'sec' , 'class' => 'wide six' , 'label' => 'Passwort' , 'type' => 'password' );
		// $arr['field'][smtp_secure] = array ( 'tab' => 'sec' , 'class' => 'wide four' , 'label' => 'Secure' , 'type' => 'dropdown' , 'array' => array ( '' => 'keine' , 'tls' => 'tls' , 'ssl' => 'ssl' ) );
		// $arr['field'][] = array ( 'tab' => 'sec' , 'type' => 'div_close' );
		// $arr['field'][] = array ( 'tab' => 'sec' , 'label' => true , 'type' => 'content' , 'text' => "<div class='button ui icon' id=check_smtp><div id='show_smtp_ok'>Überprüfen</div></div>" );
		$arr ['ajax'] = array ('success' => "if ( data == 'ok') { $('.modal.ui').modal('hide'); table_reload(); check_alert(); }",'dataType' => "html" );
		$add_js = "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/form_profile.js\"></script>";
		break;

	// Link bearbeiten
	case 'link_list' :
		$arr ['sql'] = array ('query' => "SELECT * from link where link_id = '{$_POST['update_id']}'" );

		$mysql_link_query = $GLOBALS ['mysqli']->query ( "SELECT * FROM link2tag a inner JOIN tag b ON a.tag_id = b.tag_id where link_id = '{$_POST['update_id']}' " );
		while ( $array = mysqli_fetch_array ( $mysql_link_query ) ) {
			$tag_array [] = $array ['tag_id'];
		}

		$arr ['field'] ['link'] = array ('type' => 'input','label' => 'Link','validate' => 'url','focus' => true );
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'fields' );
		$arr ['field'] ['tags'] = array ('tab' => 'first','type' => 'multiselect','label' => "Tags",'array' => $array_value_tag,'class' => 'eleven wide search','value' => $tag_array,'validate' => true );
		$arr ['field'] ['new_tag'] = array ('tab' => 'first','type' => 'input','label' => 'Neuen Tag','class' => 'five wide','label_left' => "<i class='icon arrow left'></i> Anlegen",label_right_click => '' );
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

		$arr ['ajax'] = array ('onLoad' => "call_add_tag('tag_id'); ",'success' => "
				if (data == 'ok') { $('.modal.ui').modal('hide'); table_reload(); message({ title: 'Link', text:'Erfolgreich bearbeitet!', type:'success'}); } 
				else if (data == 'exist') { message({'title':'Link', text: 'Existiert bereits!<br>Bitte anderen Namen wählen', type:'error'}); $('#link').focus(); }",'dataType' => "html" );
		break;

	case 'tag_list' :
		if ($_POST ['update_id']) {
			$arr ['sql'] = array ('query' => "SELECT * from tag where tag_id = '{$_POST['update_id']}'" );
			$mysql_tag_query = $GLOBALS ['mysqli']->query ( "SELECT * FROM tag2tag where tag_id = '{$_POST['update_id']}' " );
			while ( $array = mysqli_fetch_array ( $mysql_tag_query ) ) {
				$to_tag_id = $array ['to_tag_id'];
				$mode = $array ['mode'];

				$tag_array [$mode] [] = $to_tag_id;
			}
		}

		$arr ['ajax'] = array ('success' => "
				if (data == 'ok') { $('.modal.ui').modal('hide'); table_reload(); new PNotify({ title: 'Tag erfolgreich bearbeitet', delay: 3000, type:'success'}); }
				else if (data == 'exist') { new PNotify({ title: 'Dieser Tag existiert bereits', type:'error', delay: 3000}); $('#title').focus(); }	",'dataType' => "html" );

		// $arr['tab'] = array ( 'tabs' => [ "first" => "Allgemein" , "alert" => "Alarm" ] , 'active' =>'' );
		$arr ['field'] [] = array ('type' => 'div','class' => 'two fields' );
		$arr ['field'] ['title'] = array ('tab' => 'first','type' => 'input','label' => '"Tag"-Name','validate' => true,'focus' => true );
		$arr ['field'] ['description'] = array ('tab' => 'first','type' => 'input','label' => 'Beschreibung','info' => 'Interen Beschreibung für besseres Verständnis' );
		$arr ['field'] [] = array ('type' => 'div_close' );
		$arr ['field'] ['tag_add'] = array ('tab' => 'first','type' => 'multiselect','label' => "Automatische Tag-Zuweisung",'array' => $array_value_tag,'class' => 'search','value' => $tag_array ['add'] );
		$arr ['field'] ['tag_remove'] = array ('tab' => 'first','type' => 'multiselect','label' => "Automatische Tag-Entzug",'array' => $array_value_tag,'class' => 'search','value' => $tag_array ['remove'] );

		// $arr['field']['alert_test'] = array ( 'tab' => 'first' , 'type' => 'slider' , min=>'0', max=>'100', 'label' => 'Bei Neueintrag informieren', unit=>'Einträge', 'value'=>'33');
		// $arr['field']['alert'] = array ( 'tab' => 'alert' , 'type' => 'toggle' , 'label' => 'Bei Neueintrag informieren');
		// $arr['field']['alert_email'] = array ( 'tab' => 'alert' , 'type' => 'dropdown' , 'label' => 'An' , 'array' => $from_array , 'validate' => true , 'placeholder' => '--Absender wählen--' );
		break;

	case 'black_list' :
		if ($_POST ['update_id']) {
			$arr ['sql'] = array ('query' => "SELECT * from blacklist where black_id = '{$_POST['update_id']}'" );
		}
		$arr ['ajax'] = array ('success' => "after_submit( data )",'dataType' => "html" );
		$arr ['field'] [] = array ('tab' => 'first','id' => 'email','type' => 'input','label' => 'Email','validate' => 'email','focus' => true );
		$arr ['field'] [] = array ('tab' => 'sec','id' => 'comment','type' => 'input','label' => 'Kommentar' );
		$add_js = "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/form_black.js\"></script>";
		break;
}
// $arr['hidden']['update_id'] = $_POST['update_id'];
$arr ['hidden'] ['list_id'] = $_POST ['list_id'];

//Bei contat und newsleeter, wird über das MODAL in der List aufgerufen
if (! $hide_all_buttons) {
	if (! $hide_submit_button)
		$arr ['button'] ['submit'] = array ('value' => "<i class='save icon'></i>Speichern",'color' => 'blue' );
	$arr ['button'] ['close'] = array ('value' => 'Abbrechen','color' => 'gray','js' => "$('.modal.ui').modal('hide'); " );
}

$output = call_form ( $arr ); 
echo $output ['html'];
echo $output ['js'];
echo $add_js;