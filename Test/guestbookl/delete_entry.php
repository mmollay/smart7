<?php
session_start();

$admin = 1; // Stelle sicher, dass diese Variable definiert ist

if (!isset($_POST['timestamp'], $_POST['token']) || $_SESSION['token'] !== $_POST['token']) {
	die("Ungültige Anfrage");
}

$timestamp = urldecode($_POST['timestamp']);
$gaestebuchFile = "gaestebuch.txt";

$eintraege = file($gaestebuchFile);
$updatedEintraege = [];

foreach ($eintraege as $eintrag) {
	list($eintragDatum) = explode("|", $eintrag);
	if (trim($eintragDatum) !== trim($timestamp)) {
		$updatedEintraege[] = $eintrag;
	}
}

file_put_contents($gaestebuchFile, implode("", $updatedEintraege));

$eintraege = array_reverse(file($gaestebuchFile));
foreach ($eintraege as $eintrag) {
	list($datum, $name, $nachricht) = explode("|", $eintrag);
	echo "<div class='gaestebuch-eintrag'>";
	if ($admin === 1) {
		echo "<a href='javascript:void(0);' onclick='deleteEntry(\"" . urlencode($datum) . "\", \"" . $_SESSION['token'] . "\")' class='delete-entry'>X</a> ";
	}
	echo "<div class='gaestebuch-datum'>" . htmlspecialchars($datum) . "</div>";
	echo "<b>" . htmlspecialchars($name) . "</b>: " . nl2br($nachricht);
	echo "</div>";
}

exit;
?>
