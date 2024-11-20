<?
//Datenbankverbindung
include(__DIR__ . "/../functions.php");
include(__DIR__ . "/../config_db.php");
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kundenübersicht</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.css">
</head>

<body>

    <div class="ui container">
        <h2 class="ui dividing header">Kundenübersicht</h2>
        <?php
        // Verbindungsparameter
        $host = 'localhost';
        $dbname = 'ssi_trader';
        $username = 'smart';
        $password = 'Eiddswwenph21;';

        // Erstelle PDO-Verbindung
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<div class='ui negative message'>Verbindung fehlgeschlagen: " . $e->getMessage() . "</div>";
            exit;
        }

        // Alle Clients abrufen
        $queryClients = "SELECT c.client_id, c.first_name, c.last_name, s.name AS server_name 
                     FROM clients c 
                     JOIN servers s ON c.server_id = s.server_id";
        $stmtClients = $pdo->prepare($queryClients);
        $stmtClients->execute();
        $clients = $stmtClients->fetchAll(PDO::FETCH_ASSOC);

        foreach ($clients as $client) {
            $client_id = $client['client_id'];
            $fullName = htmlspecialchars($client['first_name'] . " " . $client['last_name']);
            $serverName = $client['server_name'];

            // Gesamteinzahlung des Clients ermitteln
            $queryDeposits = "SELECT SUM(amount) AS total_deposit FROM deposits WHERE client_id = :client_id";
            $stmt = $pdo->prepare($queryDeposits);
            $stmt->execute(['client_id' => $client_id]);
            $totalDeposit = $stmt->fetchColumn();

            // Gesamtprofit des Clients ermitteln
            $queryProfit = "SELECT SUM(profit) AS total_profit FROM orders WHERE server_id IN (SELECT server_id FROM clients WHERE client_id = :client_id)";
            $stmt = $pdo->prepare($queryProfit);
            $stmt->execute(['client_id' => $client_id]);
            $totalProfit = $stmt->fetchColumn();

            // Gewinnanteil (%) des Clients ermitteln
            $queryProfitShare = "SELECT profit_percentage FROM profit_shares WHERE client_id = :client_id";
            $stmt = $pdo->prepare($queryProfitShare);
            $stmt->execute(['client_id' => $client_id]);
            $profitPercentage = $stmt->fetchColumn();

            // Gewinnanteil berechnen
            $actualProfitShare = ($totalProfit * $profitPercentage) / 100;

            // Verbleibender Gewinn nach Abzug des prozentualen Anteils
            $remainingProfit = $totalProfit - $actualProfitShare;

            // Zeitraum ermitteln: Datum der ersten Order bis jetzt
            $queryFirstOrderDate = "SELECT MIN(time) AS first_order_time FROM orders WHERE client_id = :client_id";
            $stmtFirstOrderDate = $pdo->prepare($queryFirstOrderDate);
            $stmtFirstOrderDate->execute(['client_id' => $client_id]);
            $firstOrderTime = $stmtFirstOrderDate->fetchColumn();
            $firstOrderDate = $firstOrderTime ? date("Y-m-d", $firstOrderTime) : "Nicht verfügbar";
            $currentDate = date("Y-m-d");

            // HTML-Formatierte Ausgabe für jeden Client
            echo "<div class='ui segment'>";
            echo "<h3 class='ui header'>$fullName - Server: $serverName</h3>";
            echo "<p><strong>Zeitraum:</strong> $firstOrderDate bis $currentDate</p>";
            echo "<p><strong>Gesamteinzahlung:</strong> " . number_format($totalDeposit, 2) . " €</p>";
            echo "<p><strong>Gesamtprofit:</strong> " . number_format($totalProfit, 2) . " €</p>";
            echo "<p><strong>Gewinnanteil (%):</strong> " . number_format($profitPercentage, 2) . "%</p>";
            echo "<p><strong>Tatsächlicher Gewinnanteil:</strong> " . number_format($actualProfitShare, 2) . " €</p>";
            echo "<p><strong>Verbleibender Gewinn:</strong> " . number_format($remainingProfit, 2) . " €</p>";
            echo "</div>";
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.js"></script>

</body>

</html>