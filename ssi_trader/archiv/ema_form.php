<?
//Alte Version wo auf manuelles Traiding möglich war

include(__DIR__ . "/../config.inc.php");
include('../../ssi_smart/smart_form/include_form.php');

$serverIps = getAllServerIps($mysqli);

foreach ($serverIps as $serverInfo) {

    $serverIp = $serverInfo['url'];
    $url = $serverIp . "/getActiveStrategies";
    $server_id = $serverInfo['server_id'];

    $jsonString = sendCurlRequest($url, $data);
    $array = json_decode($jsonString, true);

    if ($jsonString == 'connection_failed') {
        echo '<div class="ui message error">Connection failed to server: ' . $serverIp . ' (' . $serverInfo['name'] . ')</div>';
        continue;
    }

    if (isset($array['error'])) {
        echo $array['error'];
        continue;
    }


    // echo $url;  
    //echo $array['activeStrategy'];

    // Initialisierung der Variablen für das Formular
    $arr = ['form' => [], 'class' => 'equal width'];

    if (!$array['activeStrategy']) {
        $wide = 'eight';
        $arr['field'][] = array('type' => 'div', 'class' => 'fields');
    }


    // Standardmäßig alle Buttons auf 'disabled' setzen
    $buttonsState = [
        'startEmaHedge' => 'disabled',
        'stopEmaHedge' => 'disabled',
        'startManualHedge' => 'disabled',
        'stopManualHedge' => 'disabled'
    ];

    // Überprüfung, ob eine aktive Strategie vorhanden ist
    if (isset($array['activeStrategy'])) {
        // Alle Buttons entfernen und nur den relevanten Stop-Button anzeigen
        $buttonsState = [
            'startEmaHedge' => false,
            'stopEmaHedge' => false,
            'startManualHedge' => false,
            'stopManualHedge' => false
        ];

        // Den entsprechenden Stop-Button aktivieren
        $buttonsState['stop' . $array['activeStrategy']] = true;
    } else {
        // Wenn keine Strategie aktiv ist, alle Start-Buttons anzeigen und Stop-Buttons entfernen
        $buttonsState = [
            'startEmaHedge' => true,
            'stopEmaHedge' => false, // Stop wird nicht angezeigt
            'startManualHedge' => true,
            'stopManualHedge' => false // Stop wird nicht angezeigt
        ];
    }

    // Generieren des HTML-Formulars basierend auf dem Zustand der Buttons
    foreach ($buttonsState as $button => $show) {

        $icon = strpos($button, 'start') !== false ? 'play' : 'stop';
        $colorClass = strpos($button, 'start') !== false ? 'green' : 'red';

        if ($show) {

            // Button anzeigen
            $buttonText = str_replace(['start', 'stop'], ['Start ', 'Stop '], $button); // Ersetzt 'start'/'stop' durch 'Start'/'Stop' im Button-Text
            $arr['field'][$button] = [
                'type' => 'button',
                'value' => $buttonText,
                'onclick' => "post_ema('$button','$server_id')",
                'class' => "$colorClass fluid",
                'icon' => $icon,
                'wide' => $wide
            ];
        } else {
            // Button nicht ins Array aufnehmen, um ihn nicht anzuzeigen
            unset($arr['field'][$button]);
        }
    }

    // Aufruf der Funktion, um das Formular zu erstellen und auszugeben
    if (!$array['activeStrategy'])
        $arr['field'][] = array('type' => 'div_close');


    $output = call_form($arr);
    $content['body'] = $output['html'];

    //Cancel placed orders
    $arr['form'] = array('action' => "ajax/post.php", 'id' => 'cancel_allserver_id' . $server_id);
    $arr['ajax'] = array('success' => "after_post_request(data)", 'dataType' => "html", "confirmation" => true);
    $arr['ajax']['confirmation'] = array('text' => array('content' => 'Are you sure to cancel placed orders?" '));
    $arr['hidden']['cancel_close_all'] = 'cancelAll';
    $arr['hidden']['server_id'] = $server_id;
    $arr['field']['button'] = array('type' => 'submit', 'value' => 'Cancel placed Orders', 'icon' => 'blue ban', 'class' => 'large fluid');
    $output = call_form($arr);
    $field_cancel_close2 = $output['html'] . $output['js'];

    //Cancel and Close
    $arr['form'] = array('action' => "ajax/post.php", 'id' => 'close_all' . $server_id);
    $arr['ajax'] = array('success' => "after_post_request(data)", 'dataType' => "html", "confirmation" => true);
    $arr['ajax']['confirmation'] = array('text' => array('content' => 'Are you sure to cancel and close all orders?" '));
    $arr['hidden']['cancel_close_all'] = 'closeAll';
    $arr['hidden']['server_id'] = $server_id;
    $arr['field']['button'] = array('type' => 'submit', 'value' => 'Close all Orders', 'icon' => 'hand holding usd icon green', 'class' => 'large fluid');
    $output = call_form($arr);
    $field_cancel_close1 = $output['html'] . $output['js'];

    //KILL ALL (SERVER and Trading )
    $arr['form'] = array('action' => "ajax/post.php", 'id' => 'kill_all');
    $arr['ajax'] = array('success' => "after_post_request(data)", 'dataType' => "html", "confirmation" => true);
    $arr['ajax']['confirmation'] = array('text' => array('content' => 'Are you sure to Stop the Server: ' . $serverInfo['name'] . '? '));
    $arr['hidden']['kill_all'] = '1';
    $arr['hidden']['server_id'] = $server_id;
    $arr['field']['button'] = array('type' => 'submit', 'value' => 'STOP THE SERVER', 'icon' => 'skull crossbones', 'class' => 'brown');
    $output = call_form($arr);
    $field_killall = $output['html'] . $output['js'];

    $content['body'] .= "
    <div class='ui grid'>
    <div class='eight wide column'>$field_cancel_close1</div>
    <div class='eight wide column'>$field_cancel_close2</div>
    </div>
    <div align=right>$field_killall</div>
    ";

    echo "
    <div class='ui attached message'><b>" . $serverInfo['name'] . "</b> (" . $serverInfo['url'] . ") </div>
    <div class='ui attached fluid segment'>" . $content['body'] . "</div>
    <br>
    ";
    $wide = '';

    //<div class='ui attached message'>" . $serverInfo['url'] . "</div>
}

