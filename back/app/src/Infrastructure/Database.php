<?php

namespace Shortener\Infrastructure;

use mysqli;

class Database
{
    private $dbname;
    private $username;
    private $servername;
    private $password;

    public function __construct()
    {
        $this->servername = $_ENV['DB_SERVER'];
        $this->username = $_ENV['DB_USER_NAME'];
        $this->password = $_ENV['DB_USER_PASSWORD'];
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