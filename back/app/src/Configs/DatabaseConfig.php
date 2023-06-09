<?php

namespace Shortener\Configs;

use Shortener\Models\DatabaseConnection;

class DatabaseConfig implements ILoadConfig
{
    private string $host;
    private string $username;
    private string $password;
    private string $name;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->name = $_ENV['DB_NAME'];
    }

    public function loadConfig(): DatabaseConnection
    {
        return new DatabaseConnection($this->host, $this->username, $this->password, $this->name);
    }
}