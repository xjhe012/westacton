<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use app\controllers\PlayerChannel;

    require './vendor/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new PlayerChannel()
            )
        ),
        8083
    );

    $server->run();