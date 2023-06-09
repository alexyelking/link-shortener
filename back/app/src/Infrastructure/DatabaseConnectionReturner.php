<?php

namespace Shortener\Infrastructure;

use mysqli;
use Shortener\Configs\Config;
use Shortener\Configs\DatabaseConfig;

class DatabaseConnectionReturner
{
    private string $host;
    private string $username;
    private string $password;
    private string $name;

    public function __construct()
    {
        $config = new Config();
        $connection = $config->load(new DatabaseConfig());
        $this->host = $connection->host;
        $this->username = $connection->username;
        $this->password = $connection->password;
        $this->name = $connection->name;
    }

    public function connect(): mysqli
    {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}