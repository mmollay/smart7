<?php
/*
 * page_newsletter.php - Versenden von News
 * @author Martin Mollay
 * @last-changed 2012-06-15 MM
 * -
 * - Gruppen überarbeitet
 */
require_once('../config.inc.php');
include('../../ssi_smart/smart_form/include_form.php');

if ($_POST['session_id'] && $_POST['event']) {
	// Neuen Tag erzeugen, session+event einhängen und tag_id ausgeben
	$tag_id = set_new_tag_from_session($_POST['session_id'], $_POST['event']);
	$focus_title_id = true;
}

$set_with_session_id_tags = true;

$array_promotion = call_array_promotion();
if ($_POST['clone_id']) {
	$clone_fields = "user_id,title,text,modus,from_name,from_email,error_email,report_email,smtp_server,smtp_user,smtp_password,smtp_secure,smtp_port,test_email,sender_id,tag_id,from_id,all_user,without_footline,label_id";
	$GLOBALS['mysqli']->query("insert into session( $clone_fields,status ) select $clone_fields,1 from session where session_id = '{$_POST['clone_id']}' ") or die(mysqli_error($GLOBALS['mysqli']));
	$_POST['update_id'] = mysqli_insert_id($GLOBALS['mysqli']);
	$default_time = (date('H') + 2) . ":00"; // Defaut-Zeit für Absenden des Newsletters
	$default_date = date('Y-m-d');
}

// "status = 1"

if (isset($_GET['list'])) {
	$list_modus = 1;
}

// Wenn noch kein Newsletter angelegt wurde - wird ein Platz freigegeben
// damit ist Multiuser-fähig wegen ID-vergabe und Bild "temp" nicht mehr notwendig
if (!$_POST['update_id']) {

	$query = $GLOBALS['mysqli']->query("SELECT * from setting WHERE user_id = '{$_SESSION['user_id']}'") or die(mysqli_error($GLOBALS['mysqli']));
	$array = mysqli_fetch_array($query);
	$from_id = $array['default_from_id'] ?? 0;

	$GLOBALS['mysqli']->query("DELETE FROM session WHERE user_id = '{$_SESSION['user_id']}' AND text='' AND title='' AND status = 1");

	$sql = "INSERT INTO session SET user_id = '{$_SESSION['user_id']}', datetime_start = NOW(), status = 1, label_id=0, counter=0, title='', text='', modus ='', from_name ='', from_email = '', replay_email ='', replay_name ='', error_email ='', report_email='', size=0, `release` = 0, test_email ='', sender_id=0, tag_id ='', tag_id_minus='', from_id = $from_id, all_user =0, allow_email_duplicate = 0, without_footline =0, send_date = '0000-00-00', send_auto =0, delivery_system ='', remove_nl = 0, array_contact_id ='', array_contact_id_minus ='', followup_id = 0, smtp_server = '' , smtp_user ='', smtp_password = '' , smtp_secure ='', smtp_port = 0 ";

	$GLOBALS['mysqli']->query($sql);
	$_POST['update_id'] = mysqli_insert_id($GLOBALS['mysqli']);
	$arr['hidden']['update_id_first'] = $_POST['update_id'];
	$default_time = (date('H') + 2) . ":00"; // Defaut-Zeit für Absenden des Newsletters
	$default_date = date('Y-m-d');

	$option_time = 'setCurrentTime:false';
} else if ($_POST['update_id']) {
	$arr['sql'] = array(
		'query' => "SELECT 
			DATE_FORMAT(send_date,'%Y-%m-%d') send_date, 
			DATE_FORMAT(send_date,'%H:%i') send_time,
			send_auto,from_id,tag_id,tag_id_minus,title,text,without_footline,all_user 
			from session where session_id = '{$_POST['update_id']}'"
	);
	$focus_title_id = true;

	$query_contact = $GLOBALS['mysqli']->query("SELECT array_contact_id,array_contact_id_minus FROM session WHERE session_id = '{$_POST['update_id']}'") or die(mysqli_error($GLOBALS['mysqli']));
	$fetch_contact = $query_contact->fetch_array();

	// auslesen und überprüfen ob User noch aktiv ist
	$array_contact_id = call_active_client_db($fetch_contact['array_contact_id']);
	$array_contact_id_minus = call_active_client_db($fetch_contact['array_contact_id_minus']);
}

$arr['hidden']['generate_manuell'] = true; // übergibt Wert wenn Campagne manuell erzeugt wird //Rückgabe "ok"
function call_active_client_db($value)
{
	$array = explode(',', $value);
	foreach ($array as $id) {
		$query = $GLOBALS['mysqli']->query("SELECT activate FROM contact WHERE contact_id = '$id' AND activate = 1 ");
		$fetch = $query->fetch_array();
		if ($fetch[0])
			$array2[] = $id;
	}
	return $array2;
}

$onload = "
$('#short_info_box').hide();
$('.testmail').hide();
if ($('#text').val() && $('#title').val() && $('#from_id').val()) { $('.testmail').show(); }
$('#send_auto').change();
load_autosave('{$_POST['update_id']}','form_edit');
";

/**
 * ****************************************************************************************
 * ermöglicht, dass alle zusätzlichen Felder nach Befüllung automatisch gespeichert werden
 * /*****************************************************************************************
 */
$ck_editor = "
resize_enabled :false,
autoGrow_minHeight:200,
autoGrow_maxHeight: 500, 
autoDetectPasteFromWord: true,
pasteFromWordRemoveStyles: true,
removePlugins : 'magicline,elementspath',
 filebrowserBrowseUrl:'ckeditor_link.php',
on: {
instanceReady: function(event) {
	var buffer = CKEDITOR.tools.eventsBuffer( 10000, function() {
	var data = event.editor.getData();
	fu_save_content('{$_POST['update_id']}','text',data);
	if ($('#text').val() && $('#title').val() && $('#from_id').val()) $('.testmail').show();
});
this.on( 'change', buffer.input );
}
}";

$buttons_placeholder = "<span style='float:left;' id ='short_info_box'><i class='circle icon save'></i></span>";
$buttons_placeholder .= call_placeholder($array_promotion, 'text');

if (!$list_modus) {
	// $arr['header'] = array ( 'text' => "<i class='icon write'></i><div class='content'>Aussendung verfassen</div>" , 'segment_class' => 'secondary green' );
	$arr['ajax'] = array('onLoad' => $onload, 'success' => "load_content_semantic('newsletter','list_campagne')", 'dataType' => "html");
	// $form_class = 'segment';
	$form_width = '900';
} else {
	$arr['ajax'] = array(
		'onLoad' => $onload,
		'success' => "
	if (data == 'no_contacts') alert('Keine Kontakte gewählt');
	else if (data == 'ok') { $('.modal.ui').modal('hide'); table_reload('newsletter_list'); }",
		'dataType' => "html"
	);
	// $arr['ajax'] = array ( 'onLoad' => $onload , 'success' => "$('.modal.ui').modal('hide'); table_reload('newsletter_list'); " , 'dataType' => "html" );
	$form_width = '100%';
}

$arr['form'] = array('action' => "ajax/content_campagne2.php", 'id' => 'form_edit', 'inline' => 'list', 'class' => $form_class, 'width' => $form_width);
$arr['tab'] = array('class' => "pointing secondary", 'content_class' => "secondary", 'tabs' => ["first" => "Allgemein", "text" => "<i class='icon write'></i>Verfassen", "upl" => "<i class='icon upload'></i>Dateien hochladen", "time" => "<i class='icon clock'></i> Absendezeit"], 'active' => '');

$arr['field']['send_auto'] = array('tab' => 'time', 'type' => 'toggle', 'label' => 'Absendung automatisch starten');
$arr['field'][] = array('tab' => 'time', 'type' => 'div', 'class' => 'fields auto_time');
$arr['field']['send_date'] = array('tab' => 'time', 'label' => 'Sende-Datum', 'type' => 'date', 'placeholder' => "", 'option' => "data-lock='from'", 'value' => $default_date, 'class' => 'ten wide');
$arr['field']['send_time'] = array('tab' => 'time', 'label' => 'Sende-Zeit', 'type' => 'time', 'placeholder' => "", 'option' => $option_time, 'class' => 'six wide', 'value' => $default_time);
$arr['field'][] = array('tab' => 'time', 'type' => 'div_close');

$arr['field']['from_id'] = array('tab' => 'first', 'type' => 'dropdown', 'label' => 'Von', 'array' => call_array_sender($_SESSION['user_id']), 'validate' => 'Bitte Absender auswählen', 'placeholder' => '--Absender wählen--', 'focus' => $focus_from_id, 'value' => $from_id);

$arr['field'][] = array('tab' => 'first', 'type' => 'div', 'class' => 'two fields');

$arr['field']['tag_id'] = array('tab' => 'first', 'type' => 'multiselect', 'label' => "An diese Tags <div class='ui label mini green'>versenden</div>", 'array' => call_array_tags(true, $set_with_session_id_tags), 'class' => 'search', 'focus' => $focus_tag_id, 'value' => $tag_id);

$arr['field']['tag_id_minus'] = array('tab' => 'first', 'type' => 'multiselect', 'label' => "Diese Tags <div class='ui label mini red'>ausschließen</div>", 'array' => call_array_tags(true, $set_with_session_id_tags), 'class' => 'search', 'info' => 'Gezieltes Versenden an User durch Ausschluss von Tags');

$arr['field'][] = array('tab' => 'first', 'type' => 'div_close');

$arr['field'][] = array('tab' => 'first', 'type' => 'div', 'class' => 'two fields');

$arr['field']['array_contact_id'] = array(
	'value' => $array_contact_id,
	'tab' => 'first',
	'type' => 'multiselect',
	'label' => "Zusätzliche User <div class='ui label mini green'>versenden</div>",
	// 'array' => call_array_contact ($_POST['session_id']),
	'url' => 'inc/get_array.php?search={query}',
	'class' => 'search',
	'info' => 'hier können noch weitere einzelne Kontakte hinzugefügt werden.'
);

$arr['field']['array_contact_id_minus'] = array(
	'value' => $array_contact_id_minus,
	'tab' => 'first',
	'type' => 'multiselect',
	'label' => "Diese User <div class='ui label mini red'>ausschließen</div>",
	// 'array' => call_array_contact ($_POST['session_id']) ,
	'url' => 'inc/get_array.php?search={query}',
	'class' => 'search',
	'info' => 'hier können noch weitere einzelne Kontakte hinzugefügt werden.'
);

$arr['field'][] = array('tab' => 'first', 'type' => 'div_close');

// if ($array_promotion)
// $arr['field']['promotion_id'] = array ( 'tab' => 'first' , 'type' => 'dropdown' , 'label' => "Promotion-Code einbinden" , 'array' => $array_promotion , 'class' => 'search' );

$arr['field']['title'] = array('tab' => 'first', 'label' => "Betreff", 'type' => "input", 'validate' => 'Bitte Betreff ausfüllen', 'placeholder' => 'Newsletterüberschrift', 'focus' => $focus_title_id);
$arr['field']['placeholder'] = array('tab' => 'first', 'type' => 'content', 'text' => $buttons_placeholder . "");
$arr['field']['text'] = array('style' => 'max-height:250px;', 'tab' => 'first', 'type' => "ckeditor", 'validate' => 'Bitte Nachricht eingeben', 'config' => $ck_editor);
$arr['field']['img_url'] = array('tab' => 'upl', 'label' => 'Daten hochladen', 'type' => 'uploader', 'upload_dir' => $upload_dir . "/{$_POST['update_id']}/", 'upload_url' => $upload_url . "/{$_POST['update_id']}/", 'accept' => array('png', 'jpg', 'jpeg', 'gif', 'pdf', 'zip'), 'options' => 'imageMaxWidth:1000,imageMaxHeight:1000', 'button_upload' => array('text' => "Dateien auswählen", 'color' => 'green', 'icon' => 'upload'), 'card_class' => 'five', 'interactions' => array('sortable' => true));

$arr['field']['without_footline'] = array('tab' => 'first', 'type' => 'checkbox', 'label' => 'Ohne "Newsletter abbestellen" in der Fu&szlig;zeile');
// $arr['field']['all_user'] = array ( 'tab' => 'first' , 'type' => 'checkbox' , 'label' => 'Newsletter auch an alle Inaktiven User senden' );

// $arr['field']['allow_email_duplicate'] = array ( 'type' => 'checkbox' , 'label' => 'Zustellung gleicher Emails zulassen' );
$arr['hidden']['session_id'] = $_POST['update_id']; // wird benötigt, damit ajax, alle 10sec. den content sichert

// TODO: Muss noch umgeschriebn werden - in Smart_form mm@ssi.at
// $arr['ajax']['success'] = array ( 'success' => "$('#modal_form_newsletter').modal('hide'); table_reload();" , 'dataType' => "html" );
// $arr['ajax']['beforeSend'] = array ( 'onLoad' => "$ajax_first_onload" , 'dataType' => "script" );

$arr['buttons'] = array('align' => 'center');
$arr['button']['submit'] = array('value' => "<i class='save icon'></i>Aussendung speichern", 'color' => 'blue');

// if (!isset($_GET['list'])) {
$arr['button']['testmail'] = array('value' => "<i class='mail icon'></i>Testmail schicken", 'onclick' => "fu_save_content('{$_POST['update_id']}','text',CKEDITOR.instances['text'].getData()); SmartSendTestMail('{$_POST['update_id']}')", 'color' => 'grey');
// }

if (isset($_GET['list'])) {
	$arr['button']['close'] = array('value' => 'Schließen', 'color' => 'gray', 'js' => "$('#modal_form_newsletter').modal('hide'); ");
}

$output = call_form($arr);
echo $output['html'];
echo "<script>appendScript('js/form_newsletter.js');</script>";
// echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/form_newsletter.js\"></script>";
echo $output['js'];

if (!isset($_GET['list'])) {
	$close_button = "<div style='float:right'><a href=# onclick=\"$('#modal_testmail').modal('hide')\"><i class='close icon'></i></a></div><div style='clear:both'></div>";
	echo "<br><br><div id='modal_testmail' class='ui small modal'><div class='header'>Testmail$close_button</div><div class='content'></div></div>";
}
