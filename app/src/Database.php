<?php

namespace Shortener;

use mysqli;

class Database
{
    public function connect(): mysqli
    {
//        DB_SERVER=db
//        USER_NAME=root
//        USER_PASS=root
//        DB_NAME=shortener_db
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