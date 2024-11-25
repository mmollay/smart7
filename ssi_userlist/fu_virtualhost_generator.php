<?php
$documentRootBase = "/var/www";

/**
 * ******************************************************
 * Erzeugt eine Datei - VirtualHost und ladet die Apache-Conf neu
 * Martin Mollay am 16.02.2018
 * ******************************************************
 */
// function fu_virtualhost_generator($company_id)
// {
//     $document_root = "/var/www/ssi";

//     // Auslesen von Matchcode für die Erzeugung der Struktur (DIR)
//     $company = call_company_option_single($company_id, 'matchcode');

//     $query_domain = $GLOBALS['mysqli']->query("SELECT * FROM ssi_company.domain WHERE company_id = '$company_id' ") or die(mysqli_error($GLOBALS['mysqli']));
//     while ($array = mysqli_fetch_array($query_domain)) {

//         $domain_alias = array();
//         $domain_id = $array['domain_id'];
//         $page_id = $array['page_id'];
//         $user_id = $array['user_id'];
//         $domain = $array['domain'];
//         $page_locked = $array['locked'];
//         $set_ssl = $array['set_ssl'];
//         $documentRoot = $document_root . "/smart_users/$company/user$user_id/page$page_id";

//         // Aliases aufrufen
//         $query = $GLOBALS['mysqli']->query("SELECT * FROM ssi_company.domain WHERE parent_id = '$domain_id' ") or die(mysqli_error($GLOBALS['mysqli']));
//         while ($fetch_alias = mysqli_fetch_array($query)) {
//             $domain_alias[] = $fetch_alias['domain'];
//         }

//         $array_virtual['domain'] = $domain;
//         $array_virtual['documentRoot'] = $documentRoot;
//         $array_virtual['set_ssl'] = $set_ssl;
//         $array_virtual['page_locked'] = $page_locked;
//         $array_virtual['AddDomain301'] = $domain_alias;

//         call_virtual_conf_file($array_virtual);
//     }

//     cron_job_befehl("/etc/init.d/apache2 reload");
// }

function fu_virtualhost_generator($company_id)
{
    
    $document_root = "/var/www/ssi";

    // Auslesen von Matchcode für die Erzeugung der Struktur (DIR)
    $company = call_company_option_single($company_id, 'matchcode');

    $stmt = $GLOBALS['mysqli']->prepare("
        SELECT d1.*, d2.domain AS alias
        FROM ssi_company.domain d1
        LEFT JOIN ssi_company.domain d2
        ON d1.domain_id = d2.parent_id
        WHERE d1.company_id = ?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($array = mysqli_fetch_assoc($result)) {
        $domain_alias = array_filter(explode("\n", $array['alias']));
        $domain = $array['domain'];
        $page_locked = $array['locked'];
        $set_ssl = $array['set_ssl'];
        $documentRoot = "{$document_root}/smart_users/{$company}/user{$array['user_id']}/page{$array['page_id']}";

        $array_virtual = ['domain' => $domain,'documentRoot' => $documentRoot,'set_ssl' => $set_ssl,'page_locked' => $page_locked,'AddDomain301' => $domain_alias];

        call_virtual_conf_file($array_virtual);
    }

    cron_job_befehl("/etc/init.d/apache2 reload");
}


// FTP - Verbindungen erzeugen
function fu_ftp_virtualhost_creator($last_insert_id = false)
{
    $document_root = "/var/www/ssi";

    $sql = "SELECT * from ftpdb.ftpuser WHERE domain != '' ";
    $query = $GLOBALS['mysqli']->query($sql) or die(mysqli_error($GLOBALS['mysqli']));
    while ($array = mysqli_fetch_array($query)) {

        $domain = $array['domain'];
        $page_locked = $array['page_locked'];
        $title = $array['title'];
        $set_ssl = $array['set_ssl'];
        $domain_alias = $array['domain_alias'];

        // Wenn User vorhanden ist
        // if ($user_id) {
        // $user_id = $array ['user_id'];
        // $documentRoot = $document_root . "/smart_users/ssi/user$user_id/ftp/" . $array ['homedir'];
        // } else {
        $documentRoot = $array['homedir'] . "/";
        // }

        $array_domainalias = explode("\n", $domain_alias);

        // wird bei erzeugung von virtual_conf benötigt für die neuerzeugung der SSL
        if ($array['id'] == $last_insert_id)
            $array_virtual['last_edit_domain'] = $domain;

        $array_virtual['domain'] = $domain;
        $array_virtual['documentRoot'] = $documentRoot;
        $array_virtual['set_ssl'] = $set_ssl;
        $array_virtual['page_locked'] = $page_locked;
        $array_virtual['AddDomain301'] = $array_domainalias;

        call_virtual_conf_file($array_virtual);
    }

    cron_job_befehl("/etc/init.d/apache2 reload");
}

// function kopiert Inhalte in eine Datei
function f_copy_file($pfad, $inhalt)
{
    exec("touch $pfad");

    file_put_contents($pfad, $inhalt) or die("Unable to write file!");

    // $fp = fopen ( $pfad, "w+" ) or die (error_get_last());
    // @fwrite ( $fp, $inhalt );
    // @fclose ( $fp );
}

// prueft ob cron_job-befehl schon vorhanden ist
function cron_job_befehl($befehl, $no_check = FALSE)
{
    $cron_file = '/var/www/ssi/cron/cron_file.txt';

    if (! is_file($cron_file)) {
        exec("touch $cron_file");
        return;
    }

    if (! $befehl)
        return;

    // remove /etc/init.d/apache2 reload
    $content = file_get_contents($cron_file);
    $content = preg_replace('[/etc/init.d/apache2 reload\n]', '', $content);

    file_put_contents($cron_file, $content);

    if (! $no_check) { // Wenn $check = 1 dann wird nicht ueberprueft ob Eintrag gebreits vorhanden ist

        if (file_exists($cron_file))
            $lines2 = file($cron_file);
        else
            die("Pfad $cron_file existiert nicht");

        foreach ($lines2 as $line_num => $line) {
            if (preg_match("[$befehl]", $line)) {
                $no_reload_value = TRUE;
            }
        }
    }

    if (! $no_reload_value) {
        $fp2 = fopen($cron_file, "a+");
        fwrite($fp2, "$befehl\n");
        fclose($fp2);
        $info_text = $str999AdmMsgReload[1];
    } else
        return TRUE; // wenn Befehl vorhanden
}

/**
 * ***********************************
 * Erzeugt Fileinhalte "DOMAIN.conf"
 * ***********************************
 */
function call_virtual_conf_file($array, $edit_domain = false)
{
    $extract = new LayerShifter\TLDExtract\Extract();
    global $documentRootBase;

    // Erzeugt Aliaslinks
    $domain_alias = $array['AddDomain301'];
    if (is_array($domain_alias)) {
        foreach ($domain_alias as $aliasDomain) {
            $aliasDomain = trim($aliasDomain);

            if ($aliasDomain) {
                $AddCertbot .= " -d www.$aliasDomain -d $aliasDomain";
                $AddDomain301_2 .= "  ServerAlias www.$aliasDomain\n";
                $AddDomain301_2 .= "  ServerAlias $aliasDomain\n";
                $AddDomain301 .= "  RewriteCond %{SERVER_NAME} =www.$aliasDomain [OR]\n";
                $AddDomain301 .= "  RewriteCond %{SERVER_NAME} =$aliasDomain [OR]\n";
            }
        }
    }

    $last_edit_domain = $array['last_edit_domain'];
    $domain = $array['domain'];
    $documentRoot = $array['documentRoot'];
    $set_ssl = $array['set_ssl'];
    $page_locked = $array['page_locked'];
    $documentRoot = rtrim($documentRoot, '/') . '/';

    // Wenn Page gesperrt wurde
    if ($page_locked) {
        $documentRoot = $documentRootBase . "/pages/locked.php";
    }

    // Prüft ob es sich um ein Subdomain handelt
    $result = $extract->parse($domain);
    $subdomain = $result->getSubdomain();

    $virtual_host = "# Is automatically generated by SmartKit\n";
    $virtual_host .= "# Date:" . date('m/d/Y h:i:s a', time()) . "\n";
    $virtual_host .= "\n";
    $virtual_host .= "<VirtualHost *:80>\n";

    if ($subdomain) {
        $virtual_host .= "  ServerName $domain\n";
        $virtual_host .= "  ServerAlias www.$domain\n";
        $SERVER_NAME = $domain;
    } else {
        $virtual_host .= "  ServerName www.$domain\n";
        $virtual_host .= "  ServerAlias $domain\n";
        $SERVER_NAME = "www." . $domain;
    }

    $virtual_host .= $AddDomain301_2;

    $virtual_host .= "  DocumentRoot $documentRoot\n";
    $virtual_host .= "  CustomLog /var/log/apache2/$domain combined\n";

    if ($set_ssl) {
        $virtual_host .= "  RewriteEngine on\n";
        $virtual_host .= "  RewriteCond %{REQUEST_URI} ^/admin\n";
        $virtual_host .= "  RewriteRule ^(.*)$ https://center.ssi.at [L,R=301]\n";
        
        $virtual_host .= $AddDomain301;

        // Bei SSL wird die Domain weitergeleitet auf https://
        $virtual_host .= "  RewriteCond %{SERVER_NAME} =www.$domain [OR]\n";
        $virtual_host .= "  RewriteCond %{SERVER_NAME} =$domain\n";
        $virtual_host .= "  RewriteRule ^ https://$SERVER_NAME%{REQUEST_URI} [END,QSA,R=permanent]\n";
    } else {
        $virtual_host .= "  RewriteEngine on\n";
        $virtual_host .= $AddDomain301;
        // Bei normaler Domain werden alle aliase an die Hauptdomain weitergeleitet
        if ($subdomain) {
            $virtual_host .= "  RewriteCond %{SERVER_NAME} =www.$domain\n";
        } else {
            $virtual_host .= "  RewriteCond %{SERVER_NAME} =$domain\n";
        }
        $virtual_host .= "  RewriteRule ^ http://$SERVER_NAME%{REQUEST_URI} [END,QSA,R=permanent]\n";
    }

    $virtual_host .= "</VirtualHost>\n\n";

    $virtual_host .= "<Directory $documentRoot>\n";
    $virtual_host .= "  Options Indexes FollowSymLinks ExecCGI Includes\n";
    $virtual_host .= "  AllowOverride All\n";
    $virtual_host .= "  Order allow,deny\n";
    $virtual_host .= "  Allow from all\n";
    $virtual_host .= "</Directory>\n\n";

    $VirtualConfPath = "/etc/apache2/sites-available/$domain.conf";
    $VirtualSslConfPath = "/etc/apache2/sites-available/$domain" . "-le-ssl.conf";
    // Speichert die neue Config Datei
    f_copy_file($VirtualConfPath, $virtual_host);

    // Wenn Domain nicht existiert im Apache wird diese "enabled"
    // if (! file_exists ( $VirtualSslConfPath )) {
    // cron_job_befehl ( "cd /etc/apache2/site-available/ | a2ensite $domain.conf" );
    exec("ln -s /etc/apache2/sites-available/$domain.conf /etc/apache2/sites-enabled/");
    // exec ( "rm /etc/apache2/sites-available/$domain" . "-le-ssl" . ".conf" );

    // }

    if (! file_exists($VirtualSslConfPath) or $last_edit_domain == $domain) {

        if ($set_ssl) {
            if ($subdomain) {
                cron_job_befehl("certbot --apache -d $domain $AddCertbot");
            } else {
                cron_job_befehl("certbot --apache -d $domain -d www.$domain $AddCertbot");
            }
        }
    }
    return $virtual_host;
}

// Löschen der Datein von Virtualhost und letsencrypt
// Dateien müssen Rechte vergeben werden hpc:root
function rm_domain($domain)
{
    exec("rm /etc/apache2/sites-available/$domain.conf");
    exec("rm /etc/apache2/sites-available/$domain" . "-le-ssl" . ".conf");
    exec("rm /etc/apache2/sites-enabled/$domain.conf");
    exec("rm /etc/apache2/sites-enabled/$domain" . "-le-ssl" . ".conf");
    exec("rm -rf /etc/letsencrypt/live/ssi.at");
    exec("rm -rf /etc/letsencrypt/archive/ssi.at");
    exec("rm /etc/letsencrypt/renewal/ssi.at.conf");
    cron_job_befehl("/etc/init.d/apache2 reload");
}

