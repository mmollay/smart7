<?php
// Prüfen, ob das Formular übermittelt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Sicherstellen, dass Name und Nachricht nicht leer sind
	if (!empty($_POST["name"]) && !empty($_POST["nachricht"])) {
		// Textdatei öffnen oder erstellen
		$datei = fopen("gaestebuch.txt", "a") or die("Kann Datei nicht öffnen!");
		
		// Datum und Uhrzeit hinzufügen
		$datum = date("Y-m-d H:i:s");
		$eintrag = $datum . " - " . htmlspecialchars($_POST["name"]) . ": " . htmlspecialchars($_POST["nachricht"]) . "\n";
		
		// Eintrag in die Datei schreiben
		fwrite($datei, $eintrag);
		
		// Datei schließen
		fclose($datei);
		
		// Bestätigung anzeigen
		echo "<p>Eintrag hinzugefügt! <a href='index.html'>Zurück zum Gästebuch</a></p>";
	} else {
		echo "<p>Bitte alle Felder ausfüllen! <a href='index.html'>Zurück zum Gästebuch</a></p>";
	}
} else {
	// Wenn das Formular nicht übermittelt wurde, zurück zum Formular
	header("Location: index.php");
}
?>
