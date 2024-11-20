<?php
// Verbindung zur Datenbank herstellen (config.php einbinden)
include('config.php');

// Überprüfen, ob der Benutzer angemeldet ist (du musst deine eigene Überprüfung implementieren)
// Zum Beispiel: if ($userLoggedIn) { ... }
$userLoggedIn = true;

if ($userLoggedIn && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Benutzer-ID (Annahme: du hast die Benutzer-ID gespeichert oder kannst sie aus der Sitzung abrufen)
    $userId = 1;
    
    // Werte aus den Eingabefeldern abrufen
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    
    // SQL-Abfrage zum Aktualisieren der Benutzereinstellungen
    $sql = "UPDATE users SET age = '$age', gender = '$gender', height = '$height', weight = '$weight' WHERE id = '$userId'";
    
    if (mysqli_query($conn, $sql)) {
        // Einstellungen erfolgreich aktualisiert
        // Weiterleitung zur beer.php Seite
        header("Location: beers.php");
        exit();
    } else {
        // Fehler beim Aktualisieren der Einstellungen
        echo "Fehler beim Aktualisieren der Einstellungen: " . mysqli_error($conn);
    }
}

// Verbindung zur Datenbank schließen
mysqli_close($conn);
?>
