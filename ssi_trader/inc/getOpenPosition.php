<?
include(__DIR__ . "/../config.inc.php");
include('../../ssi_smart/smart_form/include_form.php');

$servers = getAllServerIps($mysqli);
foreach ($servers as $serverInfo) {
    getPositionsSummary($serverIp, $_SESSION['token']['4']);
}

echo json_encode($servers);