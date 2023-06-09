<?php

namespace Shortener\Infrastructure;

use Redis;
use Shortener\Configs\Config;
use Shortener\Configs\RedisConfig;

class RedisConnectionReturner
{
    private string $host;
    private int $port;
    private int $database;

    public function __construct()
    {
        $config = new Config();
        $connection = $config->load(new RedisConfig());
        $this->host = $connection->host;
        $this->port = $connection->port;
        $this->database = $connection->database;
    }

    public function connect(): Redis
    {
        $redis = new Redis();
        $redis->connect($this->host, $this->port);
        $redis->select($this->database);
        return $redis;
    }
}