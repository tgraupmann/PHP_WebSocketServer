# PHP_WebSocketServer

This is a PHP WebSocket Server that uses [Rachet](https://github.com/ratchetphp/Ratchet).

## Usage ##

Install Ratchet.
```
php composer.phar require cboden/ratchet
```

Launch the WebSocket Server.

```
php chat.php
```

Customize the port.

This example uses port 5050.

The port is configured in /vendor/cboden/ratchet/src/Ratchet/App.php and in the sample [chat.php](chat.php) sample.

**App.php**

Configure the server port.

```
public function __construct($httpHost = 'localhost', $port = 5050, $address = '127.0.0.1', LoopInterface $loop = null) {
```

Allow the port.

```
$policy->addAllowedAccess($httpHost, 5050);
```
