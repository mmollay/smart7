<?php 
// Call User_ID
$query2 = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_company.user2company order by user_id " )or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
while ( $array2 = mysqli_fetch_array ( $query2 ) ) {
	$array_user_id = $array2 ['user_id'];
	$array_firstname = $array2 ['firstname'];
	$array_sescondname = $array2 ['secondname'];
	$array_email = $array2 ['user_name'];
	$array_user [$array_user_id] = "$array_user_id - $array_email ($array_firstname $array_sescondname)";
}

$arr ['sql'] = array ('query' => "SELECT * from ftpdb.ftpuser where id = '{$_POST['update_id']}'" );
$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_ftp','size' => 'small' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' );
$arr ['field'] ['title'] = array ('type' => 'input','label' => 'Bezeichnung' );
$arr ['field'] ['user_id'] = array ('type' => 'dropdown','class' => 'search','label' => 'User','array' => $array_user,'validate' => true );
$arr ['field'] [] = array ('type' => 'div_close' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'two fields' );
$arr ['field'] ['userid'] = array ('type' => 'input','label' => 'Username (Email)' );
$arr ['field'] ['passwd'] = array ('type' => 'input','label' => 'Passwort' );
$arr ['field'] [] = array ('type' => 'div_close' );
$arr ['field'] ['homedir'] = array ('type' => 'input','label' => 'Home-Verzeichnis (absoluter Pfad)' );
$arr ['field'] ['page_locked'] = array ('type' => 'toggle','label' => 'Webseite sperren' );
$arr ['field'] ['set_ssl'] = array ('type' => 'toggle','label' => 'SSL-aktivieren','info' => 'Die Domain muss verifiert sein' );
$arr ['field'] ['set_new_ssl'] = array ('type' => 'checkbox','label' => 'SSL-Configs neu setzen', 'info'=>'Dies kann man machen wenn neue Aliase dazugekommen sind');
// $arr['field']['set_subdomain'] = array ( 'type' => 'toggle' , 'label' => 'Domain ist Sub-Domain (ohne www)' );
$arr ['field'] ['domain'] = array ('label' => 'Domain (ohne www angeben)','type' => 'input','focus' => true );
$arr ['field'] ['domain_alias'] = array ('label' => 'Domain-Aliases (ohne www angeben)','type' => 'textarea' );
$arr ['field'] ['domain_forwarding'] = array ('label' => 'Domain(s) weiterleiten an','type' => 'input','placeholder' => 'https://' );
?>