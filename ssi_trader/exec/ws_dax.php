<?php

$host = 'trade2.ssi.at';
$host = '85.215.176.20';
$port = 8081;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!$sock) {
    die("Fehler beim Erstellen des Sockets: " . socket_strerror(socket_last_error()) . "\n");
}

if (!socket_connect($sock, $host, $port)) {
    die("Fehler beim Verbinden: " . socket_strerror(socket_last_error($sock)) . "\n");
}

// Websocket Handshake
$header = "GET /dax HTTP/1.1\r\n" .
    "Host: $host:$port\r\n" .
    "Upgrade: websocket\r\n" .
    "Connection: Upgrade\r\n" .
    "Sec-WebSocket-Key: " . base64_encode(openssl_random_pseudo_bytes(16)) . "\r\n" .
    "Sec-WebSocket-Version: 13\r\n\r\n";

socket_write($sock, $header, strlen($header));

$response = socket_read($sock, 1500);
echo "Handshake Response: \n$response\n";

// Fehlerbehandlung, wenn Handshake fehlschlägt
if (strpos($response, ' 101 ') === false) {
    die("Handshake fehlgeschlagen.\n");
}

// Listener für eingehende Nachrichten
$running = true;
while ($running) {
    $data = socket_read($sock, 1500);
    if ($data === false) {
        die("Fehler beim Lesen des Sockets: " . socket_strerror(socket_last_error($sock)) . "\n");
    }

    $length = ord($data[1]) & 127;
    $masks = substr($data, $length == 126 ? 4 : ($length == 127 ? 10 : 2), 4);
    $data = substr($data, $length == 126 ? 8 : ($length == 127 ? 14 : 6));

    $message = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $message .= $data[$i] ^ $masks[$i % 4];
    }

    echo "Empfangene Nachricht: $message\n";

    // Beenden, wenn eine bestimmte Nachricht empfangen wird, z.B. 'exit'
    if ($message === "exit") {
        $running = false;
    }
}

// Socket schließen
socket_close($sock);
echo "Socket geschlossen.\n";
