<!DOCTYPE html>
<html>
<head>
    <title>Bier-App - Biermenge eingeben</title>
    <style>
        body {
            background-color: #F5D04C;
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #0065A4;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFF;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .success-message {
            color: #008000;
            font-weight: bold;
        }

        .error-message {
            color: #FF0000;
            font-weight: bold;
        }

        .beer-image {
            max-width: 200px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include('config.php');

    $user_id = $_SESSION['user_id'];
    

    
    if (!$user_id) {
        header("Location: login.php");
        exit();
    }

    // Verbindung zur Datenbank herstellen
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Überprüfung der Verbindung
    if (!$conn) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . mysqli_connect_error());
    }

    // Überprüfen, ob das Benutzeralter vorhanden ist
    $age = "100 Jahre";
    $sql = "SELECT * FROM user_settings WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['age'])) {
            $age = $row['age'];
        }
        $username = $row['first_name'];
    
        
    }
    

    // Überprüfen, ob die Biermenge abgeschickt wurde
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $quantity = $_POST['quantity'];

        // Überprüfen, ob die wöchentliche Begrenzung überschritten wurde
        $currentDate = date('Y-m-d');
        $weekStartDate = date('Y-m-d', strtotime('monday this week'));
        $weekEndDate = date('Y-m-d', strtotime('sunday this week'));

        $sql = "SELECT SUM(quantity) AS total FROM beers WHERE user_id = '$user_id' AND date BETWEEN '$weekStartDate' AND '$weekEndDate'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $weeklyTotal = $row['total'] + $quantity;

        if ($weeklyTotal > 10) {
            echo '<div class="container">';
            echo '<img src="beer.png" alt="Beer" class="beer-image">';
            echo '<h2>Biermenge eingeben</h2>';
            echo '<div class="error-message">Du hast die wöchentliche Begrenzung überschritten!</div>';
            echo '<br>';
            echo '<a href="logout.php">Abmelden</a>';
            echo '</div>';
        } else {
            // Biermenge in der Datenbank speichern
            $sql = "INSERT INTO beers (user_id, date, quantity) VALUES ('$user_id', '$currentDate', '$quantity')";
            mysqli_query($conn, $sql);

            // Gesamtanzahl der getrunkenen Biere abrufen
            $sql = "SELECT SUM(quantity) AS total FROM beers WHERE user_id = '$user_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalBeers = $row['total'];

            echo '<div class="container">';
            echo '<img src="beer.png" alt="Beer" class="beer-image">';
            echo '<h2>Biermenge eingeben</h2>';
            echo '<div class="success-message">Biermenge erfolgreich gespeichert!</div>';
            echo '<div>Gesamtanzahl der getrunkenen Biere: ' . $totalBeers . '</div>';
            echo '<div>Benutzername: ' . $username . ' (' . $age . ')</div>';
            echo '<br>';
            echo '<a href="logout.php">Abmelden</a>';
            echo '</div>';
        }
    } else {
        // Gesamtanzahl der getrunkenen Biere abrufen
        $sql = "SELECT SUM(quantity) AS total FROM beers WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $totalBeers = $row['total'];

        echo '<div class="container">';
        echo '<img src="beer.png" alt="Beer" class="beer-image">';
        echo '<h2>Biermenge eingeben</h2>';
        echo '<div>Gesamtanzahl der getrunkenen Biere: ' . $totalBeers . '</div>';
        echo '<div>Benutzername: ' . $username . ' (' . $age . ')</div>';
        echo '<br>';
        echo '<form action="beers.php" method="POST">';
        echo '<label for="quantity">Anzahl der Biere:</label>';
        echo '<input type="number" name="quantity" required min="1" max="10"><br><br>';
        echo '<input type="submit" value="Speichern">';
        echo '</form>';
        echo '<br>';
        echo '<a href="logout.php">Abmelden</a>';
        echo '</div>';
    }

    // Verbindung zur Datenbank schließen
    mysqli_close($conn);
    ?>
</body>
</html>
