<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


//http://deineDomain.de/.../fetch_mt5.php?token=52a36a36e2e6da849685b71f466dde56
//http://localhost/smart7/ssi_trader/exec/fetch_mt5.php?token=52a36a36e2e6da849685b71f466dde56

// für cronjob  
//* * * * * php /var/www/ssi/smart7/ssi_trader/exec/fetch_mt5.php 52a36a36e2e6da849685b71f466dde56

define('SECRET_TOKEN', '52a36a36e2e6da849685b71f466dde56');

function validateToken($token)
{
    return $token === SECRET_TOKEN;
}

// Überprüfe, ob das Skript von der Kommandozeile oder über eine Webanfrage ausgeführt wird
if (php_sapi_name() === 'cli') {
    // Kommandozeilen-Argument
    $token = $argc > 1 ? $argv[1] : null;
} else {
    // GET-Parameter
    $token = isset($_GET['token']) ? $_GET['token'] : null;
}

if (!validateToken($token)) {
    die("Unbefugter Zugriff! Falscher oder fehlender Token.");
}

include(__DIR__ . "/../functions.php");
include(__DIR__ . "/../config_db.php");

// API-URL und Datenbankverbindung
$apiUrl = 'http://85.215.176.20/getMT5:8080';
$apiUrl = 'orders.txt';

$conn = new mysqli($cfg_mysql['server'], $cfg_mysql['user'], $cfg_mysql['password'], $cfg_mysql['db']);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Daten von der API abrufen
$apiResponse = file_get_contents($apiUrl);
$orders = json_decode($apiResponse, true);

if (!empty($orders)) {
    foreach ($orders as $order) {
        // Prüfen, ob das Symbol bereits existiert und die symbol_id abrufen
        $symbolQuery = $conn->prepare("SELECT symbol_id FROM ssi_trader.symbols WHERE symbol = ?");
        $symbolQuery->bind_param("s", $order[15]); // Angenommen, das Symbol ist an der 16. Stelle des Arrays
        $symbolQuery->execute();
        $result = $symbolQuery->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $symbol_id = $row['symbol_id'];
        } else {
            $insertSymbol = $conn->prepare("INSERT INTO ssi_trader.symbols (symbol) VALUES (?)");
            $insertSymbol->bind_param("s", $order[15]);
            $insertSymbol->execute();
            $symbol_id = $conn->insert_id;
        }

        // Anpassung der INSERT-Abfrage an die neue Struktur
        $stmt = $conn->prepare("INSERT INTO ssi_trader.orders (ticket, order_id, time, time_msc, type, entry, magic, position_id, reason, volume, price, commission, swap, profit, fee, symbol_id, comment, external_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Binden der Parameter aus dem $order-Array an die vorbereitete Abfrage
        $stmt->bind_param("iiiiiiiiiddddddiss", $order[0], $order[1], $order[2], $order[3], $order[4], $order[5], $order[6], $order[7], $order[8], $order[9], $order[10], $order[11], $order[12], $order[13], $order[14], $symbol_id, $order[15], $order[16]);

        $stmt->execute();
    }
    echo "Daten erfolgreich in die Datenbank eingefügt.\n";
} else {
    echo "Keine Daten von der API erhalten.\n";
}

$conn->close();
