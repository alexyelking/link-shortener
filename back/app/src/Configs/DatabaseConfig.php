<?php

namespace Shortener\Configs;

use Shortener\Models\DatabaseConnection;

class DatabaseConfig implements ILoadConfig
{
    public string $host;
    public string $username;
    public string $password;
    public string $name;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->name = $_ENV['DB_NAME'];
    }

    public function loadConfig()
    {
        return new DatabaseConnection($this->host, $this->username, $this->password, $this->name);
    }
}