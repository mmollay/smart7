<?php
require dirname(__DIR__) . '/vendor/autoload.php'; // Pfad zur autoload.php anpassen

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatServer implements MessageComponentInterface {
    public function onOpen(ConnectionInterface $conn) {
        echo "Neue Verbindung! ({$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn) {
        echo "Verbindung {$conn->resourceId} wurde getrennt\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Ein Fehler ist aufgetreten: {$e->getMessage()}\n";
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo sprintf('Nachricht von %d: %s' . "\n", $from->resourceId, $msg);
        // Hier könntest du die empfangene Nachricht an alle verbundenen Clients senden
    }
}

// Erstelle und starte den WebSocket-Server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    8080 // Der Port, auf dem dein WebSocket-Server läuft
);

echo "WebSocket-Server läuft auf Port 8080\n";
$server->run();

