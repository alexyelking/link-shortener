<?php

namespace Shortener\Models;

class DatabaseConnection
{
    public string $host;
    public string $username;
    public string $password;
    public string $name;

    public function __construct(string $host, string $username, string $password, string $name)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
    }
}