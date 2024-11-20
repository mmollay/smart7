<?php
$secret = "IHR_SECRET_HIER";
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'];

if (!$signature) {
    exit('No signature');
}

$payload = file_get_contents('php://input');
$calculated = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($signature, $calculated)) {
    exit('Invalid signature');
}

// Log the event
file_put_contents('webhook.log', date('Y-m-d H:i:s') . " - Webhook triggered\n", FILE_APPEND);

// Execute pull command
$output = shell_exec('cd /data/www/develop/smart7 && git pull 2>&1');
file_put_contents('webhook.log', $output . "\n", FILE_APPEND);
?>
