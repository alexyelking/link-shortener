<?php

use Shortener\Database;

require __DIR__ . '/vendor/autoload.php';

class CronJob
{
    public function run()
    {
        $db = new Database();
        $conn = $db->connect();
        echo 'HUI';
        $conn->close();
    }
}

$run = new CronJob();
$run->run();

//$hui = new CronJob();
//$hui->run();

//use Shortener\Database;
//$servername = "db";$_ENV['DB_SERVER'];
//$dbname = "shortener_db";$_ENV['DB_NAME'];
//
//$username = "root";$_ENV['USER_NAME'];
//$password = "root";$_ENV['USER_PASS'];
//
//$conn = new mysqli($_ENV['DB_SERVER'], $username, $password, $_ENV['DB_NAME']);
//
//if ($conn->connect_error) {
//    echo "Connection failed: " . $conn->connect_error . "\n";
//}
//else echo "Connection successful\n";


//require_once("src/Database.php");

//use Shortener\Database;


//$connection = new \Shortener\Database();


//$connection->connect();

//$connection->query($sql);

//$sql = "DELETE FROM links WHERE created_at < DATE_SUB(NOW(), INTERVAL 10 MINUTE)";
//
//if ($connection->query($sql) === TRUE) {
//    echo "Record deleted successfully\n";
//} else {
//    echo "Error deleting record: " . $connection->error . "\n";
//}
//
