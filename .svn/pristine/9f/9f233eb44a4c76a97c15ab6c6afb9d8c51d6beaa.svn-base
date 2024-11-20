<?php
// Tag Auslöser
$mysql_tag_query = $GLOBALS['mysqli']->query ( "SELECT * from f_action2tag WHERE followup_id = '$update_id' AND !no " ); // and activate='1'
while ( $mysql_tag_fetch = mysqli_fetch_array ( $mysql_tag_query ) ) {
	$tag_id = $mysql_tag_fetch['tag_id'];
	// $tag_name = $mysql_tag_fetch['title'];
	$action_add_tag_selected_array[] = $tag_id;
}

// NOT-Tag Auslöser
$mysql_not_tag_query = $GLOBALS['mysqli']->query ( "SELECT * from f_action2tag WHERE followup_id = '$update_id' AND no " ); // and activate='1'
while ( $mysql_not_tag_fetch = mysqli_fetch_array ( $mysql_not_tag_query ) ) {
	$tag_id = $mysql_not_tag_fetch['tag_id'];
	// $tag_name = $mysql_tag_fetch['title'];
	$action_remove_tag_selected_array[] = $tag_id;
}

$query = $GLOBALS['mysqli']->query ( "SELECT * from f_action2followup b WHERE b.followup_id = '$update_id'  " );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$action_array_mail_id[] = $array['mail_id'];
}

$arr['field'][] = array ( 'tab' => 'action' , 'type' => 'div' , 'class' => 'ui message' );
//$arr['field']["action_add_tag"] = array ( 'value' => $action_add_tag_selected_array , 'label' => 'Diese Tag(s) dem User hinzugfügen' , 'tab' => 'action' , 'type' => 'multiselect' , 'array' => call_array_tags () );

$arr['field'][] = array ( 'tab' => 'action' , 'type' => 'div' , 'class' => 'fields' );
$arr['field']['action_add_tag'] = array ( 'value' => $action_add_tag_selected_array , 'tab' => 'action' , 'type' => 'multiselect' , 'class' => 'wide eleven search' , 'label' => 'Diese Tag(s) dem User hinzugfügen' , 'array' => call_array_tags () );
$arr['field']['action_add_tag_add'] = array ( 'tab' => 'action' , 'type' => 'input' , 'class' => 'wide five' , 'label' => 'Neuen Tag' , 'label_left' => "<i class='icon arrow left'></i> Anlegen" , 'label_left_class' => 'button orange ui' );
$arr['field'][] = array ( 'tab' => 'action' , 'type' => 'div_close' );


$arr['field']["action_remove_tag"] = array ( 'value' => $action_remove_tag_selected_array , 'label' => 'Diese Tag(s) dem User entziehen' , 'tab' => 'action' , 'type' => 'multiselect' , 'array' => call_array_tags () );
$arr['field'][] = array ( 'tab' => 'action' , 'type' => 'div_close' );



// $arr['field']["action_mail_id"] = array ( 'value' =>$action_array_mail_id , 'label' => 'Diese Followup-Mail(s) auslösen' , 'tab' => 'action' , 'type' => 'multiselect' , 'array' => call_array_followup ( $update_id ) );
