<?php
if (! $_POST['update_id']) {
	// Holt per Default den FROM - Absender
	$query = $GLOBALS['mysqli']->query ( "SELECT * from setting WHERE user_id = '{$_SESSION['user_id']}'" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$array = mysqli_fetch_array ( $query );
	$from_id = $array['default_from_id'];
}

// Check ob Einträge vorhanden, wenn nicht wird einer erzeugt
// Wichtig für die Zuweisung der mail_id für attachments
if (! mysqli_num_rows ( $GLOBALS['mysqli']->query ( "SELECT mail_id from f_mail2followup WHERE followup_id = '$update_id' " ) )) {
	$GLOBALS['mysqli']->query ( "INSERT INTO followup_mail SET user_id = '$user_id', from_id = '$from_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$mail_id = mysqli_insert_id ($GLOBALS['mysqli']);
	$GLOBALS['mysqli']->query ( "INSERT INTO f_mail2followup SET mail_id = '$mail_id', followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
}

$query_mail = $GLOBALS['mysqli']->query ( "SELECT * from followup_mail a LEFT JOIN f_mail2followup b ON a.mail_id = b.mail_id WHERE b.followup_id = '$update_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$array_mail = mysqli_fetch_array ( $query_mail );
// while ( $array_mail = mysqli_fetch_array ( $query_mail ) ) {

$mail_title = $array_mail['title'];
$mail_text = $array_mail['text'];
$mail_id = $array_mail['mail_id'];
$mail_matchcode = $array_mail['matchcode'];
$mail_from_id = $array_mail['from_id'];
if (! $mail_from_id)
	$mail_from_id = $from_id;

$ck_editor = "autoDetectPasteFromWord: true,pasteFromWordRemoveStyles: true,removePlugins : 'magicline,elementspath', filebrowserBrowseUrl:'ckeditor_link.php', ";

// Autosave fuer ckeditor
$ck_editor .= "
	on: {
	instanceReady: function(event) {
	var buffer = CKEDITOR.tools.eventsBuffer( 10000, function() {
	var data = event.editor.getData();
	fu_save_value('$mail_id','text',data);
	if ($('#text').val() && $('#title').val() && $('#from_id').val()) $('.testmail').show();
	});
	this.on( 'change', buffer.input );
	}
	}";

// Check ob Promotion vorhanden ist
$array_promotion = call_array_promotion ();
$buttons_placeholder = "<span style='float:left;' id ='short_info_box'><i class='circle icon save'></i></span>";
$buttons_placeholder .= call_placeholder ( $array_promotion, 'text' );

$arr['field'][] = array ( 'tab' => 'mail' , 'type' => 'div' , 'class' => 'ui message' );
$arr['field']['mail_matchcode'] = array ( 'tab' => 'mail' , 'type' => 'input' , 'label' => 'Mail Beschreibung (interne Kennung)' , 'array' => call_array_sender ( $user_id )  , 'placeholder' => 'Interner Titel' , 'value' => $mail_matchcode );
$arr['field']['from_id'] = array ( 'class_input' => 'autosave' , 'tab' => 'mail' , 'type' => 'dropdown' , 'label' => 'Von' , 'array' => call_array_sender ( $user_id )  , 'placeholder' => '--Absender wählen--' , 'value' => $mail_from_id );
$arr['field']['title'] = array ( 'class_input' => 'autosave' , 'tab' => 'mail' , 'label' => "Betreff" , 'type' => "input"  , 'placeholder' => 'Newsletterüberschrift' , 'value' => $mail_title );
$arr['field']['text'] = array ( 'tab' => 'mail' , 'type' => "ckeditor"  , 'toolbar' =>'mini' , 'config' => $ck_editor , 'value' => $mail_text );
$arr['field']['placeholder'] = array ( 'tab' => 'mail' , 'type' => 'content' ,  'text' => $buttons_placeholder );
$arr['field']['img_url'] = array ( 'tab' => 'mail' , 
		'label' => 'Daten hochladen' , 
		'type' => 'uploader' , 
		'upload_dir' => $upload_dir . "/followup/$mail_id/" , 
		'upload_url' => $upload_url . "/followup/$mail_id/" , 
		'accept' => array ( 'png' , 'jpg' , 'jpeg' , 'gif' , 'pdf' , 'zip' ) , 
		// 'webcam' => array('width'=>'800','height'=>'600'),
		'options' => 'imageMaxWidth:1000,imageMaxHeight:1000' , 
		'button_upload' => array ( 'text' => "Dateien auswählen" , 'color' => 'green' , 'icon' => 'upload' ) , 
		'card_class' => 'five' , 
		'interactions' => array ( 'sortable' => true ) );
$arr['field'][] = array ( 'tab' => 'mail' , 'type' => 'div_close' );
$arr['hidden']['mail_id'] = $mail_id;

$onload_after .= "
	$('#short_info_box').hide();
	$('.testmail').hide();
	if ($('#text').val() && $('#title').val() && $('#from_id').val()) $('.testmail').show();
	$('#trigger_time').change();
	$('#trigger_modus').change();
	$('#trigger_step_id').change();
	load_autosave_followup('$mail_id','autosave');
	";
//}