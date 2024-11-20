<?php
// Verbindung zur MySQL-Datenbank herstellen
include ('config.php');

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Überprüfung der Verbindung
if (!$conn) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . mysqli_connect_error());
}

// Überprüfen, ob das Formular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Benutzername und Passwort aus dem Formular erhalten
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // SQL-Abfrage zum Überprüfen des Benutzers
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        
        // Benutzer gefunden, Überprüfung des Passworts
        $row = mysqli_fetch_assoc($result);
   
        if ($password == $row['password']) {
            // Passwort ist korrekt, Benutzer ist angemeldet
            session_start();
            $_SESSION['user_id'] = $row['id'];
            header("Location: beers.php"); // Weiterleitung zur Bier-Eingabeseite
        } else {
            // Falsches Passwort
            echo "Falsches Passwort!";
        }
    } else {
        // Benutzer nicht gefunden
        echo "Benutzer nicht gefunden!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css">
<style>
body {
    background-color: #F5D04C;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    width: 400px;
    padding: 40px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    text-align: center;
}

.login-container .logo {
    margin-bottom: 30px;
    border-radius: 50%;
    overflow: hidden;
}

.login-container .logo img {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

.login-container h2 {
    color: #4F311E;
    font-size: 24px;
    margin-bottom: 30px;
}

.login-container .ui.form .field input {
    padding: 12px;
}

.login-container .ui.form .field.button {
    margin-top: 30px;
}

.login-container .ui.form .field.button .ui.button {
    width: 100%;
}
</style>
</head>
<body>
<div class="login-container">
<div class="logo">
<img src="beer.png" alt="Logo">
</div>
<h2>Login</h2>
<form class="ui form" method="POST" action="login.php">
<div class="field">
<label>Email</label>
<input type="email" name="email" required>
</div>
<div class="field">
<label>Password</label>
<input type="password" name="password" required>
</div>
<div class="field button">
<button class="ui primary button" type="submit">Login</button>
</div>
</form>
<div class="field">
<a href="register.php" class="ui secondary button">Register</a>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
</body>
</html>
