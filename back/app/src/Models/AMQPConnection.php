<?php

namespace Shortener\Models;

class AMQPConnection
{
    public string $host;
    public int $port;
    public string $user;
    public string $password;

    public function __construct(string $host, int $port, string $user, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }
}