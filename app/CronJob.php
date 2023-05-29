<?php

namespace Shortener;

require __DIR__ . '/vendor/autoload.php';

class CronJob
{
    public function run()
    {
        $db = new Database();
        $conn = $db->connect();
        $sql = "DELETE FROM links WHERE created_at < DATE_SUB(NOW(), INTERVAL 2 MINUTE)";
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully\n";
        } else {
            echo "Error deleting record: " . $conn->error . "\n";
        }
        $conn->close();
    }
}

$run = new CronJob();
$run->run();