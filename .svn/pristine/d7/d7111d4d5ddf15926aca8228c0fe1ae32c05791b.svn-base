<?
if ($_POST ['update_id']) {
	$arr ['sql'] = array ('query' => "SELECT * from usrdb_intubspe.user WHERE user_id = '{$_POST['update_id']}' " );
}

$arr ['field'] ['email'] = array ('type' => 'input','label' => "Email",'validate' => 'email','placeholder' => '@email','focus' => true );
$arr ['field'] ['nickname'] = array ('type' => 'input','label' => "Nickname" );
$arr ['field'] ['password'] = array ('type' => 'password','label' => "Passwort",'validate' => 'password' );

$arr ['field'] ['password'] = array ('type' => 'password','label' => 'Passwort','class' => 'ten wide' );

if ($_POST ['update_id']) {
	$arr ['field'] ['new_password'] = array ('type' => 'checkbox','label' => 'Passwort neu setzen' );
}

$arr ['field'] ['level'] = array ('type' => 'dropdown','label' => "Level",'array' => array ('1' => 'Level 1','2' => 'Level 2','3' => 'Level 3' ),'value_default' => '1' );

