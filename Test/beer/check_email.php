<?php
// Verbindung zur Datenbank herstellen (config.php einbinden)
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Email-Adresse aus dem POST-Daten abrufen
    $email = $_POST['email'];
    
    // Überprüfen, ob die Email-Adresse bereits in der Datenbank vorhanden ist
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Email-Adresse bereits vorhanden
        echo "exists";
    } else {
        // Email-Adresse noch nicht vorhanden
        echo "available";
    }
}

// Verbindung zur Datenbank schließen
mysqli_close($conn);
?>
