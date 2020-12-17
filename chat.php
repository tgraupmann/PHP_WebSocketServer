<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

    // Make sure composer dependencies have been installed
    require __DIR__ . '/vendor/autoload.php';

/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
class MyChat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        //echo ("opOpen:\r\n");
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
  	    //echo ($msg . "\r\n");
        $json = json_decode($msg);
        //echo ($json->data . "\r\n");
        $jsonData = json_decode($json->data);
        //echo ($jsonData->timestamp . "\r\n");
        //echo (count($this->clients) . "\r\n");
        $jsonData->clients = count($this->clients) - 1;
        //echo (json_encode($jsonData));
        $json->data = json_encode($jsonData);

        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        //echo ("onClose:\r\n");
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

    // Run the server application through the WebSocket protocol on port 8080
    $app = new Ratchet\App('localhost', 5050);
    $app->route('/chat', new MyChat, array('*'));
    $app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
    $app->run();
