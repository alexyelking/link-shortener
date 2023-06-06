<?php

namespace Shortener\Infrastructure;

use mysqli;

class Database
{
    public function connect(): mysqli
    {
        $servername = $_ENV['DB_SERVER'];
        $username = $_ENV['DB_USER_NAME'];
        $password = $_ENV['DB_USER_PASSWORD'];
        $dbname = $_ENV['DB_NAME'];

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}