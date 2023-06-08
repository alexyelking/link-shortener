<?php

namespace Shortener\Infrastructure;

use mysqli;

class Database
{
    private string $dbname;
    private string $username;
    private string $servername;
    private string $password;

    public function __construct()
    {
        $this->servername = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dbname = $_ENV['DB_NAME'];
    }
    public function connect(): mysqli
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}