<?php

namespace Shortener\Models;

class RedisConnection
{
    public string $host;
    public int $database;
    public int $port;

    public function __construct(string $host, int $port, int $database)
    {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
    }
}