<?php

// Werte abrufen für Mail-Auslöser
$query = $GLOBALS['mysqli']->query ( "SELECT * from f_trigger2mail WHERE followup_id = '$update_id' " );
$array = mysqli_fetch_array ( $query );
$trigger_mail_id = $array['mail_id'];
if ($array['click'])
	$trigger_mail_value = 'click';
if ($trigger_mail_value)
	$trigger_mail_value .= ',';
if ($array['open'])
	$trigger_mail_value .= 'open';


// Werte abrufen für ListbuildingID
$query = $GLOBALS['mysqli']->query ( "SELECT * from f_trigger2listbuilding WHERE followup_id = '$update_id' " );
$array = mysqli_fetch_array ( $query );
$trigger_listbuilding_id = $array['listbuilding_id'];

// Werte abrufen für ListbuildingID
$query = $GLOBALS['mysqli']->query ( "SELECT * from f_trigger2followup WHERE followup_id = '$update_id' " );
$array = mysqli_fetch_array ( $query );
$trigger_step_id = $array['step_id'];

// Tag Auslöser
$mysql_tag_query = $GLOBALS['mysqli']->query ( "SELECT * from f_trigger2tag WHERE followup_id = '$update_id' AND !no AND !new" ) or die ( mysqli_error ($GLOBALS['mysqli']) ); // and activate='1'
while ( $mysql_tag_fetch = mysqli_fetch_array ( $mysql_tag_query ) ) {
	$tag_id = $mysql_tag_fetch['tag_id'];
	// $tag_name = $mysql_tag_fetch['title'];
	$trigger_tag_selected_array[] = $tag_id;
}

// NOT-Tag Auslöser
$mysql_not_tag_query = $GLOBALS['mysqli']->query ( "SELECT * from f_trigger2tag WHERE followup_id = '$update_id' AND no " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
// and activate='1'
while ( $mysql_not_tag_fetch = mysqli_fetch_array ( $mysql_not_tag_query ) ) {
	$tag_id = $mysql_not_tag_fetch['tag_id'];
	// $tag_name = $mysql_tag_fetch['title'];
	$trigger_not_tag_selected_array[] = $tag_id;
}

// Wenn User direkt einem Tag zugewiesen wird
$mysql_new_tag_query = $GLOBALS['mysqli']->query ( "SELECT * from f_trigger2tag WHERE followup_id = '$update_id' AND !no AND new " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
// and activate='1'
while ( $mysql_tag_fetch = mysqli_fetch_array ( $mysql_new_tag_query ) ) {
	$tag_id = $mysql_tag_fetch['tag_id'];
	// $tag_name = $mysql_tag_fetch['title'];
	$trigger_new_tag_selected_array[] = $tag_id;
}

if ($update_id) {
	// Zeit Auslöser
	$query = $GLOBALS['mysqli']->query ( "SELECT mode, DATE_FORMAT(send_time,'%Y-%m-%d') date, DATE_FORMAT(send_time,'%H:%i') time, day,hour,min from f_trigger2time WHERE followup_id = '$update_id' " );
	$array = mysqli_fetch_array ( $query );
	$trigger_time = $array['mode'];
	$time_date = $array['date'];
	$time_time = $array['time'];
	$time_day = $array['day'];
	$time_hour = $array['hour'];
	$time_min = $array['min'];
}
else {
	$trigger_time = 'now';
}

$array_status['open'] = 'geöffnet';
$array_status['click'] = 'geklickt';

$array_trigger_time['no'] = 'Sofort';
$array_trigger_time['datetime'] = 'nach Datum und Uhrzeit';
$array_trigger_time['periode'] = 'nach Tagen / Stunden / Min';

$array_select_trigger['trigger_by_listbuilding'] = 'Listbuilding';
$array_select_trigger['trigger_by_tag'] = 'Tag-Zuweisung';
$array_select_trigger['trigger_by_step'] = 'Step';

$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'ui message' );

/*****************************
 * MODUS-Auslöser
 *****************************/
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'equal fields' );
$arr['field']["trigger_modus"] = array ( 'label' => 'Step wird ausgelöst durch' , 'tab' => 'trigger' , 'class' => 'wide ten' , 'type' => 'dropdown' , 'array' => $array_select_trigger, 'validate'=>true );
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );

$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'equal fields trigger_settings trigger_by_tag' );
$arr['field']['trigger_new_tag'] = array ( 'value' => $trigger_new_tag_selected_array , 'tab' => 'trigger' , 'type' => 'multiselect' , 'class' => 'wide eleven search' , 'label' => 'Wenn User einer dieser Tag(s) zugewiesen bekommt' , 'array' => call_array_tags () );
$arr['field']['trigger_new_tag_add'] = array ( 'tab' => 'trigger' , 'type' => 'input' , 'class' => 'wide five' , 'label' => 'Neuen Tag' , 'label_left' => "<i class='icon arrow left'></i> Anlegen" , 'label_left_class' => 'button orange ui' );
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );

// Modus - Mailauslöser
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'equal fields trigger_settings trigger_by_step' );
$arr['field']["trigger_step_id"] = array ( 'value' => $trigger_step_id , 'class' => 'wide ten' , 'label' => 'Wenn dieser Step ausgeführt' , 'tab' => 'trigger' , 'type' => 'dropdown' , 'array' => call_array_followup_step ($pool_id, $update_id ) , 'clear' => true );
//$arr['field']["trigger_mail_status"] = array ( 'value' => $trigger_mail_value , 'class' => 'wide six mail_status' , 'label' => 'Status' , 'tab' => 'trigger' , 'type' => 'multiselect' , 'array' => $array_status );
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );

// Modus - Listbuilding-Auslöser
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'equal fields trigger_settings trigger_by_listbuilding' );
$arr['field']["trigger_listbuilding_id"] = array ( 'value' => $trigger_listbuilding_id , 'class' => 'wide ten' , 'label' => 'Wenn User dieses Listbuilding abgeschlossen hat' , 'tab' => 'trigger' , 'type' => 'dropdown' , 'array' => call_array_listbuilding () , 'clear' => true );
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );

$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );

//UND
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'content' , 'align' => 'center' , 'text' => "<b>UND</b>" );
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'ui message' );


/*****************************
 * Zeitauslöser
 *****************************/
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'fields' );
$arr['field']["trigger_time"] = array ( 'value' => '0' , 'label' => '<i class="icon clock"></i>Verzögerung/Zeitpunkt' , 'tab' => 'trigger' , 'class' => 'wide five' , 'type' => 'dropdown' , 'array' => $array_trigger_time, 'value'=>$trigger_time );
$arr['field']['time_date'] = array ( 'value' => $time_date , 'tab' => 'trigger' , 'label' => 'Sende-Datum' , 'type' => 'date' , 'placeholder' => "" , 'option' => "data-lock='from'" , 'class' => 'datetime time_settings' );
$arr['field']['time_time'] = array ( 'value' => $time_time , 'tab' => 'trigger' , 'label' => 'Sende-Zeit' , 'type' => 'time' , 'placeholder' => "" , 'option' => $option_time , 'class' => 'datetime time_settings' );
$arr['field']['time_day'] = array ( 'value' => $time_day , 'tab' => 'trigger' , 'label' => 'Tagen' , 'type' => 'input' , 'class' => 'time_settings periode' );
$arr['field']['time_hour'] = array ( 'value' => $time_hour , 'tab' => 'trigger' , 'label' => 'Stunden' , 'type' => 'input' , 'class' => 'time_settings periode' );
$arr['field']['time_min'] = array ( 'value' => $time_min , 'tab' => 'trigger' , 'label' => 'Minuten' , 'type' => 'input' , 'class' => 'time_settings periode' );
$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );

$arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );

// Wenn User diese Tags nicht hat
// $arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'ui horizontal divider' , 'text' => "und" );
// $arr['field']["trigger_tag"] = array ( 'value' => $trigger_tag_selected_array , 'label' => 'Wenn User diese Tag(s) hat' , 'tab' => 'trigger' , 'type' => 'multiselect' , 'array' => call_array_tags () );
// $arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div' , 'class' => 'ui horizontal divider' , 'text' => "und" );
// $arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );
// $arr['field']["trigger_not_tag"] = array ( 'value' => $trigger_not_tag_selected_array , 'label' => 'Wenn User NICHT diese Tag(s) hat' , 'tab' => 'trigger' , 'type' => 'multiselect' , 'array' => call_array_tags () );
// $arr['field'][] = array ( 'tab' => 'trigger' , 'type' => 'div_close' );