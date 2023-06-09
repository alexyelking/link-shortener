<?php

namespace Shortener\Configs;

use Shortener\Models\AMQPConnection;

class AMQPConfig implements ILoadConfig
{
    public string $host;
    public int $port;
    public string $user;
    public string $password;

    public function __construct()
    {
        $this->host = $_ENV['AMQP_HOST'];
        $this->port = $_ENV['AMQP_PORT'];
        $this->user = $_ENV['AMQP_USER'];
        $this->password = $_ENV['AMQP_PASSWORD'];
    }

    public function loadConfig(): AMQPConnection
    {
        return new AMQPConnection($this->host, $this->port, $this->user, $this->password);
    }
}