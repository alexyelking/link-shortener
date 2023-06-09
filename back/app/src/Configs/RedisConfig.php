<?php

namespace Shortener\Configs;

use Shortener\Models\RedisConnection;

class RedisConfig implements ILoadConfig
{
    private string $host;
    private int $port;
    private int $database;

    public function __construct()
    {
        $this->host = $_ENV['REDIS_HOST'];
        $this->port = $_ENV['REDIS_PORT'];
        $this->database = $_ENV['REDIS_DATABASE'];
    }

    public function loadConfig(): RedisConnection
    {
        return new RedisConnection($this->host, $this->port, $this->database);
    }
}