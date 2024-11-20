<?php
require_once '../../login/config_main.inc.php';
include ('../../ssi_smart/smart_form/include_form.php');
include ('../fu_virtualhost_generator.php');

if (! $_POST ['delete_id']) {
	$arr ['form'] = array ('keyboardShortcuts' => true );
	$arr ['ajax'] = array ('dataType' => "html",'success' => "if ( String(data) == String('ok') ) { $('.modal.ui').modal('hide'); table_reload(); } else alert(data);" );
	$arr ['hidden'] ['delete_id'] = $_POST ['update_id'];
	$arr ['hidden'] ['list_id'] = $_POST ['list_id'];
	$arr ['field'] [] = array ('id' => 'password','label' => 'Passwort','type' => 'password','placeholder' => 'Passwort','validate' => true,'focus' => true );
	$arr ['button'] ['submit'] = array ('value' => 'Löschen','color' => 'red' );
	$arr ['button'] ['close'] = array ('value' => 'Abbrechen','color' => 'gray','js' => "$('#modal_form_delete').modal('hide'); " );
	$output = call_form ( $arr );
	echo $output ['html'];
	echo $output ['js'];
	exit ();
}

// Password muss stimmen damit die Daten geloescht werden können
if (md5 ( $_POST ['password'] ) != $superuser_passwd) {
	echo "Passwort ist falsch!";
	return;
}

$delete_id = $_POST ['delete_id'];
$explode = explode ( ',', $delete_id );

switch ($_POST ['list_id']) {

	case 'ftp_list' :

		$query = $GLOBALS ['mysqli']->query ( "SELECT homedir,domain,domain_alias FROM ftpdb.ftpuser WHERE id = '$delete_id' " );
		$array = mysqli_fetch_array ( $query );
		$dirname = $array [0];
		$domain = $array [1];
		$domain_alias = $array ['domain_alias'];

		// Löscht Inhalte und Domain
		if (in_array ( $_SESSION ['user_id'], $_SESSION ['array_superuser_id'] )) {
			rm_domain ( $domain );
			//remove aliases
			$array_domainalias = explode ( "\n", $domain_alias );
			foreach ( $array_domainalias as $aliasDomain ) {
				$aliasDomain = trim ( $aliasDomain );
				rm_domain ( $aliasDomain );
			}
			$GLOBALS ['mysqli']->query ( "DELETE FROM ftpdb.ftpuser WHERE id = '$delete_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
			exec ( "rm -rf $dirname" );
		}
		break;

	case 'company_list' :
		$GLOBALS ['mysqli']->query ( "DELETE FROM ssi_company.tbl_company WHERE company_id = '$delete_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		$GLOBALS ['mysqli']->query ( "DELETE FROM ssi_company.comp_options WHERE company_id = '$delete_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		break;

	case 'template_list' :
		$query = $GLOBALS ['mysqli']->query ( "SELECT * from smart_templates WHERE template_id = '$delete_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		$array = mysqli_fetch_array ( $query );

		$url = $array ['url'];
		$set_public = $array ['set_public'];

		// Delete Folder
		if ($set_public) {
			exec ( "rm -rf $path_template/public/$delete_id/" );
			exec ( "rm $path_template/public/$url.jpg" );
		} else {
			exec ( "rm -rf $path_template/private/$delete_id/" );
			exec ( "rm $path_template/private/$url.jpg" );
		}

		$GLOBALS ['mysqli']->query ( "DELETE FROM smart_templates WHERE template_id = '$delete_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		break;

	case 'user_list' :

		include ('../function.php');
		foreach ( $explode as $_POST ['delete_id'] ) {
			$query = $GLOBALS ['mysqli']->query ( "SELECT followup_id FROM {$cfg_mysql['db_nl']}.followup WHERE user_id = '$delete_id' " ) or die ( mysqli_error () );
			while ( $array = mysqli_fetch_array ( $query ) ) {
				$followup_id = $array ['followup_id'];
				$array_delstructure = array ('followup_id' => array ("followup","f_action2followup","f_action2tag","f_trigger2tag","f_trigger2time","f_trigger2listbuilding","f_trigger2mail",'f_trigger2followup',"f_mail2followup" => array ('mail_id' => array ("followup_mail" ) ) ) );
				call_structure ( $array_delstructure, $followup_id, $cfg_mysql ['db_nl'] );
			}

			$array_delstructure = array (
					'user_id' => array ("amazon_order","blacklist","formular_design","sender","setting","templates","verification","link","followup_pool","promotion" => array ('promotion_id' => array ("code" ) ),"contact" => array ('contact_id' => array ("client_logfile" ) ),
							"formular" => array ('form_id' => array ("formular2tag" ) ),"tag" => array ('tag_id' => array ("link2tag","tag2tag","contact2tag" ) ),
							"session" => array ('session_id' => array ("logfile","session_logfile","user_logfile","landingpage" => array ("landingpage_id" => array ("contact_id2landingpage_id" ) ) ) ) ) );
			call_structure ( $array_delstructure, $delete_id, $cfg_mysql ['db_nl'] );
			include ('../inc/ajax_deluser.php');
			$GLOBALS ['mysqli']->query ( "DELETE FROM ssi_company.user2company WHERE user_id = '$delete_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		}

		break;

	case 'domain_list' :
		foreach ( $explode as $_POST ['delete_id'] ) {
			include ('../inc/ajax_deldomain.php');
		}

		break;

	case 'constructor_list' :
		include ('../inc/ajax_deldomain_constructor.php');
		break;

	case 'profile_list' :
		$GLOBALS ['mysqli']->query ( "DELETE FROM smart_user_right where right_id = '$delete_id' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		break;
}
echo "ok";