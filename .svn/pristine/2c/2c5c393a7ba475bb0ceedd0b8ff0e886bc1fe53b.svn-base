<?
include (__DIR__ . "/include.php");

if ($_GET['duplicate'] == true) {
    // Error-message for duplicate Pages
    $abortpage['message'] = 'Der Smart-Kit zur Bearbeitung deiner Seiten ist bereits geöffnet!<br> Um Session-Konflikte zu vermeiden kann nur 1 Webseiten-Editor pro Domain verwendet werden!
<br><br><a href="../ssi_dashboard" class="ui button">Zum Dashboard</a>';
} else if (! $abortpage['message'])
    // Error-message for other iligal things
    $abortpage['message'] = 'Unzulässige Handlung gesetzt!!';

if (! $abortpage['class'])
    $abortpage['class'] = 'message error';

echo call_page($abortpage['message'], $abortpage['class']);
