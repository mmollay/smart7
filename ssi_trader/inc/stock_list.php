<?php
include(__DIR__ . "/../config.inc.php");

// Fetch data from the database and display using smart_list
$connection = mysqli_connect($cfg_mysql['server'], $cfg_mysql['user'], $cfg_mysql['password'], $cfg_mysql['db']);
$query = "SELECT * FROM ssi_trader.stocks_data ORDER BY time DESC LIMIT 200";
$result = mysqli_query($connection, $query);
if ($result) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $smart_list = "<table class='ui very compact basic celled table'>";
    $smart_list .= "<thead><tr><th>Buy</th><th>Sell</th><th>Time</th><th>Price</th></tr></thead> <tbody>";
    foreach ($rows as $row) {
        $smart_list .= "<tr><td" . ($row['buy'] > $row['sell'] ? " class='red'" : "") . ">" . $row['buy'] . "</td><td" . ($row['sell'] > $row['buy'] ? " class='red'" : "") . ">" . $row['sell'] . "</td><td>" . $row['time'] . "</td><td>" . $row['price'] . "</td></tr>";
    }
    $smart_list .= " <tbody></table>";
} else {
    $smart_list = "Fehler beim Abrufen der Daten aus der Datenbank.";
}

echo $smart_list;
