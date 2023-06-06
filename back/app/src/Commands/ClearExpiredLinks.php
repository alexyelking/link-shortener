<?php

namespace Shortener\Commands;

use Shortener\Infrastructure\Database;

class ClearExpiredLinks
{
    public function run()
    {
        $db = new Database();
        $conn = $db->connect();
        $sql = "DELETE FROM links WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)";
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully\n";
        } else {
            echo "Error deleting record: " . $conn->error . "\n";
        }
        $conn->close();
    }
}