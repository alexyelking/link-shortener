<?php

namespace Shortener\Infrastructure;

use mysqli;

class Database
{
    public function connect(): mysqli
    {
        $servername = "db";
        $username = "root";
        $password = "root";
        $dbname = "shortener_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}