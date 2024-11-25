<?php
// Zugangsdaten fuer die Datenbank
// 28.11.2022 - set defaultvalues vor INT(1) - save domain

include ('../../login/config_main.inc.php');
include ('../fu_virtualhost_generator.php');

foreach ($_POST as $key => $value) {
    
	if ($value) {
        $GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string($value);
    }
}

check_mysql_insert("SELECT COUNT(*) FROM ssi_company.comp_options WHERE option_name='superuser_id' AND option_value = '{$_SESSION['user_id']}' AND company_id = '{$_SESSION['company_id']}'", "Update der ssi_company.comp_options Datenbank");

$user_checked = $_POST['user_checked']; // muss so übergeben werden, da im Hintergrund der Parameter gesetzt wird

switch ($_POST['list_id']) {

    /**
     * ****************************************************************
     * Speichert Eintrag in die gloabele "ssi_company" Domainverwaltung 2018
     * ****************************************************************
     */
    case 'domain_list':
        $domain_id = $_POST['update_id'];
        $set_domain_alias = $_POST['domain_alias'];

        $domain = str_replace(' ', '', $domain);
        $set_domain_alias = str_replace(' ', '', $set_domain_alias);

        // Setzt Domain für Änderung auf set_change
        $GLOBALS['mysqli']->query("UPDATE ssi_company.domain SET set_change = 1 WHERE domain_id = '$domain_id' ") or die(mysql_error());

        // Prüft ob Domain bereits existiert
        $query_count = $GLOBALS['mysqli']->query("SELECT * FROM ssi_company.domain WHERE domain = '$domain' AND set_change = 0 ") or die(mysqli_error($GLOBALS['mysqli']));
        $domain_exists = mysqli_num_rows($query_count);
        if ($domain_exists) {
            $GLOBALS['mysqli']->query("UPDATE ssi_company.domain SET set_change = 0 WHERE domain_id = '$domain_id' ") or die(mysql_error());
            echo "Domain $domain existiert bereits!";
            exit();
        }

        // Wenn Domain noch nicht verwendet wird, werden Sub-Domains überrpüft

        // Setzt Domain-Aliases auf set_change
        $GLOBALS['mysqli']->query("UPDATE ssi_company.domain SET set_change = 1 WHERE parent_id = '$domain_id' ") or die(mysql_error());
        $array_domain_alias = preg_split('/\n/', $set_domain_alias);
        // Domain-Aliase überprüfen
        foreach ($array_domain_alias as $domain_alias) {
            $domain_alias = trim($domain_alias);
            $domain_alias = rtrim($domain_alias);
            if ($domain_alias) {
                $ii ++;
                $query_count = $GLOBALS['mysqli']->query("SELECT * FROM ssi_company.domain WHERE domain = '$domain_alias' AND set_change = 0 ") or die(mysqli_error($GLOBALS['mysqli']));
                $domain_alias_exists = mysqli_num_rows($query_count);
                if ($domain_alias_exists) {
                    $GLOBALS['mysqli']->query("UPDATE ssi_company.domain SET set_change = 0 WHERE parent_id = '$domain_id' ") or die(mysql_error());
                    echo "Domain $domain_alias existiert bereits!";
                    exit();
                } else
                    $save_domain_alias[$set_domain_alias] = $domain_alias;
            }
        }
        
        if (!$set_ssl) $set_ssl = 0;
        if (!$set_subdomain) $set_subdomain = 0;
        if (!$locked) $locked = 0;
        
        // Wenn Domain und Domain-Aliases eindeutig sind, dann werden die Werte gespeichert und der Change Mode zurückgesetzt
        $GLOBALS['mysqli']->query("
		UPDATE ssi_company.domain SET
			domain = '$domain',
			forwarding = '$domain_forwarding',
			set_ssl = '$set_ssl',
			set_subdomain = '$set_subdomain',
			set_change = 0,
			domain_forwarding = '$domain_forwarding',
			locked  = '$locked'
				WHERE domain_id = '$domain_id'
			") or die(mysqli_error($GLOBALS['mysqli']));
        
        // Löschen der Aliases für den Neueintrag vorbereiten
        $GLOBALS['mysqli']->query("DELETE FROM ssi_company.domain WHERE parent_id = '$domain_id' AND user_id = 0 AND set_change = 1 ") or die(mysql_error());

        // Domain - Alias(es) werden gespeichert
        foreach ($array_domain_alias as $domain_alias) {
            if ($domain_alias) {
                $domain_alias = $GLOBALS['mysqli']->real_escape_string($domain_alias);
                $GLOBALS['mysqli']->query("INSERT ssi_company.domain SET domain = '$domain_alias', parent_id = '$domain_id' ") or die(mysqli_error($GLOBALS['mysqli']));
            }
        }

        if ($domain)
            fu_virtualhost_generator($company_id);

        break;

    case 'ftp_list':
        // user datei anlegen wenn nicht vorhanden
        if (! is_dir($_SESSION['path_user_absolute'])) {
            exec("mkdir " . $_SESSION['path_user_absolute']);
        }

        // ftp-Dir anlegen wenn nicht vorhanden
        if (! is_dir($_SESSION['path_user_absolute'] . "/ftp")) {
            exec("mkdir " . $_SESSION['path_user_absolute'] . "/ftp");
        }

        // if (preg_match ( "[/http-public|/var]", $homedir )) {
        $set_homedir = $homedir;
        // }

        // } else
        // $set_homedir = $_SESSION ['path_user_absolute'] . "/ftp/" . $homedir;

        // if (! is_dir ( $homedir ))
        // exec ( "mkdir $homedir" );

        $domain = str_replace(' ', '', $domain);
        $domain_alias = str_replace(' ', '', $domain_alias);
        $userid = str_replace(' ', '', $userid);

        // UPDATE
        if ($_POST['update_id']) {
            $GLOBALS['mysqli']->query("UPDATE ftpdb.ftpuser SET
			userid = '$userid',
			passwd = '$passwd',
			homedir = '$set_homedir',
			set_ssl = '$set_ssl',
			set_subdomain = '$set_subdomain',
			title = '$title',
			user_id = '$user_id',
			page_locked = '$page_locked',
			domain = '$domain',
			domain_alias = '$domain_alias'
			WHERE id = '{$_POST['update_id']}'
			") or die(mysqli_error($GLOBALS['mysqli']));
            $last_insert_id = $_POST['update_id'];
        } else {
            // NEW
            $GLOBALS['mysqli']->query("INSERT INTO ftpdb.ftpuser SET
			userid = '$userid',
			passwd = '$passwd',
			homedir = '$set_homedir',
			set_ssl = '$set_ssl',
			set_subdomain = '$set_subdomain',
			uid = '1002',
			gid = '1002',
			title = '$title',
			user_id = '$user_id',
			page_locked = '$page_locked',
			shell = '/bin/false',
			domain = '$domain',
			domain_alias = '$domain_alias'
			") or die(mysqli_error($GLOBALS['mysqli']));
            $last_insert_id = mysqli_insert_id($GLOBALS['mysqli']);
        }

        if ($domain)
            fu_ftp_virtualhost_creator($last_insert_id);
        break;

    case 'template_list':
        if ($set_public) {
            // Verschiebun der Explorerdaten
            exec("mv $path_template" . "private/$update_id $path_template" . "public/");
            // Setzen der Parameter auf in der Datenbank
            $GLOBALS['mysqli']->query("UPDATE smart_templates SET set_public = 1 WHERE template_id = $update_id LIMIT 1") or die(mysqli_error($GLOBALS['mysqli']));
        } else {
            // Verschiebun der Explorerdaten
            exec("mv $path_template" . "public/$update_id $path_template" . "private/");
            // Setzen der Parameter auf in der Datenbank
            $GLOBALS['mysqli']->query("UPDATE smart_templates SET set_public = 0 WHERE template_id = $update_id LIMIT 1") or die(mysqli_error($GLOBALS['mysqli']));
        }

        if ($update_id)
            $GLOBALS['mysqli']->query("UPDATE smart_templates SET
					title = '$title',
					text = '$text',
					url = '$url'
					WHERE template_id = '$update_id' LIMIT 1") or die(mysqli_error($GLOBALS['mysqli']));
        break;

    case 'company_list':

    	
    	
        // check_mysql_insert ( "SELECT COUNT(*) FROM ssi_company.user2company WHERE user_id = '{$_SESSION['user_id']}' AND company_id = '$update_id' " );
        $array_option_fields = array('matchcode' => $matchcode,'service_offline' => $service_offline,'service_offline_reason' => $service_offline_reason,'title' => $title,'description' => $description,'center_domain' => $center_domain,'db_newsletter' => $db_newsletter,'db_smartkit' => $db_smartkit,'smart_domains' => $smart_domains,'img_logo' => $img_logo,'superuser_id' => $superuser_id,'terms_and_conditions' => $terms_and_conditions,'smtp_email' => $smtp_email,'smtp_title' => $smtp_title,'smtp_host' => $smtp_host,'smtp_user' => $smtp_user,'smtp_password' => $smtp_password,'smtp_port' => $smtp_port,'smtp_secure' => $smtp_secure);

        if (! call_mysql_value("SELECT option_value FROM ssi_company.comp_options WHERE option_name='verify_key' AND company_id = '{$_POST['update_id']}' ")) {
            // Add verifyKey
            $_POST['verify_key'] = md5(uniqid(rand(), TRUE));
            $array_option_fields['verify_key'] = 'verify_key';
        }
        
        if ($_POST['update_id']) {

            // Wenn neues Passwort gesetzt werden soll
            if ($new_password) {
                $company_password = $_POST['company_password'] = md5($_POST['company_password']);
                $array_option_fields['company_password'] = 'company_password';
            }
            save_company_option($array_option_fields, $update_id);
        } else {

            exec("mv $path_template" . "private/$update_id $path_template" . "public/");

            $company_password = $_POST['company_password'] = md5($_POST['company_password']);
            $array_option_fields['company_password'] = 'company_password';

            $GLOBALS['mysqli']->query("INSERT INTO ssi_company.tbl_company SET matchcode = '$matchcode'  ") or die(mysqli_error($GLOBALS['mysqli']));

            $update_id = $smart_company_id = mysqli_insert_id($GLOBALS['mysqli']);

            $new_db = "ssi_smart$smart_company_id";

            // Prüft ob DB existiert
            if (! call_mysql_value("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$new_db' ")) {
                echo "Datenbank $new_db nicht vorhanden, bitte anlegen!";
                exit();
            }

            save_company_option($array_option_fields, $update_id);

            $verify_key_new = md5(uniqid(rand(), TRUE));

            // Ersten User anlegen = SuperUser
            // Zentrales Anlegen des User (erstellt eindeutige ID für den User)
            $GLOBALS['mysqli']->query("INSERT INTO ssi_company.user2company SET
			company_id = '{$_SESSION['company_id']}',
			firstname   = '$firstname',
			secondname  = '$secondname',
			gender = '$gender',
			user_name = '$user_email',
			password  = '$user_password',
			zip = '$zip',
			street = '$street',
			country = '$country',
			verify_key = '$verify_key_new',
			user_checked = '1',
			gender = '$gender'
			") or die(mysqli_error($GLOBALS['mysqli'])); // if 1 then show just SMART-Kit

            $new_user_id = mysqli_insert_id($GLOBALS['mysqli']);

            $GLOBALS['mysqli']->query("INSERT INTO $new_db.module2id_user SET user_id = $new_user_id, module = 'smart' ");
            $GLOBALS['mysqli']->query("INSERT INTO $new_db.module2id_user SET user_id = $new_user_id, module = 'userlist' ");

            // Setzt neuen User als Superuser
            $superuser_id = $new_user_id;
            save_company_option(array('superuser_id'), $smart_company_id);
        }

        // Speichern der Module
        foreach ($str_array_modules as $key => $values) {
            if ($_POST[$key])
                $GLOBALS['mysqli']->query("REPLACE INTO ssi_company.module2company SET module='$key', company_id ='$update_id'") or die(mysqli_error($GLOBALS['mysqli']));
            else
                $GLOBALS['mysqli']->query("DELETE from ssi_company.module2company where module='$key' AND company_id ='$update_id'") or die(mysqli_error($GLOBALS['mysqli']));
        }

        break;
    /**
     * *******************************************************************************
     * GROUP - FORM 2
     * *******************************************************************************
     */
    case 'user_list':

        // Check ob Email bereits genutzt wird
        $query = $GLOBALS['mysqli']->query("SELECT user_name FROM ssi_company.user2company 
				WHERE user_name = '$user_name' 
				AND (user_id='' OR user_id != '$update_id') 
				AND company_id = '{$_SESSION['company_id']}'
				") or die(mysqli_error($GLOBALS['mysqli']));
        $fetch_array = mysqli_fetch_array($query);
        if ($fetch_array[0]) {
            echo "Username wird bereits verwendet";
            exit();
        }

        // Passwort neu setzen wenn Checkbox aktiviert wurde
        if ($new_password) {
            $password = md5($password);
            $GLOBALS['mysqli']->query("UPDATE ssi_company.user2company SET password = '$password' WHERE user_id = '$update_id' ") or die(mysqli_error($GLOBALS['mysqli']));
        }

        // Verhindert, dass andere Superuser in Datenbank anlegen können
        if (! in_array($_SESSION['user_id'], $_SESSION['array_superuser_id'])) {
            $superuser = 0;
        }

        if (! is_dir($_SESSION['path_user_absolute'])) {
            exec("mkdir " . $_SESSION['path_user_absolute']);
        }

        if (! $right_id)
            $right_id = 0;
        if (! $parent_id)
            $parent_id = 0;
        if (! $superuser)
            $superuser = 0;
        if (! $locked)
            $locked = 0;
        // Add new User
        if (! $update_id) {

            $verify_key_new = md5(uniqid(rand(), TRUE));
            $GLOBALS['mysqli']->query("INSERT INTO ssi_company.user2company SET
			company_id = '{$_SESSION['company_id']}',
			user_name  = '$user_name',
			firstname    = '$firstname',
			secondname   = '$secondname',
			gender = '$gender',
            locked     = '$locked',
			zip = '$zip',
			city = '$city',
			street = '$street',
			country = '$country',
			right_id   = '$right_id',
			parent_id  = '$parent_id',
			user_checked = '$user_checked',
			verify_key = '$verify_key_new',
			superuser = '$superuser',
			password = '$password',
			number_of_smartpage     = '{$_POST['number_of_smartpage']}'
			") or die(mysqli_error($GLOBALS['mysqli']));
            // Bestehende Daten des Users speichern

            $update_id = mysqli_insert_id($GLOBALS['mysqli']);

            // Update new User
        } else {
            $locked = 0;
            $GLOBALS['mysqli']->query("UPDATE ssi_company.user2company SET
			smart_version = '$smart_version',
			user_name  = '$user_name',
			firstname    = '$firstname',
			secondname   = '$secondname',
			gender = '$gender',
			zip = '$zip',
			city = '$city',
			street = '$street',
			country = '$country',
			locked     = '$locked',
			right_id   = '$right_id',
			parent_id  = '$parent_id',
			user_checked = '$user_checked',
			superuser = '$superuser',
			number_of_smartpage     = '{$_POST['number_of_smartpage']}'
			WHERE user_id = '$update_id'
			") or die(mysqli_error($GLOBALS['mysqli']));
        }

        // Speichern der Module
        foreach ($str_array_modules as $key => $values) {

            if ($_POST[$key])
                $GLOBALS['mysqli']->query("REPLACE INTO module2id_user SET module='$key', user_id ='$update_id'") or die(mysqli_error($GLOBALS['mysqli']));
            else
                $GLOBALS['mysqli']->query("DELETE from module2id_user where module='$key' AND user_id ='$update_id'") or die(mysqli_error($GLOBALS['mysqli']));
        }
        // fu_virtualhost_generator ( $company_id );
        break;

    case 'profile_list':

        // Change Domainsettings
        $GLOBALS['mysqli']->query("REPLACE INTO smart_user_right SET
		right_id = '$update_id',
		user_id  = '$user_id',
		title = '$title',
		max_number_sites = '$max_number_sites',
		right_edit_profile = '$right_edit_profile',
		right_edit_profile_head = '$right_edit_profile_head',
		right_edit_layout_menu  = '$right_edit_layout_menu',
		right_edit_text = '$right_edit_text',
		right_set_public_page = '$right_set_public_page',
		right_edit_modules = '$right_edit_modules',
		right_edit_layer = '$right_edit_layer',
		right_analytics = '$right_analytics',
		right_edit_main_options = '$right_edit_main_options',
		right_edit_site_options = '$right_edit_site_options',
		right_edit_templates = '$right_edit_templates',
		right_edit_allsites = '$right_edit_allsites',
		right_edit_head = '$right_edit_head',
		right_edit_foot = '$right_edit_head',
		right_div_sort  = '$right_div_sort',
		right_div_remove = '$right_div_remove',
		right_edit_menu = '$right_edit_menu',
		right_use_module_dynamic = '$right_use_module_dynamic'
		") or die(mysqli_error($GLOBALS['mysqli']));
        break;
}

if (! $error)
    echo "ok";
else
    echo "error";
?>