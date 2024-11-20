<?php
include(__DIR__ . "/../config.inc.php");
include('../../ssi_smart/smart_form/include_form.php');

$servers = getAllServerIps($mysqli);
echo json_encode($servers);