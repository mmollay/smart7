<?php
// Empfängt das GitHub-Webhook-Payload
$payload = file_get_contents('php://input');
$event = $_SERVER['HTTP_X_GITHUB_EVENT'];

// Prüfen, ob es sich um ein Push-Ereignis handelt
if ($event === 'push') {
    // Ins Projektverzeichnis wechseln und git pull ausführen
    shell_exec('cd /data/www/develop/smart7 && git pull origin main');
}
?>
