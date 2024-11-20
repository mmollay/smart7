<?
include (__DIR__ . "/../config.inc.php");
include ('../../ssi_smart/smart_form/include_form.php');

$field_killall = '';
$real_account = 0;

//Strategies for dropdown
//$arrayStrategies = getStrategyNames($ServerPrime, $_SESSION['token']['4']);

$serverIps = getAllServerIps($mysqli);

// Initialisiere das Array, das die Tabellenreihen aufnehmen soll
$tr = [
    'real' => '',
    'demo' => ''
];

foreach ($serverIps as $serverInfo) {

    $serverIp = $serverInfo['url'];
    $server_id = $serverInfo['server_id'];
    $server_name = $serverInfo['name'];
    $brokerName = $serverInfo['broker_name'];
    $strategy_default = $serverInfo['strategy_default'];
    $contract_default = $serverInfo['contract_default'];
    $daily_profit = $serverInfo['daily_profit'];
    $previous_day_profit = $serverInfo['previous_day_profit'];
    $lotsize_default = $serverInfo['lotsize'];
    $real_account = $serverInfo['real_account'];
    $token = $_SESSION['token'][$server_id]; //Token wird in "generate_token.php" gespeichert
    $numberOfPositions = $serverInfo['numberOfPositions'];
    $sumOfValuesAtPosition9 = $serverInfo['sumOfValuesAtPosition9'];
    $account = $serverInfo['account'];
    $broker_matchcode = $serverInfo['broker_matchcode'];

    //Infoabfrage ob MT5-server bereits läuft
    $json_string = sendCurlRequest($serverIp . "/getMT5Status", '', $token);
    $array = json_decode($json_string, true);
    //echo "<hr>$serverIp" . "<br>getMT5Status:<br>$json_string<br>";

    if ($array['process']['active'] == 1) {
        $array['activeMT5'] = true;
        $arrayStrategies = getStrategyNames($serverIp, $token);
    } else {
        $array['activeMT5'] = false;
    }

    // Bestimmt den Button-Text und die Farbe basierend auf dem Status von 'activeMT5'
    // Festlegen des Button-Textes, der Aktion, der Farbe und des Icons basierend auf dem Zustand von 'activeMT5'
    $buttonAction = $array['activeMT5'] ? 'stopMT5' : 'startMT5';
    $buttonValue = $array['activeMT5'] ? 'Stop MT5' : 'Start MT5';
    $colorClass = $array['activeMT5'] ? "red" : "green";
    $icon = $array['activeMT5'] ? "stop" : "play";

    // Gemeinsame Eigenschaften für den Button setzen
    $arr['form'] = array();
    $arr['field'][] = ['type' => 'button', 'value' => $buttonValue, 'onclick' => "post_ema('$buttonAction','','$server_id')", 'class' => "{$colorClass} small fluid", 'icon' => $icon];
    $output = call_form($arr);
    $ContentButtonMT5 = $output['html'];
    //$array['activeMT5'] = true;
    //Nur anzeigen wenn MT5 aktiv ist
    if ($array['activeMT5'] == true) {


        $json_string = sendCurlRequest($serverIp . "/getStatus", '', $token);
        //echo "$serverIp<br>";
        //echo "getStatus:$json_string<br>";
        $array = json_decode($json_string, true);
        $activeStrategy = $array['activeStrategy']; //Strategy name
        $statusAuto = $auto = $array['auto']; //1,2,3,4 //$auto_value
        $pauseStrategy = $array['pauseStrategy']; //$pause für Strategy
        $pauseAuto = $array['pauseAuto']; //$pause für Auto
        $sizeStrategy = $array['sizeStrategy'];
        $sizeAuto = $array['sizeAuto']; //0.1
        $errorMsg = '';
        // Prüft, ob eine Verbindungsfehlermeldung vorliegt
        if ($jsonString == 'connection_failed') {
            $errorMsg = "Connection failed to server: $serverIp ($serverInfo[name])";
        }
        // Prüft, ob ein spezifischer Fehler im Antwortarray vorhanden ist
        elseif (isset($array['error'])) {
            $errorMsg = $array['error'] . " for the server: $serverIp ($serverInfo[name])";
        }
        // Gibt die Fehlermeldung aus, wenn eine vorliegt
        if (!empty($errorMsg)) {
            echo "<div class=\"ui message error\">$errorMsg $serverIp</div>";
            continue;
        }

        //Wenn auto ist sollen andere Button sein
        if ($statusAuto) {

            $buttonText = $pauseAuto == 0 ? 'Pause Auto' : 'Resume ';
            $buttonColor = $pauseAuto == 0 ? 'orange' : 'green';
            $buttonIcon = $pauseAuto == 0 ? 'pause' : 'play';

            $arr['form'] = array('class' => 'small');
            $arr['field'][] = array('type' => 'div', 'class' => 'equal stackable fields');
            $arr['field'][] = ['type' => 'button', 'value' => "StopAuto $auto", 'onclick' => "stopAuto($server_id,$auto)", 'class' => "red small fluid", 'icon' => 'stop'];
            $arr['field'][] = ['type' => 'button', 'value' => $buttonText, 'onclick' => " post_ema_general('pauseAuto','$server_id')", 'class' => "$buttonColor small fluid", 'icon' => $buttonIcon];
            $arr['field'][] = array('type' => 'div_close');
            $output = call_form($arr);
            $ContentStopPause = $output['html'];
            $lotsize = $sizeAuto;

        } else if ($activeStrategy) {

            //if ($activeStrategy) {
            // Determine button properties based on $pause state
            $buttonText = $pauseStrategy == 0 ? 'Pause Strategy' : 'Resume ';
            $buttonColor = $pauseStrategy == 0 ? 'orange' : 'green';
            $buttonIcon = $pauseStrategy == 0 ? 'pause' : 'play';

            $arr['form'] = array('class' => 'small');
            $arr['field'][] = array('type' => 'div', 'class' => 'equal stackable fields');
            $arr['field'][] = ['type' => 'button', 'value' => "Stop Strategy", 'onclick' => "post_ema('stopStrategy','','$server_id')", 'class' => "red small fluid", 'icon' => 'stop'];
            $arr['field'][] = ['type' => 'button', 'value' => $buttonText, 'onclick' => "post_ema('pauseStrategy','','$server_id')", 'class' => "$buttonColor small fluid", 'icon' => $buttonIcon];
            $arr['field'][] = array('type' => 'div_close');
            $output = call_form($arr);
            $ContentStopPause = $output['html'];

            //Cancel and Close
            $arr['form'] = array('action' => "ajax/post.php", 'id' => 'close_all' . $server_id, 'class' => 'small');
            $arr['ajax'] = array('success' => ",(data)", 'dataType' => "html", "confirmation" => true);
            $arr['ajax']['confirmation'] = array('text' => array('content' => 'Are you sure to cancel and close all orders?" '));
            $arr['hidden']['cancel_close_all'] = 'closeAll';
            $arr['hidden']['server_id'] = $server_id;
            $arr['field']['button'] = array('type' => 'submit', 'value' => 'Close', 'icon' => 'hand holding usd icon green', 'class' => '');
            $output = call_form($arr);
            //$ContentClose = $output['html'] . $output['js'];
            $lotsize = $sizeStrategy;

        } else {

            //print_r($arrayStrategies);
            $arr['form'] = array('action' => "ajax/post.php", 'id' => "form_start$server_id", 'class' => 'small');
            $arr['ajax'] = array('success' => "after_start_strategy(data)", 'dataType' => "html");
            $arr['field'][] = array('type' => 'div', 'class' => 'equal stackable fields');
            $arr['field']['size'] = array('type' => 'input', 'value' => $lotsize_default, 'validate' => true, 'wide' => 'three', 'placholder' => 'Lots');
            //die beiden arrays zusammen führen
            $arrayAuto = array('startAuto1' => 'startAuto1', 'startAuto2' => 'startAuto2', 'startAuto3' => 'startAuto3', 'startAuto4' => 'startAuto4');
            $mergedArray = array_merge($arrayAuto, $arrayStrategies);
            $arr['field']['strategy'] = array('type' => 'dropdown', 'array' => $mergedArray, 'class' => 'fluid search selection', 'validate' => true, 'value' => $strategy_default, 'placeholder' => 'Strategy', 'wide' => 'five', );
            $arr['field'][] = ['type' => 'submit', 'value' => "Start", 'class' => "fluid green", 'icon' => 'play', 'wide' => 'four'];
            $arr['field'][] = array('type' => 'div_close');
            $arr['hidden']['server_id'] = $server_id;
            $arr['hidden']['account'] = $account;
            $arr['hidden']['strategy_value'] = 'startStrategy';
            //$arr['button']['submit'] = array('value' => 'Start Stragegy', 'icon' => 'play', 'class' => 'red', );
            $output = call_form($arr);
            $ContentStartStrategy = $output['html'] . $output['js'];
        }

        //KILL ALL (SERVER and Trading )
        $arr['form'] = array('action' => "ajax/post.php", 'id' => 'kill_all', 'class' => 'small');
        $arr['ajax'] = array('success' => "after_post_request(data)", 'dataType' => "html", "confirmation" => true);
        $arr['ajax']['confirmation'] = array('text' => array('content' => 'Are you sure to Stop the Server: ' . $serverInfo['name'] . '? '));
        $arr['hidden']['kill_all'] = '1';
        $arr['hidden']['server_id'] = $server_id;
        $arr['field']['button'] = array('type' => 'submit', 'value' => "", 'icon' => 'skull crossbones', 'class' => 'brown');
        $output = call_form($arr);
        //float left
        $contenKillAll = "<div class='four wide column'>" . $output['html'] . $output['js'] . "</div>";
    }


    // Entscheide, ob der Server real oder Demo ist
    $serverType = $serverInfo['real_account'] == 1 ? 'real' : 'demo';

    // Bestimme das Label basierend auf dem Server-Typ
    //$label_strategy = $serverType == 'real' ? "<div class='ui mini label red'>Real</div>" : "<div class='ui mini label orange'>Demo</div>";

    // Baue die Tabellenzeile
    $tr[$serverType] .= "<tr>";
    $tr[$serverType] .= "<td>
    <b>" . $serverInfo['name'] . "</b><br>
$serverIp<br>
Account: $account : $broker_matchcode
</td>";
    $tr[$serverType] .= "<td>$ContentButtonMT5</td>";

    if ($activeStrategy) {
        $tr[$serverType] .= "<td>$lotsize</td>";
        $tr[$serverType] .= "<td>$activeStrategy</td>";
        $colspan = 0;
    } else {
        $colspan = 3;
    }

    $tr[$serverType] .= "<td colspan=$colspan>$ContentStartStrategy $ContentStopPause $ContentClose</td>";
    $tr[$serverType] .= "<td style='text-align: right;'><span id='server-positions-$server_id'>..loading</span></td>"; // Rechtbündig
    //$tr[$serverType] .= "<td style='text-align: right;'><span id='server-profit-$server_id'>" . $daily_profit . "</span></td>"; // Rechtbündig
    $tr[$serverType] .= "<td style='text-align: right;' class=''></td>"; // Rechtbündig
    $tr[$serverType] .= "<td><div align='center'>$contenKillAll</div></td>";
    $tr[$serverType] .= "</tr>";

    $contenKillAllBulk .= $contenKillAll;
    $ContentButtonMT5 = '';
    $ContentStopPause = '';
    $ContentClose = '';
    $ContentStartStrategy = '';
    $contenKillAll = '';

}
function printServerTable($title, $tbodyContent, $serverType)
{
    // Bestimmt das Label basierend auf dem übergebenen Server-Typ
    $labelStrategy = $serverType == 'real' ? "<div class='ui label red'>Real</div>" : "<div class='ui label orange'>Demo</div>";
    if ($tbodyContent) {
        echo "<h3>{$labelStrategy} {$title} </h3>";
        echo "<table class='ui small compact celled striped single line table ' style='max-width:1200px'>";
        echo "<thead><tr>
    <th class='wide four'>Server Details</th>
    <th>MT5 Server</th>
    <th>Lots</th>
    <th colspan='2'>Strategy</th>
    <th>Info</th>
    <th class=''></th>
    <th>Kill</th>
    </tr></thead>";
        echo "<tbody>{$tbodyContent}</tbody>";
        echo "</table>";
    }
}

// Ausgabe für Real Server
printServerTable("Servers", $tr['real'], 'real');

// Ausgabe für Demo Server
printServerTable("Servers", $tr['demo'], 'demo');
