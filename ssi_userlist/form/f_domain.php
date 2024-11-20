<?php
$domain_id = $_POST['update_id'];

// Userrechte auslesen
$query = $GLOBALS['mysqli']->query ( "SELECT * FROM smart_user_right order by title" );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$profile_array[$array['right_id']] = $array['title'];
}

// Auslesen der Aliases
$query = $GLOBALS['mysqli']->query ( "SELECT * FROM ssi_company.domain WHERE parent_id = '$domain_id' " ) or die (mysql_error());
while ( $array = mysqli_fetch_array ( $query ) ) {
	$domain_alias .= $array['domain'] . "\n";
}

$arr['form'] = array ( 'action' => "ajax/form_edit2.php" , 'id' => 'form_edit_smart' , 'size' => 'small' );
$arr['sql'] = array ( 'query' => "SELECT * FROM ssi_company.domain WHERE domain_id = '$domain_id' " );

$arr['field']['locked'] = array ( 'type' => 'toggle' , 'label' => 'Webseite sperren' );
// $arr['field']['page_locked'] = array ( 'type' => 'toggle' , 'label' => 'Webseite sperren' );
$arr['field']['set_ssl'] = array ( 'type' => 'toggle' , 'label' => 'SSL-aktivieren' , 'info' => 'Die Domain muss verifiert sein' );
$arr['field']['set_subdomain'] = array ( 'type' => 'toggle' , 'label' => 'Domain ist Sub-Domain (ohne www)' );
$arr['field']['domain'] = array ( 'label' => 'Domain (ohne www angeben)' , 'type' => 'input' ,  'focus' => true );
$arr['field']['domain_alias'] = array ( 'label' => 'Domain-Aliases (ohne www angeben)' , 'type' => 'textarea', 'value' => $domain_alias );
$arr['field']['domain_forwarding'] = array ( 'label' => 'Domain(s) weiterleiten an' , 'type' => 'input' , 'placeholder' => 'https://' );
$arr['field']['right_id'] = array ( 'label' => 'Profil' , 'type' => "select" , 'array' => $profile_array );
$arr['field']['txt_file'] = array ( 'label' => 'Txt-File anlegen' , 'info' => 'Für diverse Dienste zum bestätigen der Domain (Bsp.:Mailjet, Google,uws.)' , 'type' => 'input' );