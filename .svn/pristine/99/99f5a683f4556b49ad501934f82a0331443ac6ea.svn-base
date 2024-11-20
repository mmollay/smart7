<?php
session_start();

$ip = $_SERVER['REMOTE_ADDR'];
$logFile = "last_entry_log.txt";
$gaestebuchFile = "gaestebuch.txt";
$timeLimit = 20 * 60; // 20 Minuten in Sekunden
$test = 1; // Testmodus aktivieren (1) oder deaktivieren (0)
$admin = 1; // Admin-Modus aktivieren (1) oder deaktivieren (0)

// Token für CSRF-Schutz
if (!isset($_SESSION['token'])) {
	$_SESSION['token'] = bin2hex(random_bytes(32));
}

function sanitizeInput($input) {
	// Grundlegende XSS-Bereinigung
	return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

function canPost($ip, $logFile, $timeLimit, $test) {
	if ($test === 1) {
		return true; // Im Testmodus immer erlauben
	}
	
	if (file_exists($logFile)) {
		$entries = file($logFile);
		foreach ($entries as $entry) {
			list($entryIp, $entryTime) = explode("|", $entry);
			if (trim($entryIp) == $ip && (time() - trim($entryTime)) < $timeLimit) {
				return false;
			}
		}
	}
	return true;
}

function logEntry($ip, $logFile) {
	$entry = $ip . "|" . time() . "\n";
	file_put_contents($logFile, $entry, FILE_APPEND);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!empty($_POST["name"]) && isset($_POST["nachricht"])) {
		if (canPost($ip, $logFile, $timeLimit, $test)) {
			$datei = fopen($gaestebuchFile, "a") or die("Kann Datei nicht öffnen!");
			$datum = date("Y-m-d H:i:s");
			$name = sanitizeInput($_POST["name"]);
			$nachricht = sanitizeInput($_POST["nachricht"]);
			$eintrag = $datum . "|" . $name . "|" . $nachricht . "\n";
			fwrite($datei, $eintrag);
			fclose($datei);
			logEntry($ip, $logFile);
		} else {
			echo "Error:Du kannst nur alle 20 Minuten einen Eintrag machen.";
			exit;
		}
	}
}

if (file_exists($gaestebuchFile)) {
	$eintraege = array_reverse(file($gaestebuchFile)); // Umkehrung der Reihenfolge
	foreach ($eintraege as $eintrag) {
		list($datum, $name, $nachricht) = explode("|", $eintrag);
		echo "<div class='gaestebuch-eintrag'>";
		if ($admin === 1) {
			echo "<a href='#' class='delete-entry' data-timestamp='" . urlencode($datum) . "' data-token='" . $_SESSION['token'] . "'>X</a> ";
		}
		echo "<div class='gaestebuch-datum'>" . htmlspecialchars($datum) . "</div>";
		echo "<b>" . htmlspecialchars($name) . "</b>: " . nl2br($nachricht);
		echo "</div>";
	}
}
?>
