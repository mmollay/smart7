<?
if ($_POST ['update_id']) {

	$query = $GLOBALS ['mysqli']->query ( "SELECT module FROM ssi_company.module2company WHERE company_id = '{$_POST['update_id']}'  " );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$module_value [$array ['module']] = true;
		// $arr['value'][$array['module']] = true;
	}

	// include ('../../ssi_smart/php_functions/functions.php');

	// abrufen der Optionen
	$arr ['value'] = call_company_option ( $_POST ['update_id'] );
	$arr ['hidden']['update_id'] = $_POST ['update_id'];
	// $arr['sql'] = array ( 'query' => "SELECT * from ssi_company.tbl_company where company_id = '{$_POST['update_id']}'" );
}

$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_company','inline' => true );
$arr ['tab'] = array ('tabs' => [ "first" => "Allgemein","user" => "User","sec" => "Bild",'three' => "Module",'smtp' => "Maileinstellungen","agb" => "AGB" ] );

$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'message ui' );
$arr ['field'] ['service_offline'] = array ('tab' => 'first','type' => 'toggle','label' => 'Smart-Kit Service deaktivieren' );
$arr ['field'] ['service_offline_reason'] = array ('tab' => 'first','type' => 'input','label' => 'Grund' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );



$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' );
$arr ['field'] ['title'] = array ('tab' => 'first','type' => 'input','label' => 'Titel','validate' => true,'focus' => true );
$arr ['field'] ['matchcode'] = array ('tab' => 'first','type' => 'input','label' => 'Matchcode','validate' => true );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );
$arr ['field'] ['description'] = array ('tab' => 'first','type' => 'input','label' => 'Beschreibung' );
$arr ['field'] ['company_password'] = array ('tab' => 'first','type' => 'password','label' => 'Internes Passwort','validate' => true );
if ($_POST ['update_id'])
	$arr ['field'] ['new_password'] = array ('tab' => 'first','type' => 'checkbox','label' => 'Passwort neu setzen' );

$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' );
$arr ['field'] ['center_domain'] = array ('tab' => 'first','label' => 'Center - Domain','type' => 'input' );
if ($_POST ['update_id']) {
	$arr ['field'] ['superuser_id'] = array ('tab' => 'first','type' => 'input','label' => 'Superuser ID' );
}
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

$arr ['field'] ['smart_domains'] = array ('tab' => 'first','label' => 'Domains für Smartkit','type' => 'textarea' );
$arr ['field'] ['terms_and_conditions'] = array ('tab' => 'agb','label' => 'Allgemeine Geschäftsbedingungen','type' => 'ckeditor' );

$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' );
$arr ['field'] ['db_smartkit'] = array ('tab' => 'first','type' => 'input','label' => 'Datenbank (Smart-Kit)' );
$arr ['field'] ['db_newsletter'] = array ('tab' => 'first','type' => 'input','label' => 'Datenbank (Newsletter)' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

if (! $_POST ['update_id']) {
	$arr ['field'] ['user_email'] = array ('tab' => 'user','label' => 'Email (Login-User)','type' => 'input','validate' => true );
	$arr ['field'] ['user_password'] = array ('tab' => 'user','type' => 'password','label' => 'Passwort','validate' => true );
	$arr ['field'] [] = array ('tab' => 'user','type' => 'div','class' => 'fields' ); // 'label'=>'test'
	// $arr['field']['gender'] = array ( 'tab' => 'user' , 'id' => 'sex' , 'class' => 'four wide' , 'label' => 'Anrede' , 'type' => 'dropdown' , 'array' => $array_sex ,  'validate' => true );
	$arr ['field'] ['firstname'] = array ('tab' => 'user','class' => 'six wide','label' => 'firstname','type' => 'input','placeholder' => 'firstname','validate' => true );
	$arr ['field'] ['secondname'] = array ('tab' => 'user','class' => 'six wide','label' => 'secondname','type' => 'input','placeholder' => 'secondname','validate' => true );
	$arr ['field'] [] = array ('tab' => 'user','type' => 'div_close' );
}

$arr ['field'] ['img_logo'] = array ('tab' => 'sec','mode' => 'single','type' => 'uploader','upload_dir' => $upload_folder,'upload_url' => $upload_url );

foreach ( $str_array_modules as $key => $values ) {
	$arr ['field'] [$key] = array ('tab' => 'three','label' => $values,'id' => $key,'type' => 'toggle','array' => $array_user,'value' => $module_value [$key] );
}

$arr ['field'] [] = array ('tab' => 'smtp','type' => 'header','text' => 'Email','class' => 'red dividing' );
$arr ['field'] [] = array ('tab' => 'smtp','type' => 'div','class' => 'two fields' );
$arr ['field'] ['smtp_email'] = array ('tab' => 'smtp','label' => 'Von (Email)','type' => 'input','placeholder' => '@email' );
$arr ['field'] ['smtp_title'] = array ('tab' => 'smtp','label' => 'Von (Name)','type' => 'input','placeholder' => 'Firma oder Name' );
$arr ['field'] [] = array ('tab' => 'smtp','type' => 'div_close' );

$arr ['field'] [] = array ('tab' => 'smtp','type' => 'header','text' => 'SMTP-Server (optional)','class' => 'red dividing' );
$arr ['field'] [] = array ('tab' => 'smtp','type' => 'div','class' => 'three fields' );
$arr ['field'] [] = array ('tab' => 'smtp','id' => 'smtp_host','label' => 'Server','type' => 'input','placeholder' => '' );
$arr ['field'] [] = array ('tab' => 'smtp','id' => 'smtp_port','label' => 'Port','type' => 'dropdown','array' => array (587 => 587,465 => 465,25 => 25 ),'value' => 25 );
$arr ['field'] [] = array ('tab' => 'smtp','id' => 'smtp_secure','label' => 'Secure','type' => 'dropdown','array' => array ('' => 'keine','tls' => 'tls','ssl' => 'ssl' ),'value' => '' );
$arr ['field'] [] = array ('tab' => 'smtp','type' => 'div_close' );

$arr ['field'] [] = array ('tab' => 'smtp','type' => 'div','class' => 'two fields' );
$arr ['field'] [] = array ('tab' => 'smtp','id' => 'smtp_user','label' => 'User','type' => 'input' );
$arr ['field'] [] = array ('tab' => 'smtp','id' => 'smtp_password','label' => 'Passwort','type' => 'password' );
$arr ['field'] [] = array ('tab' => 'smtp','type' => 'div_close' );


