<?php
// Verbindung zur Datenbank herstellen (config.php einbinden)
include('config.php');

// Funktion zur Überprüfung der Passwortstärke
function checkPasswordStrength($password) {
    // Mindestlänge: 8 Zeichen
    if (strlen($password) < 8) {
        return false;
    }
    
    // Mindestens eine Zahl enthalten
    if (!preg_match("/[0-9]+/", $password)) {
        return false;
    }
    
    // Mindestens ein Sonderzeichen enthalten
    if (!preg_match("/[\W]+/", $password)) {
        return false;
    }
    
    return true;
}

// Funktion zur Überprüfung der Validität der Email-Adresse
function checkEmailValidity($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    return true;
}

// Daten aus dem Formular abrufen
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$birthdate = $_POST['birthdate'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Überprüfen, ob das Passwort und die Passwort-Wiederholung übereinstimmen
if ($password !== $confirm_password) {
    echo "Die Passwörter stimmen nicht überein.";
    exit;
}

// Überprüfen der Passwortstärke
if (!checkPasswordStrength($password)) {
    echo "Das Passwort erfüllt nicht die Mindestanforderungen.";
    exit;
}

// Überprüfen der Validität der Email-Adresse
if (!checkEmailValidity($email)) {
    echo "Die Email-Adresse ist ungültig.";
    exit;
}

// Hashen des Passworts
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert-Befehl ausführen
$sql = "INSERT INTO users (first_name, last_name, email, birthdate, password) VALUES ('$first_name', '$last_name', '$email', '$birthdate', '$hashed_password')";
$result = mysqli_query($conn, $sql);

// Überprüfen, ob der Insert erfolgreich war
if ($result) {
    // Registrierung erfolgreich
    // Weiterleitung zur index.php-Seite
    header("Location: index.php");
    exit;
} else {
    // Registrierung fehlgeschlagen
    echo "Fehler bei der Registrierung: " . mysqli_error($conn);
}

// Verbindung zur Datenbank schließen
mysqli_close($conn);
?>
