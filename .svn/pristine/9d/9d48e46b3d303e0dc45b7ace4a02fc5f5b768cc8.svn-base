<?php
include('../inc/mysql.php');

// Korrigiertes vorbereitetes Statement mit den richtigen Platzhaltern
$statement = $pdo->prepare("REPLACE INTO list (id, firstname, secondname, birthday, message, category, amount) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Die $_POST['update_id'] sollte tatsächlich nur $_POST['id'] sein, wenn das Formularfeld entsprechend benannt ist. 
// Stelle sicher, dass die Namen der $_POST-Variablen mit den Namen in deinem Formular übereinstimmen.
if ($statement->execute(array($_POST['update_id'], $_POST['firstname'], $_POST['secondname'], $_POST['birthday'], $_POST['message'], $_POST['category'], $_POST['amount']))) {
	$ok = true;
} else {
	$ok = false;
}

if ($ok == true) {
	// Da die Antworten als JavaScript interpretiert werden, sollten sie korrekt gehandhabt werden.
	// Beachte, dass die direkte Ausgabe von JavaScript-Code auf diese Weise ungewöhnlich ist und in der Praxis durch eine bessere Fehlerbehandlung und Benutzerfeedback-Strategie ersetzt werden sollte.

	echo "$('#edit').modal('hide');";
	echo "$('#edit2').flyout('hide');";
	echo "table_reload();";

} else {
	$error = "SQL Error in: " . $statement->queryString . " - " . implode(' - ', $statement->errorInfo());
	// Die Ausgabe des Fehlers sollte auch korrekt gehandhabt werden, um keine Sicherheitsrisiken einzugehen. 
	// In einem Produktivsystem sollte ein generisches Fehlermeldung an den Benutzer zurückgegeben werden, 
	// während die spezifischen Details geloggt werden, anstatt sie direkt auszugeben.
	echo "<script>alert('" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "');</script>";
}
