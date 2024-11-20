<?php


/*
 * page_contact.php - SSI NEWSLETTER: SEMANTICU - UI
 * @author Martin Mollay
 * @last-changed 2015-05-22
 */
session_start ();
include ('../../ssi_smart/smart_form/include_form.php');
include ('../../login/config_main.inc.php');

if (! $_POST ['update_id']) {
	$upload_folder = "$document_root/company/temp/";
	$upload_url = '../company/temp/';
} else {
	$upload_folder = "$document_root/company/" . $_POST ['update_id'] . "/";
	$upload_url = "../company/" . $_POST ['update_id'] . "/";
}

if (! is_dir ( "$document_root/" )) {
	mkdir ( "$document_root/" );
}
if (! is_dir ( "$document_root/company/" )) {
	mkdir ( "$document_root/company/" );
}
if (! is_dir ( $upload_folder )) {
	mkdir ( $upload_folder );
}

switch ($_POST ['list_id']) {

	// Rechnung bearbeiten
	case 'domain_list' :
		include ('../form/f_domain.php');
		break;

	case 'ftp_list' :
		include ('../form/f_ftp.php');
		break;

	case 'template_list' :
		$arr ['sql'] = array ('query' => "SELECT * from smart_templates where template_id = '{$_POST['update_id']}'" );
		$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_template','size' => 'small' );
		$arr ['field'] ['title'] = array ('type' => 'input','label' => 'Titel','focus' => true );
		$arr ['field'] ['url'] = array ('type' => 'input','label' => 'Webadresse' );
		$arr ['field'] ['text'] = array ('type' => 'textarea','label' => 'Beschreibung' );
		if (in_array ( $_SESSION ['user_id'], $_SESSION ['array_superuser_id'] )) {
			$arr ['field'] ['set_public'] = array ('type' => 'checkbox','label' => 'auf Public setzen' );
		}

		break;

	case 'company_list' :

		include ('../form/f_company.php');
		break;

	case 'user_list' :
		include ('../form/f_user.php');
		break;

	case 'constructor_list' :

		$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_edit_constructor','size' => 'small' );
		$arr ['sql'] = array ('query' => "SELECT page_id, page_locked, domain, domain_alias from tbl_domain where page_id = '{$_POST['update_id']}' " );
		$arr ['field'] ['page_locked'] = array ('type' => 'toggle','label' => 'Webseite sperren' );
		$arr ['field'] ['domain'] = array ('label' => 'Domain','type' => 'input' );
		$arr ['field'] ['domain_alias'] = array ('label' => 'Aliases','type' => 'textarea' );
		breaK;

	case 'profile_list' :
		include ('../form/f_profile.php');
		break;
}

// $arr['hidden']['update_id'] = $_POST['update_id'];
$arr ['ajax'] = array ('success' => "if (data == 'ok') { $('.modal').modal('hide'); table_reload(); } else { alert(data); }",'dataType' => "html" );
$arr ['hidden'] ['list_id'] = $_POST ['list_id'];
$arr ['hidden'] ['update_id'] = $_POST ['update_id'];
$arr ['button'] ['submit'] = array ('value' => 'Speichern','color' => 'blue' );
$arr ['button'] ['close'] = array ('value' => 'Abbrechen','color' => 'gray','js' => "$('.modal').modal('hide'); " );
$output = call_form ( $arr );
echo $output ['html'];
echo $output ['js'];
echo $add_js;