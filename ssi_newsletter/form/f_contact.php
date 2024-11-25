<?php
if ($_POST ['update_id']) {
	// call groups for the User
	$mysql_tag_query = $GLOBALS ['mysqli']->query ( "SELECT * FROM contact2tag where contact_id = '{$_POST['update_id']}' " ); // and activate='1'
	while ( $mysql_tag_fetch = mysqli_fetch_array ( $mysql_tag_query ) ) {
		$tag_id = $mysql_tag_fetch ['tag_id'];
		$tag_name = $mysql_tag_fetch ['title'];
		$tag_selected_array [] = $tag_id;
	}
} else {
	$value_activate = 1;
}
if ($_POST ['update_id']) {
	// auslesen ob von User selbst deaktivert worden ist
	$query = $GLOBALS ['mysqli']->query ( "SELECT COUNT(status_id) FROM user_logfile WHERE contact_id = '{$_POST['update_id']}' and status_id > 2 " );
	$array = mysqli_fetch_array ( $query );
	$user_deactivated = $array [0];
	if ($user_deactivated)
		$text_user_deactivated = "<div class='label ui'><i class='warning red icon'></i>Achtung User hat sich selbst abgemeldet!</div>";
}

$array_sex = array ('' => '--Bitte w&auml;hlen--','f' => 'Frau','m' => 'Herr','c' => 'Firma' );
$array_country = array ('AT' => 'Österreich','DE' => 'Deutschland','CH' => 'Schweiz' );
$array_sendmodus = array ('1' => 'Als Email','2' => 'Als Brief','3' => 'Als Brief und Email' );

$arr ['sql'] = array ('query' => "SELECT * from contact where contact_id = '{$_POST['update_id']}'" );
$arr ['ajax'] = array ('onLoad' => "call_add_tag('tags');",'success' => "after_newsletter_submit( data );",'dataType' => "html" );

$arr ['tab'] = array ('tabs' => [ "first" => "Stammdaten","tag" => "Tags","info" => "Informationen",'upl' => 'Uploads',"sec" => "Erweitert" ] );

$arr ['field'] [] = array ('tab' => 'first','id' => 'email','type' => 'input','label' => 'Email','validate' => 'email','focus' => true );
// $arr['field'][] = array ( 'tab' => 'first' , 'id' => 'sex' , 'label' => 'Anrede' , 'type' => 'radio' , 'array' => $array_sex );
$arr ['field'] [] = array ('tab' => 'first','id' => 'activate','type' => 'toggle','label' => 'User freigeschalten','value' => $value_activate,'label_right' => " $text_user_deactivated" );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' ); // 'label'=>'test'
$arr ['field'] [] = array ('tab' => 'first','id' => 'sex','class' => 'four wide','label' => 'Anrede','type' => 'dropdown','array' => $array_sex );
$arr ['field'] [] = array ('tab' => 'first','id' => 'title','class' => 'four wide','label' => 'Titel','type' => 'input','placeholder' => 'Mag.' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'fields two' ); // 'label'=>'test'
$arr ['field'] [] = array ('tab' => 'first','id' => 'firstname','class' => '','label' => 'Vorname','type' => 'input','placeholder' => 'Vorname' );
$arr ['field'] [] = array ('tab' => 'first','id' => 'secondname','class' => '','label' => 'Nachname','type' => 'input','placeholder' => 'Nachname' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );
$arr ['field'] [] = array ('tab' => 'first','id' => 'client_number','class' => '','label' => 'Kundennummer','type' => 'input','placeholder' => '1234556768' );
$arr ['field'] [] = array ('tab' => 'first','id' => 'telefon','type' => 'input','label' => 'Telefon' );

$arr ['field'] [] = array ('tab' => 'first','id' => 'verify_key','type' => 'content','label' => 'Token','class' => 'message ui' );

$arr ['field'] [] = array ('tab' => 'info','id' => 'commend','type' => 'textarea','label' => 'Zusatz' );
$arr ['field'] [] = array ('tab' => 'info','id' => 'commend2','type' => 'textarea','label' => 'Weiterer Zusatz' );

$arr ['field'] [] = array ('tab' => 'tag','type' => 'div','class' => 'fields' );
$arr ['field'] ['tags'] = array ('tab' => 'tag','label' => 'Ausgewählte Tags','class' => 'eleven wide search','type' => 'multiselect','array' => $array_value_tag,'value' => $tag_selected_array,'settings' => "onChange: function(value, text, selectedItem) { generate_tag_toggles(value,'{$_POST['update_id']}') }" );
$arr ['field'] ['tags_add'] = array ('tab' => 'tag','type' => 'input','label' => 'Neuen Tag','class' => 'five wide','label_left' => "<i class='icon arrow left'></i> Anlegen",'label_left_class' => 'button orange ui' );
$arr ['field'] [] = array ('tab' => 'tag','type' => 'div_close' );

$arr ['field'] [] = array ('tab' => 'tag','type' => 'header','class' => 'dividing','text' => 'Aktiverte Tags' );

$query = $GLOBALS ['mysqli']->query ( "SELECT * FROM tag a LEFT JOIN contact2tag b ON a.tag_id = b.tag_id WHERE b.contact_id = '{$_POST['update_id']}' ORDER by title " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$tag_id = $array ['tag_id'];
	$tag_name = $array ['title'];
	$tag_activate = $array ['activate'];
	$arr ['field'] ["tag$tag_id"] = array ('tab' => 'tag','class' => 'group_toggle','type' => 'toggle','label' => "$tag_name",'value' => $tag_activate );
}

$arr ['field'] [] = array ('tab' => 'tag','type' => 'content','text' => '<div id=add_group></div>' );

$arr ['field'] [] = array ('tab' => 'sec','id' => 'company_1','type' => 'input','label' => 'Firma' );
$arr ['field'] [] = array ('tab' => 'sec','id' => 'company_2','type' => 'input','label' => 'Firma (Zusatz)' );
$arr ['field'] [] = array ('tab' => 'sec','id' => 'street','type' => 'input','label' => 'Straße' );
$arr ['field'] [] = array ('tab' => 'sec','type' => 'div','class' => 'fields' ); // 'label'=>'test'
$arr ['field'] [] = array ('tab' => 'sec','id' => 'zip','label' => 'Plz','type' => 'input','class' => 'four wide','placeholder' => '1020' );
$arr ['field'] [] = array ('tab' => 'sec','id' => 'country','label' => 'Land','type' => 'dropdown','class' => 'twelve wide','array' => 'country' );
$arr ['field'] [] = array ('tab' => 'sec','type' => 'div_close' );
$arr ['field'] ['birth'] = array ('tab' => 'sec','label' => 'Geburtsdatum','type' => 'date' );

$arr ['field'] ['placeholder1'] = array ('tab' => 'sec','type' => 'input','label' => 'Platzhalter 1' );
$arr ['field'] ['placeholder2'] = array ('tab' => 'sec','type' => 'input','label' => 'Platzhalter 2' );
$arr ['field'] ['placeholder3'] = array ('tab' => 'sec','type' => 'input','label' => 'Platzhalter 3' );

exec ( "mkdir $upload_dir/user/{$_POST['update_id']}/" );
if ($_POST ['update_id']) {
	$arr ['field'] ['img_url'] = array ('tab' => 'upl','label' => 'Daten hochladen','type' => 'uploader','upload_dir' => $upload_dir . "/user/{$_POST['update_id']}/",'upload_url' => $upload_url . "/user/{$_POST['update_id']}/",'accept' => array ('png','jpg','jpeg','gif','pdf','zip' ),
			// 'webcam' => array('width'=>'800','height'=>'600'),
			'options' => 'imageMaxWidth:1000,imageMaxHeight:1000','button_upload' => array ('text' => "Dateien auswählen",'color' => 'green','icon' => 'upload' ),'card_class' => 'five','interactions' => array ('sortable' => true ) );
}

$add_js .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/form_contact.js\"></script>";