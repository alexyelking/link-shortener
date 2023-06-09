<?php

namespace Shortener\Infrastructure;

use Shortener\Configs\Config;
use Shortener\Configs\AMQPConfig;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AMQPConnectionReturner
{
    public string $host;
    public int $port;
    public string $user;
    public string $password;

    public function __construct()
    {
        $config = new Config();
        $connection = $config->load(new AMQPConfig());
        $this->host = $connection->host;
        $this->port = $connection->port;
        $this->user = $connection->user;
        $this->password = $connection->password;
    }

    public function connect()
    {
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
        $channel = $connection->channel();
        $channel->queue_declare('short-notification-queue', false, true, false, false);
        return $channel;
    }
}