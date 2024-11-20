<?php
if ($_POST ['update_id']) {
	$query = $GLOBALS ['mysqli']->query ( "SELECT module FROM module2id_user WHERE user_id = '{$_POST['update_id']}'  " );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$set_modul_user [$array ['module']] = true;
	}
	// Defaultmässig einstellen wenn user neu angelegt wird
} else {
	$user_checked = 1;
	$set_modul_user ['smart'] = 1;
	$number_of_smartpage = 1;
	$right_id = 1;
}

$query = $GLOBALS ['mysqli']->query ( "SELECT * FROM smart_user_right order by title" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$profile_array [$array ['right_id']] = $array ['title'];
}

$query2 = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_company.user2company WHERE user_id != '{$_POST['update_id']}' and parent_id != '{$_POST['update_id']}' order by user_id " );
while ( $array2 = mysqli_fetch_array ( $query2 ) ) {
	$array_user_id = $array2 ['user_id'];
	$array_firstname = $array2 ['firstname'];
	$array_sescondname = $array2 ['secondname'];
	$array_email = $array2 ['user_name'];
	$array_user [$array_user_id] = "$array_user_id - $array_email ($array_firstname $array_sescondname)";
}

$array_sex = array ('' => '--Bitte w&auml;hlen--','f' => 'Frau','m' => 'Herr','c' => 'Firma' );

$array_sendmodus = array ('1' => 'Als Email','2' => 'Als Brief','3' => 'Als Brief und Email' );

$arr ['sql'] = array (
		'query' => "SELECT *,
			if (fbid, 1, user_checked) user_checked,
			if (smart_version>'', smart_version, 'stable') smart_version
			from ssi_company.user2company where user_id  = '{$_POST['update_id']}' " );

$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_edit_user','size' => 'small' );
$arr ['tab'] = array ('tabs' => [ "first" => "Stammdaten","sec" => "Rechte" ] );

$arr ['field'] [] = array ('tab' => 'first','id' => 'user_name','type' => 'input','label' => 'Username  (Email)','validate' => 'email','focus' => true,'class' => 'ten wide' );
$arr ['field'] [] = array ('tab' => 'first','id' => 'password','type' => 'password','label' => 'Passwort','class' => 'ten wide' );

if ($_POST ['update_id']) {
	$arr ['field'] [] = array ('tab' => 'first','id' => 'new_password','type' => 'checkbox','label' => 'Passwort neu setzen' );
}

$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'fields' ); // 'label'=>'test'
$arr ['field'] [] = array ('tab' => 'first','id' => 'gender','class' => 'four wide','label' => 'Anrede','type' => 'dropdown','array' => $array_sex );
$arr ['field'] [] = array ('tab' => 'first','id' => 'firstname','class' => 'six wide','label' => 'Vorname','type' => 'input','placeholder' => 'firstname' );
$arr ['field'] [] = array ('tab' => 'first','id' => 'secondname','class' => 'six wide','label' => 'Nachname','type' => 'input','placeholder' => 'secondname' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'fields' ); // 'label'=>'test'
$arr ['field'] [] = array ('tab' => 'first','id' => 'zip','label' => 'Plz','type' => 'input','class' => 'four wide','placeholder' => '1020' );
$arr ['field'] ['city'] = array ('tab' => 'first','label' => 'Stadt','type' => 'input','placeholder' => 'Stadt','class' => 'six wide' );
$arr ['field'] ['country'] = array ('tab' => 'first','label' => 'Land','type' => 'dropdown','value' => 'at','array' => 'country','class' => 'six wide' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

$arr ['field'] ['street'] = array ('tab' => 'first','label' => 'Strasse','type' => 'input','placeholder' => 'Strasse','value' => $street );
$arr ['field'] [] = array ('tab' => 'first','id' => 'parent_id','label' => 'Parent ID','type' => 'dropdown','array' => $array_user,'value' => $group_selected_array,'clear' => true );

$arr ['field'] ['smart_version'] = array ('tab' => 'sec','label' => 'Version','type' => 'dropdown','array' => $array_version );

$arr ['field'] [] = array ('tab' => 'sec','id' => 'locked','type' => 'toggle','label' => 'User sperren' );
$arr ['field'] [] = array ('tab' => 'sec','id' => 'user_checked','type' => 'checkbox','label' => 'User verifiziert','value' => $user_checked );

if (in_array ( $_SESSION ['user_id'], $_SESSION ['array_superuser_id'] )) {
	$arr ['field'] [] = array ('tab' => 'sec','id' => 'superuser','type' => 'checkbox','label' => 'Superuser' );
}

$arr ['field'] [] = array ('tab' => 'sec','type' => 'header','text' => 'Module','size' => '3','class' => 'dividing' );

// Auslesen der Module welche von company freigegeben wurde
$query_modules = $GLOBALS ['mysqli']->query ( "SELECT module FROM ssi_company.module2company WHERE company_id = '$company_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
while ( $array_modules = $query_modules->fetch_array () ) {
	$module_id = $array_modules [0];
	// foreach ( $str_array_modules as $key => $values ) {
	$module_title = $str_array_modules [$module_id];
	$arr ['field'] [] = array ('tab' => 'sec','label' => $module_title,'id' => $array_modules [0],'type' => 'toggle','array' => $array_user,'value' => $set_modul_user [$module_id] );
}

for($iii = 1; $iii < 100; $iii ++) {
	$array_number_of_array [$iii] = $iii;
}

$arr ['field'] [] = array ('tab' => 'sec','type' => 'header','text' => 'Smart-Pages','size' => '3','class' => 'dividing' );
$arr ['field'] [] = array ('tab' => 'sec','type' => 'div','class' => 'fields' ); // 'label'=>'test'
$arr ['field'] [] = array ('tab' => 'sec','id' => 'number_of_smartpage','label' => 'Anzahl','type' => 'dropdown','array' => $array_number_of_array,'class' => 'four wide','value' => $number_of_smartpage );
$arr ['field'] [] = array ('tab' => 'sec','id' => 'right_id','label' => 'User-Profil','type' => 'dropdown','array' => $profile_array,'class' => 'twelve wide' );
$arr ['field'] [] = array ('tab' => 'sec','type' => 'div_close' );