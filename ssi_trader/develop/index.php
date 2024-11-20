<?php
$strategy_group = 1;
$dax = 17005;
$trade = 'buy'; // Handelsrichtung
$lot = 1; // Einkaufsmenge

// Verbindungsparameter für die Datenbank
$dbUser = 'smart';
$dbPassword = 'Eiddswwenph21;';
$host = 'localhost';
$dbName = 'ssi_trader';
$mysqli = new mysqli($host, $dbUser, $dbPassword, $dbName);

echo "Trade: " . $trade . "<br>";
echo "Start DAX: " . $dax . "<br>";
echo "<hr>";

function executeTrade($level, $dax, $trade, $lot, $mysqli)
{
    $sql = "SELECT reverse,LotSizePercentage,entrypoint  FROM `hedging` WHERE `group_id` = 1 AND `level` = $level";
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_assoc()) {
        $reverse = $row['reverse']; // Gegenhandel
        $LotSize = $row['LotSizePercentage'] * $lot; // Lotsize berechnen
        $EntryPoint = $dax + ($trade == 'buy' ? 1 : -1) * $row['entrypoint']; // Einstiegspunkt DAX

        // Anpassung von Handel und Takeprofit basierend auf Reverse-Flag
        if ($reverse == 1) {
            $trade = $trade == 'buy' ? 'sell' : 'buy';
        }
        $Takeprofit = $dax + ($trade == 'buy' ? 1 : -1) * $row['takeprofit'];

        //nur gewisse rows mit print_r anzeigen
        print_r($row);

        echo "<br>";
        // Ausgabe von Kauf-/Verkaufslinks
        echo "" . ($trade == 'buy' ? 'buyMarket' : 'sellMarket') . "?qty=1<br>";
        echo "" . ($trade == 'buy' ? 'buyLimit' : 'sellLimit') . "?qty=$LotSize&price=$EntryPoint<br>";
        //echo "http://85.215.176.20:8080/closeAll<br>";
        echo "Take Profit bei : $Takeprofit <br>";
        echo "<hr>";
    }
}

// Durchführen von Handelstransaktionen für verschiedene Levels
$levels = [1, 2, 3, 4, 5]; // Definiere die zu durchlaufenden Levels
foreach ($levels as $level) {
    executeTrade($level, $dax, $trade, $lot, $mysqli);
}

// Verbindung schließen
$mysqli->close();
