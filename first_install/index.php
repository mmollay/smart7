<?php
$first_install = true;

$company_id = 1;
$user_id = 1;
$array_company['db_smartkit'] = 'ssi_smart1';
$array_company['matchcode'] = 'ssi';
$array_company['title'] = 'SSI';
$array_company['superuser_id'] = '1';

// Superadmin-Passwort
$array_company['company_password'] = 'martin21;';

$array_user['user_name'] = 'office@ssi.at';
$array_user['password'] = 'martin21;';
$array_user['firstname'] = 'Martin';
$array_user['secondname'] = 'Mollay';
$array_user['password'] = 'martin21;';
$array_user['zip'] = '2700';
$array_user['street'] = 'Hollenthon 33';
$array_user['city'] = 'Hollenthon';
$array_user['country'] = 'at';
$array_user['gender'] = 'm';

// Module welche freigeschalten sind
$array_moduls = array ( 'smart' , 'newsletter' , 'userlist' );
//Domains zum auswählen für das Erzeugen von Pages
$array_domain = array ( 'ssi.at','wnn.at');

// DB - Connect
include ('../login/config_main.inc.php');

// Prüft ob Datebank existiert
if (! call_mysql_value ( "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$array_company['db_smartkit']}' " )) {
	echo "Datenbank {$array_company['db_smartkit']} ist nicht vorhanden, bitte anlegen!";
	exit ();
}

$new_db = $array_company['db_smartkit'];

if (call_company_option_single ( $company_id, 'db_smartkit' ) != $new_db) {
	
	foreach ($array_domain as $value) {
		$smart_domain .= $value."\n";
	}
	
	$array_company['smart_domains'] = $smart_domain;

	// Speichern der Default-Einstellungen;
	save_company_option ( $array_company, '1' );
	
	$GLOBALS['mysqli']->query ( "REPLACE INTO ssi_company.tbl_company SET 
		company_id = $company_id, 
		title = '{$array_company['title']}',
		matchcode = '{$array_company['matchcode']}',
		superuser_id = '{$array_company['superuser_id']}'
	" ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
	
	// Ersten User anlegen = SuperUser
	// Zentrales Anlegen des User (erstellt eindeutige ID für den User)
	$GLOBALS['mysqli']->query ( "REPLACE INTO ssi_company.user2company SET 
		company_id = $company_id, 
		user_name = '{$array_user['user_name']}', 
		user_id = '$user_id' ,
		firstname   = '{$array_user['firstname']}',
		secondname  = '{$array_user['secondname']}',
		user_name = '{$array_user['user_name']}',
		password  = '{$array_user['password']}',
		zip = '{$array_user['zip']}',
		street = '{$array_user['street']}',
		country = '{$array_user['country']}',
		city = '{$array_user['city']}',
		sex = '{$array_user['gender']}',
		verify_key = '$verify_key_new',
		superuser = 1,
		user_checked = '1',
		number_of_smartpage = '10',
		gender = '{$array_user['gender']}'


" ) or die ( mysql_error () );
	
	foreach ( $array_moduls as $key => $value ) {
		$GLOBALS['mysqli']->query ( "INSERT INTO ssi_company.module2company SET company_id = $company_id, module = '$value' " );
	}
	
	// $new_user_id = mysqli_insert_id ( $GLOBALS['mysqli'] );
	
	$verify_key_new = md5 ( uniqid ( rand (), TRUE ) );

	foreach ( $array_moduls as $key => $value ) {
		$GLOBALS['mysqli']->query ( "INSERT INTO $new_db.module2id_user SET user_id = $user_id, module = '$value' " );
	}
	// Setzt neuen User als Superuser
	save_company_option ( array ( 'superuser_id' => $user_id ), $company_id );
	// echo "Installation war erfolgreich";
	
	// Template anlegen
	$GLOBALS['mysqli']->query ( "INSERT INTO $new_db.smart_templates (`template_id`, `user_id`, `title`, `text`, `picture`, `timestamp`, `set_public`, `propose_public`, `url`) VALUES (50, $user_id, 'Wasser', '', '', '2017-04-19 18:31:53', 1, 0, 'v-water.ssi.at');" );
} else {
	// echo "Der Smart-Kit wurde bereits eingerichtet";
}

// Weiterleiten zum Login
$login_link = "../ssi_dashboard/index.php?user_name={$array_user['user_name']}&password={$array_user['password']}";
header ( "location: $login_link" );

