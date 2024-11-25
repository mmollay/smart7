<?php
$arr['form'] = array('action' => "ajax/form_edit2.php", 'id' => 'listbuilding', 'inline' => 'list');

$array_promotion = call_array_promotion();

$mysql_tag_query = $GLOBALS['mysqli']->query("SELECT * FROM formular2tag a INNER JOIN tag b ON a.tag_id = b.tag_id where form_id = '{$_POST['update_id']}' ");
while ($array = mysqli_fetch_array($mysql_tag_query)) {
	$formular_tag_array[] = $array['tag_id'];
}

if ($_POST['update_id']) {
	$text_reg = '';
	$text_reg_success = '';
	$emailtitle_reg = '';
	$emailtext_reg = '';
	$emailtitle_reg_success = '';
	$emailtext_reg_success = '';
	$text_user_exists_inactive = '';
	$text_user_exists_active = '';
	$text_user_exists_set_inactive = '';
	$text_promotion_codes_used_up = '';
	$arr['sql'] = array('query' => "SELECT * from formular where form_id = '{$_POST['update_id']}'");
}

// Einstellungen laden
$query = $GLOBALS['mysqli']->query("SELECT * from sender where user_id = '{$_SESSION['user_id']}' ") or die (mysqli_error($GLOBALS['mysqli']));
while ($aFormValues = mysqli_fetch_array($query)) {
	$from_id = $aFormValues['id'];
	$smtp_server = $aFormValues['smtp_server'];
	$from_name = $aFormValues['from_name'];
	$from_email = $aFormValues['from_email'];
	if ($smtp_server)
		$smtp_server = "=> $smtp_server";
	$from_array[$from_id] = "$from_name ($from_email) $smtp_server";
}

$arr['ajax'] = array('onLoad' => "call_add_tag('tags');", 'success' => "if ( data == 'ok') { $('.ui.modal').modal('hide'); table_reload('listbuilding_list'); }", 'dataType' => "html");
$arr['tab'] = array(
	'class' => "pointing secondary",
	'content_class' => "basic",
	'tabs' => ["first" => "<i class='setting outline icon'></i> Allgemein", "text" => "<i class='file text outline icon'></i> Textbausteine", "email-text" => "<i class='mail outline icon'></i> Email-Texte", "code" => "Code", "alert" => "<i class='bell outline icon'></i> Alert"],
	'active' => ''
);

$arr['field']['alert'] = array('tab' => 'alert', 'type' => 'toggle', 'label' => 'Bei Neueintrag informieren');
$arr['field']['alert_email'] = array('tab' => 'alert', 'type' => 'dropdown', 'label' => 'Info schicken an', 'array' => $array_alert_mail, 'placeholder' => '--Absender wählen--', 'info' => 'Wenn eine andere Email verwendet werden soll, bitte diese unter "Verifizierung" anlegen und bestätigen.');

$arr['field'][] = array('tab' => 'first', 'type' => 'div', 'class' => 'ui message');
$arr['field']['matchcode'] = array('tab' => 'first', 'type' => 'input', 'label' => 'Bezeichnung', 'validate' => true, 'focus' => true);

$arr['field']['from_id'] = array('tab' => 'first', 'type' => 'dropdown', 'label' => 'Von', 'array' => $from_array, 'validate' => 'Bitte Absender auswählen', 'placeholder' => '--Absender wählen--');

// $arr['field']['tag_id'] = array ( 'tab' => 'first' , 'label' => 'Tags zuweisen' , 'type' => 'multiselect' , 'class' => 'search' ,  'validate' => true , 'array' => $array_value_tag , 'emptyfield' => '--Tag w&auml;hlen--' , 'value' => $formular_tag_array );

$arr['field'][] = array('tab' => 'first', 'type' => 'div', 'class' => 'fields');
$arr['field']['tags'] = array('tab' => 'first', 'type' => 'multiselect', 'class' => 'wide eleven search', 'label' => "Tags zuweisen", 'array' => $array_value_tag, 'validate' => true, 'value' => $formular_tag_array);
$arr['field']['tags_add'] = array('tab' => 'first', 'type' => 'input', 'label' => 'Neuen Tag', 'class' => 'five wide', 'label_left' => "<i class='icon arrow left'></i> Anlegen", 'label_left_class' => 'button orange ui');

$arr['field'][] = array('tab' => 'first', 'type' => 'div_close');

if ($array_promotion)
	$arr['field']['promotion_id'] = array('tab' => 'first', 'type' => 'dropdown', 'label' => "Promotion-Code einbinden", 'array' => $array_promotion, 'class' => 'search', 'placeholder' => '--Promotion wählen--', 'clear' => true);

$arr['field']['description'] = array('tab' => 'first', 'type' => 'textarea', 'rows' => '3', 'label' => 'Beschreibung');

//add checkbox for listbuilding for faktura
if ($_SESSION['set_module']['faktura'])
	$arr['field']['add_contact_faktura'] = array('tab' => 'first', 'type' => 'checkbox', 'label' => 'Kontakt in Faktura einbinden');

$arr['field'][] = array('tab' => 'first', 'type' => 'div_close');

// $arr['field'][] = array ( 'tab' => 'text' , 'type' => 'content' , 'class' => 'label ui basic fluid' , 'text' => 'Mögliche Platzhalter: {%firstname%},{%secondname%},{%email%},{%promotion_code%}' );
$arr['field'][] = array('tab' => 'text', 'type' => 'div', 'class' => 'ui message');
$arr['field'][] = array('tab' => 'text', 'type' => 'header', 'class' => '', "text" => "<div class='ui green mini label'>1</div> Fast-Fertig Seite", 'info' => 'Text absenden, Aufforderung zur Bestätigung der Anmeldung');
$arr['field']['text_reg'] = array('type' => 'ckeditor', 'toolbar' => 'mini', 'tab' => 'text', 'value' => $text_reg);
$arr['field'][] = array('tab' => 'text', 'type' => 'content', 'text' => call_placeholder('', 'text_reg'));
$arr['field']['link_reg'] = array('tab' => 'text', 'label' => '<div class="label ui green mini ">ODER</div> diese Seite wird nach erfolgreicher Anmeldung aufgerufen', 'placeholder' => 'http://', 'type' => 'input', 'value' => $link_reg);
$arr['field'][] = array('tab' => 'text', 'type' => 'div_close');

$arr['field'][] = array('tab' => 'text', 'type' => 'div', 'class' => 'ui message');
$arr['field'][] = array('tab' => 'text', 'type' => 'header', 'class' => '', "text" => "<div class='ui green mini label'>2</div> Dankes Seite", 'info' => 'Text nach bestätigen der Anmeldung');
$arr['field']['text_reg_success'] = array('type' => 'ckeditor', 'toolbar' => 'mini', 'tab' => 'text', 'value' => $text_reg_success);
$arr['field'][] = array('tab' => 'text', 'type' => 'content', 'text' => call_placeholder($array_promotion, 'text_reg_success'));
$arr['field']['link_reg_success'] = array('tab' => 'text', 'label' => '<div class="label ui green mini ">ODER</div> diese Seite wird nach erfolgreicher Anmeldung aufgerufen', 'placeholder' => 'http://', 'type' => 'input', 'value' => $link_reg_success);
$arr['field'][] = array('tab' => 'text', 'type' => 'div_close');

$arr['field'][] = array('tab' => 'email-text', 'type' => 'div', 'class' => 'ui message');
$arr['field'][] = array('tab' => 'email-text', 'type' => 'header', 'class' => '', "text" => "<div class='ui green mini label'>1</div> Bestätigungsaufforderungs Mail");
$arr['field']['emailtitle_reg'] = array('label_left' => 'Betreff:', 'tab' => 'email-text', "type" => "input", 'value' => $emailtitle_reg);
$arr['field']['emailtext_reg'] = array('type' => 'ckeditor', 'toolbar' => 'mini', 'tab' => 'email-text', 'value' => $emailtext_reg);
$arr['field'][] = array('tab' => 'email-text', 'type' => 'content', 'text' => call_placeholder('', 'emailtext_reg'));
$arr['field'][] = array('tab' => 'email-text', 'type' => 'div_close');

// hat optional Followup-sequenz gestartet - wurde aber durch eine andere Lösung abgelöst
/*
 * $arr['field'][] = array ( 'tab' => 'email-text' , 'type' => 'div' , 'class' => 'ui message' );
 * $arr['field'][] = array ( 'tab' => 'email-text' , 'type' => 'header' , 'class' => 'big' , "text" => "<div class='ui green mini label'>2</div> Willkommens-Mail" );
 * $arr['field']['followup_mail_id'] = array ('tab' => 'email-text' , 'type' => 'dropdown' , 'label' => 'Followup-Sequenz einbinden' , 'array' => call_array_start_followup_pool() , 'placeholder' => '--Followup-Mail wählen--','clear'=>true );
 * $arr['field'][] = array ( 'tab' => 'email-text' , 'type' => 'div' , 'class' => 'ui horizontal divider', 'text'=>"oder" );
 * $arr['field'][] = array ( 'tab' => 'email-text' , 'type' => 'div_close' );
 * //ODER
 * $arr['field'][] = array ( 'tab' => 'email-text' , 'type' => 'div' , 'class' => 'ui accordion', 'text'=>"<div class='title'><i class='icon dropdown'></i>Direktes Mail verfassen</div>" );
 * $arr['field'][] = array ( 'tab' => 'email-text' , 'type' => 'div' , 'class' => 'content' );
 */

$arr['field'][] = array('tab' => 'email-text', 'type' => 'div', 'class' => 'ui message');
$arr['field']['emailtitle_reg_success'] = array('label_left' => 'Betreff:', 'tab' => 'email-text', "type" => "input", 'value' => $emailtitle_reg_success);
$arr['field']['emailtext_reg_success'] = array('type' => 'ckeditor', 'toolbar' => 'mini', 'tab' => 'email-text', 'value' => $emailtext_reg_success);
$arr['field'][] = array('tab' => 'email-text', 'type' => 'content', 'text' => call_placeholder($array_promotion, 'emailtext_reg_success'));
$arr['field'][] = array('tab' => 'email-text', 'type' => 'div_close');
// $arr['field'][] = array ( 'tab' => 'email-text' , 'type' => 'div_close' );
// $arr['field'][] = array ( 'tab' => 'email-text' , 'type' => 'div_close' );

// $arr['field'][] = array ( 'tab' => 'text' , 'type' => 'content' , 'text' => '<hr>' );
$arr['field']['text_user_exists_inactive'] = array('tab' => 'text', "label" => "Text nach absenden (wenn bereits angemeldet aber nicht bestätigt)", "type" => "input", 'value' => $text_user_exists_inactive);
$arr['field']['text_user_exists_active'] = array('tab' => 'text', "label" => "Text nach absenden (wenn bereits angemeldet aber nicht bestätigt)", "type" => "input", 'value' => $text_user_exists_active);
$arr['field']['text_user_exists_set_inactive'] = array('tab' => 'text', "label" => "Text nach absenden (wenn bereits angemeldet von User jedoch deaktiviert wurde)", "type" => "input", 'value' => $text_user_exists_set_inactive);
$arr['field']['text_promotion_codes_used_up'] = array('tab' => 'text', "label" => "Promotion-Codes (Verbraucht)", "type" => "input", 'value' => $text_promotion_codes_used_up);
