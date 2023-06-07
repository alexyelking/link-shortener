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
        $this->servername = $_ENV['DB_SERVER']??'db';
        $this->username = $_ENV['DB_USER_NAME']??'root';
        $this->password = $_ENV['DB_USER_PASSWORD']??'root';
        $this->dbname = $_ENV['DB_NAME']??'shortener_db';
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